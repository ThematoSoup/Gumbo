<?php
/**
 * The template part that displays a single video post in archives.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tha_entry_top(); ?>
	
	<?php 
	// If no embed at this point and the user has 'auto embeds' turned on, let's check for URLs in the post.
	if ( get_option( 'embed_autourls' ) ) :
		preg_match_all( '|^\s*(https?://[^\s"]+)\s*$|im', get_the_content(), $matches, PREG_SET_ORDER );

		// If URL matches are found, loop through them to see if we can get an embed.
		if ( is_array( $matches ) ) :
			foreach ( $matches  as $value ) :
				$embedded_video = $value[0];
				// If no embed, continue looping through the array of matches.
				if ( empty( $embed ) )
					continue;
			endforeach;
		endif;
	endif;
	?>
	
	<?php if ( ! empty( $embedded_video ) ) : ?>
	<header class="entry-header">
		<?php echo wp_oembed_get( $embedded_video ); ?>
	</header>
	<?php endif; ?>

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