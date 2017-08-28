<?php
/**
 * Requires the publisher ID
 * Search for the publisher, and get its details
 * The details are used to prepopulate the form for editing.
 * If the publisher doesn't edit, throw an error. Point them to search.
 * If the form is being submitted, then the publisher details need to be updated.
 * Validate the publisher details before sending the form.
 * How do we mange the publisher info? Create a drop-down of possible publishers - requires a publisherid
 */
require_once('../config.php');
require_once($CFG->dirroot . '/inc/countries.php');

$query = '';
$errors = false;
$errormessages = [];

$updated = false;
$inserted = false;
$formsubmitted = isset($_POST['save']);
$newpublisher = !$formsubmitted && !isset($_GET['id']);

$publisher = new stdClass();

if (isset($_GET['id'])) {
    $publisher = $DB->getPublisher($_GET['id']);
    if (!$publisher) {
        $errors = true;
        $errormessages['id'] = 'This publisher id is not recognised.';
    }

} else if ($formsubmitted) {
    // Validate the form
    $publisher->id = isset($_POST['id']) ? $_POST['id'] : 0;

    $publisher->name = trim($_POST['name']);
    if (strlen($publisher->name) < 3) {
        $errors = true;
        $errormessages['name'] = 'Too short a name';
    }

    $publisher->address1 = trim($_POST['address1']);
    if (strlen($publisher->address1) < 3) {
        $errors = true;
        $errormessages['address1'] = 'Invalid address';
    }

    $publisher->address2 = trim($_POST['address2']);
    if (!empty($publisher->address2) && strlen($publisher->address2) < 3) {
        $errors = true;
        $errormessages['address2'] = 'Invalid address';
    }

    $publisher->town = trim($_POST['town']);
    if (!empty($publisher->town) && strlen($publisher->town) < 3) {
        $errors = true;
        $errormessages['town'] = 'Invalid town';
    }

    $publisher->county = trim($_POST['county']);
    if (!empty($publisher->county) && strlen($publisher->county) < 3) {
        $errors = true;
        $errormessages['county'] = 'Invalid county';
    }

    $publisher->country = trim($_POST['country']);
    if (!isset($countries[$publisher->country])) {
        $errors = true;
        $errormessages['county'] = 'Invalid country';
    }

    $publisher->postcode = trim(strtoupper($_POST['postcode']));
    if (strlen($publisher->postcode) < 6) {
        $errors = true;
        $errormessages['postcode'] = 'Invalid postcode';
    }

    $publisher->phone = trim($_POST['phone']);
    if (!empty($publisher->phone) && (preg_match('/^[0-9 \-\+\(\)]{10,}$/', $publisher->phone) !== 1)) {
        $errors = true;
        $errormessages['phone'] = 'Phone numbers can contain numbers, -, +, (), or spaces';
    }

    $publisher->www = trim($_POST['www']);
    if ($publisher->www == 'http://') {
        $publisher->www = '';
    }
    if (!empty($publisher->www) && strpos($publisher->www, 'http') !== 0) {
        $publisher->www = 'http://' . $publisher->www;
    }
    if (!empty($publisher->www) && !filter_var($publisher->www, FILTER_VALIDATE_URL)) {
        $errors = true;
        $errormessages['www'] = 'Invalid URL';
    }

    $publisher->twitter = trim($_POST['twitter']);
    if (!empty($publisher->twitter) && (preg_match('/^@[a-z0-9_]{1,15}$/i', $publisher->twitter) !== 1)) {
        $errors = true;
        $errormessages['twitter'] = 'Invalid twitter handle.';
    }

    if (!$errors) {
        // print_r($publisher);
        if ($publisher->id == 0) {
            $inserted = $DB->insertPublisher($publisher);
            if ($inserted) {
                $publisher->id = $inserted;
            } else {
                $errors = true;
                $errormessages['insert'] = 'Unable to insert the publisher, it may already exist.';
                // print_r($DB->getErrors());
            }
        } else {
            // Update publisher
            $updated = $DB->updatePublisher($publisher);

            if (!$updated) {
                $errors = true;
                $errormessages['update'] = 'Unable to save the publisher.';
                // print_r($DB->getErrors());
            }
        }
    }

}
if (!isset($publisher->id)) {
    // There is no publisher details to display or edit. This is a new publisher
    // Set up default details.
    $publisher = new stdClass();
    $publisher->id = 0;
    $publisher->name = '';
    $publisher->address1 = '';
    $publisher->address2 = '';
    $publisher->town = '';
    $publisher->county = '';
    $publisher->country = 'GB';
    $publisher->postcode = '';
    $publisher->phone = '';
    $publisher->www = '';
    $publisher->twitter = '';
    $pagetitle = 'New publisher';
} else {
    $pagetitle = 'Editing ' . $publisher->name;
}

