<?php

namespace Anax\Authenticate;

class Authenticate extends \Anax\MVC\CDatabaseModel
{
    public function __construct($dbName)
    {
        $this->dbName = $dbName;
        $this->id = -1;
        $this->username = 'Unknown';
        $this->loggedIn = false;
    }

    public function authenticate($acronym, $password)
    {
        $success = false;

        $this->db->select()
                ->from($this->dbName)
                ->where('acronym = ?');
        $this->db->execute([$acronym]);

        $user = $this->session->get('user');


        $res = $this->db->fetchAll();
        if (isset($res) && password_verify($password, $res[0]->password)) {
            $user->id = $res[0]->id;
            $user->username = $res[0]->acronym;
            $user->loggedIn = true;

            $this->session->noSet('user');
            $this->session->set('user', $user);
            $success = true;
        }
        return $success;
    }

    public function isAuthenticated()
    {
        $ret = false;
        $user = $this->session->get('user');
        if (isset($user)) {
            $ret = true;
        }
        return $ret;
    }

    public function logout()
    {
        $this->session->noSet('user');
    }
}