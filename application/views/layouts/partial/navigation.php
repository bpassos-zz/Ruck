<nav role="navigation" class="navigation">

	<ul>
		<li><a href="/gtd/" class="home hide-text">Home</a></li>
		<li>
			<a href="#">Select a project:</a>
			<ul>
				<?php foreach ($active_projects as $project): ?>
					<li<?php if ($project->id == $this->uri->segment(3)) echo ' class="current"'; ?>>
						<a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a>
						<?php if (isset($project->children)): ?>
							<ul class="child">
								<?php foreach ($project->children as $child): ?>
									<li<?php if ($child->id == $this->uri->segment(3)) echo ' class="current"'; ?>>
										<a href="/gtd/projects/<?php echo $child->id ?>"><?php echo $child->name; ?></a>
										<?php if (isset($child->children)): ?>
											<ul class="grandchild">
												<?php foreach ($child->children as $grandchild): ?>
													<li<?php if ($grandchild->id == $this->uri->segment(3)) echo ' class="current"'; ?>>
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
		</li>
	</ul>

<!--	
	<ul>
		<?php foreach ($inactive_projects as $project): ?>
			<li><a href="/gtd/projects/<?php echo $project->id ?>"><?php echo $project->name; ?></a></li>
		<?php endforeach; ?>
	</ul>
-->

</nav>