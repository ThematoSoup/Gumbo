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
 * Hook into Steroids plugin to show theme's Portfolio Sidebar
 */
function thsp_steroids_portfolio_sidebar() {
	if ( is_active_sidebar( 'steroids-portfolio-sidebar' ) ) :
		tha_sidebars_before(); ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php
			tha_sidebar_top();
			dynamic_sidebar( 'steroids-portfolio-sidebar' );
			tha_sidebar_bottom();
			?>
		</div>
		<?php tha_sidebars_after();
	endif;
}
add_action( 'steroids_portfolio_sidebar', 'thsp_steroids_portfolio_sidebar' );


/**
 * Hook into post_class filter to add Portfolio project layout class
 */
function thsp_steroids_portfolio_project_layout( $classes ) {
	global $post;
	if ( is_singular( 'steroids_portfolio' ) && get_post_meta( $post->ID, '_thsp_project_layout', true ) ) :
		$classes[] = get_post_meta( $post->ID, '_thsp_project_layout', true );	
	endif;

	return $classes;
}
add_filter( 'post_class', 'thsp_steroids_portfolio_project_layout' );


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

	// Add layout title to steroids_portfolio_metabox
	$current_fields = $meta_boxes['steroids_portfolio']['fields'][] = array(
		'name' => 'Project Layout',
		'id'   => $prefix . 'project_layout_title',
		'type' => 'title',
	);
	// Add layout field to steroids_portfolio_metabox
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
add_filter( 'cmb_meta_boxes', 'thsp_steroids_metaboxes', 100 );