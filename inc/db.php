<?php

class db {
    private $conn;
    private $tables = array();

    public function __construct() {
        global $CFG, $DEBUG;
        $dsn = 'mysql:dbname=' . $CFG->dbname . ';host=' . $CFG->dbhost;
        try {
            $this->conn = new PDO($dsn, $CFG->dbuser, $CFG->dbpassword);
            if ($DEBUG) {
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            }
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        $this->tables = [
            'book', 'publisher', 'author'
        ];
    }

    public function insertBook($book) {

        $sql = "INSERT into `book` (`title`,`yearpublished`,`isbn`,`publisherid`) VALUES (:title, :yearpublished, :isbn, :publisherid)";
        $stmt = $this->conn->prepare($sql);
        //print_r($stmt);
        $stmt->bindValue(':title', $book['title'], PDO::PARAM_STR);
        $stmt->bindValue(':yearpublished', $book['yearpublished'], PDO::PARAM_INT);
        $stmt->bindValue(':isbn', $book['isbn'], PDO::PARAM_STR);
        $stmt->bindValue(':publisherid', $book['publisherid'], PDO::PARAM_INT);

        $stmt->execute();
        $book->id = $this->conn->lastInsertId();
        if (isset($book->authors)) {
            foreach ($book->authors as $author) {
                // if not has authorid, create new author, and store authorid
                // add bookid and authorid to book_authors table
            }
        }

        return $book->id;
    }

    private function addBookAuthor($bookid, $authorid) {
        // must be unique
    }

    /**
     * Delete book
     * @param int $id BookID
     * @return bool True/False book deleted
     */
    public function deleteBook($id) {
        $sql = "DELETE FROM `book` WHERE `id`=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function insertPublisher($publisher) {
        // unqiue keys: id, name
        if ($this->recordExists('publisher', ['name' => $publisher->name])) {
            return false;
        }

        $sql = "INSERT INTO `publisher`
            (`name`, `address1`, `address2`, `town`, `county`, `country`, `postcode`, `phone`, `www`, `twitter`)
            VALUES
            (:name, :address1, :address2, :town, :county, :country, :postcode, :phone, :www, :twitter)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $publisher->name, PDO::PARAM_STR);
        $stmt->bindValue(':address1', $publisher->address1, PDO::PARAM_STR);
        $stmt->bindValue(':address2', $publisher->address2, PDO::PARAM_STR);
        $stmt->bindValue(':town', $publisher->town, PDO::PARAM_STR);
        $stmt->bindValue(':county', $publisher->county, PDO::PARAM_STR);
        $stmt->bindValue(':country', $publisher->country, PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $publisher->postcode, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $publisher->phone, PDO::PARAM_STR);
        $stmt->bindValue(':www', $publisher->www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $publisher->twitter, PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();

    }

    /**
     * Delete book
     * @param int $id PublisherID
     * @return bool True/False publisher deleted
     */
    public function deletePublisher($id) {
        $sql = "DELETE FROM `publisher` WHERE `id`=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Insert Author
     * @param object $author Author object
     * @return int authorID
     */
    public function insertAuthor($author) {
        // unqiue keys: id, name
        if ($this->recordExists('author', ['firstname' => $author->firstname, 'lastname' => $author->lastname])) {
            return false;
        }

        $sql = "INSERT INTO `author`
            (`firstname`, `lastname`, `email`, `www`, `twitter`)
            VALUES
            (:firstname, :lastname, :email, :www, :twitter)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':firstname', $author->firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $author->lastname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $author->email, PDO::PARAM_STR);
        $stmt->bindValue(':www', $author->www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $author->twitter, PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();

    }

    /**
     * Updates an author's details.
     * @param object $author Author details
     * @return book True/False updated.
     */
    public function updateAuthor($author) {

        $sql = "UPDATE `author` SET
            `firstname`=:firstname, `lastname`=:lastname, `email`=:email, `www`=:www, `twitter`=:twitter WHERE `id`=:id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':firstname', $author->firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $author->lastname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $author->email, PDO::PARAM_STR);
        $stmt->bindValue(':www', $author->www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $author->twitter, PDO::PARAM_STR);
        $stmt->bindValue(':id', $author->id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    /**
     * Searches for an author by their fullname (firstname, lastname)
     * @param string $query
     * @return array List of authors
     */
    public function searchAuthors($query) {
        $sql = "SELECT a.*, CONCAT(a.firstname, ' ', a.lastname) AS fullname FROM `author` AS a
        WHERE CONCAT(`firstname`, ' ', `lastname`) LIKE :name";
        $query = '%' . $query . '%';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Gets details for a single author.
     * @param int $id AuthorID
     * @return object Author (false if no result)
     */
    public function getAuthor($id) {
        $sql = "SELECT *, CONCAT(`firstname`, ' ', `lastname`) AS `fullname` FROM `author` WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Updates an existing book
     * @param array $book An array of book parameters
     */
    public function updateBook($book) {
        $sql = "UPDATE `book` SET `title`=:title,`yearpublished`=:yearpublished,`isbn`=:isbn,`publisherid`=:publisherid WHERE `id`=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':title', $book->title, PDO::PARAM_STR);
        $stmt->bindValue(':yearpublished', $book->yearpublished, PDO::PARAM_INT);
        $stmt->bindValue(':isbn', $book->isbn, PDO::PARAM_STR);
        $stmt->bindValue(':publisherid', $book->publisherid, PDO::PARAM_INT);
        $stmt->bindValue(':id', $book->id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    public function searchPublishers($query) {
        $sql = "SELECT * FROM `publisher`
        WHERE `name` LIKE :name";
        $query = '%' . $query . '%';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Update a publisher
     * @param object $publisher Publisher details as an object.
     * @return bool Updated True/False
     */
    public function updatePublisher($publisher) {

        $sql = "UPDATE `publisher` SET
            `name`=:name, `address1`=:address1, `address2`=:address2, `town`=:town, `county`=:county, `country`=:country, `postcode`=:postcode, `phone`=:phone, `www`=:www, `twitter`=:twitter WHERE `id`=:id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $publisher->name, PDO::PARAM_STR);
        $stmt->bindValue(':address1', $publisher->address1, PDO::PARAM_STR);
        $stmt->bindValue(':address2', $publisher->address2, PDO::PARAM_STR);
        $stmt->bindValue(':town', $publisher->town, PDO::PARAM_STR);
        $stmt->bindValue(':county', $publisher->county, PDO::PARAM_STR);
        $stmt->bindValue(':country', $publisher->country, PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $publisher->postcode, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $publisher->phone, PDO::PARAM_STR);
        $stmt->bindValue(':www', $publisher->www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $publisher->twitter, PDO::PARAM_STR);
        $stmt->bindValue(':id', $publisher->id, PDO::PARAM_INT);

        return $stmt->execute();


    }

    public function searchBooks($query) {
        $sql = "SELECT `book`.*, `publisher`.`name` AS `publishername` FROM `book`
        JOIN `publisher` ON `publisher`.`id` = `book`.`publisherid`
        WHERE `title` LIKE :title";
        $query = '%' . $query . '%';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':title', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getBook($bookid) {
        $sql = "SELECT `book`.*, `publisher`.`name` AS `publishername`, `publisher`.`id` AS `publisherid` FROM `book`
        JOIN `publisher` ON `publisher`.`id` = `book`.`publisherid`
        WHERE `book`.`id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', (int)$bookid, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Gets full list of all publishers available.
     * @return array List of publishers (objects)
     */
    public function getPublishers() {
        $sql = "SELECT * FROM `publisher`";
        $results = $this->conn->query($sql);
        return $results->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Gets details for a single publisher.
     * @param int $id PublisherID
     * @return object Publisher (false if no result)
     */
    public function getPublisher($id) {
        $sql = "SELECT * FROM `publisher` WHERE `id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Checks to see if a record exists
     * @param string $table Table name
     * @param array $conditions field/value pairs
     * @return bool True/False
     */
    public function recordExists($table, $conditions) {
        // Need to check this is a valid table.
        if (!in_array($table, $this->tables)) {
            return false;
        }
        $params = [];
        foreach ($conditions as $field => $value) {
            $params[] = "`{$field}`=:{$field}";
        }
        $params = join(' AND ', $params);
        $sql = "SELECT * FROM {$table} WHERE {$params}";
        $stmt = $this->conn->prepare($sql);

        foreach ($conditions as $field => $value) {
            $stmt->bindValue(":{$field}", $value);
        }
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function getErrors() {
        return $this->conn->errorinfo();
    }
}
