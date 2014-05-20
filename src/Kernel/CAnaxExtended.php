<?php

namespace Anax\Kernel;

/**
*
*/
class CAnaxExtended extends \Anax\Kernel\CAnax
{
    public function __construct($di)
    {
        parent::__construct($di);
    }

    public function withSession()
    {
        $this->session = $this->di->get('session');
    }
}
