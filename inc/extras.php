<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * ========
 * Contents
 * ========
 *
 * - Add Home link to wp_page_menu()
 * - Body classes
 * - Post classes
 * - Header classes
 * - Menu item classes
 * - Get current layout helper function
 * - Check if a sidebar exists helper function
 * - Enhanced image navigation
 * - Custom wp_title, using filter hook
 * - Custom password protected post form output
 * - Embedded CSS output
 * - Check if a post hides header
 * - Check if a post hides footer
 *
 * @package Gumbo
 */


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function gumbo_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'gumbo_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 */
function gumbo_body_classes( $classes ) {
	global $post;
	
	// Get theme options values
	$gumbo_theme_options = thsp_cbp_get_options_values();

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	// Content width
	global $content_width;
	$gumbo_body_classes[] = 'content-' . $content_width;

	// Get layout class and add it to body_class array
	$gumbo_current_layout = gumbo_get_current_layout();
	$gumbo_body_classes[] = $gumbo_current_layout;

	// Check if logo image exists
	if ( '' != $gumbo_theme_options['logo_image'] ) :
		$gumbo_body_classes[] = 'has-logo-image';
	endif;

	// Check header image
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) :
		$gumbo_body_classes[] = 'has-header-image';
	endif;
	
	// Adds a class id Post Aside is active
	if ( is_singular( 'post' ) && is_active_sidebar( 'post-aside' ) ) {
		$gumbo_body_classes[] = 'post-aside';
	}

	// Color scheme class
	$gumbo_body_classes[] = 'scheme-' . $gumbo_theme_options['color_scheme'];

	// Font size class
	if ( is_singular() && get_post_meta( $post->ID, '_gumbo_post_font_size', true ) && get_post_meta( $post->ID, '_gumbo_post_font_size', true ) != $gumbo_theme_options['font_size'] ) :
		$font_size = get_post_meta( $post->ID, '_gumbo_post_font_size', true );
	else :
		$font_size = $gumbo_theme_options['font_size'];
	endif; 
	$gumbo_body_classes[] = 'font-size-' . $font_size;
		
	// Check if custom primary color is used
	if ( ! empty( $gumbo_theme_options['primary_color'] ) ) :
		$gumbo_body_classes[] = 'custom-primary-color';
	endif;
	
	// Check if header and footer are hidden in single post view
	if ( is_single() || is_page() ) :
		if(  get_post_meta( $post->ID, '_gumbo_has_no_header', true ) ) :
			$gumbo_body_classes[] = 'has-no-header';
		endif;
		
		if ( get_post_meta( $post->ID, '_gumbo_has_no_footer', true ) ) :
			$gumbo_body_classes[] = 'has-no-footer';
		endif;
	endif;
		
	$classes = array_merge( $classes, $gumbo_body_classes );
	return $classes;
}
add_filter( 'body_class', 'gumbo_body_classes' );


/**
 * Adds custom classes to the array of post classes.
 */
function gumbo_post_classes( $classes ) {
	if( current_theme_supports('post-thumbnails' ) )
		if( has_post_thumbnail() )
			$classes[] = "has-featured-image";
	
	return $classes;
}
add_filter( 'post_class', 'gumbo_post_classes' );


/**
 * Returns classes added to header element.
 */
function gumbo_header_classes() {
	// Header layout
	$gumbo_theme_options = thsp_cbp_get_options_values();
	$gumbo_header_classes = 'header-' . $gumbo_theme_options['header_layout'];
	if ( has_nav_menu( 'top' ) ) :
	$gumbo_header_classes .= ' has-top-menu';
	endif;

	return $gumbo_header_classes;
}


/**
 * Adds custom classes to the array of menu item classes.
 */
function gumbo_custom_menu_item_classes( $classes, $item ) {
	$children = get_posts( array(
		'meta_query' => array (
		array(
			'key' => '_menu_item_menu_item_parent',
			'value' => $item->ID )
		),
		'post_type' => $item->post_type 
	) );
	if (count($children) > 0) {
		array_push( $classes, 'parent-menu-item' ); // add the class .parent-menu-item to the current menu item
	}
	
	return $classes;
}
add_filter( 'nav_menu_css_class', 'gumbo_custom_menu_item_classes', 10, 2 );


/**
 * Gets current layout for page being displayed
 *
 * @uses	thsp_cbp_get_options_values()		defined in /customizer-boilerplate/helpers.php
 * @return	array	$current_layout				Layout options for current page
 * @since	Gumbo 1.0
 */
