<?php if (isset($links[0])): ?>
	<a class="footer-previous" href="<?php echo $links[0]['url']; ?>"><?php echo $links[0]['text']; ?></div>
<?php endif; ?>

<?php if (isset($links[1])): ?>
	<a class="footer-next" href="<?php echo $links[1]['url']; ?>"><?php echo $links[1]['text']; ?></div>
<?php endif; ?>