<h1>Home</h1>

<p>Welcome to <em style="font: bold italic 18px serif;">Ruck</em>. These are the <b>Next</b> tasks in all of your active projects:</p>

<ul class="tasks">
	<?php foreach ($next_tasks as $task): ?>
		<li data-context-id="<?php echo $task->context_id; ?>">
			<a href="/gtd/projects/<?php echo $task->project_id; ?>" style="font-size: 10px; margin-bottom: -20px;"><?php echo $task->project_name; ?> &raquo;</a>
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete mini">Delete</a>
			</li>
	<?php endforeach; ?>
</ul>
