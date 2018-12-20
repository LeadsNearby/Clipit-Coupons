<?php
/*******************************
  Admin Scripts
********************************/

add_action('admin_menu', 'clipit_settings_page');
function clipit_settings_page ()
{
	if ( count($_POST) > 0 && isset($_POST['clipit_settings']) )
	{
		$options = array (
			'beta_coupon_display',
			'customer_logo',
			'email_claim_address',
			'expired_coupon_text',
		    'rules_default',
			'fineprint_default',
			'border_color',
		    'content_bkgd_color', 
		    'highlight_bkgd_color',
			'featured_img_color',
			'featured_img_border_color',
			'title_color',
			'expiration_color',
			'description_color',
			'fineprint_color',
			'promo_text_color',
			'promo_bkgd_color',
                        'general_font_family',
			'title_font_family',
			'expiration_font_family',
			'description_font_family',
			'fineprint_font_family',
			'title_font_size',
			'expiration_font_size',
			'description_font_size',
			'fineprint_font_size',
			'button_font_family',
			'button_font_size',
			'coupon_banner_enable',
			'coupon_banner_image',
			'coupon_banner_height',
			'coupon_banner_width',
			'coupon_banner_position',
			'coupon_banner_link',
			'css_styling'
		);
		
		foreach ( $options as $opt )
		{
			delete_option ( 'clipit_'.$opt, $_POST[$opt] );
			add_option ( 'clipit_'.$opt, $_POST[$opt] );	
		}			
		 
	}
}
?>