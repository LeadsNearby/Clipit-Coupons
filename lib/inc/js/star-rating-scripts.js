
jQuery(document).ready(function($)
	{



		$(document).on('mouseover', '.ratings_stars', function()
			{
				$(this).prevAll().andSelf().addClass('ratings_over');
        		$(this).nextAll().removeClass('ratings_vote'); 
				$(this).nextAll().removeClass('ratings_over'); 
				
				})

		$(document).on('mouseout', '.ratings_stars', function()
			{
        		
				$(this).nextAll().removeClass('ratings_over'); 
				
				})




		$(document).on('click', '.ratings_stars', function()
			{	
				
				var starvalue = jQuery(this).attr("starvalue");
				var data_id = jQuery(this).parent().attr("data_id");				
				
				jQuery(".star-rating"+data_id+" .total_votes").addClass("loading");
				jQuery(".star-rating"+data_id+" .total_votes").html("");

						jQuery.ajax(
							{
						type: 'POST',
						url:star_rating_ajax.star_rating_ajaxurl,
						data: {"action": "star_rating_record", "data_id":data_id , "starvalue":starvalue},
						success: function(data)
								{
									jQuery(".star-rating"+data_id+" .total_votes").html(data);	
									jQuery(".star-rating"+data_id+" .total_votes").removeClass("loading");	

								}
							});
					
				

			});	
			
	

	});	
