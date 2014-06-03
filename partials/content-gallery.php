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
	
	<?php gumbo_post_meta_bottom_compact(); ?>
		
<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>