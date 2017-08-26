<?php
require_once('config.php');
$pagetitle = 'Mark\'s Books';

include($CFG->dirroot . '/inc/header.php');
?>
    <form method="POST" action="book/search.php">
        <div class="input-group">
            <input name="search" value="" type="text" placeholder="Search books" class="form-control" />
            <input type="submit" value="Search" name="submit" />
        </div>
    </form>

<?php
include($CFG->dirroot . '/inc/footer.php');
