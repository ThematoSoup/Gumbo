<?php
/**
 * Template Name: Full Width
 *
 * @package Gumbo
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php tha_content_before(); ?>
		<div id="content" class="site-content" role="main">
			<?php tha_content_top(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( '/partials/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->

<?php get_footer(); ?>
