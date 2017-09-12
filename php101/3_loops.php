<h1>Loops</h1>
<p>When you've got a collection of things in an array, you will want to go through each item in order to do something with the data.</p>
<p>There are a number of ways of looping.</p>
<h2>for</h2>
<p>When you know that your array has a sequential index, starting at zero, this is how you can loop</p>
<pre><code>
    for ($x=0; $x < count($rainbow); $x++) {
        echo 'Name: ' . $rainbow[$x]->name . '&lt;br />';
        echo 'Age: ' . $rainbow[$x]->age . '&lt;br />';
        if (count($rainbow[$x]->friends) > 0) {
            $friends = join(', ', $rainbow[$x]->friends);
            echo "Friends: {$friends}&lt;br />";
        }
    }
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

for ($x=0; $x < count($rainbow); $x++) {
    echo 'Name: ' . $rainbow[$x]->name . '<br />';
    echo 'Age: ' . $rainbow[$x]->age . '<br />';
    if (count($rainbow[$x]->friends) > 0) {
        $friends = join(', ', $rainbow[$x]->friends);
        echo "Friends: {$friends}<br />";
    }
}
?>
<h2>Foreach</h2>
<p>Foreach is particularly useful when an array isn't stored with a sequential index, or it has a named or mixed index. But you can use it for all types of arrays which makes it commonly used.</p>
<p>It can be presented in two way:</p>
<pre><code>
    foreach ($variable as $key => $value) {}
    foreach ($variable as $value) {}
</code></pre>
<p>So you can choose to ignore the $key if you're not interested in it.</p>
<pre><code>
    foreach ($rainbow as $key => $member) {
        echo 'Name: ' . $member->name . '&lt;br />';
        echo 'Age: ' . $member->age . '&lt;br />';
        if (count($member->friends) > 0) {
            $friends = join(', ', $member->friends);
            echo "Friends: {$friends}&lt;br />";
        }
    }
</code></pre>
<?php
foreach ($rainbow as $key => $member) {
    echo 'Name: ' . $member->name . '<br />';
    echo 'Age: ' . $member->age . '<br />';
    if (count($member->friends) > 0) {
        $friends = join(', ', $member->friends);
        echo "Friends: {$friends}<br />";
    }
}
?>
<h2>While</h2>
<p>Finally, while works while something is true. When you use PDO to fetch results, you might ask PDO, <code>while ($record = $results->fetch()) {}</code>.</p>
<p>In other words, while you can still find a result, keep going around.</p>
<p>Personally, I don't tend to use it very much because you need to ensure that you have an escape. That you can guarantee that at some point the condition will return false. Otherwise, you will be stuck in an endless loop.</p>
