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
	$thsp_theme_options = thsp_cbp_get_options_values(); 
?>
<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tha_entry_top(); ?>
	
	<header class="entry-header">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
			<?php 
			if ( has_post_thumbnail() ) :
				the_post_thumbnail( 'thsp-archives-featured', array( 'class' => 'entry-featured') );
			endif; // has_post_thumbnail()
			?>
			
			<?php $count = post_format_tools_get_image_attachment_count(); ?>
			<h1 class="entry-title"><?php the_title(); ?> <span>(<?php echo $count; ?> <?php _e( 'images', 'gumbo' ); ?>)</span></h1>
		</a>
	</header>

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