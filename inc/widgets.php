<?php
/**
 * Gumbo theme widgets
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 */


/*
 * Filters widget field values before passing them to the form
 *
 * @since Gumbo 1.0

function gumbo_widget_form_callback( $instance, $widget ) {
	if ( 'WP_Widget_Text' == get_class( $widget ) ) :
	endif;

	return $instance;
}
add_filter( 'widget_form_callback', 'gumbo_widget_form_callback', 5, 2 );
*/


/*
 * Changes display of Text Widget if an icon needs to be shown
 *
 * @param	array		$instance	Widget instance
 * @param	object		$widget		Widget object
 * @param	array		$args		Widget arguments		
 * @since	Gumbo 1.0
 */
function gumbo_widget_display_callback( $instance, $widget, $args ) {
	if( 'WP_Widget_Text' == get_class( $widget ) && isset( $instance['icon'] ) ) :
		$icon_size = isset( $instance['icon-size'] ) ? $instance['icon-size'] : 'no-icon';
		$valid_sizes = array( 64, 96, 128, 256 );
		if ( in_array( $icon_size, $valid_sizes ) ) : // Check if icon size value is among whitelisted values
			// Add class to the widget
			$args['before_widget'] = preg_replace( '/class="/', "class=\"thsp-text-widget-centered ", $args['before_widget'], 1 );
			$icon_display = '<div class="thsp-text-widget-icon thsp-text-widget-icon-' . $icon_size . '"><span class="genericon genericon-' . $instance['icon'] . '"></span></div>';
			// Add the icon before widget title
			$args['before_widget'] .= $icon_display;
		endif;
	endif;
	
	// Display the widget with custom $args
	$widget->widget($args, $instance);

	// Prevent default widget display
	return false;
}
add_filter( 'widget_display_callback', 'gumbo_widget_display_callback', 5, 3 );


/*
 * Updates icon form fields to Text Widget
 *
 * @param	array		$instance		Widget instance
 * @param	array		$new_instance	New widget settings
 * @param	array		$old_instance	Old widget settings
 * @param	object		$widget			Widget object
 * @since	Gumbo 1.0
 */
function gumbo_widget_update_callback( $instance, $new_instance, $old_instance, $widget ) {
	if ( 'WP_Widget_Text' == get_class( $widget ) ) :
		// Update icon
		$valid_icons = gumbo_get_genericons_icons();
		if ( in_array( $new_instance['icon'], $valid_icons ) ) 
			$instance['icon'] = $new_instance['icon'];
		// Update icon size
		$valid_sizes = array( 64, 96, 128, 256 );
		if ( in_array( $new_instance['icon-size'], $valid_sizes ) )
			$instance['icon-size'] = $new_instance['icon-size'];
	endif;

	return $instance;
}
add_filter( 'widget_update_callback', 'gumbo_widget_update_callback', 5, 4 );


/*
 * Adds icon form fields to Text Widget
 *
 * @param	array		$widget		Widget object
 * @param	boolean		$return		?
 * @param	array		$instance	Widget instance
 * @since	Gumbo 1.0
 */
function gumbo_in_widget_form( $widget, $return, $instance ) {
	if ( 'WP_Widget_Text' == get_class( $widget ) ) :
		$icon = isset( $instance['icon'] ) ? $instance['icon'] : '';
		$icon_size = isset( $instance['icon-size'] ) ? $instance['icon-size'] : 'no-icon'; ?>
		<p>
			<label for="<?php echo $widget->get_field_id('icon-size'); ?>"><?php _e( 'Icon size:', 'gumbo' ); ?></label><br />
			<select id="<?php echo $widget->get_field_id('icon-size'); ?>" name="<?php echo $widget->get_field_name('icon-size'); ?>">
				<option value="no-icon" <?php selected( $icon_size, 'no-icon' ); ?>><?php _e( 'No icon', 'gumbo' ); ?></option>
				<option value="64" <?php selected( $icon_size, 64 ); ?>><?php _e( '64px', 'gumbo' ); ?></option>
				<option value="96" <?php selected( $icon_size, 96 ); ?>><?php _e( '96px', 'gumbo' ); ?></option>
				<option value="128" <?php selected( $icon_size, 128 ); ?>><?php _e( '128px', 'gumbo' ); ?></option>
				<option value="256" <?php selected( $icon_size, 256 ); ?>><?php _e( '256px', 'gumbo' ); ?></option>
			</select>
		</p>
		<div><?php _e( 'Select an icon:', 'gumbo' ); ?></div>
		<p class="thsp-text-widget-icons">
		<?php
		$genericons = gumbo_get_genericons_icons();
		foreach ( $genericons as $genericon ) : ?>
		<label class="thsp-text-widget-icon" for="<?php echo $widget->get_field_id('icon') . '-' . $genericon; ?>">
			<input type="radio" id="<?php echo $widget->get_field_id('icon') . '-' . $genericon; ?>" name="<?php echo $widget->get_field_name('icon'); ?>" value="<?php echo $genericon; ?>" <?php checked( $icon, $genericon ); ?> />
			<span class="genericon genericon-<?php echo $genericon; ?>"></span>
		</label>
		<?php endforeach; ?>
		</p>
	<?php endif;
}
add_action( 'in_widget_form', 'gumbo_in_widget_form', 5, 3 );


