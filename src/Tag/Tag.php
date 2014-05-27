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

    public function findByTag($tag)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('text = ?');

        $this->db->execute([$tag]);
        return $this->db->fetchInto($this);
    }

    public function findMostPopular($limit)
    {
        $this->db->select()
            ->from($this->getSource())
            ->orderBy('phpmvc_tag.uses DESC')
            ->limit($limit);

        $this->db->execute([$limit]);
        return $this->db->fetchAll();
    }

    public function getAllQuestionWithTag($theTag)
    {
        $tag = $this->findByTag($theTag);

        // Get everything
        $this->db->select('phpmvc_question.id, phpmvc_question.slug, phpmvc_question.title, phpmvc_question.tags, phpmvc_question.content, phpmvc_user.acronym')
            ->from('question')
            ->join('user', 'phpmvc_user.id = phpmvc_question.user_id');
        $this->db->execute();
        $all = $this->db->fetchAll();

        $questions = [];
        foreach ($all as $one) {
            $tags = unserialize($one->tags);

            if (!is_bool($tags)) {
                if (in_array($tag->text, $tags)) {
                    $questions[] = $one;
                }
            }
        }

        return $questions;
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
    {   // Något jävla fel på denna funktionen.
        if ($tag != " ") {
            $this->saveReal([
                'text' => $tag,
                'uses' => '1',
            ]);
        }
    }




}
