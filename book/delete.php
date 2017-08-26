<?php

require_once('../config.php');
$book = new stdClass();
$deleted = false;
if ($_GET['id']) {
    $book = $DB->getBook($_GET['id']);
}
if (!$book) {
    // book doesn't exist
    $pagetitle = 'No book with this ID was found.';
} else {
    $pagetitle = $book->title;
    $deleted = $DB->deleteBook($_GET['id']);
}

include($CFG->dirroot . '/inc/header.php');

if (!$book) {
    ?>
    <div class="alert alert-danger">Error: No book with this ID was found. <a href="search.php">Please search again</a>.</div>
    <?php
}
if ($book) {
    ?>
    <h2><?php echo $book->title; ?></h2>
    <?php
    if (!$deleted) {
        ?>
        <div class="alert alert-danger">Error: Unable to delete the selected book. <a href="search.php">Please search again</a>.</div>
        <?php
    } else {
        ?>
        <div class="alert alert-success">The selected book has been deleted.</div>
        <?php
    }
}

include($CFG->dirroot . '/inc/footer.php');
