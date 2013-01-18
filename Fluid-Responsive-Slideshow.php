<?php
/*
 *Plugin Name: Fluid Responsive Slideshow
 *Plugin URI: http://todiadiyatmo.com/2013/01/wordpress-plugin-fluid-responsive-slideshow-plugin/
 *Description: Fluid and Responsive Slideshow for wordpress.
 *Version: 0.9
 *Author: Todi Adiyatmo Wijoyo
 *Author URI: http://todiadiyatmo.com/
 *License: GPLv2
 *Contributor:Saga Iqranegara
 * 
*/

/*
 * Add featured image support for this plugin
 */ 

add_theme_support( 'post-thumbnails',array('pjc_slideshow')); 

 /*
 *  Init pjc_slideshow post-type
 */

add_action( 'init', 'create_pjc_slideshow' );

function create_pjc_slideshow() {
	
	
	
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
           'taxonomies' => array( '' ),
            // 'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );	
	
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
  
	wp_enqueue_style('colorpicker-css',plugins_url("Fluid-Responsive-Slideshow/css/jquery.miniColors.css"));      
    wp_enqueue_style('style',plugins_url("Fluid-Responsive-Slideshow/css/admin_pjc_slideshow.css"));  
    wp_enqueue_script('colorpicker-mini',plugins_url("Fluid-Responsive-Slideshow/js/jquery.miniColors.js"));  
	

    wp_enqueue_script('jquery');  
}

/*
 * Call other file for this plugin
 */

require_once( plugin_dir_path( __FILE__ ) . 'shortcode.php');
require_once( plugin_dir_path( __FILE__ ) . 'post-list.php');
require_once( plugin_dir_path( __FILE__ ) . 'display-info.php');
require_once( plugin_dir_path( __FILE__ ) . 'custom-meta.php');
require_once( plugin_dir_path( __FILE__ ) . 'submenu.php');


