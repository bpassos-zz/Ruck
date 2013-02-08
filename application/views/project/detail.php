<h1>
	<?php echo $project['name']; ?> 
	<?php if ($project['status_id'] == 3): ?>
		<a href="/gtd/projects/deactivate/<?php echo $project['id']; ?>" class="mini">Mark as inactive</a>
	<?php else: ?>
		<a href="/gtd/projects/activate/<?php echo $project['id']; ?>" class="mini">Mark as active</a>
	<?php endif; ?>
	<a href="/gtd/projects/delete/<?php echo $project['id']; ?>" class="mini">Delete this project</a>
</h1>

<p><?php echo $project['description']; ?></p>

<ul class="task-list sortable">
	<?php foreach ($tasks as $task): ?>
		<li id="<?php echo $task->id; ?>">
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="mini">Delete</a>
		</li>
	<?php endforeach; ?>
</ul>

<p><a href="/gtd/tasks/create/<?php echo $project['id']; ?>">Add new task</a></p>
