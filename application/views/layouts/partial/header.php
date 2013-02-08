<meta charset="utf-8">

<title><?php echo $template['title']; ?></title>

<?php echo $template['metadata']; ?>

<style>
	
	* {
		margin: 0;
		padding: 0;
		font: 14px/20px Helvetica, Arial, sans-serif;
		color: #333;
	}
	
	body {
		padding: 20px;
	}
	
	a {
		color: #08c;
	}
	
	#sidebar {
		float: left;
		width: 20%;
		margin-right: 5%;
	}
	
	#sidebar ul, #contexts {
		list-style: none;
		overflow: hidden;
	}
	
	#sidebar a {
		text-decoration: none;
		display: block;
		background: #eee;
		margin-bottom: 5px;
		padding: 5px;
	}
	
	#sidebar a:hover {
		background: #ccc;
		color: #09f;
	}
	
	h1 {
		font-size: 24px;
		margin: 0 0 20px;
	}
	
	#contexts a {
		display: block;
		float: left;
		margin: 0 10px 20px 0;
		padding: 5px 10px;
		border-radius: 10px;
		text-decoration: none;
		background: #eee;
	}
	
</style>
