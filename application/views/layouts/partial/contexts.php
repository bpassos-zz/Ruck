<h2>Contexts:</h2>	
<ul>
	<?php foreach ($context_list as $context): ?>
		<li data-context-id="<?php echo $context->id; ?>">
			<a href="#" class="context pill"><?php echo $context->name; ?></a>
		</li>
	<?php endforeach; ?>
</ul>

<a href="/gtd/contexts">+</a>