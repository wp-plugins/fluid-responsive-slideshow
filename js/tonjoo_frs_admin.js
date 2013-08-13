jQuery(document).ready(function($){

	$("#tonjoo-frs-is-fluid select").change(function(){
		value = $(this).attr('value')



		if(value=='true'){
			
			$("#max_image_width").hide('slow');
		}
		else{
			$("#max_image_width").show('slow');
		}
	})

	$("#tonjoo_show_navigation_arrow select").change(function(){
		value = $(this).attr('value')

	

		if(value=='true'){

			$(".tonjoo_nav_option").show('slow');
		}
		else{
			$(".tonjoo_nav_option").hide('slow');
		}
	})
})