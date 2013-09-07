<?php

$options = get_option('pjc_slideshow_options');

if (!isset($options[$current]["height"]))
	$options[$current]["height"] = '370';

if (!isset($options[$current]["arrow_position"]))
	$options[$current]["arrow_position"] = '45%';



if (!isset($options[$current]["width"]))
	$options[$current]["width"] = "650";

if (!isset($options[$current]["is_fluid"]))
	$options[$current]["is_fluid"] = "false";

if (!isset($options[$current]["show_textbox"]))
	$options[$current]["show_textbox"] = "true";

if (!isset($options[$current]["textbox_height"]))
	$options[$current]["textbox_height"] = "100";

if (!isset($options[$current]["fade_time"]))
	$options[$current]["fade_time"] = "2500";

if (!isset($options[$current]["textbox_p_size"]))
	$options[$current]["textbox_p_size"] = "10";

if (!isset($options[$current]["textbox_h4_size"]))
	$options[$current]["textbox_h4_size"] = "14";

if (!isset($options[$current]["textbox_padding"]))
	$options[$current]["textbox_padding"] = "10";

if (!isset($options[$current]["hover"]))
	$options[$current]["hover"] = "true";

if (!isset($options[$current]["navigation"]))
	$options[$current]["navigation"] = "true";

if (!isset($options[$current]["bullet"]))
	$options[$current]["bullet"] = "true";

if (!isset($options[$current]["bullet_thumbs"]))
	$options[$current]["bullet_thumbs"] = "false";

if (!isset($options[$current]["animation"]))
	$options[$current]["animation"] = "fade";

if (!isset($options[$current]["animation_time"]))
	$options[$current]["animation_time"] = "800";

if (!isset($options[$current]["show_timer"]))
	$options[$current]["show_timer"] = "true";

if (!isset($options[$current]["pause"]))
	$options[$current]["pause"] = "true";

if (!isset($options[$current]["small_navigation"]))
	$options[$current]["small_navigation"] = "false";

if (!isset($options[$current]["small_navigation_treshold"]))
	$options[$current]["small_navigation_treshold"] = "600";

if (!isset($options[$current]["start_mouseout"]))
	$options[$current]["start_mouseout"] = "true";

if (!isset($options[$current]["start_mouseout_after"] ))
	$options[$current]["start_mouseout_after"] = "800";
?>