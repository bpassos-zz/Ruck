<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>
	
	<h1>
		<a href="/gtd/tasks/delete/<?php echo $task['id']; ?>" class="delete"><input type="checkbox"></a>		
		<input class="inline-edit heading" type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>">
	</h1>
	
	<aside class="context-actions">

		<?php echo $template['partials']['contexts']; ?>

		<input class="date" type="text" name="due" id="due" value="" data-due="<?php if (isset($task['due'])) echo date('m/d/Y', strtotime($task['due'])); ?>">
		<div id="datepicker"></div>

	</aside>
	
	<p><textarea name="notes" rows="20" class="inline-edit" placeholder="Add task notes"><?php echo $task['notes']; ?></textarea></p>
	
	<label for="status_id">Status:</label>
	<?php echo form_dropdown('status_id', $statuses, $task['status_id'], 'id="status_id"'); ?>

	<label for="context_id">Context:</label>
	<?php echo form_dropdown('context_id', $contexts, $task['context_id'], 'id="context_id"'); ?>

	<label for="project_id">Project:</label>
	<?php echo form_dropdown('project_id', $projects, $task['project_id'], 'id="project_id"'); ?>

	<div class="buttons">
		<button type="submit" class="btn save">Save Changes</button>
	</div>

</form>
