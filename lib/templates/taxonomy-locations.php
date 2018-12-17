<?php
/*
Template Name: Coupons Taxonomy
 */
get_header();
//Starts the loop
// global $wp_query;

$args = array(
    'post_type' => 'coupon',
    'meta_key' => 'coupon_expiration',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'coupon_expiration',
            'value' => date('F d, Y'),
            'compare' => '>=',
        ),
    ),
);

$query = new WP_Query($args);

if ($query->have_posts()) {

    if (is_active_sidebar('clipit-locations-sidebar')) {
        $fw = true;
    }?>

	<div id="clipit" class="coupons<?php echo $fw ? 'col-3-4' : '' ?>" itemscope itemtype ="http://schema.org/Offer">

    <?php while ($query->have_posts()): $query->the_post();

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
        $coupon_button_text = get_post_meta($post->ID, 'coupon_button_text', true);
        $coupon_how_to = get_post_meta($post->ID, 'coupon_how_to', true);
        $coupon_rules = get_post_meta($post->ID, 'coupon_rules', true);
        $coupon_shorts = get_post_meta($post->ID, 'coupon_shorts', true);
        $coupon_social = get_post_meta($post->ID, 'coupon_social', true);
        $coupon_print_qrcode = get_post_meta($post->ID, 'coupon_print_qrcode', true);
        $coupon_css_id = get_post_meta($post->ID, 'coupon_css_id', true);
        $coupon_css_class = get_post_meta($post->ID, 'coupon_css_class', true);
        $plusdate = strtotime($coupon_dynamic_expiration_plus_days);
        $dynamic_expirary_date = date('m/d/Y', $plusdate);

        //Sets Expiration
        $expirationtime = get_post_custom_values('coupon_expiration');
        if (is_array($expirationtime)) {
            $expirestring = implode($expirationtime);
        }
        $secondsbetween = strtotime($expirestring) - time();
        if ($secondsbetween > 0) {
            ?>
																					<div class="post <?php echo ($coupon_css_class); ?>" id="post-<?php the_ID();?> <?php echo ($coupon_css_id); ?>">
																						<div class="grid">
																							<?php if ($coupon_type == 'Upload') {?>
																								<div id="clipit-style-one" class="col-1-1 border-container">
																								<?php if ($coupon_action == 'url') {?>
																									<a href="<?php echo ($coupon_destination_url); ?>">
																										<?php
    // Default, blog-size thumbnail
                if (has_post_thumbnail()) {
                    $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" class="main-upload" id="image-slide" itemprop="image" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                } else {
                    echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" class="main-upload" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0; display:block;" />';
                }?>
																									</a>
																								<?php } elseif ($coupon_action == 'print') {?>
									<div class="countable_link">
										<a href="<?php the_permalink();?>">
											<?php
// Default, blog-size thumbnail
            if (has_post_thumbnail()) {
                $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" class="main-upload" id="image-slide" itemprop="image" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
            } else {
                echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" class="main-upload" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0; display:block;" />';
            }?>
										</a>
									</div>
							<?php }?>
							</div>
						<?php } elseif ($coupon_type == 'Build') {?>
							<div id="clipit-style-two" class="col-1-1 border-container">
								<div class="single-coup-container">
								<?php if ($coupon_feature == 'on') {?>
									<div class="featured-banner"></div>
								<?php }?>
									<div class="col-1-3 single-coup-img">
										<?php
// Default, blog-size thumbnail
            if (has_post_thumbnail()) {
                $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" id="image-slide" itemprop="image" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
            } else {
                echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="height:auto; width:100%; margin:0; display:block;" />';
            }?>
									</div><!-- .col-1-3 .single-coup-img -->
									<div class="col-2-3 last single-coup-content">
										<div class="coupon-title" itemprop="itemOffered">
											<?php the_title();?>
										</div>
										<p class="description" itemprop="description">
											<?php the_content($coupon_description, $num_words = 55, $more = null);?>
										</p>
										<?php if (get_post_meta($post->ID, 'coupon_fineprint', true)) {?>
        								<hr />
        								<div class="single-fineprint"><?php echo wpautop($coupon_fineprint, true); ?></div>
        								<?php } elseif (get_option('clipit_fineprint_default') != "") {
                echo '<hr />';
                echo '<div class="fineprint">' . wpautop(stripslashes(get_option('clipit_fineprint_default', true))) . '</div>';
            } else {?>
        								<hr />
        								<div class="single-fineprint">Please call your service provider for more details.</div>
        								<?php }?>
									</div><!-- .col-2-3 .single-coup-content -->
									<div class="clear"></div>
								</div><!-- .single-coup-container -->
								<div class="coupon-highlight">
									<div class="col-3-4">
										<span class="div">
											<?php if ($coupon_dynamic_expiration == 'on') {?>
												<div class="expiration" itemprop="availabilityEnds"><?php echo date('m/d/Y', $plusdate); ?></div>
											<?php } elseif ($coupon_dynamic_expiration == 'on' && $coupon_dynamic_expiration_plus_days == '+0 day') {?>
												<div itemprop="availabilityEnds">Expires Today!</div>
											<?php } else {?>
												<div class="expiration" itemprop="availabilityEnds"><?php echo ($coupon_expiration); ?></div>
											<?php }?>
										</span>
										<span class="div">
											<?php if ($coupon_views == 'on') {?>
												<div class="views"><?php echo getCoupontViews(get_the_ID()); ?></div>
											<?php }?>
										</span>
									</div><!-- .col-3-4 -->
									<div class="col-1-4 last action-buttons" style="margin-bottom:0">
										<?php if ($coupon_action == 'url') {?>
											<div class="couponbutton">
										<a target="_blank" href="<?php echo ($coupon_destination_url); ?>" itemprop="potentialAction"><?php if (get_post_meta($post->ID, 'coupon_button_text', true)) {echo ($coupon_button_text);} else {?>View Deal<?php }?></a>
											</div>
										<?php } elseif ($coupon_action == 'print') {?>
											<div id="editor"></div>
											<div class="countable_link couponbutton">
										<a href="<?php the_permalink();?>"><?php if (get_post_meta($post->ID, 'coupon_button_text', true)) {echo ($coupon_button_text);} else {?>Print Coupon<?php }?></a>
											</div>
										<?php } elseif ($coupon_action == 'promo') {?>
											<div class="clicktoreveal">
											<a class="code countable_link" style="text-align: center; text-decoration:none;" href="javascript:void(0)" itemprop="potentialAction"><?php echo ($coupon_promo_code); ?></a>
											</div>
										<?php } elseif ($coupon_action == 'peel') {?>
										<?php add_thickbox();?>
											<div class="clicktoreveal">
												<a href="#TB_inline?width=706&height=661&inlineId=<?php the_ID();?>" class="thickbox countable_link" itemprop="potentialAction">Click to Reveal</a>
											</div>
											<div id="<?php the_ID();?>" class="pt" style="display:none;">
												<p class="promo-text entryinfo">You selected the following coupon:</p>
												<!-- Start Coupon Copy -->
												<div id="clipit-style-two" class="col-1-1 border-container">
												<?php if ($coupon_type == 'build') {?>
													<div class="single-coup-container">
														<div class="col-1-3 single-coup-img">
															<?php
// Default, blog-size thumbnail
                if (has_post_thumbnail()) {
                    $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" id="image-slide" itemprop="image" src="' . $image_src[0] . '" style="max-width:200px; height:auto; width:100%; margin:0; display:block;" />';
                } else {
                    echo '<img title="' . get_the_title() . '" alt="' . get_the_content() . '" id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:200px; height:auto; width:100%; margin:0; display:block;" />';
                }?>
														</div><!-- Copy .col-1-3 -->
														<div class="col-2-3 last single-coup-content">
															<div class="coupon-title" itemprop="itemOffered"><?php the_title();?></div>
															<p class="description" itemprop="description"><?php the_content();?></p>
														</div><!-- Copy .col-2-3 -->
														<div class="clear"></div>
													</div><!-- Copy .single-coup-container -->
												<?php }?>
												</div><!-- Copy #clipit-style-two -->
												<!-- End Coupon Copy -->

												<?php if (get_post_meta($post->ID, 'coupon_promo_text', true)) {?>
												<p class="promo-text"><?php echo ($coupon_promo_text); ?></p>
												<?php } else {?>
												<p class="promo-text">Copy this code, make your purchase and then enter it at the final checkout stage of your purchase.</p>
												<?php }?>

												<div class="popup-code" style="text-align: center;">
													<?php echo ($coupon_promo_code); ?>
												</div>
												<div class="popup-expirydate">Expires on:
													<?php if ($coupon_dynamic_expiration == 'on') {?>
														<span class="exptext" itemprop="availabilityEnds"><?php echo date('m/d/Y', $plusdate); ?></span>
													<?php } elseif ($coupon_dynamic_expiration == 'on' && $coupon_dynamic_expiration_plus_days == '+0 day') {?>
														<span class="exptext" itemprop="availabilityEnds">Expires Today!</span>
													<?php } else {?>
														<span class="exptext" itemprop="availabilityEnds">
															<?php echo ($coupon_expiration); ?>
														</span>
													<?php }?>
												</div>
												<div class="clear"></div>
											</div><!-- .pt -->
											<?php }?>
									</div><!-- .col-1-4 -->
									<div class="clear"></div>
								</div><!-- .coupon-highlight -->
							</div><!-- #clipit-style-two -->
						<?php }?>

						<div class="clear"></div>
					</div><!-- grid -->
				</div><!-- post -->

				<?php }
    endwhile;

    echo '</div> <!-- #clipit -->';
} else {
    echo '<p>There are no current coupons</p>';
}?>

	<?php if (is_active_sidebar('clipit-locations-sidebar')): ?>
		<div id="clipit-secondary" class="clipit-widget-area col-1-4 last" role="complementary">
			<?php
