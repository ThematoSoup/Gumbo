<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 * @license		http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function thsp_metaboxes( $meta_boxes ) {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_thsp_';
	$thsp_theme_options = thsp_cbp_get_options_values();
	$default_layout = $thsp_theme_options['default_layout'];

	// Posts metabox
	$meta_boxes[] = array(
		'id'			=> 'posts_metabox',
		'title'			=> 'Post Details',
		'pages'			=> array( 'post' ), // Post type
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'fields'		=> array(
			array(
				'name'		=> 'Post layout',
				'desc'		=> '',
				'id'		=> $prefix . 'post_layout',
				'type'		=> 'radio',
				'std'		=> $default_layout,
				'options'	=> array(
					array(
						'name'	=> 'Right sidebar',
						'value'	=> 'sidebar-right'
					),
					array(
						'name'	=> 'Left sidebar',
						'value'	=> 'sidebar-left'
					),
					array(
						'name'	=> 'No sidebar',
						'value'	=> 'no-sidebar'
					),
				),
			),
			array(
				'name'		=> 'Do not show header for this post',
				'desc'		=> 'If checked, header will not be displayed in single post view',
				'id'		=> $prefix . 'has_no_header',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> 'Do not show footer for this post',
				'desc'		=> 'If checked, footer will not be displayed in single post view',
				'id'		=> $prefix . 'has_no_footer',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> 'Font size',
				'desc'		=> 'If set, this option will override font size set in Theme Customizer',
				'id'		=> $prefix . 'post_font_size',
				'type'		=> 'radio',
				'options'	=> array(
					array(
						'name'	=> 'Small',
						'value'	=> 'small'
					),
					array(
						'name'	=> 'Medium',
						'value'	=> 'medium'
					),
					array(
						'name'	=> 'Large',
						'value'	=> 'large'
					),
				),
			),
		),
	);

	// Authors page template metabox
	$meta_boxes[] = array(
		'id'			=> 'authors_page_metabox',
		'title'			=> 'Authors Page',
		'pages'			=> array( 'page' ), // Post type
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'show_on'		=> array(
			'key'	=> 'page-template',
			'value'	=> 'page-templates/template-authors.php',
		),
		'fields'		=> array(
			array(
				'name'		=> 'Order authors by',
				'desc'		=> '',
				'id'		=> $prefix . 'authors_query_order_by',
				'type'		=> 'radio',
				'options'	=> array(
					array(
						'name'	=> 'Post count',
						'value'	=> 'post_count'
					),
					array(
						'name'	=> 'Name',
						'value'	=> 'display_name'
					),
				),
			),
			array(
				'name'		=> 'Order',
				'desc'		=> '',
				'id'		=> $prefix . 'authors_query_order',
				'type'		=> 'radio',
				'options'	=> array(
					array(
						'name'	=> 'Ascending',
						'value'	=> 'ASC'
					),
					array(
						'name'	=> 'Descending',
						'value'	=> 'DESC'
					),
				),
			),
		),
	);

	// Masonry page template metabox
	$meta_boxes[] = array(
		'id'			=> 'masonry_page_metabox',
		'title'			=> 'Masonry Page',
		'pages'			=> array( 'page' ), // Post type
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'show_on'		=> array(
			'key'	=> 'page-template',
			'value'	=> 'page-templates/template-masonry.php',
		),
		'fields'		=> array(
			array(
				'name' => 'Posts per page',
				'desc' => 'Default number of posts per page (set in General > Reading) will be used if this is empty.',
				'id'   => $prefix . 'posts_per_page',
				'type' => 'text_small',
			),
			array(
				'name' => 'Hide page title',
				'desc' => 'Check if you\'d like to hide this page\'s title',
				'id'   => $prefix . 'hide_title',
				'type' => 'checkbox',
			),
			array(
				'name'		=> 'Excluded categories',
				'desc'		=> 'Select which categories to exclude',
				'id'		=> $prefix . 'excluded_cats',
				'type'		=> 'taxonomy_multicheck',
				'taxonomy'	=> 'category', // Taxonomy Slug
			),
		),
	);

	// Widgetized Homepage page template metabox
	$meta_boxes[] = array(
		'id'			=> 'authors_page_metabox',
		'title'			=> 'Authors Page',
		'pages'			=> array( 'page' ), // Post type
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'show_on'		=> array(
			'key'	=> 'page-template',
			'value'	=> 'page-templates/template-widgetized.php',
		),
		'fields'		=> array(
			array(
				'name' => 'Hide page title',
				'desc' => 'Check if you\'d like to hide this page\'s title',
				'id'   => $prefix . 'hide_title',
				'type' => 'checkbox',
			),
			array(
				'name'		=> __( 'Text position', 'gumbo' ),
				'desc'		=> __( 'Relative to featured image, video or slider', 'gumbo' ),
				'id'		=> $prefix . 'widgetized_text_position',
				'type'		=> 'radio_inline',
				'options'	=> array(
					array(
						'name'	=> __( 'Top', 'gumbo' ),
						'value'	=> 'top'
					),
					array(
						'name'	=> __( 'Right', 'gumbo' ),
						'value'	=> 'right'
					),
					array(
						'name'	=> __( 'Bottom', 'gumbo' ),
						'value'	=> 'bottom'
					),
					array(
						'name'	=> __( 'Left', 'gumbo' ),
						'value'	=> 'left'
					),
				),
				'std'	=> 'left',
			),
			array(
				'name' => __( 'Video URL', 'gumbo' ),
				'desc' => __( 'You can use video instead of Featured Image', 'gumbo' ),
				'id'   => $prefix . 'video_url',
				'type' => 'oembed',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'thsp_metaboxes' );


/**
 * Initialize the metabox class.
 */
function thsp_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once get_template_directory() . '/inc/libraries/cmb/init.php';
}
add_action( 'init', 'thsp_initialize_cmb_meta_boxes', 9999 );