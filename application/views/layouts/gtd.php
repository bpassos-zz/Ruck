<!DOCTYPE html>

<html lang="en">

	<head>
		
		<?php echo $template['partials']['header']; ?>

	</head>

	<body class="body-<?php echo $this->uri->segment(2); ?>">
		
		<div class="title-bar">
			<span>Ruck</span>
			- Where <a href="/gtd/">GTD</a> meets <a href="/scrum/" onclick="alert('...eventually.'); return false;">Scrum</a>
		</div>

		<?php echo $template['partials']['actions']; ?>

		<?php echo $template['partials']['sidebar']; ?>
		
		<?php echo $template['partials']['contexts']; ?>

		<div id="main">
			<?php echo $template['body']; ?>
		</div>

		<!-- Load jQuery -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/j/jquery-1.9.1.min.js"><\/script>')</script>
		
		<!-- Load jQuery UI Sortable -->
		<script src="/j/jquery-ui-1.10.0.custom.min.js"></script>
		
		<script src="/j/ruck.js"></script>

	</body>

</html>
