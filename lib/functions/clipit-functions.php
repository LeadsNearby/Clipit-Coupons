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
function clipit_quick_edit_add( $column_name, $post_type ) {
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

add_action('quick_edit_custom_box', 'clipit_quick_edit_add', 10, 2 );
 
/**
 * Save quick edit data
 *
 * @param int $post_id
 *
 * @return void|int
 */
function clipit_save_quick_edit_data( $post_id ) {
    if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) {
        return $post_id;
    }
 
    if ( ! current_user_can( 'edit_post', $post_id ) || 'coupon' != $_POST['post_type'] ) {
        return $post_id;
    }
 
    $data = $_POST['coupon_expiration'];
    update_post_meta( $post_id, 'coupn_expiration', $data );
}

add_action('save_post', 'clipit_save_quick_edit_data');

function clipit_quick_edit_javascript() {
    global $current_screen;
 
    if ( 'coupon' != $current_screen->post_type ) {
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
add_action('admin_footer', 'clipit_quick_edit_javascript');

function clipit_expand_quick_edit_link( $actions, $post ) {
    global $current_screen;
 
    if ( 'coupon' != $current_screen->post_type ) {
        return $actions;
    }
 
	$data = get_post_meta( $post->ID, 'coupon_expiration', true );
    $actions['inline hide-if-no-js'] = str_replace('type="button"', 'type="button" onclick="checked_coupon_expiration(\''.$data.'\')"', $actions['inline hide-if-no-js']);;
    return $actions;
}
add_filter( 'post_row_actions', 'clipit_expand_quick_edit_link', 10, 2 );


	//Email Function
	function clipit_email() {
		//EMail response generation function
		$callback = "";

		//function to generate response		
		function homepage_form_generate_response($type, $message){
			global $callback;

			if($type == "success") $callback = "<div class='success'>{$message}</div>";
			else $callback = "<div class='error'>{$message}</div>";
		}

		//response messages
		$not_human       = "Human verification incorrect.";
		$missing_content = "Please supply all information.";
		$email_invalid   = "Email Address Invalid.";
		$message_unsent  = "Message was not sent. Try Again.";
		$message_sent    = "Thanks! Your message has been sent.";

		//user posted variables
		$name = $_POST['message_name'];
		$email = $_POST['message_email'];
		$phone = $_POST['message_phone'];  
		$human = $_POST['message_human'];

		//php mailer variables
		$to = get_option('clipit_email_claim_address');
		$subject = $name . " claimed a coupon from ".get_the_title();
		$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
		'Reply-To: ' . $email . "\r\n";
		$message ='	<div style="padding: 10px 0px 30px;">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
							<tr>
								<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0;">
									<img src="' . plugins_url( 'images/logo-500px.png', __FILE__ ) . '" width="500" height="130" style="display: block;" /> 
								</td>
							</tr>
							<tr>
							<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px; text-transform: capitalize;">
											<b><span style="text-transform: capitalize;">'.$name.'<span> claimed the following coupon: '.get_the_title().'</b>
										</td>
									</tr>
									<tr>
										<td style="padding: 20px 0 30px 0;">
											<span style="text-transform: capitalize;">'.$name.'</span> claimed the following coupon: '.get_the_title().' from '.get_bloginfo('name').' and below is there contact information:<br /><br />
											<strong>Name: </strong><span style="text-transform: capitalize;">'. $name .'</span><br /><br />
											<strong>Email Address: </strong>'. $email .'<br /><br />
											<strong>Phone Number: </strong>'. $phone .'<br />
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
												&copy; '.date('Y').' ClipIt Couponer | All Rights Reserved.
											</td>
											<td><!-- Future Local for Contact Info --></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</body>';						

		if(!$human == 0){
		if($human != 2) homepage_form_generate_response("error", $not_human); //not human!
			else {
				//validate email
				if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				homepage_form_generate_response("error", $email_invalid);
				else //email is valid
				{
					//validate presence of name and message
					if(empty($name) || empty($message)){
						homepage_form_generate_response("error", $missing_content);
					}
					else //ready to go!
					{
						$sent = wp_mail($to, $subject, $message, $headers);
						if($sent) homepage_form_generate_response("success", $message_sent); //message sent!
						else homepage_form_generate_response("error", $message_unsent); //message wasn't sent
					}
				}
			}
		}
		else if ($_POST['submitted']);		
	}//End clipit_email

	//ClipIt Widget
	function clipit_widgets_init() {
		register_sidebar( array(
			'name' => __( 'ClipIt Locations Sidebar', 'clipit' ),
			'id' => 'clipit-locations-sidebar',
			'description' => __( 'Appears on ClipIt Locations Page', 'clipit' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );	
	}
	add_action( 'widgets_init', 'clipit_widgets_init' );

	// Add term page
	function clipit_locations_add_phone_field() {
		// this will add the custom meta field to the add new term page
		?>		
		<div class="form-field">
			<label for="term_meta[custom_term_meta]"><?php _e( 'Phone Number', 'clipit' ); ?></label>
			<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">
			<p class="description"><?php _e( 'Enter the phone number for this location','clipit' ); ?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_street_address_meta]"><?php _e( 'Street Address', 'clipit' ); ?></label>
			<input type="text" name="term_meta[custom_street_address_meta]" id="term_meta[custom_street_address_meta]" value="">
			<p class="description"><?php _e( 'Enter the street address for this location','clipit' ); ?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_city_address_meta]"><?php _e( 'City', 'clipit' ); ?></label>
			<input type="text" name="term_meta[custom_city_address_meta]" id="term_meta[custom_city_address_meta]" value="">
			<p class="description"><?php _e( 'Enter the city for this location','clipit' ); ?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_state_address_meta]"><?php _e( 'State', 'clipit' ); ?></label>
			<input type="text" name="term_meta[custom_state_address_meta]" id="term_meta[custom_state_address_meta]" value="">
			<p class="description"><?php _e( 'Enter the state for this location','clipit' ); ?></p>
		</div>
		<div class="form-field">
			<label for="term_meta[custom_zip_address_meta]"><?php _e( 'Zip Code', 'clipit' ); ?></label>
			<input type="text" name="term_meta[custom_zip_address_meta]" id="term_meta[custom_zip_address_meta]" value="">
			<p class="description"><?php _e( 'Enter the zip for this location','clipit' ); ?></p>
		</div>
	<?php
	}
	add_action( 'locations_add_form_fields', 'clipit_locations_add_phone_field', 10, 2 );

	// Edit term page
	function clipit_locations_edit_meta_field($term) {
	 
		// put the term ID into a variable
		$t_id = $term->term_id;
	 
		// retrieve the existing value(s) for this meta field. This returns an array
		$term_meta = get_option( "taxonomy_$t_id" ); ?>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Phone Number', 'clipit' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>">
				<p class="description"><?php _e( 'Enter the phone number for this location','clipit' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_street_address_meta]"><?php _e( 'Street Address', 'clipit' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[custom_street_address_meta]" id="term_meta[custom_street_address_meta]" value="<?php echo esc_attr( $term_meta['custom_street_address_meta'] ) ? esc_attr( $term_meta['custom_street_address_meta'] ) : ''; ?>">
				<p class="description"><?php _e( 'Enter the street address for this location','clipit' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_city_address_meta]"><?php _e( 'City', 'clipit' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[custom_city_address_meta]" id="term_meta[custom_city_address_meta]" value="<?php echo esc_attr( $term_meta['custom_city_address_meta'] ) ? esc_attr( $term_meta['custom_city_address_meta'] ) : ''; ?>">
				<p class="description"><?php _e( 'Enter the street address for this location','clipit' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_state_address_meta]"><?php _e( 'State', 'clipit' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[custom_state_address_meta]" id="term_meta[custom_state_address_meta]" value="<?php echo esc_attr( $term_meta['custom_state_address_meta'] ) ? esc_attr( $term_meta['custom_state_address_meta'] ) : ''; ?>">
				<p class="description"><?php _e( 'Enter the street address for this location','clipit' ); ?></p>
			</td>
		</tr>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[custom_zip_address_meta]"><?php _e( 'Zip Code', 'clipit' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[custom_zip_address_meta]" id="term_meta[custom_zip_address_meta]" value="<?php echo esc_attr( $term_meta['custom_zip_address_meta'] ) ? esc_attr( $term_meta['custom_zip_address_meta'] ) : ''; ?>">
				<p class="description"><?php _e( 'Enter the street address for this location','clipit' ); ?></p>
			</td>
		</tr>
	<?php
	}
	add_action( 'locations_edit_form_fields', 'clipit_locations_edit_meta_field', 10, 2 );

	// Save extra taxonomy fields callback function.
	function save_taxonomy_custom_meta( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	}  
	add_action( 'edited_locations', 'save_taxonomy_custom_meta', 10, 2 );  
	add_action( 'create_locations', 'save_taxonomy_custom_meta', 10, 2 );

	//Counts Button Clicks on Coupons
	if ( is_admin() ) add_action( 'wp_ajax_nopriv_link_click_counter', 'link_click_counter' );
	function link_click_counter() {

		if ( isset( $_POST['nonce'] ) &&  isset( $_POST['post_id'] ) && wp_verify_nonce( $_POST['nonce'], 'link_click_counter_' . $_POST['post_id'] ) ) {
			$count = get_post_meta( $_POST['post_id'], 'link_click_counter', true );
			update_post_meta( $_POST['post_id'], 'link_click_counter', ( $count === '' ? 1 : $count + 1 ) );
		}
		exit();
	}

	add_action( 'wp_head', 'coupon_link_click_head' );
	function coupon_link_click_head() {
		global $post;

		if( isset( $post->ID ) ) {
	?>
		<script type="text/javascript" >
		jQuery(function ($) {
			var ajax_options = {
				action: 'link_click_counter',
				nonce: '<?php echo wp_create_nonce( 'link_click_counter_' . $post->ID ); ?>',
				ajaxurl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				post_id: '<?php echo $post->ID; ?>'
			};

			$( '.countable_link' ).on( 'click', function() {
				var self = $( this );
				$.post( ajax_options.ajaxurl, ajax_options, function() {
				
				});
			});
		});
		</script>
	<?php
		}
	}
	
	add_action( 'wp_head', 'coupon_custom_styles' );
	function coupon_custom_styles() {
		global $post;

		if( isset( $post->ID ) ) {
	?>
		<style><?php
		# Custom Top Border Color	
		$clipit_border_color=get_option('clipit_border_color');
		if($clipit_border_color){echo '.single-coup-container {border-color:'.$clipit_border_color.';}';}
		
		# Custom Highlight Border Color
		$clipit_border_color=get_option('clipit_border_color');
		if($clipit_border_color){echo '.coupon-highlight {border-color:'.$clipit_border_color.';}';}
		
		# Custom Divider Border Color
		//$clipit_border_color=get_option('clipit_border_color');
		//if($clipit_border_color){echo '#clipit-style-two span.div {border-color:'.$clipit_border_color.';}';}

		# Custom Background Content Color
		$clipit_content_bkgd_color=get_option('clipit_content_bkgd_color');
		if($clipit_content_bkgd_color){echo '.single-coup-container {background-color:'.$clipit_content_bkgd_color.';}';}
		
		# Custom Highlight Background Color	
		$clipit_highlight_bkgd_color=get_option('clipit_highlight_bkgd_color');
		if($clipit_highlight_bkgd_color){echo '.coupon-highlight {background-color:'.$clipit_highlight_bkgd_color.';}';}
		
		# Custom Featured Image Background	
		$clipit_featured_img_color=get_option('clipit_featured_img_color');
		if($clipit_featured_img_color){echo '.single-coup-img {background-color:'.$clipit_featured_img_color.';}';}
		
		# Custom Featured Image Border	
		$clipit_featured_img_border_color=get_option('clipit_featured_img_border_color');
		if($clipit_featured_img_border_color){echo '.single-coup-img {border:1px solid '.$clipit_featured_img_border_color.';}';}
		
		# Custom Title Color
		$clipit_title_color=get_option('clipit_title_color');
		if($clipit_title_color) {echo '.coupon-title, .single-coupon-title {color:'.$clipit_title_color.';}';}

		# Custom General Font Family	
		$clipit_general_font_family=get_option('clipit_general_font_family');
		if($clipit_general_font_family){echo '#clipit {font-family:'.$clipit_general_font_family.';}';}
		
		# Custom Title Font Family	
		$clipit_title_font_family=get_option('clipit_title_font_family');
		if($clipit_title_font_family){echo '.coupon-title, .single-coupon-title {font-family:'.$clipit_title_font_family.';}';}
		
		# Custom Title Font Size	
		$clipit_title_font_size=get_option('clipit_title_font_size');
		if($clipit_title_font_size){echo '.coupon-title, .single-coupon-title {font-size:'.$clipit_title_font_size.'; line-height:160%;}';}
		
		# Custom Expiration Color	
		$clipit_expiration_color=get_option('clipit_expiration_color');
		if($clipit_expiration_color){echo '.expiration, .views, .commentbubble {color:'.$clipit_expiration_color.';}';}
		
		# Custom Expiration Font Family	
		$clipit_expiration_font_family=get_option('clipit_expiration_font_family');
		if($clipit_expiration_font_family){echo '.expiration, .views, .commentbubble {font-family:'.$clipit_expiration_font_family.';}';}
		
		# Custom Expiration Font Size	
		$clipit_expiration_font_size=get_option('clipit_expiration_font_size');
		if($clipit_expiration_font_size){echo '.expiration, .views, .commentbubble {font-size:'.$clipit_expiration_font_size.'; line-height:160%;}';}
		
		# Custom Description Color	
		$clipit_description_color=get_option('clipit_description_color');
		if($clipit_description_color){echo '.description {color:'.$clipit_description_color.';}';}
		
		# Custom Description Font Family
		$clipit_description_font_family=get_option('clipit_description_font_family');
		if($clipit_description_font_family){echo '.description {font-family:'.$clipit_description_font_family.';}';}
		
		# Custom Description Font Size	
		$clipit_description_font_size=get_option('clipit_description_font_size');
		if($clipit_description_font_size){echo '.description {font-size:'.$clipit_description_font_size.'; line-height:160%;}';}
		
		# Custom Fine Print Color	
		$clipit_fineprint_color=get_option('clipit_fineprint_color');
		if($clipit_fineprint_color){echo '.fineprint {color:'.$clipit_fineprint_color.';}';}
		
		# Custom Fine Print Font Size	
		$clipit_fineprint_font_size=get_option('clipit_fineprint_font_size');
		if($clipit_fineprint_font_size){echo '.fineprint {font-size:'.$clipit_fineprint_font_size.'; line-height:160%;}';}
		
		# Custom Fine Print Family	
		$clipit_fineprint_font_family=get_option('clipit_fineprint_font_family');
		if($clipit_fineprint_font_family){echo '.fineprint {font-family:'.$clipit_fineprint_font_family.';}';}
		
		# Custom Promo Color	
		$clipit_promo_text_color=get_option('clipit_promo_text_color');
		if($clipit_promo_text_color){echo '.reveal .code {color:'.$clipit_promo_text_color.';}';}	

		# Custom Button Font Family	
		$clipit_button_font_family=get_option('clipit_button_font_family');
		if($clipit_button_font_family){echo '.couponbutton a {font-family:'.$clipit_button_font_family.' !important;}';}
		
		# Custom Button Font Size
		$clipit_button_font_size=get_option('clipit_button_font_size');
		if($clipit_button_font_size){echo '.couponbutton a {font-size:'.$clipit_button_font_size.' !important; line-height:100%;}';}
	
		# Custom CSS
		if (get_option('clipit_css_styling') <> "") { echo stripslashes(stripslashes(get_option('clipit_css_styling'))); }
		?></style>
	<?php
		}
	}

	add_action( 'wp_footer', 'clipit_page_banner' );
	function clipit_page_banner() {
		if (get_option('clipit_coupon_banner_enable') == 1){ ?>
		
		<style type="text/css">	
		.clipit-tag-wrap {
			position: fixed;
			<?php if (get_option('clipit_coupon_banner_position') == "right"){ ?>
			right: 0;
			<?php } else if (get_option('clipit_coupon_banner_position') == "left"){ ?>
			left: 0;
			<?php } ?>
			top: 134px;
			z-index: 60;
		}
		.clipit-tag {
			<?php if (get_option('clipit_coupon_banner_width') <> ""){ ?>
			width: <?php echo get_option('clipit_coupon_banner_width'); ?>;
			<?php } else { ?>
			width: 200px;
			<?php } ?>
			<?php if (get_option('clipit_coupon_banner_height') <> ""){ ?>
			height: <?php echo get_option('clipit_coupon_banner_height'); ?>;
			<?php } else { ?>
			height: 60px;
			<?php } ?>
			<?php if (get_option('clipit_coupon_banner_image') <> ""){ ?>
			background: url(<?php echo get_option('clipit_coupon_banner_image'); ?>) 1px 0 no-repeat;
			<?php } else { ?>
			background: url(<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'inc/images/coupon-banner.png'; ?>) 1px 0 no-repeat;
			<?php } ?>
			text-indent: -9999px;
			overflow: hidden;
			display: block;
		}		
		</style>
		<div class="clipit-tag-wrap">
			<a class="clipit-tag" href="<?php echo get_option('clipit_coupon_banner_link'); ?>">Coupons</a>
		</div>
		
	<?php } 
	}
	
	//Set Email as text/html
	function wps_set_content_type(){
		return "text/html";
	}
	add_filter( 'wp_mail_content_type','wps_set_content_type' );

	//Update Coupons CPT Messages
	add_filter('post_updated_messages', 'coupon_updated_messages');
	function coupon_updated_messages( $messages ) {
	$messages['coupon'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Coupon updated. <a href="%s">View Coupon</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Coupon updated.'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Coupon restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Coupon published. <a href="%s">View Coupon</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Coupon saved.'),
		8 => sprintf( __('Coupon submitted. <a target="_blank" href="%s">Preview Coupon</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Coupon scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Coupon</a>'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Coupon draft updated. <a target="_blank" href="%s">Preview Coupon</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
	}

	// Removes the excerpt field from the coupons post type
	add_action( 'admin_menu' , 'remove_clipit_excerpt_fields' );
	function remove_clipit_excerpt_fields() {
		remove_meta_box( 'postexcerpt', 'post', 'normal' );
	}
	// Change the columns for the edit Coupon screen
	function change_columns( $cols ) {
	  $cols = array(
		'cb'       => '<input type="checkbox" />',
		'title'    => __( 'Coupon' ),
		'tags'   => __( 'Coupon Tags' ),
		'comments' => __( 'Comments' ),
		'date' => __( 'Date' ),
		'exp'      => __( 'Expiration' ),
		//'postid' => __( 'Post ID' ),
		//'thumbs_rating_up_count' =>  __( '+ Votes', 'thumbs-rating' ),
	    //'thumbs_rating_down_count' => __( '- Votes', 'thumbs-rating' ),
		'coupon_type' => __( 'Coupon Type' ),
		'display-category' => __( 'Display Type' ),
		'coupon_img' => __( 'Coupon Image' ),			
	  );
	  return $cols;
	}
	add_filter( "manage_coupon_posts_columns", "change_columns" );
	// Echo the values in the columns
	function custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case "exp":
				$exp = get_post_meta( $post_id, 'coupon_expiration', true);
				echo '<div class="expiration-date">' . $exp. '</div>';
				break;
			case "postid":
				echo $post_id;
				break;		  	  		  
			case "coupon_type":
				$coupon_type = get_post_meta( $post_id, 'coupon_type', true);
				echo '<span>' . $coupon_type. '</span>';
				break; 
			case "display-category" :
				/* Get the genres for the post. */
				$terms = get_the_terms( $post_id, 'display-category' );
				/* If terms were found. */
				if ( !empty( $terms ) ) {
					$out = array();
					/* Loop through each term, linking to the 'edit posts' page for the specific term. */
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'display_category' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'display_category', 'display' ) )
						);
					}
					/* Join the terms, separating them with a comma. */
					echo join( ', ', $out );
				}
				/* If no terms were found, output a default message. */
				else {
					_e( 'No Display Types' );
				}
			break;
			case "coupon_img":
				$coupon_type = get_post_meta( $post_id, 'coupon_type', true);
				$coupon_image = get_post_meta($post_id, 'coupon_main_upload', true);
				if ($coupon_type == 'upload') {
					echo '<img src="' .$coupon_image. '" />';
				}else {
					echo '<img src="'.plugins_url( '/images/default-coup-img.png', __FILE__).'" />';
				}			
			break; 
		}
	}
	add_action( "manage_posts_custom_column", "custom_columns", 10, 2 );
	
	// Make these columns sortable
	function sortable_columns() {
	  return array(
		'exp'       	=> 'exp',
		'tags'      	=> 'tags',
		'coupon_type'   => 'coupon_type',
		'display-category'   => 'display-category',
	  );
	}
	add_filter( "manage_edit-coupon_sortable_columns", "sortable_columns" );
	
	// Adds view counter
	function getCoupontViews($postID){
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "Viewed 0 Times";
		}
		return 'Viewed ' .$count. ' Times';
	}
	
	// Displays the view counter
	function setCouponViews($postID) {
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}	
	// Remove issues with prefetching adding extra views
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);	
	
	// Removes Yoast Columns from Coupons List
	function coupon_remove_columns( $columns ) {
		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );
		return $columns;
	}
	add_filter ( 'manage_edit-coupon_columns', 'coupon_remove_columns' );
	
	// Filter Yoast Meta Priority
	function lower_wpseo_priority( $html ) {
		return 'low';
	}
	add_filter( 'wpseo_metabox_prio', 'lower_wpseo_priority' );	
	
	//Allow HTML in Category Description	
	remove_filter('pre_term_description', 'wp_filter_kses');

	// Function creates post duplicate as a draft and redirects then to the edit post screen
	function rd_duplicate_post_as_draft(){
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
	 
		// get the original post id
		$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
		
		// and all the original post data then
		$post = get_post( $post_id );

		// if you don't want current user to be the new post author,
		// then change next couple of lines to this: $new_post_author = $post->post_author;
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
	 
		// if post data exists, create the post duplicate
		if (isset( $post ) && $post != null) {
	 
			// new post data array
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
	 
			// insert the post by wp_insert_post() function
			$new_post_id = wp_insert_post( $args );
	 
			//get all current post terms ad set them to the new post draft
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
	 
			// duplicate all post meta
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
	 
			// finally, redirect to the edit post screen for the new draft
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}
	add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
	 
	// Add the duplicate link to action list for post_row_actions
	function rd_duplicate_post_link( $actions, $post ) {
		if (current_user_can('edit_posts')) {
			$actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Clone this item" rel="permalink">Clone</a>';
		}
		return $actions;
	}
	 
	add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );	


	
	//------------------------------------------------------
    //------------- PAGE/POST EDIT PAGE ---------------------

	add_action('admin_header', 'page_supports_add_clipit_button');
    function page_supports_add_clipit_button(){
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		        return;
		}
    }

    //Action target that adds the "Insert Form" button to the post/page edit screen
	add_action('media_buttons', 'add_clipit_button', 20);
    function add_clipit_button(){

        // do a version check for the new 3.5 UI
        $version    = get_bloginfo('version');

        if ($version < 3.5) {
            // show button for v 3.4 and below
            $image_btn = plugins_url('/images/form-button.png', __FILE__);
            echo '<a href="#TB_inline?width=750&height=450&inlineId=select_coupon" class="thickbox" id="add_clipit" title="' . __("Add ClipIt Shortcode", 'clipit') . '"><img src="'.$image_btn.'" alt="' . __("Add ClipIt Shortcode", 'clipit') . '" /></a>';
        } else {
            // display button matching new UI
            echo '<a href="#TB_inline?width=750&height=450&inlineId=select_coupon" class="thickbox button gform_media_link" id="add_clipit" title="' . __("Add ClipIt Shortcode", 'clipit') . '"><span style="padding-top: 3px;" class="dashicons dashicons-tickets"></span> ' . __("Add Coupon", "clipit") . '</a>';
        }
    }
	
    //Action target that displays the popup to insert a form to a post/page
	add_action('admin_footer', 'add_mce_popup');
    function add_mce_popup(){
        ?>
        <script>
            function InsertCoupon(){
                var clipit_id = jQuery("#add_clipit_id").val();
                if(clipit_id == ""){
                    alert("<?php _e("Please select a coupon", "clipit") ?>");
                    return;
                }

                var clipit_name = jQuery("#add_clipit_id option[value='" + clipit_id + "']").text().replace(/[\[\]]/g, '');
                var clipit_title = jQuery("#clipit_title").is(":checked");
                var display_description = jQuery("#display_description").is(":checked");
                var clipit_sidebar = jQuery("#clipit_sidebar").is(":checked");
                var clipit_desc= jQuery("#clipit_desc").is(":checked");
                var clipit_img = jQuery("#clipit_img").is(":checked");
                var clipit_trim = jQuery("#clipit_trim").is(":checked");
                var clipit_fine = jQuery("#clipit_fine").is(":checked");
                var clipit_feature = jQuery("#clipit_feature").is(":checked");
                var clipit_discount = jQuery("#clipit_discount").is(":checked");
                var clipit_views = jQuery("#clipit_views").is(":checked");
                var clipit_comments = jQuery("#clipit_comments").is(":checked");
                var clipit_exp = jQuery("#clipit_exp").is(":checked");
				
                var title_qs = clipit_title ? "yes" : "";
                var trim_qs = clipit_trim ? "yes" : "";
                var desc_qs = clipit_desc ? "yes" : "";
                var sidebar_qs = clipit_sidebar ? "yes" : "";
                var img_qs = clipit_img ? "yes" : "";
                var fine_qs = clipit_fine ? "yes" : "";
                var feature_qs = clipit_feature ? "yes" : "";
                var discount_qs = clipit_discount ? "yes" : "";
                var views_qs = clipit_views ? "yes" : "";
                var comments_qs = clipit_comments ? "yes" : "";
                var exp_qs = clipit_exp ? "yes" : "";

                window.send_to_editor("[clipit_coupons columns=\"\" class=\"\" tag=\"\" post_id=\"" + clipit_id + "\" trim_desc=\"" + trim_qs +"\" show_title=\"" + title_qs +"\" show_discount=\"" + discount_qs +"\" show_fine=\"" + fine_qs +"\" show_feature=\"" + feature_qs +"\" sidebar=\"" + sidebar_qs +"\" show_img=\"" + img_qs +"\" show_views=\"" + views_qs +"\" show_exp=\"" + exp_qs +"\" show_desc=\"" + desc_qs +"\" name=\"" + clipit_name + "\"]");
            }
        </script>

        <div id="select_coupon" style="display:none;">
            <div class="wrap">
                <div>
                    <div style="padding:15px 15px 0 15px;">
                        <h3 style="color:#5A5A5A!important; font-family:Georgia,Times New Roman,Times,serif!important; font-size:1.8em!important; font-weight:normal!important;"><?php _e("Insert A Coupon", "clipit"); ?></h3>
                        <span>
                            <?php _e("Select a coupon below to add it to your post or page.", "clipit"); ?>
                        </span>
                    </div>
                    <div style="padding:15px 15px 0 15px;">
                        <select id="add_clipit_id">
                            <option value="">  <?php _e("Select a Coupon", "clipit"); ?>  </option>
							<?php
							global $post;
							$args = array(
								'numberposts' => -1,
								'post_type' => 'coupon'
							);						 
							$posts = get_posts($args);
							foreach( $posts as $post ) : setup_postdata($post); ?>
							<option value="<? echo $post->ID; ?>"><?php the_title(); ?></option>
							<?php endforeach; ?>
                        </select><br/>
                        <div style="padding:8px 0 0 0; font-size:11px; font-style:italic; color:#5A5A5A"><?php _e("Can't find your Coupon? Make sure it is not expired.", "clipit"); ?></div>
                    </div>
                    <div style="padding:15px 15px 0 15px;">
						<!-- New Fields -->
                        <input type="checkbox" id="clipit_title" /> <label for="clipit_title"><?php _e("Show Coupon Title", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_sidebar" /> <label for="clipit_sidebar"><?php _e("Enable Sidbar Style", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_desc" /> <label for="clipit_desc"><?php _e("Show Description", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_feature" /> <label for="clipit_feature"><?php _e("Show Featured Image", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_fine" /> <label for="clipit_fine"><?php _e("Show Fine Print", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_img" /> <label for="clipit_img"><?php _e("Show Image", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_trim" /> <label for="clipit_trim"><?php _e("Trim Description", "clipit"); ?></label><br />
                        <input type="checkbox" id="clipit_discount" /> <label for="clipit_discount"><?php _e("Show Discount", "clipit"); ?></label><br />
						<input type="checkbox" id="clipit_views" /> <label for="clipit_views"><?php _e("Show Coupon Views", "clipit"); ?></label><br />
						<input type="checkbox" id="clipit_exp" /> <label for="clipit_exp"><?php _e("Show Coupon Expiration", "clipit"); ?></label><br />
                    </div>
                    <div style="padding:15px;">
                        <input type="button" class="button-primary" value="<?php _e("Insert Coupons", "clipit"); ?>" onclick="InsertCoupon();"/>&nbsp;&nbsp;&nbsp;
						<a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "clipit"); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <?php

	}
?>