<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    'class' => 'navbar',

    'items' => [

        'home'  => [
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
            'text'  => '<i class="fa fa-user"></i> Users',
            'url'   => 'users',
            'title' => 'Users',
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
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
];
