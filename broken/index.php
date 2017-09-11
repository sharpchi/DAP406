<?php

$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$int = 123;
$object = new stdClass();
$object->name = "Fred";
$object->value = $string;
$array = array('name' => 'Fred', 'value' => $string);

echo 'Some text plus my $string';
echo "Some text plus my $string";
