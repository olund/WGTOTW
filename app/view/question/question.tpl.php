<div class='question'>
    <div class='question-title'><h1><a href="<?=$this->url->create('questions')?>"><i class="fa fa-chevron-left"></i></a> <?=$title?></h1></div>
<? if (isset($question) && is_object($question)): ?>
    <table class="question">
        </tbody>
            <tr style='border: 0;'>
                <td>
                    <p><?=$question->content?></p>
                    <p class="question-about"><a class="" href="<?=$this->url->create('users/profile/' . $question->acronym) ?>"><?=$question->acronym?></a> - <span><?=$this->time->getRelativeTime($question->created)?></span></p>
                </td>
            </tr>
        <tbody>
    </table>

<?php else : ?>

    <p>Question does not exist!</p>

<?php endif; ?>

</div>