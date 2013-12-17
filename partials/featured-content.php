<?php
/**
 * The template part that displays featured posts.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php
// Grab featured posts, check if they need to be displayed
$featured_posts = thsp_fetch_featured_posts();
$thsp_theme_options = thsp_cbp_get_options_values();
if ( ! empty( $featured_posts ) && $thsp_theme_options['display_featured'] && '' != $thsp_theme_options['featured_content_tag'] ) : ?>

	<div id="featured-content" class="inner flexslider">
		<ul class="slides">
			<?php foreach ( $featured_posts as $featured_post ) : ?>
			<?php
			if ( has_post_thumbnail($thumbnail->ID)) :
			$featured_image = get_the_post_thumbnail( $featured_post->ID, 'thsp-featured-content' ); ?>
			<li><a href="<?php echo get_permalink( $featured_post->ID ); ?>" title="<?php echo esc_attr( get_the_title( $featured_post->ID ) ); ?>">
				<?php echo $featured_image; ?>
				<div class="featured-content-text">
					<h2 class="featured-post-title"><?php echo get_the_title( $featured_post->ID ); ?></h2>
					<?php if ( has_excerpt( $featured_post->ID ) ) : ?>
					<div class="featured-post-excerpt"><?php echo $featured_post->post_excerpt; ?></div>
					<?php endif; ?>
				</div>
			</a></li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>

<?php endif; ?>