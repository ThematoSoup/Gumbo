<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php if ( is_active_sidebar( 'primary-sidebar' ) && 'no-sidebar' != thsp_get_current_layout() ) : // Only render this sidebar in not in single column layout ?>
	<?php tha_sidebars_before(); ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php tha_sidebar_top(); ?>
		<?php dynamic_sidebar( 'primary-sidebar' ) ?>
		<?php tha_sidebar_bottom(); ?>
	</div><!-- #secondary -->
	<?php tha_sidebars_before(); ?>
<?php endif; // Check if sidebar is active ?>