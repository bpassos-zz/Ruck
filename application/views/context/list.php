<h1><?php echo $context['name']; ?> <a href="/gtd/contexts/delete/<?php echo $context['id']; ?>" class="mini">Delete this context</a></h1>

<p><?php echo $context['description']; ?></p>

<ul class="tasks">
	<?php foreach ($tasks as $task): ?>
		<li data-context-id="<?php echo $task->context_id; ?>">
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="mini">Delete</a>
		</li>
	<?php endforeach; ?>
</ul>
