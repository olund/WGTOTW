<?php

namespace Anax\Comments;
/**
 * A controller for Comments
 */
class CommentsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    /**
     * Initialize the controller
     * @return void
     */
    public function initialize()
    {
        $this->comments = new \Anax\Comments\Comment();
        $this->comments->setDI($this->di);
    }

    /**
     * View all the comments
     * @return void
     */
    public function viewAction()
    {
        //$this->initialize();
        $all = $this->comments->findAll();
        $this->views->add('comments/comments', [
            'comments' => $all,
        ], 'sidebar');

        $form = $this->form;

        $name = isset($_SESSION['data']['name']) ? $_SESSION['data']['name'] : null;
        $text = isset($_SESSION['data']['content']) ? $_SESSION['data']['content'] : null;
        $email = isset($_SESSION['data']['email']) ? $_SESSION['data']['email'] : null;
        $web = isset($_SESSION['data']['web']) ? $_SESSION['data']['web'] : null;
        $url = isset($_SESSION['data']['url']) ? $_SESSION['data']['url'] : null;
        $id = isset($_SESSION['data']['id']) ? $_SESSION['data']['id'] : null;

        $this->session->noSet('data');

        $form = $form->create(['id' => 'form-link'], [
            'id' => [
                'type'        => 'hidden',
                'value'       => isset($id) ? $id : null,
                'required'    => false,
            ],
            'url' => [
                'type'        => 'hidden',
                'value'       => $this->request->getCurrentUrl(),
                'required'    => false,
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Name:',
                'required'    => true,
                'value'       => isset($name) ? $name : null,
                'validation'  => ['not_empty'],
            ],
            'text' => [
                'type'        => 'textarea',
                'label'       => 'Comment:',
                'required'    => true,
                'value'       => isset($text) ? $text : null,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'email',
                'label'       => 'Email:',
                'required'    => true,
                'value'       => isset($email) ? $email : null,
                'validation'  => ['email_adress'],
            ],
            'web' => [
                'type'        => 'url',
                'label'       => 'Website:',
                'required'    => false,
                'value'       => isset($web) ? $web : null,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => function($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
            'reset' => [
                'type'      => 'reset',
                'callback'  => function($form) {
                    $form->saveInSession = false;
                    return true;
                }
            ],
        ]);

        // Check the status of the form
        $status = $form->check();

        if ($status === true) {

            // What to do if the form was submitted?
            $name = $_SESSION['form-save']['name']['value'];
            $text = $_SESSION['form-save']['text']['value'];
            $email = $_SESSION['form-save']['email']['value'];
            $web = $_SESSION['form-save']['web']['value'];
            $url = $_SESSION['form-save']['url']['value'];
            $id = $_SESSION['form-save']['id']['value'];

            session_unset($_SESSION['form-save']);

            if (!empty($id)) {
                $this->dispatcher->forward([
                    'controller' => 'comments',
                    'action'     => 'save',
                    'params'     => [$name, $text, $email, $web, $id],
                ]);
            } else{
                $this->dispatcher->forward([
                    'controller' => 'comments',
                    'action'     => 'add',
                    'params'     => [$name, $text, $email, $web, $url],
                ]);
            }
        }

        $this->views->addString('<div class="article1">' . $form->getHTML() . '</div>', 'sidebar');
    }

    /**
     * Add a comment
     * @param string $name
     * @param string $content
     * @param string $email
     * @param string $web
     * @param string $url
     */
    public function addAction($name = null, $content = null, $email = null, $web = null, $url = null)
    {
        //$this->initialize();
        if (!isset($name)) {
            die('Name is missing..');
        }

        $now = date('Y-m-d h:i:s');
        $this->comments->save([
            'name' => $name,
            'content' => $content,
            'email' => $email,
            'web' => $web,
            'ip' => $this->request->getServer('REMOTE_ADDR'),
            'created' => $now,
            'active' => $now,
        ]);
        $this->response->redirect($url);
    }

    public function saveAction($name = null, $content = null, $email = null, $web = null, $id = null)
    {
        //$this->initialize();
        if (!isset($id)) {
            die("Missing id");
        }

        $comment = $this->comments->find($id);

        $now = date("Y-m-d h:i:s");

        $comment->name = $name;
        $comment->content = $content;
        $comment->email = $email;
        $comment->web = $web;

        $comment->updated = $now;
        $comment->save();

        $url = $this->url->create('redovisning');
        $this->response->redirect($url);
    }


    /**
     * Update comment.
     *
     * @param integer $id of comment to update.
     *
     * @return void
     */
    public function updateAction($id)
    {
        //$this->initialize();
        if (!isset($id)) {
            die("Missing id");
        }

        $comment = $this->comments->find($id);

        $data = [
            'method'    => 'save',
            'name'      => $comment->name,
            'content'   => $comment->content,
            'email'     => $comment->email,
            'web'       => $comment->web,
            'id'        => $comment->id,
        ];

        $this->session->set('data', $data);

        $url = $this->url->create($_SERVER['HTTP_REFERER'] . '#form-link');
        $this->response->redirect($url);
    }

    /**
     * Delete comment.
     *
     * @param integer $id of comment to delete.
     *
     * @return void
     */
    public function deleteAction($id = null)
    {
        //$this->initialize();
        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->comments->delete($id);

        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Remove all comments.
     *
     * @return void
     */
    public function deleteAllAction()
    {
        //$this->initialize();
        $this->comments->deleteAll();
        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}