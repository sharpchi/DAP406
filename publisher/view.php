<?php

require_once('../config.php');
$publishers = [];
if ($_GET['id']) {
    $publisher = $DB->getPublisher($_GET['id']);
}
if (!$publisher) {
    // book doesn't exist
    $pagetitle = 'No publisher with this ID was found.';
} else {
    $pagetitle = $publisher->name;
}

include($CFG->dirroot . '/inc/header.php');

if (!$publisher) {
    ?>
    <div class="alert alert-danger">Error: No publisher with this ID was found. <a href="search.php">Please search again</a>.</div>
    <?php
} else {
    ?>
    <h2><?php echo $publisher->name; ?></h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Address</th>
            <td>
            <?php
            echo $publisher->address1 . '<br />';
            if (!empty($publisher->address2)) {
                echo $publisher->address2 . '<br />';
            }
            if (!empty($publisher->town)) {
                echo $publisher->town . '<br />';
            }
            if (!empty($publisher->county)) {
                echo $publisher->county . '<br />';
            }
            if (!empty($publisher->country)) {
                echo $publisher->country . '<br />';
            }
            if (!empty($publisher->postcode)) {
                echo $publisher->postcode . '<br />';
            }
            ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo $publisher->phone; ?></td>
        </tr>
        <tr>
            <th>Website</th>
            <td><a href="<?php echo $publisher->www; ?>"><?php echo $publisher->www; ?></a></td>
        </tr>
        <tr>
            <th>Twitter</th>
            <td>
                <?php $twitterurl = 'https://twitter.com/' . str_replace('@', '', $publisher->twitter); ?>
            <a href="<?php echo $twitterurl; ?>"><?php echo $publisher->twitter; ?></a></td>
        </tr>
    </table>
    <a href="edit.php?id=<?php echo $publisher->id; ?>" class="btn btn-primary" title="Edit publisher">Edit</a>
    <a href="delete.php?id=<?php echo $publisher->id; ?>" class="btn btn-danger" title="Delete publisher">Delete</a>

    <?php
}

include($CFG->dirroot . '/inc/footer.php');
