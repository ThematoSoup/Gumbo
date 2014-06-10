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
 * - Load editor style
 * - Load required files
 * - Register custom background
 * - Register custom header
 * - Retrieve Google Fonts URL
 * - Enqueue scripts and styles
 * - Add menu item descriptions to main menu
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */	

/**
 * Adjusts content_width value in single column layouts
 *
 * @since Gumbo 1.0
 * @return void
 */
function gumbo_content_width() {
	global $content_width;

	if ( gumbo_has_no_sidebar() ) :
		$content_width = 1000;
	endif;
}
add_action( 'template_redirect', 'gumbo_content_width' );


/**
 * Add custom image size(s)
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'thsp-archives-featured', 640, 320, true );
	add_image_size( 'thsp-featured-content', 1000, 480, true );
	add_image_size( 'thsp-masonry', 300, 180, true );
}


if ( ! function_exists( 'gumbo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function gumbo_setup() {

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

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
		'footer' => __( 'Footer Menu', 'gumbo' ),
		'top' => __( 'Top Menu', 'gumbo' ),
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
		'link',
		'video'
	) );

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );
}
endif; // gumbo_setup
add_action( 'after_setup_theme', 'gumbo_setup' );


/**
 * Adds editor style
 */
function gumbo_editor_style() {	
	add_editor_style( 'css/editor-style.css' );
}
add_action( 'init', 'gumbo_editor_style' );


/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );


/**
 * Custom template tags for this theme.
 */
require( get_template_directory() . '/inc/template-tags.php' );


/**
 * Custom functions that act independently of the theme templates
 */
require( get_template_directory() . '/inc/extras.php' );


/**
 * Edits built-in WordPress widgets
 */
require( get_template_directory() . '/inc/widgets.php' );


/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
	require( get_template_directory() . '/inc/woocommerce/woocommerce.php' );
endif;


/**
 * Theme Customizer boilerplate
 */
require( get_template_directory() . '/inc/libraries/customizer-boilerplate/customizer.php' );


/**
 * Customizer options
 */
require( get_template_directory() . '/inc/customizer.php' );



/**
 * THA hooks
 */
require( get_template_directory() . '/inc/libraries/tha/tha-theme-hooks.php' );


/**
 * Add functions to theme hooks
 */
require( get_template_directory() . '/inc/hooks.php' );


/**
 * Custom meta boxes
 */
require_once get_template_directory() . '/inc/meta-boxes.php';


/**
 * TGM plugin activation class
 */
require_once( get_template_directory() . '/inc/tgm.php' );


/**
 * Setup the WordPress core custom background feature.
 *
 * Hooks into the after_setup_theme action.
 */
function gumbo_register_custom_background() {
	$args = array(
		'default-color'		=> '',
		'default-image'		=> '',
		// 'wp-head-callback'	=> 'gumbo_custom_background_cb',
	);

	$args = apply_filters( 'gumbo_custom_background_args', $args );

	add_theme_support( 'custom-background', $args );
}
add_action( 'after_setup_theme', 'gumbo_register_custom_background' );


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );


/**
 * Register widgetized areas and update sidebar with default widgets
 */
