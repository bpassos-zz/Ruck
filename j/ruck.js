$(function () {
	
	// Add keyboard shortcuts, only if the user is not currently focused on a form field.
	$(document).on('keypress', function (e) {
		if ($(e.target).is('input, select, textarea')) {
            return;   
        }
		if(e.which == 80 || e.which == 112) { // P
			location.href = $('#new-project').attr('href');
		}
		if(e.which == 84 || e.which == 116) { // T
			location.href = $('#new-task').attr('href');
		}
	});
	
	// Make task lists within projects sortable.
	$('.sortable').sortable({
		revert: true,
		update: function (event, ui) {
			$.ajax({
				data: {
					new_order : $('.sortable').sortable('toArray')
				},
				error: function () {
					// TODO: Add error handling for failed Ajax call.
				},
				success: function (data) {
					// Re-apply the correct IDs to the sortable list and links.
					new_ids = data.split(',');
					$('.sortable li').each(function (i) {
						this.id = new_ids[i];
						$(this).find('a').each(function () {
							this.href = this.href.replace(/\d+/, new_ids[i]);
						});
					});
				},
				type: 'POST',
				url: '/gtd/projects/order'
			});
		}
	});
	
	var $tasks = $('.tasks li');

	if ($tasks.length) {

		// Remove context links that are of no use for this project/view.
		var context_ids = [];
		$('.tasks li').each(function () {
			context_ids.push(this.getAttribute('data-context-id'));
		});
		$('.contexts li').each(function () {
			if (this.getAttribute('data-context-id') && context_ids.indexOf(this.getAttribute('data-context-id')) == -1) {
				$(this).hide();
			}
		});
	
		// Make context links toggle the current task list by context.
		$('.context').click(function () {
			$this = $(this);
			// First either add or remove the active class for this context.
			$this.parent().toggleClass('active');
			// Now collect all the active contexts and filter the task list.
			var active_context_ids = [];
			$('.contexts .active').each(function () {
				active_context_ids.push(this.getAttribute('data-context-id'));
			});
			// If at least one is active, hide all the tasks then show the ones that match.
			if (active_context_ids.length) {
				$('.tasks li').hide();
				for (var i = 0; i < active_context_ids.length; i++) {
					$('.tasks li[data-context-id="' + active_context_ids[i] + '"]').show();
				}
			} else {
				// Show all tasks as no contexts are selected.
				$('.tasks li').show();
			}
			return false;
		});
	
	} else {
		// No task list so hide the context navigation.
		$('.contexts').remove();
	}

});
