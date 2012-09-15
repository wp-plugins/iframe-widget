<?php
/*
Plugin Name: IFrame Widget
Plugin URI: http://nullpointer.debashish.com/iframe-widget-for-wordpress
Description: Adds an IFrame on your sidebar or any page to display any desired webpage.
Version: 4.0
Min WP Version: 3.0
Author: Debashish Chakrabarty
Author URI: http://www.debashish.com
*/
?>
<?php
add_action('widgets_init', create_function('', 'return register_widget("IFrame_Widget");'));
//add_filter('the_content', 'widget_iframe_on_page');

class IFrame_Widget extends WP_Widget {

	function __construct() {	   
		$widget_ops = array('classname' => 'IFrame_Widget', 'description' => "IFrame widget can display any external HTML page inside an HTML IFrame component." );
		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 300);
		parent::__construct('iframewidget', __('IFrame Widget'), $widget_ops, $control_ops);
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'IFrame Widget', 'width' => 100, 'height' => 100, 'url' => 'http://google.com', 'border' => 0) );
		$title = strip_tags($instance['title']);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$url = strip_tags($instance['url']);
		$border = strip_tags($instance['border']);
		?>
		<p>Display an external HTML page inside an HTML <a href="http://www.htmlhelp.com/reference/html40/special/iframe.html">IFrame</a>. For details <a href="http://nullpointer.debashish.com/2006/04/07/iframe-widget-for-wordpress/" target="_blank">click here</a>.</p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width*:' ); ?></label>
		<input size="4" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Height*:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Page URL:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
		
		<label for="<?php echo $this->get_field_id( 'border' ); ?>"><?php _e( 'Display Frame border? :' ); ?></label>
		<select id="<?php echo $this->get_field_id('border'); ?>" name="<?php echo $this->get_field_name('border'); ?>">
				<option style="padding-right:10px;" value="1" <?php selected('1', esc_attr($border)); ?>>Yes</option>
				<option style="padding-right:10px;" value="0" <?php selected('0', esc_attr($border)); ?>>No</option>
		</select>	
		<hr/><p><small>* The WIDTH and HEIGHT attributes can be specified either in pixels (example: 50px or simply 50) or as a percentage of the available space (example: 50%).</small></p>		
		<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['url'] = strip_tags($new_instance['url']);		
		$instance['border'] = strip_tags($new_instance['border']);		
		return $instance;
	}

	// This prints the widget
	function widget( $args, $instance ) {	
		extract($args);
		?>
		<?php echo $before_widget . $before_title . $instance['title']  . $after_title; ?>
		<iFrame scrolling="yes" frameborder="<?php echo $instance['border'] ; ?>" src="<?php echo $instance['url'] ; ?>" width="<?php echo $instance['width'] ; ?>" height="<?php echo $instance['height'] ; ?>">The browser doesn't support IFrames.</iFrame>
		<?php echo $after_widget; ?>
		<?php
	}

	//Converts all the occurances of [dciframe][/dciframe] to IFRAME HTML tags
	function widget_iframe_on_page($text){
		$regex = '#\[dciframe]((?:[^\[]|\[(?!/?dciframe])|(?R))+)\[/dciframe]#';
		if (is_array($text)) {
			//Read the Width/Height Parameters, if given
			$param = explode(",", $text[1]);
			$others = "";
			if(isset($param[1])){
				$others = ' width="' .$param[1] . '"';
			}
			if(isset($param[2])){
				$others .= ' height="' .$param[2] . '"';
			}
			if(isset($param[3]) && is_numeric($param[3])){
				$others .= ' frameborder="' .$param[3] . '"';
			}
			
			//generate the IFRAME tag
			$text = '<iFrame src="'.$param[0].'"'.$others.'></iFrame>';
		}
		return preg_replace_callback($regex, 'widget_iframe_on_page', $text);
	}
}
?>