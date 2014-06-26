jQuery(document).ready(function($){
	$(".postbox-container  ").on('change','#tonjoo-frs-show_button select',function(){
		value = $(this).attr('value')

		if(value=='false'){			
			$(".button_attr").hide('slow');
			$("#tonjoo-frs-button_skin").hide('slow');
		}

		else{
			$(".button_attr").show('slow');
			$("#tonjoo-frs-button_skin").show('slow');
		}
	})

	$(".postbox-container  ").on('change','#tonjoo-frs-padding_type select',function(){
		value = $(this).attr('value')

		if(value=='auto'){			
			$("#textbox_padding").hide('slow');
		}
		else{
			$("#textbox_padding").show('slow');
		}
	})

	$(".postbox-container  ").on('change','#tonjoo-frs-is-fluid select',function(){
		value = $(this).attr('value')

		if(value=='true'){			
			$("#max_image_width").hide('slow');
		}
		else{
			$("#max_image_width").show('slow');
		}
	})

	$(".postbox-container ").on('change',' #tonjoo_show_navigation_arrow select',function(){
		value = $(this).attr('value')

		if(value=='true'){

			$(".tonjoo_nav_option").show('slow');
		}
		else{
			$(".tonjoo_nav_option").hide('slow');
		}
	})

	$(".postbox-container ").on('change','#tonjoo-frs-bg-textbox-type select',function(){
		value = $(this).attr('value')

		if(value=='picture'){			
			$("#tonjoo-frs-textbox-bg").show('slow');
			$("#textbox_color").hide('slow');
		}
		else if(value=='color'){
			$("#tonjoo-frs-textbox-bg").hide('slow');
			$("#textbox_color").show('slow');
		}
		else{
			$("#textbox_color").hide('slow');
			$("#tonjoo-frs-textbox-bg").hide('slow');
		}
	})

	
	/**
	 * Slideshow submenu
	 */
	jQuery(document).ready( function($) {
		var category = $('table#table-slide tbody').attr('category');

	    frs_resort_data_table()

	   	$('table#table-slide tbody , .frs-modal-container  ').on('click','[frs-delete-slide]',function(){
	   		
	   		deleteConfirmation = confirm("Are you sure to delete the slide ? ");	

	   		button = jQuery(this)	

	   		post_id = button.data('post-id')

	   		if(deleteConfirmation){
	   			 ajax_button_spin(button)
	   			 data = {
		   			action:'frs_delete',
		   			post_id:button.data('post-id')
		   		}

	   			jQuery.post(ajaxurl, data,function(response){
	   				if(response.success)
	   				{
	   					jQuery('.frs-modal-backdrop').removeClass('active');
						jQuery('.frs-modal-container .frs-table-left').html('');	
						jQuery('.frs-modal-container').hide();	

	   		 			jQuery('#list_item_'+post_id).hide('3000', function(){ 
	   		 				jQuery('#list_item_'+post_id).remove() 
	   		 				frs_check_table_size()
	   		 			});
	   		 			ajax_button_spin_stop(button)
	   		 			frs_notice_updated()
	   				}
	   				else{
	   					frs_notice_error_updated()
	   				}
	   			})
	   		}else{
	   			ajax_button_spin_stop(button)
	   		}	  
	   	})

	   	$('[frs-add-slide]').click(function(){

			button = jQuery(this)	

			ajax_button_spin(button)

   			data = {
	   			action:'frs_show_modal',
	   			post_id: 'false'
	   		}

   			jQuery.post(ajaxurl, data,function(response){	   				
   				if(response.success){	   					

   					decoded = $("<div/>").html(response.modal).text();

   		 			jQuery('.frs-modal-container .frs-table-left').html(decoded)

   		 			/* set right content value */
   		 			var frs_id = response.id
   		 			var frs_title = response.title
   		 			var img_default = response.img_default
   		 			var post_thumbnail_id = response.post_thumbnail_id

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-primary').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal input#frs-title').val(frs_title);

   		 			jQuery('#frs-tonjoo-modal [media-upload-image]').attr('src',response.scr);
   		 			
   		 			jQuery('#frs-tonjoo-modal [media-upload-id]').attr('value',post_thumbnail_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal [frs-remove-image]').attr('data-image-default',img_default);

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').hide();

   		 			if(typeof tinyMCE != 'undefined' && tinyMCE.get('frs-modal-content'))
   		 				tinyMCE.get('frs-modal-content').setContent(response.content)
   		 			else
   		 				jQuery('#frs-modal-content').val('')

   		 			/* set active */
   		 			jQuery('.frs-modal-backdrop').addClass('active')
   		 			jQuery('.frs-modal-container').show().addClass('active')

   		 			ajax_button_spin_stop(button)
   				}
   			})	   		
	   	})


	    $('table#table-slide tbody ').on('click','[frs-edit-slide]',function(){

			button = jQuery(this)	

			ajax_button_spin(button)

   			data = {
	   			action:'frs_show_modal',
	   			post_id:button.data('post-id')
	   		}

   			jQuery.post(ajaxurl, data,function(response){	   				

   				if(response.success){	   					

   					ajax_button_spin_stop(button)

   					decoded = $("<div/>").html(response.modal).text();

   		 			jQuery('.frs-modal-container .frs-table-left').html(decoded)

   		 			/* set right content value */
   		 			var frs_id = response.id
   		 			var frs_title = response.title
   		 			var img_default = response.img_default
   		 			var post_thumbnail_id = response.post_thumbnail_id

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-primary').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').data('post-id',frs_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal input#frs-title').val(frs_title);

   		 			jQuery('#frs-tonjoo-modal [media-upload-image]').attr('src',response.scr);
   		 			
   		 			jQuery('#frs-tonjoo-modal [media-upload-id]').attr('value',post_thumbnail_id);
   		 			
   		 			jQuery('#frs-tonjoo-modal [frs-remove-image]').attr('data-image-default',img_default);

   		 			jQuery('#frs-tonjoo-modal .floating-modal-button .button-danger').show();

   		 			/* set active */
   		 			jQuery('.frs-modal-backdrop').addClass('active')

   		 			jQuery('.frs-modal-container').show().addClass('active')

			 		if(typeof tinyMCE != 'undefined' && tinyMCE.get('frs-modal-content'))
			   	 		tinyMCE.get('frs-modal-content').setContent(response.content)
				    else
				    	jQuery('#frs-modal-content').val(response.content);
				    

   		 			frs_check_table_size()
   				}
   			})
	   	})

	});

	jQuery('.frs-modal-backdrop').click(function(){
		jQuery(this).removeClass('active');
		jQuery('.frs-modal-container .frs-table-left').html('');
		jQuery('.frs-modal-container').hide();	
		jQuery('.spinner').removeClass('active')
		frs_check_table_size()
	})
	
	jQuery('.frs-modal-container').on('click','[frs-modal-close-modal]',function(){
		jQuery('.frs-modal-backdrop').removeClass('active');
		jQuery('.frs-modal-container .frs-table-left').html('');
		jQuery('.frs-modal-container').hide();	
		jQuery('.spinner').removeClass('active')

	})

	/**
	 * Save 
	 */

	jQuery('.frs-modal-container').on('click','[frs-save-slider]',function(){


	 	if(jQuery('#frs-modal-form #frs-title').val() == "")
	 	{
	 		
	 		alert("Please fill the slider title");

	 		post_id = jQuery(this).data('post-id')
	 		
	 	}
	 	else
	 	{
	 		button = jQuery(this)

	 		ajax_button_spin(button)

	 		if(typeof tinyMCE != 'undefined' && tinyMCE.get('frs-modal-content')){
       	 		content =  tinyMCE.get('frs-modal-content').getContent()
		    }else{
		        content =  jQuery('#frs-modal-content').val();
		    }

			post_id = jQuery('[frs-save-slider]').data('post-id')

			var data =  jQuery('#frs-modal-form').serialize() + '&action=frs_save&content=' + content +"&post_id="+post_id+"&slide_type="+current_frs_slide_type;

			jQuery.post(ajaxurl, data,function(response){	   				
				if(response.success){	   					
					//insert row ke table, jquery sortable diulangi)

					// 
					var data = 'action=frs_render_row&post_id=' + response.id

					replace_id = response.id

					jQuery.post(ajaxurl, data,function(response){
						if(response.success){

							decoded = $("<div/>").html(response.row).text();

							// edit data / replace row
							if(!isNaN(post_id)){
								$("#list_item_"+replace_id ).replaceWith(decoded );
							}
							else{
								//New data , add row
								if(jQuery('#table-slide tr:last').length){
									jQuery('#table-slide tr:last').after(decoded)
								}
								else
									jQuery('#table-slide tbody').html(decoded)

								//re sort jquery table
								frs_resort_data_table()
							}
							frs_check_table_size()
							jQuery('.frs-modal-backdrop').removeClass('active');
							jQuery('.frs-modal-container .frs-table-left').html('');	
							jQuery('.frs-modal-container').hide();	

							ajax_button_spin_stop(button)

							frs_notice_updated()
						}
						else{
							frs_notice_error_updated()
						}
					})	   	

				}
			})
	 	}		
	})


	/*
	 * Media Uploader
	 */

	var custom_uploader
    var media_button
    
    $('.postbox-container').on('click','[mediauploadbutton]',function(e) {

        media_button = $(this)


 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('[frs-mediauploader]').find('[media-upload-id]').val(attachment.id);

            thumbnail = attachment.url
            
            jQuery('[frs-mediauploader]').find('[media-upload-image]').attr('src',thumbnail);

        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });

	jQuery('.postbox-container').on('click','[frs-remove-image]',function(){

		jQuery('[media-upload-id]').val('');

		jQuery('[media-upload-image]').attr('src',jQuery(this).data('image-default'));
	})	
})

