<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>

	<h1>
		<?php echo form_input(array(
			'name'			=> 'description',
			'id'			=> 'description',
			'value'			=> set_value('description'),
			'maxlength'		=> 255,
			'size'			=> 50,
			'autofocus'		=> 'autofocus',
			'placeholder'	=> 'Enter a brief description of this single task',
		)); ?>
	</h1>

	<p>
		<?php echo form_textarea(array(
			'name'			=> 'notes',
			'id'			=> 'notes',
			'value'			=> set_value('notes'),
			'placeholder'	=> '(optional) Enter the details of this task and any other notes or discussion you need to refer to later.',
		)); ?>
	</p>

	<div class="buttons">
		<button class="btn new-task" type="submit">Save new note</button>
	</div>

</form>
