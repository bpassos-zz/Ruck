<ul>
	<?php foreach ($context_list as $context): ?>
		<li data-context-id="<?php echo $context->id; ?>">
			<a href="#" class="context"><?php echo $context->name; ?></a>
		</li>
	<?php endforeach; ?>
</ul>
