<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>
	
	<h1>
		<a href="/gtd/tasks/delete/<?php echo $task['id']; ?>" class="delete"><input type="checkbox"></a>		
		<input class="inline-edit heading" type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>">
	</h1>
	
	<aside class="context-actions">

		<?php echo $template['partials']['contexts']; ?>
		
		<input class="date" type="hidden" name="due" id="due" value="<?php if (isset($task['due'])) echo date('Y-m-d', strtotime($task['due'])); ?>">
		<div id="datepicker"></div>

	</aside>
	
	<p><textarea name="notes" rows="20" class="inline-edit" placeholder="Add task notes"><?php echo $task['notes']; ?></textarea></p>
	
	<div class="buttons">
		<button type="submit" class="btn save">Save Changes</button>
	</div>

</form>
