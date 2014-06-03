<?php
/**
 * The template part that displays a single link post in archives.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php tha_entry_top(); ?>
	
	<?php
	// Check if post contains a link, if not use post permalink 
	$post_link = ( get_url_in_content( get_the_content() ) ? get_url_in_content( get_the_content() ) : get_permalink() ); 
	?>
	
	<?php if ( get_the_title() ) : ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( $post_link ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '">', ' <span class="meta-nav">&rarr;</span></a></h1>' ); ?>
		</header><!-- .entry-header -->
	<?php else : ?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php endif; // get_the_title() ?>

	<?php gumbo_post_meta_bottom_compact(); ?>
		
<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>