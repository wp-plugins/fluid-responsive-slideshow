<?php
/*
 *Plugin Name: Fluid Responsive Slideshow
 *Plugin URI: http://www.tonjoo.com/wordpress-plugin-fluid-responsive-slideshow-plugin/
 *Description: Fluid and Responsive Slideshow for wordpress.
 *Version: 0.9.8
 *Author: tonjoo
 *Author URI: http://www.tonjoo.com/
 *License: GPLv2
 *Contributor:Saga Iqranegara
 * 
*/



/*
 * Call other file for this plugin
 */

require_once( plugin_dir_path( __FILE__ ) . 'shortcode.php');
require_once( plugin_dir_path( __FILE__ ) . 'post-list.php');
require_once( plugin_dir_path( __FILE__ ) . 'display-info.php');
require_once( plugin_dir_path( __FILE__ ) . 'custom-meta.php');
require_once( plugin_dir_path( __FILE__ ) . 'submenu.php');
require_once( plugin_dir_path( __FILE__ ) . 'tonjoo-library.php');
require_once( plugin_dir_path( __FILE__ ) . 'notification/notification.php');

 /*
 *  Save plugin version on db on plugin installation
 */



 global $tonjoo_frs_version;
 $tonjoo_frs_version = "0.98";

/*
 * Add featured image support for this plugin
 */ 




add_action('after_setup_theme','after_setup_theme_pjc',5);

function after_setup_theme_pjc(){
	

	//check if post-thumbnails support defined
	if(isset($_wp_theme_features['post-thumbnails'])){
		//check if post-thumbails is set to true ( means all post have featured image), skip if true
		if(  $_wp_theme_features['post-thumbnails']!=true)
			//if post thumbnails only defined for specific post, merge the array
			$_wp_theme_features['post-thumbnails'] = array_merge((array)$_wp_theme_features['post-thumbnails'], array('pjc_slideshow'));
	}
	//no other post type using post-thumbnails
	else
		add_theme_support( 'post-thumbnails', array('pjc_slideshow') );
}



 /*
 *  Init pjc_slideshow post-type
 */

 add_action( 'init', 'create_pjc_slideshow',5 );

 function create_pjc_slideshow() {
	// register_taxonomy( $taxonomy, $object_type, $args );  

	 // Add new taxonomy, make it hierarchical (like categories)
 	$labels = array(
 		'name' => _x( 'Slide Type', 'taxonomy general name' ),
 		'singular_name' => _x( 'Slide Type', 'taxonomy singular name' ),
 		'search_items' =>  __( 'Search Slide Type' ),
 		'all_items' => __( 'All Slide Type' ),
 		'parent_item' => __( 'Parent Slide Type' ),
 		'parent_item_colon' => __( 'Parent Slide Type:' ),
 		'edit_item' => __( 'Edit Slide Type' ), 
 		'update_item' => __( 'Update Slide Type' ),
 		'add_new_item' => __( 'Add New Slide Type' ),
 		'new_item_name' => __( 'New Slide Type Name' ),
 		'menu_name' => __( 'Slide Type' ),
 		); 	

 	register_taxonomy('slide_type',array('pjc_slideshow'), array(
 		'hierarchical' => true,
 		'labels' => $labels,
 		'show_ui' => true,
 		'query_var' => true,
 		'rewrite' => array( 'slug' => 'slide-type' ),
 		));





 	register_post_type( 'pjc_slideshow',
 		array(
 			'labels' => array(
 				'name' => 'Fluid Responsive Slideshow',
 				'singular_name' => 'Slide',
 				'add_new' => 'Add Slide',
 				'add_new_item' => 'Add Slide Item',
 				'edit' => 'Edit',
 				'edit_item' => 'Edit Slide',
 				'new_item' => 'New Slide',
 				'view' => 'View',
 				'view_item' => 'View Slides',
 				'search_items' => 'Search Slides',
 				'not_found' => 'No Slides Found',
 				'not_found_in_trash' => 'No Slides found in the trash',
 				'parent' => 'Parent Slide view'
 				),
 			'public' => true,
            // 'menu_position' => 77.76,
 			'supports' => array( 'editor','title','thumbnail'),
 			'taxonomies' => array( 'slide_type' ),
            // 'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
 			'has_archive' => true
 			)
 		);	







 }




/*
 * Register Info Box (Meta Box) and option sub-menu
 */

add_action( 'admin_menu', 'pjc_slideshow_admin' );

function pjc_slideshow_admin() {
	
	
	
   // add_meta_box( $id, 
   // $title, 
   // $callback, 
   // $post_type, $context, $priority, $callback_args );


	
	/*
    * Register css and javascript for admin page
    */

	wp_enqueue_style('colorpicker-css',plugin_dir_url( __FILE__ )."css/jquery.miniColors.css");      
	wp_enqueue_script('colorpicker-mini',plugin_dir_url( __FILE__ )."js/jquery.miniColors.js");  


	wp_enqueue_script('jquery');  
	wp_enqueue_script('tonjoo_frs_admin',plugin_dir_url( __FILE__ )."js/tonjoo_frs_admin.js");  



}


