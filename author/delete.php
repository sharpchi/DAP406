<?php

require_once('../config.php');
$publisher = new stdClass();
$deleted = false;
if ($_GET['id']) {
    $publisher = $DB->getPublisher($_GET['id']);
}
if (!$publisher) {
    // publisher doesn't exist
    $pagetitle = 'No publisher with this ID was found.';
} else {
    $pagetitle = $publisher->name;
    $deleted = $DB->deletePublisher($_GET['id']);
}

include($CFG->dirroot . '/inc/header.php');

if (!$publisher) {
    ?>
    <div class="alert alert-danger">Error: No publisher with this ID was found. <a href="search.php">Please search again</a>.</div>
    <?php
}
if ($publisher) {
    ?>
    <h2><?php echo $publisher->name; ?></h2>
    <?php
    if (!$deleted) {
        ?>
        <div class="alert alert-danger">Error: Unable to delete the selected publisher. <a href="search.php">Please search again</a>.</div>
        <?php
    } else {
        ?>
        <div class="alert alert-success">The selected publisher has been deleted.</div>
        <?php
    }
}

include($CFG->dirroot . '/inc/footer.php');
