<?php

require_once('../config.php');
$authors = [];
if ($_GET['id']) {
    $author = $DB->getAuthor($_GET['id']);
}
if (!$author) {
    // book doesn't exist
    $pagetitle = 'No author with this ID was found.';
} else {
    $pagetitle = $author->fullname;
}

include($CFG->dirroot . '/inc/header.php');

if (!$author) {
    ?>
    <div class="alert alert-danger">Error: No author with this ID was found. <a href="search.php">Please search again</a>.</div>
    <?php
} else {
    ?>
    <h2><?php echo $author->fullname; ?></h2>
    <table class="table table-striped table-bordered">

        <tr>
            <th>Email</th>
            <td><?php echo $author->email; ?></td>
        </tr>
        <tr>
            <th>Website</th>
            <td><a href="<?php echo $author->www; ?>"><?php echo $author->www; ?></a></td>
        </tr>
        <tr>
            <th>Twitter</th>
            <td>
                <?php $twitterurl = 'https://twitter.com/' . str_replace('@', '', $author->twitter); ?>
            <a href="<?php echo $twitterurl; ?>"><?php echo $author->twitter; ?></a></td>
        </tr>
    </table>
    <a href="edit.php?id=<?php echo $author->id; ?>" class="btn btn-primary" title="Edit author">Edit</a>
    <a href="delete.php?id=<?php echo $author->id; ?>" class="btn btn-danger" title="Delete author">Delete</a>

    <?php
}

include($CFG->dirroot . '/inc/footer.php');
