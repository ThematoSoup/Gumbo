<?php
/**
 * The template part that displays a single gallery post in archives.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tha_entry_top(); ?>
	

	<header class="entry-header">
		<?php $count = count( get_post_gallery_images( $post ) ); ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?> <span>(<?php echo $count; ?> <?php _e( 'images', 'gumbo' ); ?>)</span></a></h1>
	</header>

	<div class="entry-summary">
		<?php echo get_post_gallery( $post, true ); ?>
	</div><!-- .entry-summary -->
	
	<div class="entry-meta">
		<?php
			printf( __( '<a href="%1$s" title="Permalink to %2$s">%3$s</a> was posted on <time class="entry-date" datetime="%4$s">%5$s</time>', 'gumbo' ),
				esc_url( get_permalink() ),
				esc_attr( get_the_title() ),
				get_the_title(),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			);
		?>
		
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="sep"> | </span>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'gumbo' ), __( '1 Comment', 'gumbo' ), __( '% Comments', 'gumbo' ) ); ?></span>
		<?php endif; ?>
	</div><!-- .entry-meta -->
		
	<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>