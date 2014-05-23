<?php $url = $this->url->create('questions/new'); ?>

<a href="<?=$this->url->create('questions')?>"><h1 class="left"><?=$title?></h1></a>
<a href='<?=$url?>' class='new-button'><span><i class="fa fa-plus"></i> New</span></a>

<?php if(!empty($questions)) : ?>
    <table class="question">
        </tbody>
        <tr class="spacer"></tr>
        <?php foreach ($questions as $question) : ?>
            <?php $url = $this->url->create('questions/title/' . $question->q_id .'/' . $question->slug)?>
            <tr class='hover' onclick="document.location = '<?=$url?>'">
                <td>
                    <h2><?=$question->title?></h2>
                    <p class="question-content"><?=(strlen($question->content) > 178) ? substr($question->content,0,175).'...' : $question->content?></p>
                    <p class="question-about"><a class="hoverDark" href="<?=$this->url->create('users/profile/' . $question->acronym) ?>"><?=$question->acronym?></a> - <span><?=$this->time->getRelativeTime($question->created)?></span></p>
                </td>
            </tr>
            <tr class="spacer"></tr>
        <?php endforeach; ?>
        <tbody>
    </table>

<?php else : ?>
    <p>No questions found.</p>
<?php endif; ?>