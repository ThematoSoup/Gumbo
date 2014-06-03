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
function gumbo_infinite_scroll_setup() {
	if ( ! is_post_type_archive( 'product' ) ) :
		add_theme_support( 'infinite-scroll', array(
			'container' 		=> 'content',
			'footer'		    => 'main',
			'type'				=> 'click',
			'render'			=> 'gumbo_jetpack_render',
			'posts_per_page'	=> 5
		) );
	endif;
}
add_action( 'after_setup_theme', 'gumbo_infinite_scroll_setup' );

// Load Jetpack additional posts
function gumbo_jetpack_render() {
	while( have_posts() ) :
    	the_post();
		get_template_part( '/partials/content', get_post_format() );
	endwhile;
}