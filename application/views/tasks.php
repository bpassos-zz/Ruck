<h1><?php echo $project['name']; ?></h1>

<p><?php echo $project['description']; ?></p>

<ul>
	<?php foreach ($tasks as $task): ?>
		<li><a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a></li>
	<?php endforeach; ?>
</ul>
