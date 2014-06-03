<?php
/**
 * The template part that displays a single quote post in archives.
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php tha_entry_top(); ?>
	
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php gumbo_post_meta_bottom_compact(); ?>
			
<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>