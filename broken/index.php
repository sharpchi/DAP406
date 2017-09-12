<?php

helpme($topic);

function he1pme($topic) {
    echo "<p>Help topic: $topic.</p>"
}

$message1 = 'This isn't my day';

$person = stdClass();
$person->name = 'Jane';
$person->qualifications = ['A level English'; 'GCSE Maths'];

$people[] = $person;

$person = stdClass();
$person->name = 'Rod';
$person->qualifications = ['A level Spanish'; 'GCSE English'];

$people[] = $person;

for each ($p as People) {
    echo 'Name: {$p->name}<br />';
    echo 'Qualifications: {$p->qualifications}<br />';
    echo 'Job: {$p->jobtitle}<br />';
}

// Clue: search php PDO
$DB = new PDO('mysql:dbname=MSharp;host=localhost', 'MSharp', '123456789');
// Clue: search PDO setAttribute
$sql = "SELECT a.* FROM 'author' WHERE fistname LIKE 'jan'";

$stmt = $DB->query($sql);

$results = $stmt->fetchAll();
foreach ($results as $item) {
    foreach ($item as $key -> $data) {
        echo "{$key}: {$data}<br />";
    }
}
