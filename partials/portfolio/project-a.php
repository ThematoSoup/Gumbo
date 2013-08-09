<?php
/**
 * @package Gumbo
 */
?>

<?php tha_entry_before(); ?>
<article id="post-<?php the_ID(); ?>">	
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta"><?php the_terms( $post->ID, 'steroids_project_categories' ); ?></div>
	</header><!-- .entry-header -->

	<div class="project-media">
	<?php
	if ( get_post_meta( $post->ID, '_steroids_portfolio_video_url', true ) ) :
		echo wp_oembed_get( get_post_meta( $post->ID, '_steroids_portfolio_video_url', true ) );
	elseif ( has_post_thumbnail() ) :
		the_post_thumbnail( 'thsp-archives-featured', array( 'class' => 'entry-featured') );
	endif; // has_post_thumbnail()
	?>
	</div><!-- .project-media -->

	<?php tha_entry_top(); ?>
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
	<?php tha_entry_bottom(); ?>
	
	<?php thsp_project_meta( $post ); // Defined in /inc/steroids.php ?>
</article><!-- #post-## -->
<?php tha_entry_after(); ?>