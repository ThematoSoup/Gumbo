<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<?php tha_content_before(); ?>
		<div id="content" class="site-content" role="main">
			<?php tha_content_top(); ?>

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'gumbo' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try search or one of the links below?', 'gumbo' ); ?></p>
					<div class="widget_search">
						<?php get_search_form(); ?>
					</div>
					
					<div class="widgets-404 clear">
						<?php the_widget( 'WP_Widget_Recent_Posts', 'number=5' ); ?>
	
						<?php if ( gumbo_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
							<div class="widget widget_categories">
								<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'gumbo' ); ?></h2>
								<ul>
									<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 5 ) ); ?>
								</ul>
							</div><!-- .widget -->
						<?php else :
							the_widget( 'WP_Widget_Tag_Cloud' );
						endif; ?>
	
						<?php
						/* translators: %1$s: smiley */
						$archive_content = '<p>' . __( 'Try looking in the monthly archives.', 'gumbo' ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
						?>
					</div><!-- .404-widgets -->
				</div><!-- .entry-content -->
			</article><!-- #post-0 .post .error404 .not-found -->

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</section><!-- #primary -->

<?php get_footer(); ?>