
<span class="sitelogo"><i class="fa fa-linux fa-5x"></i></span>
<span class='sitetitle'><?=$siteTitle?></span>
<span class='siteLogin'>
    <?php if ($this->auth->isAuthenticated()): ?>
    <a href='questions' class='ask-button right'>
        <span>Ask a question</span>
    </a>
<?php else: ?>
    <a href='users/login' class='ask-button right'>
        <span>Login</span>
    </a>
<?php endif; ?>
</span>
<span class='siteslogan'><?=$siteTagline?></span>