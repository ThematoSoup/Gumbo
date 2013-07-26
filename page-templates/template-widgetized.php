<?php
/**
 * Template Name: Widgetized
 *
 * @package Gumbo
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php tha_content_before(); ?>
		<div id="content" class="site-content" role="main">
			<?php tha_content_top(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php tha_entry_before(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php tha_entry_top(); ?>
					<?php if ( ! get_post_meta( $post->ID, '_thsp_hide_title', true ) ) : // Check if hide title option is checked ?>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					<?php endif; ?>
				
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->
					<?php edit_post_link( __( 'Edit', 'gumbo' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
					<?php tha_entry_bottom(); ?>
				</article><!-- #post-## -->
				<?php tha_entry_after(); ?>

			<?php endwhile; // end of the loop. ?>

			<!-- Widgetized start -->
			<!-- Widgetized end -->

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->
	
<?php get_footer(); ?>