<h1>Weekly Review</h1>

<p>This list contains all of your active projects and their tasks. For each one, check that the project is still running and that there is a concrete Next Action defined for each project.</p>

<ul class="projects_tasks">
	<?php foreach ($projects as $project): ?>
		<li>
			<a href="/gtd/projects/<?php echo $project->id; ?>"><?php echo $project->name; ?></a>
			<a href="/gtd/projects/delete/<?php echo $project->id; ?>/review" class="delete">Delete this project</a>
			<?php if (count($project->tasks) != 0): ?>
				<ol>
					<?php foreach ($project->tasks as $task): ?>
						<li>
							<a href="/gtd/tasks/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
						</li>
					<?php endforeach; ?>
				</ol>
			<?php else: ?>
				<p>This project has <strong>no actions!</strong></p>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

<style>
	
	.projects_tasks {
		margin: 20px 0;
		font-size: 14px;
	}
	
	.projects_tasks li {
		border-top: 1px solid #e5e5e5;
		padding: 10px 0;
		position: relative;
	}
	
	.delete {
		position: absolute;
		top: 5px;
		right: 0;
		color: #c00;
		font-size: 12px;
	}
	
	.projects_tasks ol {
		margin: 0 20px 20px;
		font-size: 12px;
	}
	
	.projects_tasks p {
		margin: 0 20px 20px;
	}
	
	.projects_tasks li li {
		border: 0;
		padding: 0;
	}
	
</style>