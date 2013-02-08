<ul id="contexts">
	<?php foreach ($context_list as $context): ?>
		<li><a href="/gtd/context/<?php echo $context->id; ?>"><?php echo $context->name; ?></a></li>
	<?php endforeach; ?>
</ul>
