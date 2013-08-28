<?php
/**
 * Functions theme uses to display content for custom post types registered by Steroids plugin
 */

/**
 * Register widgetized areas used with Steroids custom posts
 */
function thsp_steroids_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Portfolio Sidebar', 'gumbo' ),
		'id'            => 'steroids-portfolio-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'thsp_steroids_widgets_init' );


/**
 * Adjusts content_width value for post types registered by Steroids plugin
 *
 * @since Gumbo 1.0
 * @return void
 */
function thsp_steroids_content_width() {
	global $content_width;

	if ( ! is_active_sidebar( 'steroids-portfolio-sidebar' ) && is_singular( 'steroids_portfolio' ) ) :
		$content_width = 1000;
	endif;
}
add_action( 'template_redirect', 'thsp_steroids_content_width' );


/**
 * Define the metabox and field configurations for Steroids custom post types
 * cmb_Meta_Box already exists - /inc/custom-meta-boxes.php so no need to initiate again
 *
 * @param  array $meta_boxes
 * @return array
 */
function thsp_steroids_metaboxes( $meta_boxes ) {
	$prefix = '_thsp_';

	// Add layout fields to steroids_portfolio_metabox
	$current_fields = $meta_boxes['steroids_portfolio']['fields'][] = array(
		'name'		=> 'Project Layout',
		'desc'		=> '',
		'id'		=> $prefix . 'project_layout',
		'type'		=> 'radio',
		'std'		=> 'layout-a',
		'options'	=> array(
			array(
				'name'	=> 'Layout A (Media, Content, Meta)',
				'value'	=> 'layout-a'
			),
			array(
				'name'	=> 'Layout B (Left: Media, Meta / Right: Content',
				'value'	=> 'layout-b'
			),
			array(
				'name'	=> 'Layout C (Media, Left: Content / Right: Meta)',
				'value'	=> 'layout-c'
			),
		)
	);
	
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'thsp_steroids_metaboxes' );