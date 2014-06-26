<?php




 /*
 *  Save plugin version on db on plugin installation and display the notification if needed
 */
add_action('admin_notices','tonjoo_frs_print_notification_box');
function tonjoo_frs_print_notification_box(){

	global $tonjoo_frs_version;
	$run = false;

	//Display notification when the plugin is installed
	if (get_site_option('tonjoo_frs_version') != $tonjoo_frs_version) {

		$run=true;
	}

	//kill the function if run is false
	if(!$run)
		return;

	update_option("tonjoo_frs_version", $tonjoo_frs_version);
	wp_enqueue_style('tonjoo-notification',plugin_dir_url( __FILE__ ).'tonjoo_notification.css');  
    wp_enqueue_script('tonjoo-notification-js',plugin_dir_url( __FILE__ ).'notification.js');
	 
   ?>
    <div class='widget' id='tonjoo-notification'  >
		<h3>Notification ~ Fluid Responsive Slideshow by <a href='http://tonjoo.com' >tonjoo</a></h3>

		Thank you for using Fluid Responsive Slideshow.

		Version 0.9.8 bring several improvement :
		<ol>
			<li>Fix featured image problem</li>
			<li>Minor code refactoring</li>
			<li>Fixed slideshow animation on certain themes</li>
			<li>Better readme</li>
		</ol>
		If you like this plugin, please <a href='http://tonjoo.com/donate'>donate</a> for development and support :)</a>

		<button  class="button button-primary button-large" id="tonjoo-notification-close"  >Dismiss</button>
	</div>
    <?php
	
}