<?php
/**
 * The template part that displays a single post in archives.
 *
 * Based on theme settings one of three possible layouts is shown.
 * Excerpt or full content is shown, also based on theme settings.
 *
 * @package Gumbo
 */
?>

<?php 
	// Get theme options
	$gumbo_theme_options = thsp_cbp_get_options_values(); 
?>
<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php tha_entry_top(); ?>
	
	<?php if ( has_post_thumbnail() && false == get_post_format() ) : ?>
		<a class="entry-thumbnail" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thsp-archives-featured', array( 'class' => 'entry-featured') ); ?></a>
	<?php endif; // has_post_thumbnail() ?>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
			<?php gumbo_post_meta_top(); ?>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'gumbo' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
	<?php endif; // is_search() ?>

	<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		<?php gumbo_post_meta_bottom(); ?>
	<?php endif; // End if 'post' == get_post_type() ?>
		
<?php tha_entry_bottom(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>