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
			<li><a href="/gtd/tasks/detail/{id}">{description}</a></li>
		{/tasks}
	</ul>
</div>
