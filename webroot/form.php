<?php

require __DIR__.'/config_with_app.php';

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$app->router->add('', function () use ($app) {

    $app->theme->setTitle('Form test');

    // Skapa ett objekt
    $form = new \Mos\HTMLForm\CForm();

    // Skapa elements i formen.

    $form = $form->create([], [
    	'name' => [
    		'type' 		  => 'text',
    		'label'		  => 'Name: ',
    		'required'	  => false,
    		'validation'  => ['not_empty'],
    	],
    	
    	'email' => [
    		'type' => 'text',
    		'label' => 'email',
    		'required' => true,
    		'validation' => ['not_empty', 'email_adress'],
    	],

    	'submit' => [
    		'type' => 'submit',
    		'callback' => function($form) {
    			$form->AddOutput("<p><i>DoSubmit(): Den var submittad</i></p>");
    			$form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
			    $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");

			    // Save in session:
			    $form->saveInSession = true;

			    return true;
    		}
    	],
    ]);

    // render the shit
    echo $form->getHTML();

    $status = $form->check();

    if ($status == true) {
    	$form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
    	header("Location: " . $_SERVER['PHP_SELF']);
    }


});


$app->router->handle();
$app->theme->render();