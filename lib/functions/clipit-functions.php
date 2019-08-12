<?php
// ClipIt Functions

// https://ducdoan.com/add-custom-field-to-quick-edit-screen-in-wordpress/
/**
 * Add Headline news checkbox to quick edit screen
 *
 * @param string $column_name Custom column name, used to check
 * @param string $post_type
 *
 * @return void
 */
function clipit_quick_edit_add($column_name, $post_type) {
    if ('exp' != $column_name) {
        return;
    }

    printf(
        '<fieldset>
			<legend class="inline-edit-legend">Coupon Options</legend>
			<div class="inline-edit-col">
				<label style="display: inline-block">%s</label>
				<span style="display: inline-block; margin-left: 8px">
					<input style="width: auto" class="clipit-datepicker coupon-text" type="text" size="" name="coupon_expiration"/>
				</span>
			</div>
		</fieldset>',
        'Expiration Date'
    );
}

// add_action('quick_edit_custom_box', 'clipit_quick_edit_add', 10, 2);

/**
 * Save quick edit data
 *
 * @param int $post_id
 *
 * @return void|int
 */
function clipit_save_quick_edit_data($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    $data = $_POST['coupon_expiration'];
    update_post_meta($post_id, 'coupn_expiration', $data);
}

// add_action('save_post', 'clipit_save_quick_edit_data');

function clipit_quick_edit_javascript() {
    global $current_screen;

    if ('coupon' != $current_screen->post_type) {
        return;
    }
    ?>
    <script type="text/javascript">
    function checked_coupon_expiration(fieldValue) {
		inlineEditPost.revert();
		setTimeout(() => {
			const inlineEditor = document.querySelector('.inline-editor');
			const datePicker = inlineEditor.querySelector('.clipit-datepicker')
			datePicker.value = fieldValue;
			jQuery('.inline-editor .clipit-datepicker').datepicker({
				minDate: new Date()
			});
		}, 0);
    }
    </script>
<?php
}
// add_action('admin_footer', 'clipit_quick_edit_javascript');

function clipit_expand_quick_edit_link($actions, $post) {
    global $current_screen;

    if ('coupon' != $current_screen->post_type) {
        return $actions;
    }

    $data = get_post_meta($post->ID, 'coupon_expiration', true);
    $actions['inline hide-if-no-js'] = str_replace('type="button"', 'type="button" onclick="checked_coupon_expiration(\'' . $data . '\')"', $actions['inline hide-if-no-js']);
    return $actions;
}
// add_filter('post_row_actions', 'clipit_expand_quick_edit_link', 10, 2);

//Email Function
function clipit_email() {
    //EMail response generation function
    $callback = "";

    //function to generate response
    function homepage_form_generate_response($type, $message) {
        global $callback;

        if ($type == "success") {
            $callback = "<div class='success'>{$message}</div>";
        } else {
            $callback = "<div class='error'>{$message}</div>";
        }

    }

    //response messages
    $not_human = "Human verification incorrect.";
    $missing_content = "Please supply all information.";
    $email_invalid = "Email Address Invalid.";
    $message_unsent = "Message was not sent. Try Again.";
    $message_sent = "Thanks! Your message has been sent.";

    //user posted variables
    $name = $_POST['message_name'];
    $email = $_POST['message_email'];
    $phone = $_POST['message_phone'];
    $human = $_POST['message_human'];

    //php mailer variables
    $to = get_option('clipit_email_claim_address');
    $subject = $name . " claimed a coupon from " . get_the_title();
    $headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n" . 'Reply-To: ' . $email;
    'Reply-To: ' . $email . "\r\n";
    $message = '	<div style="padding: 10px 0px 30px;">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
							<tr>
								<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0;">
									<img src="' . plugins_url('images/logo-500px.png', __FILE__) . '" width="500" height="130" style="display: block;" />
								</td>
							</tr>
							<tr>
							<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px; text-transform: capitalize;">
											<b><span style="text-transform: capitalize;">' . $name . '<span> claimed the following coupon: ' . get_the_title() . '</b>
										</td>
									</tr>
									<tr>
										<td style="padding: 20px 0 30px 0;">
											<span style="text-transform: capitalize;">' . $name . '</span> claimed the following coupon: ' . get_the_title() . ' from ' . get_bloginfo('name') . ' and below is there contact information:<br /><br />
											<strong>Name: </strong><span style="text-transform: capitalize;">' . $name . '</span><br /><br />
											<strong>Email Address: </strong>' . $email . '<br /><br />
											<strong>Phone Number: </strong>' . $phone . '<br />
										</td>
									</tr>
								</table>
							</td>
							<td>
							</td>
							</tr>
							<tr>
								<td bgcolor="#ee4c50" style="padding: 30px; color: rgb(255, 255, 255);">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td>
												&copy; ' . date('Y') . ' ClipIt Couponer | All Rights Reserved.
											</td>
											<td><!-- Future Local for Contact Info --></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</body>';

    if (!$human == 0) {
        if ($human != 2) {
            homepage_form_generate_response("error", $not_human);
        }
        //not human!
        else {
            //validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                homepage_form_generate_response("error", $email_invalid);
            } else //email is valid
            {
                //validate presence of name and message
                if (empty($name) || empty($message)) {
                    homepage_form_generate_response("error", $missing_content);
                } else //ready to go!
                {
                    $sent = wp_mail($to, $subject, $message, $headers);
                    if ($sent) {
                        homepage_form_generate_response("success", $message_sent);
                    }
                    //message sent!
                    else {
                        homepage_form_generate_response("error", $message_unsent);
                    }
                    //message wasn't sent
                }
            }
        }
    } else if ($_POST['submitted']);
} //End clipit_email

