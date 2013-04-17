<h1>Your Contexts</h1>
	
<p>Add, delete or edit your Contexts.</p>

<ul class="tasks">
	<?php foreach ($contexts as $context): ?>
		<li>
			<a href="/gtd/contexts/edit/<?php echo $context->id; ?>"><?php echo $context->name; ?></a>
			<a href="/gtd/contexts/delete/<?php echo $context->id; ?>" class="pill">Delete</a>
		</li>
	<?php endforeach; ?>
</ul>

<div class="buttons">
	<a href="/gtd/contexts/create" class="btn add" id="add">Create new context</a>
</div>
