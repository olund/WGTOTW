<?php

namespace Anax\Tag;

class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->tags = new \Anax\Tag\Tag();
        $this->tags->setDI($this->di);
    }

    public function indexAction()
    {
        $this->theme->setTitle('Tags');
        $tags = $this->tags->findAll();
        $this->views->add('tags/list', [
           'title' => 'All tags',
           'tags' => $tags,
        ]);
    }

    public function tagAction($title)
    {
        $this->theme->setTitle($title);
        $tag = $this->tags->find($title);

        $questions = $this->tags->getAllQuestionWithTag($title);
        $this->views->add('tags/tag', [
            'title' => $title,
            'tags' => $tag,
            'questions' => $questions,
        ]);
    }

    public function setupAction()
    {
        // Setup the database.
        $this->theme->setTitle('Setup the db');

        // Drop the table.
        $this->db->dropTableIfExists('tag')->execute();

        // Create table
        $this->db->createTable('tag', [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'text' => ['varchar(32)', 'not null'],
            'uses' => ['integer', 'default "0"'],
        ])->execute();

        $this->views->addString('<h1>Tag database was reconfigured!</h1>', 'main');
    }
}
