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
        <?php if (isset($all)): ?>
            <?php dump($all); ?>
            <?php foreach ($all as $key => $value): ?>
                <?php // Gör något här sen // ?>
            <?php endforeach ?>
        <?php else: ?>
            <p>Nothing posted yet..<p>
        <?php endif ?>

    </div>


<? else : ?>
    <p>User not found!</p>
<? endif; ?>