<?php

namespace Anax\Questions;

class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDi($this->di);

        $this->tags = new \Anax\Tag\Tag();
        $this->tags->setDI($this->di);

        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }

    /**
     * Show all question.. this is the startpage
     */
    public function indexAction()
    {
        // Get all the questions
        $questions = $this->questions->findAll();
        $this->theme->setTitle('All questions');

        // Markdown wonders.
        $this->contentToMd($questions);

        $this->views->add('question/list-all', [
            'title' => 'All questions',
            'questions' => $questions,
        ], 'main');
    }

    private function contentToMd($array) {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $value->content = $this->textFilter->doFilter($value->content, 'shortcode, markdown');
            }
        } else {
            $array->content = $this->textFilter->doFilter();
        }

        return $array;
    }

    public function newAction()
    {
        // Check if the user is authenticated
        if (!$this->auth->isAuthenticated()) {
            $this->flashy->error('Please login before posing messages');
            $this->response->redirect($this->url->create('users/login'));
            exit();
        }
        $this->theme->setTitle('Add a new question');

        // Create the form
        $form = $this->form;
        $form->create([], [
            'title' => [
                'type' => 'text',
                'placeholder' => 'The title',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'content' => [
                'type' => 'textarea',
                'placeholder' => 'The question',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'tags' => [
                'type' => 'text',
                'placeholder' => 'tag1, tag2, tag3 and so on',
                'required' => false,
            ],
            'submit' => [
                'type' => 'submit',
                'callback' => function ($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        if ($form->check() === true) {
            // Save the values from session
            $title = $_SESSION['form-save']['title']['value'];
            $content = $_SESSION['form-save']['content']['value'];
            $tags = $_SESSION['form-save']['tags']['value'];
            // Unset the session
            $this->session->noSet('form-save');

            // Get current time/date
            $now = date("Y-m-d H:i:s");

            // Create slug
            $slug = $this->createSlug($title);

            if (isset($tags)) {
                $tags = htmlentities(strip_tags($tags));
                $tags =strtolower($tags);
                $tags = str_replace(' ', '', $tags);
                $tags = str_replace('#', '', $tags);
                $tags = explode(',', $tags);
            }
            // Check if the tag already exist.
            $this->tags->check($tags);

            $id = $this->session->get('user')->id;
            // update user
            $user = $this->users->find($id);
            $user->post++;
            $user->save([
                'id' => $user->id,
                'post' => $user->post
            ]);

            // Save the question.
            $this->questions->save([
                'user_id' => $this->session->get('user')->id,
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
                'tags' => serialize($tags),
                'created' => $now,
            ]);


            // Flash the success
            $this->flashy->success('The question was posted!');
            $url = $this->url->create('questions/title/' . $this->questions->findBySlug($slug)->id . '/' . $slug);
            $this->response->redirect($url);
        }

        $this->views->add('default/page', [
            'title' => 'New question',
            'content' => $this->form->getHTML(),
        ], 'main');
    }


    public function titleAction($id, $slug)
    {
        $question = $this->questions->getQuestionWithComments($id);
        $question[0]['question']->content = $this->textFilter->doFilter($question[0]['question']->content, 'shortcode, markdown');

        foreach ($question[0]['answers'] as $key => &$value) {
            $value['answers']['answer'] = $this->textFilter->doFilter($value['answers']['answer'], 'shortcode, markdown');
        }
        foreach ($question[0]['comments'] as $key => &$value) {
            //die(dump($question));
            $value->q_comment = $this->textFilter->doFilter($value->q_comment, 'shortcode, markdown');

        }

        foreach ($question[0]['answers'] as $key => &$value) {
            foreach ($value['comments'] as $k => &$val) {
                $val->a_content = $this->textFilter->doFilter($val->a_content, 'shortcode, markdown');
            }
        }

        $this->theme->setTitle($question[0]['question']->title);
        $this->views->add('question/question', [
            'title' => $question[0]['question']->title,
            'question' => $question,
        ], 'main');
    }

    public function sidebarAction()
    {
        $questions = $this->questions->findLatest(3);
        $this->contentToMd($questions);

        $this->views->add('question/list', [
            'title' => 'Latest Questions',
            'questions' => $questions,
        ], 'sidebar');
    }



    private function createSlug($str)
    {
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

        return $clean;
    }

    /**
     * Setup the Question Database.
     * @return void
     */
    public function setupAction()
    {
        $this->theme->setTitle('Setup');

        // SQL... Skapa tabeller och grejjer

        // QUESTION TABLE
        $this->db->dropTableIfExists('question')->execute();
        $this->db->createTable('question', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'user_id' => ['integer', 'not null'],
            'title' => ['varchar(100)', 'not null'],
            'content' => ['text', 'not null'],
            'slug'    => ['varchar(100)', 'not null'],
            'tags' => ['text'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
        ])->execute();



        // ANSWER TABLE
        $this->db->dropTableIfExists('answer')->execute();
        $this->db->createTable('answer',[
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'user_id' => ['integer', 'not null'],
            'q_id' => ['integer', 'not null'],
            'content' => ['text', 'not null'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
        ])->execute();

        // Q_COMMENT TABLE
        $this->db->dropTableIfExists('q_comment')->execute();
        $this->db->createTable('q_comment', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'user_id' => ['integer', 'not null'],
            'q_id' => ['integer', 'not null'],
            'content' => ['text', 'not null'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
        ])->execute();

        // A_COMMENT TABLE
        $this->db->dropTableIfExists('a_comment')->execute();
        $this->db->createTable('a_comment', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'user_id' => ['integer', 'not null'],
            'a_id' => ['integer', 'not null'],
            'content' => ['text', 'not null'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
        ])->execute();

        $now = date("Y-m-d H:i:s");

        $this->questions->save([
            'user_id' => '1',
            'title' => 'Problems with the root account',
            'content' => 'How do i get access to the root account?
            ```su root```
            does not work...',
            'slug' => 'can-you-help-me',
            'created' => $now,
        ]);
        $this->views->addString('Database is updated:d', 'main');
    }

    public function answerAction($id, $slug)
    {
        if ($id == null || $slug == null) {
            die('Id and slug cant be null u fool');
        }

         if (!$this->auth->isAuthenticated()) {
            $this->flashy->error('Please sign in!');
            $url = $this->url->create('users/login');
            $this->response->redirect($url);
            exit();
        }

        $this->theme->setTitle("Answer");

        $form = $this->form;
        $form = $form->create([], [
            'answer' => [
                'type' => 'textarea',
                'placeholder' => 'The answer...',
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

        if ($form->check()) {
            $content = $_SESSION['form-save']['answer']['value'];
            $this->session->noSet('form-save');
            $now = date("Y-m-d H:i:s");

            // Save
            $this->questions->saveAnswer([
                'user_id' => $this->session->get('user')->id,
                'question_id' => $id,
                'content' => $content,
                'created' => $now,
            ]);

            $this->flashy->success('Your answer was posted!');
            $url = $this->url->create('questions/title/' . $id . '/' . $slug);
            $this->response->redirect($url);
        }

        $this->views->add('default/page', [
            'title' => 'New answer',
            'content' => $form->getHTML(),
        ], 'main');

    }

    public function commentAction($type, $id, $q_id)
    {
        if ($type == null || $id == null || !is_string($type)) {
            die('wrong params');
            exit();
        }
        if ($type != 'a' && $type != 'q') {
            die('not answer or question');
            exit();
        }

         if (!$this->auth->isAuthenticated()) {
            $this->flashy->error('Please sign in!');
            $url = $this->url->create('users/login');
            $this->response->redirect($url);
            exit();
        }

        $this->theme->setTitle("Comment");

        $form = $this->form;

        $form = $form->create([], [
            'comment' => [
                'type' => 'textarea',
                'placeholder' => 'The Comment...',
                'required' => true,
                'validation' => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => function($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        if ($form->check()) {
            $content = $_SESSION['form-save']['comment']['value'];
            $this->session->noSet('form-save');
            $now = date("Y-m-d H:i:s");

            $this->questions->saveComment([
                'user_id' => $this->session->get('user')->id,
                'reference_id' => $q_id,
                'content' => $content,
                'created' => $now,
            ], $type);
            $this->flashy->success("Your comment was posted!");
            $slug = $this->questions->find($id)->slug;
            $url = $this->url->create('questions/title/' . $id . '/' . $slug);
            $this->response->redirect($url);
        }


        $this->views->add('default/page', [
            'title' => 'New comment',
            'content' => $form->getHTML(),
        ], 'main');
    }


}