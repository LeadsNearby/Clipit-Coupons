<?php

add_action("admin_init", "clipit_meta_box");
function clipit_meta_box()
{
    add_meta_box("coupon_options", "Coupon Options", "coupon_options", "coupon", "normal", "core");
    add_meta_box("gbp_options", "GBP Options", "gbp_options", "coupon", "normal", "core");
}

add_action('rest_api_init', function () {
    register_meta('post', 'coupon_expiration', [
        'object_subtype' => 'coupon',
        'single' => true,
        'show_in_rest' => true,
    ]);
});

function coupon_options($post)
{
    $args = array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => -1
    );
    $pages = get_posts($args);

    $values = get_post_custom($post->ID);
    $is_value = esc_html( get_post_meta( $post->ID, 'coupon_fb_like', true ) );
    $is_featured = esc_html( get_post_meta( $post->ID, 'coupon_featured', true ) );
    $checked;
    $featured_checked;
    if ( $is_value == "yes" ) { $checked = "checked"; } 
	else if ( $is_value == "no" ) { $checked = ""; } 
	else { $checked="";}

    if ( $is_featured == "yes" ) { $featured_checked = "checked"; } 
	else if ( $is_featured == "no" ) { $featured_checked = ""; } 
	else { $featured_checked="";}
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
    $coupon_pre_text = (isset($values['coupon_pre_text']) ? esc_attr($values['coupon_pre_text'][0]) : '');
    $coupon_button_text = (isset($values['coupon_button_text']) ? esc_attr($values['coupon_button_text'][0]) : '');
    $coupon_fb_like = (isset($values['coupon_fb_like']) ? esc_attr($values['coupon_fb_like'][0]) : '');
    $page_custom_select = (isset($values['page_custom_select']) ? esc_attr($values['page_custom_select'][0]) : '');
    $coupon_icon = (isset($values['coupon_icon']) ? esc_attr($values['coupon_icon'][0]) : '');
    $coupon_css_class = (isset($values['coupon_css_class']) ? esc_attr($values['coupon_css_class'][0]) : '');
    
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
?>

    <div id="Actions" class="">
        <p>
            <label for="coupon_featured"><?php _e('Featured Coupon', 'inputname'); ?></label><br/>
            <label for="coupon_featured"><?php _e('Enable Featured Coupon', 'inputname'); ?>
                <input type="checkbox" name="coupon_featured" id="coupon_featured" value="yes" <?php echo $featured_checked; ?> />
            </label>
        </p>
        <p>
            <label id="expireDate" for="coupon_expiration"><?php _e('Coupon Expiration', 'inputname'); ?></label><br />
            <em>Choose a date you would like your coupon will expire.</em><br />
            <input id="datepicker" onfocus='this.value = ""' class="coupon-text" type="text" size="" name="coupon_expiration" value="<?php echo esc_html($coupon_expiration); ?>" required />
        <p class="date_err"></p>
        </p>
        <p>
            <label for="coupon_pre_text"><?php _e('Coupon Pre Text', 'inputname'); ?></label><br/>
            <input class="coupon_pre_text" type="text" size="" name="coupon_pre_text" value="<?php echo esc_html($coupon_pre_text); ?>" />
        </p>
        <p>
            <label for="coupon_fb_like"><?php _e('Enable Facebook Recommend Button', 'inputname'); ?></label><br/>
            <label for="coupon_fb_like"><?php _e('Enable Button', 'inputname'); ?>
                <input type="checkbox" name="coupon_fb_like" id="coupon_fb_like" value="yes" <?php echo $checked; ?> />
            </label>
        </p>
        <p>
            <label for="coupon_fineprint"><?php _e('The Fine Print', 'textfine'); ?>:</label><br />
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
            <em><?php _e('Suitable for text and HTML. May include %s tags.', 'coupons'); ?></em>
        </p>
        <p><label>CSS Class</label><br />
            <em>Enter in your custom CSS class. This will add a custom class to the coupon</em><br />
            <input class="coupon_css_class" type="text" size="" name="coupon_css_class" value="<?php echo esc_html($coupon_css_class); ?>" />
        </p>
        <p>
            <label for="coupon_shorts"><?php _e('Contact Form Shortcode', 'textfine'); ?>:</label><br />
            <em>Enter your coupon shortcode here. <?php _e('Suitable for text and HTML. May include %s tags.', 'coupons'); ?></em>
            <textarea style="width:100%" name="coupon_shorts" id="coupon_shorts" rows="5"><?php echo stripslashes(get_post_meta($post->ID, 'coupon_shorts', true)); ?></textarea><br />
        </p>
        <p>
				<label for="coupon_icon"><?php esc_attr_e( 'Coupon Icon', 'coupons' ); ?></label>
				<select id="coupon_icon" name="coupon_icon">
					<option value=""><?php esc_html_e( '&ndash; Select &ndash;', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( '5-stars' ); ?>" <?php selected( $coupon_icon, '5-stars', true ); ?>><?php esc_html_e( '5 Stars', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'air-blowing-alt' ); ?>" <?php selected( $coupon_icon, 'air-blowing-alt', true ); ?>><?php esc_html_e( 'Air Blowing Alt', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'air-blowing' ); ?>" <?php selected( $coupon_icon, 'air-blowing', true ); ?>><?php esc_html_e( 'Air Blowing', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'air-duct' ); ?>" <?php selected( $coupon_icon, 'air-duct', true ); ?>><?php esc_html_e( 'Air Duct', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'alarm' ); ?>" <?php selected( $coupon_icon, 'alarm', true ); ?>><?php esc_html_e( 'Alarm', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'backflow-preventer' ); ?>" <?php selected( $coupon_icon, 'backflow-preventer', true ); ?>><?php esc_html_e( 'Backflow Preventer', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'boiler' ); ?>" <?php selected( $coupon_icon, 'boiler', true ); ?>><?php esc_html_e( 'Boiler', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-badge' ); ?>" <?php selected( $coupon_icon, 'bolt-badge', true ); ?>><?php esc_html_e( 'Bolt Badge', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-battery' ); ?>" <?php selected( $coupon_icon, 'bolt-battery', true ); ?>><?php esc_html_e( 'Bolt Battery', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-car' ); ?>" <?php selected( $coupon_icon, 'bolt-car', true ); ?>><?php esc_html_e( 'Bolt Car', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-circle' ); ?>" <?php selected( $coupon_icon, 'bolt-circle', true ); ?>><?php esc_html_e( 'Bolt Circle', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-generator-simple' ); ?>" <?php selected( $coupon_icon, 'bolt-generator-simple', true ); ?>><?php esc_html_e( 'Bolt Generator Simple', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-generator' ); ?>" <?php selected( $coupon_icon, 'bolt-generator', true ); ?>><?php esc_html_e( 'Bolt Generator', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-roof' ); ?>" <?php selected( $coupon_icon, 'bolt-roof', true ); ?>><?php esc_html_e( 'Bolt Roof', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-square' ); ?>" <?php selected( $coupon_icon, 'bolt-square', true ); ?>><?php esc_html_e( 'Bolt Sqaure', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt-triangle' ); ?>" <?php selected( $coupon_icon, 'bolt-triangle', true ); ?>><?php esc_html_e( 'Bolt triangle', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bolt' ); ?>" <?php selected( $coupon_icon, 'bolt', true ); ?>><?php esc_html_e( 'Bolt', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'breaker' ); ?>" <?php selected( $coupon_icon, 'breaker', true ); ?>><?php esc_html_e( 'Breaker', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bulb-bolt' ); ?>" <?php selected( $coupon_icon, 'bulb-bolt', true ); ?>><?php esc_html_e( 'Bulb Bolt', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bulb-bright' ); ?>" <?php selected( $coupon_icon, 'bulb-bright', true ); ?>><?php esc_html_e( 'Bulb Bright', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bulb-glows' ); ?>" <?php selected( $coupon_icon, 'bulb-glows', true ); ?>><?php esc_html_e( 'Bulb Glow', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bulb-home' ); ?>" <?php selected( $coupon_icon, 'bulb-home', true ); ?>><?php esc_html_e( 'Bulb Home', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bulb-spiral' ); ?>" <?php selected( $coupon_icon, 'bulb-spiral', true ); ?>><?php esc_html_e( 'Bulb Spiral', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'bulb' ); ?>" <?php selected( $coupon_icon, 'bulb', true ); ?>><?php esc_html_e( 'Bulb', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'cable-multi' ); ?>" <?php selected( $coupon_icon, 'cable-multi', true ); ?>><?php esc_html_e( 'Cable Multi', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'cable' ); ?>" <?php selected( $coupon_icon, 'cable', true ); ?>><?php esc_html_e( 'Cable', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'cables' ); ?>" <?php selected( $coupon_icon, 'cables', true ); ?>><?php esc_html_e( 'Cables', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'cctv' ); ?>" <?php selected( $coupon_icon, 'cctv', true ); ?>><?php esc_html_e( 'CCTV', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'ceiling-fan-flat' ); ?>" <?php selected( $coupon_icon, 'ceiling-fan-flat', true ); ?>><?php esc_html_e( 'Ceiling Fan Flat', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'ceiling-fan' ); ?>" <?php selected( $coupon_icon, 'ceiling-fan', true ); ?>><?php esc_html_e( 'Ceiling Fan', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'clipboard-check' ); ?>" <?php selected( $coupon_icon, 'clipboard-check', true ); ?>><?php esc_html_e( 'Clipboard Check', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'clock-fast' ); ?>" <?php selected( $coupon_icon, 'clock-fast', true ); ?>><?php esc_html_e( 'Clock Fast', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'cogs' ); ?>" <?php selected( $coupon_icon, 'cogs', true ); ?>><?php esc_html_e( 'Cogs', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'commercial-building' ); ?>" <?php selected( $coupon_icon, 'commercial-building', true ); ?>><?php esc_html_e( 'Commercial Building', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'cone-caution' ); ?>" <?php selected( $coupon_icon, 'cone-caution', true ); ?>><?php esc_html_e( 'Cone Caution', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'crimping' ); ?>" <?php selected( $coupon_icon, 'crimping', true ); ?>><?php esc_html_e( 'Crimping', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'dehumidifier' ); ?>" <?php selected( $coupon_icon, 'dehumidifier', true ); ?>><?php esc_html_e( 'Dehumidifier', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'drill-jack-hammer' ); ?>" <?php selected( $coupon_icon, 'drill-jack-hammer', true ); ?>><?php esc_html_e( 'Drill Jack Hammer', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'drops' ); ?>" <?php selected( $coupon_icon, 'drops', true ); ?>><?php esc_html_e( 'Drops', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'dryer' ); ?>" <?php selected( $coupon_icon, 'dryer', true ); ?>><?php esc_html_e( 'Dryer', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'ductless' ); ?>" <?php selected( $coupon_icon, 'ductless', true ); ?>><?php esc_html_e( 'Ductless', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'ductwork' ); ?>" <?php selected( $coupon_icon, 'ductwork', true ); ?>><?php esc_html_e( 'Ductwork', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'exit' ); ?>" <?php selected( $coupon_icon, 'exit', true ); ?>><?php esc_html_e( 'Exit', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'extinguishers' ); ?>" <?php selected( $coupon_icon, 'extinguishers', true ); ?>><?php esc_html_e( 'Extinguisher', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'fan-alt' ); ?>" <?php selected( $coupon_icon, 'fan-alt', true ); ?>><?php esc_html_e( 'Fan Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'fan' ); ?>" <?php selected( $coupon_icon, 'fan', true ); ?>><?php esc_html_e( 'Fan', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'filling-pipe' ); ?>" <?php selected( $coupon_icon, 'filling-pipe', true ); ?>><?php esc_html_e( 'Filling Pipe', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'fire-supression' ); ?>" <?php selected( $coupon_icon, 'fire-supression', true ); ?>><?php esc_html_e( 'Fire Supression', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'flame-alt' ); ?>" <?php selected( $coupon_icon, 'flame-alt', true ); ?>><?php esc_html_e( 'Flame Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'flame-bar-bottom' ); ?>" <?php selected( $coupon_icon, 'flame-bar-bottom', true ); ?>><?php esc_html_e( 'Flame Bar Bottom', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'flame-flat' ); ?>" <?php selected( $coupon_icon, 'flame-flat', true ); ?>><?php esc_html_e( 'Flame Flat', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'flame-in-badge' ); ?>" <?php selected( $coupon_icon, 'flame-in-badge', true ); ?>><?php esc_html_e( 'Flame In Badge', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'flame' ); ?>" <?php selected( $coupon_icon, 'flame', true ); ?>><?php esc_html_e( 'Flame', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'floor-installation' ); ?>" <?php selected( $coupon_icon, 'floor-installation', true ); ?>><?php esc_html_e( 'Floor Installation', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage-closed' ); ?>" <?php selected( $coupon_icon, 'garage-closed', true ); ?>><?php esc_html_e( 'Garage Closed', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage-opener-keychain' ); ?>" <?php selected( $coupon_icon, 'garage-opener-keychain', true ); ?>><?php esc_html_e( 'Garage Opener Keychain', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage-opener' ); ?>" <?php selected( $coupon_icon, 'garage-opener', true ); ?>><?php esc_html_e( 'Garage Opener', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage-remote-opener' ); ?>" <?php selected( $coupon_icon, 'garage-remote-opener', true ); ?>><?php esc_html_e( 'Garage Remote Opener', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage-with-car-alt' ); ?>" <?php selected( $coupon_icon, 'garage-with-car-alt', true ); ?>><?php esc_html_e( 'Garage w/ Car Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage-with-car' ); ?>" <?php selected( $coupon_icon, 'garage-with-car', true ); ?>><?php esc_html_e( 'Garage w/ Car', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'globe-americas' ); ?>" <?php selected( $coupon_icon, 'globe-americas', true ); ?>><?php esc_html_e( 'Globe Americas', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'gutters' ); ?>" <?php selected( $coupon_icon, 'gutters', true ); ?>><?php esc_html_e( 'Gutters', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hammer' ); ?>" <?php selected( $coupon_icon, 'hammer', true ); ?>><?php esc_html_e( 'Hammer', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hand-home' ); ?>" <?php selected( $coupon_icon, 'hand-home', true ); ?>><?php esc_html_e( 'Hand Home', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hand-plant' ); ?>" <?php selected( $coupon_icon, 'hand-plant', true ); ?>><?php esc_html_e( 'Hand Plant', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hazards' ); ?>" <?php selected( $coupon_icon, 'hazards', true ); ?>><?php esc_html_e( 'Hazards', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'heat-pump' ); ?>" <?php selected( $coupon_icon, 'heat-pump', true ); ?>><?php esc_html_e( 'Heat Pump', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'home-foundation' ); ?>" <?php selected( $coupon_icon, 'home-foundation', true ); ?>><?php esc_html_e( 'Home Foundation', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'home-heart' ); ?>" <?php selected( $coupon_icon, 'home-heart', true ); ?>><?php esc_html_e( 'Home Heart', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'home-lock' ); ?>" <?php selected( $coupon_icon, 'home-lock', true ); ?>><?php esc_html_e( 'Home Lock', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'home-roof' ); ?>" <?php selected( $coupon_icon, 'home-roof', true ); ?>><?php esc_html_e( 'Home Roof', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'home-wifi' ); ?>" <?php selected( $coupon_icon, 'home-wifi', true ); ?>><?php esc_html_e( 'Home Wifi', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'ideas-light-bulb' ); ?>" <?php selected( $coupon_icon, 'ideas-light-bulb', true ); ?>><?php esc_html_e( 'Ideas Light Bulb', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'insulation-roll' ); ?>" <?php selected( $coupon_icon, 'insulation-roll', true ); ?>><?php esc_html_e( 'Insulation Roll', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'insulation-spiral' ); ?>" <?php selected( $coupon_icon, 'insulation-spiral', true ); ?>><?php esc_html_e( 'Insulation Spiral', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'insulation-spray' ); ?>" <?php selected( $coupon_icon, 'insulation-spray', true ); ?>><?php esc_html_e( 'Insulation Spray', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'irrigation-sprinkler' ); ?>" <?php selected( $coupon_icon, 'irrigation-sprinkler', true ); ?>><?php esc_html_e( 'Irrigation Sprinkler', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'landscape-light-directional' ); ?>" <?php selected( $coupon_icon, 'landscape-light-directional', true ); ?>><?php esc_html_e( 'Landscape Light Directional', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'landscape-light' ); ?>" <?php selected( $coupon_icon, 'landscape-light', true ); ?>><?php esc_html_e( 'Landscape Light', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'leaf' ); ?>" <?php selected( $coupon_icon, 'leaf', true ); ?>><?php esc_html_e( 'Leaf', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'leaves-alt' ); ?>" <?php selected( $coupon_icon, 'leaves-alt', true ); ?>><?php esc_html_e( 'Leaves Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'leaves-home' ); ?>" <?php selected( $coupon_icon, 'leaves-home', true ); ?>><?php esc_html_e( 'Leaves Home', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'leaves' ); ?>" <?php selected( $coupon_icon, 'leaves', true ); ?>><?php esc_html_e( 'Leaves', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'lighting-circled' ); ?>" <?php selected( $coupon_icon, 'lighting-circled', true ); ?>><?php esc_html_e( 'Lighting Circled', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'lock' ); ?>" <?php selected( $coupon_icon, 'lock', true ); ?>><?php esc_html_e( 'Lock', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'magnifying-spores' ); ?>" <?php selected( $coupon_icon, 'magnifying-spores', true ); ?>><?php esc_html_e( 'Magnifying Spores', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'mold' ); ?>" <?php selected( $coupon_icon, 'mold', true ); ?>><?php esc_html_e( 'Mold', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'mulitmeter' ); ?>" <?php selected( $coupon_icon, 'mulitmeter', true ); ?>><?php esc_html_e( 'Multimeter', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'paint-brush' ); ?>" <?php selected( $coupon_icon, 'paint-brush', true ); ?>><?php esc_html_e( 'Paint Brush', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'paint-can' ); ?>" <?php selected( $coupon_icon, 'paint-can', true ); ?>><?php esc_html_e( 'Paint Can', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'paint-roller-alt' ); ?>" <?php selected( $coupon_icon, 'paint-roller-alt', true ); ?>><?php esc_html_e( 'Paint Roller Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'paint-roller' ); ?>" <?php selected( $coupon_icon, 'paint-roller', true ); ?>><?php esc_html_e( 'Paint Roller', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'paint-spray-can' ); ?>" <?php selected( $coupon_icon, 'paint-spray-can', true ); ?>><?php esc_html_e( 'Paint Spray Can', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'paint-spray-gun' ); ?>" <?php selected( $coupon_icon, 'paint-spray-gun', true ); ?>><?php esc_html_e( 'Paint Spray Gun', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'pencil-ruler' ); ?>" <?php selected( $coupon_icon, 'pencil-ruler', true ); ?>><?php esc_html_e( 'Pencil Ruler', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'pest-control' ); ?>" <?php selected( $coupon_icon, 'pest-control', true ); ?>><?php esc_html_e( 'Pest Control', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'phone-office' ); ?>" <?php selected( $coupon_icon, 'phone-office', true ); ?>><?php esc_html_e( 'Phone Office', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'phone-retro' ); ?>" <?php selected( $coupon_icon, 'phone-retro', true ); ?>><?php esc_html_e( 'Phone Retro', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plug-bolt' ); ?>" <?php selected( $coupon_icon, 'plug-bolt', true ); ?>><?php esc_html_e( 'Plug Bolt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plug-circle' ); ?>" <?php selected( $coupon_icon, 'plug-circle', true ); ?>><?php esc_html_e( 'Plug Circle', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plug-in-circle' ); ?>" <?php selected( $coupon_icon, 'plug-in-circle', true ); ?>><?php esc_html_e( 'Plug In Circle', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plug' ); ?>" <?php selected( $coupon_icon, 'plug', true ); ?>><?php esc_html_e( 'Plug', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'power-washing' ); ?>" <?php selected( $coupon_icon, 'power-washing', true ); ?>><?php esc_html_e( 'Power Washing', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'putty-knife' ); ?>" <?php selected( $coupon_icon, 'putty-knife', true ); ?>><?php esc_html_e( 'Putty Knife', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'radiant-droplet' ); ?>" <?php selected( $coupon_icon, 'radiant-droplet', true ); ?>><?php esc_html_e( 'Radiant Droplet', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'radiant-heat' ); ?>" <?php selected( $coupon_icon, 'radiant-heat', true ); ?>><?php esc_html_e( 'Radiant Heat', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'roof-detail' ); ?>" <?php selected( $coupon_icon, 'roof-detail', true ); ?>><?php esc_html_e( 'Roof Detail', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'roofing-material' ); ?>" <?php selected( $coupon_icon, 'roofing-material', true ); ?>><?php esc_html_e( 'Roofing Material', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'safe' ); ?>" <?php selected( $coupon_icon, 'safe', true ); ?>><?php esc_html_e( 'Safe', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'sawing-wood' ); ?>" <?php selected( $coupon_icon, 'sawing-wood', true ); ?>><?php esc_html_e( 'Sawing Wood', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'sinkhole' ); ?>" <?php selected( $coupon_icon, 'sinkhole', true ); ?>><?php esc_html_e( 'Sinkhole', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'snowflake-alt' ); ?>" <?php selected( $coupon_icon, 'snowflake-alt', true ); ?>><?php esc_html_e( 'Snowflake Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'snowflake-sun-alt' ); ?>" <?php selected( $coupon_icon, 'snowflake-sun-alt', true ); ?>><?php esc_html_e( 'Snowflake Sun Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'snowflake' ); ?>" <?php selected( $coupon_icon, 'snowflake', true ); ?>><?php esc_html_e( 'Snowflake', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'solar-panels' ); ?>" <?php selected( $coupon_icon, 'solar-panels', true ); ?>><?php esc_html_e( 'Solar Panels', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'sound' ); ?>" <?php selected( $coupon_icon, 'sound', true ); ?>><?php esc_html_e( 'Sound', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'springs' ); ?>" <?php selected( $coupon_icon, 'springs', true ); ?>><?php esc_html_e( 'Springs', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'squiggly-alt' ); ?>" <?php selected( $coupon_icon, 'squiggly-alt', true ); ?>><?php esc_html_e( 'Squiggly Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'squiggly' ); ?>" <?php selected( $coupon_icon, 'squiggly', true ); ?>><?php esc_html_e( 'Squiggly', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'sun-fiery' ); ?>" <?php selected( $coupon_icon, 'sun-fiery', true ); ?>><?php esc_html_e( 'Sun Fiery', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'sun-leaf' ); ?>" <?php selected( $coupon_icon, 'sun-leaf', true ); ?>><?php esc_html_e( 'Sun Leaf', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'tamper' ); ?>" <?php selected( $coupon_icon, 'tamper', true ); ?>><?php esc_html_e( 'Tamper', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'technician' ); ?>" <?php selected( $coupon_icon, 'technician', true ); ?>><?php esc_html_e( 'Technician', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'termite-control' ); ?>" <?php selected( $coupon_icon, 'termite-control', true ); ?>><?php esc_html_e( 'Termite Control', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'thermometer' ); ?>" <?php selected( $coupon_icon, 'thermometer', true ); ?>><?php esc_html_e( 'Thermometer', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'toolbox' ); ?>" <?php selected( $coupon_icon, 'toolbox', true ); ?>><?php esc_html_e( 'Toolbox', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'truck' ); ?>" <?php selected( $coupon_icon, 'truck', true ); ?>><?php esc_html_e( 'Truck', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wall-pavers' ); ?>" <?php selected( $coupon_icon, 'wall-pavers', true ); ?>><?php esc_html_e( 'Wall Pavers', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'water-heater' ); ?>" <?php selected( $coupon_icon, 'water-heater', true ); ?>><?php esc_html_e( 'Water Heater', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'window-with-shutters' ); ?>" <?php selected( $coupon_icon, 'window-with-shutters', true ); ?>><?php esc_html_e( 'Window w/ Shutters', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wood-floor-install' ); ?>" <?php selected( $coupon_icon, 'wood-floor-install', true ); ?>><?php esc_html_e( 'Wood Floor Install', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wood-floors' ); ?>" <?php selected( $coupon_icon, 'wood-floors', true ); ?>><?php esc_html_e( 'Wood Floors', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wrench-hammer-toolbox' ); ?>" <?php selected( $coupon_icon, 'wrench-hammer-toolbox', true ); ?>><?php esc_html_e( 'Wrench Hammer Toolbox', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wrench-hand' ); ?>" <?php selected( $coupon_icon, 'wrench-hand', true ); ?>><?php esc_html_e( 'Wrench Hand', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wrench-motion' ); ?>" <?php selected( $coupon_icon, 'wrench-motion', true ); ?>><?php esc_html_e( 'Wrench Motion', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wrench-screwdriver' ); ?>" <?php selected( $coupon_icon, 'wrench-screwdriver', true ); ?>><?php esc_html_e( 'Wrench Screwdriver', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'wrench-toolbox' ); ?>" <?php selected( $coupon_icon, 'wrench-toolbox', true ); ?>><?php esc_html_e( 'Wrench Toolbox', 'coupons' ); ?></option>
                    
                </select>
			</p>
            <p>
                <label for="page_custom_select">Select Coupon Form Page:</label><br>
                <select id="page_custom_select" name="page_custom_select">
                    <option value="">Select the page that has your coupon form</option>
                    <?php foreach ( $pages as $page ) : ?>
                        <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page_custom_select, esc_attr( $page->ID ) ); ?>><?php echo esc_html( $page->post_title ); ?></option>
                        <?php endforeach; ?>
                </select>
            </p>
    </div>
    <?php
}


