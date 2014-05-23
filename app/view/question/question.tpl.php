<h1 style='margin-bottom: 0;'><a href="<?=$this->url->create('questions')?>"><i class="fa fa-chevron-left hoverDark"></i></a> <?=$title?></h1>

<? if (isset($question) && is_object($question)): ?>

    <table class="question">
        </tbody>

            <tr style='border: 0;'>
                <td>
                    <p><?=$question->content?></p>
                    <p class="question-about"><a class="hoverDark" href="<?=$this->url->create('users/profile/' . $question->acronym) ?>"><?=$question->acronym?></a> - <span><?=$this->time->getRelativeTime($question->created)?></span></p>
                </td>
            </tr>

        <tbody>
    </table>

<?php else : ?>

    <p>Question does not exist!</p>

<?php endif; ?>