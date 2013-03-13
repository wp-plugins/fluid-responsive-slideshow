<?php

/* Define the custom box */

add_action( 'add_meta_boxes', 'tonjoo_slideshow_add_custom_box' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'tonjoo_slideshow_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'tonjoo_slideshow_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function tonjoo_slideshow_add_custom_box() {
  
  //add_meta_box( 
  // $id, 
  // $title, 
  // $callback, 
  // $post_type, 
  // $context, 
  // $priority,
   // $callback_args )
  
    add_meta_box( 
        'tonjoo_slideshow_meta',
        'Slide Options',
        'tonjoo_slideshow_meta',
        'pjc_slideshow' ,
        'normal',
        "high"
    );
  
  
   /*
    * Add information page on admin panel
    */
  
    add_meta_box( 
         'tonjoo_slideshow_info',
        'Instruction',
        'tonjoo_display_info',
        'pjc_slideshow', 
        'normal',
         'low'
    );
  

  

}

/* Prints the box content */
function tonjoo_slideshow_meta( $post ) {



  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'tonjoo_slideshow_noncename' );

  $postmeta = get_post_meta($post->ID, 'tonjoo_frs_meta',true);
  $order_number = get_post_meta($post->ID, 'tonjoo_frs_order_number',true);


  // $text = get_post_meta($post->ID, 'tonjoo_slideshow_text',true);

  // $title_color = get_post_meta($post->ID, 'tonjoo_slideshow_titlecolor',true);
  // $text_color = get_post_meta($post->ID, 'tonjoo_slideshow_textcolor',true);
  
  // $href = get_post_meta($post->ID, 'tonjoo_slideshow_href',true);


  if(!$order_number)
     $order_number=0;
  
  if(!$postmeta['show_text'])
    $postmeta['show_text']='yes';
  
  if(!$postmeta['text_color'])
   $postmeta['text_color']="ffffff";
  
  if(!$postmeta['title_color'])
   $postmeta['title_color']="ffffff";
  
  if(!$postmeta['href'])
  $postmeta['href']="#";
  

  
?>
<style>
.tonjoo_slideshow th{
  width:100px;
  text-align: center;
}
</style>

<script type="text/javascript">
  jQuery(document).ready(function(){

    jQuery('.color-picker').minicolors()
    console.log("tes")
  })
</script>

<table class="form-table tonjoo_slideshow">
  <tr>
    <th scope="row">Order Number</th>
    <td >
      <input style="width:20px;" class="regular-text" type="text" name="tonjoo_frs_order_number" value="<?php esc_attr_e($order_number); ?>" />
      <label class="description" >The slide will be sorted from the lowest number,if the order is equal the slide is order by the oldest date first</label>
    </td>
  </tr>
  <?php 

        $show_text = array(
                  '0' => array(
                    'value' =>  'true',
                    'label' =>  'Yes'
                  ),
                  '1' => array(
                    'value' =>  'false',
                    'label' =>  'No' 
                  )
                );


        $option_select = array(
                "name"=>"tonjoo_frs_meta[show_text]",
                "description" => "Select yes if you want to make the text displayed",
                "label" => "Show Text",
                "value" => $postmeta['show_text'],
                "select_array" => $show_text,
                "id"=>"tonjoo-frs-show_text"
              );

        
         tj_print_select_option($option_select);
  ?>
  <th scope="row">Title Color</th>
    <td>
      <input class="regular-text color-picker"  name="tonjoo_frs_meta[title_color]" value="<?php esc_attr_e($postmeta['title_color']); ?>" />
      <label class="description" >Title Color</label>
    </td>
  </tr>
  <tr>
    <th scope="row">Text Color</th>
    <td>
      <input class="regular-text color-picker"  name="tonjoo_frs_meta[text_color]" value="<?php esc_attr_e($postmeta['text_color']); ?>" />
      <label class="description" >Text Color</label>
    </td>
  </tr>
  <tr>
    <th scope="row">Image Href</th>
    <td>
      <input class="regular-text"  name="tonjoo_frs_meta[href]" value="<?php esc_attr_e($postmeta['href']); ?>" />
      <label class="description" >Image Hiperlink location</label>
    </td>
  </tr>
</table>

<?php 

}

/* When the post is saved, saves our custom data */
function tonjoo_slideshow_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['tonjoo_slideshow_noncename'], plugin_basename( __FILE__ ) ) )
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
  $post_meta = $_POST['tonjoo_frs_meta'];

  // foreach ($mydata as $key => $value) {
  //   $opsi = get_post_meta($post_ID, 'tonjoo_slideshow_'.$key,true);
  //   // check if the custum field has a value
  // if($opsi=='') {
  //   add_post_meta($post_ID,'tonjoo_slideshow_'.$key, $value);
  // }
  // else{
  //   update_post_meta($post_ID,'tonjoo_slideshow_'.$key, $value);
  // }

  //trim data

  foreach ( $post_meta as $key => $value) {
    # code...
    $postmeta[$key]= trim($value);
    $postmeta[$key]= esc_attr($value);
  }

  


   update_post_meta($post_ID,'tonjoo_frs_meta', $post_meta);

  //update order number 

   $order_number = $_POST['tonjoo_frs_order_number'];

   if($order_number==''){
      $order_number=0;
    }
    update_post_meta($post_ID,'tonjoo_frs_order_number', $order_number);
}


