<ul id="contexts">
	<?php foreach ($context_list as $context): ?>
		<li><a href="/gtd/contexts/<?php echo $context->id; ?>"><?php echo $context->name; ?></a></li>
	<?php endforeach; ?>
	<li><a href="/gtd/contexts/create">+New</a></li>
</ul>
