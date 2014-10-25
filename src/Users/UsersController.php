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

        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDi($this->di);
    }

    public function indexAction()
    {
        $all = $this->users->findAll();
        $this->theme->setTitle('List all users');
        $this->views->add('users/list', [
            'users' =>  $all,
            'title' =>  'All users',
        ]);
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

    public function addAction()
    {
        $this->theme->setTitle("Add user");
        if ($this->auth->isAuthenticated()) {
            $this->flashy->add('warning', 'You are already signed in!');
            $url = $this->url->create('');
            $this->response->redirect($url);
            exit();
        }

        $form = $this->form;
        $form = $form->create([], [
            'name' => [
                'type' => 'text',
                'placeholder' => 'Name...',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'acronym' => [
                'type'        => 'text',
                'placeholder' => 'Username...',
                'required'    => true,
                'validation' => ['not_empty'],
            ],
            'email' => [
                'type'      => 'text',
                'placeholder' => 'Email...',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'password' => [
                'type' => 'password',
                'placeholder' => 'Password...',
                'required' => true,
                'validation' => ['not_empty'],
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
            $name = $_SESSION['form-save']['name']['value'];
            $acronym = $_SESSION['form-save']['acronym']['value'];
            $email = $_SESSION['form-save']['email']['value'];
            $password = $_SESSION['form-save']['password']['value'];
            $this->session->noSet('form-save');
            $now = date("Y-m-d H:i:s");

            $this->users->save([
                'acronym' => htmlentities(strip_tags($acronym)),
                'email' => htmlentities(strip_tags($email)),
                'name' => htmlentities(strip_tags($name)),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created' => $now,
                'active' => $now,
            ]);
            $this->flashy->success("Your account was successfully registered!");
            $this->auth->authenticate($acronym, $password);
            $url = $this->url->create('');
            $this->response->redirect($url);
        }

        $this->views->add('me/page', [
            'title' => 'Register account',
            'content' => $form->getHTML(),
        ]);
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

    public function updateAction($id)
    {
        $this->theme->setTitle('Update user');
        if (!isset($id)) {
            die('Missing id..');
        }
        $user = $this->users->find($id);

        // Check if the user owns the profile.
        $usrSession = $this->session->get('user');
        $edit = $user->id == $usrSession->id ? true : false;
        if (!$edit) {
            die('YOU CANT DO THAT');
        }

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
            'password' => [
                'type' => 'password',
                'label' => 'New Password',
                'required' => false,
            ],

            'submit' => [
                'type' => 'submit',
                'callback' => function ($form) {
                    // Spara till databas
                    $this->users->save([
                       'acronym' => $form->Value('acronym'),
                       'email' => $form->Value('email'),
                       'name' => $form->Value('name'),
                       'password' => password_hash($form->Value('password'), PASSWORD_DEFAULT),
                    ]);

                    return true;
                }
            ],

        ]);

        $status = $form->check();
        if ($status == true) {
            $url = $this->url->create("users/profile/$user->acronym");
            $this->response->redirect($url);
        }

        $this->views->add('users/update', [
            'user' => $user,
            'title' => "Edit user",
            'content' => $form->getHTML(),
        ]);
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
        $this->theme->setTitle('Pthiserskorgen');

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
        if (!isset($id)) {
            die('Id är inte satt');
        }
        $now = date('Y-m-d h:i:s');

        if (isset($user->active)) {
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
            $this->flashy->notice('Already logged in!');
            exit();
        }

        // Skapa form

        $this->form->create([], [
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
                    'callback' => function ($form) {
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


            if ($this->auth->authenticate($acronym, $password)) {
                $name = $this->session->get('user')->username;
                $this->flashy->success("Welcome {$name}");
                $url = $this->url->create('');
            } else {
                $this->flashy->error('Wrong username/password');
                $url = $this->url->create('users/login');
            }
            $this->response->redirect($url);
        }
        $this->views->add('me/page', [
            'title' => 'Login',
            'content' => $this->form->getHTML(),
        ],'main');

        $url = $this->url->create('users/add');
        $this->views->addString("<a href='{$url}'>Register here!</a>", 'sidebar');
    }

    public function logoutAction()
    {
        $this->theme->setTitle('Logout');
        if ($this->auth->isAuthenticated()) {
            $this->auth->logout();
            $this->flashy->success("WHY U LEAVE?!");
            $url = $this->url->create('');
        } else {
            $this->flashy->error('Please login before logout u noob');
            $url = $this->url->create('users/login');

        }
        $url = $this->url->create('');
        $this->response->redirect($url);
    }

    public function profileAction($acronym)
    {
        $title = "$acronym's profile";
        $this->theme->setTitle($title);

        if (is_numeric($acronym)) {
            $user = $this->users->find($acronym);
        } else {
            $user = $this->users->findByName($acronym);
        }

        // Check if the user owns the profile.
        $edit = false;
        if ($this->session->get('user') !== null) {
            $usrSession = $this->session->get('user');
            $edit = $user->id == $usrSession->id ? true : false;
        }


        $questions = $this->questions->findQuestionsByUser($user->id);
        $answers = $this->questions->findAnswersByUser($user->id);
        $comments = $this->questions->findCommentsByUser($user->id);

        $this->views->add('users/profile', [
            'title' => $title,
            'user' => $user,
            'edit' => $edit,
            'questions' => $questions,
            'answers' => $answers,
            'comments' => $comments,
        ], 'main');


        $questions = $this->questions->findQuestionsByUser($user->id,3);
        $answers = $this->questions->findAnswersByUser($user->id,3);
        $this->views->add('users/profile-sidebar', [
            'user' => $user,
            'questions' => $questions,
            'answers' => $answers,
        ], 'sidebar');

    }

    public function setupAction()
    {
        // Drop table if exist
        $this->db->dropTableIfExists('user')->execute();

        // Create a user table
        $this->db->createTable('user', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'post' => ['integer'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ])->execute();

        // Add 2 users
        $this->db->insert(
            'user',
            ['acronym', 'email', 'name', 'password', 'created', 'active']
        );

        // Get the date?
        $now = date("Y-m-d h:i:s");

        // Execute the query
        $this->db->execute([
            'admin',
            'admin@test.se',
            'Administrator',
            password_hash('admin', PASSWORD_DEFAULT),
            $now,
            $now
        ]);
    }
}
