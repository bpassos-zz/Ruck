<p>
	<?php foreach ($parent_projects as $parent_project): ?>
		<a href="/gtd/projects/<?php echo $parent_project->id; ?>"><?php echo $parent_project->name; ?></a>
		 &raquo;
	<?php endforeach; ?>
</p>

<?php echo validation_errors('<div class="error">', '</div>'); ?>

<form method="post">
	
	<input class="inline-edit heading" type="text" name="name" value="<?php echo htmlspecialchars($project['name']); ?>">

	<textarea name="description" rows="2" class="inline-edit" placeholder="Enter a project description"><?php echo $project['description']; ?></textarea>

	<div class="form-actions">
		<button type="submit" class="btn primary">Save Changes</button>
		<?php if ($project['status_id'] == 3): ?>
			<a href="/gtd/projects/deactivate/<?php echo $project['id']; ?>" class="btn">Mark as inactive</a>
		<?php else: ?>
			<a href="/gtd/projects/activate/<?php echo $project['id']; ?>" class="btn">Mark as active</a>
		<?php endif; ?>
		<a href="/gtd/projects/delete/<?php echo $project['id']; ?>" class="btn">Delete this project</a>
	</div>

</form>

<ul class="tasks sortable">
	<?php foreach ($tasks as $task): ?>
		<li id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="delete mini">Delete</a>
		</li>
	<?php endforeach; ?>
</ul>

<p>[+] <a href="/gtd/tasks/create/<?php echo $project['id']; ?>">Add new task</a></p>

<?php if (isset($child_projects)): ?>

	<h2>Sub Projects</h2>
	
	<?php foreach ($child_projects as $project): ?>
		<a href="/gtd/projects/<?php echo $project->id; ?>">
			<div class="child-project">
				<h3><?php echo $project->name; ?></h3>
				<?php if ($project->tasks): ?>
					<ul>
						<?php foreach ($project->tasks as $task): ?>
							<li id="<?php echo $task->id; ?>" data-context-id="<?php echo $task->context_id; ?>">
								<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a> 
								<a href="/gtd/tasks/delete/<?php echo $task->id; ?>" class="delete mini">Delete</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</a>
	<?php endforeach; ?>
	
<?php endif; ?>
