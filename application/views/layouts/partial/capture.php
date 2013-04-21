<div class="block capture">
	
	<div class="heading">
		Inbox
		<?php if ($inbox_count > 0): ?>
			<a href="/gtd/tasks/process_inbox" class="count inbox" accesskey="p" id="inbox"><?php echo $inbox_count; ?></a>
		<?php endif; ?>
	</div>
	
	<div class="content">
		<form class="quick-capture">
			<label for="quick-capture">Quick capture:</label>
			<input type="text">
		</form>
	</div>
	
</div>
