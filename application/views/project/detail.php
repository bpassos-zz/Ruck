<p>
	<?php foreach ($parent_projects as $parent_project): ?>
		<a href="/gtd/projects/<?php echo $parent_project->id; ?>"><?php echo $parent_project->name; ?></a>
		 &raquo;
	<?php endforeach; ?>
</p>

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
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="delete mini"><input type="checkbox"></a>
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
		</li>
	<?php endforeach; ?>
</ul>

<div class="buttons">
	<a href="/gtd/tasks/create/<?php echo $project['id']; ?>" class="btn add">Add new task</a>
</div>

<?php if (isset($child_projects)): ?>

	<h1>Sub Projects</h1>
	
	<?php foreach ($child_projects as $project): ?>
		<a href="/gtd/projects/<?php echo $project->id; ?>">
			<div class="child-project">
				<h3><?php echo $project->name; ?></h3>
				<?php if ($project->tasks): ?>
					<ul class="tasks">
						<?php foreach ($project->tasks as $task): ?>
							<li id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
								<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="delete mini"><input type="checkbox"></a>
								<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</a>
	<?php endforeach; ?>
	
<?php endif; ?>
