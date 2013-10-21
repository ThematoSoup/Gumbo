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
 */


function thsp_widget_form_callback( $instance, $widget ) {
	if( 'WP_Widget_Text' == get_class( $widget ) ) :
	endif;

	return $instance;
}
add_filter( 'widget_form_callback', 'thsp_widget_form_callback', 5, 2 );

function thsp_widget_display_callback( $instance, $widget, $args ) {
	if( 'WP_Widget_Text' == get_class( $widget ) ) :
		$args['before_title'] = '<div class="thsp-text-widget-icon">' . $instance['icon'] . '</div>' . $args['before_title'];
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
		$icon = isset( $instance['icon'] ) ? $instance['icon'] : ''; ?>
		<p><label for="<?php echo $widget->get_field_id('icon'); ?>"><?php _e( 'Select an icon.'); ?></label><br />
		<select id="<?php echo $widget->get_field_id('icon'); ?>" name="<?php echo $widget->get_field_name('icon'); ?>">
			<option value="1" <?php selected( $icon, 1 ); ?>>One</option>
			<option value="2" <?php selected( $icon, 2 ); ?>>Two</option>
			<option value="3" <?php selected( $icon, 3 ); ?>>Three</option>
		</select></p>
	<?php endif;
}
add_action( 'in_widget_form', 'thsp_in_widget_form', 5, 3 );



/**
 * Unregister Text Widget
 */
// function thsp_remove_text_widget() {
	/**
	 * Enhanced Text widget class
	 *
	 * @since 1.0
	 */
	/*
	class THSP_Widget_Text extends WP_Widget_Text {

		function widget( $args, $instance ) {
			extract($args);
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
				<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
			<?php
			echo $after_widget;
		}
	
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			if ( current_user_can('unfiltered_html') )
				$instance['text'] =  $new_instance['text'];
			else
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
			$instance['filter'] = isset($new_instance['filter']);
			return $instance;
		}
	
		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
			$title = strip_tags($instance['title']);
			$text = esc_textarea($instance['text']);
	?>
			<h1>LaLaLa</h1>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
	
			<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
		<?php }
			
	}
	register_widget( 'THSP_Widget_Text' );
	*/	
// }
// add_action( 'widgets_init', 'thsp_remove_text_widget' );