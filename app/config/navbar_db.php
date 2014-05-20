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
            'text'  => '<i class="fa fa-arrow-left"></i> Back',
            'url'   => '../',
            'title' => 'Back'
        ],

        // This is a menu item
        'list' => [
            'text'  =>'List',
            'url'   =>'users/list',
            'title' => 'List'
        ],

        // This is a menu item
        'active' => [
            'text'  =>'Active',
            'url'   =>'users/active',
            'title' => 'Active'
        ],

        // This is a menu item
        'inactive' => [
            'text'  =>'Inactive',
            'url'   =>'users/inactive',
            'title' => 'Inactive'
        ],

        // This is a menu item
        'id' => [
            'text'  =>'View',
            'url'   =>'users/id',
            'title' => 'View'
        ],

        'soft-deleted' => [
            'text'  => 'Soft-deleted',
            'url'   => 'users/soft-deleted',
            'title' => 'Soft-deleted',
        ],

        // This is a menu item
        'add' => [
            'text'  =>'Add',
            'url'   =>'users/add',
            'title' => 'Add'
        ],

        // This is a menu item
        'setup' => [
            'text'  =>'Setup',
            'url'   =>'setup',
            'title' => 'Setup'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];