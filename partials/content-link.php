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