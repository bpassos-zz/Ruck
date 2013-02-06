<!DOCTYPE html>

<html>
	
	<head>
		
		<title>Task Detail</title>
		
		<style>
			
			#sidebar {
				float: left;
				width: 25%;
			}
			
		</style>
		
	</head>
	
	<body>
		
		<div id="sidebar">
			<ul>
				{projects_list}
					<li><a href="/gtd/projects/{id}">{name}</a></li>
				{/projects_list}
			</ul>
		</div>
		
		<div id="content">
			{task}
				<h1>{description}</h1>
				<p>{notes}</p>
			{/task}
		</div>
		
	</body>
	
</html>