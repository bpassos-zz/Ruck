<h1>Home</h1>

<p>Welcome to Ruck. These are the <b>Next</b> tasks in all of your active projects:</p>

<ul>
	<?php foreach ($next_tasks as $task): ?>
		<li><a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a></li>
	<?php endforeach; ?>
</ul>
