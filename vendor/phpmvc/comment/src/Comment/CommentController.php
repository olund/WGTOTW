<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($key = null)
    {
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
        $this->theme->setTitle("View all");
        $all = $comments->findAll($key);

        $this->views->add('comment/comments', [
            'comments' => $all,
            'key'      => $key,
        ]);
    }



    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content' => $this->request->getPost('content'),
            'name' => $this->request->getPost('name'),
            'web' => $this->request->getPost('web'),
            'mail' => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip' => $this->request->getServer('REMOTE_ADDR'),
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
        // Get the key
        $key = $this->request->getPost('key');

        $comments->add($comment, $key);
        $this->response->redirect($this->request->getPost('redirect'));
    }



    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction()
    {
        $isPosted = $this->request->getPost('doRemoveAll');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $key = $this->request->getPost('key');
        $comments->deleteAll($key);
        $this->response->redirect($this->request->getPost('redirect'));
    }

    public function removeAction()
    {
        if(!$this->request->getPost('doRemove')) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $id = $this->request->getPost('id');
        $key = $this->request->getPost('key');

        $comments->delete($id, $key);
        $this->response->redirect($this->request->getPost('redirect'));
    }


    public function editAction()
    {
        if(!$this->request->getPost('doEdit')) {
           $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $id = $this->request->getPost('id');
        $key = $this->request->getPost('key');

        $comment = $comments->find($id, $key);

        // Lägg till id och key på en kommentar.
        $comment['key'] = $key;
        $comment['id'] = $id;

        $this->views->add('comment/edit', $comment);
    }

    public function saveAction()
    {
        if(!$this->request->getPost('doSave')) {
           $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content' => $this->request->getPost('content'),
            'name' => $this->request->getPost('name'),
            'web' => $this->request->getPost('web'),
            'mail' => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip' => $this->request->getServer('REMOTE_ADDR'),
        ];

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $id = $this->request->getPost('id');
        $key = $this->request->getPost('key');
        $comments->save($comment, $id, $key);
        $this->response->redirect($this->request->getPost('redirect'));
    }
}
