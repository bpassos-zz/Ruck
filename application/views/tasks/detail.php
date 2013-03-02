<?php echo validation_errors('<div class="error">', '</div>'); ?>

<form method="post">
	
	<h1>
		<a href="/gtd/tasks/delete/<?php echo $task['id']; ?>" class="delete"><input type="checkbox"></a>		
		<input class="inline-edit heading" type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>">
	</h1>
	
	<aside class="context-actions">
		<?php echo $template['partials']['contexts']; ?>
	</aside>
	
	<p><textarea name="notes" rows="20" class="inline-edit" placeholder="Add task notes"><?php echo $task['notes']; ?></textarea></p>
	
	<div class="buttons">
		<button type="submit" class="btn save">Save Changes</button>
	</div>

</form>
