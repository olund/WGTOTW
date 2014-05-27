<?php

namespace Anax\Questions;

class Question extends \Anax\MVC\CDatabaseModel
{
    /**
     * Find and return all questions from the database
     * @return array
     */
    public function findAll()
    {
        $this->db->select('*, phpmvc_question.id AS q_id, phpmvc_question.created AS created')
                 ->from($this->getSource())
                 ->join('user', 'phpmvc_user.id = phpmvc_question.user_id')
                 ->orderBy('phpmvc_question.created DESC');

        $this->db->execute();
        return $this->db->fetchAll();
    }

    /**
     * Find a question with id
     * @param  int $id the id
     * @return array
     */
    public function find($id)
    {
        $this->db->select('*, phpmvc_question.id AS q_id, phpmvc_question.created AS created')
                ->from($this->getSource())
                ->where($this->db->getTablePrefix() . $this->getSource() . ".id = ?")
                ->join('user', 'phpmvc_user.id = phpmvc_question.user_id');

        $this->db->execute([$id]);
        return $this->db->fetchOne();
    }

    /**
     * Find a quesiton based on a slug
     * @param  string $slug The slug
     * @return array
     */
    public function findBySlug($slug)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where('slug = ?');

        $this->db->execute([$slug]);
        return $this->db->fetchInto($this);
    }

    public function findQuestionsByUser($id, $limit = 1000)
    {
        $this->db->select('
                phpmvc_question.slug,
                phpmvc_question.title,
                phpmvc_question.id AS q_id,
                phpmvc_question.created AS created
            ')
            ->from($this->getSource())
            ->join('user', 'phpmvc_user.id = phpmvc_question.user_id')
            ->where('phpmvc_user.id = ?')
            ->orderBy('phpmvc_question.id DESC')
            ->limit($limit);
        $this->db->execute([$id]);
        return $this->db->fetchAll();
    }

    public function findAnswersByUser($id, $limit = 1000)
    {
        $this->db->select('phpmvc_answer.id as id,
            phpmvc_user.acronym as a_acronym,
            phpmvc_answer.content as a_content,
            phpmvc_question.slug as slug')
            ->from('answer')
            ->join('user', 'phpmvc_user.id = phpmvc_answer.user_id')
            ->join('question', 'phpmvc_answer.q_id = phpmvc_question.id')
            ->where('phpmvc_user.id = ?')
            ->orderBy('id DESC')
            ->limit($limit);
        $this->db->execute([$id]);
        return $this->db->fetchAll();
    }

    public function findCommentsByUser($id)
    {   // Get question comments
        $this->db->select()
            ->from('q_comment')
            ->join('user', 'phpmvc_user.id = phpmvc_q_comment.user_id')
            ->where('phpmvc_q_comment.user_id = ?');
        $this->db->execute([$id]);

        $q_comments = $this->db->fetchAll();

        // Get answer comments
        $this->db->select()
            ->from('a_comment')
            ->join('user', 'phpmvc_user.id = phpmvc_a_comment.user_id')
            ->where('phpmvc_a_comment.user_id = ?');
        $this->db->execute([$id]);
        $a_comments = $this->db->fetchAll();

        $all = [];
        $all['question_comments'] = $q_comments;
        $all['answers_comments'] = $a_comments;
        return $all;

    }


    /**
     * Find the latest questions..
     * @param  int $limit the limit
     * @return [type]     [description]
     */
    public function findLatest($limit)
    {
        $this->db->select('*, phpmvc_question.id AS q_id , phpmvc_question.created AS created')
                ->from($this->getSource())
                ->join('user', 'phpmvc_user.id = phpmvc_question.user_id')
                ->orderBy('phpmvc_question.created DESC')
                ->limit($limit);

        $this->db->execute();
        return $this->db->fetchAll();
    }

    private function getQuestionComments($id)
    {
        $this->db->select('phpmvc_q_comment.content as q_comment,
            phpmvc_user.acronym as q_comment_username')
            ->from('q_comment')
            ->join('user', 'phpmvc_user.id = phpmvc_q_comment.user_id')
            ->where('phpmvc_q_comment.q_id = ?');

        $this->db->execute([$id]);
        return $this->db->fetchAll();
        /*
            SELECT
            phpmvc_q_comment.content as q_comment,
            phpmvc_user.acronym as q_comment_username
            FROM phpmvc_q_comment
            INNER JOIN phpmvc_user
            ON phpmvc_user.id = phpmvc_q_comment.user_id
            WHERE phpmvc_q_comment.q_id = 1
         */
    }

    private function getQuestionAnswers($id)
    {
        $this->db->select('phpmvc_answer.id as id,
            phpmvc_user.acronym as a_acronym,
            phpmvc_answer.content as a_content')
            ->from('answer')
            ->join('user', 'phpmvc_user.id = phpmvc_answer.user_id')
            ->where('phpmvc_answer.q_id = ?')
            ->orderBy('id DESC');

        $this->db->execute([$id]);
        $answers = $this->db->fetchAll();
        /*
            SELECT
            phpmvc_answer.id as id,
            phpmvc_user.acronym as a_acronym,
            phpmvc_answer.content as a_content
            FROM phpmvc_answer
            INNER JOIN phpmvc_user
            ON phpmvc_user.id = phpmvc_answer.user_id
            WHERE phpmvc_answer.q_id = 1
         */
        $array = [];
        // Get comments for the answers
        foreach ($answers as $key => $answer) {
            $this->db->select('phpmvc_a_comment.content as a_content,
                phpmvc_user.acronym as a_comment_author')
                ->from('a_comment')
                ->join('user', 'phpmvc_user.id = phpmvc_a_comment.user_id')
                ->where('phpmvc_a_comment.a_id = ?');
            $this->db->execute([$answer->id]);
            $res = $this->db->fetchAll();

            $array[$key]['answers'] = [
                'id' => $answer->id,
                'answer' => $answer->a_content,
                'author' => $answer->a_acronym,
            ];
            if (count($res) != 0 ) {
                $array[$key]['comments'] = $res;
            } else {
                $array[$key]['comments'] = [];
            }
        }
        return $array;
    }

    private function getQuestionTags($id)
    {
        $this->db->select('phpmvc_question.tags')
            ->from('question')
            ->where('id = ?');

        $this->db->execute([$id]);
        return $this->db->fetchOne();
    }

    /**
     * THIS IS THE ONE!
     * This fucking method returns all the question shit.
     * @param  int $id [description]
     * @return [type]     [description]
     */
    public function getQuestionWithComments($id)
    {
        $question = $this->find($id);
        $comments = $this->getQuestionComments($question->q_id);
        $answers = $this->getQuestionAnswers($id);
        $tags = $this->getQuestionTags($id);

        $all = [];

        $all[0]['question'] = $question;
        if (count($comments) != 0) {
            $all[0]['comments'] = $comments;
        } else {
            $all[0]['comments'] = [];
        }

        $all[0]['answers'] = $answers;
        $all[0]['tags'] = $tags;
        return $all;
    }

    public function saveAnswer($values = [])
    {
        $this->db->insert('answer',
            ['user_id', 'q_id', 'content', 'created']
        );

        $this->db->execute([
            $values['user_id'],
            $values['question_id'],
            $values['content'],
            $values['created'],
        ]);
    }

    public function saveComment($values = [], $type)
    {
        if ($type == 'a') {
            $this->db->insert(
                $type . '_comment',
                ['user_id', 'a_id', 'content', 'created']
            );

        } elseif ($type == 'q') {
            $this->db->insert(
                $type . '_comment',
                ['user_id', 'q_id', 'content', 'created']
            );
        }

        $this->db->execute([
            $values['user_id'],
            $values['reference_id'],
            $values['content'],
            $values['created'],
        ]);
    }
}