function frs_check_table_size(){
	if(jQuery("table#table-slide tr").size()==0){
		jQuery('.no-slide').removeClass('hide')
	}
	else{
		jQuery('.no-slide').addClass('hide')
	}
}

function frs_resort_data_table(){

 	jQuery('table#table-slide tbody').sortable({
	    items: '.list_item',
	    opacity: 0.5,
	    cursor: 'pointer',
	    axis: 'y',
	    update: function() {
	        var ordr = jQuery(this).sortable('serialize') + '&action=frs_list_update_order';

	        jQuery.post(ajaxurl, ordr, function(response){
	           frs_notice_updated() 
	        });
	    },
	    helper: function(e, tr){
		    
		    var originals = tr.children();
		    var helper = tr.clone();
		    helper.children().each(function(index)
		    {
		      // Set helper cell sizes to match the original sizes
		      jQuery(this).width(originals.eq(index).width());
		
		    });
		    
		    return helper;
		}
	});
}

function ajax_button_spin(button){
	if(button.next('.spinner').size()!=0)
		button.next('.spinner').addClass('active')
	else
		button.siblings('.spinner').addClass('active')
}

function ajax_button_spin_stop(button){
	if(button.next('.spinner').size()!=0)
		button.next('.spinner').removeClass('active')
	else
		button.siblings('.spinner').removeClass('active')
}

function frs_notice_updated() {
	jQuery('.frs-notice-wrapper').addClass('active');
	jQuery('.frs-updated').hide();
	jQuery('.frs-updated').stop().show('slow');
}

function frs_notice_error_updated() {	
	jQuery('.frs-notice-wrapper').addClass('active');
	jQuery('.frs-updated-error').hide()
	jQuery('.frs-updated-error').stop().show('slow')
}