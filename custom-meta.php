<?php

/* Define the custom box */

add_action( 'add_meta_boxes', 'pjc_slideshow_add_custom_box' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'pjc_slideshow_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'pjc_slideshow_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function pjc_slideshow_add_custom_box() {
	
	//add_meta_box( 
	// $id, 
	// $title, 
	// $callback, 
	// $post_type, 
	// $context, 
	// $priority,
	 // $callback_args )
	
    add_meta_box( 
        'pjc_slideshow_meta',
        'Slide Options',
        'pjc_slideshow_custom_meta',
        'pjc_slideshow' ,
        'normal',
        "high"
    );
	
	
	 /*
    * Add information page on admin panel
    */
  
    add_meta_box( 'pjc_slideshow_info',
        'Instruction',
        'pjc_display_info',
        'pjc_slideshow', 
        'normal',
         'low'
    );
	

	

}

/* Prints the box content */
function pjc_slideshow_custom_meta( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'pjc_slideshow_noncename' );

  $number = get_post_meta($post->ID, 'pjc_slideshow_order',true);
  $text = get_post_meta($post->ID, 'pjc_slideshow_text',true);

  $title_color = get_post_meta($post->ID, 'pjc_slideshow_titlecolor',true);
  $text_color = get_post_meta($post->ID, 'pjc_slideshow_textcolor',true);
  
  $href = get_post_meta($post->ID, 'pjc_slideshow_href',true);
  
  
  if(!$number)
  	$number=0;
  
  if(!$text)
  	$text='yes';
  
  if(!$text_color)
   $text_color="ffffff";
  
  if(!$title_color)
   $title_color="ffffff";
  
  if(!$href)
  $href="#";
  
  
?>
<style>
.pjc_slideshow th{
	width:100px;
	text-align: center;
}
</style>

<table class="form-table pjc_slideshow">
	<tr>
		<th scope="row">Order Number</th>
		<td >
			<input style="width:20px;" class="regular-text" "type="text" name="pjc_slideshow[order]" value="<?php esc_attr_e($number); ?>" />
			<label class="description" >The slide will be sorted from the lowest number,if the order is equal the slide is order by the oldest date first</label>
		</td>
	</tr>
	<tr valign="top">
			<th scope="row">Show Text</th>
			<td>
				<select name="pjc_slideshow[text]">
					<?php
					
						$navigation = array(
							'0' => array(
								'value' =>	'yes',
								'label' =>  'Yes'
							),
							'1' => array(
								'value' =>	'no',
								'label' =>  'No' 
							)
						);
						
					
						$selected = $text;
						$p = '';
						$r = '';
	
						foreach ( $navigation as $option ) {
							$label = $option['label'];
							if ( $selected == $option['value'] ) // Make default first in list
								$p = "<option selected='selected' value='" . esc_attr( $option['value'] ) . "'>$label</option>";
							else
								$r .= "<option value='" . esc_attr( $option['value'] ) . "'>$label</option>";
						}
						echo $p . $r;
					?>
				</select>
				<label class="description" >Select yes to show text on slideshow</label>
			</td>
		</tr>
	<tr>
		<th scope="row">Title Color</th>
		<td>
			<input class="regular-text" type="minicolors"  name="pjc_slideshow[titlecolor]" value="<?php esc_attr_e($title_color); ?>" />
			<label class="description" >Title Color</label>
		</td>
	</tr>
	<tr>
		<th scope="row">Text Color</th>
		<td>
			<input class="regular-text" type="minicolors"  name="pjc_slideshow[textcolor]" value="<?php esc_attr_e($text_color); ?>" />
			<label class="description" >Text Color</label>
		</td>
	</tr>
	<tr>
		<th scope="row">Image Href</th>
		<td>
			<input class="regular-text"  name="pjc_slideshow[href]" value="<?php esc_attr_e($href); ?>" />
			<label class="description" >Image Hiperlink location</label>
		</td>
	</tr>
</table>

<?php 

}

/* When the post is saved, saves our custom data */
function pjc_slideshow_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['pjc_slideshow_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  $mydata = $_POST['pjc_slideshow'];

  foreach ($mydata as $key => $value) {
    $opsi = get_post_meta($post_ID, 'pjc_slideshow_'.$key,true);
    // check if the custum field has a value
	if($opsi=='') {
		add_post_meta($post_ID,'pjc_slideshow_'.$key, $value);
	}
	else{
		update_post_meta($post_ID,'pjc_slideshow_'.$key, $value);
	}
	
  }

}
