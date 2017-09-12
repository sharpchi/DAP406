<?php
ini_set('display_errors', 1);

$DB = new PDO('mysql:dbname=DAP406;host=localhost', 'MSharp', 'dap406');
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$sql = "SELECT * FROM `author` WHERE firstname LIKE '%jane%'";

$stmt = $DB->query($sql);

$results = $stmt->fetchAll(PDO::FETCH_OBJ);
foreach ($results as $item) {
    foreach ($item as $key => $data) {
        echo "{$key}: {$data}<br />";
    }
}

$firstname = '%jan%';
$lastname = '%sea%';
$sql = "SELECT * FROM `author` WHERE `firstname` LIKE :firstname";

$stmt = $DB->prepare($sql);
$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_OBJ);
echo '<pre>';
print_r($results);
echo '</pre>';

$sql = "SELECT * FROM `author` WHERE `firstname` LIKE :firstname AND `lastname` LIKE :lastname";

$stmt = $DB->prepare($sql);
$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_OBJ);
echo '<pre>';
print_r($results);
echo '</pre>';

$sql = "INSERT INTO `book` (`title`, `yearpublished`, `isbn`, `publisherid`) VALUES (:title, :yearpublished, :isbn, :publisherid)";
$title = 'This is my book';
$yearpublished = 2006;
$isbn = 1234455;
$publisherid = 11;
$stmt = $DB->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':yearpublished', $yearpublished, PDO::PARAM_STR);
$stmt->bindValue(':isbn', $isbn, PDO::PARAM_INT);
$stmt->bindValue(':publisherid', $publisherid, PDO::PARAM_INT);

$stmt->execute();
$bookid = $DB->lastInsertId();

$sql = "SELECT * FROM book WHERE id=:id";
$stmt = $DB->prepare($sql);
$stmt->bindValue(':id', $bookid, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);
echo '<pre>';
print_r($results);
echo '</pre>';

$sql = "UPDATE book SET `title`=:title WHERE `id`=:id";
$newtitle = "This is my new book title";
$stmt = $DB->prepare($sql);
$stmt->bindValue(':id', $bookid, PDO::PARAM_INT);
$stmt->bindValue(':title', $newtitle, PDO::PARAM_STR);


echo '<pre>';
echo 'Executed status ' . $stmt->execute();
echo '</pre>';