function gumbo_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'gumbo' ),
		'description'	=> __( 'Main widget area, used throughout your site.', 'gumbo' ),
		'id'            => 'primary-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer', 'gumbo' ),
		'id'            => 'footer-widget-area',
		'description'	=> __( 'This widget area is located in site footer.', 'gumbo' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Below Header', 'gumbo' ),
		'description'	=> __( 'This widget area is located below site header.', 'gumbo' ),
		'id'			=> 'sub-header-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget sub-header-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Above Footer', 'gumbo' ),
		'description'	=> __( 'This widget area is located above site footer.', 'gumbo' ),
		'id'			=> 'above-footer-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget above-footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Post Aside', 'gumbo' ),
		'description'	=> __( 'Appears next to post content in posts with standard post format.', 'gumbo' ),
		'id'            => 'post-aside',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Widgetized Template', 'gumbo' ),
		'description'	=> __( 'This widget area is used in Widgetized Page Template', 'gumbo' ),
		'id'			=> 'homepage-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget widgetized-homepage-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	/*
	 * If WooSidebars plugin is active, deregister their sidebars
	 * then register them again with correct arguments
	 */
	if ( in_array( 'woosidebars/woosidebars.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
		$custom_sidebars = get_posts( array(
			'post_type' =>'sidebar',
			'posts_per_page' => -1,
			'suppress_filters' => 'false'
		) );
		if ( count( $custom_sidebars ) > 0 ) :
			foreach ( $custom_sidebars as $k => $v ) :
				$sidebar_id = $v->post_name;
				unregister_sidebar( $sidebar_id );
				register_sidebar( array(
					'name'			=> $v->post_title,
					'description'	=> $v->post_excerpt,
					'id'			=> $sidebar_id,
					'before_widget' => '<aside id="%1$s" class="widget widgetized-homepage-widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h1 class="widget-title">',
					'after_title'   => '</h1>',
				) );
			endforeach;
		endif;
	endif;
}
add_action( 'widgets_init', 'gumbo_widgets_init' );


/*
 * Return Google Fonts url
 */
function gumbo_google_fonts_url() {
	/*
	 * Check if fonts set in theme options require loading
	 * of Google scripts
	 */
	$theme_options			= thsp_cbp_get_options_values();
	$theme_options_fields	= thsp_cbp_get_fields();
	$body_font_value		= $theme_options['body_font'];
	$heading_font_value		= $theme_options['heading_font'];
	$body_font_options		= $theme_options_fields['gumbo_typography_section']['fields']['body_font']['control_args']['choices'];
	$heading_font_options	= $theme_options_fields['gumbo_typography_section']['fields']['heading_font']['control_args']['choices'];
	$heading_font_weight	= $theme_options['heading_weight'] ? '700,700italic' : '400,400italic';
    
	/*
	 * Check if Google Fonts are needed
	 * Font options are defined in /inc/customizer.php
	 */
	if ( isset( $body_font_options[ $body_font_value ]['google_font'] ) || isset( $heading_font_options[ $heading_font_value ]['google_font'] ) ) :
		$font_families = array();
		
		if ( $body_font_value == $heading_font_value ) : // Check if it's the same font
			$font_families[] = $body_font_options[ $body_font_value ]['google_font'] . ':400,400italic,700,700italic';
		else :
			if ( isset( $body_font_options[ $body_font_value ]['google_font'] ) ) : // Check body font
				$font_families[] = $body_font_options[ $body_font_value ]['google_font'] . ':400,400italic,700,700italic';
			endif;
			if ( isset( $heading_font_options[ $heading_font_value ]['google_font'] ) ) : // Check heading font
				$font_families[] = $heading_font_options[ $heading_font_value ]['google_font'] . ':' . $heading_font_weight;
			endif;
		endif;
		
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
		
		return $fonts_url;
	else:
		return false;
	endif;	
}

/**
 * Enqueue scripts and styles
 */
function gumbo_scripts() {
	// Enqueue the font
	if ( gumbo_google_fonts_url() ) :
		wp_enqueue_style(
			'gumbo-fonts',
			gumbo_google_fonts_url()
		);
	endif;
	
	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.0.3' );

	// Enqueue main stylesheet
	wp_enqueue_style( 'gumbo', get_stylesheet_uri() );
	
	wp_enqueue_script( 'gumbo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'gumbo-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;
	
	if ( is_singular() && wp_attachment_is_image() ) :
		wp_enqueue_script( 'gumbo-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	endif;
	
	// Masonry script
	if ( is_page_template( 'page-templates/template-masonry.php' ) ) :
		// Check if 'masonry' handle is registered (3.9+)
		if ( wp_script_is( 'masonry', 'registered' ) ) {
			wp_enqueue_script( 'masonry' );
		} else {
			wp_enqueue_script( 'jquery-masonry' );
		}
	endif; 
	
	// Flex Slider for featured content
	$theme_options = thsp_cbp_get_options_values();
	if ( is_front_page() && $theme_options['display_featured'] ) :
		wp_enqueue_style( 'flex-slider', get_template_directory_uri() . '/js/flexslider/flexslider.css', array(), '2.2.0' );
		wp_enqueue_script( 'flex-slider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '2.2.0' );
	endif; 
	
	wp_enqueue_script( 'gumbo', get_template_directory_uri() . '/js/gumbo.js', array( 'jquery' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'gumbo_scripts' );


/**
 * Add menu item descriptions to main menu
 * @link	http://www.wpbeginner.com/wp-themes/how-to-add-menu-descriptions-in-your-wordpress-themes/
 */
class gumbo_Menu_With_Description extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
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