$(function () {
	
	// Add a CLear button to the datepicker plugin.
	var dpFunc = $.datepicker._generateHTML;
	$.datepicker._generateHTML = function  (inst) {
		var thishtml = $(dpFunc.call($.datepicker, inst));
		thishtml = $('<div/>').append(thishtml);
		$('.ui-datepicker-buttonpane', thishtml).append(
			$('<button class="ui-datepicker-clear ui-state-default ui-priority-primary ui-corner-all"\>Clear</button\>').click(function () {
				$('#datepicker').datepicker('setDate', null);
				return false;
			})
		);
		thishtml = thishtml.children();
		return thishtml;
	};
	
	// Add keyboard shortcuts, only if the user is not currently focused on a form field.
	$(document).on('keydown', function (e) {
		if ($(e.target).is('input, select, textarea')) {
            return;   
        }
        //alert(e.which);
		if(e.which == 80 || e.which == 112) { // P
			location.href = $('#new-project').attr('href');
		}
		if(e.which == 84 || e.which == 116) { // T
			location.href = $('#new-task').attr('href');
		}
		if(e.which == 78 || e.which == 110) { // N
			location.href = $('#add').attr('href');
		}
		if(e.which == 72 || e.which == 104) { // H
			location.href = $('#home').attr('href');
		}
		if(e.which == 83 || e.which == 115) { // H
			location.href = $('#new-child-project').attr('href');
		}
		// Arrow keys.
		if(e.which == 37) { // Left
			location.href = $('#left-arrow').attr('href');
		}
		if(e.which == 38) { // Up
			location.href = $('#up-arrow').attr('href');
		}
		if(e.which == 39) { // Right
			location.href = $('#right-arrow').attr('href');
		}

	});
	
	// Make the task checkboxes not intercept the click event.
	$('.delete input').click(function () {
		location.href = $(this).parent().attr('href');
	});
	
	// Make task lists within projects sortable.
	$('.sortable').sortable({
		revert: true,
		update: function (event, ui) {
			var post_data = {
				new_order : $('.sortable').sortable('toArray')
			};
			post_data[csrf.token_name] = csrf.hash;
			$.ajax({
				data: post_data,
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
	
	var $tasks = $('.tasks li'), is_next = $('.next').length;

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
				if (is_next) {
					$.cookie('contexts', active_context_ids, { expires: 1 }); // Selected context(s) persist for a single day
				}
			} else {
				// Show all tasks as no contexts are selected.
				$('.tasks li').show();
				if (is_next) {
					$.removeCookie('contexts');
				}
			}
			return false;
		});
		
		// If the contexts cookie is present, use it to set the initial state of the homepage contexts.
		if (is_next && $.cookie('contexts')) {
			var active_context_ids = $.cookie('contexts');
			$('.tasks li').hide();
			for (var i = 0; i < active_context_ids.length; i++) {
				$('.contexts li[data-context-id="' + active_context_ids[i] + '"] a').click();
			}
		}
	
	} else {
		// No task list so hide the context navigation.
		$('.contexts').remove();
	}
	
	// Attach datepicker to Due Date field.
	$('#datepicker').datepicker({
		altFormat		: 'yy-mm-dd',
		altField		: "#due",
		showButtonPanel	: true
	});
	
	// Set the date to the right value.
	$('#datepicker').datepicker('setDate', $('#due').attr('data-due'));


});
