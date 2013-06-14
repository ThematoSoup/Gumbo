<?php
/**
 * Gumbo Theme Customizer
 *
 * @package Gumbo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function gumbo_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'gumbo_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function gumbo_customize_preview_js() {
	wp_enqueue_script( 'gumbo_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130304', true );
}
add_action( 'customize_preview_init', 'gumbo_customize_preview_js' );


/*
 * ==================================
 * Theme Customizer Boilerplate edits
 * ==================================
 */


/**
 * Hooking into Theme Customizer Boilerplate to set name of DB entry
 * under which theme options are stored
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @since	Cazuela 1.0
 */
add_filter( 'thsp_cbp_option', 'thsp_edit_cbp_option_name', 1 );
function thsp_edit_cbp_option_name() {
	return 'thsp_gumbo_options';
}


/**
 * Hooking into Theme Customizer Boilerplate to set Customizer location
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @return	string		Theme Customizer Boilerplate location path
 * @since	Cazuela 1.0
 */
add_filter( 'thsp_cbp_directory_uri', 'thsp_edit_cbp_directory_uri', 1 );
function thsp_edit_cbp_directory_uri() {	
	return get_template_directory_uri() . '/inc/customizer-boilerplate';	
}


/**
 * Hooking into Theme Customizer Boilerplate to set Menu link text
 * https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @return	string			Menu link text
 * @since	Cazuela 1.0
 */
add_filter( 'thsp_cbp_menu_link_text', 'thsp_customizer_menu_link_text', 1 );
function thsp_customizer_menu_link_text() {
	return __( 'Theme Customizer', 'gumbo' );
}


/**
 * Options array for Theme Customizer Boilerplate
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @return	array		Theme options
 * @since	Cazuela 1.0
 */
