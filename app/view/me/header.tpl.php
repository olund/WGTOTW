<span class="sitelogo"><i class="fa fa-linux fa-5x"></i></span>
<span class='sitetitle'><?=$siteTitle?></span>
<span class='siteLogin'>

<?php if ($this->auth->isAuthenticated()): ?>
    <?php $username = $this->session->get('user')->username; ?>
    <a href='<?=$this->url->create('users/profile/' . $username)?>'>
        <span stlyle="">Profile</span>
    </a>

    <?php $url = $this->url->create('questions/new'); ?>
    <a href='<?=$url?>' class='ask-button right'>
        <span>ASK A QUESTION</span>
    </a>
<?php else: ?>
    <?php $url = $this->url->create('users/login'); ?>
    <a href='<?=$url?>' class='ask-button right'>
        <span>LOGIN</span>
    </a>
<?php endif; ?>
</span>
<span class='siteslogan'><?=$siteTagline?></span>