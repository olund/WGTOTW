<?php

namespace Anax\Comments;

/**
 * Model for Comments
 */
class Comment extends \Anax\MVC\CDatabaseModel
{
    /**
     * Save current object/row
     * @param  array $values
     * @return boolean
     */
    public function save($values = []) {
        $this->setProperties($values);
        $values = $this->getProperties();
        if (isset($values['id'])) {
            return $this->update($values);
        } else {
            return $this->create($values);
        }
    }
}