add_filter( 'thsp_cbp_options_array', 'thsp_theme_options_array', 1 );
function thsp_theme_options_array() {
	// Using helper function to get default required capability
	$thsp_cbp_capability = thsp_cbp_capability();

	// Get current theme options
	$thsp_body_font_weight = $thsp_theme_options['body_font_weight'];

	$options = array(

		// Section ID
		'colors' => array(
			'existing_section' => true,
			'fields' => array(
				'page_background' => array(
					'setting_args' => array(
						'default' => 'light',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Page background', 'gumbo' ),
						'type' => 'select', // Select control
						'choices' => array(
							'light' => array(
								'label' => 'Light',
							),
							'dark' => array(
								'label' => 'Dark'
							)
						),					
						'priority' => 2
					) // End control args
				),
				'primary_color' => array(
					'setting_args' => array(
						'default' => '#1e559b',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Primary color', 'gumbo' ),
						'type' => 'color', // Color picker field control
						'priority' => 3
					)
				)
			) // End fields
		),

		// Section ID
		'title_tagline' => array(
			'existing_section' => true,
			'fields' => array(
				
				'logo_image' => array(
					'setting_args' => array(
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Logo', 'gumbo' ),
						'type' => 'image', // Image upload field control
						'priority' => 20
					)
				)
				
			) // End fields
		), // End section
		
		// Section ID
		'nav' => array(
			'existing_section' => true,
			'fields' => array(
				'post_navigation_below' => array(
					'setting_args' => array(
						'default' => true,
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Navigation below posts', 'gumbo' ),
						'type' => 'checkbox', // Checkbox field control
						'priority' => 21
					)
				),
			) // End fields
		), // End section

		// Section ID
		'thsp_layout_section' => array(
			'existing_section' => false,
			'args' => array(
				'title' => __( 'Layout', 'gumbo' ),
				'description' => __( 'Set default page layout', 'gumbo' ),
				'priority' => 10
			),
			'fields' => array(
				'default_layout' => array(
					'setting_args' => array(
						'default' => 'layout-cp',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Default layout', 'gumbo' ),
						'type' => 'images_radio', // Image radio replacement
						'choices' => array(
							'layout-c' => array(
								'label' => __( 'Content', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-c.png'
							),
							'layout-cp' =>  array(
								'label' => __( 'Content - Primary Sidebar', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-cp.png'
							),
							'layout-pc' => array(
								'label' => __( 'Primary Sidebar - Content', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-pc.png'
							),
							'layout-cps' => array(
								'label' => __( 'Content - Primary Sidebar - Secondary Sidebar', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-cps.png'
							),
							'layout-psc' => array(
								'label' => __( 'Primary Sidebar - Secondary Sidebar - Content', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-psc.png'
							),
							'layout-pcs' => array(
								'label' => __( 'Primary Sidebar - Content - Secondary Sidebar', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-pcs.png'
							)
						),					
						'priority' => 2
					) // End control args
				),
				'main_nav_placement' => array(
					'setting_args' => array(
						'default' => 'floated',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Main navigation placement', 'gumbo' ),
						'type' => 'radio', // Image radio replacement
						'choices' => array(
							'floated' => array(
								'label' => __( 'Next to title and tagline', 'gumbo' )
							),
							'below' =>  array(
								'label' => __( 'Below title and tagline', 'gumbo' )
							),
						),					
						'priority' => 2
					) // End control args
				),
				'post_archives_show' => array(
					'setting_args' => array(
						'default' => 'full_content',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Post in archives show', 'gumbo' ),
						'type' => 'radio', // Image radio replacement
						'choices' => array(
							'full_content' => array(
								'label' => __( 'Full content', 'gumbo' )
							),
							'excerpt' => array(
								'label' => __( 'Excerpt', 'gumbo' )
							),
						),					
						'priority' => 3
					) // End control args
				)
			) // End fields
		),
		
		// Section ID
		'thsp_typography_section' => array(
			'existing_section' => false,
			'args' => array(
				'title' => __( 'Typography', 'gumbo' ),
				'description' => __( 'Select fonts', 'gumbo' ),
				'priority' => 20
			),
			'fields' => array(
				'body_font' => array(
					'setting_args' => array(
						'default' => 'titillium-web',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Body font', 'gumbo' ),
						'type' => 'select', // Select control
						'choices' => array(
							'helvetica' => array(
								'label' => 'Helvetica'
							),
							'open-sans' => array(
								'label' => 'Open Sans',
								'google_font' => 'Open+Sans'
							),
							'lato' => array(
								'label' => 'Lato',
								'google_font' => 'Lato'
							),
							'source-sans-pro' => array(
								'label' => 'Source Sans Pro',
								'google_font' => 'Source+Sans+Pro'
							),
							'roboto' => array(
								'label' => 'Roboto',
								'google_font' => 'Roboto'
							),
							'titillium-web' => array(
								'label' => 'Titillium Web',
								'google_font' => 'Titillium+Web'
							)
						),
						'priority' => 1
					) // End control args
				),
				'body_font_weight' => array(
					'setting_args' => array(
						'default' => 'regular',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Body font weight', 'gumbo' ),
						'type' => 'radio', // Radio control
						'choices' => array(
							'400' => array(
								'label' => 'Regular'
							),
							'300' => array(
								'label' => 'Thin'
							),
						),
						'priority' => 1
					) // End control args
				),
				'heading_font' => array(
					'setting_args' => array(
						'default' => 'titillium-web',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Heading font', 'gumbo' ),
						'type' => 'select', // Select control
						'choices' => array(
							'helvetica' => array(
								'label' => 'Helvetica'
							),
							'open-sans' => array(
								'label' => 'Open Sans',
								'google_font' => 'Open+Sans'
							),
							'lato' => array(
								'label' => 'Lato',
								'google_font' => 'Lato'
							),
							'source-sans-pro' => array(
								'label' => 'Source Sans Pro',
								'google_font' => 'Source+Sans+Pro'
							),
							'roboto' => array(
								'label' => 'Roboto',
								'google_font' => 'Roboto'
							),
							'titillium-web' => array(
								'label' => 'Titillium Web',
								'google_font' => 'Titillium+Web'
							)
						),
						'priority' => 1
					) // End control args
				),
				'font_size' => array(
					'setting_args' => array(
						'default' => 'medium',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Font size', 'gumbo' ),
						'type' => 'radio', // Radio control
						'choices' => array(
							'small' => array(
								'label' => 'Small'
							),
							'medium' => array(
								'label' => 'Medium'
							),
							'large' => array(
								'label' => 'Large'
							)
						),
						'priority' => 1
					) // End control args
				)
			) // End fields
		)
	);

	return $options;
}


/**
 * Built-in controls to remove from Theme Customizer
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @return	array	Built-in controls that need to be removed from Theme Customizer
 * @since	Cazuela 1.0
 */
add_filter( 'tshp_cbp_remove_controls', 'thsp_theme_options_remove_controls', 1 );
function thsp_theme_options_remove_controls() {
	$thsp_cbp_remove_controls = array(
		'header_textcolor',
		'background_color'
	);
	
	return $thsp_cbp_remove_controls;
}