function gbp_options($post)
{
    $values = get_post_custom($post->ID);
    $coupon_code = (isset($values['gbp_coupon_code']) ? esc_attr($values['gbp_coupon_code'][0]) : '');
    $redemption_url = (isset($values['gbp_redemption_url']) ? esc_attr($values['gbp_redemption_url'][0]) : '');
    $post_to_gbp = (isset($values['post_to_gbp']) ? esc_attr($values['post_to_gbp'][0]) : '');
    $image = get_post_meta($post->ID, 'gbp_custom_image', true);
    $token = get_option('gbp_access_token');
    $locations = get_option('gbp_locations');
    $selected_location = get_option('gbp_selected_location');

    if ($token != null && $locations != null && $selected_location != null) {
    ?>

        <div id="locations_list gbp_options" class="location_list_div">
            <p style='font-weight: bold;'>
                List of Locations:
            </p>
            <?php
            $locations = get_option('gbp_locations');
            $selected_location_value = get_option('gbp_selected_location');
            foreach ($locations as $loc) {

                if (is_array($loc)) {
                    $locName = $loc['name'];
                    $locTitle = $loc['title'];
                } else {
                    $locName = $loc->name;
                    $locTitle = $loc->title;
                }

                if (!empty($selected_location_value) && in_array($locName, $selected_location_value)) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                echo "<p><input type='checkbox' name='gbp_box_loc[]' value='" . $locName . "' id='" . $locTitle . "' style='display: inline-block;visibility: visible;' " . $checked . "><label for='" . $locTitle . "'>" . $locTitle . "</label></p>";
                // echo "<br>";
            }
            ?>
            <span class="box_err" style="color: red;"></span>
        </div>
        <div id="Actions" class="">
            <p>
                <label>Coupon Code*</label> <br />
                <input type="text" name="gbp_coupon_code" id="gbp_coupon_code" class="coupon_css_class input-text" value="<?php echo $coupon_code; ?>"><br />
                <span class="code_err" style="color: red;"></span>
            </p>
            <p>
                <label>Redemption URL*</label> <br />
                <input type="text" name="gbp_redemption_url" id="gbp_redemption_url" class="coupon_css_class input-text" value="<?php echo $redemption_url; ?>"><br />
                <span class="url_err" style="color: red;"></span>
            </p>
            <div id="img_div" style='border: 1px solid #8c8f94;padding: 15px;border-radius: 4px;'>
                <p>
                    <label>Upload Offer Image*</label><br />
                    <em>Upload an image that is 540px wide. (min size: 1MB)</em>
                    <br />
                    <button name="file" class="gbp_upload_image_button" style='margin-top: 3px;'>Select Image</button><br />
                    <input type="hidden" name="gbp_custom_image" id="gbp_custom_image" value="<?php echo $image; ?>" style="width:500px;" />
                    <span class="img_err" style="color: red;"></span>
                    <?php
                    echo "<img src='" . $image . "' id='img_path' style='margin-top: 5px; width: 100px; height: 100px; " . ((!empty($image)) ? 'display: block;' : 'display: none;') . "' />";
                    ?>
                </p>
            </div>
            <p class='font-bold'>
                <input type="checkbox" name="post_to_gbp" class="post_to_gbp" id="post_to_gbp" <?php echo $post_to_gbp; ?>>
                <label for="post_to_gbp">Create offer post to GBP</label>
            </p>
            <script type="text/javascript">
                jQuery(function($) {
                    $('body').on('change', '#post_to_gbp', function() {
                        if ($("#post_to_gbp").prop('checked') == true) {
                            $("#post_to_gbp").val('checked');
                        } else {
                            $("#post_to_gbp").val('');
                        }
                    });
                    $('body').on('click', '#publish', function(e) {
                        if ($("#post_to_gbp").prop('checked') == true) {
                            $(".date_err").text('');
                            $(".img_err").text('');
                            $(".url_err").text('')
                            $(".code_err").text('');
                            $(".box_err").text('');
                            $(".invalid").removeClass("invalid");
                            var url_regex = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/
                            var loc_value = new Array();
                            $("input[name='gbp_box_loc[]']:checked").each(function() {
                                loc_value.push($(this).val());
                            });
                            if (loc_value == '' || loc_value == undefined) {
                                $("#locations_list").addClass("invalid");
                                $(".box_err").text('Please Select Atleast One Location');
                                window.location.href = '#gbp_options';
                                return false;
                            } else if ($("#gbp_coupon_code").val() == '') {
                                $("#gbp_coupon_code").addClass("invalid");
                                window.location.href = '#gbp_options';
                                $(".code_err").text('Coupon Code Required');
                                return false;
                            } else if ($("#gbp_redemption_url").val() == '') {
                                $("#gbp_redemption_url").addClass("invalid");
                                window.location.href = '#gbp_options';
                                $(".url_err").text('Redemption URL Required');
                                return false;
                            } else if (!url_regex.test($("#gbp_redemption_url").val())) {
                                $("#gbp_redemption_url").addClass("invalid");
                                window.location.href = '#gbp_options';
                                $(".url_err").text('Enter Valid URL');
                                return false;
                            } else if ($("#gbp_custom_image").val() == '') {
                                $("#img_div").addClass("invalid");
                                window.location.href = '#gbp_options';
                                $(".img_err").text('Offer Image Required');
                                return false;
                            } else if ($("#datepicker").val() != '') {
                                var GivenDate = $("#datepicker").val();
                                var CurrentDate = new Date();
                                GivenDate = new Date(GivenDate);
                                if (GivenDate < CurrentDate) {
                                    $("#datepicker").addClass("invalid");
                                    window.location.href = '#expireDate';
                                    $(".date_err").text('Coupon Expiration date is older than the current date.');
                                    $(".date_err").css('color', "red");
                                    return false;
                                }
                            } else {
                                $(".code_err").text('');
                                $(".url_err").text('');
                                $(".img_err").text('');
                                $(".date_err").text('');
                            }
                        }
                    });
                    $('body').on('click', '.gbp_upload_image_button', function(e) {
                        e.preventDefault();
                        if ($("#gbp_custom_image").val() != '') {
                            $(".img_err").text('');
                            $("#img_div").css('border', '1px solid #8c8f94');
                        }
                        var button = $(this),
                            cp_uploader = wp.media({
                                title: 'Custom image',
                                library: {
                                    uploadedTo: wp.media.view.settings.post.id,
                                    type: 'image'
                                },
                                button: {
                                    text: 'Use this image'
                                },
                                multiple: false
                            }).on('select', function() {
                                var attachment = cp_uploader.state().get('selection').first().toJSON();
                                $('#gbp_custom_image').val(attachment.url);
                                $('#img_path').attr('src', attachment.url);
                                $('#img_path').css('display', 'block');
                                $("#img_div").removeClass("invalid");
                                $('#img_div').css('border', '1px solid #8c8f94');
                                $('.img_err').text('');
                            })
                            .open();
                    });
                });
            </script>
        </div>
<?php
    } else {
        echo "<p><b>Need to Connect with GBP</b></p><p><a href='" . do_shortcode('[site_url]') . "/wp-admin/edit.php?post_type=coupon&page=admin-settings.php'>Please Connect GBP Account</a></p>";
    }
}

