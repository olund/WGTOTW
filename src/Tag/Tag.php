<?php

namespace Anax\Tag;

class Tag extends \Anax\MVC\CDatabaseModel
{
    /**
     * Find all tags
     *
     */
    public function findAll()
    {
        $this->db->select('*')
            ->from('tag')
            ->orderBy('phpmvc_tag.uses DESC');
        $this->db->execute();
        return $this->db->fetchAll();
    }
    /**
     * Find a tag by title
     */
    public function find($title)
    {
        $this->db->select('*')
            ->from('tag')
            ->where('text = ?');
        $this->db->execute([$title]);
        return $this->db->fetchOne();
    }

    public function check($tags = [])
    {
        if (!empty($tags)) {
            foreach ($tags as $key => $tag) {
                $r = $this->find($tag);
                if (!empty($r) && is_object($r)) {
                    $this->updateTag($tag);
                } else {
                    $this->addTag($tag);
                }
            }
        }
    }

    public function updateTag($tag)
    {
        $tag = $this->find($tag);
        $tag->uses++;
        $this->save($tag);
    }

    public function addTag($tag)
    {
        if ($tag != " ") {
            $this->saveReal([
                'text' => $tag,
                'uses' => '1',
            ]);
        }
    }




}
