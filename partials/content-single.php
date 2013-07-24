<?php
/**
 * @package Gumbo
 */
?>

<?php tha_entry_before(); ?>
<?php $has_post_aside_class = ( 'standard' == get_post_format() && is_active_sidebar( 'post-aside' ) ? 'has-post-aside' : '' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $has_post_aside_class . ' clear' ); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	
		<?php if ( 'standard' == get_post_format() && has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'thsp-archives-featured', array( 'class' => 'entry-featured') ); ?>
		<?php endif; // has_post_thumbnail() ?>
	</header><!-- .entry-header -->

	
	<div class="entry-main">
		<?php tha_entry_top(); ?>
		<header class="entry-meta">
			<?php if ( is_active_sidebar( 'post-top' ) ) : ?>
			<div class="entry-top">
				<?php dynamic_sidebar( 'post-top' ); ?>
			</div><!-- .entry-aside -->
			<?php
			else :
				thsp_posted_on();
			endif;
			?>
		</header><!-- .entry-meta -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	
		<?php tha_entry_bottom(); ?>
		<footer class="entry-meta">
			<?php
				/* translators: used between list items, there is a space after the comma */
				$category_list = get_the_category_list( __( ', ', 'gumbo' ) );
	
				/* translators: used between list items, there is a space after the comma */
				$tag_list = get_the_tag_list( '', __( ', ', 'gumbo' ) );
	
				if ( ! thsp_categorized_blog() ) {
					// This blog only has 1 category so we just need to worry about tags in the meta text
					if ( '' != $tag_list ) {
						$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'gumbo' );
					} else {
						$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'gumbo' );
					}
	
				} else {
					// But this blog has loads of categories so we should probably display them here
					if ( '' != $tag_list ) {
						$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'gumbo' );
					} else {
						$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'gumbo' );
					}
	
				} // end check for categories on this blog
	
				printf(
					$meta_text,
					$category_list,
					$tag_list,
					get_permalink(),
					the_title_attribute( 'echo=0' )
				);
			?>
	
			<?php edit_post_link( __( 'Edit', 'gumbo' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</div><!-- .entry-main -->

	<?php if ( 'standard' == get_post_format() && is_active_sidebar( 'post-aside' ) ) : ?>
	<div class="entry-aside">
		<?php dynamic_sidebar( 'post-aside' ); ?>
	</div><!-- .entry-aside -->
	<?php endif; // is_active_sidebar(); ?>
	
</article><!-- #post-## -->
<?php tha_entry_after(); ?>