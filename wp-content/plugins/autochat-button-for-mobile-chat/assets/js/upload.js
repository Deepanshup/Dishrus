jQuery(function($){
	/*
	 * Select/Upload image(s) event
	 */
	jQuery('.tpw_upload_image_button').on('click', function(e){
		
		e.preventDefault();
 
    		var button = jQuery(this),
    		    custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false 
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			//jQuery(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
			jQuery(".tpw_img_stng").attr("src", attachment.url);
			jQuery(".tpw_upload_image").attr("value", attachment.url);
		})
		.open();
	});
 
	/*
	 * Remove image event
	 */
	jQuery('body').on('click', '.tpw_remove_image_button', function(){
		jQuery(this).hide().prev().val('').prev().addClass('button').html('Upload image');
		return false;
	});
 
});
