<?php

class db {
    private $conn;

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
    }

    public function insertBook($title, $authors, $genres, $yearpublished, $publisherid, $isbn) {
        $sql = "INSERT into `book` (`title`,`yearpublished`,`isbn`,`publisher`) VALUES (:title, :yearpublished, :isbn, :publisher)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':yearpublished', $yearpublished, PDO::PARAM_INT);
        $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindValue(':publisherid', $publisherid, PDO::PARAM_INT);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function insertPublisher($name, $address1, $address2, $town, $county, $country, $postcode, $phone, $www, $twitter) {
        $sql = "INSERT INTO `publisher`
            (`name`, `address1`, `address2`, `town`, `county`, `country`, `postcode`, `phone`, `www`, `twitter`)
            VALUES
            (:name, :address1, :address2, :town, :county, :country, :postcode, :phone, :www, :twitter)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
        $stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
        $stmt->bindValue(':town', $town, PDO::PARAM_STR);
        $stmt->bindValue(':county', $county, PDO::PARAM_STR);
        $stmt->bindValue(':country', $country, PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':www', $www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $twitter, PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();

    }

    public function insertAuthor($firstname, $lastname, $www, $twitter) {

        $sql = "INSERT INTO `author`
            (`firstname`, `lastname`, `www`, `twitter`)
            VALUES
            (:firstname, :lastname, :www, :twitter)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindValue(':www', $www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $twitter, PDO::PARAM_STR);

        $stmt->execute();

        return $this->conn->lastInsertId();

    }

    public function updateBook($id, $title, $authors, $genres, $yearpublished, $publisherid, $isbn) {
        $sql = "UPDATE `book` SET (`title`=:title,`yearpublished`=:yearpublished,`isbn`=:isbn,`publisher`=:publisher) WHERE `id`=:id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':yearpublished', $yearpublished, PDO::PARAM_INT);
        $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
        $stmt->bindValue(':publisherid', $publisherid, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

    }

    public function updatePublisher($id, $name, $address1, $address2, $town, $county, $country, $postcode, $phone, $www, $twitter) {

        $sql = "UPDATE `publisher` SET
            (`name`=:name, `address1`=:address1, `address2`:=address2, `town`=:town, `county`=:county, `country`=:country, `postcode`=:postcode, `phone`=:phone, `www`=:www, `twitter`=:twitter)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
        $stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
        $stmt->bindValue(':town', $town, PDO::PARAM_STR);
        $stmt->bindValue(':county', $county, PDO::PARAM_STR);
        $stmt->bindValue(':country', $country, PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindValue(':www', $www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $twitter, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();


    }

    public function updateAuthor($id, $firstname, $lastname, $www, $twitter) {

        $sql = "UPDATE `author` SET
            (`firstname`=:firstname, `lastname`=:lastname, `www`=:www, `twitter`=:twitter)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindValue(':www', $www, PDO::PARAM_STR);
        $stmt->bindValue(':twitter', $twitter, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

    }

    public function searchBooks($query) {
        $sql = "SELECT `book`.*, `publisher`.`name` AS `publishername` FROM `book`
        JOIN `publisher` ON `publisher`.`id` = `book`.`publisher_id`
        WHERE `title` LIKE :title";
        $query = '%' . $query . '%';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':title', $query, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getBook($bookid) {
        $sql = "SELECT `book`.*, `publisher`.`name` AS `publishername`, `publisher`.`id` AS `publisherid` FROM `book`
        JOIN `publisher` ON `publisher`.`id` = `book`.`publisher_id`
        WHERE `book`.`id` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', (int)$bookid, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