include($CFG->dirroot . '/inc/header.php');

if ($errors) {
    echo '<div class="alert alert-danger">Errors have been found.</div>';
}
if (($errors && (!$updated && !$inserted )) && $formsubmitted) {
    if ($publisher->id > 0) {
        echo '<div class="alert alert-danger">' . $errormessages['update'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">' . $errormessages['insert'] . '</div>';
    }
}
if ($updated && $formsubmitted) {
    echo '<div class="alert alert-success">Publisher has been updated.</div>';
}
?>

<form method="POST" action="edit.php">
    <!-- publisherid - disabled -->
    <div class="form-group">
        <label for="id">ID</label>
        <input type="text" name="id" title="Publisher ID" value="<?php echo $publisher->id; ?>" class="form-control" readonly="readonly" />
        <?php
            if (isset($errormessages['id'])) {
                echo '<div class="alert alert-danger">' . $errormessages['id'] . '</div>';
            }
        ?>
    </div>
    <!-- name -->
    <div class="form-group">
        <label for="name">Publisher name</label>
        <input type="text" name="name" title="Publisher name" value="<?php echo $publisher->name; ?>" required class="form-control" />
        <?php
            if (isset($errormessages['name'])) {
                echo '<div class="alert alert-danger">' . $errormessages['name'] . '</div>';
            }
        ?>
    </div>

    <!-- address1 -->
    <div class="form-group">
        <label for="address1">Address 1</label>
        <input type="text" name="address1" title="Address 1" value="<?php echo $publisher->address1; ?>" required class="form-control" />
        <?php
            if (isset($errormessages['address1'])) {
                echo '<div class="alert alert-danger">' . $errormessages['address1'] . '</div>';
            }
        ?>
    </div>

    <!-- address2 -->
    <div class="form-group">
        <label for="address2">Address 1</label>
        <input type="text" name="address2" title="Address 2" value="<?php echo $publisher->address2; ?>" class="form-control" />
        <?php
            if (isset($errormessages['address2'])) {
                echo '<div class="alert alert-danger">' . $errormessages['address2'] . '</div>';
            }
        ?>
    </div>

    <!-- town -->
    <div class="form-group">
        <label for="town">Town</label>
        <input type="text" name="town" title="Town" value="<?php echo $publisher->town; ?>" class="form-control" />
        <?php
            if (isset($errormessages['town'])) {
                echo '<div class="alert alert-danger">' . $errormessages['town'] . '</div>';
            }
        ?>
    </div>

    <!-- county -->
    <div class="form-group">
        <label for="county">County</label>
        <input type="text" name="county" title="County" value="<?php echo $publisher->county; ?>" class="form-control" />
        <?php
            if (isset($errormessages['county'])) {
                echo '<div class="alert alert-danger">' . $errormessages['county'] . '</div>';
            }
        ?>
    </div>

    <!-- country -->
    <div class="form-group">
        <label for="country">Country</label>
        <select name="country" required class="form-control">
            <option value="">Select Country</option>
            <?php
            foreach ($countries as $key => $country) {
                $selected = ($publisher->country == $key) ? ' selected="selected"' : '';
                echo '<option value="' . $key . '"' . $selected . '>' . $country . '</option>';
            }
            ?>
        </select>
        <?php
            if (isset($errormessages['country'])) {
                echo '<div class="alert alert-danger">' . $errormessages['country'] . '</div>';
            }
        ?>
    </div>

    <!-- postcode -->
    <div class="form-group">
        <label for="postcode">Postcode</label>
        <input type="text" name="postcode" title="Postcode" value="<?php echo $publisher->postcode; ?>" class="form-control" />
        <?php
            if (isset($errormessages['postcode'])) {
                echo '<div class="alert alert-danger">' . $errormessages['postcode'] . '</div>';
            }
        ?>
    </div>

    <!-- phone -->
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" title="Phone" value="<?php echo $publisher->phone; ?>" class="form-control" />
        <?php
            if (isset($errormessages['phone'])) {
                echo '<div class="alert alert-danger">' . $errormessages['phone'] . '</div>';
            }
        ?>
    </div>

    <!-- www -->
    <div class="form-group">
        <label for="www">Website</label>
        <input type="url" name="www" title="Website" value="<?php echo $publisher->www; ?>" class="form-control" />
        <?php
            if (isset($errormessages['www'])) {
                echo '<div class="alert alert-danger">' . $errormessages['www'] . '</div>';
            }
        ?>
    </div>

    <!-- twitter -->
    <div class="form-group">
        <label for="twitter">Twitter</label>
        <input type="text" name="twitter" title="Twitter" value="<?php echo $publisher->twitter; ?>" class="form-control" placeholder="@handle" />
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
