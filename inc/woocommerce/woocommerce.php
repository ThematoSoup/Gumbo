<?php

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Theme wrapper
function my_theme_wrapper_start() { ?>
	<div id="primary" class="content-area image-attachment">
		<?php tha_content_before(); ?>
		<div id="content" class="site-content" role="main">
			<?php tha_content_top(); ?>

<?php }
add_action( 'woocommerce_before_main_content', 'my_theme_wrapper_start', 10 );

// Theme wrapper
function my_theme_wrapper_end() { ?>
			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->
<?php }
add_action( 'woocommerce_after_main_content', 'my_theme_wrapper_end', 10 );


// Register Store Sidebar
function gumbo_woocommerce_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Store Sidebar', 'gumbo' ),
		'description' => __( 'This widget area is used with WooCommerce store pages.', 'gumbo' ),
		'id' => 'store-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget store-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'gumbo_woocommerce_widgets_init' );


// Replace sidebar (function is pluggable)
function woocommerce_get_sidebar() {
	woocommerce_get_template( 'inc/woocommerce/woocommerce-sidebar.php' );
}


// Disable Jetpack Infinite Scroll on WooCommerce pages
function gumbo_woocommerce_disable_infinite_scroll() {
    $supported = current_theme_supports( 'infinite-scroll' ) && ( is_home() || is_archive() ) && ( ! is_woocommerce() );

    return $supported;
}
add_filter( 'infinite_scroll_archive_supported', 'gumbo_woocommerce_disable_infinite_scroll' );


/**
 * Output the related products. Overrides a pluggable WooCommerce function.
 *
 * @access public
 * @subpackage	Product
 * @return void
 */
function woocommerce_output_related_products() {
	woocommerce_related_products( 4, 4 );
}


// Change number of products per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 16;' ), 20 );