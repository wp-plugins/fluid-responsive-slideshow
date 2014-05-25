<?php

add_action( 'admin_menu', 'pjc_slideshow_add_submenu' );

/*
 * Add submenu for plugin option, the page definition is on submenu-page.php
 */

function pjc_slideshow_add_submenu() {
	//php add_submenu_page(//parent_slug,
	// $page_title, 
    //$menu_title, 
    //$capability, 
    //$menu_slug, 
    //$function, 
    //$icon_url, 
    //$position ); 
	
	
	
	add_submenu_page('edit.php?post_type=pjc_slideshow',
		'Slideshow', 
		'Slideshow', 
		'administrator', 
		'frs-setting-page', 
		'pjc_slideshow_submenu_page', plugins_url('myplugin/images/icon.png')); 
	
}

require_once( plugin_dir_path( __FILE__ ) . 'submenu-page.php');