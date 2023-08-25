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
    $is_fpd_featured = esc_html( get_post_meta( $post->ID, 'coupon_fineprint_display', true ) );
    $checked;
    $featured_checked;
    $fpd_checked;

    if ( $is_value == "yes" ) { $checked = "checked"; } 
	else if ( $is_value == "no" ) { $checked = ""; } 
	else { $checked="";}

    if ( $is_featured == "yes" ) { $featured_checked = "checked"; } 
	else if ( $is_featured == "no" ) { $featured_checked = ""; } 
	else { $featured_checked="";}

    if ( $is_fpd_featured == "yes" ) { $fpd_checked = "checked"; } 
	else if ( $is_fpd_featured == "no" ) { $fpd_checked = ""; } 
	else { $fpd_checked="";}
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
    $coupon_fineprint_display = (isset($values['coupon_fineprint_display']) ? esc_attr($values['coupon_fineprint_display'][0]) : '');
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
        <p>
            <label for="coupon_fineprint_display"><?php _e('Display Fine Print', 'inputname'); ?></label><br/>
            <label for="coupon_fineprint_display"><?php _e('Enable Button', 'inputname'); ?>
                <input type="checkbox" name="coupon_fineprint_display" id="coupon_fineprint_display" value="yes" <?php echo $fpd_checked; ?> />
            </label>
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
                    <option value="<?php echo esc_attr( 'electric_fan_repair_replace_one' ); ?>" <?php selected( $coupon_icon, 'electric_fan_repair_replace_one', true ); ?>><?php esc_html_e( 'Electric - Ceiling Fan', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'electric_fan_repair_replace_two' ); ?>" <?php selected( $coupon_icon, 'electric_fan_repair_replace_two', true ); ?>><?php esc_html_e( 'Electric - Ceiling Fan Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'electric_outlet_repair_replace' ); ?>" <?php selected( $coupon_icon, 'electric_outlet_repair_replace', true ); ?>><?php esc_html_e( 'Electric - Outlet', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'electric_panel' ); ?>" <?php selected( $coupon_icon, 'electric_panel', true ); ?>><?php esc_html_e( 'Electric - Panel', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'electric_recessed_lights' ); ?>" <?php selected( $coupon_icon, 'electric_recessed_lights', true ); ?>><?php esc_html_e( 'Electric - Recessed Light', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'electric_switch_repair_replace' ); ?>" <?php selected( $coupon_icon, 'electric_switch_repair_replace', true ); ?>><?php esc_html_e( 'Electric - Light Switch', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'electric_vehicle_charging' ); ?>" <?php selected( $coupon_icon, 'electric_vehicle_charging', true ); ?>><?php esc_html_e( 'Electric - Vehicle Charging', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'family_grandparents' ); ?>" <?php selected( $coupon_icon, 'family_grandparents', true ); ?>><?php esc_html_e( 'Family - Grandparents', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage_door_installation_one' ); ?>" <?php selected( $coupon_icon, 'garage_door_installation_one', true ); ?>><?php esc_html_e( 'Garage Door Installation- ', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage_door_installation_two' ); ?>" <?php selected( $coupon_icon, 'garage_door_installation_two', true ); ?>><?php esc_html_e( 'Garage Door - Installation Two', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage_door_repair_one' ); ?>" <?php selected( $coupon_icon, 'garage_door_repair_one', true ); ?>><?php esc_html_e( 'Garage Door - Repair', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'garage_door_repair_two' ); ?>" <?php selected( $coupon_icon, 'garage_door_repair_two', true ); ?>><?php esc_html_e( 'Garage Door - Repair Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hvac_ductless_repair_inside' ); ?>" <?php selected( $coupon_icon, 'hvac_ductless_repair_inside', true ); ?>><?php esc_html_e( 'HVAC - Ductless Repair', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hvac_ductless_repair_outside' ); ?>" <?php selected( $coupon_icon, 'hvac_ductless_repair_outside', true ); ?>><?php esc_html_e( 'HVAC - Ductless Repair Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hvac_installation_one' ); ?>" <?php selected( $coupon_icon, 'hvac_installation_one', true ); ?>><?php esc_html_e( 'HVAC Installation', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hvac_installation_two' ); ?>" <?php selected( $coupon_icon, 'hvac_installation_two', true ); ?>><?php esc_html_e( 'HVAC Installation Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'hvac_repair_one' ); ?>" <?php selected( $coupon_icon, 'hvac_repair_one', true ); ?>><?php esc_html_e( 'HVAC Repair', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'thermostat_digital' ); ?>" <?php selected( $coupon_icon, 'thermostat_digital', true ); ?>><?php esc_html_e( 'HVAC - Thermostat Digital', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'thermostat-smart' ); ?>" <?php selected( $coupon_icon, 'thermostat-smart', true ); ?>><?php esc_html_e( 'HVAC - Thermostat Smart', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'iaq_filter_replace' ); ?>" <?php selected( $coupon_icon, 'iaq_filter_replace', true ); ?>><?php esc_html_e( 'IAQ - Filter Replace', 'coupons' ); ?></option>
					<option value="<?php echo esc_attr( 'painting_painters' ); ?>" <?php selected( $coupon_icon, 'painting_painters', true ); ?>><?php esc_html_e( 'Painting - Painters', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_faucet_replacement' ); ?>" <?php selected( $coupon_icon, 'plumbing_faucet_replacement', true ); ?>><?php esc_html_e( 'Plumbing - Faucet Replace', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_repair_one' ); ?>" <?php selected( $coupon_icon, 'plumbing_repair_one', true ); ?>><?php esc_html_e( 'Plumbing - Repair', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_repair_two' ); ?>" <?php selected( $coupon_icon, 'plumbing_repair_two', true ); ?>><?php esc_html_e( 'Plumbing - Repair Two', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_repair_three' ); ?>" <?php selected( $coupon_icon, 'plumbing_repair_three', true ); ?>><?php esc_html_e( 'Plumbing  - Repair Three', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_tank_water_heater' ); ?>" <?php selected( $coupon_icon, 'plumbing_tank_water_heater', true ); ?>><?php esc_html_e( 'Plumbing - Tank Water Heater', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_tankless_water_heater_repair' ); ?>" <?php selected( $coupon_icon, 'plumbing_tankless_water_heater_repair', true ); ?>><?php esc_html_e( 'Plumbing - Tankless Water Heater Repair', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_tankless_water_heater' ); ?>" <?php selected( $coupon_icon, 'plumbing_tankless_water_heater', true ); ?>><?php esc_html_e( 'Plumbing - Tankless Water Heater', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_toilet_repair' ); ?>" <?php selected( $coupon_icon, 'plumbing_toilet_repair', true ); ?>><?php esc_html_e( 'Plumbing - Toilet Repair', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_toilet_repair_two' ); ?>" <?php selected( $coupon_icon, 'plumbing_toilet_repair_two', true ); ?>><?php esc_html_e( 'Plumbing - Toilet Repair Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'plumbing_toilet_replacement' ); ?>" <?php selected( $coupon_icon, 'plumbing_toilet_replacement', true ); ?>><?php esc_html_e( 'Plumbing - Toilet Replacement', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'roofing_asphault_shingle_installation_one' ); ?>" <?php selected( $coupon_icon, 'roofing_asphault_shingle_installation_one', true ); ?>><?php esc_html_e( 'Roofing - Asphalt Singles', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'roofing_asphault_shingle_installation_two' ); ?>" <?php selected( $coupon_icon, 'roofing_asphault_shingle_installation_two', true ); ?>><?php esc_html_e( 'Roofing - Asphalt Singles Alt', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'roofing_ceramic_shingles' ); ?>" <?php selected( $coupon_icon, 'roofing_ceramic_shingles', true ); ?>><?php esc_html_e( 'Roofing - Ceramic Singles', 'coupons' ); ?></option>
                    <option value="<?php echo esc_attr( 'window_replace_one' ); ?>" <?php selected( $coupon_icon, 'window_replace_one', true ); ?>><?php esc_html_e( 'Windows - Replace', 'coupons' ); ?></option>
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

    if ( isset( $_POST['coupon_fineprint_display'] ) && $_POST['coupon_fineprint_display'] != '' ) {
        update_post_meta( $post_id, 'coupon_fineprint_display', $_POST['coupon_fineprint_display'] );
    }else {
        update_post_meta( $post_id, 'coupon_fineprint_display', "no" );
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