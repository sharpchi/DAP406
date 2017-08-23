<?php
/**
 * Requires the book ID
 * Search for the book, and get its details
 * The details are used to prepopulate the form for editing.
 * If the book doesn't edit, throw an error. Point them to search.
 * If the form is being submitted, then the book details need to be updated.
 * Validate the book details before sending the form.
 * How do we mange the publisher info? Create a drop-down of possible publishers - requires a publisherid
 */
require_once('../config.php');
$query = '';
$book = new stdClass();
if (isset($_GET['id'])) {
    $books = $DB->getBook($_GET['id']);
    if (count($books) == 1) {
        $book = $books[0];
    }
} else if (isset($_POST['edit']) && isset($_POST['id'])) {
    // This is editting the book details
    // Validate the form
}
if (!isset($book->id)) {
    // There is no book details to display or edit. The is a new book
    // Set up default details.
    $book->id = 0;
    $book->title = '';
    $book->yearpublished = date('Y');
    $book->isbn = 0;
    $book->publisherid = '';
}
$pagetitle = 'Editing book';
include($CFG->dirroot . '/inc/header.php');
?>

<form method="post" action="edit.php">
    <!-- bookid - disabled -->
    <div class="form-group">
        <label for="id">ID</label>
        <input type="text" name="id" title="Book ID" value="<?php echo $book->id; ?>" disabled="disabled" class="form-control" />
    </div>
    <!-- title -->
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" title="Book title" value="<?php echo $book->title; ?>" required class="form-control" />
    </div>
    <!-- yearpublished -->
    <div class="form-group">
        <label for="yearpublished">Year published</label>
        <input type="number" name="yearpublished" title="Year published" value="<?php echo $book->yearpublished; ?>" required class="form-control" min="1800" max="<?php echo date('Y'); ?>" />
    </div>
    <!-- isbn -->
    <div class="form-group">
        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" title="ISBN" value="<?php echo $book->isbn; ?>" required class="form-control" />
    </div>
    <!-- publisher - select -->
    <div class="form-group">
        <label for="publisherid">Publisher</label>
        <select name="publisherid" required>
            <option value="">Select publisher</option>
            <?php
            $publishers = $DB->getPublishers();
            foreach($publishers as $publisher) {
                if ($book->publisherid == $publisher->id) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                echo '<option value="' . $publisher->id . '"' . $selected . '>' . $publisher->name . '</option>';
            }
            ?>
        </select>
    </div>
    <!-- submit - button -->
    <div class="input-group">

        <input name="search" class="form-control" value="<?php echo $query; ?>" type="text" placeholder="Search books" />
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
        echo '<li><a href="view.php?id=' . $result->id   . '">' . $result->title . '</a></li>';
    }
    ?>
    </ul>
    <?php
}

include($CFG->dirroot . '/inc/footer.php');
