<!DOCTYPE html>

<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->

	<head>
		
		<?php echo $template['partials']['head']; ?>

	</head>

	<body>
		
		<?php echo $template['partials']['header']; ?>
			
		<div class="wrapper">

			<div class="sidebar">
				<?php echo $template['partials']['menu']; ?>
			</div>
		
			<div class="content">

				<?php if ($this->session->flashdata('message')): ?>
					<div class="flash">
						<?php echo $this->session->flashdata('message'); ?>
					</div>
				<?php endif; ?>

				<?php echo $template['body']; ?>

			</div>
		
		</div>
		
		<!-- Load jQuery -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/j/jquery-1.9.1.min.js"><\/script>')</script>
		
		<!-- Load jQuery cookie plugin -->
		<script src="/j/jquery.cookie.js"></script>
		
		<!-- Load jQuery UI Sortable and Datepicker -->
		<script src="/j/jquery-ui-1.10.2.custom.min.js"></script>
		
		<script src="/j/ruck.js"></script>
		
		<script>
			var _gaq = [
				["_setAccount", "UA-71160-19"],
				["_trackPageview"]
			];
			(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
			g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
			s.parentNode.insertBefore(g,s)}(document,"script"));
		</script>

	</body>

</html>