/**
 * Enqueue Genericons font in Widgets page
 *
 * @param	strong		$hook	Current admin screen hook
 * @since	Gumbo 1.0
 */
function gumbo_admin_enqueue_genericons( $hook ) {
    if ( 'widgets.php' != $hook )
        return;

	wp_enqueue_style( 'genericons-admin', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.0.1' );
}
add_action( 'admin_enqueue_scripts', 'gumbo_admin_enqueue_genericons' );


/**
 * Adds custom CSS to style icon fields in Text Widget
 *
 * @since Gumbo 1.0
 */
function gumbo_admin_text_widget_icon_css() { ?>
	<style type="text/css">
		.thsp-text-widget-icons { height: 156px; overflow: scroll; }
		.thsp-text-widget-icons label { font-size: 0; }
		.thsp-text-widget-icons input[type="radio"] { display: none; }
		.thsp-text-widget-icons span.genericon { width: 48px; height: 48px; font-size: 48px; margin: 2px; opacity: 0.2; }
		.thsp-text-widget-icons input[type="radio"]:checked + span.genericon { opacity: 1; }
	</style>
<?php }
add_action( 'admin_head', 'gumbo_admin_text_widget_icon_css' );


// add_filter( 'dynamic_sidebar_params', 'gumbo_dynamic_sidebar_params' );


/**
 * Returns list of all available icons
 *
 * @return	array		$genericons		Array of all available Genericons
 * @since	Gumbo 1.0
 */
function gumbo_get_genericons_icons() {
	$genericons = array(
		/* Post formats */
		'standard',
		'aside',
		'image',
		'gallery',
		'video',
		'status',
		'quote',
		'link',
		'chat',
		'audio',
		
		/* Social icons */
		'github',
		'dribbble',
		'twitter',
		'facebook',
		'facebook',
		'wordpress',
		'googleplus',
		'linkedin',
		'linkedin',
		'pinterest',
		'pinterest-alt',
		'flickr',
		'vimeo', 
		'youtube',
		'tumblr',
		'instagram',
		'codepen',
		'polldaddy',
		'googleplus-alt',
		'path',
		
		/* Meta icons */
		'comment',
		'category',
		'tag',
		'time',
		'user',
		'day',
		'week',
		'month',
		'pinned',
		
		/* Other icons */
		'search',
		'unzoom', 
		'zoom', 
		'show', 
		'hide', 
		'close',
		'close-alt',
		'trash',
		'star',
		'home',
		'mail',
		'edit',
		'reply',
		'feed',
		'warning',
		'share',
		'attachment',
		'location',
		'checkmark',
		'menu', 
		'refresh',
		'minimize',
		'maximize',
		'404', 
		'spam', 
		'summary',
		'cloud',
		'key', 
		'dot', 
		'next', 
		'previous',
		'expand',
		'collapse',
		'dropdown',
		'dropdown-left',
		'top',
		'draggable',
		'phone',
		'send-to-phone',
		'plugin',
		'cloud-download',
		'cloud-upload',
		'external',
		'document',
		'book',
		'cog',
		'unapprove',
		'cart',
		'pause',
		'stop',
		'skip-back',
		'skip-ahead',
		'play',
		'tablet',
		'send-to-tablet',
		'info',
		'notice',
		'help',
		'fastforward',
		'rewind',
		'portfolio',
		
		/* Generic shapes */
		'uparrow',
		'rightarrow',
		'downarrow',
		'leftarrow',
	);
	
	return $genericons;
}