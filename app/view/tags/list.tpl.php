<h1><?=$title?></h1>

<?php if(!empty($tags)) : ?>

    <?php foreach($tags as $tag): ?>
        <p>
            <a class="tag" href="<?=$this->url->create('tags/tag/' . $tag->text)?>">
                #<?=$tag->text?>
            </a><span class='tag-uses'> x <?=$tag->uses?></span>
        </p>
    <?php endforeach; ?>

<?php else : ?>

    <p>No tags found</p>

<?php endif; ?>