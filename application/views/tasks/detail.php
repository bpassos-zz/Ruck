<?php echo validation_errors('<div class="error">', '</div>'); ?>

<h1><input class="inline-edit heading" type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>"></h1>

<aside class="context-actions">

	<?php echo $template['partials']['contexts']; ?>

	<div class="buttons">
		<a class="btn" href="/gtd/tasks/delete/<?php echo $task['id']; ?>">Delete this task</a>		
	</div>

</aside>

<p><textarea name="notes" rows="20" class="inline-edit" placeholder="Add task notes"><?php echo $task['notes']; ?></textarea></p>

<div class="buttons">
	<button type="submit" class="btn save">Save Changes</button>
</div>
