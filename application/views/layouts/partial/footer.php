<?php if (isset($links[0])): ?>
	<a class="footer-previous" href="<?php echo $links[0]['url']; ?>" title="<?php echo $links[0]['text']; ?>"><?php echo character_limiter($links[0]['text'], 20); ?></a>
<?php endif; ?>

<div class="arrow-keys">
	<?php if (isset($links[0])): ?>
		<a href="<?php echo $links[0]['url']; ?>" id="left-arrow">&larr;</a>
	<?php else: ?>
		<a href="#" class="disabled" id="left-arrow">&larr;</a>
	<?php endif; ?>
	<?php if (isset($links[2])): ?>
		<a href="<?php echo $links[2]['url']; ?>" id="up-arrow">&uarr;</a>
	<?php else: ?>
		<a href="#" class="disabled" id="up-arrow">&uarr;</a>
	<?php endif; ?>
	<?php if (isset($links[1])): ?>
		<a href="<?php echo $links[1]['url']; ?>" id="right-arrow">&rarr;</a>
	<?php else: ?>
		<a href="#" class="disabled" id="right-arrow">&rarr;</a>
	<?php endif; ?>
</div>

<?php if (isset($links[1])): ?>
	<a class="footer-next" href="<?php echo $links[1]['url']; ?>" title="<?php echo $links[1]['text']; ?>"><?php echo character_limiter($links[1]['text'], 20); ?></a>
<?php endif; ?>