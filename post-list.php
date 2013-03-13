<?php

/*
 * Modify which columns display in the admin views 
 */
function pjc_slideshow_posts_columns($posts_columns) {
	$tmp = array();

	foreach ($posts_columns as $key => $value) {
		$tmp[$key] = $value;
	}

	$tmp['pjc_slideshow_title'] = 'Slide Image';
	$tmp['pjc_slideshow_type'] = 'Shortcode';
	$tmp['pjc_slideshow_order'] = 'Order Number';

	return $tmp;
}

add_filter('manage_pjc_slideshow_posts_columns', 'pjc_slideshow_posts_columns');

/*
 * Custom column output when admin is viewing the pjc_slideshow post type.
 */
function pjc_slideshow_custom_column($column_name) {
	global $post;

	if ($column_name == 'pjc_slideshow_title') {
		echo "<a href='",   get_edit_post_link($post -> ID), "'>",   get_the_post_thumbnail($post -> ID, 'medium'), "</a>";

	}
	if ($column_name == 'pjc_slideshow_order') {
		$order =  get_post_meta($post -> ID,'tonjoo_frs_order_number',true);
		
	

		if(!isset($order))
			echo "<b style='color:red'>no order no. ,slide will not be shown</b>";
		else
			echo "$order";

	}
	if ($column_name == 'pjc_slideshow_type') {

		$terms = get_the_terms($post -> ID, 'slide_type');

		if($terms){
			// Loop over each item since it's an array
			foreach ($terms as $term) {
				// Print the name method from $term which is an OBJECT
				print " [pjc_slideshow slide_type='{$term -> name}'] <br />";
				// Get rid of the other data stored in the object, since it's not needed
				unset($term);
			}
		}
		else{
			print "<b style='color:red'>no slide type,slide will not be shown</b>";
		}
		

	}

}

add_action('manage_posts_custom_column', 'pjc_slideshow_custom_column');

/*
 * Make the "Featured Image" metabox front and center when editing a pjc_slideshow post.
 */
function pjc_slideshow_metaboxes($post) {
	

	global $wp_meta_boxes;

	remove_meta_box('postimagediv', 'pjc_slideshow', 'side');
	add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'pjc_slideshow', 'normal', 'high');
}

add_action('add_meta_boxes_pjc_slideshow', 'pjc_slideshow_metaboxes');
