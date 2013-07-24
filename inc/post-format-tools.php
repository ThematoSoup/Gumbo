<?php
/**
 * Post Format Tools - A mini library for formatting post formats.
 *
 * Post Format Tools has functions and filters for handling the output of post formats.  This library 
 * helps theme developers format posts with given post formats in a more standardized fashion.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   PostFormatTools
 * @version   0.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link      http://justintadlock.com
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */


/* Makes URLs in link posts clickable. */
add_filter( 'the_content', 'post_format_tools_link_content' );

/* Wraps <blockquote> around quote posts. */
add_filter( 'the_content', 'post_format_tools_quote_content' );

/* Makes URLs in link posts clickable. */
add_filter( 'the_content', 'post_format_tools_link_content' );


/**
 * Checks if a post has any content. Useful if you need to check if the user has written any content 
 * before performing any actions.
 *
 * @since 0.1.0
 * @access public
 * @param int $id The ID of the post.
 * @return bool Whether the post has content.
 */
function post_format_tools_post_has_content( $id = 0 ) {
	$post = get_post( $id );
	return ( !empty( $post->post_content ) ? true : false );
}

/**
 * Wraps the output of the quote post format content in a <blockquote> element if the user hasn't added a 
 * <blockquote> in the post editor.
 *
 * @since 0.1.0
 * @access public
 * @param string $content The post content.
 * @return string $content
 */
function post_format_tools_quote_content( $content ) {
	if ( has_post_format( 'quote' ) ) {
		preg_match( '/<blockquote.*?>/', $content, $matches );

		if ( empty( $matches ) )
			$content = "<blockquote>{$content}</blockquote>";
	}

	return $content;
}

/**
 * Filters the content of the link format posts.  Wraps the content in the make_clickable() function 
 * so that users can enter just a URL into the post content editor.
 *
 * @since 0.1.0
 * @access public
 * @param string $content The post content.
 * @return string $content
 */
function post_format_tools_link_content( $content ) {
	if ( has_post_format( 'link' ) )
		$content = make_clickable( $content );

	return $content;
}

/**
 * Grabs the first URL from the post content of the current post.  This is meant to be used with the link post 
 * format to easily find the link for the post. 
 *
 * @note This is a modified version of the twentyeleven_url_grabber() function in the TwentyEleven theme.
 * @author wordpressdotorg
 * @copyright Copyright (c) 2011, wordpressdotorg
 * @link http://wordpress.org/extend/themes/twentyeleven
 * @license http://wordpress.org/about/license
 *
 * @since 0.1.0
 * @access public
 * @return string The link if found.  Otherwise, the permalink to the post.
 */
function post_format_tools_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', make_clickable( get_the_content() ), $matches ) )
		return get_permalink( get_the_ID() );

	return esc_url_raw( $matches[1] );
}

/**
 * Returns the number of images attached to the current post in the loop.
 *
 * @since 0.1.0
 * @access public
 * @return int
 */
function post_format_tools_get_image_attachment_count() {
	$images = get_children( array( 'post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => -1 ) );
	return count( $images );
}

/**
 * Retrieves embedded videos from the post content.  This script only searches for embeds used by 
 * the WordPress embed functionality.
 *
 * @since 0.1.0
 * @access public
 * @global object $wp_embed The global WP_Embed object.
 * @param array $args Arguments for the [embed] shortcode.
 * @return string
 */
function post_format_tools_get_video( $args = array() ) {
	global $wp_embed;

	/* If this is not a 'video' post, return. */
	if ( !has_post_format( 'video' ) )
		return false;

	/* Merge the input arguments and the defaults. */
	$args = wp_parse_args( $args, wp_embed_defaults() );

	/* Get the post content. */
	$content = get_the_content();

	/* Set the default $embed variable to false. */
	$embed = false;

	/* Use WP's built in WP_Embed class methods to handle the dirty work. */
	add_filter( 'post_format_tools_video_shortcode_embed', array( $wp_embed, 'run_shortcode' ) );
	add_filter( 'post_format_tools_video_auto_embed', array( $wp_embed, 'autoembed' ) );

	/* We don't want to return a link when an embed doesn't work.  Filter this to return false. */
	add_filter( 'embed_maybe_make_link', '__return_false' );

	/* Check for matches against the [embed] shortcode. */
	preg_match_all( '|\[embed.*?](.*?)\[/embed\]|i', $content, $matches, PREG_SET_ORDER );

	/* If matches were found, loop through them to see if we can hit the jackpot. */
	if ( is_array( $matches ) ) {
		foreach ( $matches  as $value ) {

			/* Apply filters (let WP handle this) to get an embedded video. */
			$embed = apply_filters( 'post_format_tools_video_shortcode_embed', '[embed width="' . absint( $args['width'] ) . '" height="' . absint( $args['height'] ) . '"]' . $value[1]. '[/embed]' );

			/* If no embed, continue looping through the array of matches. */
			if ( empty( $embed ) )
				continue;
		}
	}

	/* If no embed at this point and the user has 'auto embeds' turned on, let's check for URLs in the post. */
	if ( empty( $embed ) && get_option( 'embed_autourls' ) ) {
		preg_match_all( '|^\s*(https?://[^\s"]+)\s*$|im', $content, $matches, PREG_SET_ORDER );

		/* If URL matches are found, loop through them to see if we can get an embed. */
		if ( is_array( $matches ) ) {
			foreach ( $matches  as $value ) {

				/* Let WP work its magic with the 'autoembed' method. */
				$embed = apply_filters( 'post_format_tools_video_auto_embed', $value[0] );

				/* If no embed, continue looping through the array of matches. */
				if ( empty( $embed ) )
					continue;
			}
		}
	}

	/* Remove the maybe make link filter. */
	remove_filter( 'embed_maybe_make_link', '__return_false' );

	/* Return the embed. */
	return $embed;
}