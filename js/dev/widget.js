(function($) {
	$(function() {
	
		// Check to make sure the widget is on the current page
		if( $('ul.tipsy-social-icons').length > 0 && $('ul.tooltip-position-off').length !== 1 ) {
	
			var aTipsyAttrs = $('ul.tipsy-social-icons').attr('class').split(' ');
			
			var sPosition = 'n';
			if(aTipsyAttrs[1] === 'tooltip-position-' || aTipsyAttrs[1] === 'tooltip-position-above') {
				sPosition = 's';
			} // end if/else
		
			$('.tipsy-social-icon-container > ul > li > a > img').each(function() {
				$(this).tipsy({
					fade: true,
					title: 'alt',
					gravity: sPosition
				});
			});
		
		} // end if
		
	});
})(jQuery);