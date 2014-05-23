<?php

namespace Anax\Questions;

class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDi($this->di);
    }

    /**
     * Show all question.. this is the startpage
     */
    public function indexAction()
    {
        // Get all the questions
        $questions = $this->questions->findAll();
        $this->theme->setTitle('All questions');

        $this->views->add('question/list', [
            'title' => 'All questions',
            'questions' => $questions,
        ], 'main');
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

            // Unset the session
            $this->session->noSet('form-save');

            // Get current time/date
            $now = date("Y-m-d H:i:s");

            // Create slug
            $slug = $this->createSlug($title);
            // Markdown wonders.
            // IDK IF I should have this here...
            $content = $this->textFilter->doFilter($content, 'shortcode, markdown');

            // Save the question.
            $this->questions->save([
                'user_id' => $this->session->get('user')->id,
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
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
        $question = $this->questions->find($id);

        if (!is_object($question)) {
            die ('Cant find the question you are looking for..');
        } else {
            $this->theme->setTitle($question->title);
            $this->views->add('question/question', [
                'title' => $question->title,
                'question' => $question,
            ], 'main');
        }

    }

    public function sidebarAction()
    {
        $questions = $this->questions->findLatest(3);
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

        // SQL...
        $this->db->dropTableIfExists('question')->execute();

        $this->db->createTable('question', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'user_id' => ['integer', 'not null'],
            'title' => ['varchar(100)', 'not null'],
            'content' => ['text', 'not null'],
            'slug'    => ['varchar(100)', 'not null'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
        ])->execute();

        $this->questions->save([
            'user_id' => '1',
            'title' => 'test question',
            'content' => 'Who Am I?',
            'slug' => 'test-question',
        ]);

        $this->questions->save([
            'user_id' => '2',
            'title' => 'sample question',
            'content' => 'Who are YOU?',
            'slug' => 'sample-question',
        ]);
        $this->views->addString('Database is updated:d', 'main');
    }


}