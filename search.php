<?php
/**
 * The template for displaying Search Results pages.
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

			<?php if ( have_posts() ) : ?>
	
				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'gumbo' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->
	
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php get_template_part( '/partials/content', 'search' ); ?>
	
				<?php endwhile; ?>
	
				<?php gumbo_content_nav( 'nav-below' ); ?>
	
			<?php else : ?>
	
				<?php get_template_part( '/partials/no-results', 'search' ); ?>
	
			<?php endif; ?>

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>