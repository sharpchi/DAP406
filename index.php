<?php
require_once('config.php');


include($CFG->dirroot . '/inc/header.php');
?>
    <form method="POST" action="book/search.php">
        <label for="search">Search books</label>
        <input name="search" value="" type="text" placeholder="Search books" />
        <input type="submit" value="Search" name="submit" />
    </form>

<?php
include($CFG->dirroot . '/inc/footer.php');
