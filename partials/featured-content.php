<?php
/**
 * The template part that displays featured posts.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php
// Grab featured posts
$featured_posts = thsp_fetch_featured_posts();
if ( ! empty( $featured_posts ) ) : ?>

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
					<div class="featured-post-excerpt"><?php echo get_the_excerpt( $featured_post->ID ); ?></div>
				</div>
			</a></li>
			<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>

<?php endif; ?>