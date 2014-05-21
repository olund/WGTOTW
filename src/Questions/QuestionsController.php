<?php

namespace Anax\Questions;

class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->questions = new \Anax\Questions\Question();
        $this->questions->setDi($this->di);
    }
}