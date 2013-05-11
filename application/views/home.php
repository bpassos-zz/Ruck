<h1>Next Actions</h1>

<aside class="contexts">
	<?php echo $template['partials']['contexts']; ?>
</aside>

<ul class="tasks next">
	<?php foreach ($next_tasks as $task): ?>
		<li data-context-id="<?php echo $task->context_id; ?>">
<!--
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete"><input type="checkbox"></a>
-->
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
