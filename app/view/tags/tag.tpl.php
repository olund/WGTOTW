
<?php if(!empty($tags)) : ?>
    <h1><a href="<?=$this->url->create('tags')?>"><i class="fa fa-chevron-left"></i></a></h1>
    <h1><?=$title?></h1>
        <h4>Questions with <?=$title?> as tag</h4>
        <?php foreach ($questions as $key => $question): ?>
        <div class="question-content hover" onclick="document.location = '<?=$this->url->create('questions/title/' . $question->id . '/' . $question->slug)?>'">
            <p><?=$question->content?></p>
            <b>By:</b><a class="by" href="<?=$this->url->create('users/profile/' . $question->acronym)?>"> <?=$question->acronym?></a>
        </div>
    <?php endforeach ?>

<?php else : ?>
    <p>The tag not found.</p>
<?php endif; ?>

