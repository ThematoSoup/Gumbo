<?php
/**
 * Gumbo functions and definitions
 *
 * ========
 * Contents
 * ========
 *
 * - Content width
 * - Theme setup
 *   -- Template tags
 *   -- Extras
 *   -- Customizer
 *   -- Languages
 *   -- Feed links
 *   -- Post thumbnail support
 *   -- Register menus
 *   -- Post formats support
 * - Register custom background
 * - Enqueue scripts and styles
 * - Register custom header
 *
 * @package Gumbo
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'thsp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function thsp_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Theme Customizer boilerplate
	 */
	require( get_template_directory() . '/inc/customizer-boilerplate/customizer.php' );

	/**
	 * Customizer options
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'gumbo', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'gumbo' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'chat',
		'link',
		'gallery',
		'status',
		'quote',
		'image',
		'video'
	) );

	/**
	 * Enable support for Theme Hook Alliance hooks
	 */
	add_theme_support( 'tha_hooks', array( 'all' ) );
}
endif; // thsp_setup
add_action( 'after_setup_theme', 'thsp_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function thsp_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'thsp_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'thsp_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function thsp_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'gumbo' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Secondary Sidebar', 'gumbo' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'thsp_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function thsp_scripts() {
	/*
	 * Enqueue Google Fonts
	 *
	 * Check if fonts set in theme options require loading
	 * of Google scripts
	 */
	$theme_options			= thsp_cbp_get_options_values();
	$theme_options_fields	= thsp_cbp_get_fields();
	$body_font_value		= $theme_options['body_font'];
	$body_font_weight		= $theme_options['body_font_weight'];
	$heading_font_value		= $theme_options['heading_font'];
	$body_font_options		= $theme_options_fields['thsp_typography_section']['fields']['body_font']['control_args']['choices'];
	$heading_font_options	= $theme_options_fields['thsp_typography_section']['fields']['heading_font']['control_args']['choices'];

	// Check protocol
	$protocol = is_ssl() ? 'https' : 'http';
    
    // Check if it's a Google Font
	if( isset( $body_font_options[$body_font_value]['google_font'] ) ) {
		// Check body font weight
		if ( 'thin' == $body_font_weight ) {
			$body_font_options[$body_font_value]['google_font'] = str_replace( '400', '300', $body_font_options[$body_font_value]['google_font'] );
		}
		
		wp_enqueue_style(
			'body_font_' . $body_font_value,
			$protocol . '://fonts.googleapis.com/css?family=' . $body_font_options[$body_font_value]['google_font']
		);
	}	
	// Check if it's a Google Font and different than body font so it's not loaded twice
	if( isset( $heading_font_options[$heading_font_value]['google_font'] ) && $body_font_value != $heading_font_value ) {
		wp_enqueue_style(
			'heading_font_' . $heading_font_value,
			$protocol . '://fonts.googleapis.com/css?family=' . $heading_font_options[$heading_font_value]['google_font']
		);
	}
	
	wp_enqueue_style( 'gumbo-style', get_stylesheet_uri() );

	wp_enqueue_script( 'gumbo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'gumbo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'gumbo-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'thsp_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Theme hooks
 */
require( get_template_directory() . '/inc/tha/tha-theme-hooks.php' );