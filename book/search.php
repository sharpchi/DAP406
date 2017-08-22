<?php
require_once('../config.php');
$query = '';
$results = [];
if (isset($_POST['submit'])) {
    // validate query
    $query = $_POST['search'];
    $results = $DB->searchBooks($query);
}
include($CFG->dirroot . '/inc/header.php');
?>
<h1>Mark's books</h1>

<form method="post" action="search.php">
    <label for="search">Search books</label>
    <input name="search" value="<?php echo $query; ?>" type="text" placeholder="Search books" />
    <input type="submit" value="Search" name="submit" />
</form>

<?php
include($CFG->dirroot . '/inc/footer.php');
