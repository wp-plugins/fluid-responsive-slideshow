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


1. Create a 'Slide Type'. Each `Slide type` equal to one gallery.
   - The `Slide Type` must only contain alphabet and letter (do not use whitespace and number ). So `Best Car` won't work, use `Best_Car`
   - One slide type can only be made to one slideshow
2. After creating a `Slide type`, configure the slideshow on the option page . The skin, slide time, etc can be modified here.
3. To add a picture (Slide) to the `Slide Type` (Gallery) add a new slide .
4. Add Slide title and content, add the `Slide Type` and order number to the Slide.The slide will not working without the Slide Type and order number
5. Insert the picture using featured image.
   - Choose the picture, select show and then click the "use as featured image" button
   - Picture size must be equal for all Images in a slide type
6.	Publish the slide
7.	Use shortcode [pjc_slideshow slide_type='name_of_the_slide_type'] to show the slideshow on your post
8.	Use <?php echo do_shortcode("[pjc_slideshow slide_type='name_of_the_slide_type']"); ?> to show the slide on the theme

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
= 0.9.8 =
* Minor code refactoring
* Improved usage instruction
* Fixed slidshow animation on certain themes

= 0.9.6 =
* Fix featured image bug
* Fix post meta bug

= 0.9.5 =
* Add support for ozh Admin

= 0.9.4 =
* Fix maximal number of slide

= 0.9.2 =
* Fix options bug
* Add 3 Skin

= 0.91 =
* Support IE 7
* Fix Option Saving Bug
* Add skin support ~ skin available on next release 

= 0.9 =
* First Release


