<?php echo validation_errors('<div class="error">', '</div>'); ?>

<form method="post" action="">
	<fieldset>
		<legend>Create a new task</legend>
		<ol>
			<li>
				<label for="description">Task description</label>
				<?php echo form_input(array(
					'name'		=> 'description',
					'id'		=> 'description',
					'value'		=> set_value('description'),
					'maxlength'	=> 255,
				)); ?>
			</li>
			<li>
				<label for="notes">Task notes</label>
				<?php echo form_textarea(array(
					'name'		=> 'notes',
					'id'		=> 'notes',
					'value'		=> set_value('notes'),
				)); ?>
			</li>
			<li>
				<label for="status_id">Status</label>
				<?php echo form_dropdown('status_id', $statuses, '0', 'id="status_id"'); ?>
			</li>
			<li>
				<label for="context_id">Context</label>
				<?php echo form_dropdown('context_id', $contexts, '0', 'id="context_id"'); ?>
			</li>
			<li>
				<label for="project_id">Project</label>
				<?php echo form_dropdown('project_id', $projects, $project_id, 'id="project_id"'); ?>
			</li>
		</ol>
	</fieldset>
	<div class="actions">
		<button class="btn primary" type="submit">Create new task</button>
	</div>
</form>
