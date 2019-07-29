<?php

add_action("admin_init", "clipit_meta_box");
function clipit_meta_box() {
    add_meta_box("coupon_options", "Coupon Options", "coupon_options", "coupon", "normal", "core");
}

add_action('rest_api_init', function () {
    register_meta('post', 'coupon_expiration', [
        'object_subtype' => 'coupon',
        'single' => true,
        'show_in_rest' => true,
    ]);
});

function coupon_options($post) {
    $values = get_post_custom($post->ID);
    $coupon_feature = (isset($values['coupon_feature']) ? esc_attr($values['coupon_feature'][0]) : '');
    $coupon_social = (isset($values['coupon_social']) ? esc_attr($values['coupon_social'][0]) : '');
    $coupon_email = (isset($values['coupon_email']) ? esc_attr($values['coupon_email'][0]) : '');
    $coupon_views = (isset($values['coupon_views']) ? esc_attr($values['coupon_views'][0]) : '');
    $coupon_dynamic_expiration = (isset($values['coupon_dynamic_expiration']) ? esc_attr($values['coupon_dynamic_expiration'][0]) : '');
    $coupon_dynamic_expiration_plus_days = (isset($values['coupon_dynamic_expiration_plus_days']) ? esc_attr($values['coupon_dynamic_expiration_plus_days'][0]) : '');
    $coupon_expiration = (isset($values['coupon_expiration']) ? esc_attr($values['coupon_expiration'][0]) : '');
    $coupon_destination_url = (isset($values['coupon_destination_url']) ? esc_attr($values['coupon_destination_url'][0]) : '');
    $coupon_action = (isset($values['coupon_action']) ? esc_attr($values['coupon_action'][0]) : '');
    $coupon_type = (isset($values['coupon_type']) ? esc_attr($values['coupon_type'][0]) : '');
    $coupon_promo_code = (isset($values['coupon_promo_code']) ? esc_attr($values['coupon_promo_code'][0]) : '');
    $coupon_name = (isset($values['coupon_name']) ? esc_attr($values['coupon_name'][0]) : '');
    $coupon_fineprint = (isset($values['coupon_fineprint']) ? esc_attr($values['coupon_fineprint'][0]) : '');
    $coupon_promo_text = (isset($values['coupon_promo_text']) ? esc_attr($values['coupon_promo_text'][0]) : '');
    $coupon_button_text = (isset($values['coupon_button_text']) ? esc_attr($values['coupon_button_text'][0]) : '');
    $coupon_css_class = (isset($values['coupon_css_class']) ? esc_attr($values['coupon_css_class'][0]) : '');
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>

	<!-- <div class="tab">
	  <div class="tablinks" onclick="openOption(event, 'Actions')" id="defaultOpen">Actions</div>
	  <div class="tablinks" onclick="openOption(event, 'Fine')">Fine Print & Promo</div>
	  <div class="tablinks" onclick="openOption(event, 'Styles')">Styles</div>
	</div> -->

	<div id="Actions" class="">
	  <p><label for="coupon_expiration"><?php _e('Coupon Expiration', 'inputname');?></label><br />
	    <em>Choose a date you would like your coupon will expire.</em><br />
	    <input id="datepicker" class="coupon-text" type="text" size="" name="coupon_expiration" value="<?php echo esc_html($coupon_expiration); ?>" />
	  </p>
	  <p>
	    <label for="coupon_fineprint"><?php _e('The Fine Print', 'textfine');?>:</label><br />
	    <em>Enter your coupon fine print information here. If nothing is entered, will fall back to fine print set in main settings.</em><br />
	        <?php $fineprint_textarea = get_post_meta($post->ID, 'coupon_fineprint', true);
    wp_editor($fineprint_textarea, 'coupon_fineprint', array(
        'wpautop' => true,
        'media_buttons' => false,
        'textarea_name' => 'coupon_fineprint',
        'textarea_rows' => 10,
        'teeny' => true,
    ));
    ?>
	    <em><?php _e('Suitable for text and HTML. May include %s tags.', 'coupons');?></em>
	  </p>
	  <p><label>CSS Class</label><br />
	    <em>Enter in your custom CSS class. This will add a custom class to the coupon</em><br />
	    <input class="coupon_css_class" type="text" size="" name="coupon_css_class" value="<?php echo esc_html($coupon_css_class); ?>" />
	  </p>
	  <p>
	    <label for="coupon_shorts"><?php _e('Contact Form Shortcode', 'textfine');?>:</label><br />
		<em>Enter your coupon shortcode here. <?php _e('Suitable for text and HTML. May include %s tags.', 'coupons');?></em>
		<textarea style="width:100%" name="coupon_shorts" id="coupon_shorts" rows="5"><?php echo stripslashes(get_post_meta($post->ID, 'coupon_shorts', true)); ?></textarea><br />
	  </p>
	</div>
    <?php
}

// Saves the Custom Metabozes
add_action('save_post', 'cd_meta_box_save');
function cd_meta_box_save($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce')) {
        return;
    }

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post')) {
        return;
    }

    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array(), // and those anchors can only have href attribute
        ),
    );

    // Make sure your data is set before trying to save it

    if (isset($_POST['coupon_expiration'])) {
        update_post_meta($post_id, 'coupon_expiration', wp_kses($_POST['coupon_expiration'], $allowed));
    }

    if (isset($_POST['coupon_type'])) {
        update_post_meta($post_id, 'coupon_type', esc_attr($_POST['coupon_type']));
    }

    if (isset($_POST['coupon_fineprint'])) {
        update_post_meta($post_id, 'coupon_fineprint', $_POST['coupon_fineprint']);
    }

    if (isset($_POST['coupon_shorts'])) {
        update_post_meta($post_id, 'coupon_shorts', $_POST['coupon_shorts']);
    }

    if (isset($_POST['coupon_css_class'])) {
        update_post_meta($post_id, 'coupon_css_class', $_POST['coupon_css_class']);
    }

}
?>