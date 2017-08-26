<?php
$menu = [
    'home' => [
        'url' => '/index.php',
        'label' => 'Home'
    ],
    'book' => [
        'url' => '/book/',
        'label' => 'Books'
    ],
    'publisher' => [
        'url' => '/publisher/',
        'label' => 'Publishers'
    ],
    'author' => [
        'url' => '/author/',
        'label' => 'Authors'
    ],
    'genre' => [
        'url' => '/genre/',
        'label' => 'Genres'
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $CFG->www; ?>/styles.css" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $pagetitle; ?></title>
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="container" id="main">
