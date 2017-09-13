<?php
ini_set('display_errors', 1);
ini_set('error_logs', 1);

$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$int = 123;
$object = new stdClass();
$object->name = "Fred";
$object->value = $string;
$array = array('name' => 'Fred', 'value' => $string);

echo $string . "<br />";
echo $int . "<br />";
print_r($object);
echo "<br />";
echo "<pre>" . print_r($array, true) . '</pre>';
echo "<br />";

echo $object->thing . "<br />";
echo $array['thing'] . "<br />";

try {
    myFunction($string, $object);
} catch (Error $e) {
    echo "<pre>" . print_r($e, true) . '</pre>';
    echo "<br />";
}

function myFunction($thing, $that) {
    echo "$thing<br />";
    echo "$that<br />";
}
