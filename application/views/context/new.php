<?php echo validation_errors('<div class="error">', '</div>'); ?>

<form method="post" action="">
	<fieldset>
		<legend>Create a new context</legend>
		<ol>
			<li>
				<label for="name">Context name</label>
				<?php echo form_input(array(
					'name'		=> 'name',
					'id'		=> 'name',
					'value'		=> set_value('name'),
					'maxlength'	=> 100,
					'autofocus'	=> 'autofocus',
				)); ?>
			</li>
			<li>
				<label for="description">Context description</label>
				<?php echo form_input(array(
					'name'		=> 'description',
					'id'		=> 'description',
					'value'		=> set_value('description'),
					'maxlength'	=> 255,
				)); ?>
			</li>
		</ol>
	</fieldset>
	<div class="actions">
		<button type="submit">Create new context</button>
	</div>
</form>
