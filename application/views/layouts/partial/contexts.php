<nav class="contexts">
	<h2>Contexts</h2>	
	<ul>
		<?php foreach ($context_list as $context): ?>
			<li data-context-id="<?php echo $context->id; ?>">
				<a href="#" class="pill context"><?php echo $context->name; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<a href="/gtd/contexts"><small>Edit</small></a>