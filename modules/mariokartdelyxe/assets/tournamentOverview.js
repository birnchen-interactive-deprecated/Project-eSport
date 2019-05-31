"use strict";

$(document).ready(function() {

	$('table.foldable .namedHeader').on('click', function() {

		var tableParent = $(this).parents('table.foldable');
		if (tableParent.hasClass('foldable_open')) {
			tableParent.removeClass('foldable_open');
		} else {
			tableParent.addClass('foldable_open');
		}

	})
	
});