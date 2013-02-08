<!DOCTYPE html>

<html lang="en">

	<head>
		
		<?php echo $template['partials']['header']; ?>

	</head>

	<body>
		
		<div style="font: bold italic 20px serif; background: #333; color: #fff; padding: 10px 20px; margin: -20px -20px 20px;">
			<span style="font: italic 32px serif; color: #f60;">Ruck</span>
			- Where <a href="/gtd/">GTD</a> meets <a href="/scrum/" onclick="alert('...eventually.'); return false;">Scrum</a>
		</div>

		<?php echo $template['partials']['actions']; ?>

		<?php echo $template['partials']['sidebar']; ?>
		
		<?php echo $template['partials']['contexts']; ?>

		<?php echo $template['body']; ?>

	</body>

</html>
