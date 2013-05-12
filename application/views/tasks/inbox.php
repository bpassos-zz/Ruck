<h1>Quick Capture</h1>

<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>

	<fieldset>
		<legend>Quick Task Capture</legend>
		<ol>
			<li>
				<label for="description">Task description</label>
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
		</ol>
	</fieldset>

	<div class="buttons">
		<button class="btn new-task" type="submit">Save new note</button>
	</div>

</form>
