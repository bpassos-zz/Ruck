<div id="sidebar">

	<ul class="projects">
		<?php foreach ($active_projects as $project): ?>
			<li><a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a></li>
		<?php endforeach; ?>
	</ul>

	<ul class="projects inactive">
		<?php foreach ($inactive_projects as $project): ?>
			<li><a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a></li>
		<?php endforeach; ?>
	</ul>

</div>
