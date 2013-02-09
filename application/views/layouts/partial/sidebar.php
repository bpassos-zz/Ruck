<div id="sidebar">

	<ul class="projects">
		<?php foreach ($active_projects as $project): ?>
			<li>
				<a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a>
				<?php if (isset($project->children)): ?>
					<ul class="child">
						<?php foreach ($project->children as $child): ?>
							<li>
								<a href="/gtd/projects/<?php echo $child->id ?>"><?php echo $child->name; ?></a>
								<?php if (isset($child->children)): ?>
									<ul class="grandchild">
										<?php foreach ($child->children as $grandchild): ?>
											<li>
												<a href="/gtd/projects/<?php echo $grandchild->id ?>"><?php echo $grandchild->name; ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
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
