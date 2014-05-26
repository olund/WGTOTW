<?php

require __DIR__.'/config_with_app.php';

// Start session.
$app->withSession();

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$di->set('form', '\Mos\HTMLForm\CForm');
$di->set('time', '\Anax\Time\CTime');

$di->setShared('db', function () {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});

// Set flash.
$di->setShared('flashy', function () {
    $flashy = new \Anax\Flash\CFlash();
    return $flashy;
});

// Använd nyskapad Comment och commentcontroller...
$di->set('CommentsController', function () use ($di) {
    $controller = new \Anax\Comments\CommentsController();
    $controller->setDI($di);
    return $controller;
});

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('QuestionsController', function () use ($di) {
    $controller = new \Anax\Questions\QuestionsController();
    $controller->setDI($di);
    return $controller;
});

$di->setShared('auth', function() use ($di) {
    $module = new \Anax\Authenticate\Authenticate('user');
    $module->setDI($di);
    return $module;
});

$di->setShared('TagsController', function () use ($di) {
    $controller = new \Anax\Tag\TagsController();
    $controller->setDI($di);
    return $controller;
});

$app->views->addString($app->flashy->get(), 'flash');

// Home route
$app->router->add('', function () use ($app) {
    $app->theme->setTitle('Linux Questions');
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->dispatcher->forward([
        'controller' => 'questions',
        'action' => 'sidebar',
    ]);

    $app->views->add('me/page', [
        'content' => $content,
    ], 'main');
});

// Redovisning route
$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ], 'main');

    // Comments
    $app->dispatcher->forward([
        'controller' => 'comments',
        'action'     => 'view',
    ]);
});


$app->router->add('about', function () use ($app) {
    $app->theme->setTitle('About');
    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
    ], 'main');

});

$app->router->add('source', function () use ($app) {
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle('Source');

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir'   => '..',
        'add_ignore' => ['.htaccess'],
    ]);
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});


$app->router->handle();
$app->theme->render();
