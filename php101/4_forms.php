<h1>Forms</h1>
<p>A webpage can receive data from another page by a couple of methods: 1. the url 2: as form data. Both these methods produce an array, you access as with any other named array.</p>
<h2>$_GET</h2>
<p>When you see a url like: <code>http://localhost/DAP406/php101/4_forms.php?query=fred&page=1</code>, the variables query and page are processed using the $_GET array.</p>
<p><a href="4_forms.php?query=fred&page=1">Click on this link.</a></p>
<?php
if (isset($_GET)) {
    ?>
<pre></code>
if (isset($_GET)) {
    echo "Query ({$_GET['query']}) Page({$_GET['page']})&lt;br />";
}
</code></pre>
    <?php
    echo "Query ({$_GET['query']}) Page({$_GET['page']})<br />";
}
?>
<h2>$_POST</h2>
<p>Usually, data sent from a form use the POST method (you can use GET, but POST is more usual)</p>
<pre><code>
    &lt;form name="testform" method="POST" action="4_forms.php">
        &lt;label for="query">Query:&lt;/label> &lt;input type="text" name="query" value="Fred" />&lt;br />
        &lt;label for="page">Page:&lt;/label> &lt;input type="number" name="page" value=1 />&lt;/br />
        &lt;input type="submit" value="Submit" />
    &lt;/form>
</code></pre>
<p>Submit this form</p>
<form name="testform" method="POST" action="4_forms.php">
    <label for="query">Query:</label> <input type="text" name="query" value="Fred" /><br />
    <label for="page">Page:</label> <input type="number" name="page" value=1 /></br />
    <input type="submit" value="Submit" />
</form>
<?php
if (isset($_POST)) {
    ?>
<pre></code>
if (isset($_POST)) {
    echo "Query ({$_POST['query']}) Page({$_POST['page']})&lt;br />";
}
</code></pre>
    <?php
    echo "Query ({$_POST['query']}) Page({$_POST['page']})<br />";
}
?>
