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

    public function initialize()
    {
        if (is_null($this->session->get('user'))) {
            $user = new \Anax\Users\User();
            $this->session->set('user', $user);
        }
    }

    public function authenticate($acronym, $password)
    {
        $this->initialize();
        $success = false;
        $user = $this->session->get('user');

        $this->db->select()
                ->from($this->dbName)
                ->where('acronym = ?');
        $this->db->execute([$acronym]);
        $res = $this->db->fetchAll();

        if ($res != null && password_verify($password, $res[0]->password)) {
            $user->id = $res[0]->id;
            $user->username = $res[0]->acronym;
            $user->loggedIn = true;

            $this->session->noSet('user', $user);
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