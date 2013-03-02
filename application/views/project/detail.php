<?php echo validation_errors('<div class="error">', '</div>'); ?>

<h1><input class="inline-edit" type="text" name="name" value="<?php echo htmlspecialchars($project['name']); ?>"></h1>

<aside class="context-actions">

	<p><textarea name="description" rows="2" class="inline-edit" placeholder="Enter a project description"><?php echo $project['description']; ?></textarea></p>

	<?php echo $template['partials']['contexts']; ?>

	<div class="buttons">
		<?php if ($project['status_id'] == 3): ?>
			<a href="/gtd/projects/deactivate/<?php echo $project['id']; ?>" class="btn inactive">Mark as inactive</a>
		<?php else: ?>
			<a href="/gtd/projects/activate/<?php echo $project['id']; ?>" class="btn active">Mark as active</a>
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
				<a href="/gtd/tasks/detail/<?php echo $task->id; ?>" class="pill date"><?php echo date('F j', strtotime($task->due)); ?></a>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

<div class="buttons">
	<a href="/gtd/tasks/create/<?php echo $project['id']; ?>" class="btn add" id="add"><u>N</u>ew task</a>
	<a href="/gtd/projects/create/<?php echo $project['id']; ?>" class="btn new" id="new-child-project">New <u>S</u>ub-Project</a>
</div>

<?php if (isset($child_projects)): ?>

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
	
<?php endif; ?>
