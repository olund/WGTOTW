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
		return $this->db->fetchInfo($this);
	}
}