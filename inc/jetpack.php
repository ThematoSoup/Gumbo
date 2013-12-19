<?php
/**
 * Jetpack Compatibility File
 *
 * See: http://jetpack.me/
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function thsp_infinite_scroll_setup() {
	if ( ! is_post_type_archive( 'product' ) ) :
		add_theme_support( 'infinite-scroll', array(
			'container' 		=> 'content',
			'footer'		    => 'main',
			'type'				=> 'click',
			'render'			=> 'thsp_jetpack_render',
			'posts_per_page'	=> 5
		) );
	endif;
}
add_action( 'after_setup_theme', 'thsp_infinite_scroll_setup' );

// Load Jetpack additional posts
function thsp_jetpack_render() {
	while( have_posts() ) :
    	the_post();
		get_template_part( '/partials/content', get_post_format() );
	endwhile;
}