//ClipIt Widget
function clipit_widgets_init() {
    register_sidebar(array(
        'name' => __('ClipIt Locations Sidebar', 'clipit'),
        'id' => 'clipit-locations-sidebar',
        'description' => __('Appears on ClipIt Locations Page', 'clipit'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'clipit_widgets_init');

// Add term page
function clipit_locations_add_phone_field() {
    // this will add the custom meta field to the add new term page
    ?>
		<div class="form-field">
			<label for="term_meta[custom_term_meta]"><?php _e('Phone Number', 'clipit');?></label>
			<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
			<p class="description"><?php _e('Enter the phone number for this location', 'clipit');?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_street_address_meta]"><?php _e('Street Address', 'clipit');?></label>
			<input type="text" name="term_meta[custom_street_address_meta]" id="term_meta[custom_street_address_meta]" value="">
			<p class="description"><?php _e('Enter the street address for this location', 'clipit');?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_city_address_meta]"><?php _e('City', 'clipit');?></label>
			<input type="text" name="term_meta[custom_city_address_meta]" id="term_meta[custom_city_address_meta]" value="">
			<p class="description"><?php _e('Enter the city for this location', 'clipit');?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_state_address_meta]"><?php _e('State', 'clipit');?></label>
			<input type="text" name="term_meta[custom_state_address_meta]" id="term_meta[custom_state_address_meta]" value="">
			<p class="description"><?php _e('Enter the state for this location', 'clipit');?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_zip_address_meta]"><?php _e('Zip Code', 'clipit');?></label>
			<input type="text" name="term_meta[custom_zip_address_meta]" id="term_meta[custom_zip_address_meta]" value="">
			<p class="description"><?php _e('Enter the zip for this location', 'clipit');?></p>
		</div>
	<?php
}
add_action('locations_add_form_fields', 'clipit_locations_add_phone_field', 10, 2);

// Edit term page
function clipit_locations_edit_meta_field($term) {

    // put the term ID into a variable
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option("taxonomy_$t_id");?>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e('Phone Number', 'clipit');?></label></th>
			<td>
				<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr($term_meta['custom_term_meta']) ? esc_attr($term_meta['custom_term_meta']) : ''; ?>">
				<p class="description"><?php _e('Enter the phone number for this location', 'clipit');?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_street_address_meta]"><?php _e('Street Address', 'clipit');?></label></th>
			<td>
				<input type="text" name="term_meta[custom_street_address_meta]" id="term_meta[custom_street_address_meta]" value="<?php echo esc_attr($term_meta['custom_street_address_meta']) ? esc_attr($term_meta['custom_street_address_meta']) : ''; ?>">
				<p class="description"><?php _e('Enter the street address for this location', 'clipit');?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_city_address_meta]"><?php _e('City', 'clipit');?></label></th>
			<td>
				<input type="text" name="term_meta[custom_city_address_meta]" id="term_meta[custom_city_address_meta]" value="<?php echo esc_attr($term_meta['custom_city_address_meta']) ? esc_attr($term_meta['custom_city_address_meta']) : ''; ?>">
				<p class="description"><?php _e('Enter the street address for this location', 'clipit');?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_state_address_meta]"><?php _e('State', 'clipit');?></label></th>
			<td>
				<input type="text" name="term_meta[custom_state_address_meta]" id="term_meta[custom_state_address_meta]" value="<?php echo esc_attr($term_meta['custom_state_address_meta']) ? esc_attr($term_meta['custom_state_address_meta']) : ''; ?>">
				<p class="description"><?php _e('Enter the street address for this location', 'clipit');?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_zip_address_meta]"><?php _e('Zip Code', 'clipit');?></label></th>
			<td>
				<input type="text" name="term_meta[custom_zip_address_meta]" id="term_meta[custom_zip_address_meta]" value="<?php echo esc_attr($term_meta['custom_zip_address_meta']) ? esc_attr($term_meta['custom_zip_address_meta']) : ''; ?>">
				<p class="description"><?php _e('Enter the street address for this location', 'clipit');?></p>
			</td>
		</tr>
	<?php
}
add_action('locations_edit_form_fields', 'clipit_locations_edit_meta_field', 10, 2);

