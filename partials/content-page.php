<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php tha_entry_top(); ?>

	<header class="entry-header">
		<?php if ( false == get_post_format() && has_post_thumbnail() ) : ?>
			<div class="entry-thumbnail">
			<?php
			if ( 'no-sidebar' == get_post_meta( $post->ID, '_gumbo_post_layout', true ) ) :
				// Larger image if no sidebar
				the_post_thumbnail( 'thsp-featured-content', array( 'class' => 'entry-featured') );
			else :
				the_post_thumbnail( 'thsp-archives-featured', array( 'class' => 'entry-featured') );
			endif;
			?>
			</div>
		<?php endif; // has_post_thumbnail() ?>

		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'gumbo' ), '<footer class="entry-meta"><span class="post-edit">', '</span></footer>' ); ?>

<?php tha_entry_bottom(); ?>
</article><!-- #post-## -->
<?php tha_entry_after(); ?>