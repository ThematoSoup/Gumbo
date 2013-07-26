/**
 * Gumbo theme main javascript file
 */
jQuery( document ).ready( function( $ ) {
	if( $('#masonry-container').length !== 0 ) {
		var $container = $('#masonry-container');
		
		// Homepage layout
		$($container).masonry({
			itemSelector:	'.masonry-brick',
			gutter:			30
		});
	}
});