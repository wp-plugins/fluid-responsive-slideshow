<?php




 /*
 *  Save plugin version on db on plugin installation and display the notification if needed
 */
add_action('admin_notices','tonjoo_frs_print_notification_box');
function tonjoo_frs_print_notification_box(){

	global $tonjoo_frs_version;

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

		Thank you for choosing Fluid Responsive Slideshow.

		Version 0.93 is hotfix for version 0.92 we have made several improvement :
		<ol>
			<li>Fix some options value that does not work</li>
			<li>Fix maximal number of slide</li>
			<li>Add 3 new skin ~ modern,minimalist,corporate</li>
		</ol>

		<b>Installation instruction for upgrade user from 0.90</b>
		<br>
		<br>
		Due to improvement we made to the new version user upgrading this plugin from previous version will have to do the following things :
		<ol>
			<li>Update each slide options on the slide page</li>
			<li>Update the FR Slideshow Option for each slide type</li>
		</ol>

		<button  class="button button-primary button-large" id="tonjoo-notification-close"  >Dismiss</button>
	</div>
    <?php
	
}