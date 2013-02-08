<h1><?php echo $project['name']; ?></h1>

<ul>
	<?php foreach ($tasks as $task): ?>
		<li><a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a></li>
	<?php endforeach; ?>
</ul>
