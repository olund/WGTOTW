<div class='question'>

<?php $url = $this->url->create('questions/new'); ?>
    <a href="<?=$this->url->create('questions')?>"><h1 class="left"><?=$title?></h1></a>
    <a href='<?=$url?>' class='new-button'><span><i class="fa fa-plus"></i> New</span></a>
<?php if(!empty($questions)) : ?>

    <?php foreach ($questions as $question) : ?>
        <?php $url = $this->url->create('questions/title/' . $question->q_id .'/' . $question->slug)?>

        <h2 class='question-title'><?=$question->title?></h2>
        <div onclick="document.location = '<?=$url?>'" class="question-content hover"><p><?=(strlen($question->content) > 178) ? substr($question->content,0,175).'...' : $question->content?></p></div>
        <a class="by" href="<?=$this->url->create('users/profile/' . $question->acronym) ?>"><?=$question->acronym?></a> - <span><?=$this->time->getRelativeTime($question->created)?></span>

    <?php endforeach; ?>
        <tbody>
    </table>

<?php else : ?>
    <p>No questions found.</p>
<?php endif; ?>

</div>