<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Gumbo
 */
?>

<?php tha_sidebars_before(); ?>
<div id="secondary" class="widget-area" role="complementary">
	<?php tha_sidebar_top(); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
		<aside id="search" class="widget widget_search">
			<?php get_search_form(); ?>
		</aside>

		<aside id="archives" class="widget">
			<h1 class="widget-title"><?php _e( 'Archives', 'gumbo' ); ?></h1>
			<ul>
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</aside>
	<?php endif; // end sidebar widget area ?>
	<?php tha_sidebar_bottom(); ?>
</div><!-- #secondary -->

<?php if ( thsp_check_secondary_sidebar() ) : // Only render this sidebar in 3 column layouts ?>
<div id="tertiary" class="widget-area" role="complementary">
	<?php tha_sidebar_top(); ?>
	<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>
		<aside id="meta" class="widget">
			<h1 class="widget-title"><?php _e( 'Meta', 'gumbo' ); ?></h1>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</aside>
	<?php endif; // end sidebar widget area ?>
	<?php tha_sidebar_bottom(); ?>
</div><!-- #secondary -->
<?php endif; // Check if sidebar needs to be rendered ?>
<?php tha_sidebars_before(); ?>