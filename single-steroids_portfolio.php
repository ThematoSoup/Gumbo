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
	
				<?php tha_entry_before(); ?>
				<?php $project_layout = ( get_post_meta( $post->ID, '_thsp_project_layout', true ) ? get_post_meta( $post->ID, '_thsp_project_layout', true ) : 'layout-a' ); ?>
				
				<article id="post-<?php the_ID(); ?>" class="portfolio-project <?php echo $project_layout; ?>">	
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
				
					<div class="project-media">
					<?php
					if ( get_post_meta( $post->ID, '_steroids_portfolio_video_url', true ) ) :
						echo wp_oembed_get( get_post_meta( $post->ID, '_steroids_portfolio_video_url', true ) );
					elseif ( has_post_thumbnail() ) :
						the_post_thumbnail( 'thsp-archives-featured', array( 'class' => 'entry-featured') );
					endif; // has_post_thumbnail()
					?>
					</div><!-- .project-media -->
				
					<?php tha_entry_top(); ?>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php
							wp_link_pages( array(
								'before' 		=> '<div class="page-links">' . __( 'Pages:', 'gumbo' ),
								'after'  		=> '</div>',
								'link_before'	=> '<span>',
								'link_after'	=> '</span>'
							) );
						?>
					</div><!-- .entry-content -->
					<?php tha_entry_bottom(); ?>
					
					<?php thsp_project_meta( $post ); // Defined in /inc/steroids.php ?>
				</article><!-- #post-## -->
				<?php tha_entry_after(); ?>
	
			<?php endwhile; // end of the loop. ?>

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->

<?php if ( is_active_sidebar( 'steroids-portfolio-sidebar' ) ) : ?>
	<?php tha_sidebars_before(); ?>
	<div id="secondary" class="widget-area" role="complementary">
		<?php tha_sidebar_top(); ?>
		<?php dynamic_sidebar( 'steroids-portfolio-sidebar' ); ?>
		<?php tha_sidebar_bottom(); ?>
	</div>
	<?php tha_sidebars_after(); ?>
<?php endif; ?>
<?php get_footer(); ?>