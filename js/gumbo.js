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

	if( $('#pull-out-trigger').length !== 0 ) {
		var $pullOutHeight = $('#pull-out-widget-area').height();
		
		$('#pull-out-trigger').toggle(
			function(){
				$('#pull-out-widget-area').slideDown(400);
				$('body').animate({
					paddingTop: $pullOutHeight,
				}, 400);
				$(this).animate({ 
					marginTop: $pullOutHeight,
				}, 400).addClass('open');
			},
			function(){
				$('#pull-out-widget-area').slideUp(400);
				$('body').animate({
					paddingTop: 0,
				}, 400);
				$(this).animate({ 
					marginTop: 0,
				}, 400).removeClass('open');
			}
		);
	}
});