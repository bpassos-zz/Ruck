<!DOCTYPE html>

<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->

	<head>
		
		<?php echo $template['partials']['header']; ?>

	</head>

	<body class="<?php echo $this->uri->segment(2); ?>">
		
		<header role="banner">
			<img class="logo" src="/i/ruck.png" alt="Ruck" width="67" height="23">
		</header>
		
		<form role="search" class="search" method="get" action="/search">
			<div>
				<label for="q">Search:</label>
				<input type="search" id="q" name="q" placeholder="Search all tasks and projects...">
				<button type="submit">Search</button>
			</div>
		</form>
		
		<?php echo $template['partials']['navigation']; ?>
		
		<?php echo $template['partials']['actions']; ?>

		<section class="content" role="main">
			<?php echo $template['body']; ?>
		</section>
		
		<footer>
			
		</footer>

		<!-- Load jQuery -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/j/jquery-1.9.1.min.js"><\/script>')</script>
		
		<!-- Load jQuery UI Sortable -->
		<script src="/j/jquery-ui-1.10.0.custom.min.js"></script>
		
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
