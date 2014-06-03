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
	// $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
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
 * @since	Gumbo 1.0
 */
add_filter( 'thsp_cbp_option', 'gumbo_edit_cbp_option_name', 1 );
function gumbo_edit_cbp_option_name() {
	return 'gumbo_options';
}


/**
 * Hooking into Theme Customizer Boilerplate to set Customizer location
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @return	string		Theme Customizer Boilerplate location path
 * @since	Gumbo 1.0
 */
add_filter( 'thsp_cbp_directory_uri', 'gumbo_edit_cbp_directory_uri', 1 );
function gumbo_edit_cbp_directory_uri() {	
	return get_template_directory_uri() . '/inc/libraries/customizer-boilerplate';	
}


/**
 * Options array for Theme Customizer Boilerplate
 *
 * @link	https://github.com/slobodan/WordPress-Theme-Customizer-Boilerplate
 * @return	array		Theme options
 * @since	Gumbo 1.0
 */
add_filter( 'thsp_cbp_options_array', 'gumbo_theme_options_array', 1 );
function gumbo_theme_options_array() {
	// Using helper function to get default required capability
	$gumbo_cbp_capability = thsp_cbp_capability();

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
						'capability' => $gumbo_cbp_capability,
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
						'capability' => $gumbo_cbp_capability,
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
						'capability' => $gumbo_cbp_capability,
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
						'capability' => $gumbo_cbp_capability,
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
						'capability' => $gumbo_cbp_capability,
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
		'gumbo_layout_section' => array(
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
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Default page layout', 'gumbo' ),
						'type' => 'radio', // Image radio replacement
						'choices' => array(
							'sidebar-right' =>  array(
								'label' => __( 'Right sidebar', 'gumbo' ),
								// 'image_src' => get_template_directory_uri() . '/images/theme-options/layout-cp.png'
							),
							'sidebar-left' => array(
								'label' => __( 'Left sidebar', 'gumbo' ),
								// 'image_src' => get_template_directory_uri() . '/images/theme-options/layout-pc.png'
							),
							'no-sidebar' => array(
								'label' => __( 'No sidebar', 'gumbo' ),
								// 'image_src' => get_template_directory_uri() . '/images/theme-options/layout-c.png'
							),
						),					
						'priority' => 2
					) // End control args
				),
				'header_layout' => array(
					'setting_args' => array(
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
						'default' => 'nav-below',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Header layout', 'gumbo' ),
						'type' => 'radio', // Image radio replacement
						'choices' => array(
							'nav-below' =>  array(
								'label' => __( 'Navigation below title and tagline', 'gumbo' ),
								// 'image_src' => get_template_directory_uri() . '/images/theme-options/nav-below.png'
							),
							'nav-right' => array(
								'label' => __( 'Navigation next to title and tagline', 'gumbo' ),
								// 'image_src' => get_template_directory_uri() . '/images/theme-options/nav-right.png'
							),
							'nav-below-centered' =>  array(
								'label' => __( 'Center aligned', 'gumbo' ),
								// 'image_src' => get_template_directory_uri() . '/images/theme-options/nav-below-centered.png'
							),							
						),					
						'priority' => 3
					) // End control args
				),
			) // End fields
		),

		// Section ID
		'gumbo_featured_section' => array(
			'existing_section' => false,
			'args' => array(
				'title' => __( 'Featured Content', 'gumbo' ),
				'description' => __( 'Set featured content for your site', 'gumbo' ),
				'priority' => 15
			),
			'fields' => array(
				'display_featured' => array(
					'setting_args' => array(
						'default' => false,
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					),                                        
					'control_args' => array(
						'label' => __( 'Display featured posts in homepage', 'gumbo' ),
						'type' => 'checkbox', // Checkbox field control
						'priority' => 1
					)
				),
				'featured_content_tag' => array(
					'setting_args' => array(
						'default' => '',
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					),                                        
					'control_args' => array(
						'label' => __( 'Enter a tag to use for featured content', 'gumbo' ),
						'type' => 'text', // Text field control
						'priority' => 2
					)
				),                                
				'featured_posts_count' => array(
					'setting_args' => array(
						'default' => 5,
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					),                                        
					'control_args' => array(
						'label' => __( 'Number of featured posts', 'gumbo' ),
						'type' => 'number', // Textarea control
						'priority' => 3
					)
				),
				'slider_width' => array(
					'setting_args' => array(
						'default' => 'full-width',
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Featured content width', 'gumbo' ),
						'type' => 'radio', // Radio control
						'choices' => array(
							'full-width' => array(
								'label' => __( 'Full width', 'gumbo' ),
							),
							'content-width' => array(
								'label' => __( 'Content width', 'gumbo'),
							),
						),
						'priority' => 10
					) // End control args
				),
			) // End fields
		),
		
		// Section ID
		'gumbo_typography_section' => array(
			'existing_section' => false,
			'args' => array(
				'title' => __( 'Typography', 'gumbo' ),
				'description' => __( 'Select fonts and their options', 'gumbo' ),
				'priority' => 20
			),
			'fields' => array(
				'font_size' => array(
					'setting_args' => array(
						'default' => 'medium',
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
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
						'priority' => 10
					) // End control args
				),
				'body_font' => array(
					'setting_args' => array(
						'default' => 'rosario',
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Body font', 'gumbo' ),
						'type' => 'select', // Image replacement radios
						'choices' => $font_choices,
						'priority' => 20
					) // End control args
				),
				'heading_font' => array(
					'setting_args' => array(
						'default' => 'rosario',
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					), // End setting args			
					'control_args' => array(
						'label' => __( 'Heading font', 'gumbo' ),
						'type' => 'select',
						'choices' => $font_choices,
						'priority' => 30
					) // End control args
				),
				'heading_weight' => array(
					'setting_args' => array(
						'default' => true,
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Make headings bold', 'gumbo' ),
						'type' => 'checkbox', // Checkbox field control
						'priority' => 40
					)
				),
				'heading_uppercase' => array(
					'setting_args' => array(
						'default' => false,
						'type' => 'option',
						'capability' => $gumbo_cbp_capability,
						'transport' => 'refresh',
					),					
					'control_args' => array(
						'label' => __( 'Make headings uppercase', 'gumbo' ),
						'type' => 'checkbox', // Checkbox field control
						'priority' => 50
					)
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
 * @since	Gumbo 1.0
 */
add_filter( 'tshp_cbp_remove_controls', 'gumbo_theme_options_remove_controls', 1 );
function gumbo_theme_options_remove_controls() {
	$gumbo_cbp_remove_controls = array(
		'blogname'
	);
	
	return $gumbo_cbp_remove_controls;
}