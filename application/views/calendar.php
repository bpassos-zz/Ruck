<h1>Due Today</h1>

<?php if (count($today) > 0): ?>
	
	<ul class="tasks">
		<?php foreach ($today as $task): ?>
			<li data-context-id="<?php echo $task->context_id; ?>">
				<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete">&#10004;</a>
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="task"><?php echo $task->description; ?></a>
				<?php if ($task->due): ?>
					<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>"><?php echo date('F j', strtotime($task->due)); ?></a>
					<?php if ($task->recurs): ?>
						<img src="/i/recurs.png" alt="Recurs">
					<?php endif; ?>
				<?php endif; ?>
				<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>

<?php else: ?>

	<p>You have no tasks due today.</p>	

<?php endif; ?>

<?php if (count($tomorrow) > 0): ?>
	
	<h1>Due Tomorrow</h1>
	
	<ul class="tasks">
		<?php foreach ($tomorrow as $task): ?>
			<li data-context-id="<?php echo $task->context_id; ?>">
				<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete">&#10004;</a>
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="task"><?php echo $task->description; ?></a>
				<?php if ($task->due): ?>
					<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>"><?php echo date('F j', strtotime($task->due)); ?></a>
					<?php if ($task->recurs): ?>
						<img src="/i/recurs.png" alt="Recurs">
					<?php endif; ?>
				<?php endif; ?>
				<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>

<?php endif; ?>

<?php if (count($overdue) > 0): ?>
	
	<h1>Overdue Tasks</h1>
	
	<ul class="tasks">
		<?php foreach ($overdue as $task): ?>
			<li data-context-id="<?php echo $task->context_id; ?>">
				<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete">&#10004;</a>
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="task"><?php echo $task->description; ?></a>
				<?php if ($task->due): ?>
					<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>"><?php echo date('F j', strtotime($task->due)); ?></a>
					<?php if ($task->recurs): ?>
						<img src="/i/recurs.png" alt="Recurs">
					<?php endif; ?>
				<?php endif; ?>
				<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>

<?php endif; ?>
