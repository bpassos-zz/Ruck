<?php echo validation_errors('<div class="error">', '</div>'); ?>

<form method="post" action="">
	<fieldset>
		<legend>Create a new project</legend>
		<ol>
			<li>
				<label for="name">Project name</label>
				<?php echo form_input(array(
					'name'		=> 'name',
					'id'		=> 'name',
					'value'		=> set_value('name'),
					'maxlength'	=> 100,
					'autofocus'	=> 'autofocus',
				)); ?>
			</li>
			<li>
				<label for="description">Project description</label>
				<?php echo form_input(array(
					'name'		=> 'description',
					'id'		=> 'description',
					'value'		=> set_value('description'),
					'maxlength'	=> 255,
				)); ?>
			</li>
			<li>
				<label for="status_id">Status</label>
				<?php echo form_dropdown('status_id', $statuses, '3', 'id="status_id"'); ?>
			</li>
			<li>
				<label for="parent_project_id">Parent project</label>
				<?php echo form_dropdown('parent_project_id', $projects, '0', 'id="parent_project_id"'); ?>
			</li>
		</ol>
	</fieldset>
	<div class="actions">
		<button type="submit">Create new project</button>
	</div>
</form>
