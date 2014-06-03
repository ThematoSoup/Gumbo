<?php
/**
 * Template Name: Authors
 *
 * Used to display your site's authors
 * Authors can be ordered by post count or alphabetically
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
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
				
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ), 'after' => '</div>' ) ); ?>

						<!-- Authors template code -->
						<?php
						// Get custom fields that determine how authors are ordered
						$orderby_value = get_post_meta( $post->ID, '_gumbo_authors_query_orderby', true ) ? get_post_meta( $post->ID, '_gumbo_authors_query_orderby', true ) : 'display_name';
						$order_value = get_post_meta( $post->ID, '_gumbo_authors_query_order', true ) ? get_post_meta( $post->ID, '_gumbo_authors_query_order', true ) : 'ASC';
						?>
						
						<ul id="authors-list">
						<?php
							// User query
							$authors_query = new WP_User_Query( array(
								'orderby'	=> $orderby_value,
								'order'		=> $order_value,
							) );

							// Get the results from the query
							$displayed_authors = $authors_query->get_results();

							// Display authors
							foreach ( $displayed_authors as $displayed_author ) {
								// Template tag, defined in /inc/template-tags.php
								gumbo_display_an_author( $displayed_author );
							}
						?>
						</ul><!-- #authors-list -->
						<!-- End authors template code -->
					</div><!-- .entry-content -->
					<?php edit_post_link( __( 'Edit', 'gumbo' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
					<?php tha_entry_bottom(); ?>
				</article><!-- #post-## -->
				<?php tha_entry_after(); ?>

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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
