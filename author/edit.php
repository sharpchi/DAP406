<?php
/**
 * Requires the author ID
 * Search for the author, and get its details
 * The details are used to prepopulate the form for editing.
 * If the author doesn't edit, throw an error. Point them to search.
 * If the form is being submitted, then the author details need to be updated.
 * Validate the author details before sending the form.
 * How do we mange the author info? Create a drop-down of possible authors - requires a authorid
 */
require_once('../config.php');

$query = '';
$errors = false;
$errormessages = [];

$updated = false;
$inserted = false;
$formsubmitted = isset($_POST['save']);
$newauthor = !$formsubmitted && !isset($_GET['id']);

$author = new stdClass();

if (isset($_GET['id'])) {
    $author = $DB->getAuthor($_GET['id']);
    if (!$author) {
        $errors = true;
        $errormessages['id'] = 'This author id is not recognised.';
    }

} else if ($formsubmitted) {
    // Validate the form
    $author->id = isset($_POST['id']) ? $_POST['id'] : 0;

    $author->firstname = trim($_POST['firstname']);
    if (strlen($author->firstname) < 3) {
        $errors = true;
        $errormessages['firstname'] = 'Too short a name';
    }

    $author->lastname = trim($_POST['lastname']);
    if (strlen($author->lastname) < 2) {
        $errors = true;
        $errormessages['lastname'] = 'Too short a name';
    }

    $author->fullname = join(' ', [$author->firstname, $author->lastname]);

    $author->email = trim($_POST['email']);
    if (!empty($author->email) && !filter_var($author->email, FILTER_VALIDATE_EMAIL)) {
        $errors = true;
        $errormessages['email'] = 'Invalid email address';
    }

    $author->www = trim($_POST['www']);
    if ($author->www == 'http://') {
        $author->www = '';
    }
    if (!empty($author->www) && strpos($author->www, 'http') !== 0) {
        $author->www = 'http://' . $author->www;
    }
    if (!empty($author->www) && !filter_var($author->www, FILTER_VALIDATE_URL)) {
        $errors = true;
        $errormessages['www'] = 'Invalid URL';
    }

    $author->twitter = trim($_POST['twitter']);
    if (!empty($author->twitter) && (preg_match('/^@[a-z0-9_]{1,15}$/i', $author->twitter) !== 1)) {
        $errors = true;
        $errormessages['twitter'] = 'Invalid twitter handle.';
    }

    if (!$errors) {
        // print_r($author);
        if ($author->id == 0) {
            $inserted = $DB->insertAuthor($author);
            if ($inserted) {
                $author->id = $inserted;
            } else {
                $errors = true;
                $errormessages['insert'] = 'Unable to insert the author, it may already exist.';
                // print_r($DB->getErrors());
            }
        } else {
            // Update author
            $updated = $DB->updateAuthor($author);

            if (!$updated) {
                $errors = true;
                $errormessages['update'] = 'Unable to save the author.';
                // print_r($DB->getErrors());
            }
        }
    }

}
if (!isset($author->id)) {
    // There is no author details to display or edit. This is a new author
    // Set up default details.
    $author = new stdClass();
    $author->id = 0;
    $author->firstname = '';
    $author->lastname = '';
    $author->fullname = '';
    $author->email = '';
    $author->www = '';
    $author->twitter = '';
    $pagetitle = 'New author';
} else {
    $pagetitle = 'Editing ' . $author->fullname;
}

include($CFG->dirroot . '/inc/header.php');

if ($errors) {
    echo '<div class="alert alert-danger">Errors have been found.</div>';
}
if (($errors && (!$updated && !$inserted )) && $formsubmitted) {
    if ($author->id > 0) {
        echo '<div class="alert alert-danger">' . $errormessages['update'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">' . $errormessages['insert'] . '</div>';
    }
}
if ($updated && $formsubmitted) {
    echo '<div class="alert alert-success">Author has been updated.</div>';
}
?>

<form method="POST" action="edit.php">
    <!-- authorid - disabled -->
    <div class="form-group">
        <label for="id">ID</label>
        <input type="text" name="id" title="Author ID" value="<?php echo $author->id; ?>" class="form-control" readonly="readonly" />
        <?php
            if (isset($errormessages['id'])) {
                echo '<div class="alert alert-danger">' . $errormessages['id'] . '</div>';
            }
        ?>
    </div>
    <!-- firstname -->
    <div class="form-group">
        <label for="firstname">Author firstname</label>
        <input type="text" name="firstname" title="Author firstname" value="<?php echo $author->firstname; ?>" required class="form-control" />
        <?php
            if (isset($errormessages['firname'])) {
                echo '<div class="alert alert-danger">' . $errormessages['firstname'] . '</div>';
            }
        ?>
    </div>

    <!-- lastname -->
    <div class="form-group">
        <label for="lastname">Author lastname</label>
        <input type="text" name="lastname" title="Author lastname" value="<?php echo $author->lastname; ?>" required class="form-control" />
        <?php
            if (isset($errormessages['lastname'])) {
                echo '<div class="alert alert-danger">' . $errormessages['lastname'] . '</div>';
            }
        ?>
    </div>

    <!-- www -->
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" title="Email" value="<?php echo $author->email; ?>" class="form-control" />
        <?php
            if (isset($errormessages['email'])) {
                echo '<div class="alert alert-danger">' . $errormessages['email'] . '</div>';
            }
        ?>
    </div>

    <!-- www -->
    <div class="form-group">
        <label for="www">Website</label>
        <input type="url" name="www" title="Website" value="<?php echo $author->www; ?>" class="form-control" />
        <?php
            if (isset($errormessages['www'])) {
                echo '<div class="alert alert-danger">' . $errormessages['www'] . '</div>';
            }
        ?>
    </div>

    <!-- twitter -->
    <div class="form-group">
        <label for="twitter">Twitter</label>
        <input type="text" name="twitter" title="Twitter" value="<?php echo $author->twitter; ?>" class="form-control" placeholder="@handle" />
        <?php
            if (isset($errormessages['twitter'])) {
                echo '<div class="alert alert-danger">' . $errormessages['twitter'] . '</div>';
            }
        ?>
    </div>

    <!-- submit - button -->
    <input type="submit" name="save" value="Save" class="btn btn-success" />
</form>

<?php
include($CFG->dirroot . '/inc/footer.php');
