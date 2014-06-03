<?php
/**
 * Functions added to theme hooks.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 * @license		http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 */


/**
 * Add sub-header widget area to tha_header_after hook
 */
function gumbo_add_sub_header() {
	if ( is_active_sidebar( 'sub-header-widget-area' ) ) :
		echo '<div id="sub-header" class="flexible-widget-area ' . gumbo_count_widgets( 'sub-header-widget-area' ) . '">';
			echo '<div class="inner clear">';
			dynamic_sidebar( 'sub-header-widget-area' );
			echo '</div>';
		echo '</div><!-- #sub-header -->';
	endif;
}
add_action( 'tha_header_after', 'gumbo_add_sub_header', 10 );


/**
 * Add slider to tha_header_after hook
 */
function gumbo_add_top_slider() {
	global $post;
	
	if ( is_singular() && ( get_post_meta( $post->ID, '_gumbo_slider_revolution', true ) || get_post_meta( $post->ID, '_gumbo_slider_layer', true ) ) ) :
		echo '<div id="top-slider">';
			if( get_post_meta( $post->ID, '_gumbo_slider_revolution', true ) ) :
				putRevSlider( get_post_meta( $post->ID, '_gumbo_slider_revolution', true ) );
			elseif( get_post_meta( $post->ID, '_gumbo_slider_layer', true ) ) :
				layerslider( get_post_meta( $post->ID, '_gumbo_slider_layer', true ) );
			endif;
		echo '</div>';
	endif;
}
add_action( 'tha_header_after', 'gumbo_add_top_slider', 20 );


/**
 * Add above footer widget area to tha_header_after hook
 */
function gumbo_add_above_footer() {
	if ( is_active_sidebar( 'above-footer-widget-area' ) ) :
		echo '<div id="above-footer" class="flexible-widget-area ' . gumbo_count_widgets( 'above-footer-widget-area' ) . '">';
			echo '<div class="inner clear">';
			dynamic_sidebar( 'above-footer-widget-area' );
			echo '</div>';
		echo '</div><!-- #above-footer -->';
	endif;
}
add_action( 'tha_footer_before', 'gumbo_add_above_footer' );


function gumbo_footer_credits() { ?>
	<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'gumbo' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'gumbo' ), 'WordPress' ); ?></a>
	<span class="sep"> | </span>
	<?php printf( __( 'Theme: %1$s by %2$s.', 'gumbo' ), 'Gumbo', 'ThematoSoup' ); ?>
<?php }
add_action( 'gumbo_credits', 'gumbo_footer_credits', 10 );


/**
 * Add Yoast breadcrumbs to tha_content_top action hook
 *
 * Check if WooCommerce breadcrumbs are active and let them takeover in WooCommerce pages
 *
 * @since	Gumbo 1.0
 */
function gumbo_add_yoast_breadcrumbs() {
	if ( function_exists( 'is_woocommerce' ) ) :
		if ( ! is_woocommerce() && ! is_home() && function_exists( 'yoast_breadcrumb' ) ) :
			yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		endif;
	elseif ( function_exists( 'yoast_breadcrumb' ) && ! is_home() ) :
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	endif;	
}
add_action( 'tha_content_top', 'gumbo_add_yoast_breadcrumbs', 10 );