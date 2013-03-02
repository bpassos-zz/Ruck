<?php if (isset($links[0])): ?>
	<a class="footer-previous" href="<?php echo $links[0]['url']; ?>"><?php echo $links[0]['text']; ?></a>
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
	<a class="footer-next" href="<?php echo $links[1]['url']; ?>"><?php echo $links[1]['text']; ?></a>
<?php endif; ?>