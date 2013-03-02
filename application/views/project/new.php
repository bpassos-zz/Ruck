<h1>Create a new Project</h1>

<?php echo validation_errors('<div class="error">', '</div>'); ?>

<form method="post">
	<fieldset>
		<legend>Create a new project</legend>
		<ol>
			<li class="no-label">
				<label for="name">Project name</label>
				<?php echo form_input(array(
					'name'			=> 'name',
					'id'			=> 'name',
					'value'			=> set_value('name'),
					'maxlength'		=> 100,
					'size'			=> 50,
					'autofocus'		=> 'autofocus',
					'placeholder'	=> 'Enter a short but memorable project name', 
				)); ?>
			</li>
			<li class="no-label">
				<label for="description">Project description</label>
				<?php echo form_input(array(
					'name'			=> 'description',
					'id'			=> 'description',
					'value'			=> set_value('description'),
					'maxlength'		=> 255,
					'size'			=> 50,
					'placeholder'	=> 'Enter a short description of this project', 
				)); ?>
			</li>
			<li>
				<label for="status_id">Status:</label>
				<?php echo form_dropdown('status_id', $statuses, '3', 'id="status_id"'); ?>
			</li>
			<li>
				<label for="parent_project_id">Parent project:</label>
				<?php echo form_dropdown('parent_project_id', $projects, $parent_project_id, 'id="parent_project_id"'); ?>
			</li>
		</ol>
	</fieldset>
	<div class="buttons">
		<button class="btn add" type="submit">Create new project</button>
	</div>
</form>
