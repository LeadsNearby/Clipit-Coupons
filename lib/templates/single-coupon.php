<?php 
	/*
	Template Name: Coupons Single
	*/
get_header(); ?>	
	<div id="clipit" class="coupons coupons-single" itemscope itemtype ="http://schema.org/Offer">
		<?php
		$coupon_promo_code = get_post_meta($post->ID, 'coupon_promo_code', true);
		$coupon_action = get_post_meta($post->ID, 'coupon_action', true);
		$coupon_type = get_post_meta($post->ID, 'coupon_type', true);
		$coupon_expiration = get_post_meta($post->ID, 'coupon_expiration', true);
		$coupon_dynamic_expiration = get_post_meta($post->ID, 'coupon_dynamic_expiration', true);
		$coupon_dynamic_expiration_plus_days = get_post_meta($post->ID, 'coupon_dynamic_expiration_plus_days', true);
		$coupon_display_expiration = get_post_meta($post->ID, 'coupon_display_expiration', true);
		$coupon_destination_url = get_post_meta($post->ID, 'coupon_destination_url', true);
		$coupon_feature = get_post_meta($post->ID, 'coupon_feature', true);
		$coupon_email = get_post_meta($post->ID, 'coupon_email', true);
		$coupon_views = get_post_meta($post->ID, 'coupon_views', true);
		$coupon_like = get_post_meta($post->ID, 'coupon_like', true);
		$coupon_name = get_post_meta($post->ID, 'coupon_name', true);
		$coupon_savings = get_post_meta($post->ID, 'coupon_savings', true);
		$coupon_value = get_post_meta($post->ID, 'coupon_value', true);
		$coupon_fineprint = get_post_meta($post->ID, 'coupon_fineprint', true);
		$coupon_promo_text = get_post_meta($post->ID, 'coupon_promo_text', true);
		$coupon_how_to = get_post_meta($post->ID, 'coupon_how_to', true);
		$coupon_rules = get_post_meta($post->ID, 'coupon_rules', true);
		$coupon_shorts = get_post_meta($post->ID, 'coupon_shorts', true);
		$coupon_social = get_post_meta($post->ID, 'coupon_social', true);
		$coupon_css_id = get_post_meta($post->ID, 'coupon_css_id', true);
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

		if (have_posts()) : while (have_posts()) : the_post();
		if(get_option('clipit_beta_coupon_display', true) == 'on') {
			if($unix_coupon_expiration < current_time('timestamp')) {
				echo '<h3>Sorry, the coupon expired on '.$coupon_expiration.', but our customers also viewed the following coupons.</h3>';
			} else {
				ob_start(); ?>
				<div class="lnbCoupons">
					<article class="lnbCoupon lnbCoupon--singlePage" style="--button-bg: <?php echo $button_bg; ?>; --button-accent: <?php echo $button_accent; ?>">
						<div class="lnbCoupon__content">
							<h2 class="lnbCoupon__title"><?php the_title(); ?></h2>
							<span class="lnbCoupon__description"><?php the_content() ;?></span>
							<span class="lnbCoupon__expiration">Expires: <?php echo $coupon_expiration; ?></span>
							<!-- <span class="lnbCoupon__finePrint"><?php /*echo $coupon_fineprint;*/ ?></span> -->
							<span class="lnbCoupon__finePrint">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nisi leo, vulputate et aliquam vitae, viverra nec erat. Maecenas scelerisque purus nisi, a vestibulum eros bibendum a.</span>
							<span class="lnbCoupon__image">
								<img src="<?php echo $logo_url; ?>" />
							</span>
						</div>
						<div class="lnbCoupon__actions">
							<a href="javascript:window.print()" class="lnbCoupon__button">Print Coupon</a>
						</div>
					</article>
				</div>
				<?php echo ob_get_clean();
			}
		} else {
			
		}

		//Sets Expiration
		$expirationtime = get_post_custom_values('coupon_expiration');
			if (is_array($expirationtime)) {
			$expirestring = implode($expirationtime);
		}
		$secondsbetween = strtotime($expirestring)-time();
			if ( $secondsbetween > 0 ) {
	
		//Convert to date
		$datestr = get_post_custom_values('coupon_expiration');
		
		$plusdate = strtotime($coupon_dynamic_expiration_plus_days);
		$dynamic_expirary_date = date('m/d/Y', $plusdate);

        //Calculate Discount
<<<<<<< HEAD
				
		$coupon_total = null;

		if (is_int($coupon_value) && is_int($coupon_savings)) {
			$coupon_total = $coupon_value - $coupon_savings;
		}

		// Randon Serial Number
		function sernum()
		{
			$template   = 'XX99-XX99-99XX-99XX-XXXX-99XX';
			$k = strlen($template);
			$sernum = '';
			for ($i=0; $i<$k; $i++)
			{
				switch($template[$i])
				{
					case 'X': $sernum .= chr(rand(65,90)); break;
					case '9': $sernum .= rand(0,9); break;
					case '-': $sernum .= '-';  break; 
				}
			}
			return $sernum;
		}
=======
		$coupon_total = $coupon_value - $coupon_savings;
>>>>>>> Single coup template mods
		
		$plusdate = strtotime($coupon_dynamic_expiration_plus_days);
		
		?>		
				<div class="post" id="post-<?php the_ID(); ?>">	
					<!-- To be displayed on print only -->
					<div class="page-body pg-promotions print-trigger printstyles">
						<?php if ($coupon_type == 'Upload') {

							if(has_post_thumbnail()) {                    
								$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
								 echo '<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
							}else {
								echo'<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
							} 
							
						} elseif ($coupon_type == 'Build' && get_option('clipit_beta_coupon_display', true) !== 'on') { ?>
						<div class="print-coupons">
							<?php
								if(class_exists('Avada')) {
									$logo_url = Avada()->settings->get('logo', 'url');
								} else {
									$logo_url = get_option('clipit_customer_logo');
								}
							?>
							<?php if($logo_url) { ?>
							<div class="logo"><img src="<?php echo $logo_url; ?>" /></div>
							<?php } ?>
							<div class="coupon-title"><?php the_title(); ?></div>
							<div class="coupon-details"><?php the_content(); ?></div>
							<div class="coupon-disclaimer">
							<?php if ($coupon_dynamic_expiration == 'on') { ?>
								<div itemprop="validThrough">Exp: <?php echo date('m/d/Y', $plusdate); ?></div>
							<?php } elseif ($coupon_dynamic_expiration == 'on' && $coupon_dynamic_expiration_plus_days == '+0 day') { ?>
								<div itemprop="validThrough">Expires Today!</div>
							<?php } else {?>
								<div itemprop="validThrough">Exp: <?php echo( $coupon_expiration ); ?></div>
							<?php } ?>	
							</div>
						</div>
						<?php } ?>
						<?php if (get_post_meta($post->ID, 'coupon_fineprint', true)) { ?>
						<h3>Fine Print</h3>
						<div class="single-fineprint"><?php echo wpautop( $coupon_fineprint, true ); ?></div>
						<?php }elseif (get_option('clipit_fineprint_default') <> ""){
							echo '<h3>Fine Print</h3>';
							echo '<div class="fineprint">'.wpautop(stripslashes(get_option('clipit_fineprint_default', true))).'</div>';
						}else { ?>
						<h3>Fine Print</h3>
						<div class="single-fineprint">Please call your service provider for more details.</div>	
						<?php } ?>						
					</div>
					<!-- End print only -->				
					<div class="grid" <?php if(get_option('clipit_beta_coupon_display', true) == 'on') { echo 'style="display: none"';} ?>>
						<div class="single-coupon-title" itemprop="itemOffered"><?php echo( $coupon_title ); ?></div> 
						<div class="right-border col-2-3">
						<?php if ($coupon_type == 'Upload') { ?>
							<?php if ($coupon_action == 'url') { ?>
								<a class="<?php if ($coupon_print_qrcode == 'on') { ?>bypassme<?php } ?>" href="<?php echo( $coupon_destination_url ); ?>">
									<?php	
									// Default, blog-size thumbnail
									if(has_post_thumbnail()) {                    
										$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
										 echo '<img title="'.the_title().'" alt="'.the_content().'" class="main-upload" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									} else {
										echo'<img title="'.the_title().'" alt="'.the_content().'" class="main-upload" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '"height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									}?>	
								</a>
								<?php } elseif ($coupon_action == 'print') { 

									// Default, blog-size thumbnail
									if(has_post_thumbnail()) {                    
										$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
										 echo '<img title="'.the_title().'" alt="'.the_content().'" class="main-upload" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									} else {
										echo'<img title="'.the_title().'" alt="'.the_content().'" class="main-upload" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '"height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									} 
								}
							} elseif ($coupon_type == 'Build') { ?>
							<div class="col-1-1 border-container">
								<?php if ($coupon_feature == 'on') { ?>
									<div class="featured-banner bypassme"></div>
								<?php } ?>
								<div class="<?php if ($coupon_print_qrcode == 'on') { ?>bypassme<?php } ?>">
									<?php	
									// Default, blog-size thumbnail
									if(has_post_thumbnail()) {                    
										$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
										 echo '<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									}else {
										echo'<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									}?>								
								</div>						
							</div>
							<?php } ?>
							<div class="single-coup-content">									
								<div class="single-description" itemprop="description"><?php the_content(); ?></div>
								<?php if (get_post_meta($post->ID, 'coupon_fineprint', true)) { ?>
								<hr />
								<div class="single-fineprint"><?php echo wpautop( $coupon_fineprint, true ); ?></div>
								<?php }elseif (get_option('clipit_fineprint_default') <> ""){
									echo '<hr />';
									echo '<div class="fineprint">'.wpautop(stripslashes(get_option('clipit_fineprint_default', true))).'</div>';
								}else { ?>
								<hr />
								<div class="single-fineprint">Please call your service provider for more details.</div>	
								<?php } ?>
							</div>

							<?php if( has_term( '', 'locations' ) ) { ?> 
							<div class="addinfo redeem bypassme">
							<span class="icons" id="redeem-icon"></span>
							<h3>Redeem At</h3>
							<?php
							$args = array(
								'orderby' => 'name',
								'order' => 'ASC',
							);
							$categories = wp_get_object_terms( $id, 'locations', $args );
							foreach($categories as $category) {
								$term_meta = get_option( "taxonomy_$category->term_id" );
								$clipit_map_address = str_replace(' ', '+', $term_meta['custom_street_address_meta']);
								echo '<div class="clipit-locale">';
								echo '<div class="col-1-3">';
								echo '<p><strong>' . $category->name . '</strong></p> ';
								echo '<address>';
								echo '<div class="clipit-address">' . $term_meta['custom_street_address_meta'] . '</div>';
								echo '<span>' . $term_meta['custom_city_address_meta'] . '</span>, '; 
								echo '<span>' . $term_meta['custom_state_address_meta'] . '</span> ';  
								echo '<span>' . $term_meta['custom_zip_address_meta']. '</span>';
								echo '</address>';
								echo '<div><a style="color:#0185c6" target="_blank" href="https://maps.google.com/maps?f=d&amp;daddr='.$clipit_map_address,'+',$term_meta['custom_city_address_meta'],'+',$term_meta['custom_state_address_meta'],'+',$term_meta['custom_zip_address_meta'].'">Get Directions</a></div>';								
								echo '<p>' . $term_meta['custom_term_meta'] . '</p>';
								echo '<p>' . wpautop($category->description) . '</p>';
								echo '</div>';
								echo '<div class="map col-2-3 last" style="margin-bottom:20px">';
								echo '<iframe id="map-preview-frame" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/place?q='.$clipit_map_address,'+',$term_meta['custom_city_address_meta'],'+',$term_meta['custom_state_address_meta'],'+',$term_meta['custom_zip_address_meta'].'&key=AIzaSyBj-ikeaUhEL5aIbgDebWahSCeFdOEcAKc" style="margin-top: 0px; min-height:175px; height:100%; width: 100%; overflow: hidden;"></iframe>';
								echo '</div>';
								echo '<div class="clear"></div>';
								echo '</div>';
							}
							?>
							</div>
							<?php } ?>
							<div id="min-info" class="bypassme">
								<?php if ($coupon_display_expiration == 'on') { ?>
									<?php if ($coupon_dynamic_expiration == 'on') { ?>
									<div class="col-1-3 no-margin">
										<span class="icons" id="expiration-icon"></span>
										<div class="icons-small" itemprop="validThrough">Exp: <?php echo $dynamic_expirary_date ?></div>
									</div>
									<?php } elseif ($coupon_dynamic_expiration == 'on' && $coupon_dynamic_expiration_plus_days == '+0 day') { ?>
									<div class="col-1-3 no-margin">
										<span class="icons" id="expiration-icon"></span>
										<div class="icons-small" itemprop="validThrough">Expires Today!</div>
									</div>
									<?php } else {?>
									<div class="col-1-3 no-margin">
										<span class="icons" id="expiration-icon"></span>
										<div class="icons-small" itemprop="validThrough">Exp: <?php echo( $coupon_expiration ); ?></div>
									</div>
									<?php } ?>
								<?php } ?>
								<?php if ($coupon_views == 'on') { ?>
								<div class="col-1-3 no-margin">
									<span class="icons" id="views-icon"></span>
									<div class="icons-small"><?php echo getCoupontViews(get_the_ID()); ?></div>
								</div>
								<?php } ?>
								<div class="col-1-3 no-margin">
								<span class="icons" id="pin-icon"></span>
								<div class="icons-small" itemprop="validFrom">Posted: <?php the_date('m/d/Y'); ?></div>
								</div>
							</div>							
						</div><!-- .right-border -->
						
						<div class="left-border col-1-3">
						<div class="col-1-1">
								<div style="margin-bottom:0">
									<?php if ($coupon_action == 'url') { ?>
										<div class="couponbutton">
											<a class="coupon_btn_click" target="_blank" href="<?php echo( $coupon_destination_url ); ?>" itemprop="potentialAction">View Deal</a>
										</div>										
									<?php } elseif ($coupon_action == 'print') { ?>
										<div id="editor"></div>
										<div class="countable_link couponbutton print-coupon">
											<a class="print-preview coupon_btn_click" href="javascript:void(0)">Print Coupon</a>
										</div>
									<?php } elseif ($coupon_action == 'promo') { ?>
										<div class="clicktoreveal">											
											<a class="code countable_link coupon_btn_click" style="text-align: center; text-decoration:none;" href="javascript:void(0)" itemprop="potentialAction"><?php echo( $coupon_promo_code ); ?></a>
										</div>									
									<?php } elseif ($coupon_action == 'peel') { ?>
									<?php add_thickbox(); ?>
										<div class="clicktoreveal">
											<a href="#TB_inline?width=706&height=661&inlineId=promo-code-two" class="thickbox countable_link coupon_btn_click" itemprop="potentialAction">Click to Reveal</a>
										</div>
										<div id="promo-code-two" style="display:none;">
												<p class="promo-text entryinfo">You selected the following coupon:</p>
												<!-- Start Coupon Copy -->	
												<div id="clipit-style-two" class="col-1-1 border-container">
												<?php if ($coupon_type == 'Build') { ?>
													<div class="single-coup-container">
														<div class="col-1-3 single-coup-img" style="float:left; width:33%;">
															<?php	
															// Default, blog-size thumbnail
															if(has_post_thumbnail()) {                    
																$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
																 echo '<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="max-width:200px; height:auto; width:100%; margin:0; display:block;" />';
															}else {
																echo'<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:200px; height:auto; width:100%; margin:0; display:block;" />';
															}?>								
														</div>
														<div class="col-2-3 last single-coup-content" style="float:left; width:66%;">
															<div class="coupon-title" style="font-size:30px" itemprop="itemOffered"><?php the_title(); ?></div>
															<p class="description" itemprop="description"><?php the_content(); ?></p>
														</div>
														<div class="clear"></div>
													</div>	
												<?php } ?>	
												</div>											
												<!-- End Coupon Copy -->
												
												<?php if (get_post_meta($post->ID, 'coupon_promo_text', true)) { ?>
												<p class="promo-text"><?php echo( $coupon_promo_text ); ?></p>
												<?php } else { ?>
												<p class="promo-text">Copy this code, make your purchase and then enter it at the final checkout stage of your purchase.</p>	
												<?php } ?>
												
												<div class="popup-code" style="text-align: center;"><?php echo( $coupon_promo_code ); ?></div>
												<div class="popup-expirydate">Expires on:
													<?php if ($coupon_dynamic_expiration == 'on') { ?>
														<span class="exptext" itemprop="validThrough"><?php echo $dynamic_expirary_date ?></span>
													<?php } elseif ($coupon_dynamic_expiration == 'on' && $coupon_dynamic_expiration_plus_days == '+0 day') { ?>
														<span class="exptext" itemprop="validThrough">Expires Today!</span>
													<?php } else {?>
														<span class="exptext" itemprop="validThrough"><?php echo( $coupon_expiration ); ?></span>
													<?php } ?>
												</div>
												<div class="clear"></div>
											</div><!-- #promo-code -->												
											</div><!-- Action buttons -->									
									<?php } ?>
									<div class="deal-discount">
										<table>
											<tbody>
												<tr>
													<?php if (get_post_meta($post->ID, 'coupon_value', true)) { ?>
													<th>Value</th>
													<?php } ?>
													<?php if (get_post_meta($post->ID, 'coupon_savings', true)) { ?>
													<th>Discount</th>
													<?php } ?>
													<?php if (get_post_meta($post->ID, 'coupon_value', true) &&  get_post_meta($post->ID, 'coupon_savings', true)) { ?>
													<th>You Save</th>
													<?php } ?>
												</tr>
												<tr id="discount-data">
												<?php if (get_post_meta($post->ID, 'coupon_value', true)) { ?>
													<td id="discount-value">$<?php echo( $coupon_value ); ?></td>
												<?php } ?>
												<?php if (get_post_meta($post->ID, 'coupon_savings', true)) { ?>	
													<td id="discount-percent">$<?php echo( $coupon_savings ); ?></td>
												<?php } ?>
												<?php if (get_post_meta($post->ID, 'coupon_value', true) &&  get_post_meta($post->ID, 'coupon_savings', true)) { ?>	
													<td id="discount-you-save">$<?php echo( $coupon_total ); ?></td>
												<?php } ?>	
												</tr>
											</tbody>
										</table>
									</div><!-- .deal-discount -->
									<?php if ($coupon_display_expiration == 'on' && $coupon_dynamic_expiration == 'off') { ?>
										<div class="expirydate" style="line-height: 20px; padding: 5px 0 20px;">
											<h3>Limited Time Only!</h3>
											<div class="expirydate-date dyanmic-off">
												<span itemprop="validThrough" class="wlt_shortcodes_expiry_date"></span>	
											</div>
											<div class="clear"></div>
										</div><!-- .expirydate-coupon -->
										<?php } elseif ($coupon_display_expiration == 'on' && $coupon_dynamic_expiration == 'on') { ?>
										<div class="expirydate" style="line-height: 20px; padding: 5px 0 20px;">
											<div class="expirydate-date dyanmic-on">
												<?php if ($coupon_dynamic_expiration_plus_days == '+0 day') { ?>
												<h3 class="wlt_shortcodes_expiry_date_text" itemprop="validThrough">Expires Today!</h3>
												<?php } else { ?>
												<h3>Limited Time Only!</h3>
												<span itemprop="validThrough" class="wlt_shortcodes_dynamic_date"></span>
												<?php } ?>
											</div>
											<div class="clear"></div>
										</div><!-- .expirydate-coupon --> 
										<?php } ?>	
								<?php if ($coupon_social == 'on') { ?>
								<div class="social-icons" style="margin-top:20px">
									<h3 class="no-padding">Share this Coupon!</h3>
									<ul id="social-tabs">
										<li>
											<a class="social-coupons coupon-facebook popup" title="Facebook It" href="http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo get_permalink(); ?>&amp;p[images][0]=<?php $image_src[0] ?>&amp;p[title]=<?php the_title(); ?>&amp;p[summary]=<?php echo strip_tags( $social_content ); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-twitter popup" title="Tweet It" href="http://twitter.com/share?text=<?php the_title(); ?>&amp;url=<?php echo get_permalink(); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-google popup" title="Google It" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-linkedin popup" title="Add to LinkedIn" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;summary=<?php echo strip_tags( $social_content ); ?>&amp;source=<?php get_bloginfo('name'); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-pinterest popup" title="Pin It!" href="https://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php $image_src[0] ?>&description=<?php echo strip_tags( $social_content ); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-stumbleupon popup" title="Add to Stumbleupon" href="http://www.stumbleupon.com/submit?url=<?php echo get_permalink(); ?>&title=<?php the_title(); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-reddit popup" title="Add to Reddit" href="http://reddit.com/submit?url=<?php echo get_permalink(); ?>&title=<?php the_title(); ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-digg popup" title="Digg It" href="http://digg.com/submit?url=<?php echo get_permalink(); ?>&title=<?php the_title; ?>"></a>
										</li>
										<li>
											<a class="social-coupons coupon-email popup" title="Email A Friend" href="mailto:?subject=<?php bloginfo('name'); ?>: <?php the_title(); ?>&amp;body=Check out this coupon I just downloaded: <?php the_permalink() ?>"></a>
										</li>
										<div class="clear"></div>
									</ul>
									<div class="clear"></div>
								</div>
								<?php } ?>
							<div class="howto addinfo bypassme">
							<span class="icons" id="howto-icon"></span>
							<h3>How To Use</h3>
							<div class="clear"></div>
							<?php
								if ( get_post_meta($post->ID, 'coupon_how_to', true) ) {
									// Get the variable from the database as a string
									$how_to = get_post_meta($post->ID, 'coupon_how_to', true );
									// Break the string up by using the line breaks (carriage returns)
									$how_to = explode( "\n", $how_to );
									// Start the unordered list tag
									echo '<ol>';
									// Loop through each ingredient since it's now an array thanks to the explode() function
									foreach( $how_to as $how_tos ) {
										// Add the list item open and close tag around each array element
										echo '<li>' . $how_tos . '</li>';
									}
									// Once the loop finishes, close out the unordered list tag
									echo '</ol>';
								} else {?>
									<p>Please call your service provider for more details.</p>
								<?php }
							?>
							<?php if (get_post_meta($post->ID, 'coupon_shorts', true)) { ?>
							<h3 class="bypassme contactus" data-html2canvas-ignore>Contact Us</h3>						
							<div class="bypassme shorts" data-html2canvas-ignore>
								<?php echo apply_filters('the_content', get_post_meta($post->ID, 'coupon_shorts', true)); ?>
							</div>
							<?php } ?>
							</div>
							<div class="fine addinfo bypassme">
								<span class="icons" id="fine-icon"></span>
								<h3>The Fine Print</h3>
								<div class="clear"></div>
								<?php if (get_post_meta($post->ID, 'coupon_fineprint', true)) { ?>
								<p><?php echo wpautop( $coupon_fineprint ); ?></p>
								<?php }elseif (get_option('clipit_fineprint_default') <> ""){
									echo wpautop(stripslashes(get_option('clipit_fineprint_default')));
								}else { ?>
								<p>Please call your service provider for more details.</p>
								<?php } ?>
							</div>
							<div class="last rules addinfo">
							    <?php if (get_post_meta($post->ID, 'coupon_rules', true) || get_option('clipit_rules_default') <> "") { ?>
								<span class="icons bypassme" id="rules-icon"></span>
								<h3 class="bypassme">The Rules</h3>
								<div class="clear"></div>
								<?php if (get_post_meta($post->ID, 'coupon_rules', true)) { ?>
								<p><?php echo wpautop( $coupon_rules ); ?></p>
								<?php }elseif (get_option('clipit_rules_default') <> ""){
									echo wpautop(stripslashes(get_option('clipit_rules_default')));
								}else { ?>
								<p>Please call your service provider for more details.</p>
								<?php } ?>
								<?php } ?>						
							</div>
						</div><!-- .col-1-1 -->
						</div><!-- .left-border -->
					</div><!-- .grid -->
					<div class="clear"></div>				
				</div><!-- .post -->
				
				<?php
				global $jal_db_version;
				$clipit_db_version = '1.0';
				
				global $wpdb;
				global $clipit_db_version;
				
				// creates clipit_email_table in database if not exists
				$table = $wpdb->prefix . "clipit_email_table"; 
				$charset_collate = $wpdb->get_charset_collate();
				$sql = "CREATE TABLE IF NOT EXISTS $table (
					`id` mediumint(9) NOT NULL AUTO_INCREMENT,
					`time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					`name` text NOT NULL,
					`email` text NOT NULL,
					`phone` text NOT NULL,
				UNIQUE (`id`)
				) $charset_collate;";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
				
				if ($coupon_email == 'on') { ?>				
				<div id="email-coupon-message" title="Claim Your Coupon Now!" class="bypassme">
					<?php echo $callback; ?>
					<form id="email-claim" action="<?php the_permalink(); ?>" method="post">
						<label for="message_name">Name<span class="required">*</span></label>
						<input type="text" autocomplete="off" name="message_name" placeholder="John Smith" value="<?php echo esc_attr($_POST['message_name']); ?>"><br />
						<label for="message_email">Email Address<span class="required">*</span></label>
						<input type="text" autocomplete="off" name="message_email" placeholder="johnsmith@email.com" value="<?php echo esc_attr($_POST['message_email']); ?>"><br />
						<label for="message_email">Phone Number</label>
						<input type="tel" pattern="\d{3}[\-]\d{3}[\-]\d{4}" autocomplete="off" name="message_phone" placeholder="919-555-1234" value="<?php echo esc_attr($_POST['message_phone']); ?>"><br />
						<label for="message_human">Human Verification<span class="required">*</span></label>
						<input type="text" autocomplete="off" name="message_human" style="width: 30%;"> <span style="padding:8px 0; width:30%;">+ 3 = 5</span><br />
						<div class="clear"></div>
						<input type="hidden" name="submitted" value="1">
						<input type="submit" name="submit_form" value="Claim Your Coupon Now">
					</form>
				</div>
				<?php } 
				// does the inserting, in case the form is filled and submitted
				if($_POST["submit_form"] != '' && $_POST["message_name"] != '') {
					$table = $wpdb->prefix."clipit_email_table";
					$name = strip_tags($_POST["message_name"], "");
					$email = strip_tags($_POST["message_email"], "");
					$phone = strip_tags($_POST["message_phone"], "");
					$wpdb->insert( 
						$table, 
						array( 
							'time' => current_time( 'mysql' ),
							'name' => $name,
							'email' => $email,
							'phone' => $phone,
						)
					);
				}			
				?>	
			
			<!-- Related posts block -->
                        <hr />
			<h1 class="bypassme" id="recent">Related Coupons</h1>
			<div id="related" class="group grid bypassme">
			<ul class="group">			
			<?php
			// You might need to use wp_reset_query(); 
			// here if you have another query before this one

			global $post;

			// The query arguments
			$args = array(
				'posts_per_page' => 4,
				'order' => 'DESC',
				'orderby' => 'ID',
				'post_type' => 'coupon',
				'post__not_in' => array( $post->ID ),
				'meta_query'  => array(
		            array(
						'meta_key' => 'coupon_expiration',
						'meta_value' => current_time( 'F j, Y' ),
						'meta_compare' => '>='
		            )
		        )
			);

			// Create the related query
			$custom_posts = new WP_Query( $args );
		    if ($custom_posts->have_posts()) : while ($custom_posts->have_posts()) : $custom_posts->the_post();
			
		        $coupon_savings = get_post_meta($post->ID, 'coupon_savings', true);
		        $coupon_value = get_post_meta($post->ID, 'coupon_value', true);
				$expirationtime = get_post_meta($post->ID, 'coupon_expiration', true);

			?>
					<li class="col-1-4">
						<a href="<?php the_permalink() ?>" title="<?php the_title() ?>" alt="<?php the_title() ?>" rel="bookmark">
							<article>
								<?php if(has_post_thumbnail()) {                    
									$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
									 echo '<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="width:100%; margin:0 auto; display:block;" />';
								}else {
									echo'<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
								} ?>
				                <div class="recent-container">
				                	<h1 class="entry-title"><?php the_title(); ?></h1>
									<div class="theExcerpt"><?php wp_trim_words( the_content(), $num_words = 55, $more = null ); ?></div>
				                	<div class="expiry-date">Expires on: <?php echo( $expirationtime ); ?></div>
				                	<?php if (get_post_meta($post->ID, 'coupon_value', true) &&  get_post_meta($post->ID, 'coupon_savings', true)) { ?>
				                	<div data-pingdom-id="deal-price" class="cui-price ">
					                    <s class="cui-price-original">$<?php echo( $coupon_value ); ?></s>
					                    <span class="cui-price-discount ">$<?php echo( $coupon_savings ); ?></span>
					                </div>
				                <?php } ?>
				                </div>
							</article>
						</a>
					</li>
			<?php 
				endwhile; endif;
				wp_reset_query();
			?>
				<div class="clear"></div>
				</ul><!-- .group -->
			</div><!-- #related -->		
			
			<?php }	elseif ( $secondsbetween <= 0 ) { ?>
				<div>
				<?php if (get_option('clipit_expired_coupon_text') <> ""){ 
					echo wpautop(stripslashes(get_option('clipit_expired_coupon_text')));
				}else { ?>
					
					<!-- Related posts block -->
					<div id="related" class="group grid bypassme">
					<hr />
					<ul class="group">			
					<?php
					// You might need to use wp_reset_query(); 
					// here if you have another query before this one

					global $post;

					// The query arguments
					$args = array(
						'posts_per_page' => 4,
						'order' => 'DESC',
						'orderby' => 'ID',
						'post_type' => 'coupon',
						'post__not_in' => array( $post->ID )
					);

					// Create the related query
					$custom_posts = new WP_Query( $args );
					if ($custom_posts->have_posts()) : while ($custom_posts->have_posts()) : $custom_posts->the_post();
					
					$coupon_expiration = get_post_meta($post->ID, 'coupon_expiration', true);
						$coupon_savings = get_post_meta($post->ID, 'coupon_savings', true);
						$coupon_value = get_post_meta($post->ID, 'coupon_value', true); 
					?>
							<li class="col-1-4">
							<a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark">
								<article>
									<?php if(has_post_thumbnail()) {                    
										$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
										 echo '<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="width:100%; margin:0 auto; display:block;" />';
									}else {
										echo'<img title="'.the_title().'" alt="'.the_content().'" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0 auto 20px; display:block;" />';
									} ?>
						<div class="recent-container">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="expiry-date">Expires on: <?php echo( $coupon_expiration ); ?></div>
						<?php if (get_post_meta($post->ID, 'coupon_value', true) &&  get_post_meta($post->ID, 'coupon_savings', true)) { ?>
						<div data-pingdom-id="deal-price" class="cui-price ">
							<s class="cui-price-original">$<?php echo( $coupon_value ); ?></s>
							<span class="cui-price-discount ">$<?php echo( $coupon_savings ); ?></span>
						</div>
						<?php } ?>
						</div>
								</article>
							</a>
							</li>
					<?php
						 endwhile; endif;
						 wp_reset_query();
					?>
						<div class="clear"></div>
						</ul><!-- .group -->
					</div><!-- #related -->	
					
				<?php } ?>
				</div>
			<?php } ?>
			<?php endwhile; endif; // end of the loop. ?>	
	</div><!-- #clipit -->
	</div><!-- #main -->
	<?php if ( is_active_sidebar( 'clipit-single-sidebar' ) ) : ?>
	<div id="clipit-secondary" class="clipit-widget-area col-1-4 last bypassme" role="complementary">
		<?php dynamic_sidebar( 'clipit-single-sidebar' ); ?>
	</div><!-- #secondary -->
	<?php endif; ?>	
<?php get_footer(); ?>
