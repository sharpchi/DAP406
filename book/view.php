<?php

require_once('../config.php');
$books = [];
if ($_GET['id']) {
    $books = $DB->getBook($_GET['id']);
}
if (count($books) == 0) {
    // book doesn't exist
    $pagetitle = 'No book with this ID was found. <a href="search.php">Please search again</a>.';
} else {
    $pagetitle = $books[0]->title;
}

include($CFG->dirroot . '/inc/header.php');

if (count($books) == 0) {
    ?>
    <div class="alert alert-danger">Error: No book with this ID was found. <a href="search.php">Please search again</a>.</div>
    <?php
} else {
    ?>
    <h2><?php echo $books[0]->title; ?></h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Year published</th>
            <td><?php echo $books[0]->yearpublished; ?></td>
        </tr>
        <tr>
            <th>Publisher</th>
            <td><a href="../publisher/view.php?id=<?php echo $books[0]->publisherid; ?>" title="<?php echo $books[0]->publishername; ?>"><?php echo $books[0]->publishername; ?></a></td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td><?php echo $books[0]->isbn; ?></td>
        </tr>
    </table>
    <a href="edit.php?id=<?php echo $books[0]->id; ?>" class="btn btn-primary" title="Edit book">Edit</a>
    <a href="delete.php?id=<?php echo $books[0]->id; ?>" class="btn btn-danger" title="Delete book">Delete</a>

    <?php
}

include($CFG->dirroot . '/inc/footer.php');
