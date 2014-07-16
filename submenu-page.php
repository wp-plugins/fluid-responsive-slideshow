<?php

/**
 * Register custom options for the plugin
 */

add_action("admin_init","init_pjc_slideshow_options");

function init_pjc_slideshow_options(){
		register_setting( 'pjc_options', 'pjc_slideshow_options');
}

/**
 * Option page definiton
 */


function pjc_slideshow_submenu_page(){

	if ( isset ( $_GET['tab'] ) ) 
		pjc_slideshow_tab($_GET['tab']); 
	else 
		pjc_slideshow_tab('plugin');
	
}

/**
 * Tab definiton
 */

function pjc_slideshow_tab($current = 'plugin')
{
	/* get slug */
	if($current != 'plugin')
	{
		$current_slug = get_term_by('slug', $current, 'slide_type', 'ARRAY_A');
		$current = $current_slug['slug'];
		$current_name = $current_slug['name'];
	}
	else
	{
		$current_name = 'plugin';
	}
	
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	
	<style>
		label {
			vertical-align: top
		}
		#button-slide-type {			
			margin: 1px 10px 15px 3px;
		}
	</style>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#button-slide-type").click(function(){
				var selected_slide = jQuery("#select-slide-type").val();

				self.location.href = selected_slide;
			});
		});
	</script>

	<div class="wrap">
		<?php 
			/**
			 * Check if no slyde type
			 */
			if(wp_count_terms('slide_type') <= 0)
			{
				echo "	<div class='no-slide'>
						<h2>There is no slide type to show, create a new one ? </h2><br><a frs-add-slide href='".get_admin_url()."edit-tags.php?taxonomy=slide_type&post_type=pjc_slideshow"."' class='button button-primary'>Create First Slide Type</a>
						</div>";

				die();
			}

			screen_icon();
			echo "<h2>Fluid Responsive Slideshow Options</h2>";
 		?>
		<p>You can add, edit, delete and re order your slide on this page. Drag the images to change slide ordering</p>
		<div id="icon-themes" class="icon32"><br></div>
		
		<!-- SELECT SLIDESHOW -->
		<div style="float:left;margin:5px 5px 0 0;font-weight:bold;">Select Slide Type: </div>
		<select id="select-slide-type">
		<?php
			$tabs = array();
			
			require( plugin_dir_path( __FILE__ ) . 'default-options.php');
			
			$terms = get_terms("slide_type",array("hide_empty"=>0));
		 
			foreach ( $terms as $term ){

				//$tabs[$term->name]=$term->name;
				$tabs[$term->slug]=$term->name;

			}
			
			foreach( $tabs as $tab => $name )
			{
	        	$class = ( $tab == $current ) ? 'selected' : '';
	        	
	        	echo "<option value='".get_admin_url()."edit.php?post_type=pjc_slideshow&page=frs-setting-page&tab=$tab&tabtype=slide' $class>$name</option>";
	    	}		
		?>
		</select>

		<a href="javascript:;" id="button-slide-type" class="button">Show</a>
		<a href="http://tonjoo.com/addons/fluid-responsive-slideshow/" target="_blank">Fluid Responsive Slideshow Manual</a>
		<a href="http://wordpress.org/support/view/plugin-reviews/fluid-responsive-slideshow?rate=5#postform" target="_blank" style="margin-left:10px;">Enjoy with the plugin?, rate us!</a>

		<!-- Add Buton -->
		<?php if( (isset($_GET['tabtype'])&&$_GET['tabtype']=='slide') || (!isset($_GET['tab'])) ): ?>
		<br>
		<a frs-add-slide class='button button-primary'>Add New Slide</a><span class="spinner frs-button-spinner " ></span>
		<br>
		<br>
		<?php endif; ?>
		<?php
			/**
			 * get term for current slideshow 
			 */
			$term_id = 0;
			$term_slug = "";

			if(isset($_GET['tab']) && $_GET['tab'] != "")
			{
				$term = term_exists($_GET['tab'], 'slide_type');
				$term_id = $term['term_id'];
				$term_slug = $_GET['tab'];
			}
			else
			{
				/**
				 * get term if not defined current slideshow
				 */
				$args = array('number' => '1','hide_empty' => false);
				$terms = get_terms('slide_type', $args );

				foreach ($terms as $term) {
					$term_id = $term->term_id;
					$term_slug = $term->slug;
				}
			}
		?>

		<!-- BEGIN TAB SLIDE AND OPTIONS -->
		<h2 class="nav-tab-wrapper">
		<?php if(isset($_GET['tab']) && $_GET['tab'] != ""): ?>
			<a class="nav-tab <?php if(isset($_GET['tabtype']) && $_GET['tabtype'] == "slide") echo "nav-tab-active" ?>" href='<?php echo get_admin_url()."edit.php?post_type=pjc_slideshow&page=frs-setting-page&tab=".$_GET['tab']."&tabtype=slide" ?>'>Slide</a>
			<a class="nav-tab <?php if(! isset($_GET['tabtype']) || $_GET['tabtype'] != "slide") echo "nav-tab-active" ?>" href='<?php echo get_admin_url()."edit.php?post_type=pjc_slideshow&page=frs-setting-page&tab=".$_GET['tab'] ?>'>Configuration</a>
		<?php else: ?>
			<a class="nav-tab nav-tab-active" href='<?php echo get_admin_url()."edit.php?post_type=pjc_slideshow&page=frs-setting-page&tab=".$term_slug."&tabtype=slide" ?>'>Slide</a>
			<a class="nav-tab" href='<?php echo get_admin_url()."edit.php?post_type=pjc_slideshow&page=frs-setting-page&tab=".$term_slug ?>'>Configuration</a>
		<?php endif ?>
		</h2>
		<div class='frs-notice-wrapper'>
			<div class="updated below-h2 frs-updated"><p><strong>Updated!</strong> Your changes has been saved</p></div>		
			<div class="updated below-h2 frs-updated-error"><p><strong>Error Updated!</strong> Please try again in a moment</p></div>		
		</div>
		<?php

		if(isset($_GET['tabtype']) && $_GET['tabtype'] == "slide")
		{
			/**
			 * load slide page
			 */
			require_once( plugin_dir_path( __FILE__ ) . 'submenu-page-slide.php');
		}
		elseif(! isset($_GET['tab']))
		{
			/**
			 * load slide page if not defined current slideshow
			 */
			require_once( plugin_dir_path( __FILE__ ) . 'submenu-page-slide.php');
		}
		else
		{
			/**
			 * load options page
			 */
			require_once( plugin_dir_path( __FILE__ ) . 'submenu-page-options.php');
		}

		?>
		
		
	</div>

	<?php
}
