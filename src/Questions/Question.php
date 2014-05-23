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
        $this->db->select('*, ' . $this->db->getTablePrefix() . $this->getSource() . '.id AS q_id , phpmvc_question.created AS created')
                 ->from($this->getSource())
                 ->join('user', $this->db->getTablePrefix() . 'user.id = ' . $this->db->getTablePrefix() . $this->getSource() . '.user_id')
                 ->orderBy($this->db->getTablePrefix() . $this->getSource() .'.created DESC');

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public function find($id)
    {
        $this->db->select('*, phpmvc_question.id AS q_id, phpmvc_question.created AS created')
                ->from($this->getSource())
                ->where($this->db->getTablePrefix() . $this->getSource() . ".id = ?")
                ->join('user', 'phpmvc_user.id = phpmvc_question.user_id');

        $this->db->execute([$id]);
        return $this->db->fetchInto($this);
    }

    public function findBySlug($slug)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('slug = ?');

        $this->db->execute([$slug]);
        return $this->db->fetchInto($this);
    }

    public function findLatest($nr)
    {
        $this->db->select('*, ' . $this->db->getTablePrefix() . $this->getSource() . '.id AS q_id , phpmvc_question.created AS created')
                ->from($this->getSource())
                ->join('user', $this->db->getTablePrefix() . 'user.id = ' . $this->db->getTablePrefix() . $this->getSource() . '.user_id')
                ->orderBy($this->db->getTablePrefix() . $this->getSource() .'.created DESC')
                ->limit($nr);

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}
