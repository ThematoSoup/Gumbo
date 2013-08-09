<?php
/**
 * The Template for displaying single portfolio project.
 * Requires Steroids plugin and its Portfolio module to be active
 *
 * @package Gumbo
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php tha_content_before(); ?>
		<div id="content" class="site-content" role="main">
			<?php tha_content_top(); ?>

			<?php while ( have_posts() ) : the_post(); ?>
	
				<?php get_template_part( '/partials/portfolio/project', 'a' ); ?>
	
			<?php endwhile; // end of the loop. ?>

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>