function gumbo_get_current_layout() {
	global $post;

	// Get current theme options values
	$gumbo_theme_options = thsp_cbp_get_options_values();

	// Check if in single post/page view and if layout custom field value exists
	if ( is_singular() && get_post_meta( $post->ID, '_gumbo_post_layout', true ) ) :
		$current_layout = get_post_meta( $post->ID, '_gumbo_post_layout', true );
	else :
		$current_layout = $gumbo_theme_options['default_layout'];
	endif;
	
	if ( is_404() ) :
		$current_layout = 'no-sidebar';
	endif;

	if ( gumbo_has_no_sidebar() ) :
		$current_layout = 'no-sidebar';
	endif;
	
	/*
	 * Returns an array with two values that can be changed using
	 * 'gumbo_current_layout' filter hook
	 *
	 * returns	$current_layout		string		sidebar-right / sidebar-left / no-sidebar
	 */
	return apply_filters( 'gumbo_current_layout', $current_layout );
}


/**
 * Checks if current page has sidebar
 *
 * @return	boolean				
 * @since	Gumbo 1.0
 */
function gumbo_has_no_sidebar() {
	global $post;
	/*
	 * Get current sidebar
	 * Checks post meta to see if default sidebar is being
	 * overriden and WooSidebars plugin is active
	 */
	$current_sidebar = ( ( in_array( 'woosidebars/woosidebars.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_singular() && get_post_meta( $post->ID, '_gumbo_widget_area', true ) ) ? get_post_meta( $post->ID, '_gumbo_widget_area', true ) : 'primary-sidebar' );
	
	/*
	 * Check if No Sidebar option is checked in meta box
	 */
	if ( is_singular() && 'no-sidebar' == get_post_meta( $post->ID, '_gumbo_post_layout', true ) ) :
		return true;
	endif;
	
	/*
	 * Check for Primary or replacement sidebar if WooCommerce
	 * is not active
	 */
	if ( ! is_active_sidebar( $current_sidebar ) && ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
		return true;
	endif;
	
	// If WooCommerce plugin is active, check if Store Sidebar has any widgets
	if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
		if( is_woocommerce() && ! is_active_sidebar( 'store-sidebar' ) ) :
			return true;
		elseif ( ! is_active_sidebar( $current_sidebar ) ) :
			return true;
		endif;
	endif;
	
	return false;
}


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since	Gumbo 1.0
 */
function gumbo_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'gumbo_enhanced_image_navigation', 10, 2 );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 * @since	Gumbo 1.0
 */
function gumbo_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'gumbo' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'gumbo_wp_title', 10, 2 );


/**
 * Change password protected form output
 * @since	Gumbo 1.0
 */
function gumbo_custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$form_output = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post"><p>' . __( 'This post is password protected. To view it please enter your password below:', 'gumbo' ) . ' </p><label class="pass-label" for="' . $label . '">' . __( 'Password', 'gumbo' ) . ' </label><input name="post_password" id="' . $label . '" type="password" /><input type="submit" name="Submit" class="button" value="' . esc_attr__( "Submit" ) . '" /></form>';
	return $form_output;
}
add_filter( 'the_password_form', 'gumbo_custom_password_form' );


/**
 * Internal CSS for accent color
 * @since	Gumbo 1.0
 */
function gumbo_generated_css() {
	// Get current theme options
	$gumbo_theme_options			= thsp_cbp_get_options_values();
	$theme_options_fields		= thsp_cbp_get_fields();
	$primary_color				= $gumbo_theme_options['primary_color'];
	$header_background_color	= $gumbo_theme_options['header_background_color'];
	$body_font_value			= $gumbo_theme_options['body_font'];
	$heading_font_value			= $gumbo_theme_options['heading_font'];
	$heading_font_weight		= $gumbo_theme_options['heading_weight'];
	$heading_font_transform		= $gumbo_theme_options['heading_uppercase'];
	$body_font_options			= $theme_options_fields['gumbo_typography_section']['fields']['body_font']['control_args']['choices'];
	$heading_font_options		= $theme_options_fields['gumbo_typography_section']['fields']['heading_font']['control_args']['choices'];
	$bg_repeat					= get_theme_mod( 'background_repeat' ); ?>
	
	<style type="text/css" id="gumbo-generated-css">
	<?php if ( isset( $body_font_value ) && 'helvetica' != $body_font_value ) : // Body font ?>
		body, button, input, select, textarea, .site-description {
			font-family: <?php echo $body_font_options[ $body_font_value ]['font_family']; ?>;
		}
	<?php endif; ?>
	
	<?php if ( isset( $heading_font_value ) && 'helvetica' != $heading_font_value ) : // Heading font ?>
		h1, h2, h3, h4, h5, h6 {
			font-family: <?php echo $heading_font_options[ $heading_font_value ]['font_family']; ?>;
		}
	<?php endif; ?>

	<?php if ( ! $heading_font_weight ) : // Heading font not bold ?>
		h1, h2, h3, h4, h5, h6 {
			font-weight: normal;
		}
	<?php endif; ?>

	<?php if ( $heading_font_transform ) : // Heading font not bold ?>
		h1, h2, h3, h4, h5, h6 {
			text-transform: uppercase;
		}
	<?php endif; ?>

	<?php if ( isset( $primary_color ) && '' != $primary_color ) : // Primary color ?>
		.custom-primary-color .entry-content a,
		.custom-primary-color .entry-summary a,
		.custom-primary-color #comments a,
		.custom-primary-color .widget a,
		.custom-primary-color .star-rating {
			color: <?php echo $primary_color; ?>
		}
		.custom-primary-color #commentform #submit,
		.custom-primary-color .comment-reply-link,
		.custom-primary-color .wpcf7 input[type="submit"],
		.custom-primary-color .protected-post-form input[type="submit"],
		.custom-primary-color .page-numbers.current,
		.custom-primary-color .page-links > span,
		.custom-primary-color #main #content .woocommerce-pagination .current,
		.custom-primary-color #main .more-link,
		.custom-primary-color .navigation-main .sub-menu a:hover,
		.custom-primary-color #infinite-handle span {
			background: <?php echo $primary_color; ?>;
		}
	<?php endif; ?>

	<?php if ( isset( $header_background_color ) && '' != $header_background_color ) : // Header background color ?>
		#masthead {
			background-color: <?php echo $header_background_color; ?> !important;
		}
	<?php endif; ?>
	
	<?php if ( 'no-repeat' == $bg_repeat ) : // Custom background stretch ?>
		body.custom-background {
			background-size: 100%;
		}
	<?php endif; ?>
	</style>

