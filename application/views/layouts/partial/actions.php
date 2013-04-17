<section class="actions">
	
	<a href="/gtd/tasks/inbox" class="icon capture" accesskey="q" id="capture"><u>Q</u>uick Capture</a>
	
	<?php if ($inbox_count > 0): ?>
		<a href="/gtd/tasks/process_inbox" class="icon inbox" accesskey="p" id="inbox">Process <u>I</u>nbox (<?php echo $inbox_count; ?>)</a>
	<?php else: ?>
		<a href="/gtd/tasks/process_inbox" class="icon inbox" accesskey="p" id="inbox" onclick="alert('No items to process!'); return false;">Process <u>I</u>nbox</a>
	<?php endif; ?>

	<a href="/gtd/projects/create" class="icon project" accesskey="p" id="new-project">New <u>P</u>roject</a>

	<a href="/gtd/tasks/create" class="icon task" accesskey="t" id="new-task">New <u>T</u>ask</a>

	<a href="/gtd/projects/someday_maybe" class="icon someday-maybe" accesskey="s" id="someday-maybe"><u>S</u>omeday/<br>Maybe</a>

</section>
