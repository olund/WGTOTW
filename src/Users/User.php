<?php

namespace Anax\Users;

/**
 * Model for Users
 */
class User extends \Anax\MVC\CDatabaseModel
{
	public function findByName($acronym)
	{
		$this->db->select()->from($this->getSource())->where('acronym = ?');
		$this->db->execute([$acronym]);
		return $this->db->fetchInto($this);
	}

    public function findMostActive($limit)
    {
        $this->db->select('phpmvc_user.acronym')
            ->from('user')
            ->orderBy('phpmvc_user.post DESC')
            ->limit($limit);
        $this->db->execute();
        return $this->db->fetchAll();
    }
}
