<h1>Calendar</h1>

<?php if (count($upcoming) > 0): ?>
	
	<?php foreach ($upcoming as $task): ?>
		<div class="calendar-item">
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>">
				<strong class="date"><?php echo date('M j', strtotime($task->due)); ?></strong>
				<br>
				<?php echo character_limiter($task->description, 20); ?>
			</a>
			<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="pill project calendar-project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
		</div>
	<?php endforeach; ?>

<?php else: ?>

	<p>You have no tasks due today.</p>	

<?php endif; ?>
