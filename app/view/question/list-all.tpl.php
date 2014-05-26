<div class='question'>

<?php $url = $this->url->create('questions/new'); ?>
    <a href="<?=$this->url->create('questions')?>"><h1><?=$title?></h1></a>
    <a href='<?=$url?>' class='new-button'><span><i class="fa fa-plus"></i> New</span></a>
<?php if(!empty($questions)) : ?>
    <?php foreach ($questions as $question) : ?>
        <?php $url = $this->url->create('questions/title/' . $question->q_id .'/' . $question->slug)?>
        <p class='toggle'><?=$question->title?></p>
        <div onclick="document.location = '<?=$url?>'" class='selection'><?=(strlen($question->content) > 178) ? substr($question->content,0,175).'...' : $question->content?></div>
    <?php endforeach; ?>

<?php else : ?>
    <p>No questions found.</p>
<?php endif; ?>

</div>