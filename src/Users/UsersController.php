<?php

namespace Anax\Users;

class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    public function initialize()
    {
        // Kallas automagist
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);

        $this->auth = new \Anax\Authenticate\Authenticate('user');
        $this->auth->setDI($this->di);

        $this->flashy = new \Anax\Flash\CFlash();
    }

    public function listAction()
    {
        $all = $this->users->findAll();
        $this->theme->setTitle('List all users');
        $this->views->add('users/list-all', [
            'users'	=>	$all,
            'title'	=>	'View all users',
        ]);
    }

    public function idAction($id = null)
    {
        $user = $this->users->find($id);
        $this->theme->setTitle('View user with id');
            // Skapa en form
        $form = $this->form;
        $form = $form->create([], [
            'id' => [
                'type' => 'text',
                'label' => 'id',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => function ($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);


         // Kolla om formen är ok
        $status = $form->check();
        if ($status === true) {
            $id = $_SESSION['form-save']['id']['value'];
            session_unset($_SESSION['form-save']['id']['value']);
            $url = $this->url->create('users/id/' . $id);
            $this->response->redirect($url);
        } elseif ($status === false) {

        }

        $this->views->add('users/id', [
                'user' => $user,
                'title' => 'View user',
                'content' => $form->getHTML(),

        ]);

    }

    public function addAction($acronym = null)
    {
        $this->theme->setTitle("Add user");

        if (!isset($acronym)) {
            $form = $this->form;
            $form = $form->create([], [
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Username or ID:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => function ($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

            $status = $form->check();

            if ($status === true) {
                $acronym = $_SESSION['form-save']['acronym']['value'];
                $url = $this->url->create('users/add/' . $acronym);
                session_unset($_SESSION['form-save']);
                $this->response->redirect($url);

            }
            $this->views->add('me/page', [
                'content' => $form->getHTML(),
            ]);

        } else {
            $now = date("Y-m-d h:i:s");

            $this->users->save([
                'acronym' => $acronym,
                'email' => $acronym . '@mail.se',
                'name' => 'Mr/Mrs ' . $acronym,
                'password' => password_hash($acronym, PASSWORD_DEFAULT),
                'created' => $now,
                'active' => $now,
            ]);

            $url = $this->url->create('users/id/' . $this->users->id);
            $this->response->redirect($url);
        }
    }

    public function deleteAction ($id = null)
    {

        if (!isset($id)) {
            die('Missing id');
        }

        $res = $this->users->delete($id);

        $url = $this->url->create('users/list');
        $this->response->redirect($url);
    }

    public function softDeleteAction($id = null)
    {
        if (!isset($id)) {
            die('Missing id');
        }

        $now = date("Y-m-d h:i:s");

        $user = $this->users->find($id);

        $user->deleted = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }

    public function activeAction()
    {
        $all = $this->users->query()
        ->where('active IS NOT NULL')
        ->andWhere('deleted is NULL')
        ->execute();

        $this->theme->setTitle('Users that are active');
        $this->views->add('users/list-all', [
            'users' => $all,
            'title'	=> 'Users that are active',
        ]);
    }

    public function inactiveAction()
    {
        $all = $this->users->query()
        ->where('active IS NULL')
        ->execute();

        $this->theme->setTitle('Inactive users');
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => 'Inaktiva användare',
        ]);
    }

    public function updateAction($id = null)
    {
        $this->theme->setTitle('Update user');
        if (!isset($id)) {
            die('Missing id..');
        }
        $user = $this->users->find($id);

        $form = $this->form;
        $form = $form->create([], [
            'acronym' => [
                'type' => 'text',
                'label' => 'Acronym',
                'required' => true,
                'validation' => ['not_empty'],
                'value' => $user->acronym,
            ],
            'email' => [
                'type' => 'text',
                'label' => 'Email',
                'required' => true,
                'validation' => ['not_empty'],
                'value' => $user->email,
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Name',
                'required' => true,
                'validation' => ['not_empty'],
                'value' => $user->name,
            ],

            'submit' => [
                'type' => 'submit',
                'callback' => function ($form) {
                    // Spara till databas
                    $this->users->save([
                       'acronym' => $form->Value('acronym'),
                       'email' => $form->Value('email'),
                       'name' => $form->Value('name'),
                    ]);

                    return true;
                }
            ],

        ]);

        $status = $form->check();
        if ($status == true) {
            $url = $this->url->create('users/list');
            $this->response->redirect($url);
        }

        $this->views->add('users/update', [
            'user' => $user,
            'title' => "Edit user",
            'content' => $form->getHTML(),
        ]);
    }

    public function saveAction()
    {

        $isPosted = $this->request->getPost('doSave');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $id = $this->request->getPost('id');
        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');

        $user = $this->users->find($id);

        $now = date("Y-m-d h:i:s");

        $user->email = $email;
        $user->name = $name;
        $user->updated = $now;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }

    public function softUndoAction($id)
    {
        if (!isset($id)) {
            die('Missing id');
        }

        $now = date("Y-m-d h:i:s");

        $user = $this->users->find($id);

        $user->deleted = null;
        $user->save();

        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }


    // SOFT DELETE kollar om aktiv är null..
    public function softDeletedAction()
    {
        $this->theme->setTitle('Papperskorgen');

        $all = $this->users->query()
        ->where('deleted IS NOT NULL')
        ->execute();

        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => 'Softdeleted users',
        ]);
    }

    // SÄTTER OM EN ANVÄNDARE ÄR AKTIV ELLER EJ.
    public function statusAction($id)
    {
        $user = $this->users->find($id);
        if(!isset($id)) {
            die('Id är inte satt');
        }
        $now = date('Y-m-d h:i:s');

        if(isset($user->active)) {
            // Då ska den bli inaktiv
            $user->active = null;
        } else {
            $user->active = $now;
        }

        $user->save();

        $url = $this->url->create('users/id/' . $user->id);
        $this->response->redirect($url);
    }

    /**
     * Login
     * @return [type] [description]
     */
    public function loginAction()
    {
        $this->theme->setTitle('Login');
        // Kolla om man redan är inloggad.
        if ($this->auth->isAuthenticated()) {
            //$this->response->redirect($this->url->create(''));
            $this->flashy->notice('Already logged in!');
        }

        // Skapa form

        $this->form->create([],
            [
                'username' => [
                    'type' => 'text',
                    'name' => 'username',
                    'label' => 'Username',
                    'required' => true,
                    'validation' => ['not_empty'],
                ],

                'password' => [
                    'type' => 'password',
                    'name' => 'password',
                    'label' => 'Password',
                    'required' => true,
                    'validation' => ['not_empty'],
                ],

                'submit' => [
                    'type' => 'submit',
                    'value' => 'Login',
                    'callback' => function($form) {
                        $this->form->saveInSession = true;
                        return true;
                    }
                ]
            ]);

        $status = $this->form->check();
        if ($status === true) {
            // Login

            // Save shit.
            $acronym = $_SESSION['form-save']['username']['value'];
            $password = $_SESSION['form-save']['password']['value'];
            $this->session->noSet('form-save');


            if($this->auth->authenticate($acronym, $password)) {
                $name = $this->session->get('user')->username;
                $this->flashy->success("Välkommen {$name}");
            } else {
                echo 'NOPE';
            }
        }
        $flash = $this->flashy->get();

        $this->views->add('me/page', [
            'title' => 'Login',
            'content' => $this->form->getHTML(),
        ])->addString($flash, 'flash');

    }

    public function logoutAction()
    {
        $this->theme->setTitle('Logout');
        if ($this->auth->isAuthenticated()) {
            $user = $this->session->get('user');
            $this->auth->logout();
            $this->flashy->success("Welcome back {$user->username}");
        } else {
            $this->flashy->error('Please login before logout u noob');
        }

        $this->views->addString($this->flashy->get(), 'flash');
    }

    public function profileAction($acronym)
    {
        $this->theme->setTitle("$acronym's profile");
        echo $acronym;
    }














}
