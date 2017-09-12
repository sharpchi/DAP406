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

<h2>Boolean</h2>
<p>True or False, 1 or 0.</p>
<p>Very often a function will return false if either there are no results to return (such as in a database query that didn't match anything), or if there was an error.</p>
<?php
$bool1 = true;
$bool2 = false;
$bool3 = 1;
$bool4 = 0;
$bool5 = 'Some random value';
?>
<pre><code>
    $bool1 = true;
    $bool2 = false;
    $bool3 = 1;
    $bool4 = 0;
    $bool5 = 'Some random value';
</code></pre>
<p>Using conditional `if` statement you can detect if a value is true or false.</p>
<pre><code>
    if ($bool1 == true) {
        echo 'true';
    }
</code></pre>
<?php
if ($bool1 == true) {
    echo 'true';
}
?>
<pre><code>
    if ($bool2 == false) {
        echo 'True, it\'s false.';
    }
</code></pre>
<?php
if ($bool2 == false) {
    echo 'True, it\'s false.';
}
?>
<p>But, notice that also:
    <pre><code>
        if ($bool1 == 1) {
            echo 'true';
        }
    </code></pre>
    <?php
    if ($bool1 == true) {
        echo 'true';
    }
    ?>
    <pre><code>
        if ($bool2 == 0) {
            echo 'True, it\'s false.';
        }
    </code></pre>
    <?php
    if ($bool2 == false) {
        echo 'True, it\'s false.';
    }
    ?>
<p>Also:</p>
<pre><code>
    if ($bool5 == true) {
        echo "A value has been set.";
    }
</code></pre>
<?php
if ($bool5 == true) {
    echo "A value has been set.";
}
?>
<p>So you can see that if you want to know if you are dealing with an actual bool, doing a simple == is not enough. You need to use ===. This basically says: The value <em>and</em> type are the same.</p>
<pre><code>
    if ($bool1 === true) {
        echo 'This is True';
    } else {
        echo "This is something else.";
    }
</code></pre>
<?php
if ($bool1 === true) {
    echo 'This is True';
} else {
    echo "This is something else.";
}
?>
<pre><code>
    if ($bool2 === false) {
        echo "This is false";
    }

</code></pre>
<?php
if ($bool2 === false) {
    echo "This is false";
}
?>
<pre><code>
    if ($bool3 === true) {
        echo 'This is True';
    } else {
        echo "This is something else";
    }

</code></pre>
<?php
if ($bool3 === true) {
    echo 'This is True';
} else {
    echo "This is something else";
}
?>
<pre><code>
    if ($bool3 === 1) {
        echo "This is 1";
    }
</code></pre>
<?php
if ($bool3 === 1) {
    echo "This is 1";
}
?>
<pre><code>
    if ($bool5 === true) {
        echo "This is true";
    } else {
        echo "This is something else.";
    }
</code></pre>
<?php
if ($bool5 === true) {
    echo "This is true";
} else {
    echo "This is something else.";
}
?>
<h2>Arrays</h2>
<p>Arrays allow you to create a collection of values together and organise them either by an index number (usually starting at zero), or by name.</p>
<p>The collection of values don't have to be of the same type.</p>
<p>You can declare an array in two ways:</p>
<pre><code>
$array1 = array();
$array2 = [];
</code></pre>
<p>Both have created empty arrays. You can populate your arrays by assigning an index (or key) then giving it a value.</p>
<pre><code>
    $array1[0] = "Some value";
    $array1[1] = 1;
    $array1[2] = true;
    $array1[3] = ['rod', 'jane', 'freddy'];
    $array2['name'] = "Joe Bloggs";
    $array2['age'] = 29;
    $array2['ishuman'] = true;
    $array2['rainbow'] = ['rod', 'jane', 'freddy'];
</code></pre>
<pre>
<?php
$array1 = array();
$array2 = [];
$array1[0] = "Some value";
$array1[1] = 30;
$array1[2] = true;
$array1[3] = ['rod', 'jane', 'freddy']; // Multi-dimension array.
$array2['name'] = "Joe Bloggs";
$array2['age'] = 29;
$array2['ishuman'] = true;
$array2['rainbow'] = ['rod', 'jane', 'freddy'];
print_r($array1);
print_r($array2);
?>
</pre>
<p>You can count how many items are in an array, but using `count()`</p>
<pre><code>echo count($array1);</code></pre>
<?php
echo count($array1);
 ?>
<h2>Object</h2>
<p>In some ways, an object is a little bit like an array - it has keys and values of arbitrary information. But it is more usually used to express the occurance of a particular thing.</p>
<p>We won't go into much detail here except to know how to create an empty object, and get values from it.</p>
<pre><code>
$rainbow = [];
$person = new stdClass();
$person->name = "Freddy Bloggs";
$person->age = 29;
$person->gender = 'Male';
$person->friends = ['rod', 'jane'];
$rainbow[] = $person;

$person = new stdClass();
$person->name = "Rod Rogers";
$person->age = 31;
$person->gender = 'Male';
$person->friends = ['freddy', 'jane'];
$rainbow[] = $person;

$person = new stdClass();
$person->name = "Jane Jenkins";
$person->age = 28;
$person->gender = 'Female';
$person->friends = ['rod', 'freddy'];
$rainbow[] = $person;

print_r($rainbow);
</code></pre>
<?php
$rainbow = [];
$person = new stdClass();
$person->name = "Freddy Bloggs";
$person->age = 29;
$person->gender = 'Male';
$person->friends = ['rod', 'jane'];
$rainbow[] = $person;

$person = new stdClass();
$person->name = "Rod Rogers";
$person->age = 31;
$person->gender = 'Male';
$person->friends = ['freddy', 'jane'];
$rainbow[] = $person;

$person = new stdClass();
$person->name = "Jane Jenkins";
$person->age = 28;
$person->gender = 'Female';
$person->friends = ['rod', 'freddy'];
$rainbow[] = $person;
?>
<pre>
<?php
print_r($rainbow);
?>
</pre>
<p>Objects can also contain functions, and this you will see when you start using PDO. Accessing the functions, is just the same as accessing a variable, except you pass in zero or more arguments. <code>$hasfriends = $person->hasFriends('Jane Jenkins');</code> would return true or false where the function might be something like:</p>
<pre><code>
    function hasFriends($person) {
        foreach ($this->rainbow as $member) {
            if ($member->name == $person) {
                return (count($member->friends) > 0);
            }
        }
        return false;
    }
</code></pre>
