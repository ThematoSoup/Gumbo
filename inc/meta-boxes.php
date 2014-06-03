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
function gumbo_metaboxes( $meta_boxes ) {
	// Start with an underscore to hide fields from custom fields list
	$prefix               = '_gumbo_';
	$gumbo_theme_options  = thsp_cbp_get_options_values();
	$default_layout       = $gumbo_theme_options['default_layout'];
	$default_font_size    = $gumbo_theme_options['font_size'];


	// Posts and pages metabox
	$layout_fields = array(
		array(
			'name'			=> __( 'Layout', 'gumbo' ),
			'desc'			=> '',
			'id'			=> $prefix . 'post_layout',
			'type'			=> 'radio',
			'std'			=> $default_layout,
			'options'		=> array(
				array(
					'name'	=> __( 'Right sidebar', 'gumbo' ),
					'value'	=> 'sidebar-right'
				),
				array(
					'name'	=> __( 'Left sidebar', 'gumbo' ),
					'value'	=> 'sidebar-left'
				),
				array(
					'name'	=> __( 'No sidebar', 'gumbo' ),
					'value'	=> 'no-sidebar'
				),
			),
		),
		array(
			'name'		=> __( 'Do not show header for this post', 'gumbo' ),
			'desc'		=> __( 'If checked, header will not be displayed', 'gumbo' ),
			'id'		=> $prefix . 'has_no_header',
			'type'		=> 'checkbox',
		),
		array(
			'name'		=> __( 'Do not show footer for this post', 'gumbo' ),
			'desc'		=> __( 'If checked, footer will not be displayed', 'gumbo' ),
			'id'		=> $prefix . 'has_no_footer',
			'type'		=> 'checkbox',
		),
		array(
			'name'		=> __( 'Font size', 'gumbo' ),
			'desc'		=> __( 'If set, this option will override font size set in Theme Customizer', 'gumbo' ),
			'id'		=> $prefix . 'post_font_size',
			'std'		=> $default_font_size,
			'type'		=> 'radio',
			'options'	=> array(
				array(
					'name'	=> __( 'Small', 'gumbo' ),
					'value'	=> 'small'
				),
				array(
					'name'	=> __( 'Medium', 'gumbo' ),
					'value'	=> 'medium'
				),
				array(
					'name'	=> __( 'Large', 'gumbo' ),
					'value'	=> 'large'
				),
			),
		),
	);
			
	if ( in_array( 'woosidebars/woosidebars.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
		$widget_area_options = array(
			array(
				'name'	=> __( 'Default sidebar', 'gumbo' ),
				'value'	=> false
			)
		);
		$custom_sidebars = get_posts( array(
			'post_type' =>'sidebar',
			'posts_per_page' => -1,
			'suppress_filters' => 'false'
		) );
		if ( count( $custom_sidebars ) > 0 ) :
			foreach ( $custom_sidebars as $k => $v ) :
				$widget_area_options[] = array(
					'name'	=> $v->post_title,
					'value'	=> $v->post_name,
				);
			endforeach;
		endif;
		$layout_fields[] = array(
			'name'		=> __( 'Widget Area', 'gumbo' ),
			'desc'		=> __( 'Select a widget area to display in the sidebar.', 'gumbo' ),
			'id'		=> $prefix . 'widget_area',
			'std'		=> false,
			'type'		=> 'select',
			'options'	=> $widget_area_options,
		);
	endif;
	
	$meta_boxes[] = array(
		'id'			=> 'posts_metabox',
		'title'			=> __( 'Layout Options', 'gumbo' ),
		'pages'			=> array( 'post', 'page' ), // Post type
		'context'		=> 'normal',
		'priority'		=> 'high',
		'show_names'	=> true, // Show field names on the left
		'fields'		=> $layout_fields,
	);

	// Authors page template metabox
	$meta_boxes[] = array(
		'id'			=> 'authors_page_metabox',
		'title'			=> __( 'Authors Page Settings', 'gumbo' ),
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
				'name'		=> __( 'Order authors by', 'gumbo' ),
				'desc'		=> '',
				'id'		=> $prefix . 'authors_query_order_by',
				'type'		=> 'radio',
				'options'	=> array(
					array(
						'name'	=> __( 'Post count', 'gumbo' ),
						'value'	=> 'post_count'
					),
					array(
						'name'	=> __( 'Name', 'gumbo' ),
						'value'	=> 'display_name'
					),
				),
			),
			array(
				'name'		=> __( 'Order', 'gumbo' ),
				'desc'		=> '',
				'id'		=> $prefix . 'authors_query_order',
				'type'		=> 'radio',
				'options'	=> array(
					array(
						'name'	=> __( 'Ascending', 'gumbo' ),
						'value'	=> 'ASC'
					),
					array(
						'name'	=> __( 'Descending', 'gumbo' ),
						'value'	=> 'DESC'
					),
				),
			),
		),
	);

	// Masonry page template metabox
	$meta_boxes[] = array(
		'id'			=> 'masonry_page_metabox',
		'title'			=> __( 'Masonry Page Settings', 'gumbo' ),
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
				'name' => __( 'Posts per page', 'gumbo' ),
				'desc' => __( 'Default number of posts per page (set in General > Reading) will be used if this is empty.', 'gumbo' ),
				'id'   => $prefix . 'posts_per_page',
				'type' => 'text_small',
			),
			array(
				'name' => __( 'Hide page title', 'gumbo' ),
				'desc' => __( 'Check if you\'d like to hide this page\'s title', 'gumbo' ),
				'id'   => $prefix . 'hide_title',
				'type' => 'checkbox',
			),
			array(
				'name'		=> __( 'Excluded categories', 'gumbo' ),
				'desc'		=> __( 'Select which categories to exclude', 'gumbo' ),
				'id'		=> $prefix . 'excluded_cats',
				'type'		=> 'taxonomy_multicheck',
				'taxonomy'	=> 'category', // Taxonomy Slug
			),
		),
	);

	// Widgetized Homepage page template metabox
	$meta_boxes[] = array(
		'id'			=> 'widgetized_page_metabox',
		'title'			=> __( 'Widgetized Page Settings', 'gumbo' ),
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
				'name' => __( 'Hide page title', 'gumbo' ),
				'desc' => __( 'Check if you\'d like to hide this page\'s title', 'gumbo' ),
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
add_filter( 'cmb_meta_boxes', 'gumbo_metaboxes' );


/**
 * Initialize the metabox class.
 */
function gumbo_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once get_template_directory() . '/inc/libraries/cmb/init.php';
}
add_action( 'init', 'gumbo_initialize_cmb_meta_boxes', 9999 );