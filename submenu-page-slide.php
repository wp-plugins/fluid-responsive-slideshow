<?php
	/**
	 * declared variable from submenu-page.php:
	 *
	 * $term_id
	 * $term_slug
	 */
?>


<script type="text/javascript">	
	current_frs_slide_type = '<?php echo $term_id ?>'
</script>

<?php 

global $post;

$args = array(
	'post_type' => 'pjc_slideshow',
	'posts_per_page' => 999,
	'orderby' => 'CONVERT(tonjoo_frs_order_number,signed) meta_value_num',
	'order' => 'ASC',
	'meta_key' => 'tonjoo_frs_order_number',
	'tax_query' => array(
		array(
			'taxonomy' => 'slide_type',
			'field' => 'slug',
			'terms' => $term_slug
		)
	)
);

$query = new WP_Query( $args );
$zeroHide = '';
?>
<table class="wp-list-table widefat fixed dataTable no-footer" id="table-slide" style="margin-top:20px;">
	<tbody>
	<?php if ($query->have_posts()): $zeroHide = 'hide' ?>


		<?php while ($query->have_posts()): $query->the_post(); ?>
		<?php

			//get permalink to edit
			$id = get_the_ID();
			$edit = admin_url()."post.php?post={$id}&action=edit";

			include 'ajax-row-template.php';
		?>
		<?php endwhile; ?>
	<?php endif; ?>

	</tbody>
</table>
<div class='no-slide <?php echo $zeroHide ?>'>
		<h2>The slide type seems empty ! </h2><br><a frs-add-slide  class='button button-primary'>Create First Slide</a><span class="spinner frs-button-spinner" ></span>
</div>

<?php 

$id = null ;

if($id==null){
	$type='Add';
}

?>

<!-- Modal add and edit -->
<div class="frs-modal-backdrop"></div>
<div class='frs-modal-container postbox-container'></div>
<?php
tonjoo_js_wp_editor();

/* Restore original Post Data */
wp_reset_postdata();