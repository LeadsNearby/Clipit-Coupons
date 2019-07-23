<?php 
	/*
	Template Name: Coupons Single
	*/
get_header();
wp_enqueue_style('clipit-styles');
wp_enqueue_style('clipit-print-styles');
?>
	<div id="clipit" class="coupons coupons-single" itemscope itemtype ="http://schema.org/Offer">
		<?php
		$coupon_action = get_post_meta($post->ID, 'coupon_action', true);
		$coupon_type = get_post_meta($post->ID, 'coupon_type', true);
		$coupon_expiration = get_post_meta($post->ID, 'coupon_expiration', true);
		$coupon_display_expiration = get_post_meta($post->ID, 'coupon_display_expiration', true);
		$coupon_destination_url = get_post_meta($post->ID, 'coupon_destination_url', true);
		$coupon_fineprint = get_post_meta($post->ID, 'coupon_fineprint', true) ? get_post_meta($post->ID, 'coupon_fineprint', true) : get_option('clipit_fineprint_default', true);
		$coupon_shorts = get_post_meta($post->ID, 'coupon_shorts', true);
		$coupon_css_class = get_post_meta($post->ID, 'coupon_css_class', true);
		$social_content = get_the_content();
		
		//Calls email function
		// clipit_email();

		$unix_coupon_expiration = strtotime($coupon_expiration . ' 11:59 pm');

		if(class_exists('Avada')) {
			$logo_url = Avada()->settings->get('logo', 'url');
			$button_bg = Avada()->settings->get('button_gradient_top_color');
			$button_accent = Avada()->settings->get('button_accent_color');
		}

		$styles = array();
		if($button_bg !== '#a0ce4e') {
			$styles[] = '--button-bg: '.$button_bg.';';
			$styles[] = '--save-bkg: '.$button_bg.';';
		}

		if($button_accent !== '#ffffff') {
			$styles[] = '--button-accent: '.$button_accent.';';
		}

		if (have_posts()) : while (have_posts()) : the_post();
			$to_be_deprecated = array(
				'coupon_expiration' => $coupon_expiration,
				'button_bg' => $button_bg,
				'logo_url' => $logo_url,
				'coupon_fineprint' => $coupon_fineprint,
				'button_accent' => $button_accent,
				'coupon_dynamic_expiration' => $coupon_dynamic_expiration,
				'coupon_dynamic_expiration_plus_days' => $coupon_dynamic_expiration_plus_days
			);
			
			if(!empty($coupon_expiration) and $unix_coupon_expiration < current_time('timestamp')) {
				echo '<h3>Sorry, the coupon expired on '.$coupon_expiration.'</h3>';
			} else {
				ob_start(); ?>
				<div class="lnbCoupons lnbCoupons--singlePage" style="<?php echo implode($styles); ?>">
					<?php echo clipit_render_single_coupon($post, 'single-page', $to_be_deprecated); ?>
				</div>
				<?php echo ob_get_clean();
			}
		endwhile;
		endif;
get_footer();
