<!DOCTYPE html>

<html>
	
	<head>
		
		<title>Tasks</title>
		
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
			{project}
				<h1>{name}</h1>
			{/project}
			<ul>
				{tasks}
					<li>{description}</li>
				{/tasks}
			</ul>
		</div>
		
	</body>
	
</html>