jQuery(document).ready(function() {
	//Coupon Page Print
	/*
	 * Initialise print preview plugin
	 */
	// Add link for print preview and intialise
	jQuery('a.print-preview').click(function() {  
		window.print();  
		return false;  
	}); 	
	
	//Toggle Comments in shortcode
	jQuery(".clipshort .commentbubble").click(function(){
	  jQuery(this).closest('.coupon-highlight').next().toggle("slow");
	});	
	
	//Displays No Comment & removes text decoration if comments are not present with coupon shortcode
	jQuery(".clipshort .commentbubble").each(function(){
	  if(jQuery(this).closest('.coupon-highlight').next().length > 0){
		  jQuery(this).text('View Comments');
	  }else {
		jQuery(this).text('No Comments').css({'cursor':'default','text-decoration':'none'});
	  }
	});

	//Toggle Comments on click when on coupon-single.php page
	jQuery(".commentbubble").click(function(){
	  jQuery('#comments').toggle('slow');
	});
	
	jQuery('.popup').click(function (event) {
		event.preventDefault();
		window.open(jQuery(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
	});

	//Responsive Google Map iFrame
	var calcHeight = function() {
		jQuery('#preview-frame').height(jQuery(window).height());
	}
	jQuery(document).ready(function() {
		calcHeight();
	}); 
	jQuery(window).resize(function() {
		calcHeight();
	}).load(function() {
		calcHeight();
	});

	//Removes the "View on Google Maps" header
	jQuery('.gm-style .default-card').hide();
	
	//get the data
	jQuery('.rate_widget').each(function(i) {
		var widget = this;
		var out_data = {
			widget_id : jQuery(widget).attr('id'),
			fetch: 1
		};
		jQuery.post(
			'../../rating/ratings.php',
			out_data,
			function(INFO) {
				jQuery(widget).data( 'fsr', INFO );
				set_votes(widget);
			},
			'json'
		);
	});	

	//Loads scripts if screen size is larger than Mobile (480px)
	if ( jQuery(window).width() > 480) { 
	
		//jQuery Tooltip
		jQuery( "#hide-option" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
		});
		
		//Opens Email Modal Window
		jQuery( "#email-coupon-message" ).dialog({
			modal: true,
			resizable: false,
			width: 'auto',
			
			//closeOnEscape: false,
			buttons: {
				Ok: function() {
					jQuery( this ).dialog( "close" );
				}
			}
		});	
		jQuery("#email-coupon-message").dialog( "option", "max-width", 500 );
		
		//Shows Hide close functions on modal window
		jQuery('.ui-dialog-buttonpane').hide();
		jQuery('.ui-dialog-titlebar-close').hide();	
		
		if(jQuery('.success').length > 0){
			jQuery('.ui-dialog-buttonpane').show();
			jQuery('.ui-dialog-buttonset button').click();
		}else if(jQuery('.error').length > 0){
			jQuery('.ui-dialog-buttonpane').hide();
			jQuery('.ui-dialog-titlebar-close').hide();
		}; 		
		
		//Changes width to 100% on ThickBox Popup
		jQuery('.thickbox').click(function(){
			if(jQuery('#TB_ajaxContent').length){
			  jQuery('#TB_ajaxContent').delay( 800 ).css({'width':'100%', 'padding':'0'});
			}
		});		
		
	}
   
});