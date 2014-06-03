<?php
/**
 * The Sidebar containing the main widget area.
 *
 * For single posts and pages custom widget area is stored
 * as a custom field. If WooSidebars plugin is active, this
 * custom widget area is used instead of Primary Sidebar.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php
$current_sidebar = ( in_array( 'woosidebars/woosidebars.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && get_post_meta( $post->ID, '_gumbo_widget_area', true ) ? get_post_meta( $post->ID, '_gumbo_widget_area', true ) : 'primary-sidebar' );
if ( is_active_sidebar( $current_sidebar ) && 'no-sidebar' != gumbo_get_current_layout() ) : // Only render this sidebar in not in single column layout ?>
	<?php tha_sidebars_before(); ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php tha_sidebar_top(); ?>
		<?php dynamic_sidebar( $current_sidebar ) ?>
		<?php tha_sidebar_bottom(); ?>
	</div><!-- #secondary -->
	<?php tha_sidebars_before(); ?>
<?php endif; // Check if sidebar is active ?>