<?php
/**
 * Edits to built-in WordPress widgets
 *
 * Notes:
 * ------
 * It's better to do this using hooks, if possible
 * Text widget uses 'widget_text' hook (wp-includes/default-widgets.php)
 * Check 'display_callback', 'update_callback', 'form_callback' and 'in_widget_form' in that same file
 *
 * @package		Gumbo
 * @since		Gumbo 1.0
 * @link		http://shibashake.com/wordpress-theme/wordpress-widget-system
 * @link		http://stackoverflow.com/questions/12351603/wordpress-add-config-option-to-all-widget-settings
 */


function thsp_widget_form_callback( $instance, $widget ) {
	if( 'WP_Widget_Text' == get_class( $widget ) ) :
	endif;

	return $instance;
}
add_filter( 'widget_form_callback', 'thsp_widget_form_callback', 5, 2 );

function thsp_widget_display_callback( $instance, $widget, $args ) {
	if( 'WP_Widget_Text' == get_class( $widget ) ) :
		$icon_display = '<div class="thsp-text-widget-icon thsp-text-widget-icon-' . $instance['icon-size'] . '"><span class="genericon genericon-' . $instance['icon'] . '"></span></div>';
		$args['before_title'] = $icon_display . $args['before_title'];
	endif;
	
	// Display the widget with custom $args
	$widget->widget($args, $instance);

	// Prevent default widget display
	return false;
}
add_filter( 'widget_display_callback', 'thsp_widget_display_callback', 5, 3 );

function thsp_widget_update_callback( $instance, $new_instance, $old_instance, $widget ) {
	if( 'WP_Widget_Text' == get_class( $widget ) ) :
		$instance['icon'] = $new_instance['icon'];
		$instance['icon-size'] = $new_instance['icon-size'];
	endif;

	return $instance;
}
add_filter( 'widget_update_callback', 'thsp_widget_update_callback', 5, 4 );


/*
 * Add form fields, checks if it's text widget
 *
 * $widget = widget info (text, classes etc.)
 * $return = null
 * $instance = widget instance details
 */
function thsp_in_widget_form( $widget, $return, $instance ) {
	if( 'WP_Widget_Text' == get_class( $widget ) ) :
		$icon = isset( $instance['icon'] ) ? $instance['icon'] : '';
		$icon_size = isset( $instance['icon-size'] ) ? $instance['icon-size'] : 'no-icon'; ?>
		<p>
			<label for="<?php echo $widget->get_field_id('icon-size'); ?>">Icon size:</label><br />
			<select id="<?php echo $widget->get_field_id('icon-size'); ?>" name="<?php echo $widget->get_field_name('icon-size'); ?>">
				<option value="no-icon" <?php selected( $icon_size, 'no-icon' ); ?>>No icon</option>
				<option value="64" <?php selected( $icon_size, 64 ); ?>>64px</option>
				<option value="128" <?php selected( $icon_size, 128 ); ?>>128px</option>
				<option value="256" <?php selected( $icon_size, 256 ); ?>>256px</option>
			</select>
		</p>
		<div>Select an icon:</div>
		<p class="thsp-text-widget-icons">
		<?php
		$genericons = thsp_get_genericons_icons();
		foreach ( $genericons as $genericon ) : ?>
		<label class="thsp-text-widget-icon" for="<?php echo $widget->get_field_id('icon') . '-' . $genericon; ?>">
			<input type="radio" id="<?php echo $widget->get_field_id('icon') . '-' . $genericon; ?>" name="<?php echo $widget->get_field_name('icon'); ?>" value="<?php echo $genericon; ?>" <?php checked( $icon, $genericon ); ?> />
			<span class="genericon genericon-<?php echo $genericon; ?>"></span>
		</label>
		<?php endforeach; ?>
		</p>
	<?php endif;
}
add_action( 'in_widget_form', 'thsp_in_widget_form', 5, 3 );


/**
 * Enqueue Genericons in Widgets page
 */
function thsp_admin_enqueue_genericons( $hook ) {
    if( 'widgets.php' != $hook )
        return;

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons-admin', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.0.1' );
}
add_action( 'admin_enqueue_scripts', 'thsp_admin_enqueue_genericons' );



function thsp_admin_text_widget_icon_css() { ?>
	<style type="text/css">
		.thsp-text-widget-icons { height: 156px; overflow: scroll; }
		.thsp-text-widget-icons label { font-size: 0; }
		.thsp-text-widget-icons input[type="radio"] { display: none; }
		.thsp-text-widget-icons span.genericon { width: 48px; height: 48px; font-size: 48px; margin: 2px; opacity: 0.2; }
		.thsp-text-widget-icons input[type="radio"]:checked + span.genericon { opacity: 1; }
	</style>
<?php }
add_action( 'admin_head', 'thsp_admin_text_widget_icon_css' );


// Helper function to get list of all Genericons icons
function thsp_get_genericons_icons() {
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