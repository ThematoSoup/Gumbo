<?php
/**
 * Gumbo Child Theme functions and definitions
 *
 * Use this file to customize Gumbo's functionality and interact with theme hooks
 * For full list of theme hooks, please check theme documentation
 */


/**
 * Adds a heading after header
 */
function gumbo_child_hook_example() {
	echo '<h1>This will appear right after header</h1>';
}
add_action( 'tha_after_header', 'gumbo_child_hook_example' );


/**
 * Removes footer credits
 */
remove_action( 'gumbo_credits', 'gumbo_footer_credits', 10 );