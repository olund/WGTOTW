<?php

namespace Anax\Tag;

class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->tags = new \Anax\Tag\Tag();
        $this->tags->setDI($this->di);

        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
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

    public function triptychAction()
    {
        $tags = $this->tags->findMostPopular(5);
        $users = $this->users->findMostActive(5);
        $this->views->addString('<h4>Most active users</h4>', 'triptych-1');
        foreach ($users as $key => $user) {
            $url = $this->url->create('users/profile/' . $user->acronym);
            $this->views->addString("<p><a href='{$url}'>{$user->acronym}</a></p>", 'triptych-1');
        }

        //die(dump($users));

        $this->views->addString('<h4>Popular tags</h4>', 'triptych-2');
        foreach ($tags as $key => $tag) {
            $url = $this->url->create('tags/tag/' . $tag->text);
            $this->views->addString("<p><a href='{$url}'>#{$tag->text} x {$tag->uses}</a></p>", 'triptych-2');
        }

    }
}
