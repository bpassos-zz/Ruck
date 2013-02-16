<?php echo validation_errors('<div class="error">', '</div>'); ?>

<p><a href="/gtd/projects/<?php echo $project['id']; ?>"><?php echo $project['name']; ?></a> &rarr;</p>

<form method="post">
	
	<input class="inline-edit heading" type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>">

	<textarea name="notes" rows="20" class="inline-edit" placeholder="Add task notes"><?php echo $task['notes']; ?></textarea>

	<div class="form-actions">
		<button type="submit" class="btn primary">Save Changes</button>
		<a class="btn" href="/gtd/tasks/delete/<?php echo $task['id']; ?>">Delete this task</a>		
	</div>

</form>
