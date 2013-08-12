<?php

/*
 * Register custom options for the plugin
 */

add_action("admin_init","init_pjc_slideshow_options");

function init_pjc_slideshow_options(){
		register_setting( 'pjc_options', 'pjc_slideshow_options');
}

/*
 * Option page definiton
 */


function pjc_slideshow_submenu_page(){

	if ( isset ( $_GET['tab'] ) ) 
		pjc_slideshow_tab($_GET['tab']); 
	else 
		pjc_slideshow_tab('plugin');
	
}

/*
 * Tab definiton
 */


function pjc_slideshow_tab($current = 'plugin'){


	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	
	<style>
		label {
			vertical-align: top
		}
	</style>
	<div class="wrap">
		<?php screen_icon();
		echo "<h2>Fluid Responsive Slideshow Options</h2>";
 		?>
		<p>Each Slide Type can have its own setting. *Additional CSS can be edited at the fluid-responsive-slideshow.css</p>
		
		<?php
		
		 
		  
		  
	    
		?>
		  
		<div id="icon-themes" class="icon32"><br></div>
		<h2 class="nav-tab-wrapper">
		<?php
		
		
		$tabs = array( 'plugin' => 'Information');
		
		require( plugin_dir_path( __FILE__ ) . 'default-options.php');
		
		$terms = get_terms("slide_type",array("hide_empty"=>0));
	 
	      foreach ( $terms as $term ){
	     
	      	$tabs[$term->name]=$term->name;
		
	      }
		
	
			
		
		
		
		foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        	echo "<a class='nav-tab$class' href='?page=setting-page&tab=$tab'>$name</a>";
    	}
		?>
		</h2>
		
		<?php switch ( $current ) {
		
			case 'plugin':
				require( plugin_dir_path( __FILE__ ) . 'manual.php');
			?>
		
			
			
			<?php
			break;
			case $current:
			?>
			<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
				<br><div class="updated fade"><p><strong><?php _e('Options saved', 'pjc_slideshow_options'); ?></strong></p></div>
			<?php endif; ?> 
			<form method="post" action="options.php">
			<?php settings_fields('pjc_options'); ?>
		
		
			<?php
			
			  foreach ( $terms as $term ){
	     
		     
				  
				if($options[$term->name] && $term->name!=$current){
					foreach ($options[$term->name] as $key => $value) {
						echo "<input type='hidden' value='$value' name='pjc_slideshow_options[$term->name][$key]'>";
					}
				}
			
		      }
			
			
			?>
			
			<h2><?php echo "Slide $current Options"?></h2>
			<!-- Extra style for options -->
			<style>
				.form-table td {
					vertical-align: middle;
				}

				.form-table th {
					width: 150px
				}

				.form-table input,.form-table select {

					width: 150px;
					margin-right: 10px;
				}
				<?php
					if($options[$current][is_fluid]=='true')
						echo "
							#max_image_width{
								display:none;
							}
						";

					if($options[$current][navigation]=='false')
						echo "
							.tonjoo_nav_option{
								display:none;
							}
						";
				
				?>
			</style>
			
			<table class="form-table">
				<?php 

				$dir =  dirname(__FILE__)."/skins";

				
				//post format
			


				$skins = scandir($dir);

				$slideshow_skin =  array();

				foreach ($skins as $key => $value) {

					$extension = pathinfo($value, PATHINFO_EXTENSION); 
					$filename = pathinfo($value, PATHINFO_FILENAME); 
					$extension = strtolower($extension);
					$the_value = strtolower($filename);

					if($extension=='css'){
						$data = array(
								"label"=>"$filename",
								"value"=>"$the_value"								

							);

						array_push($slideshow_skin,$data);

					}
					
				
		
				}


			


				$option_select = array(
								"name"=>"pjc_slideshow_options[{$current}][skin]",
								"description" => "Select skin",
								"label" => "Slideshow Skin",
								"value" => $options[$current][skin],
								"select_array" => $slideshow_skin,
								"id"=>"tonjoo-frs-skin"
							);

				
				 tj_print_select_option($option_select);
				?>

				<?php 

				$slideshow_fluid = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);


				$option_select = array(
								"name"=>"pjc_slideshow_options[{$current}][is_fluid]",
								"description" => "Select yes if you want to make the slideshow be fluid",
								"label" => "Fluid Slideshow",
								"value" => $options[$current][is_fluid],
								"select_array" => $slideshow_fluid,
								"id"=>"tonjoo-frs-is-fluid"
							);

				
				 tj_print_select_option($option_select);
				?>

				<tr valign="top" id='max_image_width'>
					<th scope="row">Maximal Image Width</th>
					<td>
						<input  class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][width]"?>" value="<?php esc_attr_e($options[$current]["width"]); ?>" />
						<label class="description" >Maximal Width of image, height will be adjusted proportionally</label>
					</td>
				</tr>
				<!-- <tr valign="top">
					<th scope="row">Image Height</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][height]"?>" value="<?php esc_attr_e($options[$current]["height"]); ?>" />
						<label class="description" >Height of the image</label>
					</td>
				</tr>
				 -->
				 <?php 

				$slideshow_select = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);


				$option_select = array(
								"name"=>"pjc_slideshow_options[{$current}][show_textbox]",
								"description" => "Select yes if you to show the textbox",
								"label" => "Show Textbox",
								"value" => $options[$current][show_textbox],
								"select_array" => $slideshow_select,
								"id"=>"tonjoo-frs-is-show-textbox"
							);

				
				 tj_print_select_option($option_select);
				?>
				<tr valign="top">
					<th scope="row">Textbox height</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][textbox_height]"?>" value="<?php esc_attr_e($options[$current]["textbox_height"]); ?>" />
						<label class="description" >Textbox height</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Textbox Padding</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][textbox_padding]"?>" value="<?php esc_attr_e($options[$current]["textbox_padding"]); ?>" />
						<label class="description" >Textbox padding</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Textbox Heading Size</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][textbox_h4_size]"?>" value="<?php esc_attr_e($options[$current]["textbox_h4_size"]); ?>" />
						<label class="description" >Textbox Heading</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Textbox Text Size</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][textbox_p_size]"?>" value="<?php esc_attr_e($options[$current]["textbox_p_size"]); ?>" />
						<label class="description" >Textbox Heading</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Slide Time</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][fade_time]"?>" value="<?php esc_attr_e($options[$current]["fade_time"]); ?>" />
						<label class="description" >The speed image cycle (in millisecond).0 for manual slideshow</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Slide Transition time</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][animation_time]"?>" value="<?php esc_attr_e($options[$current]["animation_time"]); ?>" />
						<label class="description" >The speed of the transisiton animation (in millisecond).</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Pause on hover</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][pause]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);
								
							
								$selected = $options[$current]["pause"];
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
						<label class="description" >Select yes to pause animation on mouse hover</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Continue on Mouseout</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][start_mouseout]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);
								
							
								$selected = $options[$current]["start_mouseout"];
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
						<label class="description" >Select yes to continue animation ater the mouseout event. In effect when 'Pause on hover' is set yes</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Delayed start after mouseout</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][start_mouseout_after]"?>" value="<?php esc_attr_e($options[$current]["start_mouseout_after"]); ?>" />
						<label class="description" >Animation will resume after mouseout event in the given time (in ms). In effect when 'Continue on mouseout' is set yes</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Show Timer</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][show_timer]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);
								
							
								$selected = $options[$current]["show_timer"];
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
						<label class="description" >Display a small timer on the slideshow</label>
					</td>
				</tr>
				<tr valign="top" id='tonjoo_show_navigation_arrow'>
					<th scope="row">Show Navigation Arrow</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][navigation]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);
								
							
								$selected = $options[$current]["navigation"];
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
						<label class="description" >If "no" is selected the navigation arrow will not visible</label>
					</td>
				</tr>
				<tr valign="top" class='tonjoo_nav_option'>
					<th scope="row">Navigation Arrow Position</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][arrow_position]"?>" value="<?php esc_attr_e($options[$current]["arrow_position"]); ?>" />
						<label class="description" >Position of navigation arrow from top( in % )</label>
					</td>
				</tr>
				<tr valign="top" class='tonjoo_nav_option'>
					<th scope="row">Small Navigation Arrow (not available on all themes)</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][small_navigation]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);
								
							
								$selected = $options[$current]["small_navigation"];
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
						<label class="description" >Use smaller navigation arrow (for smaller slideshow)</label>
					</td>
				</tr>
				<tr valign="top" class='tonjoo_nav_option'>
					<th scope="row">Small navigation size threshold</th>
					<td>
						<input class="regular-text" type="text" name="pjc_slideshow_options<?php echo "[$current][small_navigation_treshold]"?>" value="<?php esc_attr_e($options[$current]["small_navigation_treshold"]); ?>" />
						<label class="description" >If the size of the gallery bellow the threshold, small navigation arrow will be used.If the value bigger than the gallery size the navigation arrow will stay small</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Bullet Navigation</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][bullet]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'true',
										'label' =>  'Yes'
									),
									'1' => array(
										'value' =>	'false',
										'label' =>  'No' 
									)
								);
								
							
								$selected = $options[$current]["bullet"];
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
						<label class="description" >If "no" is selected the bullet navigation will not visible</label>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Slideshow animation</th>
					<td>
						<select name="pjc_slideshow_options<?php echo "[$current][animation]"?>">
							<?php
							
								$navigation = array(
									'0' => array(
										'value' =>	'fade',
										'label' =>  'Fade'
									),
									'1' => array(
										'value' =>	'horizontal-slide',
										'label' =>  'Horizontal Slide' 
									),
									'2' => array(
										'value' =>	'horizontal-push',
										'label' =>  'Horizontal Push'
									),
									'3' => array(
										'value' =>	'vertical-slide',
										'label' =>  'Vertical Slide' 
									)
								);
								
							
								$selected = $options[$current]["animation"];
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
						<label class="description" >The animation type in slide transition</label>
					</td>
				</tr>
			</table>
			<br>
			<br>
			
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Options', 'pjc_slideshow_options'); ?>" />
			</p>
		</form>
			
			
			<?php
			break;
		} ?>
	</div>
	<?php

	}
