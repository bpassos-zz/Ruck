<ul id="contexts">
	<?php foreach ($context_list as $context): ?>
		<li data-context-id="<?php echo $context->id; ?>"><a href="#" class="context"><?php echo $context->name; ?></a></li>
	<?php endforeach; ?>
	<li><a href="/gtd/contexts/create">+New</a></li>
</ul>
