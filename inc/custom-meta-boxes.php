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
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_thsp_';

	$meta_boxes[] = array(
		'id'         => 'authors_page_metabox',
		'title'      => 'Authors Page',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Order authors by',
				'desc'    => '',
				'id'      => $prefix . 'authors_query_order_by',
				'type'    => 'radio',
				'options' => array(
					array(
						'name' => 'Post count',
						'value' => 'post_count'
					),
					array(
						'name' => 'Name',
						'value' => 'display_name'
					),
				),
			),
			array(
				'name'    => 'Order',
				'desc'    => '',
				'id'      => $prefix . 'authors_query_order',
				'type'    => 'radio',
				'options' => array(
					array(
						'name' => 'Ascending',
						'value' => 'ASC'
					),
					array(
						'name' => 'Descending',
						'value' => 'DESC'
					),
				),
			),
		),
	);

	$meta_boxes[] = array(
		'id'         => 'about_page_metabox',
		'title'      => 'About Page Metabox',
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(
			array(
				'name' => 'Test Text',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_text',
				'type' => 'text',
			),
		)
	);

	// Add other metaboxes as needed

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