<?php

require_once('../config.php');

class db {
    public var $conn;
    
    public function __construct() {
        global $CFG;
        $dsn = 'mysql:dbname=' . $CFG->dbname . ';host=' . $CFG->dbhost;
        try {
            $this->conn = new PDO($dsn, $CFG->dbuser, $CFG->dbpassword);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    
    public function insertBook($title, $authors, $genres, $yearpublished, $publisherid, $isbn) {
        global $DB;
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
        global $DB;
        
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
        global $DB;
        
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
        global $DB;
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
        global $DB;
        
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
        global $DB;
        
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
}