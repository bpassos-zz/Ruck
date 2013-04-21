<?php if (count($upcoming) > 0): ?>

	<div class="block calendar">

		<div class="heading">
			Calendar
		</div>

		<div class="content">
		
			<?php foreach ($upcoming as $task): ?>
				<div class="calendar-item">
					<a href="/gtd/tasks/detail/<?php echo $task->id; ?>">
						<strong><?php echo $task->due; ?></strong>
						<br>
						<?php echo character_limiter($task->description, 20); ?>
					</a>
				</div>
			<?php endforeach; ?>
		
		</div>

	</div>

<?php endif; ?>

<div class="block next-actions">

	<div class="heading">
		Next Actions
	</div>

	<div class="content">

		<aside class="contexts">
			<?php echo $template['partials']['contexts']; ?>
		</aside>

		<ul class="tasks next">
			<?php foreach ($next_tasks as $task): ?>
				<li data-context-id="<?php echo $task->context_id; ?>">
					<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete"><input type="checkbox"></a>
					<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
					<?php if ($task->due): ?>
						<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>"><?php echo date('F j', strtotime($task->due)); ?></a>
						<?php if ($task->recurs): ?>
							<img src="/i/recurs.png" alt="Recurs">
						<?php endif; ?>
					<?php endif; ?>
					<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="pill project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>

	</div>

</div>
