<?php
/**
 * Template Name: Widgetized Template
 *
 * Similar to 2012 homepage template
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php tha_content_before(); ?>
		<div id="content" class="site-content" role="main">
			<?php tha_content_top(); ?>

			<?php $widgetized_text_position = ( get_post_meta( $post->ID, '_gumbo_widgetized_text_position', true ) ? get_post_meta( $post->ID, '_gumbo_widgetized_text_position', true ) : 'left' ); ?>
			<div id="widgetized-homepage-top" class="widgetized-text-<?php echo $widgetized_text_position; ?> clear">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php tha_entry_before(); ?>

				<?php if ( 'right' == $widgetized_text_position || 'bottom' == $widgetized_text_position ) : ?>
				<div id="widgetized-homepage-aside">
				<?php
				if ( get_post_meta( $post->ID, '_gumbo_video_url', true ) ) :
					echo '<div class="widgetized-homepage-video-container">';
					echo wp_oembed_get( get_post_meta( $post->ID, '_gumbo_video_url', true ) );
					echo '</div>';
				elseif ( has_post_thumbnail() ) :
					the_post_thumbnail( 'large' );
				endif;
				?>
				</div><!-- #widgetized-homepage-aside -->
				<?php endif; ?>

				<!-- Page title and content -->
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'widgetized-homepage-text' ); ?>>
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
				<!-- End page title and content -->
				
				<?php if ( 'left' == $widgetized_text_position || 'top' == $widgetized_text_position ) : ?>
				<div id="widgetized-homepage-aside">
				<?php
				if ( get_post_meta( $post->ID, '_gumbo_video_url', true ) ) :
					echo '<div class="widgetized-homepage-video-container">';
					echo wp_oembed_get( get_post_meta( $post->ID, '_gumbo_video_url', true ) );
					echo '</div>';
				elseif ( has_post_thumbnail() ) :
					the_post_thumbnail( 'large' );
				endif;
				?>
				</div><!-- #widgetized-homepage-aside -->
				<?php endif; ?>

				<?php tha_entry_after(); ?>
			<?php endwhile; // end of the loop. ?>
			</div><!-- #widgetized-homepage-top -->

			<?php if ( is_active_sidebar( 'homepage-widget-area' ) ) : ?>
			<?php $widgets_per_row = ( get_post_meta( $post->ID, '_gumbo_widgetized_widgets_per_row', true ) ? get_post_meta( $post->ID, '_gumbo_widgetized_widgets_per_row', true ) : 4 ); ?>
			<div id="widgetized-homepage-widgets" class="flexible-widget-area <?php echo gumbo_count_widgets( 'homepage-widget-area' ); ?>">
				<?php dynamic_sidebar( 'homepage-widget-area' ); ?>
			</div><!-- #widgetized-homepage-widgets -->
			<?php endif; ?>

			<?php tha_content_bottom(); ?>
		</div><!-- #content -->
		<?php tha_content_after(); ?>
	</div><!-- #primary -->
	
<?php get_footer(); ?>