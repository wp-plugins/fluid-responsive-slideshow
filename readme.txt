=== Plugin Name ===
Tags: slideshow, gallery, image, responsive, fluid, images
Donate link: http://tonjoo.com/donate/
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fluid Responsive Slideshow / image slider is a wordpress plugin that enable you to put slideshow easily into post,page, or template. 
== Description ==

Fluid Responsive Slideshow / image slider is a wordpress plugin that enable you to put slideshow easily into post,page, or template. This plugin is based on a jquery plugin called orbit.js

**Features :**

* Manage your slideshow as you manage your post / page.
* Ordering of Image in a slideshow.
* Multiple slideshow on single page/post.
* Responsive Image.
* Hiperlink on image.
* Custom text and font size.
* And many custumizable parameter.
* Multiple Skin


**Usage Instruction**

1. Add a Slide Type in the , Slide Type page. One Slide Type equal to one album. Slide type must not contain white space, so don't use term like "Best Cars" use "best-cars" or "bestcars"
2. Add Slide, add the title and the text content of the Slide.
3. Insert the picture using featured image. Choose the picture, select show and then click the “use as featured image” button.
4. Add the Slide Type to the Slide.The slide will not working without the Slide Type.
5. Publish the slide.

**Publish your slideshow on a Page/Post/Custom Post Type**

Put the line bellow on your post/page :

[pjc_slideshow slide_type='your_slide_type']

**Publish your slideshow on a theme**

Put the line bellow on your theme file :

<?php echo do_shortcode("[pjc_slideshow slide_type='your_slide_type']"); ?>

**Notes**

* The slide_type paramater is case sensitive
* Image size must be less or equal than parrent container
* One slide type can only be made to one slideshow

**Upgrade Instruction from 0.90**

* Update each slide options on the slide page
* Update the FR Slideshow Option for each slide type


*if you have any questions,comment,customization request or suggestion please contact me via support[at]tonjoo.com or [visit plugin site](http://www.tonjoo.com/wordpress-plugin-fluid-responsive-slideshow-plugin/ "visit plugin site")*

*You can view available skins on [skins demo](http://tonjoo.com/skins-for-fluid-responsive-slideshow/ "skins demo")*



== Installation ==

1. Grap the plugin from from wordpress plugin directory or Upload the fluid-responsive-slideshow folder to the /wp-content/plugins/ directory
2. Activate the plugin

== Frequently Asked Questions ==

**My slideshow is not working ?**

Please try to deactive other plugin. Most of the problem was caused by other plugin that load JQuery library via CDN which is actualy not allowed by Wordpress.

**Some of my slide is not showing up**

All of the slide must have a slide order and slide type.

== Screenshots ==

1. The slideshow is easy embed on post/page by using shortcode.
2. Adding a new slideshow is as easy as adding a new categories/tags.
3. You can easily browse and manage your slide just like managing normal post.
4. This plugin already provide you with a bunch of option to custumize the slideshow based on your preference. Every slide type also has it owns options
5. Skin Options

== Changelog ==

= 0.92=
* Fix options bug
* Add 3 Skin

= 0.91=
* Support IE 7
* Fix Option Saving Bug
* Add skin support ~ skin available on next release 

= 0.9 =
* First Release


