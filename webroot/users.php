<?php

require __DIR__.'/config_with_app.php';

$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_db.php');
//$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('form', '\Mos\HTMLForm\CForm');
$app->session;


$app->router->add('', function () use ($app) {
    $app->theme->setTitle('Users');
    $app->views->add('me/page', [
        'content' => 'User db'
    ]);
});


$app->router->add('setup', function () use ($app) {
    $app->theme->setTitle('Setup db');
    $app->db->setVerbose(false);

    // Drop table if exist
    $app->db->dropTableIfExists('user')->execute();

    // Create a user table
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();


    // Add 2 users
    $app->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );

    // Get the date?
    $now = date("Y-m-d h:i:s");


    // Execute the query
    $app->db->execute([
        'admin',
        'admin@test.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);

    $app->db->execute([
        'olund',
        'olund@me.se',
        'Henrik Ölund',
        password_hash('olund', PASSWORD_DEFAULT),
        $now,
        $now
    ]);

    $url = $app->url->create('users/list');
    $app->response->redirect($url);

});

$app->router->handle();
$app->theme->render();
