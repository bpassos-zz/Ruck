<h1>Archived Projects</h1>

<ul class="tasks">
	<?php foreach ($projects as $project): ?>
		<li><a href="/gtd/projects/<?php echo $project->id; ?>"><?php echo $project->name; ?></a></li>
	<?php endforeach; ?>
</ul>