<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
<<<<<<< HEAD

=======
 
>>>>>>> upstream/master
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
<<<<<<< HEAD
            'text'  => '<i class="fa fa-home"></i> Home',
            'url'   => '',
            'title' => 'Home'
        ],


        'questions' => [
            'text'  => '<i class="fa fa-question-circle"></i> Questions',
            'url'   => 'questions',
            'title' => 'Questions',
        ],

        'tags' => [
            'text' => '<i class="fa fa-tag"></i> Tags',
            'url' => 'tags',
            'title' => 'Tags',
        ],

        'users' => [
            'text'  => '<i class="fa fa-user"></i> Användare',
            'url'   => 'users',
            'title' => 'Användare',
        ],

        // This is a menu item
        'about' => [
            'text'  =>'<i class="fa fa-star"></i> About',
            'url'   =>'about',
            'title' => 'About'
        ],
    ],

    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
=======
            'text'  => 'Home',   
            'url'   => 'index.php',  
            'title' => 'Some title 1'
        ],
 
        // This is a menu item
        'test'  => [
            'text'  => 'Test with submenu',   
            'url'   => 'test.php',   
            'title' => 'Some title 2',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 1'  => [
                        'text'  => 'Item 1',   
                        'url'   => 'item1.php',  
                        'title' => 'Some item 1'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => 'Item 2',   
                        'url'   => 'item2.php',  
                        'title' => 'Some item 2'
                    ],
                ],
            ],
        ],
 
        // This is a menu item
        'about' => [
            'text'  =>'About', 
            'url'   =>'about.php',  
            'title' => 'Some title 3'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
>>>>>>> upstream/master
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
<<<<<<< HEAD
    'create_url' => function ($url) {
=======
    'create_url' => function($url) {
>>>>>>> upstream/master
        return $this->di->get('url')->create($url);
    },
];
