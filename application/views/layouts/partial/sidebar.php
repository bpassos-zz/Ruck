<div id="sidebar">
	<ul>
		<?php foreach ($projects_list as $project): ?>
			<li><a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
