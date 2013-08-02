<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @package  Gumbo
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( $meta_boxes ) {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_thsp_';

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
			array(
				'name'		=> __( 'Widgets per row', 'gumbo' ),
				'desc'		=> __( 'Use "Widgetized Homepage Widget Area" for this', 'gumbo' ),
				'id'		=> $prefix . 'widgetized_widgets_per_row',
				'type'		=> 'radio_inline',
				'options'	=> array(
					array(
						'name'	=> 'Two',
						'value'	=> 2
					),
					array(
						'name'	=> 'Three',
						'value'	=> 3
					),
					array(
						'name'	=> 'Four',
						'value'	=> 4
					),
				),
				'std'	=> 4
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );

/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once get_template_directory() . '/inc/libraries/cmb/init.php';
}
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );