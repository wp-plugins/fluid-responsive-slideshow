<?php

$options = get_option('pjc_slideshow_options');

if ($options[$current]["height"] == "")
	$options[$current]["height"] = '370';

if ($options[$current]["arrow_position"] == "")
	$options[$current]["arrow_position"] = '45%';

if ($options[$current]["width"] == "")
	$options[$current]["width"] = "650";

if ($options[$current]["textbox_height"] == "")
	$options[$current]["textbox_height"] = "100";

if ($options[$current]["fade_time"] == "")
	$options[$current]["fade_time"] = "2500";

if ($options[$current]["textbox_p_size"] == "")
	$options[$current]["textbox_p_size"] = "10";

if ($options[$current]["textbox_h4_size"] == "")
	$options[$current]["textbox_h4_size"] = "14";

if ($options[$current]["textbox_padding"] == "")
	$options[$current]["textbox_padding"] = "10";

if ($options[$current]["hover"] == "")
	$options[$current]["hover"] = "true";

if ($options[$current]["navigation"] == "")
	$options[$current]["navigation"] = "true";

if ($options[$current]["bullet"] == "")
	$options[$current]["bullet"] = "true";

if ($options[$current]["bullet_thumbs"] == "")
	$options[$current]["bullet_thumbs"] = "false";

if ($options[$current]["animation"] == "")
	$options[$current]["animation"] = "fade";

if ($options[$current]["animation_time"] == "")
	$options[$current]["animation_time"] = "800";

if ($options[$current]["show_timer"] == "")
	$options[$current]["show_timer"] = "true";

if ($options[$current]["pause"] == "")
	$options[$current]["pause"] = "true";

if ($options[$current]["small_navigation"] == "")
	$options[$current]["small_navigation"] = "false";

if ($options[$current]["small_navigation_treshold"] == "")
	$options[$current]["small_navigation_treshold"] = "600";

if ($options[$current]["start_mouseout"] == "")
	$options[$current]["start_mouseout"] = "true";

if ($options[$current]["start_mouseout_after"] == "")
	$options[$current]["start_mouseout_after"] = "800";
?>