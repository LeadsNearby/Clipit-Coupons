<?php

add_action("admin_init", "clipit_meta_box");
function clipit_meta_box(){
	//Profile
	add_meta_box("coupon_options", "Coupon Options", "coupon_options", "coupon", "normal", "core");
    add_meta_box("coupon_preview", "Coupon Preview", "coupon_preview", "coupon", "normal", "core");
	add_meta_box("coupon_discount", "Discounts", "coupon_discount", "coupon", "side", "default");
	add_meta_box("coupon_how", "How To Use", "coupon_how", "coupon", "side", "default");
	add_meta_box("coupon_rules", "The Rules", "coupon_rules", "coupon", "side", "default");
	add_meta_box("coupon_shorts", "Contact Form Shortcode", "coupon_shorts", "coupon", "side", "default");
	add_meta_box("coupon_qrcode", "Coupon QR Code", "coupon_qrcode", "coupon", "side", "default");
}

function coupon_options( $post ) {
	$values = get_post_custom( $post->ID );
	$coupon_feature = (isset( $values['coupon_feature'] ) ? esc_attr( $values['coupon_feature'][0] ) : '');
	$coupon_social = (isset( $values['coupon_social'] ) ? esc_attr( $values['coupon_social'][0] ) : '');
	$coupon_email = (isset( $values['coupon_email'] ) ? esc_attr( $values['coupon_email'][0] ) : '');
	$coupon_views = (isset( $values['coupon_views'] ) ? esc_attr( $values['coupon_views'][0] ) : '');
	$coupon_dynamic_expiration = (isset( $values['coupon_dynamic_expiration'] ) ? esc_attr( $values['coupon_dynamic_expiration'][0] ) : '');
	$coupon_dynamic_expiration_plus_days = (isset( $values['coupon_dynamic_expiration_plus_days'] ) ? esc_attr( $values['coupon_dynamic_expiration_plus_days'][0] ) : '');
	$coupon_expiration = (isset( $values['coupon_expiration'] ) ? esc_attr( $values['coupon_expiration'][0] ) : '');
	$coupon_display_expiration = (isset( $values['coupon_display_expiration'] ) ? esc_attr( $values['coupon_display_expiration'][0] ) : '');
	$coupon_destination_url = (isset( $values['coupon_destination_url'] ) ? esc_attr( $values['coupon_destination_url'][0] ) : '');
	$coupon_action = (isset( $values['coupon_action'] ) ? esc_attr( $values['coupon_action'][0] ) : '');
	$coupon_type = (isset( $values['coupon_type'] ) ? esc_attr( $values['coupon_type'][0] ) : '');
	$coupon_social_like = (isset( $values['coupon_social_like'] ) ? esc_attr( $values['coupon_social_like'][0] ) : '');
	$coupon_like = (isset( $values['coupon_like'] ) ? esc_attr( $values['coupon_like'][0] ) : '');
	$coupon_main_upload = (isset( $values['coupon_main_upload'] ) ? esc_attr( $values['coupon_main_upload'][0] ) : '');
	$coupon_promo_code = (isset( $values['coupon_promo_code'] ) ? esc_attr( $values['coupon_promo_code'][0] ) : '');
	$coupon_name  = (isset( $values['coupon_name'] ) ? esc_attr( $values['coupon_name'][0] ) : '');
	$coupon_fineprint = (isset( $values['coupon_fineprint'] ) ? esc_attr( $values['coupon_fineprint'][0] ) : '');
	$coupon_promo_text = (isset( $values['coupon_promo_text'] ) ? esc_attr( $values['coupon_promo_text'][0] ) : '');
	$coupon_button_text = (isset( $values['coupon_button_text'] ) ? esc_attr( $values['coupon_button_text'][0] ) : '');
	$coupon_css_class = (isset( $values['coupon_css_class'] ) ? esc_attr( $values['coupon_css_class'][0] ) : '');
	$coupon_css_id = (isset( $values['coupon_css_id'] ) ? esc_attr( $values['coupon_css_id'][0] ) : '');
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>

	<div class="tab">
	  <div class="tablinks" onclick="openOption(event, 'Actions')" id="defaultOpen">Actions</div>
	  <div class="tablinks" onclick="openOption(event, 'Options')">Options</div>
	  <div class="tablinks" onclick="openOption(event, 'Uploads')">Uploads</div>
	  <div class="tablinks" onclick="openOption(event, 'Fine')">Fine Print & Promo</div>
	  <div class="tablinks" onclick="openOption(event, 'Styles')">Styles</div>
	</div>

	<div id="Actions" class="tabcontent">
	  <h3>Coupon Actions</h3>
	  <p>
	    <label for="coupon_type"><?php _e( 'Coupon Type', 'inputname' ); ?>:</label><br />
	    <em>Select if you want to upload your coupons or build them.</em><br />
	    <select name="coupon_type" id="coupon_type">
	        <option value="Build" <?php selected( $coupon_type, 'Build' ); ?>>Build Coupon</option>
	        <option value="Upload" <?php selected( $coupon_type, 'Upload' ); ?>>Upload Coupon</option>
	    </select>
	  </p>
	  <p>
	    <label for="coupon_action"><?php _e( 'Coupon Action', 'inputname' ); ?>:</label><br />
	    <em>Select what action you would like your coupon to take when a user clicks on it.</em><br />
	    <select name="coupon_action" id="coupon_action">
	        <option value="url" <?php selected( $coupon_action, 'url' ); ?>>Destination URL</option>
	        <option value="print" <?php selected( $coupon_action, 'print' ); ?>>Print Page</option>
	        <option value="promo" <?php selected( $coupon_action, 'promo' ); ?>>Promo Code Display</option>
	        <option value="peel" <?php selected( $coupon_action, 'peel' ); ?>>Promo Code Peel</option>
	    </select>
	  </p>
	  <p class="url"><label for="coupon_destination_url"><?php _e( 'Destination URL', 'inputname' ); ?>:</label><br />
	    <em>Enter the URL you want your coupon to redirect to once it is clicked on.</em><br />
	    <input class="coupon-text" type="text" size="" name="coupon_destination_url" value="<?php echo esc_html($coupon_destination_url); ?>" /> 
	  </p>
	  <p><label for="coupon_expiration"><?php _e( 'Coupon Expiration', 'inputname' ); ?></label><br />
	    <em>Choose a date you would like your coupon will expire.</em><br />
	    <input id="datepicker" class="coupon-text" type="text" size="" name="coupon_expiration" value="<?php echo esc_html($coupon_expiration); ?>" /> 
	  </p>
	  <p>
	    <input type="checkbox" id="coupon_dynamic_expiration" name="coupon_dynamic_expiration" <?php checked( $coupon_dynamic_expiration, 'on' ); ?> />
	    <label for="coupon_dynamic_expiration"><?php _e( 'Enable Dynamic Expiration Date', 'inputname' ); ?></label><br />
	    <em>Check to enable the Dynamic Expiration Date Feature</em>
	  </p>
	  <p>
	    <label for="coupon_dynamic_expiration_plus_days"><?php _e( 'Dynamic Expiration + Days', 'inputname' ); ?>:</label><br />
	    <em>Select how many days in the future you want dynamic expiration to show.</em><br />
	    <select name="coupon_dynamic_expiration_plus_days" id="coupon_dynamic_expiration_plus_days">
	        <option value="+0 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+0 day' ); ?>>+0 day</option>
	        <option value="+1 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+1 day' ); ?>>+1 day</option>
	        <option value="+2 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+2 day' ); ?>>+2 day</option>
	        <option value="+3 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+3 day' ); ?>>+3 day</option>
	        <option value="+4 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+4 day' ); ?>>+4 day</option>
	        <option value="+5 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+5 day' ); ?>>+5 day</option>
	        <option value="+6 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+6 day' ); ?>>+6 day</option>
	        <option value="+7 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+7 day' ); ?>>+7 day</option>
	        <option value="+8 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+8 day' ); ?>>+8 day</option>
	        <option value="+9 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+9 day' ); ?>>+9 day</option>
	        <option value="+10 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+10 day' ); ?>>+10 day</option>
	        <option value="+11 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+11 day' ); ?>>+11 day</option>
	        <option value="+12 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+12 day' ); ?>>+12 day</option>
	        <option value="+13 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+13 day' ); ?>>+13 day</option>
	        <option value="+14 day" <?php selected( $coupon_dynamic_expiration_plus_days, '+14 day' ); ?>>+14 day</option>
	    </select>
	  </p>
	</div>

	<div id="Options" class="tabcontent">
	  <h3>Coupon Options</h3>
	  <p>
	    <input type="checkbox" id="coupon_display_expiration" name="coupon_display_expiration" <?php checked( $coupon_display_expiration, 'on' ); ?> />
	    <label for="coupon_display_expiration"><?php _e( 'Display Expiration Date', 'inputname' ); ?></label><br />
	    <em>Check to display Expiration Date Feature</em>
	  </p>  
	  <p>
	    <input type="checkbox" id="coupon_social" name="coupon_social" <?php checked( $coupon_social, 'on' ); ?> />
	    <label for="coupon_social"><?php _e( 'Social Sharing', 'inputname' ); ?></label><br />
	    <em>Check to enable the Social Sharing</em>
	  </p>
	  <p>
	    <input type="checkbox" id="coupon_email" name="coupon_email" <?php checked( $coupon_email, 'on' ); ?> />
	    <label for="coupon_email"><?php _e( 'Email to Claim Coupon', 'inputname' ); ?></label><br />
	    <em>Check to enable the Email to Claim Feature</em>
	  </p>
	  <p>
	    <input type="checkbox" id="coupon_feature" name="coupon_feature" <?php checked( $coupon_feature, 'on' ); ?> />
	    <label for="coupon_feature"><?php _e( 'Featured Coupon', 'inputname' ); ?></label><br />
	    <em>Check to enable the Featured Coupon Banner</em>
	  </p>
	  <p>
	    <input type="checkbox" id="coupon_views" name="coupon_views" <?php checked( $coupon_views, 'on' ); ?> />
	    <label for="coupon_views"><?php _e( 'Display Coupon Views', 'inputname' ); ?></label><br />
	    <em>Check to display views of coupon</em>
	  </p>
	  <p><label for="coupon_name"><?php _e( 'Coupon Name', 'inputname' ); ?>:</label><br />
	    <em>Enter the name of your coupon - for internal use only.</em><br />
	    <input class="coupon_name" type="text" size="" name="coupon_name" value="<?php echo esc_html($coupon_name); ?>" /> 
	  </p> 
	</div>

	<div id="Uploads" class="tabcontent">
	  <h3>Coupon Uploads</h3>
	  <p class="upload"><label>Main Coupon Image (If uploading an image):</label><br />
	    <input class="upload_image" type="text" size="150" name="coupon_main_upload" value="<?php echo esc_html($coupon_main_upload); ?>" /> 
	    <span class="wp-media-buttons"><a title="Add Media" data-editor="coupon_main_upload" class="button upload_coupon_button add_media" href="#"><span class="wp-media-buttons-icon"></span> Add Media</a></span>
	    <div class="clear"></div>
	  </p>
	</div>

	<div id="Fine" class="tabcontent">
	  <h3>Fine Print and Promotions</h3>
	  <p>
	    <label for="coupon_fineprint"><?php _e( 'The Fine Print', 'textfine' ); ?>:</label><br />
	    <em>Enter your coupon fine print information here.</em><br />
	        <?php $fineprint_textarea = get_post_meta($post->ID, 'coupon_fineprint', true);
	    wp_editor($fineprint_textarea, 'coupon_fineprint', array(
	      'wpautop' => true,
	      'media_buttons' => true,
	      'textarea_name' => 'coupon_fineprint',
	      'textarea_rows' => 10,
	      'teeny' => true
	    ));
	    ?>    
	    <em><?php _e( 'Suitable for text and HTML. May include %s tags.', 'coupons' ); ?></em>
	  </p>
	  <p><label for="coupon_promo_code"><?php _e( 'Coupon Code/Promotional Code', 'inputname' ); ?>:</label><br />
	    <em>Enter your Coupon or Promo Code here. This will appear if you select "Promo Code Display" or partially appear if you select "Promo Code Peel" from the Coupon Actions drop down</em><br />
	    <input class="coupon_promo_code" type="text" size="" name="coupon_promo_code" value="<?php echo esc_html($coupon_promo_code); ?>" /> 
	  </p>
	  <p><label>Promo Text</label><br />
	    <em>If you selected "Promo Code Peel" from the Coupon Actions dropdown this text will appear in the modal that opens up to display the promo code.</em><br />
	    <input class="coupon_promo_text" type="text" size="" name="coupon_promo_text" value="<?php echo esc_html($coupon_promo_text); ?>" /> 
	  </p>
	</div>

	<div id="Styles" class="tabcontent">
	  <h3>Styles</h3>
	  <p><label>Custom Button Text</label><br />
	    <em>Enter in your custom button text. This will override the default button text</em><br />
	    <input class="coupon_button_text" type="text" size="" name="coupon_button_text" value="<?php echo esc_html($coupon_button_text); ?>" /> 
	  </p>
	  <p><label>CSS Class</label><br />
	    <em>Enter in your custom CSS class. This will add a custom class to the coupon</em><br />
	    <input class="coupon_css_class" type="text" size="" name="coupon_css_class" value="<?php echo esc_html($coupon_css_class); ?>" /> 
	  </p>
	  <p><label>CSS ID</label><br />
	    <em>Enter in your custom CSS ID. This will add a custom ID to the coupon</em><br />
	    <input class="coupon_css_id" type="text" size="" name="coupon_css_id" value="<?php echo esc_html($coupon_css_id); ?>" /> 
	  </p>
	</div>
	<div class="clear"></div>
	<script>
    function openOption(evt, optionName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(optionName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
    </script>
	
    <?php   
}

function coupon_discount( $post )
{
$values = get_post_custom( $post->ID );
	$coupon_savings = (isset( $values['coupon_savings'] ) ? esc_attr( $values['coupon_savings'][0] ) : '');
	$coupon_value = (isset( $values['coupon_value'] ) ? esc_attr( $values['coupon_value'][0] ) : '');
?>
	<p>Enter the actual value of the service or item in the first field, then enter the deal amount in the second field. The total savings will be calculated and displayed on the coupon.</p>
	<p><label for="coupon_value"><?php _e( 'Actual Value', 'inputvalue' ); ?>:</label><br />
		<em>Enter the actual dollar value of the service or item (no symbols). Ex: 25</em><br />
		<span>$</span><input class="coupon_value" type="text" size="" name="coupon_value" value="<?php echo esc_html($coupon_value); ?>" /> 
	</p>	
	<p><label for="coupon_savings"><?php _e( 'Savings', 'inputsavings' ); ?>:</label><br />
		<em>Enter the deal amount (no symbols). Ex: 50</em><br />
		<span>$</span><input class="coupon_savings" type="text" size="" name="coupon_savings" value="<?php echo esc_html($coupon_savings); ?>" /> 
	</p>
	<?php
}

function coupon_how( $post )
{
$values = get_post_custom( $post->ID );
	$coupon_how_to = (isset( $values['coupon_how_to'] ) ? esc_attr( $values['coupon_how_to'][0] ) : '');
?>
	<p>
        <label for="coupon_how_to"><?php _e( 'Description', 'textdesc' ); ?>:</label><br />
		<em>Enter and directions for use.</em><br />
        <textarea name="coupon_how_to" id="coupon_how_to" cols="25" rows="10"><?php echo stripslashes(get_post_meta($post->ID, 'coupon_how_to', true)); ?></textarea><br />
		<em><?php _e( 'Suitable for text and HTML. May include %s tags.', 'coupons' ); ?></em>
    </p>
	<?php
}

function coupon_rules( $post )
{
$values = get_post_custom( $post->ID );
	$coupon_rules = isset( $values['coupon_rules'] ) ? esc_attr( $values['coupon_rules'][0] ) : '';
?>
	<p>
        <label for="coupon_rules"><?php _e( 'The Rules', 'textfine' ); ?>:</label><br />
		<em>Enter any restrictions not specified in the Fine Print.</em><br />
        <textarea name="coupon_rules" id="coupon_rules" cols="25" rows="10"><?php echo stripslashes(get_post_meta($post->ID, 'coupon_rules', true)); ?></textarea><br />
		<em><?php _e( 'Suitable for text and HTML. May include %s tags.', 'coupons' ); ?></em>
    </p>
	<?php
}

function coupon_shorts( $post )
{
$values = get_post_custom( $post->ID );
	$coupon_shorts = isset( $values['coupon_shorts'] ) ? esc_attr( $values['coupon_shorts'][0] ) : '';
?>
	<p>
        <label for="coupon_shorts"><?php _e( 'Contact Form Shortcode', 'textfine' ); ?>:</label><br />
		<em>Enter your coupon shortcode here.</em><br />
        <textarea name="coupon_shorts" id="coupon_shorts" cols="25" rows="10"><?php echo stripslashes(get_post_meta($post->ID, 'coupon_shorts', true)); ?></textarea><br />
		<em><?php _e( 'Suitable for text and HTML. May include %s tags.', 'coupons' ); ?></em>
    </p>
	<?php
}

function coupon_qrcode( $post )
{
$values = get_post_custom( $post->ID );
	$coupon_shorts = isset( $values['coupon_shorts'] ) ? esc_attr( $values['coupon_shorts'][0] ) : '';
?>
	<img src="https://chart.googleapis.com/chart?cht=qr&amp;chs=225x225&amp;chl=<?php echo get_permalink( $post->ID ); ?>" width="225" height="225" />
	<?php
}

function coupon_preview( $post )
{
	$coupon_promo_code = get_post_meta($post->ID, 'coupon_promo_code', true);
	$coupon_action = get_post_meta($post->ID, 'coupon_action', true);
	$coupon_type = get_post_meta($post->ID, 'coupon_type', true);
	$coupon_main_upload = get_post_meta($post->ID, 'coupon_main_upload', true);
	$coupon_expiration = get_post_meta($post->ID, 'coupon_expiration', true);
	$coupon_dynamic_expiration = get_post_meta($post->ID, 'coupon_dynamic_expiration', true);
	$coupon_dynamic_expiration_plus_days = get_post_meta($post->ID, 'coupon_dynamic_expiration_plus_days', true);
	$coupon_display_expiration = get_post_meta($post->ID, 'coupon_display_expiration', true);
	$coupon_destination_url = get_post_meta($post->ID, 'coupon_destination_url', true);
	$coupon_feature = get_post_meta($post->ID, 'coupon_feature', true);
	$coupon_views = get_post_meta($post->ID, 'coupon_views', true);
	$coupon_spcial_like = get_post_meta($post->ID, 'coupon_like', true);
	$coupon_like = get_post_meta($post->ID, 'coupon_like', true);
	$coupon_name = get_post_meta($post->ID, 'coupon_name', true);
	$coupon_savings = get_post_meta($post->ID, 'coupon_savings', true);
	$coupon_fineprint = get_post_meta($post->ID, 'coupon_fineprint', true);
	$coupon_promo_text = get_post_meta($post->ID, 'coupon_promo_text', true);
	$coupon_style = get_post_meta($post->ID, 'coupon_style', true);
    $plusdate = strtotime($coupon_dynamic_expiration_plus_days);
	$dynamic_expirary_date = date('m/d/Y', $plusdate);		
?>

<div id="clipit" class="coupons">	
	<div class="grid">	
		<?php if ($coupon_type == 'Upload') { ?>
			<div id="clipit-style-one" class="col-1-1 border-container">
				<div class="col-1-1">
					<strong style="display: block;">Main Coupon Image</strong><br />
					<?php if ($coupon_action == 'url') { ?>
						<a href="<?php echo( $coupon_destination_url ); ?>"><img class="coup_upload" src="<?php echo( $coupon_main_upload ); ?>" /></a>
					<?php } elseif ($coupon_action == 'print') { ?>
						<a href="javascript:void(0)"><img class="coup_upload" src="<?php echo( $coupon_main_upload ); ?>" /></a>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>	
		<?php } elseif ($coupon_type == 'Build') { ?>
		
		<!-- ClipIt Style Two -->
		
		<div id="clipit-style-two" class="col-1-1 border-container">
			<div class="single-coup-container">
				<?php if ($coupon_feature == 'on') { ?>
					<div class="featured-banner"></div>
				<?php } ?>
				<div class="col-1-3 single-coup-img">
					<?php	
					// Default, blog-size thumbnail
					if(has_post_thumbnail()) {                    
						$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
						 echo '<img id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
					}else {
						echo'<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
					}?>								
				</div>
				<div class="col-2-3 last single-coup-content">
					<div class="coupon-title" itemprop="itemOffered"><?php the_title(); ?></div>
					<p class="description" itemprop="description"><?php the_content(); ?></p>
					<?php if (get_post_meta($post->ID, 'coupon_fineprint', true)) { ?>
					<hr />
					<div class="fineprint"><?php echo wpautop( $coupon_fineprint ); ?></div>
					<?php }elseif (get_option('clipit_fineprint_default') <> ""){
						echo '<hr />';
						echo '<div class="fineprint">'.wpautop(stripslashes(get_option('clipit_fineprint_default'))).'</div>';
					}else { ?>
					<hr />
					<div class="fineprint">Please call your service provider for more details.</div>	
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div><!-- .single-coupon-container -->
			<div class="coupon-highlight">
			        <div class="col-3-4">
				        <span class="div">
					<?php if ($coupon_dynamic_expiration == 'on') { ?>
						<div class="expiration" itemprop="availabilityEnds"><?php echo date('m/d/Y', $plusdate); ?></div>
						<?php } elseif ($coupon_dynamic_expiration == 'on' && $coupon_dynamic_expiration_plus_days == '+0 day') { ?>
						      <div itemprop="availabilityEnds">Expires Today!</div>
						<?php } else {?>
						      <div class="expiration" itemprop="availabilityEnds"><?php echo( $coupon_expiration ); ?></div>
						<?php } ?>
					</span>	
					<span class="div">
					<?php if ($coupon_views == 'on') { ?>
						<div class="views"><?php echo getCoupontViews(get_the_ID()); ?></div>
					<?php } ?>
					</span>
				</div><!-- .col-3-4 -->
				<div class="col-1-4 last action-buttons" style="margin-bottom:0">
					<?php if ($coupon_action == 'url') { ?>
						<div class="couponbutton">
							<a target="_blank" href="<?php echo( $coupon_destination_url ); ?>" itemprop="potentialAction">View Deal</a>
						</div>										
					<?php } elseif ($coupon_action == 'print') { ?>
						<div id="editor"></div>
						<div class="countable_link couponbutton print-coupon">
							<a href="javascript:void(0)">Print Coupon</a>
						</div>
					<?php } elseif ($coupon_action == 'promo') { ?>
						<div class="clicktoreveal">											
						<a class="code countable_link" style="text-align: center; text-decoration:none;" href="javascript:void(0)" itemprop="potentialAction"><?php echo( $coupon_promo_code ); ?></a>
						</div>									
					<?php } elseif ($coupon_action == 'peel') { ?>
					<?php add_thickbox(); ?>
						<div class="clicktoreveal">
							<a href="#TB_inline?width=706&height=661&inlineId=promo-code-two" class="thickbox countable_link" itemprop="potentialAction">Click to Reveal</a>
						</div>
						<div id="promo-code-two" style="display:none;">
								<p class="promo-text entryinfo">You selected the following coupon:</p>
								<!-- Start Coupon Copy -->	
								<div id="clipit-style-two" class="col-1-1 border-container">
								<?php if ($coupon_type == 'build') { ?>
									<div class="single-coup-container">
										<div class="col-1-3 single-coup-img">
											<?php	
											// Default, blog-size thumbnail
											if(has_post_thumbnail()) {                    
												$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
												 echo '<img id="image-slide" itemprop="image" src="' . $image_src[0]  . '" style="max-width:200px; height:auto; width:100%; margin:0; display:block;" />';
											}else {
												echo'<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:200px; height:auto; width:100%; margin:0; display:block;" />';
											}?>								
										</div>
										<div class="col-2-3 last single-coup-content">
											<div class="coupon-title" itemprop="itemOffered"><?php the_title(); ?></div>
											<p class="description" itemprop="description"><?php get_the_content(); ?></p>
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
										<span class="exptext" itemprop="availabilityEnds"><?php echo date('m/d/Y'); ?></span>
									<?php } else {?>
										<span class="exptext" itemprop="availabilityEnds"><?php echo( $coupon_expiration ); ?></span>
									<?php } ?>
								</div>
								<div class="clear"></div>
							</div><!-- #promo-code -->												
				        </div><!-- .col-1-4 -->									
					<?php } ?>
					<div class="clear"></div>									
				</div><!-- coupon-highlight -->
				<div class="clear"></div>
			</div><!-- col-1-1 clipit-style-two-->	
			</div><!-- col-1-1 clipit-style-two-->	
		<?php } ?>
	</div><!-- .grid -->
</div><!-- #clipit -->
	<?php
}


// Saves the Custom Metabozes
add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;	 

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;

	// now we can actually save the data
	$allowed = array(
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);

	// Make sure your data is set before trying to save it
	if( isset( $_POST['coupon_promo_code'] ) )
		update_post_meta( $post_id, 'coupon_promo_code', wp_kses( $_POST['coupon_promo_code'], $allowed ) );	

	if( isset( $_POST['coupon_expiration'] ) )
		update_post_meta( $post_id, 'coupon_expiration', wp_kses( $_POST['coupon_expiration'], $allowed ) );

	if( isset( $_POST['coupon_dynamic_expiration_plus_days'] ) )
		update_post_meta( $post_id, 'coupon_dynamic_expiration_plus_days', esc_attr( $_POST['coupon_dynamic_expiration_plus_days'] ) );		

	if( isset( $_POST['coupon_destination_url'] ) )
		update_post_meta( $post_id, 'coupon_destination_url', wp_kses( $_POST['coupon_destination_url'], $allowed ) );

	if( isset( $_POST['coupon_type'] ) )
		update_post_meta( $post_id, 'coupon_type', esc_attr( $_POST['coupon_type'] ) );

	if( isset( $_POST['coupon_main_upload'] ) )
		update_post_meta( $post_id, 'coupon_main_upload', esc_attr( $_POST['coupon_main_upload'] ) );

	if( isset( $_POST['coupon_action'] ) )
		update_post_meta( $post_id, 'coupon_action', esc_attr( $_POST['coupon_action'] ) );

	if( isset( $_POST['coupon_name'] ) )
		update_post_meta( $post_id, 'coupon_name', wp_kses( $_POST['coupon_name'], $allowed ) );

	if( isset( $_POST['coupon_value'] ) )
		update_post_meta( $post_id, 'coupon_value', wp_kses( $_POST['coupon_value'], $allowed ) );		
		
	if( isset( $_POST['coupon_savings'] ) )
		update_post_meta( $post_id, 'coupon_savings', wp_kses( $_POST['coupon_savings'], $allowed ) );	

	if( isset( $_POST['coupon_fineprint'] ) )
		update_post_meta( $post_id, 'coupon_fineprint', $_POST['coupon_fineprint'] );
	
	if( isset( $_POST['coupon_rules'] ) )
		update_post_meta( $post_id, 'coupon_rules', $_POST['coupon_rules'] );
	
	if( isset( $_POST['coupon_how_to'] ) )
		update_post_meta( $post_id, 'coupon_how_to', $_POST['coupon_how_to'] );
		
	if( isset( $_POST['coupon_shorts'] ) )
		update_post_meta( $post_id, 'coupon_shorts', $_POST['coupon_shorts'] );
		
	if( isset( $_POST['coupon_css_class'] ) )
		update_post_meta( $post_id, 'coupon_css_class', $_POST['coupon_css_class'] );

	if( isset( $_POST['coupon_css_id'] ) )
		update_post_meta( $post_id, 'coupon_css_id', $_POST['coupon_css_id'] );		

	if( isset( $_POST['coupon_promo_text'] ) )
		update_post_meta( $post_id, 'coupon_promo_text', wp_kses( $_POST['coupon_promo_text'], $allowed ) );
	
	if( isset( $_POST['coupon_button_text'] ) )
		update_post_meta( $post_id, 'coupon_button_text', wp_kses( $_POST['coupon_button_text'], $allowed ) );
		

	$dynamic_expiration = isset( $_POST['coupon_dynamic_expiration'] ) && $_POST['coupon_dynamic_expiration'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_dynamic_expiration', $dynamic_expiration );
	
	$display_expiration = isset( $_POST['coupon_display_expiration'] ) && $_POST['coupon_display_expiration'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_display_expiration', $display_expiration );
	
	$chk = isset( $_POST['coupon_feature'] ) && $_POST['coupon_feature'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_feature', $chk );
	
	$socialchk = isset( $_POST['coupon_social'] ) && $_POST['coupon_social'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_social', $socialchk );
	
	$claim = isset( $_POST['coupon_email'] ) && $_POST['coupon_email'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_email', $claim );
	
	$social_like = isset( $_POST['coupon_social_like'] ) && $_POST['coupon_social_like'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_social_like', $social_like );

	$like = isset( $_POST['coupon_like'] ) && $_POST['coupon_like'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_like', $like );

	$views = isset( $_POST['coupon_views'] ) && $_POST['coupon_views'] ? 'on' : 'off';
	update_post_meta( $post_id, 'coupon_views', $views );
	   
}
?>