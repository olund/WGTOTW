<?php

namespace Anax\Questions;

class Question extends \Anax\MVC\CDatabaseModel
{
    /**
     * Find and return all questions from the database
     * @return array
     */
    public function findAll()
    {
        $this->db->select('*, phpmvc_question.id AS q_id, phpmvc_question.created AS created')
                 ->from($this->getSource())
                 ->join('user', 'phpmvc_user.id = phpmvc_question.user_id')
                 ->orderBy('phpmvc_question.created DESC');

        $this->db->execute();
        return $this->db->fetchAll();
    }

    /**
     * Find a question with id
     * @param  int $id the id
     * @return array
     */
    public function find($id)
    {
        $this->db->select('*, phpmvc_question.id AS q_id, phpmvc_question.created AS created')
                ->from($this->getSource())
                ->where($this->db->getTablePrefix() . $this->getSource() . ".id = ?")
                ->join('user', 'phpmvc_user.id = phpmvc_question.user_id');

        $this->db->execute([$id]);
        return $this->db->fetchOne();
    }

    /**
     * Find a quesiton based on a slug
     * @param  string $slug The slug
     * @return array
     */
    public function findBySlug($slug)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('slug = ?');

        $this->db->execute([$slug]);
        return $this->db->fetchInto($this);
    }

    /**
     * Find the latest questions..
     * @param  int $limit the limit
     * @return [type]     [description]
     */
    public function findLatest($limit)
    {
        $this->db->select('*, phpmvc_question.id AS q_id , phpmvc_question.created AS created')
                ->from($this->getSource())
                ->join('user', 'phpmvc_user.id = phpmvc_question.user_id')
                ->orderBy('phpmvc_question.created DESC')
                ->limit($limit);

        $this->db->execute();
        return $this->db->fetchAll();
    }
}
