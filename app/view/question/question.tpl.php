<div class='question'>
    <?php foreach ($question as $key => $value) : ?>
        <h1 class="question-title"><?=$value['question']->title?></h1>
        <a href='<?=$this->url->create('questions/answer/' . $value['question']->q_id . '/' . $value['question']->slug)?>' style="margin: 0 1em;" class='ask-button-small right'><span><i class="fa fa-check"></i> Answer</span></a>
        <a href='<?=$this->url->create('questions/comment/q/' . $value['question']->q_id . '/' . $value['question']->q_id)?>' style="margin: 0;" class='ask-button-small right'><span><i class="fa fa-comment"></i> Comment</span></a>

        <div class='question-content'>
            <p><?=$value['question']->content?></p>
            <div class='question-tags'>
            <?php if (!empty($value['tags']->tags)) : ?>
                <?php foreach ($value['tags'] as $key => $tag) : ?>
                    <?php foreach (unserialize($tag) as $a => $t) : ?>
                        <a class="tag" href="#">#<?=$t?></a>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            </div>
            <a class="by" href="<?=$this->url->create('users/profile/' . $value['question']->acronym)?>">By: <?=$value['question']->acronym?></a>
        </div>


        <div class='question-comment'>
            <?php foreach ($value['comments'] as $comment) : ?>
                <div class='q-comment'>
                    <p><?=$comment->q_comment?></p>
                    <a class="by" href="<?=$this->url->create('users/profile/' . $comment->q_comment_username)?>">By: <?=$comment->q_comment_username?></a>
                </div>
            <?php endforeach; ?>
        </div>

        <h4 class="answers">Answers:</h4>
        <?php foreach ($value['answers'] as $key => $answer) : ?>
            <div class="question-answers">
            <a href='<?=$this->url->create('questions/comment/a/'.$value['question']->q_id.'/' . $answer['answers']['id'])?>' style="margin: 0;" class='ask-button-small right'><span><i class="fa fa-comment"></i> Comment</span></a>
            <p><?=$answer['answers']['answer']?></p>
            <a class="by" href="<?=$this->url->create('users/profile/' . $answer['answers']['author'])?>">By: <?=$answer['answers']['author']?></a>
            </div>

            <?php foreach ($answer['comments'] as $comment) : ?>
                <div class="answer-comments">
                <p><?=$comment->a_content?></p>
                <a class="by" href="<?=$this->url->create('users/profile/' . $comment->a_comment_author)?> ">By: <?=$comment->a_comment_author?></a>
                </div>
            <?php endforeach; ?>


        <?php endforeach;?>


    <?php endforeach; ?>


</div>