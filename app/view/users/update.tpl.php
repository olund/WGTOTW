<h1><?=$title?></h1>


<? if (isset($user) && is_object($user)): ?>

        <?php $properties = $user->getProperties(); ?>
        <p> <?=$content?> </p>

<? else : ?>

<? endif; ?>

<p><a href='<?=$this->url->create("users/profile/$user->acronym")?>'><i class="fa fa-arrow-left"></i> Back</a></p>