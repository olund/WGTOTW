<? if (isset($user) && is_object($user)): ?>

<h3>Latest Questions</h3>
    <?php if (isset($questions)): ?>
        <ul>
            <?php foreach ($questions as $key => $question): ?>
                <li><a href="<?=$this->url->create('questions/title/' . $question->q_id . '/' .$question->slug)?>"><?=$question->title?></a></p></li>
            <?php endforeach ?>
        </ul>

    <?php else: ?>
        <p>Nothing yet...</p>
    <?php endif; ?>

<h3>Latest Answers</h3>
    <?php if (isset($answers)): ?>
        <ul>
            <?php foreach ($answers as $key => $answer): ?>
                <li><a href="<?=$this->url->create('questions/title/' . $answer->id .  '/' . $answer->slug)?>"><?=$answer->a_content?></a></li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <p>Nothing yet...</p>
    <?php endif ?>
<? else : ?>
<? endif; ?>