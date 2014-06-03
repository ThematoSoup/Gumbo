<?php
/**
 * The template used for displaying post content in post.php
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */
?>

<?php tha_entry_before(); ?>
<?php $has_post_aside_class = ( false == get_post_format() && is_active_sidebar( 'post-aside' ) ? 'has-post-aside' : '' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $has_post_aside_class . ' clear' ); ?>>
<?php tha_entry_top(); ?>
	
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

	<?php if ( false == get_post_format() && is_active_sidebar( 'post-aside' ) ) : ?>
	<div class="entry-aside">
		<?php dynamic_sidebar( 'post-aside' ); ?>
	</div><!-- .entry-aside -->
	<?php endif; // is_active_sidebar(); ?>

	<header class="entry-header">		
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php gumbo_post_meta_top(); ?>
	</header><!-- .entry-header -->
	
	<div class="entry-main">
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' 		=> '<div class="page-links">' . __( 'Pages:', 'gumbo' ),
					'after'  		=> '</div>',
					'link_before'	=> '<span>',
					'link_after'	=> '</span>'
				) );
			?>
		</div><!-- .entry-content -->
	
	</div><!-- .entry-main -->

	<?php gumbo_post_meta_bottom(); ?>
	
<?php tha_entry_bottom(); ?>
</article><!-- #post-## -->
<?php tha_entry_after(); ?>