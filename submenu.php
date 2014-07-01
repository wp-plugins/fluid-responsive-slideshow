<?php

add_action( 'admin_menu', 'pjc_slideshow_add_submenu' );

/**
 * Add submenu for plugin option, the page definition is on submenu-page.php
 */

function pjc_slideshow_add_submenu() 
{	
	add_submenu_page('edit.php?post_type=pjc_slideshow',
		'Slideshow', 
		'Slideshow', 
		'moderate_comments', 
		'frs-setting-page', 
		'pjc_slideshow_submenu_page', plugins_url('myplugin/images/icon.png')); 
	
}

require_once( plugin_dir_path( __FILE__ ) . 'submenu-page.php');