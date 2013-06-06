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
	<?php if ( ( 'layout_1' == $thsp_theme_options['post_layout'] || 'layout_2' == $thsp_theme_options['post_layout'] ) && has_post_thumbnail() ) : ?>
		<a class="entry-thumbnail" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><img src="http://lorempixel.com/660/300" /></a>
	<?php endif; // has_post_thumbnail() and post layout check ?>
	
	<?php if ( 'layout_2' == $thsp_theme_options['post_layout'] || 'layout_3' == $thsp_theme_options['post_layout'] ) : ?>
	<div class="entry-aside">
		<?php if ( 'layout_3' == $thsp_theme_options['post_layout'] ) : ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<a class="entry-thumbnail" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><img src="http://lorempixel.com/128/128" /></a>
			<?php endif; // has_post_thumbnail() and post layout check ?>
		<?php else : ?>
			<?php echo get_avatar( get_the_author_meta('ID'), 128 ); ?>
		<?php endif; ?>
	</div><!-- .entry aside -->
	<div class="entry-main">
	<?php endif; // post layout check ?>
			
		<?php tha_entry_top(); ?>
		
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php thsp_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
	
		<?php if ( is_search() || 'excerpt' == $thsp_theme_options['post_archives_show'] ) : // Only display Excerpts for Search and if that option is selected ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'gumbo' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'gumbo' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; // is_search() ?>
	
		<footer class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'gumbo' ) );
					if ( $categories_list && thsp_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( __( 'Posted in %1$s', 'gumbo' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>
	
				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'gumbo' ) );
					if ( $tags_list ) :
				?>
				<span class="sep"> | </span>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'gumbo' ), $tags_list ); ?>
				</span>
				<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>
	
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="sep"> | </span>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'gumbo' ), __( '1 Comment', 'gumbo' ), __( '% Comments', 'gumbo' ) ); ?></span>
			<?php endif; // 'post' == get_post_type() ?>
	
			<?php edit_post_link( __( 'Edit', 'gumbo' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->

		<?php tha_entry_bottom(); ?>

	<?php if ( 'layout-3' == $thsp_theme_options['post_layout'] || 'layout-4' == $thsp_theme_options['post_layout'] ) : ?>
	</div><!-- .entry-main-->
	<?php endif; // post layout check ?>		
	
</article><!-- #post-<?php the_ID(); ?> -->
<?php tha_entry_after(); ?>