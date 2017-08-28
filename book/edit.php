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
$errors = false;
$errormessages = [];

$updated = false;
$inserted = false;
$formsubmitted = isset($_POST['save']);
$newbook = !$formsubmitted && !isset($_GET['id']);

$book = new stdClass();

if (isset($_GET['id'])) {
    $book = $DB->getBook($_GET['id']);
    if (!$book) {
        $errors = true;
        $errormessages['id'] = 'This book id is not recognised.';
    }

} else if ($formsubmitted) {
    // Validate the form
    $book->id = isset($_POST['id']) ? $_POST['id'] : 0;

    $book->title = $_POST['title'];
    if (strlen($book->title) < 3) {
        $errors = true;
        $errormessages['title'] = 'Too short a title';
    }

    $book->yearpublished = $_POST['yearpublished'];
    if (!is_int((int)$book->yearpublished) || $book->yearpublished < 1800 || $book->yearpublished > date('Y')) {
        $errors = true;
        $errormessages['yearpublished'] = 'Invalid published date';
    }

    // ISBN after 2007 is 13 digits long, before 2007 10 digits
    $book->isbn = trim($_POST['isbn']);
    if (preg_match('/^[0-9]{10,13}$/', $book->isbn) !== 1) {
        $errors = true;
        $errormessages['isbn'] = 'ISBNs are numbers only.';
    }

    if ($book->yearpublished < 2007 && strlen($book->isbn) != 10) {
        $errors = true;
        $errormessages['isbn'] = 'Before 2007, ISBNs should be 10 digits long.';
    } else if ($book->yearpublished >= 2007 && strlen($book->isbn) != 13) {
        $errors = true;
        $errormessages['isbn'] = 'From 2007, ISBNs should be 13 digits long.';
    }

    // Publisherid has to be a valud publisherid
    $book->publisherid = trim($_POST['publisherid']);
    if (!is_int((int)$book->publisherid)) {
        $errors = true;
        $errormessages['publisherid'] = 'This publisher is not valid.';
    } else {
        if (!$DB->getPublisher($book->publisherid)) {
            $errors = true;
            $errormessages['publisherid'] = 'This publisher is not valid.';
        }
    }

    if (!$errors) {
        //print_r($book);
        if ($book->id == 0) {
            $inserted = $DB->insertBook($book);
            if ($inserted) {
                $book->id = $inserted;
            } else {
                $errors = true;
                $errormessages['insert'] = 'Unable to save the book.';
            }
        } else {
            // Update book
            $updated = $DB->updateBook($book);

            if (!$updated) {
                $errors = true;
                $errormessages['update'] = 'Unable to save the book.';
            }
        }
    }

}
if (!isset($book->id)) {
    // There is no book details to display or edit. This is a new book
    // Set up default details.
    $book = new stdClass();
    $book->id = 0;
    $book->title = '';
    $book->yearpublished = date('Y');
    $book->isbn = 0;
    $book->publisherid = '';
    $pagetitle = 'New book';
} else {
    $pagetitle = 'Editing ' . $book->title;
}

include($CFG->dirroot . '/inc/header.php');

if ($errors) {
    echo '<div class="alert alert-danger">Errors have been found.</div>';
}
if (($errors && (!$updated && !$inserted )) && $formsubmitted) {
    echo '<div class="alert alert-danger">Unable to update book.</div>';
}
if ($updated && $formsubmitted) {
    echo '<div class="alert alert-success">Book has been updated.</div>';
}
?>

<form method="POST" action="edit.php">
    <!-- bookid - disabled -->
    <div class="form-group">
        <label for="id">ID</label>
        <input type="text" name="id" title="Book ID" value="<?php echo $book->id; ?>" class="form-control" readonly="readonly" />
        <?php
            if (isset($errormessages['id'])) {
                echo '<div class="alert alert-danger">' . $errormessages['id'] . '</div>';
            }
        ?>
    </div>
    <!-- title -->
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" title="Book title" value="<?php echo $book->title; ?>" required class="form-control" />
        <?php
            if (isset($errormessages['title'])) {
                echo '<div class="alert alert-danger">' . $errormessages['title'] . '</div>';
            }
        ?>
    </div>
    <!-- yearpublished -->
    <div class="form-group">
        <label for="yearpublished">Year published</label>
        <input type="number" name="yearpublished" title="Year published" value="<?php echo $book->yearpublished; ?>" required class="form-control" min="1800" max="<?php echo date('Y'); ?>" />
        <?php
            if (isset($errormessages['yearpublished'])) {
                echo '<div class="alert alert-danger">' . $errormessages['yearpublished'] . '</div>';
            }
        ?>
    </div>
    <!-- isbn -->
    <div class="form-group">
        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" title="ISBN" value="<?php echo $book->isbn; ?>" required class="form-control" />
        <?php
            if (isset($errormessages['isbn'])) {
                echo '<div class="alert alert-danger">' . $errormessages['isbn'] . '</div>';
            }
        ?>
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
        <?php
            if (isset($errormessages['publisherid'])) {
                echo '<div class="alert alert-danger">' . $errormessages['publisherid'] . '</div>';
            }
        ?>
    </div>
    <!-- submit - button -->
    <input type="submit" name="save" value="Save" class="btn btn-success" />
</form>

<?php
include($CFG->dirroot . '/inc/footer.php');
