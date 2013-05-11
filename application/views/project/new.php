<h1>Create a new Project</h1>

<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>
	<fieldset>
		<legend>Create a new project</legend>
		<ol>
			<li>
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
			<li>
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
			<li class="horizontal">
				<label for="status_id">Someday/Maybe?</label>
				<?php echo form_hidden('someday_maybe', 0); ?>
				<ul class="form-options">
					<li><a href="#" data-value="1" data-field="someday_maybe">Yes</a></li>
					<li><a href="#" data-value="0" data-field="someday_maybe" class="selected">No</a></li>
				</ul>
			</li>
			<li class="concealed">
				<label for="parent_project_id">Parent project:</label>
				<a href="#parent_project_id">Select a parent project</a>
				<?php echo form_dropdown('parent_project_id', $projects, $parent_project_id, 'id="parent_project_id"'); ?>
			</li>
		</ol>
	</fieldset>
	<div class="buttons">
		<button class="btn new-project" type="submit">Create new project</button>
	</div>
</form>
