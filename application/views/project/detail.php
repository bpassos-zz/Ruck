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
		
	<h1 class="inline-edit"><?php echo $project['name']; ?> <span class="edit">Edit</span></h1>
	<input class="inline-edit" type="text" name="name" value="<?php echo htmlspecialchars($project['name']); ?>">
			
	<p class="description inline-edit"><?php echo $project['description']; ?></p>
	<textarea name="description" rows="2" class="inline-edit" placeholder="Enter a project description"><?php echo $project['description']; ?></textarea>
	
	<ul class="tasks sortable">
		<?php foreach ($tasks as $task): ?>
			<li<?php if ($task->due) echo ' class="has-date"'; ?> id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
				<?php if ($task->due): ?>
					<span class="date">
						<strong><?php echo date("j", strtotime($task->due)); ?></strong>
						<?php echo date("M", strtotime($task->due)); ?>
					</span>
				<?php endif; ?>
				<a href="/gtd/tasks/complete/<?php echo $task->id; ?>" class="complete"><input type="checkbox"></a>
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="task" title="<?php echo htmlspecialchars($task->notes); ?>"><?php echo $task->description; ?></a>
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
			
</form>
		
<div class="buttons">
	<a href="/gtd/tasks/create/<?php echo $project['id']; ?>" class="btn new-task" id="add"><u>N</u>ew task</a>
	<?php if ($project['someday_maybe'] == 0): ?>
		<a href="/gtd/projects/deactivate/<?php echo $project['id']; ?>" class="btn inactive someday-maybe">Move to Someday/Maybe</a>
	<?php else: ?>
		<a href="/gtd/projects/activate/<?php echo $project['id']; ?>" class="btn active someday-maybe">Make this project active</a>
	<?php endif; ?>
	<a href="/gtd/projects/create/<?php echo $project['id']; ?>" class="btn new-project" id="new-child-project">New <u>S</u>ub-Project</a>
	<a href="/gtd/projects/delete/<?php echo $project['id']; ?>" class="btn delete-project">Delete this project</a>
</div>
		
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
			<a href="/gtd/tasks/uncomplete/<?php echo $task->id; ?>" class="uncomplete"><input type="checkbox" checked="checked"></a>
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

<?php if (isset($child_projects)): ?>

	<div class="sub-projects">
		
		<h1 class="sub">Sub Projects</h1>
		
		<?php foreach ($child_projects as $project): ?>
			<?php if ($project->tasks): ?>
				<ul class="tasks">
					<?php foreach ($project->tasks as $task): ?>
						<li id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
							<a href="/gtd/tasks/complete/<?php echo $task->id; ?>" class="complete"<input type="checkbox"></a>
							<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
							<a href="/gtd/projects/<?php echo $project->id; ?>" class="project" title="<?php echo $project->name; ?>"><?php echo character_limiter($project->name, 20); ?></a>
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
