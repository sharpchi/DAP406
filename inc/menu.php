<?php
$menu = [
    'home' => [
        'url' => '/index.php',
        'label' => 'Home'
    ],
    'book' => [
        'url' => '/book/',
        'label' => 'Books',
        'children' => [
            'search' => [
                'url' => '/book/search.php',
                'label' => 'Books'
            ],
            'edit' => [
                'url' => '/book/edit.php',
                'label' => 'New book'
            ]
        ]
    ],
    'publisher' => [
        'url' => '/publisher/',
        'label' => 'Publishers',
        'children' => [
            'search' => [
                'url' => '/publisher/search.php',
                'label' => 'Publishers'
            ],
            'edit' => [
                'url' => '/publisher/edit.php',
                'label' => 'New publisher'
            ]
        ]
    ],
    'author' => [
        'url' => '/author/',
        'label' => 'Authors',
        'children' => [
            'search' => [
                'url' => '/author/search.php',
                'label' => 'Authors'
            ],
            'edit' => [
                'url' => '/author/edit.php',
                'label' => 'New author'
            ]
        ]
    ],
    // 'genre' => [
    //     'url' => '/genre/',
    //     'label' => 'Genres'
    // ]
];

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $CFG->www; ?>">Mark's Books</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <?php
        //echo $page;
        foreach ($menu as $key => $item) {
            $dropdown = isset($item['children']) ? ' dropdown' : '';
            $active = ($item['url'] == $page) ? ' active' : '';
            echo '<li class="nav-item' . $active . $dropdown . '">';

            if ($dropdown) {
                echo '<a class="nav-link dropdown-toggle" href="' . $CFG->www . $item['url'] . '" data-toggle="dropdown">' .
                    $item['label'] . '</a>';
                echo '<div class="dropdown-menu">';
                foreach ($item['children'] as $child) {
                    echo '<a class="dropdown-item" href="' . $CFG->www . $child['url'] . '">' . $child['label'] . '</a>';
                }
                echo '</div>';
            } else {
                echo '<a class="nav-link" href="' . $CFG->www . $item['url'] . '">' .
                    $item['label'] . '</a>';
            }
            echo '</li>';
        }
        ?>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="POST" action="<?php echo $CFG->www; ?>/book/search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Search books" aria-label="Search books">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
