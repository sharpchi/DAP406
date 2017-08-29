<?php

require_once('../config.php');
$books = [];
if ($_GET['id']) {
    $book = $DB->getBook($_GET['id']);
}
if (!$book) {
    // book doesn't exist
    $pagetitle = 'No book with this ID was found.';
} else {
    $pagetitle = $book->title;
}

include($CFG->dirroot . '/inc/header.php');

if (!$book) {
    ?>
    <div class="alert alert-danger">Error: No book with this ID was found. <a href="search.php">Please search again</a>.</div>
    <?php
} else {
    ?>
    <h2><?php echo $book->title; ?></h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Year published</th>
            <td><?php echo $book->yearpublished; ?></td>
        </tr>
        <tr>
            <th>Publisher</th>
            <td><a href="../publisher/view.php?id=<?php echo $book->publisherid; ?>" title="<?php echo $book->publishername; ?>"><?php echo $book->publishername; ?></a></td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td><?php echo $book->isbn; ?></td>
        </tr>
        <tr>
            <th>Authors</th>
            <td><?php
                $authors = [];
                foreach ($book->authors as $author) {
                    $authors[] = '<a href="' . $CFG->www . '/author/view.php?id=' . $author->id . '">' . $author->fullname . '</a>';
                }
                echo join(', ', $authors);
            ?>
            </td>
        </tr>
    </table>
    <a href="edit.php?id=<?php echo $book->id; ?>" class="btn btn-primary" title="Edit book">Edit</a>
    <a href="delete.php?id=<?php echo $book->id; ?>" class="btn btn-danger" title="Delete book">Delete</a>

    <?php
}

include($CFG->dirroot . '/inc/footer.php');
