<?php
ini_set('display_errors', 1);
$topic = 'Maths';
helpme($topic);

function helpme($topic) {
    echo "<p>Help topic: $topic.</p>";
}

$message1 = 'This isn\'t my day';

$person = new stdClass();
$person->name = 'Jane';
$person->qualifications = ['A level English', 'GCSE Maths'];
$person->jobtitle = 'English teacher';

$people[] = $person;

$person = new stdClass();
$person->name = 'Rod';
$person->qualifications = ['A level Spanish', 'GCSE English'];
$person->jobtitle = 'Spanish teacher';

$people[] = $person;

foreach ($people as $p) {
    echo "Name: {$p->name}<br />";
    $qualifications = join(", ", $p->qualifications);
    echo "Qualifications: {$qualifications}<br />";
    echo "Job: {$p->jobtitle}<br />";
}

$DB = new PDO('mysql:dbname=DAP406;host=localhost', 'MSharp', 'dap406');
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$sql = "SELECT * FROM `author` WHERE firstname LIKE 'jane'";

$stmt = $DB->query($sql);

$results = $stmt->fetchAll(PDO::FETCH_OBJ);
foreach ($results as $item) {
    foreach ($item as $key => $data) {
        echo "{$key}: {$data}<br />";
    }
}
