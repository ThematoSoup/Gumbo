<?php
/**
 * The template part that displays single post in Masonry template.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'masonry-brick' ); ?>>
<?php tha_entry_top(); ?>

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
				__( '%1$s ago', 'gumbo' ),
				human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
			);
			?>
		</a></span>
			
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="post-comments"><?php comments_popup_link( __( 'Leave a comment', 'gumbo' ), __( '1 Comment', 'gumbo' ), __( '% Comments', 'gumbo' ) ); ?></span>
		<?php endif; ?>
	</footer><!-- .entry-footer -->

<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>