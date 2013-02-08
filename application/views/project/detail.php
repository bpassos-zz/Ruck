<h1><?php echo $project['name']; ?></h1>

<p><?php echo $project['description']; ?></p>

<p><a href="/gtd/tasks/create/<?php echo $project['id']; ?>">Add new task</a> | <a href="/gtd/projects/delete/<?php echo $project['id']; ?>">Delete this project</a></p>

<ul class="task-list sortable">
	<?php foreach ($tasks as $task): ?>
		<li id="<?php echo $task->id; ?>"><a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> <a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="mini">Delete</a></li>
	<?php endforeach; ?>
</ul>
