<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * ========
 * Contents
 * ========
 *
 * - Add Home link to wp_page_menu()
 * - Custom body classes
 * - Custom post classes
 * - Add custom body classes for layout and typography options
 * - Enhanced image navigation
 * - Custom wp_title, using filter hook
 *
 * @package Gumbo
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function thsp_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'thsp_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function thsp_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class id Post Aside is active
	if ( is_single() && is_active_sidebar( 'post-aside' ) ) {
		$classes[] = 'post-aside';
	}

	// Get current theme options
	$thsp_theme_options = thsp_cbp_get_options_values();
	$thsp_body_classes = array();

	// Get layout classes and add them to body_class array
	$thsp_current_layout = thsp_get_current_layout();
	foreach ( $thsp_current_layout as $thsp_current_layout_value ) {
		$thsp_body_classes[] = $thsp_current_layout_value;
	}

	// Typography classes
	$thsp_body_classes[] = 'body-font-' . $thsp_theme_options['body_font'];
	$thsp_body_classes[] = 'body-font-weight-' . $thsp_theme_options['body_font_weight'];
	$thsp_body_classes[] = 'heading-font-' . $thsp_theme_options['heading_font'];
	$thsp_body_classes[] = 'font-size-' . $thsp_theme_options['font_size'];
		
	$classes = array_merge( $classes, $thsp_body_classes );
	return $classes;
}
add_filter( 'body_class', 'thsp_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 */
function thsp_post_classes( $classes ) {
	if( current_theme_supports('post-thumbnails' ) )
		if( has_post_thumbnail() )
			$classes[] = "has-featured-image";
	
	return $classes;
}
add_filter( 'post_class', 'thsp_post_classes' );

/**
 * Gets current layout for page being displayed
 *
 * @uses	thsp_cbp_get_options_values()		defined in /customizer-boilerplate/helpers.php
 * @return	array	$current_layout				Layout options for current page
 * @since	Gumbo 1.0
 */
function thsp_get_current_layout() {
	global $post;

	// Get current theme options values
	$thsp_theme_options = thsp_cbp_get_options_values();

	// Check if in single post/page view and if layout custom field value exists
	if ( is_singular() && get_post_meta( $post->ID, '_thsp_post_layout', true ) ) {
		$current_layout['default_layout'] = get_post_meta( $post->ID, '_thsp_post_layout', true );
	} else {
		$current_layout['default_layout'] = $thsp_theme_options['default_layout'];
	}

	if( is_singular() && get_post_meta( $post->ID, '_post_layout_type', true ) ) {
		$current_layout['default_layout'] = get_post_meta( $post->ID, '_post_layout_type', true );
	} else {
		$current_layout['layout_type'] = $thsp_theme_options['layout_type'];
	}

	/*
	 * Returns an array with two values that can be changed using
	 * 'thsp_current_layout' filter hook:
	 * $current_layout['default-layout']	- determines number and placement of sidebars
	 * $current_layout['layout_type']		- boxed or full width
	 */
	return apply_filters( 'thsp_current_layout', $current_layout );
}

/**
 * Checks if current layout has three columns and secondary sidebar needs to be rendered
 *
 * @uses	thsp_get_current_layout()			defined in /inc/extras.php
 * @return	boolean
 * @since	Gumbo 1.0
 */
function thsp_check_secondary_sidebar() {
	$current_layout = thsp_get_current_layout();
	if ( in_array( $current_layout['default_layout'], array( 'layout-pcs', 'layout-cps', 'layout-psc' ) ) ) {
		return true;
	} else return false;
}

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function thsp_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'thsp_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function thsp_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'gumbo' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'thsp_wp_title', 10, 2 );

/**
 * Change password protected form output
 */
function thsp_custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$form_output = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post"><p>' . __( 'This post is password protected. To view it please enter your password below:', 'gumbo' ) . ' </p><label class="pass-label" for="' . $label . '">' . __( 'Password', 'gumbo' ) . ' </label><input name="post_password" id="' . $label . '" type="password" /><input type="submit" name="Submit" class="button" value="' . esc_attr__( "Submit" ) . '" /></form>';
	return $form_output;
}
add_filter( 'the_password_form', 'thsp_custom_password_form' );

/**
 * Internal CSS for accent color
 */
function thsp_internal_css() {
	// Get current theme options
	$thsp_theme_options = thsp_cbp_get_options_values();
	$thsp_primary_color = $thsp_theme_options['primary_color'];
	?>
	<style type="text/css">
		a { color: <?php echo $thsp_primary_color; ?> }
		#commentform #submit, .comment-reply-link, .wpcf7 input[type="submit"], .protected-post-form input[type="submit"] { background: <?php echo $thsp_primary_color; ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'thsp_internal_css' );