<h1>New Task</h1>
		
<?php echo validation_errors('<div class="error">', '</div>'); ?>
		
<?php echo form_open(); ?>
	<fieldset>
		<legend>Create a new project</legend>
		<ol>
			<li>
				<label for="name">Task description</label>
				<?php echo form_input(array(
					'name'			=> 'description',
					'id'			=> 'description',
					'value'			=> set_value('description'),
					'maxlength'		=> 255,
					'size'			=> 50,
					'autofocus'		=> 'autofocus',
					'placeholder'	=> 'Enter a brief description of this single task',
				)); ?>
			</li>
			<li>
				<label for="notes">Task notes</label>
				<?php echo form_textarea(array(
					'name'			=> 'notes',
					'id'			=> 'notes',
					'value'			=> set_value('notes'),
					'placeholder'	=> '(optional) Enter the details of this task and any other notes or discussion you need to refer to later.',
				)); ?>
			</li>
			</li>
			<li class="concealed">
				<label for="due">Due date:</label>
				<a href="#" class="overlay-show">Click to set a due date</a>
				<input type="hidden" name="due" id="due" value="<?php echo set_value('due'); ?>">
				<a href="#" class="overlay-clear">Clear selected date</a>
			</li>
			<li class="horizontal">
				<label for="recurs">This task recurs:</label>
				<?php echo form_hidden('recurs', 0); ?>
				<ul class="form-options">
					<?php foreach ($recurring_labels as $id => $name): ?>
						<li><a href="#" data-value="<?php echo $id; ?>" data-field="recurs"><?php echo $name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="horizontal">
				<label for="status_id">Status:</label>
				<?php echo form_hidden('status_id', 0); ?>
				<ul class="form-options">
					<?php foreach ($statuses as $id=>$name): ?>
						<li><a href="#" data-value="<?php echo $id; ?>" data-field="status_id"<?php if ($id == 1) echo ' class="selected"'; ?>><?php echo $name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="horizontal">
				<label for="context_id">Context:</label>
				<?php echo form_hidden('context_id', 0); ?>
				<ul class="form-options">
					<?php foreach ($contexts as $id => $name): ?>
						<li><a href="#" data-value="<?php echo $id; ?>" data-field="context_id"<?php if ($id == $default_context) echo ' class="selected"'; ?>><?php echo $name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li>
				<label for="project_id">Project:</label>
				<?php echo form_dropdown('project_id', $projects, $project_id, 'id="project_id"'); ?>
			</li>
		</ol>

	</fieldset>
		
	<div class="buttons">
		<button class="btn new-task" type="submit">Create new task</button>
	</div>
		
</form>

<div class="overlay">
	<a href="#" class="overlay-close">&times;</a>
	<div id="datepicker"></div>
</div>
