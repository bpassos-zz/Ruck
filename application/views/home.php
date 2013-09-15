<h1>Next Actions</h1>

<aside class="contexts">
	<?php echo $template['partials']['contexts']; ?>
</aside>

<ul class="tasks next">
	<?php foreach ($next_tasks as $task): ?>
		<li data-context-id="<?php echo $task->context_id; ?>">
			<a href="/gtd/tasks/complete/<?php echo $task->id; ?>/home" class="complete"><input type="checkbox"></a>
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="task" title="<?php echo htmlspecialchars($task->notes); ?>"><?php echo $task->description; ?></a>
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

<h1>Completed Tasks</h1>

<ul class="tasks completed">
	<?php foreach ($completed_tasks as $task): ?>
		<li<?php if ($task->due) echo ' class="has-date"'; ?> id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
			<?php if ($task->due): ?>
				<span class="date">
					<strong><?php echo date("j", strtotime($task->due)); ?></strong>
					<?php echo date("M", strtotime($task->due)); ?>
				</span>
			<?php endif; ?>
			<a href="/gtd/tasks/uncomplete/<?php echo $task->id; ?>/home" class="uncomplete"><input type="checkbox" checked="checked"></a>
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="task"><?php echo $task->description; ?></a>
			<?php if ($task->recurs): ?>
				<img src="/i/recurs.png" alt="Recurs">
			<?php endif; ?>
			<?php if ($task->waiting_for == 1): ?>
				<img src="/i/waiting_for.png" alt="Waiting for someone else">
			<?php endif; ?>
			<span class="context"><?php echo $task->context_name; ?></span>
		</li>
	<?php endforeach; ?>
</ul>
