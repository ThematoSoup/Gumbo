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


if ( ! function_exists( 'thsp_project_meta' ) ) :
/**
 * Display portfolio project meta fields
 */
function thsp_project_meta( $post ) {
	echo '<div class="project-meta">';
		echo '<h3>' . __( 'Project Details', 'gumbo' ) . '</h3>';
		echo '<dl>';
		// Show project categories
		the_terms( $post->ID, 'steroids_project_categories', '<dt>' . __( 'Project Category', 'gumbo' ) . '</dt><dd>', ', ', '</dd>' );
	
		// Show client name and URL
		if ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) || get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) ) :
			echo '<dt>' . __( 'Client', 'gumbo' ) . '</dt>';
			echo '<dd>';
			if ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) && get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) ) :
				echo '<a href="' . get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) . '">' . get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) . '</a>';
			elseif ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) ) :
				echo get_post_meta( $post->ID, '_steroids_portfolio_client_name', true );
			else :
				echo get_post_meta( $post->ID, '_steroids_portfolio_client_url', true );
			endif;
		endif;
		
		// Show project date
		if ( get_post_meta( $post->ID, '_steroids_portfolio_project_date', true ) ) :
			echo '<dt>' . __( 'Date', 'gumbo' ) . '</dt>';
			echo '<dd>' . date( get_option( 'date_format' ), get_post_meta( $post->ID, '_steroids_portfolio_project_date', true ) ) . '</dd>';
		endif;
		echo '</dl>';

		if ( get_post_meta( $post->ID, '_steroids_portfolio_project_url', true ) ) :
			echo '<p><a class="more-link" href="' . get_post_meta( $post->ID, '_steroids_portfolio_project_url', true ) . '">' . __( 'Visit Project', 'gumbo' ) . '</a></p>';
		endif;
	echo '</div><!-- .project-meta -->';
}
endif;


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