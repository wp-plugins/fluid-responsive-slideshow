<?php

function frs_modal($post_id){

if($post_id!='false')
	$post = get_post($post_id);
else{
	$post = new FRSPost();
	$post->post_content="";
	$post->ID=null;
}


?>
	<div class='media-modal wp-core-ui hide' id='frs-tonjoo-modal' >
		<div class='frs-modal-content'>
			<div class='frs-modal-post'>
				<form id='frs-modal-form'>
					<div class='frs-table-left'>
						<h2 class="frs-modal-options">Slide Options</h2>
						<?php 

							tonjoo_slideshow_meta($post);

						?>
					</div>

					<div class='frs-table-right'>
							<input type='text' name='title' id="frs-title" placeholder='Slider Title' value="<?php echo get_the_title($post_id) ?>">
							<?php 
								
							$img_default =  plugin_dir_url( __FILE__ ).'/assets/slideshow_empty.png';

							if($post_id!='false'&& has_post_thumbnail($post_id)){				

								$post_thumbnail_id = get_post_thumbnail_id($post_id);

								$scr = wp_get_attachment_image_src($post_thumbnail_id,'original');

								$scr = $scr[0];
							}
							else{

								$post_thumbnail_id = 'false';

								$scr = $img_default;
							}

							?>

							<div mediauploader style="margin-top:10px;">
								<img mediaUploadImage src="<?php echo $scr ?>" class='frs-modal-image'>
								<input mediaUploadID type='hidden'  name='featured_image' value='<?php echo $post_thumbnail_id ?>'>
					      		<input type='button' class='button-primary button-frs button' mediaUploadButton value='Set image'>
					      		<a class='button-frs button button-danger' frs-remove-image data-image-default='<?php echo $img_default ?>'>Remove Image</a>
							</div>

							
							<?php 

							$content = $post->post_content;
						
							$content = apply_filters('the_content',$content);
					
							?>
							<textarea id='frs-modal-content'><?php echo $content ?></textarea>
							<?php
								 
							?>
					
					</div>
				</form>
			</div>
		</div>
		<div class="floating-modal-button">
			<span class="spinner frs-button-spinner frs-button-spinner-modal " ></span>
			<a class='button button-frs button-primary' frs-save-slider data-post-id='<?php echo $post_id?>'>Save Slider</a>
			<?php if($post_id!='false'): ?>
			<a class="button-frs button button-danger" data-post-id="<?php echo $post_id?>" frs-delete-slide="">Delete Slide</a>
			<?php endif; ?>

			<a class='button frs-modal-close' frs-modal-close-modal >Cancel</a>
		</div>
	</div>

<?php
}
