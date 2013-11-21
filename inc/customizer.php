<?php
/**
 * Theme Customizer options
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 * @license		http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link		https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
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
	return get_template_directory_uri() . '/inc/libraries/customizer-boilerplate';	
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

	// Using same font options for body and heading fonts
	$font_choices = array(
		'helvetica' => array(
			'label' => 'Helvetica',
			'font_family' => '"Helvetica Neue", Helvetica, sans-serif',
		),
		'georgia' => array(
			'label' => 'Georgia',
			'font_family' => 'Georgia, serif',
		),
		'droid-serif' => array(
			'label' => 'Droid Serif',
			'google_font' => 'Droid Serif',
			'font_family' => '"Droid Serif", serif',
		),
		'arimo' => array(
			'label' => 'Arimo',
			'google_font' => 'Arimo',
			'font_family' => 'Arimo, sans-serif',
		),
		'lato' => array(
			'label' => 'Lato',
			'google_font' => 'Lato',
			'font_family' => 'Lato, sans-serif',
		),
		'open-sans' => array(
			'label' => 'Open Sans',
			'google_font' => 'Open Sans',
			'font_family' => '"Open Sans", sans-serif',
		),
		'ubuntu' => array(
			'label' => 'Ubuntu',
			'google_font' => 'Ubuntu',
			'font_family' => 'Ubuntu, sans-serif',
		),
		'cabin' => array(
			'label' => 'Cabin',
			'google_font' => 'Cabin',
			'font_family' => 'Cabin, sans-serif',
		),
		'istok-web' => array(
			'label' => 'Istok Web',
			'google_font' => 'Istok Web',
			'font_family' => '"Istok Web", sans-serif',
		),
		'noto-serif' => array(
			'label' => 'Noto Serif',
			'google_font' => 'Noto Serif',
			'font_family' => '"Noto Serif", serif',
		),
		'rosario' => array(
			'label' => 'Rosario',
			'google_font' => 'Rosario',
			'font_family' => 'Rosario, sans-serif',
		),
		'tinos' => array(
			'label' => 'Tinos',
			'google_font' => 'Tinos',
			'font_family' => 'Tinos, serif',
		),
		'source-sans-pro' => array(
			'label' => 'Source Sans Pro',
			'google_font' => 'Source Sans Pro',
			'font_family' => '"Source Sans Pro", sans-serif',
		),
		'roboto' => array(
			'label' => 'Roboto',
			'google_font' => 'Roboto',
			'font_family' => 'Roboto, sans-serif',
		),
		'titillium-web' => array(
			'label' => 'Titillium Web',
			'google_font' => 'Titillium Web',
			'font_family' => '"Titillium Web", sans-serif',
		)
	);

	$options = array(

		// Section ID
		'colors' => array(
			'existing_section' => true,
			'fields' => array(
				'color_scheme' => array(
					'setting_args' => array(
						'default' => 'white',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Color Scheme', 'gumbo' ),
						'type' => 'select', // Select control
						'choices' => array(
							'white' => array(
								'label' => 'White',
							),
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
						'default' => '',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Primary Color', 'gumbo' ),
						'type' => 'color', // Color picker field control
						'priority' => 3
					)
				),
				'header_background_color' => array(
					'setting_args' => array(
						'default' => '',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Header Background Color', 'gumbo' ),
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
						'label' => __( 'Enable navigation below posts', 'gumbo' ),
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
						'default' => 'sidebar-right',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Default page layout', 'gumbo' ),
						'type' => 'images_radio', // Image radio replacement
						'choices' => array(
							'sidebar-right' =>  array(
								'label' => __( 'Right sidebar', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-cp.png'
							),
							'sidebar-left' => array(
								'label' => __( 'Left sidebar', 'gumbo' ),
								'image_src' => get_template_directory_uri() . '/images/theme-options/layout-pc.png'
							),
						),					
						'priority' => 2
					) // End control args
				),
				'main_nav_placement' => array(
					'setting_args' => array(
						'default' => 'nav-below',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Main navigation placement', 'gumbo' ),
						'type' => 'radio', // Image radio replacement
						'choices' => array(
							'nav-right' => array(
								'label' => __( 'Next to title and tagline', 'gumbo' )
							),
							'nav-below' =>  array(
								'label' => __( 'Below title and tagline', 'gumbo' )
							),
						),					
						'priority' => 2
					) // End control args
				),
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
						'default' => 'helvetica',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Body font', 'gumbo' ),
						'type' => 'select', // Image replacement radios
						'choices' => $font_choices,
						'priority' => 1
					) // End control args
				),
				'heading_font' => array(
					'setting_args' => array(
						'default' => 'helvetica',
						'type' => 'option',
						'capability' => $thsp_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Heading font', 'gumbo' ),
						'type' => 'select',
						'choices' => $font_choices,
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
				),
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
	);
	
	return $thsp_cbp_remove_controls;
}