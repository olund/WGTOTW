<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',

    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => '<i class="fa fa-home"></i> Home',
            'url'   => '',
            'title' => 'Home'
        ],


        'questions' => [
            'text'  => '<i class="fa fa-picture-o"></i> Questions',
            'url'   => 'questions',
            'title' => 'Questions',
        ],

        'tags' => [
            'text' => '<i class="fa fa-flash"></i> Tags',
            'url' => 'tags',
            'title' => 'Tags',
        ],

        'users' => [
            'text'  => '<i class="fa fa-user"></i> Användare',
            'url'   => 'users.php',
            'title' => 'Användare',
        ],

        // This is a menu item
        'about' => [
            'text'  =>'<i class="fa fa-wrench"></i> About',
            'url'   =>'about',
            'title' => 'About'
        ],
    ],

    // Callback tracing the current selected menu item base on scriptname
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
];
