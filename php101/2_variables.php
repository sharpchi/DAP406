<h1>Variables</h1>
<p>The main characteristic of PHP variables is that they are not "strongly typed". That is to say, something that starts out as a number, can just as easily become a string or an array without any checks.</p>

<p>This can quickly lead to confusion because you won't get any error messages telling you about the change until you try to do something that requires a particular type to work, such as calculation on a string.</p>
<h2>Strings</h2>
<?php

// string
$string1 = "This is a string";
echo '<p>' . $string1 . "</p>";

$string2 = 'This is a string';
echo '<p>' . $string2 . "</p>";

$string3 = 'Strings can joined together. (' . $string1 . ' ' . $string2 . ') using a ".".';
echo '<p>' . $string3 . "</p>";

$string4 = "Strings with double quotes can interpret \\n \nas a new line.";
echo '<p>' . $string4 . "</p>";

$string5 = "Strings with double quotes can have ($string1) strings inside them.";
echo '<p>' . $string5 . "</p>";

$string6 = 'Strings with single quotes cannot interpret \n';
echo '<p>' . $string6 . "</p>";

$string7 = '\'But when you use single quotes to wrap your text you must escape any internal single quotes using a backslash "\\".\'';
echo '<p>' . $string7 . "</p>";
?>

<h2>Integers</h2>
<p>Integers are whole numbers: 1,2,3,4,5</p>
<?php
$int1 = 1;
$int2 = $int1 + 1;
$int3 = $int2 * $int2;
$int4 = $int3 / 3;
?>
<p>You can assign a value to a variable: <?php echo $int1; ?></p>
<p>You can add a variable that is a number to a number: <?php echo $int2; ?></p>
<p>You can multiply variables that are numbers together: <?php echo $int3; ?></p>
<p>But you can't add a string to a number: <?php echo $int1 + $string1; ?></p>
<p>If you want to check if something is an integer, you can use the function <code>is_int($int1);</code>: <?php echo is_int($int1); ?> <a href="http://php.net/manual/en/function.is-int.php">http://php.net/manual/en/function.is-int.php</a></p>
<p>If you divide an integer and the result isn't a whole number: <?php echo $int4; ?>. PHP will show you the decimal answer. So if being a whole number is important, use <code>is_int();</code>
<h2>Decimal</h2>
<?php

// decimal - float

// Boolean

// array

// object

// Comparing

echo '</pre>';