$args = array(
    'orderby' => 'name',
    'order' => 'ASC',
);
$categories = wp_get_object_terms($id, 'locations', $args);
foreach ($categories as $category) {
    $term_meta = get_option("taxonomy_$category->term_id");
    $clipit_map_address = str_replace(' ', '+', $term_meta['custom_street_address_meta']);
    echo '<div class="clipit-locale">';
    echo '<div class="col-1-3">';
    echo '<p><strong>' . $category->name . '</strong></p> ';
    echo '<address>';
    echo '<div class="clipit-address">' . $term_meta['custom_street_address_meta'] . '</div>';
    echo '<span>' . $term_meta['custom_city_address_meta'] . '</span>, ';
    echo '<span>' . $term_meta['custom_state_address_meta'] . '</span> ';
    echo '<span>' . $term_meta['custom_zip_address_meta'] . '</span>';
    echo '</address>';
    echo '<div><a style="color:#0185c6" target="_blank" href="https://maps.google.com/maps?f=d&amp;daddr=' . $clipit_map_address, '+', $term_meta['custom_city_address_meta'], '+', $term_meta['custom_state_address_meta'], '+', $term_meta['custom_zip_address_meta'] . '">Get Directions</a></div>';
    echo '<p>' . $term_meta['custom_term_meta'] . '</p>';
    echo '<p>' . wpautop($category->description) . '</p>';
    echo '</div>';
    echo '<div class="map col-2-3 last" style="margin-bottom:20px">';
    echo '<iframe id="map-preview-frame" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/place?q=' . $clipit_map_address, '+', $term_meta['custom_city_address_meta'], '+', $term_meta['custom_state_address_meta'], '+', $term_meta['custom_zip_address_meta'] . '&key=AIzaSyBj-ikeaUhEL5aIbgDebWahSCeFdOEcAKc" style="margin-top: 0px; min-height:175px; height:100%; width: 100%; overflow: hidden;"></iframe>';
    echo '</div>';
    echo '<div class="clear"></div>';
    echo '</div>';
}
?>
			<?php dynamic_sidebar('clipit-locations-sidebar');?>
		</div><!-- #secondary -->
	<?php endif;?>
<?php get_footer();?>