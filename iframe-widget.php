<?php
/*
Plugin Name: IFrame Widget
Plugin URI: http://nullpointer.debashish.com/iframe-widget-for-wordpress
Description: Adds an IFrame on your sidebar or any page to display any desired webpage.
Version: 2.0
Author: Debashish Chakrabarty
Author URI: http://www.debashish.com

-----------------------------------------------------
Copyright 2006  DEBASHISH CHAKRABARTY  (email : debashish@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
-----------------------------------------------------

See readme file for change-logs.
*/

// This gets called at the plugins_loaded action
function widget_iframe_init() {
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ){
		return;	
	}

	// This saves options and prints the widget's config form.
	function widget_iframe_control() {
		$options = $newoptions = get_option('widget_iframe');
		if ( $_POST['iframe-submit'] ) {
			$newoptions['title'] = $_POST['iframe-title'];
			$newoptions['width'] = (int) $_POST['iframe-width'];
			$newoptions['height'] = (int) $_POST['iframe-height'];
			$newoptions['url'] = $_POST['iframe-url'];			
		}

		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_iframe', $options);
		}
		?>
		<div style="text-align:right">
		    <p style="text-align:left;"><label for="iframe-intro">Display an external HTML page inside an HTML <a href="http://www.htmlhelp.com/reference/html40/special/iframe.html">IFrame</a>. For details <a href="http://nullpointer.debashish.com/2006/04/07/iframe-widget-for-wordpress/" target="_blank">click here</a>.</label></p>
			<label for="iframe-title" style="line-height:35px;display:block;">Title: <input type="text" id="iframe-title" name="iframe-title" value="<?php echo ($options['title']); ?>" /></label>
			<label for="iframe-width" style="line-height:35px;display:block;">Width (px): <input type="text" id="iframe-width" name="iframe-width" value="<?php echo ($options['width']); ?>" /></label>
			<label for="iframe-height" style="line-height:35px;display:block;">Height (px): <input type="text" id="iframe-height" name="iframe-height" value="<?php echo ($options['height']); ?>" /></label>
			<label for="iframe-url" style="line-height:35px;display:block;">Page URL: <input type="text" id="iframe-url" name="iframe-url" value="<?php echo $options['url']; ?>" /></label>
			<input type="hidden" name="iframe-submit" id="iframe-submit" value="1" />
		</div>
		<?php
	}

	// This prints the widget
	function widget_iframe($args) {	
		extract($args);
		$defaults = array('title' => 'My IFrame', 'width' => 100, 'height' => 100, 'url' => 'http://www.google.com');
		$options = (array) get_option('widget_iframe');

		//If the user has not yet set the options or set them empty, take the defaults
		foreach ( $defaults as $key => $value ){
			if ( !isset($options[$key]) || $options[$key] == ""){
				$options[$key] = $defaults[$key];	
			}
		}
		
		$title = $options['title'];
		$width = $options['width'];
		$height = $options['height'];
		$url = $options['url'];		
		?>
		<?php echo $before_widget . $before_title . $title . $after_title; ?>
		<iFrame frameborder="0" src="<?php echo $url; ?>" width="<?php echo $width; ?>px" height="<?php echo $height; ?>px">The browser doesn't support IFrames.</iFrame>
		<?php echo $after_widget; ?>
		<?php
	}

	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget('IFrame Widget', 'widget_iframe');
	register_widget_control('IFrame Widget', 'widget_iframe_control');
}

//Converts all the occurances of [dciframe][/dciframe] to IFRAME HTML tags
function widget_iframe_on_page($text){
	$regex = '#\[dciframe]((?:[^\[]|\[(?!/?dciframe])|(?R))+)\[/dciframe]#';
	if (is_array($text)) {
		//Read the Width/Height Parameters, if given
	    $param = explode(",", $text[1]);
		$others = "";
		if(isset($param[1]) && is_nan($param[1])){
			$others = ' width="' .$param[1] . '"';
		}
		if(isset($param[2]) && is_nan($param[2])){
			$others .= ' height="' .$param[2] . '"';
		}
		//generate the IFRAME tag
        $text = '<iFrame frameborder="0" src="'.$param[0].'"'.$others.'></iFrame>';
    }
	return preg_replace_callback($regex, 'widget_iframe_on_page', $text);
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('plugins_loaded', 'widget_iframe_init');
add_filter('the_content', 'widget_iframe_on_page');
?>