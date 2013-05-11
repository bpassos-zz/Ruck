<h1>Someday/Maybe</h1>

<p>Those projects that you don't want to lose track of, but aren't ready to work on right now.</p>

<ul class="tasks">
	<?php foreach ($projects as $project): ?>
		<li><a href="/gtd/projects/<?php echo $project->id; ?>" class="task"><?php echo $project->name; ?></a></li>
	<?php endforeach; ?>
</ul>