// Saves the Custom Metabozes
add_action('save_post', 'cd_meta_box_save');

function cd_meta_box_save($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce')) {
        return;
    }

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array(), // and those anchors can only have href attribute
        ),
    );

    // Make sure your data is set before trying to save it
    if (isset($_POST['gbp_coupon_code'])) {
        update_post_meta($post_id, 'gbp_coupon_code', esc_attr($_POST['gbp_coupon_code']));
    }
    if (isset($_POST['gbp_redemption_url'])) {
        update_post_meta($post_id, 'gbp_redemption_url', esc_attr($_POST['gbp_redemption_url']));
    }
    if (isset($_POST['gbp_custom_image'])) {
        update_post_meta($post_id, 'gbp_custom_image', esc_attr($_POST['gbp_custom_image']));
    }

    if ( isset( $_POST['coupon_featured'] ) && $_POST['coupon_featured'] != '' ) {
        update_post_meta( $post_id, 'coupon_featured', $_POST['coupon_featured'] );
    }else {
        update_post_meta( $post_id, 'coupon_featured', "no" );
    }

    if (isset($_POST['coupon_expiration'])) {
        update_post_meta($post_id, 'coupon_expiration', wp_kses($_POST['coupon_expiration'], $allowed));
    }

    if ( isset( $_POST['coupon_fb_like'] ) && $_POST['coupon_fb_like'] != '' ) {
        update_post_meta( $post_id, 'coupon_fb_like', $_POST['coupon_fb_like'] );
    }else {
        update_post_meta( $post_id, 'coupon_fb_like', "no" );
    }

    if (isset($_POST['page_custom_select'])) {
        update_post_meta($post_id, 'page_custom_select', esc_attr($_POST['page_custom_select']));
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

    if ( isset( $_POST['coupon_icon'] ) ) { 
        update_post_meta( $post_id, 'coupon_icon', sanitize_text_field( wp_unslash( $_POST['coupon_icon'] ) ) );
    }

    if (isset($_POST['coupon_pre_text'])) {
        update_post_meta($post_id, 'coupon_pre_text', $_POST['coupon_pre_text']);
    }

    if (isset($_POST['coupon_css_class'])) {
        update_post_meta($post_id, 'coupon_css_class', $_POST['coupon_css_class']);
    }

    if (isset($_POST['post_to_gbp'])) {
        $accounts = get_option('gbp_accounts');
        $access_token = get_option('gbp_access_token');
        $coupon_code = $_POST['gbp_coupon_code'];
        $summary = $_POST['coupon_fineprint'];
        if ($_POST['coupon_fineprint'] == '') {
            $summary = $_POST['post_excerpt'];
            if ($_POST['post_excerpt'] == '') {
                $summary = $_POST['content'];
                if ($_POST['content'] == '') {
                    $summary = $_POST['post_content'];
                }
            }
        }
        $title = $_POST['post_title'];
        if (strlen($title) >= 58) {
            $title = substr($title, 0, 50) . '...';
        }

        $redemption_url = $_POST['gbp_redemption_url'];
        $media_url = $_POST['gbp_custom_image'];
        // Coupon Start Date in year, month and day
        $st_year = get_the_date('Y', $post_id);
        $st_month = get_the_date('m', $post_id);
        $st_day = get_the_date('d', $post_id);
        // Coupon Publish Time in 24 Hours format
        $start_time = get_the_date('H:i:s');
        $start_time = date("H:i:s", strtotime($start_time));
        $ordertime = explode(':', $start_time);
        $st_hours = $ordertime[0];
        $st_minutes   = $ordertime[1];
        $st_seconds  = $ordertime[2];
        // Coupon Expiration Date
        $ex_date = $_POST['coupon_expiration'];
        $ex_date =  date("m-d-Y", strtotime($ex_date));
        $orderdate = explode('-', $ex_date);
        $ex_month = $orderdate[0];
        $ex_day   = $orderdate[1];
        $ex_year  = $orderdate[2];

        // $location = json_decode(get_option('gbp_selected_location'));
        // foreach ($location as $value) {
            $payload = '{
                "summary": "' . $summary . '",
                "event": {
                    "title": "' . $title . '",
                    "schedule": {
                        "startDate": {
                            "year": "' . $st_year . '",
                            "month": "' . $st_month . '",
                            "day": "' . $st_day . '"
                          },
                        "startTime": {
                            "hours": "' . $st_hours . '",
                            "minutes": "' . $st_minutes . '",
                            "seconds": "' . $st_seconds . '",
                            "nanos": 0,
                        },
                      "endDate": {
                        "year": "' . $ex_year . '",
                        "month": "' . $ex_month . '",
                        "day": "' . $ex_day . '"
                      },
                      "endTime": {
                        "hours": 23,
                        "minutes": 59,
                        "seconds": 59,
                        "nanos": 0,
                    },
                }
              },
                "offer": {
                   "couponCode": "' . $coupon_code . '",
                   "redeemOnlineUrl": "' . $redemption_url . '",
                   "termsConditions": "Offer only valid if you can prove you are a time traveler"
                },
                "media": [
                {
                  "mediaFormat": "PHOTO",
                  "sourceUrl": "' . $media_url . '"
                }
              ],
              "topicType": "OFFER"
            }';
    
            foreach ($_POST['gbp_box_loc'] as $value) {
            
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://mybusiness.googleapis.com/v4/accounts/' . $accounts->accounts . '/locations/' . $value . '/localPosts',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $access_token,
                    ),
                ));
                $response = curl_exec($curl);
                $result = json_decode($response);
            }

            $prevent_publish = false;
            update_post_meta($post_id, 'post_to_gbp', '');
            if ($result->error->code == '400') {
                $status_short_text = $result->error->message;
                $status_msg = json_encode($result->error->details);
                echo $status_msg;
                create_error_log($status_short_text, $status_msg);
                echo "<script>alert('something wrong');</script>";
                $prevent_publish = true;
            }
            //Set to true if data was invalid.
            if ($prevent_publish) {
                // unhook this function to prevent indefinite loop
                remove_action('save_post', 'cd_meta_box_save');
                // update the post to change post status
                wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
                // re-hook this function again
                add_action('save_post', 'cd_meta_box_save');
            }
            remove_action('save_post', 'cd_meta_box_save');
        } else {
            update_post_meta($post_id, 'post_to_gbp', '');
            return;
            exit;
        }
    }
    /* Write error info into plugin log file. */
    function create_error_log($error_short_text, $error_content)
    {
        $plugin_dir = plugin_dir_path(__FILE__);
        $error_date = date("M,d,Y h:i:s A");
        $error = $error_date . " : " . $error_short_text . " - " . $error_content . "\n----- ------ -----\n";
        error_log($error, 3, $plugin_dir . "/gbp_plugin.log");
    }
    ?>