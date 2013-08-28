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
					
					<div class="project-meta">
						<h3><?php _e( 'Project Details', 'gumbo' ); ?></h3>
						<dl>
						<?php
						// Show portfolio taxonomy terms 
						the_terms( $post->ID, 'steroids_project_categories', '<dt>' . __( 'Project Category', 'gumbo' ) . '</dt><dd>', ', ', '</dd>' );
						?>
					
						<?php
						// Show client name and URL
						if ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) || get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) ) :
							echo '<dt>' . __( 'Client', 'gumbo' ) . '</dt>';
							echo '<dd>';
							if ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) && get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) ) :
								echo '<a href="' . get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) . '">' . get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) . '</a>';
							elseif ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) ) :
								echo get_post_meta( $post->ID, '_steroids_portfolio_client_name', true );
							else :
								echo get_post_meta( $post->ID, '_steroids_portfolio_client_url', true );
							endif;
						endif;
						?>
						
						<?php
						// Show project date
						if ( get_post_meta( $post->ID, '_steroids_portfolio_project_date', true ) ) :
							echo '<dt>' . __( 'Date', 'gumbo' ) . '</dt>';
							echo '<dd>' . date( get_option( 'date_format' ), get_post_meta( $post->ID, '_steroids_portfolio_project_date', true ) ) . '</dd>';
						endif;
						?>
						</dl>
					
						<?php
						// Show Project URL button
						if ( get_post_meta( $post->ID, '_steroids_portfolio_project_url', true ) ) :
							echo '<p><a class="more-link" href="' . get_post_meta( $post->ID, '_steroids_portfolio_project_url', true ) . '">' . __( 'Visit Project', 'gumbo' ) . '</a></p>';
						endif;
						?>
					</div><!-- .project-meta -->
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