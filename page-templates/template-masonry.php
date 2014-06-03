<?php
/**
 * Template Name: Masonry
 *
 * Number of posts per page and excluded category can be set in page meta box
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
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
					<?php if ( ! get_post_meta( $post->ID, '_gumbo_hide_title', true ) ) : // Check if hide title option is checked ?>
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

			<!-- Masonry start -->
			<div id="masonry-container" class="clear">
				<?php
				/* Start the Loop */
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
				$numposts = ( get_post_meta( $post->ID, '_gumbo_posts_per_page', true ) ? get_post_meta( $post->ID, '_gumbo_posts_per_page', true ) : get_option( 'posts_per_page' ) );
				$args = array(
					'posts_per_page'		=> $numposts,
					'paged'					=> $paged,
					'ignore_sticky_posts'	=> true
				);
				$masonry_posts = new WP_Query( $args );	    				
				while ( $masonry_posts->have_posts() ) : $masonry_posts->the_post();
				?>
											
				<?php get_template_part( '/partials/content', 'masonry' ); ?>
				
				<?php endwhile; ?>
			</div><!-- #masonry	-container -->

			<nav role="navigation" id="nav-below" class="navigation-paging">
				<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'gumbo' ); ?></h1>
				<?php
				$big = 999999999; // need an unlikely integer
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $masonry_posts->max_num_pages
				) );
				?>
			</nav><!-- #nav-below -->
			<?php wp_reset_postdata(); ?>
			<!-- Masonry end -->

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->
	
<?php get_footer(); ?>