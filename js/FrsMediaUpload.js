jQuery(document).ready(function($){
     
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
            media_button.parent('[mediauploader]').find('[mediaUploadID]').val(attachment.id);

            thumbnail = attachment.url
            
            media_button.parent('[mediauploader]').find('[mediaUploadImage]').attr('src',thumbnail);

        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 
 
});