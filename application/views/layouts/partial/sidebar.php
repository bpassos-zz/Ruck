<div id="sidebar">

	<ul class="projects">
		<?php foreach ($active_projects as $project): ?>
			<li>
				<a href="/gtd/projects/<?php echo $project['parent']->id ?>"><?php echo $project['parent']->name; ?></a>
				<?php if (isset($project['children'])): ?>
					<ul class="child">
						<?php foreach ($project['children'] as $child): ?>
							<li>
								<a href="/gtd/projects/<?php echo $child->id ?>"><?php echo $child->name; ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>

	<ul class="projects inactive">
		<?php foreach ($inactive_projects as $project): ?>
			<li><a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a></li>
		<?php endforeach; ?>
	</ul>

</div>