<?php }
add_action( 'wp_head', 'gumbo_generated_css' );


/**
 * Internal CSS for accent color
 *
 * @link	http://24ways.org/2010/calculating-color-contrast/
 * @since	Gumbo 1.0
 */
function gumbo_get_color_contrast( $hexcolor ){
	$r = hexdec( substr( $hexcolor, 0, 2 ) );
	$g = hexdec( substr( $hexcolor, 2, 2 ) );
	$b = hexdec( substr( $hexcolor, 4, 2 ) );
	$yiq = ( ( $r*299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;
	return ( $yiq >= 128 ) ? '#303030' : '#fcfcfc';
}


/**
 * Count number of widgets in a sidebar
 * Used to add classes to widget areas so widgets can be displayed one, two or three per row
 *
 * @uses	wp_get_sidebars_widgets()		http://codex.wordpress.org/Function_Reference/wp_get_sidebars_widgets
 * @since	Gumbo 1.0
 */
function gumbo_count_widgets( $sidebar_id ) {
	/* 
	 * Count widgets in footer widget area
	 * Used to set widget width based on total count
	 */
	$sidebars_widgets_count = wp_get_sidebars_widgets();
	if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) :
		$widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );
		$widget_classes = 'widget-count-' . count( $sidebars_widgets_count[ $sidebar_id ] );
		if ( $widget_count % 4 == 0 || $widget_count > 6 ) : // four per row if four widgets or more than 6
			$widget_classes .= ' per-row-4';
		elseif ( $widget_count % 3 == 0 || $widget_count > 3 ) :
			$widget_classes .= ' per-row-3';
		elseif ( 2 == $widget_count ) :
			$widget_classes .= ' per-row-2';
		endif; 
		 
		return $widget_classes;
	endif;
}


/**
 * Retrieves the attachment ID from the file URL
 * Used to get attachment object for logo image added through Theme Customizer
 *
 * @link		http://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/
 * @return 		$attachment_array	array
 *				[0] - URL
 *				[1] - width
 *				[2] - height
 * @since		Gumbo 1.0
 */
function gumbo_get_logo_image( $attachment_url ) {
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) :
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
	endif;

	$attachment_array = wp_get_attachment_image_src( $attachment_id, 'full' );

	return $attachment_array; 
}


/**
 * Checks if post hides header
 *
 * @since	Gumbo 1.0
 */
function gumbo_has_no_header() {
	global $post;
	$gumbo_has_no_header = false;
	
	if ( is_singular() && get_post_meta( $post->ID, '_gumbo_has_no_header', true ) ) :
		$gumbo_has_no_header = true;
	endif;
		
	return $gumbo_has_no_header;
}


/**
 * Checks if post hides footer
 *
 * @since	Gumbo 1.0
 */
function gumbo_has_no_footer() {
	global $post;
	$gumbo_has_no_header = false;
	
	if ( is_singular() && get_post_meta( $post->ID, '_gumbo_has_no_footer', true ) ) :
		$gumbo_has_no_header = true;
	endif;
		
	return $gumbo_has_no_header;
}