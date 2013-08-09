<?php
/**
 * Gumbo functions and definitions
 *
 * ========
 * Contents
 * ========
 *
 * - Content width
 * - Add image size(s)
 * - Theme setup
 *   -- Template tags
 *   -- Extras
 *   -- Customizer
 *   -- Languages
 *   -- Feed links
 *   -- Post thumbnail support
 *   -- Register menus
 *   -- Post formats support
 * - Add menu item descriptions to main menu
 * - Register custom background (commented out)
 * - Enqueue scripts and styles
 * - Register custom header
 *
 * @package Gumbo
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 660; /* pixels */

/**
 * Add custom image size(s)
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'thsp-archives-featured', 660, 9999 );
	add_image_size( 'thsp-masonry', 300, 180, true );
}

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
		'status',
		'quote',
		'image',
		'gallery',
		'link'
	) );

	/**
	 * Enable support for Theme Hook Alliance hooks
	 */
	add_theme_support( 'tha_hooks', array( 'all' ) );
}
endif; // thsp_setup
add_action( 'after_setup_theme', 'thsp_setup' );

/**
 * Custom template tags for this theme.
 */
require( get_template_directory() . '/inc/template-tags.php' );

/**
 * Custom functions that act independently of the theme templates
 */
require( get_template_directory() . '/inc/extras.php' );

/**
 * Steroids plugin display functions
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'steroids/steroids.php' ) ) :
	require( get_template_directory() . '/inc/steroids.php' );
endif;


/**
 * Theme Customizer boilerplate
 */
require( get_template_directory() . '/inc/libraries/customizer-boilerplate/customizer.php' );

/**
 * Post Format tools
 */
require( get_template_directory() . '/inc/libraries/post-format-tools.php' );

/**
 * Theme hooks
 */
require( get_template_directory() . '/inc/libraries/tha/tha-theme-hooks.php' );

/**
 * Customizer options
 */
require( get_template_directory() . '/inc/customizer.php' );

/**
 * Custom meta boxes
 */
require_once get_template_directory() . '/inc/custom-meta-boxes.php';

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
// add_action( 'after_setup_theme', 'thsp_register_custom_background' );

/**
 * Register widgetized areas and update sidebar with default widgets
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
	register_sidebar( array(
		'name'          => __( 'Post Aside', 'gumbo' ),
		'id'            => 'post-aside',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post Top', 'gumbo' ),
		'id'            => 'post-top',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post Bottom', 'gumbo' ),
		'id'            => 'post-bottom',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name' => __( 'Widgetized Homepage Widget Area', 'gumbo' ),
		'description' => __( 'This widget area is used in "Widgetized Homepage" page template', 'gumbo' ),
		'id' => 'homepage-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget widgetized-homepage-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Pull-out widget area', 'gumbo' ),
		'description' => __( 'This widget area can be located at top, bottom, left or right of each page. To set its location go to Appearance > Theme Customizer.', 'gumbo' ),
		'id' => 'pull-out-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget pull-out-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Sub-header widget area', 'gumbo' ),
		'description' => __( 'This widget area is located below site header.', 'gumbo' ),
		'id' => 'sub-header-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget sub-header-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Above footer widget area', 'gumbo' ),
		'description' => __( 'This widget area is located above site footer.', 'gumbo' ),
		'id' => 'above-footer-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget above-footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'thsp_widgets_init' );

/**
 * Add pull out widget area to wp_footer hook
 */
function thsp_add_pull_out() {
	$theme_options = thsp_cbp_get_options_values();
	if ( is_active_sidebar( 'pull-out-widget-area' ) ) :
		echo '<div id="pull-out-widget-area" class="flexible-widget-area position-' . $theme_options['pull_out_placement'] . ' ' . thsp_count_widgets( 'pull-out-widget-area' ) . '">';
			dynamic_sidebar( 'pull-out-widget-area' );
		echo '</div><!-- #pull-out-widget-area -->';
		echo '<a href="#" id="pull-out-trigger">' . __( 'Click', 'gumbo' ) . '</a>';
	endif;
}
add_action( 'wp_footer', 'thsp_add_pull_out' );

/**
 * Add sub-header widget area to tha_header_after hook
 */
function thsp_add_sub_header() {
	if ( is_active_sidebar( 'sub-header-widget-area' ) ) :
		echo '<div id="sub-header" class="flexible-widget-area ' . thsp_count_widgets( 'sub-header-widget-area' ) . '">';
			echo '<div class="inner clear">';
			dynamic_sidebar( 'sub-header-widget-area' );
			echo '</div>';
		echo '</div><!-- #sub-header -->';
	endif;
}
add_action( 'tha_header_after', 'thsp_add_sub_header' );

/**
 * Add above footer widget area to tha_header_after hook
 */
function thsp_add_above_footer() {
	if ( is_active_sidebar( 'above-footer-widget-area' ) ) :
		echo '<div id="above-footer" class="flexible-widget-area ' . thsp_count_widgets( 'above-footer-widget-area' ) . '">';
			echo '<div class="inner clear">';
			dynamic_sidebar( 'above-footer-widget-area' );
			echo '</div>';
		echo '</div><!-- #above-footer -->';
	endif;
}
add_action( 'tha_footer_before', 'thsp_add_above_footer' );

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
    
	/*
	 * Check if Google Fonts are needed
	 * Font options are defined in /inc/customizer.php
	 */
	if ( isset( $body_font_options[ $body_font_value ]['google_font'] ) || isset( $heading_font_options[ $heading_font_value ]['google_font'] ) ) :
		$font_families = array();
		
		if ( $body_font_value == $heading_font_value ) : // Check if it's the same font
			$font_families[] = $body_font_options[ $body_font_value ]['google_font'] . ':' . $body_font_weight . ',' . $body_font_weight . 'italic,700,700italic';
		else :
			if ( isset( $body_font_options[ $body_font_value ]['google_font'] ) ) : // Check body font
				$font_families[] = $body_font_options[ $body_font_value ]['google_font'] . ':' . $body_font_weight . ',' . $body_font_weight . 'italic';
			endif;
			if ( isset( $heading_font_options[ $heading_font_value ]['google_font'] ) ) : // Check heading font
				$font_families[] = $heading_font_options[ $heading_font_value ]['google_font'] . ':700,700italic';
			endif;
		endif;
		
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

		// Enqueue the font
		wp_enqueue_style(
			'gumbo_fonts',
			$fonts_url
		);
	endif;
	
	wp_enqueue_style( 'gumbo-style', get_stylesheet_uri() );
	wp_enqueue_script( 'gumbo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'gumbo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;
	if ( is_singular() && wp_attachment_is_image() ) :
		wp_enqueue_script( 'gumbo-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	endif;
	if ( is_page_template( 'page-templates/template-masonry.php' ) ) :
		wp_enqueue_script( 'gumbo-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'jquery' ), '3.1.0' );
	endif; 
	wp_enqueue_script( 'gumbo', get_template_directory_uri() . '/js/gumbo.js', array( 'jquery' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'thsp_scripts' );

/**
 * Implement the Custom Header feature
 */
// require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Add menu item descriptions to main menu
 * @link	http://www.wpbeginner.com/wp-themes/how-to-add-menu-descriptions-in-your-wordpress-themes/
 */
class THSP_Menu_With_Description extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if ( '' != $item->description ) :
			$item_output .= '<span class="menu-item-description">' . $item->description . '</span>';
		endif;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}