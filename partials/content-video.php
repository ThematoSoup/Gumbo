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

	<?php gumbo_post_meta_bottom_compact(); ?>
		
<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>