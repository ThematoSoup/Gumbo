<?php
/**
 * Functions theme uses to display content for custom post types registered by Steroids plugin
 */

if ( ! function_exists( 'thsp_project_meta' ) ) :
/**
 * Display portfolio project meta fields
 */
function thsp_project_meta( $post ) {
	if ( get_post_meta( $post->ID, '_steroids_portfolio_project_url', true ) ) :
		echo '<a href="' . get_post_meta( $post->ID, '_steroids_portfolio_project_url', true ) . '">' . __( 'Visit Project', 'gumbo' ) . '</a>';
	endif;
		
	echo '<dl>';
	// Show client name and URL
	if ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) || get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) ) :
		echo '<dt>' . __( 'Client', 'gumbo' ) . '</dt>';
		echo '<dd>';
		if ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) && get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) ) :
			echo '<a href="' . get_post_meta( $post->ID, '_steroids_portfolio_client_url', true ) . '">' . get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) . '</a>';
		elseif ( get_post_meta( $post->ID, '_steroids_portfolio_client_name', true ) ) :
			echo get_post_meta( $post->ID, '_steroids_portfolio_client_name', true );
		else :
			echo get_post_meta( $post->ID, '_steroids_portfolio_client_url', true );
		endif;
	endif;
	
	// Show project date
	if ( get_post_meta( $post->ID, '_steroids_portfolio_project_date', true ) ) :
		echo '<dt>' . __( 'Date', 'gumbo' ) . '</dt>';
		echo '<dd>' . date( get_option( 'date_format' ), get_post_meta( $post->ID, '_steroids_portfolio_project_date', true ) ) . '</dd>';
	endif;
	echo '</dl>';
}
endif;