<? if (isset($user) && is_object($user)): ?>
    <div class="profile">
        <?php $gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '.jpg?s=40'; ?>

        <h1>
            <img class="gravatar" src='<?= $gravatar ?>' alt="Avatar"/>
            <?=$title?>
            <? if ($edit) : ?>
                <a class='a-alt' href='<?=$this->url->create('users/update') . '/' . $user->id?>'><i class='fa fa-pencil'></i></a>
            <? endif; ?>
        </h1>

        <h4>Username</h4>
        <p><?=$user->acronym?></p>
        <h4>Name</h4>
        <p><?=$user->name?></p>
        <h4>Email</h4>
        <p><?=$user->email?></p>
    </div>

    <div class="all">
        <?php if (isset($questions)): ?>
            <div class="all-questions">
                <h4>All Question Posted</h4>
                <hr>
                <ul>
                <?php foreach ($questions as $key => $question): ?>
                    <li><a href="<?=$this->url->create('questions/title/' . $question->q_id . '/' . $question->slug)?>"><?=$question->title?></a></li>
                <?php endforeach ?>
                </ul>
            </div>

        <?php else: ?>
            <p>Nothing question posted<p>
        <?php endif ?>

        <?php if (isset($answers)): ?>
        <div class="all-answers">
            <h4>All Answers Posted</h4>
            <hr>
            <ul>
            <?php foreach ($answers as $key => $answer): ?>
                <li>
                    <a href="<?=$this->url->create('questions/title/' . $answer->id . '/' . $answer->slug)?>"><?=$answer->a_content?></a>
                </li>
            <?php endforeach ?>
            </ul>
        </div>
        <?php else: ?>
            <p>Nothing answers posted<p>
        <?php endif ?>

        <?php if (isset($comments)): ?>
            <div class="all-comments">
            <h4>All Comments Posted</h4>
            <hr>
            <ul>
            <?php foreach ($comments as $key => $comment): ?>
                <?php foreach ($comment as $c): ?>
                    <li>
                        <a href="<?=$this->url->create('questions/title/' . $c->ffs . '/' . $c->slug)?>"><?=$c->q_content?></a>
                    </li>
                <?php endforeach ?>

            <?php endforeach ?>
            </ul>
        </div>
        <?php else: ?>
            <p>Nothing answers posted<p>
        <?php endif ?>
    </div>


<? else : ?>
    <p>User not found!</p>
<? endif; ?>