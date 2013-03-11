<h1>Your Next Tasks</h1>

<aside class="context-actions">
	<?php echo $template['partials']['contexts']; ?>
</aside>

<ul class="tasks next">
	<?php foreach ($next_tasks as $task): ?>
		<li data-context-id="<?php echo $task->context_id; ?>">
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home" class="delete"><input type="checkbox"></a>
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
			<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="pill project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
			<?php if ($task->due): ?>
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>"><?php echo date('F j', strtotime($task->due)); ?></a>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

<?php if (count($upcoming) > 0): ?>

	<h1 class="upcoming-header">Upcoming Due Dates</h1>

	<table class="calendar">
		<thead>
			<tr>
				<?php if (date('t') - date('j') > 14): ?>
					<th colspan="14"><?php echo date('M'); ?></th>
				<?php else: ?>
					<th colspan="<?php echo date('t') - date('j') + 1; ?>"><?php echo date('M'); ?></th>
					<th colspan="<?php echo 13 - date('t') + date('j'); ?>"><?php echo date('M', time() + (60 * 60 * 24 * 14)); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php $cell = 0; $offset = 110; while ($cell < 14): ?>
					<?php $position = 50; ?>
					<td<?php if (date('w', time() + (60 * 60 * 24 * $cell)) == 0 || date('w', time() + (60 * 60 * 24 * $cell)) == 6) echo ' class="weekend"'; ?>>
						<?php echo date('j', time() + (60 * 60 * 24 * $cell)) ?>
						<?php foreach ($upcoming as $task): ?>
							<?php if (date('Y-m-d', strtotime($task->due)) === date('Y-m-d', time() + (60 * 60 * 24 * $cell))): ?>
								<div class="upcoming" style="background-position: <?php echo $position; ?>% 0; height: <?php echo $offset; ?>px; z-index: <?php echo 14 - $cell; ?>;">
									<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>" style="margin-left: -<?php echo $position - 50; ?>%;">
										<?php echo character_limiter($task->description, 20); ?>
									</a>
								</div>
								<?php $offset = ($offset <= 50) ? 170 : $offset - 30; ?>
								<?php $position = ($position >= 100) ? 25 : $position + 25; ?>
							<?php endif ?>
						<?php endforeach; ?>
					</td>
					<?php $cell++; ?>
				<?php endwhile; ?>
			</tr>
		</tbody>
	</table>

<?php endif; ?>
