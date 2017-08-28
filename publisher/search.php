<?php
require_once('../config.php');
$query = '';
$results = [];
if (isset($_POST['submit'])) {
    // validate query
    $query = $_POST['search'];
    $results = $DB->searchPublishers($query);
}
$pagetitle = 'Search publishers';
include($CFG->dirroot . '/inc/header.php');
?>

<form method="post" action="search.php">
    <div class="input-group">
        <input name="search" class="form-control" value="<?php echo $query; ?>" type="text" placeholder="Search publishers" />
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default" name="submit">Search</button>
        </span>
    </div>
</form>

<?php

if (count($results) > 0) {
    ?>
    <h2>Results</h2>
    <ul>
    <?php
    foreach ($results as $result) {
        echo '<li><a href="view.php?id=' . $result->id   . '">' . $result->name . '</a></li>';
    }
    ?>
    </ul>
    <?php
}

include($CFG->dirroot . '/inc/footer.php');
