<article class='article1'>
<h1><?=$title?></h1>

<?=$content?>

<?php if(isset($byline)) : ?>
	<footer class='byline'>
	<?=$byline?>
	</footer>
<?php endif; ?>

</article>