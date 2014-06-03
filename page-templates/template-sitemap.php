<?php
/**
 * Template Name: Sitemap
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

						<!-- Sitemap start -->
						<div id="sitemap-authors" class="sitemap-section">
							<h2><?php _e( 'Authors', 'gumbo' ); ?></h2>
							<ul>
							<?php
							wp_list_authors(
								array(
									'exclude_admin' => false,
								)
							);
							?>
							</ul>
						</div>
						
						<div id="sitemap-pages" class="sitemap-section">
							<h2><?php _e( 'Pages', 'gumbo' ); ?></h2>
							<ul>
							<?php
							// Add pages you'd like to exclude in the exclude here
							wp_list_pages(
								array(
									'exclude' => '',
									'title_li' => '',
								)
							);
							?>
							</ul>
						</div><!-- #sitemap-pages -->
						
						<div id="sitemap-posts" class="sitemap-section">
							<h2 id="posts"><?php _e( 'Posts', 'gumbo' ); ?></h2>
							<?php
							// Add categories you'd like to exclude in the exclude here
							$gumbo_sitemap_cats = get_categories();
							foreach ( $gumbo_sitemap_cats as $gumbo_sitemap_cat ) :
								echo '<h3>' . $gumbo_sitemap_cat->cat_name . '</h3>';
								echo wpautop( $gumbo_sitemap_cat->description );
								echo '<ul>';
								$gumbo_sitemap_posts_args = array(
									'posts_per_page'	=> -1,
									'cat'				=> $gumbo_sitemap_cat->cat_ID
								);
								$gumbo_sitemap_cat_posts = new WP_Query( $gumbo_sitemap_posts_args );
								while( $gumbo_sitemap_cat_posts->have_posts() ) :
									$gumbo_sitemap_cat_posts->the_post();
									echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
								endwhile;
								echo '</ul>';
								wp_reset_postdata();
							endforeach;
							?>
						</div><!-- #sitemap-posts -->
						
						<?php
						$cpt_args = array(
							'public'   => true,
							'_builtin' => false
						); 
						$cpt_output = 'names';
						$cpt_operator = 'and';
						$custom_post_types = get_post_types( $cpt_args, $cpt_output, $cpt_operator ); 
						foreach ( $custom_post_types  as $custom_post_type ) :						
							$custom_post_type_object = get_post_type_object( $custom_post_type );
							$gumbo_custom_post_type_args = array(
								'post_type'			=> $custom_post_type_object->name,
								'posts_per_page'	=> -1
							);
							$gumbo_custom_post_type_posts = new WP_Query( $gumbo_custom_post_type_args );
							if ( $gumbo_custom_post_type_posts->have_posts() ) :
								echo '<div id="sitemap-' . $custom_post_type_object->name . '" class="sitemap-section">';
									echo '<h2>' . $custom_post_type_object->labels->name . '</h2>';
										echo '<ul>';
										while ( $gumbo_custom_post_type_posts->have_posts() ) :
											$gumbo_custom_post_type_posts->the_post();
											echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
										endwhile;
									echo '</ul>';
								echo '</div><!-- .sitemap-section -->';
							endif;
						endforeach;
						?>
						<!-- Sitemap end -->
					</div><!-- .entry-content -->
					
					<?php edit_post_link( __( 'Edit', 'gumbo' ), '<footer class="entry-meta entry-meta-bottom"><span class="post-edit">', '</span></footer>' ); ?>
					
					<?php tha_entry_bottom(); ?>
				</article><!-- #post-## -->
				<?php tha_entry_after(); ?>

				<?php
					wp_reset_postdata();
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