// Save extra taxonomy fields callback function.
function save_taxonomy_custom_meta($term_id) {
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option("taxonomy_$t_id", $term_meta);
    }
}
add_action('edited_locations', 'save_taxonomy_custom_meta', 10, 2);
add_action('create_locations', 'save_taxonomy_custom_meta', 10, 2);

//Update Coupons CPT Messages
add_filter('post_updated_messages', 'coupon_updated_messages');
function coupon_updated_messages($messages) {
    if (empty($_GET['post'])) {
        return $messages;
    }
    $messages['coupon'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf(__('Coupon updated. <a href="%s">View Coupon</a>'), esc_url(get_permalink($_GET['post']))),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Coupon updated.'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf(__('Coupon restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Coupon published. <a href="%s">View Coupon</a>'), esc_url(get_permalink($_GET['post']))),
        7 => __('Coupon saved.'),
        8 => sprintf(__('Coupon submitted. <a target="_blank" href="%s">Preview Coupon</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($_GET['post'])))),
        9 => sprintf(__('Coupon scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Coupon</a>'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n(__('M j, Y @ G:i'), strtotime(get_the_date($_GET['post']))), esc_url(get_permalink($_GET['post']))),
        10 => sprintf(__('Coupon draft updated. <a target="_blank" href="%s">Preview Coupon</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($_GET['post'])))),
    );
    return $messages;
}

// Removes the excerpt field from the coupons post type
// add_action( 'admin_menu' , 'remove_clipit_excerpt_fields' );
// function remove_clipit_excerpt_fields() {
//     remove_meta_box( 'postexcerpt', 'post', 'normal' );
// }
// Change the columns for the edit Coupon screen
function change_columns($cols) {
    $cols = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Coupon'),
        'tags' => __('Coupon Tags'),
        'date' => __('Date'),
        'exp' => __('Expiration'),
        'display-category' => __('Display Type'),
    );
    return $cols;
}
add_filter("manage_coupon_posts_columns", "change_columns");
// Echo the values in the columns
function custom_columns($column, $post_id) {
    global $post;
    switch ($column) {
        case "exp":
            $exp = get_post_meta($post_id, 'coupon_expiration', true);
            echo '<div class="expiration-date">' . $exp . '</div>';
            break;
        case "postid":
            echo $post_id;
            break;
        case "display-category":
            /* Get the genres for the post. */
            $terms = get_the_terms($post_id, 'display-category');
            /* If terms were found. */
            if (!empty($terms)) {
                $out = array();
                /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                foreach ($terms as $term) {
                    $out[] = sprintf('<a href="%s">%s</a>',
                        esc_url(add_query_arg(array('post_type' => $post->post_type, 'display_category' => $term->slug), 'edit.php')),
                        esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'display_category', 'display'))
                    );
                }
                /* Join the terms, separating them with a comma. */
                echo join(', ', $out);
            }
            /* If no terms were found, output a default message. */
            else {
                _e('No Display Types');
            }
            break;
    }
}
add_action("manage_posts_custom_column", "custom_columns", 10, 2);

// Make these columns sortable
function sortable_columns() {
    return array(
        'exp' => 'exp',
        'tags' => 'tags',
        'display-category' => 'display-category',
    );
}
add_filter("manage_edit-coupon_sortable_columns", "sortable_columns");

// Adds view counter
function getCoupontViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "Viewed 0 Times";
    }
    return 'Viewed ' . $count . ' Times';
}

// Removes Yoast Columns from Coupons List
function coupon_remove_columns($columns) {
    unset($columns['wpseo-score']);
    unset($columns['wpseo-title']);
    unset($columns['wpseo-metadesc']);
    unset($columns['wpseo-focuskw']);
    return $columns;
}
add_filter('manage_edit-coupon_columns', 'coupon_remove_columns');

// Filter Yoast Meta Priority
function lower_wpseo_priority($html) {
    return 'low';
}
add_filter('wpseo_metabox_prio', 'lower_wpseo_priority');

//Allow HTML in Category Description
remove_filter('pre_term_description', 'wp_filter_kses');