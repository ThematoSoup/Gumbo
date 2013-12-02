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

			<!-- Masonry start -->
			<div id="masonry-container" class="clear">
				<?php
				/* Start the Loop */
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$numposts = ( get_post_meta( $post->ID, '_thsp_posts_per_page', true ) ? get_post_meta( $post->ID, '_thsp_posts_per_page', true ) : get_option( 'posts_per_page' ) );
				$args = array(
					'posts_per_page'		=> $numposts,
					'paged'					=> $paged,
					'ignore_sticky_posts'	=> true
				);
				$masonry_posts = new WP_Query( $args );	    				
				while ( $masonry_posts->have_posts() ) : $masonry_posts->the_post();
				?>
											
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'masonry-brick' ); ?>>
					<header class="entry-header">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-thumb">
							<?php the_post_thumbnail( 'thsp-masonry' ); ?>
						</div><!-- .entry-thumb -->
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
						</a>
					</header><!-- .entry-header -->
				
					<div class="entry-summary">
						<?php echo wp_trim_words( get_the_excerpt(), 20, '&hellip;' ); ?>
					</div><!-- .entry-summary -->

					<footer class="entry-meta entry-meta-bottom">
						<span class="post-time"><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark">
							<?php
							printf(
								__( '%1$s ago' ),
								human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
							);
							?>
						</a></span>
							
						<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
							<span class="post-comments"><?php comments_popup_link( __( 'Leave a comment', 'gumbo' ), __( '1 Comment', 'gumbo' ), __( '% Comments', 'gumbo' ) ); ?></span>
						<?php endif; ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-<?php the_ID(); ?> -->
				
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