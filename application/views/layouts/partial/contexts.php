<ul id="contexts">
	<?php foreach ($context_list as $context): ?>
		<li><a href="#" data-context-id="<?php echo $context->id; ?>" class="context"><?php echo $context->name; ?></a></li>
	<?php endforeach; ?>
	<li><a href="/gtd/contexts/create">+New</a></li>
</ul>
