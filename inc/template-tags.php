<?php
/**
 * Custom template tags for Gumbo theme.
 *
 * ========
 * Contents
 * ========
 *
 * - Content navigation
 * - Comment callback
 * - Post meta callbacks
 * - Categorized blog check
 * - Categorized blog transient flusher
 * - Featured posts callback
 * - Featured posts transient flusher
 *
 * @package Gumbo
 */


if ( ! function_exists( 'gumbo_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function gumbo_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Get current theme options
	$theme_options = thsp_cbp_get_options_values();
	
	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;
		
	if ( 'nav-below' == $nav_id && ! $theme_options['post_navigation_below'] )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'gumbo' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>
		<?php
			$previous_post = get_adjacent_post( false, '', true );
			$prev_post_class = ( has_post_thumbnail( $previous_post->ID ) ? 'has-image' : '' );
			$next_post = get_adjacent_post( false, '', false );
			$next_post_class = ( has_post_thumbnail( $next_post->ID ) ? 'has-image' : '' );
			echo '<div class="prev prev-post ' . $prev_post_class . '">';
				echo '<a href="' . get_permalink( $previous_post->ID ) . '" title="' . sprintf( __( 'Previous post: %1$s', 'gumbo' ), esc_attr( get_the_title( $previous_post->ID ) ) ) . '">';
					echo '<div class="clear">';
						echo get_the_post_thumbnail( $previous_post->ID, 'thumbnail');
						echo '<span class="heading">' . __( 'Previous post', 'gumbo' ) . '</span>';
						echo '<div class="title previous-title">' . get_the_title( $previous_post->ID ) . '</div>';
					echo '</div>';
				echo '</a>';
			echo '</div>';
			echo '<div class="next next-post ' . $next_post_class . '">';
				echo '<a href="' . get_permalink( $next_post->ID ) . '" title="' . sprintf( __( 'Next post: %1$s', 'gumbo' ), esc_attr( get_the_title( $next_post->ID ) ) ) . '">';
					echo '<div class="clear">';
						echo get_the_post_thumbnail( $next_post->ID, 'thumbnail');
						echo '<span class="heading">' . __( 'Next post', 'gumbo' ) . '</span>';
						echo '<div class="title next-title">' . get_the_title( $next_post->ID ) . '</div>';
					echo '</div>';
				echo '</a>';
			echo '</div>';
		?>
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages
		global $wp_query;
		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;'
		) );
	endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // gumbo_content_nav


if ( ! function_exists( 'gumbo_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function gumbo_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'gumbo' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'gumbo' ), '<span class="edit-link">', '<span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 48 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'gumbo' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'gumbo' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'gumbo' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'gumbo' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for gumbo_comment()


if ( ! function_exists( 'gumbo_post_meta_top' ) ) :
/**
 * Prints HTML with post categories, if it's not a single category blog.
 */
function gumbo_post_meta_top() {
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'gumbo' ) );
		echo '<div class="entry-meta entry-meta-top">';
			if ( gumbo_categorized_blog() ) :
				echo '<span class="post-categories">' . $category_list . '</span>';
			endif;
			echo '<span class="post-time"><a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_time() ) . '" rel="bookmark"><time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></a></span>';
			echo '<span class="post-author author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts by %s', 'gumbo' ), get_the_author() ) ) .'" rel="author">' . get_the_author() .'</a></span>';
			if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
				echo '<span class="post-comments">';
				comments_popup_link( __( 'Leave a comment', 'gumbo' ), __( '1 Comment', 'gumbo' ), __( '% Comments', 'gumbo' ) );
				echo '</span>';
			endif;
		echo '</div>';
}
endif;


if ( ! function_exists( 'gumbo_post_meta_bottom' ) ) :
/**
 * Prints HTML with tags and edit link.
 */
function gumbo_post_meta_bottom() {
	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( ', ', 'gumbo' ) );
	echo '<footer class="entry-meta entry-meta-bottom">';
		if ( '' != $tag_list ) :
			echo '<span class="post-tags">' . $tag_list . '</span>';
		endif;
		edit_post_link( __( 'Edit', 'gumbo' ), '<span class="post-edit">', '</span>' );
	echo '</footer>';
}
endif;

if ( ! function_exists( 'gumbo_post_meta_bottom_compact' ) ) :
/**
 * Prints HTML with post categories, if it's not a single category blog.
 */
function gumbo_post_meta_bottom_compact() {
	echo '<footer class="entry-meta entry-meta-bottom">';
		echo '<span class="post-time"><a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_time() ) . '" rel="bookmark"><time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></a></span>';
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
			echo '<span class="post-comments">';
			comments_popup_link( __( 'Leave a comment', 'gumbo' ), __( '1 Comment', 'gumbo' ), __( '% Comments', 'gumbo' ) );
			echo '</span>';
		endif;
		edit_post_link( __( 'Edit', 'gumbo' ), '<span class="post-edit">', '</span>' );
	echo '</footer>';
}
endif;


/**
 * Template tag that displays an author in Authors page template
 *
 * @param	$author			Author object
 * @since 	Gumbo 1.0
 */
function gumbo_display_an_author( $author ) { ?>
	<li class="clear">
		<div class="author-avatar">
			<?php echo get_avatar( $author->ID, 96 ); ?>
		</div><!-- .author-avatar -->
		<div class="author-text">
			<h2 class="author-name"><a href="<?php echo get_author_posts_url( $author->ID ); ?>"><?php echo get_the_author_meta( 'display_name', $author->ID ); ?></a></h2>
			<?php echo wpautop( get_the_author_meta( 'description', $author->ID ) ); ?>
			
			<!-- Latest posts by author -->
			<?php
				$args = array (
					'posts_per_page'	=> 3,
					'author'			=> $author->ID
				);
				$posts_by_author = new WP_Query( $args );
				if ( $posts_by_author->have_posts() ) : ?>
					<h3><?php _e( 'Latest posts', 'gumbo' ); ?></h3>
					<ul class="latest-by-author">
						<?php while ( $posts_by_author->have_posts() ) : $posts_by_author->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'gumbo' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					</ul><!-- .latest-by-author -->
				<?php
				endif;
				wp_reset_postdata();
			?>
			<!-- End latest posts by author -->											
		</div><!-- .author-text -->
	</li>
<?php }


/**
 * Returns true if a blog has more than 1 category
 */
function gumbo_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so gumbo_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so gumbo_categorized_blog should return false
		return false;
	}
}


/**
 * Flush out the transients used in gumbo_categorized_blog
 */
function gumbo_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'gumbo_category_transient_flusher' );
add_action( 'save_post', 'gumbo_category_transient_flusher' );


/**
 * Returns true if a blog has more than 1 category
 */
function gumbo_fetch_featured_posts() {
	if ( false === ( $gumbo_featured_posts = get_transient( 'gumbo_featured_posts' ) ) ) {
		// Get theme options values
		$gumbo_theme_options = thsp_cbp_get_options_values();
		$featured_query_args = array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $gumbo_theme_options['featured_posts_count'],
			'tag'				=> $gumbo_theme_options['featured_content_tag']
		);
		$gumbo_featured_posts = get_posts( $featured_query_args );

		set_transient( 'gumbo_featured_posts', $gumbo_featured_posts );
	}
	
	return $gumbo_featured_posts;
}


/**
 * Flush out the transient set in gumbo_fetch_featured_posts
 */
function gumbo_featured_posts_transient_flusher() {
	delete_transient( 'gumbo_featured_posts' );
}
add_action( 'save_post', 'gumbo_featured_posts_transient_flusher' );
add_action( 'customize_save', 'gumbo_featured_posts_transient_flusher' );