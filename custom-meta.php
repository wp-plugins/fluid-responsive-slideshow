<?php
/* Define the custom box */

add_action( 'add_meta_boxes', 'tonjoo_slideshow_add_custom_box' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'tonjoo_slideshow_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'tonjoo_slideshow_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function tonjoo_slideshow_add_custom_box() 
{    
    add_meta_box( 
        'tonjoo_slideshow_meta',
        'Slide Options',
        'tonjoo_slideshow_meta',
        'pjc_slideshow' ,
        'normal',
        "high"
    );
}


/* Prints the box content */
function tonjoo_slideshow_meta( $post ) 
{
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
     
    if($postmeta=='')
        $postmeta=array();

    if(!array_key_exists('show_text',$postmeta))
        $postmeta['show_text']='yes';

    if (!isset($postmeta["slider_bg"] ))
        $postmeta["slider_bg"] = "#000000";

    if(!array_key_exists('text_position',$postmeta))
        $postmeta['text_position']='left';

    if(!array_key_exists('text_align',$postmeta))
        $postmeta['text_align']='left';

    if(!array_key_exists('text_color',$postmeta))
        $postmeta['text_color']="ffffff";

    if(!array_key_exists('title_color',$postmeta))
        $postmeta['title_color']="ffffff";

    if(!array_key_exists('show_button',$postmeta))
        $postmeta['show_button']='yes';

    if(!array_key_exists('button_skin',$postmeta))
        $postmeta['button_skin']="white";

    if(!array_key_exists('button_caption',$postmeta))
        $postmeta['button_caption']="Button Is Here";

    if(!array_key_exists('button_href',$postmeta))
        $postmeta['button_href']="#";

    if (!isset($postmeta["bg_textbox_type"] ))
        $postmeta["bg_textbox_type"] = "picture";

    if (!isset($postmeta["textbox_bg"] ))
        $postmeta["textbox_bg"] = "black";

    if (!isset($postmeta["textbox_color"] ))
        $postmeta["textbox_color"] = "";

    if (!isset($postmeta["textbox_padding"] ))
        $postmeta["textbox_padding"] = "0px 0px 0px 0px";

    if(!array_key_exists('padding_type',$postmeta))
        $postmeta['padding_type']='auto';

    ?>
    <script type="text/javascript">

        jQuery(document).ready(function(){
            jQuery('INPUT.minicolors').minicolors();
        })

    </script>

    <style>
        .tonjoo_slideshow th{
            width:100px;
            text-align: center;
        }

        label.error{
            margin-left: 5px;
            color: red;
        }
    </style>

    <style>
        .form-table td {
            vertical-align: middle;
        }

        <?php    
            if($postmeta['bg_textbox_type']=='picture')
                echo "
                #textbox_color{
                    display:none;
                }";

            if($postmeta['bg_textbox_type']=='color')
                echo "
                #tonjoo-frs-textbox-bg{
                    display:none;
                }";

            if($postmeta['bg_textbox_type']=='none')
                echo "
                #tonjoo-frs-textbox-bg{
                    display:none;
                }
                #textbox_color{
                    display:none;
                }";

            if($postmeta['padding_type']=='auto')
                echo "
                #textbox_padding{
                    display:none;
                }";

            if($postmeta['show_button']=='false')
                echo "
                #tonjoo-frs-button_skin, .button_attr{
                    display:none;
                }";
        ?>

        #picture_prev{
            width: 80px;
            height: 27px;
            background-image: url("<?php echo plugins_url( 'fluid-responsive-slideshow/backgrounds/'.$postmeta['textbox_bg'].'.png' , dirname(__FILE__) ) ?>");
            float: left;
            margin-left: 5px;
            border: solid 1px #CCC;
        }

        .tonjoo_slideshow tr th {
            text-align: left;
            font-weight: normal;
        }

        .meta-subtitle {
            margin: 0px -22px !important;
            border-top:1px solid rgb(238, 238, 238);
            background-color:#f6f6f6;
        }

        @media (max-width: 767px) {
            .meta-subtitle {
                margin-left: -12px !important;
            }
        }
    </style>

    <script type="text/javascript">
        jQuery(document).ready(function($){
            $("#tonjoo-frs-textbox-bg select").change(function(){
                value = $(this).attr('value')

                $("#picture_prev").css('background-image',"url('<?php echo plugins_url( 'fluid-responsive-slideshow/backgrounds/' , dirname(__FILE__) ) ?>" + value + ".png')");
            })

            function format(state) {
                if (!state.id) return state.text; // optgroup

                var name_select = state.id.toLowerCase();
                var name_select_array = name_select.split('-premium');

                if(name_select_array[1] == 'true')
                {
                    var button = "<?php echo plugins_url( 'fluid-responsive-slideshow-premium/buttons/' , dirname(__FILE__) ) ?>" + name_select_array[0];
                }
                else
                {
                    var button = "<?php echo plugins_url( 'fluid-responsive-slideshow/buttons/' , dirname(__FILE__) ) ?>" + name_select_array[0];
                }

                return "<div><img class='images' src='" + button + ".png'/></div>" + "<p>" + state.text + "</p>";
            }
            $("select[name='tonjoo_frs_meta[button_skin]']").select2({
                formatResult: format,
                formatSelection: format,
                escapeMarkup: function(m) { return m; }
            });

        })
    </script>

    <!-- Always default value, ordering from slideshow-->
    <input type="hidden" name="tonjoo_frs_order_number" value="<?php esc_attr_e($order_number); ?>" />

    <table class="form-table tonjoo_slideshow">
        <tr><td colspan=2><h3 class="meta-subtitle" style="margin-top:-23px !important;">General</h3></td></tr>
     
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

        <th scope="row">Background</th>
            <td>
                <input class="regular-text minicolors" style="width:150px;height:30px;float:left;margin-right:17px;" name="tonjoo_frs_meta[slider_bg]" value="<?php esc_attr_e($postmeta['slider_bg']); ?>" />
                <label class="description" > Background show when no image is available</label>
            </td>
        </tr>

        <tr><td colspan=2><h3 class="meta-subtitle">Text Box Background</h3></td></tr>

        <?php 
            $bg_textbox_type = array(
                                '0' => array(
                                        'value' =>  'picture',
                                        'label' =>  'Transparent'
                                    ),
                                '1' => array(
                                        'value' =>  'color',
                                        'label' =>  'Solid Color' 
                                    ),
                                '2' => array(
                                        'value' =>  'none',
                                        'label' =>  'None' 
                                    )
                                );

            $option_select = array(
                                "name"=>"tonjoo_frs_meta[bg_textbox_type]",
                                "description" => "Select both two options, transparent or solid color",
                                "label" => "Type",
                                "value" => $postmeta['bg_textbox_type'],
                                "select_array" => $bg_textbox_type,
                                "id"=>"tonjoo-frs-bg-textbox-type"
                            );
            
            tj_print_select_option($option_select);
            

        ?>

        <?php
            $dir =  dirname(__FILE__)."/backgrounds";

            $backgrounds = scandir($dir);

            $textbox_bg =  array();

            foreach ($backgrounds as $key => $value) 
            {
                $extension = pathinfo($value, PATHINFO_EXTENSION); 
                $filename = ucwords(pathinfo($value, PATHINFO_FILENAME)); 
                $extension = strtolower($extension);
                $the_value = strtolower($filename);

                if($extension=='png'){
                    $data = array(
                        "label"=>"$filename",
                        "value"=>"$the_value" 
                    );

                    array_push($textbox_bg,$data);
                }
            }

            $option_select = array(
                                "name"=>"tonjoo_frs_meta[textbox_bg]",
                                "description" => "<div id='picture_prev'></div>",
                                "label" => "Transparent",
                                "value" => $postmeta['textbox_bg'],
                                "select_array" => $textbox_bg,
                                "id"=>"tonjoo-frs-textbox-bg"
                            );
            
            tj_print_select_option($option_select);
        ?>

        <tr valign="top" id='textbox_color'>
            <th scope="row">Solid Color</th>
            <td>
                <input  class="regular-text minicolors" style="width:150px;height:30px;float:left;margin-right:17px;" type="text" name="tonjoo_frs_meta[textbox_color]" value="<?php esc_attr_e($postmeta["textbox_color"]); ?>" />
                <label class="description" ></label>
            </td>
        </tr>

        <tr><td colspan=2><h3 class="meta-subtitle">Text Box Position</h3></td></tr>

        <?php 
            $text_position = array(
                                '0' => array(
                                    'value' =>  'left',
                                    'label' =>  'Left'
                                ),
                                '1' => array(
                                    'value' =>  'right',
                                    'label' =>  'Right' 
                                ),
                                '2' => array(
                                    'value' =>  'bottom',
                                    'label' =>  'Bottom' 
                                ),
                                '3' => array(
                                    'value' =>  'center',
                                    'label' =>  'Center' 
                                )
                            );


            $option_select = array(
                                "name"=>"tonjoo_frs_meta[text_position]",
                                "description" => "Slide text position",
                                "label" => "Position",
                                "value" => $postmeta['text_position'],
                                "select_array" => $text_position,
                                "id"=>"tonjoo-frs-text_position"
                            );
              
            tj_print_select_option($option_select);
        ?>

        <?php 
            $text_align = array(
                            '0' => array(
                                'value' =>  'left',
                                'label' =>  'Left'
                            ),
                            '1' => array(
                                'value' =>  'center',
                                'label' =>  'Center' 
                            ),
                            '2' => array(
                                'value' =>  'right',
                                'label' =>  'Right' 
                            )
                    );


            $option_select = array(
                                "name"=>"tonjoo_frs_meta[text_align]",
                                "description" => "Slide text align",
                                "label" => "Align",
                                "value" => $postmeta['text_align'],
                                "select_array" => $text_align,
                                "id"=>"tonjoo-frs-text_align"
                            );

            
            tj_print_select_option($option_select);
        ?>

        <tr><td colspan=2><h3 class="meta-subtitle">Text Color</h3></td></tr>

        <th scope="row">Title</th>
            <td>
                <input class="regular-text minicolors" style="width:150px;height:30px;float:left;margin-right:17px;" name="tonjoo_frs_meta[title_color]" value="<?php esc_attr_e($postmeta['title_color']); ?>" />
                <label class="description" ></label>
            </td>
        </tr>
        <tr>
            <th scope="row">Description</th>
            <td>
                <input class="regular-text minicolors" style="width:150px;height:30px;float:left;margin-right:17px;" name="tonjoo_frs_meta[text_color]" value="<?php esc_attr_e($postmeta['text_color']); ?>" />
                <label class="description" ></label>
            </td>
        </tr>

        <tr><td colspan=2><h3 class="meta-subtitle">Text Box Button</h3></td></tr>

        <?php 
            $show_button = array(
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
                                "name"=>"tonjoo_frs_meta[show_button]",
                                "description" => "Select yes if you want to make the button displayed",
                                "label" => "Show Button",
                                "value" => $postmeta['show_button'],
                                "select_array" => $show_button,
                                "id"=>"tonjoo-frs-show_button"
                            );

            
            tj_print_select_option($option_select);
      ?>

      <?php 
            $dir =  dirname(__FILE__)."/buttons";

            $skins = scandir($dir);

            $button_skin =  array();

            foreach ($skins as $key => $value) {

                $extension = pathinfo($value, PATHINFO_EXTENSION); 
                $filename = pathinfo($value, PATHINFO_FILENAME); 
                $extension = strtolower($extension);
                $the_value = strtolower($filename);
                $filename_ucwords = str_replace('-', ' ', ucwords($filename));
                $filename_ucwords = ucwords($filename_ucwords);

                if($extension=='css'){
                    $data = array(
                            "label"=>"$filename_ucwords",
                            "value"=>"$the_value"                               

                        );

                    array_push($button_skin,$data);

                }
            }

           if(is_plugin_active("fluid-responsive-slideshow-premium/Fluid-Responsive-Slideshow-Premium.php") && function_exists('is_frs_premium_exist')) 
            {
                
                $dir =  ABSPATH . 'wp-content/plugins/fluid-responsive-slideshow-premium/buttons';

                $skins = scandir($dir);

                foreach ($skins as $key => $value) {

                    $extension = pathinfo($value, PATHINFO_EXTENSION); 
                    $filename = pathinfo($value, PATHINFO_FILENAME); 
                    $extension = strtolower($extension);
                    $the_value = strtolower($filename);
                    $filename_ucwords = str_replace('-', ' ', $filename);
                    $filename_ucwords = ucwords($filename_ucwords);


                    if($extension=='css'){
                        $data = array(
                                "label"=>"$filename_ucwords (Premium)",
                                "value"=>"$the_value-PREMIUMtrue"

                            );

                        array_push($button_skin,$data);

                    }
                }
            }


            $option_select = array(
                            "name"=>"tonjoo_frs_meta[button_skin]",
                            "description" => " Select button skin",
                            "label" => "Button Skin",
                            "value" => $postmeta['button_skin'],
                            "select_array" => $button_skin,
                            "id"=>"tonjoo-frs-button_skin"
                        );

            
            tj_print_select_option($option_select);
        ?>

        <tr class="button_attr">
            <th scope="row">Caption</th>
            <td>
                <input class="regular-text" name="tonjoo_frs_meta[button_caption]" value="<?php esc_attr_e($postmeta['button_caption']); ?>" />
                <label class="description" >Button caption</label>
            </td>
        </tr>
        <tr class="button_attr">
            <th scope="row">Href</th>
            <td>
                <input class="regular-text"  name="tonjoo_frs_meta[button_href]" value="<?php esc_attr_e($postmeta['button_href']); ?>" />
                <label class="description" >Button hiperlink location</label>
            </td>
        </tr>

        <!-- 
            Keputusan sementara fungsi ini (Text Box Padding) dimatikan
            karena akan membingungkan user 
            lihat juga di shortcode.php
        -->

        <!-- <tr><td colspan=2><h3 class="meta-subtitle">Text Box Padding</h3></td></tr>  -->

        <?php
            // $padding_type = array(
            //                     '0' => array(
            //                         'value' =>  'auto',
            //                         'label' =>  'Auto'
            //                     ),
            //                     '1' => array(
            //                         'value' =>  'manual',
            //                         'label' =>  'Manual'
            //                     )
            //                 );


            // $option_select = array(
            //                         "name"=>"tonjoo_frs_meta[padding_type]",
            //                         "description" => "Select textbox padding type",
            //                         "label" => "Type",
            //                         "value" => $postmeta['padding_type'],
            //                         "select_array" => $padding_type,
            //                         "id"=>"tonjoo-frs-padding_type"
            //                     );
            
            // tj_print_select_option($option_select);
        ?>

        <!-- <tr id="textbox_padding" >
            <th scope="row">Padding</th>
            <td>
                <input class="regular-text" name="tonjoo_frs_meta[textbox_padding]" value="<?php esc_attr_e($postmeta['textbox_padding']); ?>" />
                <label class="description">[top]px [right]px [bottom]px [left]px</label>
            </td>
        </tr> -->
    </table>

<?php 

} /* end function */


/* When the post is saved, saves our custom data */
function tonjoo_slideshow_save_postdata( $post_id) 
{

    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    $_POST['tonjoo_slideshow_noncename'] = isset($_POST['tonjoo_slideshow_noncename']) ? $_POST['tonjoo_slideshow_noncename'] : '';
    if ( !wp_verify_nonce( $_POST['tonjoo_slideshow_noncename'], plugin_basename( __FILE__ ) ) )
        return;


    // Check permissions
    if(isset($_POST['post_type'])){
         if ( 'page' == $_POST['post_type'] ) 
        {
            if ( !current_user_can( 'edit_page', $post_id ) ) return;
        }
        else
        {
            if ( !current_user_can( 'edit_post', $post_id ) ) return;
        }   
    }

    // OK, we're authenticated: we need to find and save the data

    //if saving in a custom table, get post_ID
    // $post_ID = $_POST['post_ID'];
    
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

    update_post_meta($post_id,'tonjoo_frs_meta', $post_meta);

    //update order number 

    $order_number = $_POST['tonjoo_frs_order_number'];

    if($order_number=='')
    {
        $order_number=0;
    }

    update_post_meta($post_id,'tonjoo_frs_order_number', $order_number);
}