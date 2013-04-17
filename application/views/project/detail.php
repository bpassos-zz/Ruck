<?php
$created_at = new DateTime($project['created_at']);
$now = new DateTime(date('Y-m-d'));
$diff = $created_at->diff($now);
if ($diff->y)
{
	$datestamp = $diff->format('%y years, %m months, %d days');
}
else if ($diff->m)
{
	$datestamp = $diff->format('%m months, %d days');
}
else
{
	$datestamp = $diff->format('%d days');
}
?>

<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>

	<h1><input class="inline-edit" type="text" name="name" value="<?php echo htmlspecialchars($project['name']); ?>"></h1>

	<aside class="context-actions">
	
		<p><textarea name="description" rows="2" class="inline-edit" placeholder="Enter a project description"><?php echo $project['description']; ?></textarea></p>
		
		<button type="submit" class="btn save">Save</button>

		<?php echo $template['partials']['contexts']; ?>
	
		<div class="buttons">
			<?php if ($project['someday_maybe'] == 0): ?>
				<a href="/gtd/projects/deactivate/<?php echo $project['id']; ?>" class="btn inactive">Move to Someday/Maybe</a>
			<?php else: ?>
				<a href="/gtd/projects/activate/<?php echo $project['id']; ?>" class="btn active">Make this project active</a>
			<?php endif; ?>
			<br>
			<br>
			<a href="/gtd/projects/delete/<?php echo $project['id']; ?>" class="btn delete">Delete this project</a>
		</div>
	

	</aside>
	
	<ul class="tasks sortable">
		<?php foreach ($tasks as $task): ?>
			<li id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
				<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="delete"><input type="checkbox"></a>
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
				<?php if ($task->due): ?>
					<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill <?php echo (strtotime($task->due) + 86400 > time()) ? 'date' : 'overdue'; ?>">
						<?php echo date('F j', strtotime($task->due)); ?>
					</a>
					<?php if ($task->recurs): ?>
						<img src="/i/recurs.png" alt="Recurs">
					<?php endif; ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	
</form>

<div class="buttons">
	<a href="/gtd/tasks/create/<?php echo $project['id']; ?>" class="btn add" id="add"><u>N</u>ew task</a>
	<a href="/gtd/projects/create/<?php echo $project['id']; ?>" class="btn new" id="new-child-project">New <u>S</u>ub-Project</a>
</div>

<?php if (isset($child_projects)): ?>

	<div class="sub-projects">
		
		<h1 class="sub">Sub Projects</h1>
		
		<?php foreach ($child_projects as $project): ?>
			<?php if ($project->tasks): ?>
				<ul class="tasks">
					<?php foreach ($project->tasks as $task): ?>
						<li id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
							<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="delete"><input type="checkbox"></a>
							<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
							<a href="/gtd/projects/<?php echo $project->id; ?>" class="pill project" title="<?php echo $project->name; ?>"><?php echo character_limiter($project->name, 20); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php endforeach; ?>
	
	</div>

<?php endif; ?>

<p class="datestamp"><?php echo $datestamp; ?></p>

<script>
	var csrf = {
		token_name: '<?php echo $this->security->get_csrf_token_name(); ?>',
		hash: '<?php echo $this->security->get_csrf_hash(); ?>'
	};
</script>
