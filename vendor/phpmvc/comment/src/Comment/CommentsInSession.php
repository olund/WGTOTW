<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Add a new comment
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($comment, $key = null)
    {
        $comments = $this->session->get('comments', []);
        $comments[$key][] = $comment;
        $this->session->set('comments', $comments);
    }



    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($key = null)
    {
        $comments = $this->session->get('comments', []);
        if(isset($comments[$key])) {
            return $comments[$key];
        }
    }

     /**
     * Find and return comment with id
     *
     * @return a comment.
     */
    public function find($id, $key) 
    {
        $comments = $this->session->get('comments', []);
        return $comments[$key][$id];
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAllInSession()
    {
        $this->session->set('comments', []);
    }

    public function deleteAll($key)
    {
        $comments = $this->session->get('comments', []);
        $comments[$key] = [];
        $this->session->set('comments', $comments);
    }
    
    /**
     * Delete a comment
     * @param int $id the id.
     * @return void
     */
    public function delete($id, $key = null) 
    {
        // Get all comments.
        $comments = $this->session->get('comments', []);
        // Remove the comment.
        unset($comments[$key][$id]);
        // Set the new array.
        $this->session->set('comments', $comments);
    }

    public function save($comment, $id = null, $key = null) {
        $comments = $this->session->get('comments', []);
        $comments[$key][$id] = $comment;
        $this->session->set('comments', $comments);
    }
}
