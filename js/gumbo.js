/**
 * Gumbo theme main javascript file
 */
jQuery( document ).ready( function( $ ) {
	if( $('#masonry-container').length !== 0 ) {
		var $container = $('#masonry-container');
		
		// Homepage layout
		$container.imagesLoaded( function() {
			$($container).masonry({
				itemSelector:	'.masonry-brick',
				gutter:			30
			});
		});
	}

	if( $('.flexslider').length !== 0 ) {
		$('.flexslider').flexslider({
			animation: 'fade',
			directionNav: false
		});
	}
});