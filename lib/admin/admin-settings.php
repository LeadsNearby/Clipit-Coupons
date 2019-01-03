<?php
add_action("admin_menu" , "coupon_plugin_settings");
function coupon_plugin_settings() {
	add_submenu_page("edit.php?post_type=coupon", "ClipIt Coupons Settings", "Clipit Settings", "edit_themes", basename(__FILE__), "clipit_settings");
}

function clipit_settings() { global $title; ?>
	<h2><?php echo $title;?></h2>
<script>
  jQuery(document).ready(function() {
		jQuery( "#accordion" ).accordion({
			  collapsible: true,
			  active: false
		});
		jQuery( "#tabs" ).tabs(
			{
				activate:function(event, ui) { 
					var tabid = jQuery("#tabs").tabs("option","active");
					jQuery.cookie("curtab",tabid);
				}
			}
		).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        jQuery( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		var curtab = jQuery.cookie("curtab");
		if (curtab.length > 0) {
		     jQuery("#tabs").tabs({active:curtab});
        }

		jQuery('.clipit_upload_button').click(function() {
			 targetfield = jQuery(this).prev('.upload-url');
			 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			 return false;
		});
	 
		window.send_to_editor = function(html) {
			 imgurl = jQuery('img',html).attr('src');
			 jQuery(targetfield).val(imgurl);
			 tb_remove();
		}		
		
	});
</script>

<?php
$image_library_url = get_upload_iframe_src( 'image', null, 'library' );
$image_library_url = remove_query_arg( array('TB_iframe'), $image_library_url );
$image_library_url = add_query_arg( array( 'context' => 'jpg-default-image', 'TB_iframe' => 1 ), $image_library_url );
?>

<div id="tabs" class="wrap jpgadmin">
    <ul>
		<div id="theme-options-title">
			<a class="admin-logo" href="http://clipitcouponer.com/">
				<img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/admin-logo.png'; ?>">
			</a>
			<a class="admin-logo-min" href="http://clipitcouponer.com/">
				<img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/admin-logo-min.png'; ?>">
			</a>
			<div class="theme-options-text">ClipIt OPTIONS</div>
		</div>	
		<li id="tab1"><a href="#tabs-1"><div class="admin-tools-icon icon"></div><div class="admin-tabs-link">General Settings</div></a><div class="help">General</div></li>
		<li id="tab2"><a href="#tabs-2"><div class="admin-style-icon icon"></div><div class="admin-tabs-link">Styling Options</div></a><div class="help">Styling</div></li>
		<li id="tab3"><a href="#tabs-3"><div class="admin-typography-icon icon"></div><div class="admin-tabs-link">Typography Options</div></a><div class="help">Typography</div></li>
		<li id="tab4"><a href="#tabs-4"><div class="admin-style-icon icon"></div><div class="admin-tabs-link">Custom CSS</div></a><div class="help">CSS</div></li>
    </ul>	
    <div id="tabs-1" class="right-col">	
		<form method="post" action="">
		<fieldset>
			<div class="admin-page-title">
				<?php esc_html_e('General Settings'); ?>
			</div>
			<div class="save-top">
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
					<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
				</p>	
				<p class="submit">
					<input type="button" name="Submit" class="button-primary reset" value="Reset" />
				</p>
			</div>
			<div class="clear"></div>
			<hr>
				<table class="form-table">
				<tr>
					<td>
						<div class="section-header"><?php esc_html_e('General Settings'); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="beta_coupon_display"><?php esc_html_e('Use Beta Coupon Layout'); ?></label><br />					
						<input type="checkbox" name="beta_coupon_display" id="beta_coupon_display" class="col-input text-style" style="font-size:11px;" <?php if(get_option('clipit_beta_coupon_display', true) === 'on') { echo 'checked' ;} ?> />
					</td>
				</tr>
				<tr>
					<td>
						<label for="expired_coupon_text"><?php esc_html_e('Expired Coupon Text'); ?></label><br />
						<em><?php esc_html_e('Expired Coupon Texr. You can use HTML for links etc.'); ?></em><br/>					
						<textarea name="expired_coupon_text" id="expired_coupon_text" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_expired_coupon_text')); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label for="rules_default"><?php esc_html_e('The Rules Default content'); ?></label><br />
						<em><?php esc_html_e('Default Coupon Rules. You can use HTML for links etc.'); ?></em><br/>					
						<textarea name="rules_default" id="rules_default" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_rules_default')); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label for="fineprint_default"><?php esc_html_e('The Fine Print Default content'); ?></label><br />
						<em><?php esc_html_e('Default Fine Print Rules. You can use HTML for links etc.'); ?></em><br />					
						<textarea name="fineprint_default" id="fineprint_default" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_fineprint_default')); ?></textarea>
					</td>
				</tr>				
				<tr>
					<td>
						<div class="section-header"><?php esc_html_e('Email Settings'); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<p><label for="customer-logo">Logo</label><br />
						<em>Enter in the URL of your logo.</em><br />
						<input class="upload_image wp-media-buttons" id="customer_logo" type="text" name="customer_logo" size="70" value="<?php echo get_option('clipit_customer_logo'); ?>" /> 
						<span class="wp-media-buttons"><a title="Add Media" data-editor="customer_logo" class="button upload_coupon_button add_media" href="#"><span class="wp-media-buttons-icon"></span> Add Media</a></span><span class="wp-media-remove"><a title="Remove Media" data-editor="removal" class="button remove_image_button remove_media" href="#"><span class="wp-media-buttons-icon"></span> Remove</a></span></p>				
					</td>
				</tr>
				<tr>
					<td>
						<div class="form_element">
							<img class="loadit" src="<?php echo get_option('clipit_customer_logo'); ?>" />
						</div>
					</td>
				</tr>				
				<tr>
					<td>
						<label for="email_claim_address"><?php esc_html_e('Email to Claim Coupon'); ?></label><br />
						<em><?php esc_html_e('Enter the contact email address to receive notifications of when someone enters their contact information to claim a coupon.<br /> Got multiple email addresses? Separate each with a comma and space i.e., test@test.com, test@test.com'); ?></em><br />					
						<input name="email_claim_address" type="text" id="email_claim_address" class="col-input body-style" value="<?php echo get_option('clipit_email_claim_address'); ?>" class="regular-text" />
					</td>
				</tr>	
			</table>
			</fieldset>
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
				<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
			</p>	
			<p class="submit">
				<input type="button" name="Submit" class="button-primary reset" value="Reset" />
			</p>
	</div>
	<div id="tabs-2" class="right-col">
		<fieldset>
			<div class="admin-page-title"><?php esc_html_e('Styling Options'); ?></div>
			<div class="save-top">
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
					<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
				</p>	
				<p class="submit">
					<input type="button" name="Submit" class="button-primary reset" value="Reset" />
				</p>
			</div>
			<div class="clear"></div>
				<hr>
				<table class="form-table">
				<tr>
					<td>
						<div class="section-header"><?php esc_html_e('BACKGROUND COLORS'); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="border_color"><?php esc_html_e('Coupon Border Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your coupon border background. Leave blank if you want to use default colors.'); ?></em><br />					
						<input type="text" name="border_color" class="hexcolor" value="<?php echo get_option('clipit_border_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="content_bkgd_color"><?php esc_html_e('Coupon Content Background Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your coupon content background. Leave blank if you want to use default colors.'); ?></em><br />					
						<input type="text" name="content_bkgd_color" class="hexcolor" value="<?php echo get_option('clipit_content_bkgd_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="highlight_bkgd_color"><?php esc_html_e('Coupon Highlight Background Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your coupon highlighter. Leave blank if you want to use default colors.'); ?></em><br />					
						<input type="text" name="highlight_bkgd_color" class="hexcolor" value="<?php echo get_option('clipit_highlight_bkgd_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="featured_img_color"><?php esc_html_e('Featured Image Frame Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your featured image frame color. Leave blank if you want to use default colors.'); ?></em><br />			
						<input type="text" name="featured_img_color" class="hexcolor" value="<?php echo get_option('clipit_featured_img_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="featured_img_border_color"><?php esc_html_e('Featured Image border Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your featured image border. Leave blank if you want to use default colors.'); ?></em><br />			
						<input type="text" name="featured_img_border_color" class="hexcolor" value="<?php echo get_option('clipit_featured_img_border_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="section-header"><?php esc_html_e('FONT COLORS'); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="title_color"><?php esc_html_e('Coupon Title Text Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your coupon title. Leave blank if you want to use default colors.'); ?></em><br />			
						<input type="text" name="title_color" class="hexcolor" value="<?php echo get_option('clipit_title_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="expiration_color"><?php esc_html_e('Coupon Highlight Text Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your highlight text. Leave blank if you want to use default colors.'); ?></em><br />			
						<input type="text" name="expiration_color" class="hexcolor" value="<?php echo get_option('clipit_expiration_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="description_color"><?php esc_html_e('Description Text Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your description text. Leave blank if you want to use default colors.'); ?></em><br />			
						<input type="text" name="description_color" class="hexcolor" value="<?php echo get_option('clipit_description_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="fineprint_color"><?php esc_html_e('Fine Print Text Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your fine print text. Leave blank if you want to use default colors.'); ?></em><br />			
						<input type="text" name="fineprint_color" class="hexcolor" value="<?php echo get_option('clipit_fineprint_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="promo_text_color"><?php esc_html_e('Promo Font Color'); ?></label><br />
						<em><?php esc_html_e('Enter the color for your promo text. Leave blank if you want to use default colors.'); ?></em><br />					
						<input type="text" name="promo_text_color" class="hexcolor" value="<?php echo get_option('clipit_promo_text_color'); ?>" />
						<input type='button' class='pickcolor button-secondary' value='Select Color'>
						<div class='colorpicker' style='z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;'></div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="section-header">Coupon Banner Options</div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="coupon_banner_enable"><?php _e( 'Enable Coupon Banner', 'inputname' ); ?></label><br />
						<em>Click to enable Coupon Banner Feature</em>
						<input id="coupon_banner_enable" name="coupon_banner_enable" type="checkbox" value="1" <?php checked( '1', get_option( 'clipit_coupon_banner_enable' ) ); ?> />
					</td>
				</tr>
				<tr>
					<td>
						<p><label for="coupon_banner_image">Coupon Banner Image</label><br />
						<em>Enter in the URL of your coupon banner here. If one is not supplied, Clipit will use the default image.</em><br />
						<input class="upload_image wp-media-buttons" id="coupon_banner_image" type="text" name="coupon_banner_image" size="70" value="<?php echo get_option('clipit_coupon_banner_image'); ?>" /> 
						<span class="wp-media-buttons"><a title="Add Media" data-editor="coupon_banner_image" class="button upload_coupon_button add_media" href="#"><span class="wp-media-buttons-icon"></span> Add Media</a></span></p>				
					</td>
				</tr>
				<tr>
					<td>
						<div class="form_element">
							<img class="loadit" src="<?php echo get_option('clipit_coupon_banner_image'); ?>" />
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="coupon_banner_width"><?php esc_html_e('Banner image width (px)'); ?></label><br />
						<em><?php esc_html_e('Enter the width of your custom coupon banner image in pixels'); ?></em><br />					
						<input placeholder="200px" name="coupon_banner_width" type="text" id="coupon_banner_width" class="col-input body-style" value="<?php echo get_option('clipit_coupon_banner_width'); ?>" class="regular-text" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="coupon_banner_height"><?php esc_html_e('Banner image height (px)'); ?></label><br />
						<em><?php esc_html_e('Enter the height of your custom coupon banner image in pixels'); ?></em><br />							
						<input placeholder="60px" name="coupon_banner_height" type="text" id="coupon_banner_height" class="col-input body-style" value="<?php echo get_option('clipit_coupon_banner_height'); ?>" class="regular-text" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="coupon_banner_position"><?php esc_html_e('Coupon Banner Position'); ?></label><br />
						<em><?php esc_html_e('Select a font family for print coupon button'); ?></em><br />					
						<select class="col-input body-style" name="coupon_banner_position" id="coupon_banner_position">
							<option value="right" <?php if(get_option('clipit_coupon_banner_position') == 'right'){?>selected="selected"<?php }?>>Right</option>
							<option value="left" <?php if(get_option('clipit_coupon_banner_position') == 'left'){?>selected="selected"<?php }?>>Left</option>								
						</select>
					</td>
				</tr>						
				<tr>
					<td>
						<label for="coupon_banner_link"><?php esc_html_e('Banner image link'); ?></label><br />
						<em><?php esc_html_e('Enter the url where you would like the coupon banner to link to. Hint: This is normally the main coupon page.'); ?></em><br />							
						<input placeholder="<?php echo get_bloginfo('url'); ?>" name="coupon_banner_link" type="text" id="coupon_banner_link" class="col-input body-style" value="<?php echo get_option('clipit_coupon_banner_link'); ?>" class="regular-text" />
					</td>
				</tr>
			</table>
		</fieldset>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
			<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
		</p>
		<p class="submit">
			<input type="button" name="Submit" class="button-primary reset" value="Reset" />
		</p>			
	</div>					
	<div id="tabs-3" class="right-col">	
		<fieldset>
		<div class="admin-page-title"><?php esc_html_e('Typography Options'); ?></div>
		<div class="save-top">
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
					<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
				</p>	
				<p class="submit">
					<input type="button" name="Submit" class="button-primary reset" value="Reset" />
				</p>
			</div>
			<div class="clear"></div>
			<hr>
			<table class="form-table">
			<tr>
				<td>
					<div class="section-header"><?php esc_html_e('STANDARD FONTS'); ?></div>
				</td>
			</tr>
			<tr>
				<td>
					<label for="general_font_family"><?php esc_html_e('General Font Family'); ?></label><br />
					<em><?php esc_html_e('Select a general font family'); ?></em><br />					
					<div class="text-demo"><legend>font demo</legend><div id="fontdemo" style="font-family:<?php echo get_option('clipit_general_font_family'); ?>">The quick brown fox jumps over the lazy dog</div></div>
				</td>
			</tr>
			<tr>
				<td>					
					<select class="col-input body-style" name="general_font_family" id="general_font_family" onchange="this.form.submit();"> 
						<option value="Inherit" <?php if(get_option('clipit_general_font_family') == 'Inherit'){?>selected="selected"<?php }?>>Inherit</option>
						<option value="Arial" <?php if(get_option('clipit_general_font_family') == 'Arial'){?>selected="selected"<?php }?>>Arial</option>		
						<option value="Arial Narrow" <?php if(get_option('clipit_general_font_family') == 'Arial Narrow'){?>selected="selected"<?php }?>>Arial Narrow</option>
						<option value="Arial Rounded MT Bold" <?php if(get_option('clipit_general_font_family') == 'Arial Rounded MT Bold'){?>selected="selected"<?php }?>>Arial Rounded MT Bold</option>
						<option value="Book Antiqua" <?php if(get_option('clipit_general_font_family') == 'Book Antiqua'){?>selected="selected"<?php }?>>Book Antiqua</option>
						<option value="Bookman Old Style" <?php if(get_option('clipit_general_font_family') == 'Bookman Old Style'){?>selected="selected"<?php }?>>Bookman Old Style</option>
						<option value="Bradley Hand ITC TT" <?php if(get_option('clipit_general_font_family') == 'Bradley Hand ITC TT'){?>selected="selected"<?php }?>>Bradley Hand ITC TT</option>
						<option value="Century Gothic" <?php if(get_option('clipit_general_font_family') == 'Century Gothic'){?>selected="selected"<?php }?>>Century Gothic</option>
						<option value="Comic Sans MS" <?php if(get_option('clipit_general_font_family') == 'Comic Sans MS'){?>selected="selected"<?php }?>>Comic Sans MS</option>
						<option value="Courier New" <?php if(get_option('clipit_general_font_family') == 'Courier New'){?>selected="selected"<?php }?>>Courier New</option>
						<option value="Economica" <?php if(get_option('clipit_general_font_family') == 'Economica'){?>selected="selected"<?php }?>>Economica</option>
						<option value="Fjalla One" <?php if(get_option('clipit_general_font_family') == 'Fjalla One'){?>selected="selected"<?php }?>>Fjalla One</option>
						<option value="Franklin Gothic Medium" <?php if(get_option('clipit_general_font_family') == 'Franklin Gothic Medium'){?>selected="selected"<?php }?>>Franklin Gothic Medium</option>
						<option value="Garamond" <?php if(get_option('clipit_general_font_family') == 'Garamond'){?>selected="selected"<?php }?>>Garamond</option>
						<option value="Georgia" <?php if(get_option('clipit_general_font_family') == 'Georgia'){?>selected="selected"<?php }?>>Georgia</option>
						<option value="haettenschweiler" <?php if(get_option('clipit_general_font_family') == 'haettenschweiler'){?>selected="selected"<?php }?>>haettenschweiler</option>
						<option value="Impact" <?php if(get_option('clipit_general_font_family') == 'Impact'){?>selected="selected"<?php }?>>Impact</option>
						<option value="Lucida Bright" <?php if(get_option('clipit_general_font_family') == 'Lucida Bright'){?>selected="selected"<?php }?>>Lucida Bright</option>
						<option value="lucida calligraphy" <?php if(get_option('clipit_general_font_family') == 'lucida calligraphy'){?>selected="selected"<?php }?>>Lucida Calligraphy</option>
						<option value="Lucida Console" <?php if(get_option('clipit_general_font_family') == 'Lucida Console'){?>selected="selected"<?php }?>>Lucida Console</option>
						<option value="Lucida Sans" <?php if(get_option('clipit_general_font_family') == 'Lucida Sans'){?>selected="selected"<?php }?>>Lucida Sans</option>
						<option value="Lucida Sans Typewriter" <?php if(get_option('clipit_general_font_family') == 'Lucida Sans Typewriter'){?>selected="selected"<?php }?>>Lucida Sans Typewriter</option>
						<option value="Lucida Sans Unicode" <?php if(get_option('clipit_general_font_family') == 'Lucida Sans Unicode'){?>selected="selected"<?php }?>>Lucida Sans Unicode</option>
						<option value="Mistral" <?php if(get_option('clipit_general_font_family') == 'Mistral'){?>selected="selected"<?php }?>>Mistral</option>
						<option value="MS Mincho" <?php if(get_option('clipit_general_font_family') == 'MS Mincho'){?>selected="selected"<?php }?>>MS Mincho</option>
						<option value="Onyx" <?php if(get_option('clipit_general_font_family') == 'Onyx'){?>selected="selected"<?php }?>>Onyx</option>
						<option value="Papyrus" <?php if(get_option('clipit_general_font_family') == 'Papyrus'){?>selected="selected"<?php }?>>Papyrus</option>
						<option value="Perpetua" <?php if(get_option('clipit_general_font_family') == 'Perpetua'){?>selected="selected"<?php }?>>Perpetua</option>
						<option value="perpetua titling mt" <?php if(get_option('clipit_general_font_family') == 'perpetua titling mt'){?>selected="selected"<?php }?>>Perpetua Titling MT</option>
						<option value="Playbill" <?php if(get_option('clipit_general_font_family') == 'Playbill'){?>selected="selected"<?php }?>>Playbill</option>
						<option value="Rancho" <?php if(get_option('clipit_general_font_family') == 'Rancho'){?>selected="selected"<?php }?>>Rancho</option>
						<option value="Rockwell" <?php if(get_option('clipit_general_font_family') == 'Rockwell'){?>selected="selected"<?php }?>>Rockwell</option>
						<option value="Rockwell Extra Bold" <?php if(get_option('clipit_general_font_family') == 'Rockwell Extra Bold'){?>selected="selected"<?php }?>>Rockwell Extra Bold</option>
						<option value="Stencil" <?php if(get_option('clipit_general_font_family') == 'Stencil'){?>selected="selected"<?php }?>>Stencil</option>
						<option value="Tamoha" <?php if(get_option('clipit_general_font_family') == 'Tamoha'){?>selected="selected"<?php }?>>Tamoha</option>
						<option value="Times New Roman" <?php if(get_option('clipit_general_font_family') == 'Times New Roman'){?>selected="selected"<?php }?>>Times New Roman</option>
						<option value="Trebuchet MS" <?php if(get_option('clipit_general_font_family') == 'Trebuchet MS'){?>selected="selected"<?php }?>>Trebuchet MS</option>
						<option value="Tw Cen MT" <?php if(get_option('clipit_general_font_family') == 'Tw Cen MT'){?>selected="selected"<?php }?>>Tw Cen MT</option>
						<option value="Verdana" <?php if(get_option('clipit_general_font_family') == 'Verdana'){?>selected="selected"<?php }?>>Verdana</option>
						<option value="Wide Latin" <?php if(get_option('clipit_general_font_family') == 'Wide Latin'){?>selected="selected"<?php }?>>Wide Latin</option>								
					</select>
				</td>
			</tr>			
			<tr>
				<td>
					<label for="title_font_family"><?php esc_html_e('Title Font Family'); ?></label><br />
					<em><?php esc_html_e('Select a font family for the coupon title'); ?></em><br />					
					<div class="text-demo"><legend>font demo</legend><div id="fontdemo" style="font-family:<?php echo get_option('clipit_title_font_family'); ?>">The quick brown fox jumps over the lazy dog</div></div>
				</td>
			</tr>
			<tr>
				<td>					
					<select class="col-input body-style" name="title_font_family" id="title_font_family" onchange="this.form.submit();"> 
						<option value="Inherit" <?php if(get_option('clipit_title_font_family') == 'Inherit'){?>selected="selected"<?php }?>>Inherit</option>
						<option value="Arial" <?php if(get_option('clipit_title_font_family') == 'Arial'){?>selected="selected"<?php }?>>Arial</option>		
						<option value="Arial Narrow" <?php if(get_option('clipit_title_font_family') == 'Arial Narrow'){?>selected="selected"<?php }?>>Arial Narrow</option>
						<option value="Arial Rounded MT Bold" <?php if(get_option('clipit_title_font_family') == 'Arial Rounded MT Bold'){?>selected="selected"<?php }?>>Arial Rounded MT Bold</option>
						<option value="Book Antiqua" <?php if(get_option('clipit_title_font_family') == 'Book Antiqua'){?>selected="selected"<?php }?>>Book Antiqua</option>
						<option value="Bookman Old Style" <?php if(get_option('clipit_title_font_family') == 'Bookman Old Style'){?>selected="selected"<?php }?>>Bookman Old Style</option>
						<option value="Bradley Hand ITC TT" <?php if(get_option('clipit_title_font_family') == 'Bradley Hand ITC TT'){?>selected="selected"<?php }?>>Bradley Hand ITC TT</option>
						<option value="Century Gothic" <?php if(get_option('clipit_title_font_family') == 'Century Gothic'){?>selected="selected"<?php }?>>Century Gothic</option>
						<option value="Comic Sans MS" <?php if(get_option('clipit_title_font_family') == 'Comic Sans MS'){?>selected="selected"<?php }?>>Comic Sans MS</option>
						<option value="Courier New" <?php if(get_option('clipit_title_font_family') == 'Courier New'){?>selected="selected"<?php }?>>Courier New</option>
						<option value="Economica" <?php if(get_option('clipit_title_font_family') == 'Economica'){?>selected="selected"<?php }?>>Economica</option>
						<option value="Fjalla One" <?php if(get_option('clipit_title_font_family') == 'Fjalla One'){?>selected="selected"<?php }?>>Fjalla One</option>
						<option value="Franklin Gothic Medium" <?php if(get_option('clipit_title_font_family') == 'Franklin Gothic Medium'){?>selected="selected"<?php }?>>Franklin Gothic Medium</option>
						<option value="Garamond" <?php if(get_option('clipit_title_font_family') == 'Garamond'){?>selected="selected"<?php }?>>Garamond</option>
						<option value="Georgia" <?php if(get_option('clipit_title_font_family') == 'Georgia'){?>selected="selected"<?php }?>>Georgia</option>
						<option value="haettenschweiler" <?php if(get_option('clipit_title_font_family') == 'haettenschweiler'){?>selected="selected"<?php }?>>haettenschweiler</option>
						<option value="Impact" <?php if(get_option('clipit_title_font_family') == 'Impact'){?>selected="selected"<?php }?>>Impact</option>
						<option value="Lucida Bright" <?php if(get_option('clipit_title_font_family') == 'Lucida Bright'){?>selected="selected"<?php }?>>Lucida Bright</option>
						<option value="lucida calligraphy" <?php if(get_option('clipit_title_font_family') == 'lucida calligraphy'){?>selected="selected"<?php }?>>Lucida Calligraphy</option>
						<option value="Lucida Console" <?php if(get_option('clipit_title_font_family') == 'Lucida Console'){?>selected="selected"<?php }?>>Lucida Console</option>
						<option value="Lucida Sans" <?php if(get_option('clipit_title_font_family') == 'Lucida Sans'){?>selected="selected"<?php }?>>Lucida Sans</option>
						<option value="Lucida Sans Typewriter" <?php if(get_option('clipit_title_font_family') == 'Lucida Sans Typewriter'){?>selected="selected"<?php }?>>Lucida Sans Typewriter</option>
						<option value="Lucida Sans Unicode" <?php if(get_option('clipit_title_font_family') == 'Lucida Sans Unicode'){?>selected="selected"<?php }?>>Lucida Sans Unicode</option>
						<option value="Mistral" <?php if(get_option('clipit_title_font_family') == 'Mistral'){?>selected="selected"<?php }?>>Mistral</option>
						<option value="MS Mincho" <?php if(get_option('clipit_title_font_family') == 'MS Mincho'){?>selected="selected"<?php }?>>MS Mincho</option>
						<option value="Onyx" <?php if(get_option('clipit_title_font_family') == 'Onyx'){?>selected="selected"<?php }?>>Onyx</option>
						<option value="Papyrus" <?php if(get_option('clipit_title_font_family') == 'Papyrus'){?>selected="selected"<?php }?>>Papyrus</option>
						<option value="Perpetua" <?php if(get_option('clipit_title_font_family') == 'Perpetua'){?>selected="selected"<?php }?>>Perpetua</option>
						<option value="perpetua titling mt" <?php if(get_option('clipit_title_font_family') == 'perpetua titling mt'){?>selected="selected"<?php }?>>Perpetua Titling MT</option>
						<option value="Playbill" <?php if(get_option('clipit_title_font_family') == 'Playbill'){?>selected="selected"<?php }?>>Playbill</option>
						<option value="Rancho" <?php if(get_option('clipit_title_font_family') == 'Rancho'){?>selected="selected"<?php }?>>Rancho</option>
						<option value="Rockwell" <?php if(get_option('clipit_title_font_family') == 'Rockwell'){?>selected="selected"<?php }?>>Rockwell</option>
						<option value="Rockwell Extra Bold" <?php if(get_option('clipit_title_font_family') == 'Rockwell Extra Bold'){?>selected="selected"<?php }?>>Rockwell Extra Bold</option>
						<option value="Stencil" <?php if(get_option('clipit_title_font_family') == 'Stencil'){?>selected="selected"<?php }?>>Stencil</option>
						<option value="Tamoha" <?php if(get_option('clipit_title_font_family') == 'Tamoha'){?>selected="selected"<?php }?>>Tamoha</option>
						<option value="Times New Roman" <?php if(get_option('clipit_title_font_family') == 'Times New Roman'){?>selected="selected"<?php }?>>Times New Roman</option>
						<option value="Trebuchet MS" <?php if(get_option('clipit_title_font_family') == 'Trebuchet MS'){?>selected="selected"<?php }?>>Trebuchet MS</option>
						<option value="Tw Cen MT" <?php if(get_option('clipit_title_font_family') == 'Tw Cen MT'){?>selected="selected"<?php }?>>Tw Cen MT</option>
						<option value="Verdana" <?php if(get_option('clipit_title_font_family') == 'Verdana'){?>selected="selected"<?php }?>>Verdana</option>
						<option value="Wide Latin" <?php if(get_option('clipit_title_font_family') == 'Wide Latin'){?>selected="selected"<?php }?>>Wide Latin</option>								
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="expiration_font_family"><?php esc_html_e('Expiration Font Family'); ?></label><br />
					<em><?php esc_html_e('Select a font family for the coupon expiration'); ?></em><br />					
					<div class="text-demo"><legend>font demo</legend><div id="fontdemo" style="font-family:<?php echo get_option('clipit_expiration_font_family'); ?>">The quick brown fox jumps over the lazy dog</div></div>
				</td>
			</tr>
			<tr>
				<td>					
					<select class="col-input body-style" name="expiration_font_family" id="expiration_font_family" onchange="this.form.submit();">
						<option value="Inherit" <?php if(get_option('clipit_expiration_font_family') == 'inherit'){?>selected="selected"<?php }?>>Inherit</option>
						<option value="Arial" <?php if(get_option('clipit_expiration_font_family') == 'Arial'){?>selected="selected"<?php }?>>Arial</option>		
						<option value="Arial Narrow" <?php if(get_option('clipit_expiration_font_family') == 'Arial Narrow'){?>selected="selected"<?php }?>>Arial Narrow</option>
						<option value="Arial Rounded MT Bold" <?php if(get_option('clipit_expiration_font_family') == 'Arial Rounded MT Bold'){?>selected="selected"<?php }?>>Arial Rounded MT Bold</option>
						<option value="Book Antiqua" <?php if(get_option('clipit_expiration_font_family') == 'Book Antiqua'){?>selected="selected"<?php }?>>Book Antiqua</option>
						<option value="Bookman Old Style" <?php if(get_option('clipit_expiration_font_family') == 'Bookman Old Style'){?>selected="selected"<?php }?>>Bookman Old Style</option>
						<option value="Bradley Hand ITC TT" <?php if(get_option('clipit_expiration_font_family') == 'Bradley Hand ITC TT'){?>selected="selected"<?php }?>>Bradley Hand ITC TT</option>
						<option value="Century Gothic" <?php if(get_option('clipit_expiration_font_family') == 'Century Gothic'){?>selected="selected"<?php }?>>Century Gothic</option>
						<option value="Comic Sans MS" <?php if(get_option('clipit_expiration_font_family') == 'Comic Sans MS'){?>selected="selected"<?php }?>>Comic Sans MS</option>
						<option value="Courier New" <?php if(get_option('clipit_expiration_font_family') == 'Courier New'){?>selected="selected"<?php }?>>Courier New</option>
						<option value="Economica" <?php if(get_option('clipit_expiration_font_family') == 'Economica'){?>selected="selected"<?php }?>>Economica</option>
						<option value="Fjalla One" <?php if(get_option('clipit_expiration_font_family') == 'Fjalla One'){?>selected="selected"<?php }?>>Fjalla One</option>
						<option value="Franklin Gothic Medium" <?php if(get_option('clipit_expiration_font_family') == 'Franklin Gothic Medium'){?>selected="selected"<?php }?>>Franklin Gothic Medium</option>
						<option value="Garamond" <?php if(get_option('clipit_expiration_font_family') == 'Garamond'){?>selected="selected"<?php }?>>Garamond</option>
						<option value="Georgia" <?php if(get_option('clipit_expiration_font_family') == 'Georgia'){?>selected="selected"<?php }?>>Georgia</option>
						<option value="haettenschweiler" <?php if(get_option('clipit_expiration_font_family') == 'haettenschweiler'){?>selected="selected"<?php }?>>haettenschweiler</option>
						<option value="Impact" <?php if(get_option('clipit_expiration_font_family') == 'Impact'){?>selected="selected"<?php }?>>Impact</option>
						<option value="Lucida Bright" <?php if(get_option('clipit_expiration_font_family') == 'Lucida Bright'){?>selected="selected"<?php }?>>Lucida Bright</option>
						<option value="lucida calligraphy" <?php if(get_option('clipit_expiration_font_family') == 'lucida calligraphy'){?>selected="selected"<?php }?>>Lucida Calligraphy</option>
						<option value="Lucida Console" <?php if(get_option('clipit_expiration_font_family') == 'Lucida Console'){?>selected="selected"<?php }?>>Lucida Console</option>
						<option value="Lucida Sans" <?php if(get_option('clipit_expiration_font_family') == 'Lucida Sans'){?>selected="selected"<?php }?>>Lucida Sans</option>
						<option value="Lucida Sans Typewriter" <?php if(get_option('clipit_expiration_font_family') == 'Lucida Sans Typewriter'){?>selected="selected"<?php }?>>Lucida Sans Typewriter</option>
						<option value="Lucida Sans Unicode" <?php if(get_option('clipit_expiration_font_family') == 'Lucida Sans Unicode'){?>selected="selected"<?php }?>>Lucida Sans Unicode</option>
						<option value="Mistral" <?php if(get_option('clipit_expiration_font_family') == 'Mistral'){?>selected="selected"<?php }?>>Mistral</option>
						<option value="MS Mincho" <?php if(get_option('clipit_expiration_font_family') == 'MS Mincho'){?>selected="selected"<?php }?>>MS Mincho</option>
						<option value="Onyx" <?php if(get_option('clipit_expiration_font_family') == 'Onyx'){?>selected="selected"<?php }?>>Onyx</option>
						<option value="Papyrus" <?php if(get_option('clipit_expiration_font_family') == 'Papyrus'){?>selected="selected"<?php }?>>Papyrus</option>
						<option value="Perpetua" <?php if(get_option('clipit_expiration_font_family') == 'Perpetua'){?>selected="selected"<?php }?>>Perpetua</option>
						<option value="perpetua titling mt" <?php if(get_option('clipit_expiration_font_family') == 'perpetua titling mt'){?>selected="selected"<?php }?>>Perpetua Titling MT</option>
						<option value="Playbill" <?php if(get_option('clipit_expiration_font_family') == 'Playbill'){?>selected="selected"<?php }?>>Playbill</option>
						<option value="Rancho" <?php if(get_option('clipit_expiration_font_family') == 'Rancho'){?>selected="selected"<?php }?>>Rancho</option>
						<option value="Rockwell" <?php if(get_option('clipit_expiration_font_family') == 'Rockwell'){?>selected="selected"<?php }?>>Rockwell</option>
						<option value="Rockwell Extra Bold" <?php if(get_option('clipit_expiration_font_family') == 'Rockwell Extra Bold'){?>selected="selected"<?php }?>>Rockwell Extra Bold</option>
						<option value="Stencil" <?php if(get_option('clipit_expiration_font_family') == 'Stencil'){?>selected="selected"<?php }?>>Stencil</option>
						<option value="Tamoha" <?php if(get_option('clipit_expiration_font_family') == 'Tamoha'){?>selected="selected"<?php }?>>Tamoha</option>
						<option value="Times New Roman" <?php if(get_option('clipit_expiration_font_family') == 'Times New Roman'){?>selected="selected"<?php }?>>Times New Roman</option>
						<option value="Trebuchet MS" <?php if(get_option('clipit_expiration_font_family') == 'Trebuchet MS'){?>selected="selected"<?php }?>>Trebuchet MS</option>
						<option value="Tw Cen MT" <?php if(get_option('clipit_expiration_font_family') == 'Tw Cen MT'){?>selected="selected"<?php }?>>Tw Cen MT</option>
						<option value="Verdana" <?php if(get_option('clipit_expiration_font_family') == 'Verdana'){?>selected="selected"<?php }?>>Verdana</option>
						<option value="Wide Latin" <?php if(get_option('clipit_expiration_font_family') == 'Wide Latin'){?>selected="selected"<?php }?>>Wide Latin</option>								
					</select>
				</td>
			</tr>	
			<tr>
				<td>
					<label for="description_font_family"><?php esc_html_e('Coupon Description Font Family'); ?></label><br />
					<em><?php esc_html_e('Select a font family for coupon description'); ?></em><br />					
					<div class="text-demo"><legend>font demo</legend><div id="fontdemo" style="font-family:<?php echo get_option('clipit_description_font_family'); ?>">The quick brown fox jumps over the lazy dog</div></div>
				</td>
			</tr>
			<tr>
				<td>					
					<select class="col-input body-style" name="description_font_family" id="description_font_family" onchange="this.form.submit();">
						<option value="Inherit" <?php if(get_option('clipit_description_font_family') == 'inherit'){?>selected="selected"<?php }?>>Inherit</option>
						<option value="Arial" <?php if(get_option('clipit_description_font_family') == 'Arial'){?>selected="selected"<?php }?>>Arial</option>		
						<option value="Arial Narrow" <?php if(get_option('clipit_description_font_family') == 'Arial Narrow'){?>selected="selected"<?php }?>>Arial Narrow</option>
						<option value="Arial Rounded MT Bold" <?php if(get_option('clipit_description_font_family') == 'Arial Rounded MT Bold'){?>selected="selected"<?php }?>>Arial Rounded MT Bold</option>
						<option value="Book Antiqua" <?php if(get_option('clipit_description_font_family') == 'Book Antiqua'){?>selected="selected"<?php }?>>Book Antiqua</option>
						<option value="Bookman Old Style" <?php if(get_option('clipit_description_font_family') == 'Bookman Old Style'){?>selected="selected"<?php }?>>Bookman Old Style</option>
						<option value="Bradley Hand ITC TT" <?php if(get_option('clipit_description_font_family') == 'Bradley Hand ITC TT'){?>selected="selected"<?php }?>>Bradley Hand ITC TT</option>
						<option value="Century Gothic" <?php if(get_option('clipit_description_font_family') == 'Century Gothic'){?>selected="selected"<?php }?>>Century Gothic</option>
						<option value="Comic Sans MS" <?php if(get_option('clipit_description_font_family') == 'Comic Sans MS'){?>selected="selected"<?php }?>>Comic Sans MS</option>
						<option value="Courier New" <?php if(get_option('clipit_description_font_family') == 'Courier New'){?>selected="selected"<?php }?>>Courier New</option>
						<option value="Economica" <?php if(get_option('clipit_description_font_family') == 'Economica'){?>selected="selected"<?php }?>>Economica</option>
						<option value="Fjalla One" <?php if(get_option('clipit_description_font_family') == 'Fjalla One'){?>selected="selected"<?php }?>>Fjalla One</option>
						<option value="Franklin Gothic Medium" <?php if(get_option('clipit_description_font_family') == 'Franklin Gothic Medium'){?>selected="selected"<?php }?>>Franklin Gothic Medium</option>
						<option value="Garamond" <?php if(get_option('clipit_description_font_family') == 'Garamond'){?>selected="selected"<?php }?>>Garamond</option>
						<option value="Georgia" <?php if(get_option('clipit_description_font_family') == 'Georgia'){?>selected="selected"<?php }?>>Georgia</option>
						<option value="haettenschweiler" <?php if(get_option('clipit_description_font_family') == 'haettenschweiler'){?>selected="selected"<?php }?>>haettenschweiler</option>
						<option value="Impact" <?php if(get_option('clipit_description_font_family') == 'Impact'){?>selected="selected"<?php }?>>Impact</option>
						<option value="Lucida Bright" <?php if(get_option('clipit_description_font_family') == 'Lucida Bright'){?>selected="selected"<?php }?>>Lucida Bright</option>
						<option value="lucida calligraphy" <?php if(get_option('clipit_description_font_family') == 'lucida calligraphy'){?>selected="selected"<?php }?>>Lucida Calligraphy</option>
						<option value="Lucida Console" <?php if(get_option('clipit_description_font_family') == 'Lucida Console'){?>selected="selected"<?php }?>>Lucida Console</option>
						<option value="Lucida Sans" <?php if(get_option('clipit_description_font_family') == 'Lucida Sans'){?>selected="selected"<?php }?>>Lucida Sans</option>
						<option value="Lucida Sans Typewriter" <?php if(get_option('clipit_description_font_family') == 'Lucida Sans Typewriter'){?>selected="selected"<?php }?>>Lucida Sans Typewriter</option>
						<option value="Lucida Sans Unicode" <?php if(get_option('clipit_description_font_family') == 'Lucida Sans Unicode'){?>selected="selected"<?php }?>>Lucida Sans Unicode</option>
						<option value="Mistral" <?php if(get_option('clipit_description_font_family') == 'Mistral'){?>selected="selected"<?php }?>>Mistral</option>
						<option value="MS Mincho" <?php if(get_option('clipit_description_font_family') == 'MS Mincho'){?>selected="selected"<?php }?>>MS Mincho</option>
						<option value="Onyx" <?php if(get_option('clipit_description_font_family') == 'Onyx'){?>selected="selected"<?php }?>>Onyx</option>
						<option value="Papyrus" <?php if(get_option('clipit_description_font_family') == 'Papyrus'){?>selected="selected"<?php }?>>Papyrus</option>
						<option value="Perpetua" <?php if(get_option('clipit_description_font_family') == 'Perpetua'){?>selected="selected"<?php }?>>Perpetua</option>
						<option value="perpetua titling mt" <?php if(get_option('clipit_description_font_family') == 'perpetua titling mt'){?>selected="selected"<?php }?>>Perpetua Titling MT</option>
						<option value="Playbill" <?php if(get_option('clipit_description_font_family') == 'Playbill'){?>selected="selected"<?php }?>>Playbill</option>
						<option value="Rancho" <?php if(get_option('clipit_description_font_family') == 'Rancho'){?>selected="selected"<?php }?>>Rancho</option>
						<option value="Rockwell" <?php if(get_option('clipit_description_font_family') == 'Rockwell'){?>selected="selected"<?php }?>>Rockwell</option>
						<option value="Rockwell Extra Bold" <?php if(get_option('clipit_description_font_family') == 'Rockwell Extra Bold'){?>selected="selected"<?php }?>>Rockwell Extra Bold</option>
						<option value="Stencil" <?php if(get_option('clipit_description_font_family') == 'Stencil'){?>selected="selected"<?php }?>>Stencil</option>
						<option value="Tamoha" <?php if(get_option('clipit_description_font_family') == 'Tamoha'){?>selected="selected"<?php }?>>Tamoha</option>
						<option value="Times New Roman" <?php if(get_option('clipit_description_font_family') == 'Times New Roman'){?>selected="selected"<?php }?>>Times New Roman</option>
						<option value="Trebuchet MS" <?php if(get_option('clipit_description_font_family') == 'Trebuchet MS'){?>selected="selected"<?php }?>>Trebuchet MS</option>
						<option value="Tw Cen MT" <?php if(get_option('clipit_description_font_family') == 'Tw Cen MT'){?>selected="selected"<?php }?>>Tw Cen MT</option>
						<option value="Verdana" <?php if(get_option('clipit_description_font_family') == 'Verdana'){?>selected="selected"<?php }?>>Verdana</option>
						<option value="Wide Latin" <?php if(get_option('clipit_description_font_family') == 'Wide Latin'){?>selected="selected"<?php }?>>Wide Latin</option>								
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="fineprint_font_family"><?php esc_html_e('Coupon Fine Print Font Family'); ?></label><br />
					<em><?php esc_html_e('Select a font family for the coupon fine print'); ?></em><br />					
					<div class="text-demo"><legend>font demo</legend><div id="fontdemo" style="font-family:<?php echo get_option('clipit_fineprint_font_family'); ?>">The quick brown fox jumps over the lazy dog</div></div>
				</td>
			</tr>
			<tr>
				<td>					
					<select class="col-input body-style" name="fineprint_font_family" id="fineprint_font_family" onchange="this.form.submit();">
						<option value="Inherit" <?php if(get_option('clipit_fineprint_font_family') == 'inherit'){?>selected="selected"<?php }?>>Inherit</option>
						<option value="Arial" <?php if(get_option('clipit_fineprint_font_family') == 'Arial'){?>selected="selected"<?php }?>>Arial</option>		
						<option value="Arial Narrow" <?php if(get_option('clipit_fineprint_font_family') == 'Arial Narrow'){?>selected="selected"<?php }?>>Arial Narrow</option>
						<option value="Arial Rounded MT Bold" <?php if(get_option('clipit_fineprint_font_family') == 'Arial Rounded MT Bold'){?>selected="selected"<?php }?>>Arial Rounded MT Bold</option>
						<option value="Book Antiqua" <?php if(get_option('clipit_fineprint_font_family') == 'Book Antiqua'){?>selected="selected"<?php }?>>Book Antiqua</option>
						<option value="Bookman Old Style" <?php if(get_option('clipit_fineprint_font_family') == 'Bookman Old Style'){?>selected="selected"<?php }?>>Bookman Old Style</option>
						<option value="Bradley Hand ITC TT" <?php if(get_option('clipit_fineprint_font_family') == 'Bradley Hand ITC TT'){?>selected="selected"<?php }?>>Bradley Hand ITC TT</option>
						<option value="Century Gothic" <?php if(get_option('clipit_fineprint_font_family') == 'Century Gothic'){?>selected="selected"<?php }?>>Century Gothic</option>
						<option value="Comic Sans MS" <?php if(get_option('clipit_fineprint_font_family') == 'Comic Sans MS'){?>selected="selected"<?php }?>>Comic Sans MS</option>
						<option value="Courier New" <?php if(get_option('clipit_fineprint_font_family') == 'Courier New'){?>selected="selected"<?php }?>>Courier New</option>
						<option value="Economica" <?php if(get_option('clipit_fineprint_font_family') == 'Economica'){?>selected="selected"<?php }?>>Economica</option>
						<option value="Fjalla One" <?php if(get_option('clipit_fineprint_font_family') == 'Fjalla One'){?>selected="selected"<?php }?>>Fjalla One</option>
						<option value="Franklin Gothic Medium" <?php if(get_option('clipit_fineprint_font_family') == 'Franklin Gothic Medium'){?>selected="selected"<?php }?>>Franklin Gothic Medium</option>
						<option value="Garamond" <?php if(get_option('clipit_fineprint_font_family') == 'Garamond'){?>selected="selected"<?php }?>>Garamond</option>
						<option value="Georgia" <?php if(get_option('clipit_fineprint_font_family') == 'Georgia'){?>selected="selected"<?php }?>>Georgia</option>
						<option value="haettenschweiler" <?php if(get_option('clipit_fineprint_font_family') == 'haettenschweiler'){?>selected="selected"<?php }?>>haettenschweiler</option>
						<option value="Impact" <?php if(get_option('clipit_fineprint_font_family') == 'Impact'){?>selected="selected"<?php }?>>Impact</option>
						<option value="Lucida Bright" <?php if(get_option('clipit_fineprint_font_family') == 'Lucida Bright'){?>selected="selected"<?php }?>>Lucida Bright</option>
						<option value="lucida calligraphy" <?php if(get_option('clipit_fineprint_font_family') == 'lucida calligraphy'){?>selected="selected"<?php }?>>Lucida Calligraphy</option>
						<option value="Lucida Console" <?php if(get_option('clipit_fineprint_font_family') == 'Lucida Console'){?>selected="selected"<?php }?>>Lucida Console</option>
						<option value="Lucida Sans" <?php if(get_option('clipit_fineprint_font_family') == 'Lucida Sans'){?>selected="selected"<?php }?>>Lucida Sans</option>
						<option value="Lucida Sans Typewriter" <?php if(get_option('clipit_fineprint_font_family') == 'Lucida Sans Typewriter'){?>selected="selected"<?php }?>>Lucida Sans Typewriter</option>
						<option value="Lucida Sans Unicode" <?php if(get_option('clipit_fineprint_font_family') == 'Lucida Sans Unicode'){?>selected="selected"<?php }?>>Lucida Sans Unicode</option>
						<option value="Mistral" <?php if(get_option('clipit_fineprint_font_family') == 'Mistral'){?>selected="selected"<?php }?>>Mistral</option>
						<option value="MS Mincho" <?php if(get_option('clipit_fineprint_font_family') == 'MS Mincho'){?>selected="selected"<?php }?>>MS Mincho</option>
						<option value="Onyx" <?php if(get_option('clipit_fineprint_font_family') == 'Onyx'){?>selected="selected"<?php }?>>Onyx</option>
						<option value="Papyrus" <?php if(get_option('clipit_fineprint_font_family') == 'Papyrus'){?>selected="selected"<?php }?>>Papyrus</option>
						<option value="Perpetua" <?php if(get_option('clipit_fineprint_font_family') == 'Perpetua'){?>selected="selected"<?php }?>>Perpetua</option>
						<option value="perpetua titling mt" <?php if(get_option('clipit_fineprint_font_family') == 'perpetua titling mt'){?>selected="selected"<?php }?>>Perpetua Titling MT</option>
						<option value="Playbill" <?php if(get_option('clipit_fineprint_font_family') == 'Playbill'){?>selected="selected"<?php }?>>Playbill</option>
						<option value="Rancho" <?php if(get_option('clipit_fineprint_font_family') == 'Rancho'){?>selected="selected"<?php }?>>Rancho</option>
						<option value="Rockwell" <?php if(get_option('clipit_fineprint_font_family') == 'Rockwell'){?>selected="selected"<?php }?>>Rockwell</option>
						<option value="Rockwell Extra Bold" <?php if(get_option('clipit_fineprint_font_family') == 'Rockwell Extra Bold'){?>selected="selected"<?php }?>>Rockwell Extra Bold</option>
						<option value="Stencil" <?php if(get_option('clipit_fineprint_font_family') == 'Stencil'){?>selected="selected"<?php }?>>Stencil</option>
						<option value="Tamoha" <?php if(get_option('clipit_fineprint_font_family') == 'Tamoha'){?>selected="selected"<?php }?>>Tamoha</option>
						<option value="Times New Roman" <?php if(get_option('clipit_fineprint_font_family') == 'Times New Roman'){?>selected="selected"<?php }?>>Times New Roman</option>
						<option value="Trebuchet MS" <?php if(get_option('clipit_fineprint_font_family') == 'Trebuchet MS'){?>selected="selected"<?php }?>>Trebuchet MS</option>
						<option value="Tw Cen MT" <?php if(get_option('clipit_fineprint_font_family') == 'Tw Cen MT'){?>selected="selected"<?php }?>>Tw Cen MT</option>
						<option value="Verdana" <?php if(get_option('clipit_fineprint_font_family') == 'Verdana'){?>selected="selected"<?php }?>>Verdana</option>
						<option value="Wide Latin" <?php if(get_option('clipit_fineprint_font_family') == 'Wide Latin'){?>selected="selected"<?php }?>>Wide Latin</option>								
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="button_font_family"><?php esc_html_e('Coupon Button Font Family'); ?></label><br />
					<em><?php esc_html_e('Select a font family for print coupon button'); ?></em><br />					
					<div class="text-demo"><legend>font demo</legend><div id="fontdemo" style="font-family:<?php echo get_option('clipit_button_font_family'); ?>">The quick brown fox jumps over the lazy dog</div></div>
				</td>
			</tr>
			<tr>
				<td>					
					<select class="col-input body-style" name="button_font_family" id="button_font_family" onchange="this.form.submit();">
						<option value="Inherit" <?php if(get_option('clipit_button_font_family') == 'inherit'){?>selected="selected"<?php }?>>Inherit</option>
						<option value="Arial" <?php if(get_option('clipit_button_font_family') == 'Arial'){?>selected="selected"<?php }?>>Arial</option>		
						<option value="Arial Narrow" <?php if(get_option('clipit_button_font_family') == 'Arial Narrow'){?>selected="selected"<?php }?>>Arial Narrow</option>
						<option value="Arial Rounded MT Bold" <?php if(get_option('clipit_button_font_family') == 'Arial Rounded MT Bold'){?>selected="selected"<?php }?>>Arial Rounded MT Bold</option>
						<option value="Book Antiqua" <?php if(get_option('clipit_button_font_family') == 'Book Antiqua'){?>selected="selected"<?php }?>>Book Antiqua</option>
						<option value="Bookman Old Style" <?php if(get_option('clipit_button_font_family') == 'Bookman Old Style'){?>selected="selected"<?php }?>>Bookman Old Style</option>
						<option value="Bradley Hand ITC TT" <?php if(get_option('clipit_button_font_family') == 'Bradley Hand ITC TT'){?>selected="selected"<?php }?>>Bradley Hand ITC TT</option>
						<option value="Century Gothic" <?php if(get_option('clipit_button_font_family') == 'Century Gothic'){?>selected="selected"<?php }?>>Century Gothic</option>
						<option value="Comic Sans MS" <?php if(get_option('clipit_button_font_family') == 'Comic Sans MS'){?>selected="selected"<?php }?>>Comic Sans MS</option>
						<option value="Courier New" <?php if(get_option('clipit_button_font_family') == 'Courier New'){?>selected="selected"<?php }?>>Courier New</option>
						<option value="Economica" <?php if(get_option('clipit_button_font_family') == 'Economica'){?>selected="selected"<?php }?>>Economica</option>
						<option value="Fjalla One" <?php if(get_option('clipit_button_font_family') == 'Fjalla One'){?>selected="selected"<?php }?>>Fjalla One</option>
						<option value="Franklin Gothic Medium" <?php if(get_option('clipit_button_font_family') == 'Franklin Gothic Medium'){?>selected="selected"<?php }?>>Franklin Gothic Medium</option>
						<option value="Garamond" <?php if(get_option('clipit_button_font_family') == 'Garamond'){?>selected="selected"<?php }?>>Garamond</option>
						<option value="Georgia" <?php if(get_option('clipit_button_font_family') == 'Georgia'){?>selected="selected"<?php }?>>Georgia</option>
						<option value="haettenschweiler" <?php if(get_option('clipit_button_font_family') == 'haettenschweiler'){?>selected="selected"<?php }?>>haettenschweiler</option>
						<option value="Impact" <?php if(get_option('clipit_button_font_family') == 'Impact'){?>selected="selected"<?php }?>>Impact</option>
						<option value="Lucida Bright" <?php if(get_option('clipit_button_font_family') == 'Lucida Bright'){?>selected="selected"<?php }?>>Lucida Bright</option>
						<option value="lucida calligraphy" <?php if(get_option('clipit_button_font_family') == 'lucida calligraphy'){?>selected="selected"<?php }?>>Lucida Calligraphy</option>
						<option value="Lucida Console" <?php if(get_option('clipit_button_font_family') == 'Lucida Console'){?>selected="selected"<?php }?>>Lucida Console</option>
						<option value="Lucida Sans" <?php if(get_option('clipit_button_font_family') == 'Lucida Sans'){?>selected="selected"<?php }?>>Lucida Sans</option>
						<option value="Lucida Sans Typewriter" <?php if(get_option('clipit_button_font_family') == 'Lucida Sans Typewriter'){?>selected="selected"<?php }?>>Lucida Sans Typewriter</option>
						<option value="Lucida Sans Unicode" <?php if(get_option('clipit_button_font_family') == 'Lucida Sans Unicode'){?>selected="selected"<?php }?>>Lucida Sans Unicode</option>
						<option value="Mistral" <?php if(get_option('clipit_button_font_family') == 'Mistral'){?>selected="selected"<?php }?>>Mistral</option>
						<option value="MS Mincho" <?php if(get_option('clipit_button_font_family') == 'MS Mincho'){?>selected="selected"<?php }?>>MS Mincho</option>
						<option value="Onyx" <?php if(get_option('clipit_button_font_family') == 'Onyx'){?>selected="selected"<?php }?>>Onyx</option>
						<option value="Papyrus" <?php if(get_option('clipit_button_font_family') == 'Papyrus'){?>selected="selected"<?php }?>>Papyrus</option>
						<option value="Perpetua" <?php if(get_option('clipit_button_font_family') == 'Perpetua'){?>selected="selected"<?php }?>>Perpetua</option>
						<option value="perpetua titling mt" <?php if(get_option('clipit_button_font_family') == 'perpetua titling mt'){?>selected="selected"<?php }?>>Perpetua Titling MT</option>
						<option value="Playbill" <?php if(get_option('clipit_button_font_family') == 'Playbill'){?>selected="selected"<?php }?>>Playbill</option>
						<option value="Rancho" <?php if(get_option('clipit_button_font_family') == 'Rancho'){?>selected="selected"<?php }?>>Rancho</option>
						<option value="Rockwell" <?php if(get_option('clipit_button_font_family') == 'Rockwell'){?>selected="selected"<?php }?>>Rockwell</option>
						<option value="Rockwell Extra Bold" <?php if(get_option('clipit_button_font_family') == 'Rockwell Extra Bold'){?>selected="selected"<?php }?>>Rockwell Extra Bold</option>
						<option value="Stencil" <?php if(get_option('clipit_button_font_family') == 'Stencil'){?>selected="selected"<?php }?>>Stencil</option>
						<option value="Tamoha" <?php if(get_option('clipit_button_font_family') == 'Tamoha'){?>selected="selected"<?php }?>>Tamoha</option>
						<option value="Times New Roman" <?php if(get_option('clipit_button_font_family') == 'Times New Roman'){?>selected="selected"<?php }?>>Times New Roman</option>
						<option value="Trebuchet MS" <?php if(get_option('clipit_button_font_family') == 'Trebuchet MS'){?>selected="selected"<?php }?>>Trebuchet MS</option>
						<option value="Tw Cen MT" <?php if(get_option('clipit_button_font_family') == 'Tw Cen MT'){?>selected="selected"<?php }?>>Tw Cen MT</option>
						<option value="Verdana" <?php if(get_option('clipit_button_font_family') == 'Verdana'){?>selected="selected"<?php }?>>Verdana</option>
						<option value="Wide Latin" <?php if(get_option('clipit_button_font_family') == 'Wide Latin'){?>selected="selected"<?php }?>>Wide Latin</option>							
					</select>
				</td>
			</tr>			
			<tr>
				<td>
					<div class="section-header"><?php esc_html_e('FONT SIZES'); ?></div>
				</td>
			</tr>
			<tr>
				<td>
					<label for="title_font_size"><?php esc_html_e('Coupon Title Font Size'); ?></label><br />
					<em><?php esc_html_e('Enter the font size for your title'); ?></em><br />					
					<select class="col-input body-style" name="title_font_size" id="title_font_size">
						<option value="" <?php if(get_option('clipit_title_font_size') == ''){?>selected="selected"<?php }?>>Default</option>
						<option value="10px" <?php if(get_option('clipit_title_font_size') == '10px'){?>selected="selected"<?php }?>>10px</option>
						<option value="11px" <?php if(get_option('clipit_title_font_size') == '11px'){?>selected="selected"<?php }?>>11px</option>
						<option value="12px" <?php if(get_option('clipit_title_font_size') == '12px'){?>selected="selected"<?php }?>>12px</option>
						<option value="13px" <?php if(get_option('clipit_title_font_size') == '13px'){?>selected="selected"<?php }?>>13px</option>
						<option value="14px" <?php if(get_option('clipit_title_font_size') == '14px'){?>selected="selected"<?php }?>>14px</option>
						<option value="15px" <?php if(get_option('clipit_title_font_size') == '15px'){?>selected="selected"<?php }?>>15px</option>
						<option value="16px" <?php if(get_option('clipit_title_font_size') == '16px'){?>selected="selected"<?php }?>>16px</option>
						<option value="17px" <?php if(get_option('clipit_title_font_size') == '17px'){?>selected="selected"<?php }?>>17px</option>
						<option value="18px" <?php if(get_option('clipit_title_font_size') == '18px'){?>selected="selected"<?php }?>>18px</option>
						<option value="19px" <?php if(get_option('clipit_title_font_size') == '19px'){?>selected="selected"<?php }?>>19px</option>
						<option value="20px" <?php if(get_option('clipit_title_font_size') == '20px'){?>selected="selected"<?php }?>>20px</option>
						<option value="21px" <?php if(get_option('clipit_title_font_size') == '21px'){?>selected="selected"<?php }?>>21px</option>
						<option value="22px" <?php if(get_option('clipit_title_font_size') == '22px'){?>selected="selected"<?php }?>>22px</option>
						<option value="23px" <?php if(get_option('clipit_title_font_size') == '23px'){?>selected="selected"<?php }?>>23px</option>
						<option value="24px" <?php if(get_option('clipit_title_font_size') == '24px'){?>selected="selected"<?php }?>>24px</option>
						<option value="25px" <?php if(get_option('clipit_title_font_size') == '25px'){?>selected="selected"<?php }?>>25px</option>
						<option value="26px" <?php if(get_option('clipit_title_font_size') == '26px'){?>selected="selected"<?php }?>>26px</option>
						<option value="27px" <?php if(get_option('clipit_title_font_size') == '27px'){?>selected="selected"<?php }?>>27px</option>
						<option value="28px" <?php if(get_option('clipit_title_font_size') == '28px'){?>selected="selected"<?php }?>>28px</option>
						<option value="29px" <?php if(get_option('clipit_title_font_size') == '29px'){?>selected="selected"<?php }?>>29px</option>
						<option value="30px" <?php if(get_option('clipit_title_font_size') == '30px'){?>selected="selected"<?php }?>>30px</option>
						<option value="31px" <?php if(get_option('clipit_title_font_size') == '31px'){?>selected="selected"<?php }?>>31px</option>
						<option value="32px" <?php if(get_option('clipit_title_font_size') == '32px'){?>selected="selected"<?php }?>>32px</option>
						<option value="33px" <?php if(get_option('clipit_title_font_size') == '33px'){?>selected="selected"<?php }?>>33px</option>
						<option value="34px" <?php if(get_option('clipit_title_font_size') == '34px'){?>selected="selected"<?php }?>>34px</option>
						<option value="35px" <?php if(get_option('clipit_title_font_size') == '35px'){?>selected="selected"<?php }?>>35px</option>
						<option value="36px" <?php if(get_option('clipit_title_font_size') == '36px'){?>selected="selected"<?php }?>>36px</option>
						<option value="37px" <?php if(get_option('clipit_title_font_size') == '37px'){?>selected="selected"<?php }?>>37px</option>
						<option value="38px" <?php if(get_option('clipit_title_font_size') == '38px'){?>selected="selected"<?php }?>>38px</option>
						<option value="39px" <?php if(get_option('clipit_title_font_size') == '39px'){?>selected="selected"<?php }?>>39px</option>
						<option value="40px" <?php if(get_option('clipit_title_font_size') == '40px'){?>selected="selected"<?php }?>>40px</option>
						<option value="41px" <?php if(get_option('clipit_title_font_size') == '41px'){?>selected="selected"<?php }?>>41px</option>
						<option value="42px" <?php if(get_option('clipit_title_font_size') == '42px'){?>selected="selected"<?php }?>>42px</option>
						<option value="43px" <?php if(get_option('clipit_title_font_size') == '43px'){?>selected="selected"<?php }?>>43px</option>
						<option value="44px" <?php if(get_option('clipit_title_font_size') == '44px'){?>selected="selected"<?php }?>>44px</option>
						<option value="45px" <?php if(get_option('clipit_title_font_size') == '45px'){?>selected="selected"<?php }?>>45px</option>
						<option value="46px" <?php if(get_option('clipit_title_font_size') == '46px'){?>selected="selected"<?php }?>>46px</option>
						<option value="47px" <?php if(get_option('clipit_title_font_size') == '47px'){?>selected="selected"<?php }?>>47px</option>
						<option value="48px" <?php if(get_option('clipit_title_font_size') == '48px'){?>selected="selected"<?php }?>>48px</option>
						<option value="49px" <?php if(get_option('clipit_title_font_size') == '49px'){?>selected="selected"<?php }?>>49px</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="expiration_font_size"><?php esc_html_e('Expiration Font Size'); ?></label><br />
					<em><?php esc_html_e('Enter the font size for your expiration text'); ?></em><br />					
					<select class="col-input body-style" name="expiration_font_size" id="expiration_font_size">
						<option value="" <?php if(get_option('clipit_expiration_font_size') == ''){?>selected="selected"<?php }?>>Default</option>
						<option value="10px" <?php if(get_option('clipit_expiration_font_size') == '10px'){?>selected="selected"<?php }?>>10px</option>
						<option value="11px" <?php if(get_option('clipit_expiration_font_size') == '11px'){?>selected="selected"<?php }?>>11px</option>
						<option value="12px" <?php if(get_option('clipit_expiration_font_size') == '12px'){?>selected="selected"<?php }?>>12px</option>
						<option value="13px" <?php if(get_option('clipit_expiration_font_size') == '13px'){?>selected="selected"<?php }?>>13px</option>
						<option value="14px" <?php if(get_option('clipit_expiration_font_size') == '14px'){?>selected="selected"<?php }?>>14px</option>
						<option value="15px" <?php if(get_option('clipit_expiration_font_size') == '15px'){?>selected="selected"<?php }?>>15px</option>
						<option value="16px" <?php if(get_option('clipit_expiration_font_size') == '16px'){?>selected="selected"<?php }?>>16px</option>
						<option value="17px" <?php if(get_option('clipit_expiration_font_size') == '17px'){?>selected="selected"<?php }?>>17px</option>
						<option value="18px" <?php if(get_option('clipit_expiration_font_size') == '18px'){?>selected="selected"<?php }?>>18px</option>
						<option value="19px" <?php if(get_option('clipit_expiration_font_size') == '19px'){?>selected="selected"<?php }?>>19px</option>
						<option value="20px" <?php if(get_option('clipit_expiration_font_size') == '20px'){?>selected="selected"<?php }?>>20px</option>
						<option value="21px" <?php if(get_option('clipit_expiration_font_size') == '21px'){?>selected="selected"<?php }?>>21px</option>
						<option value="22px" <?php if(get_option('clipit_expiration_font_size') == '22px'){?>selected="selected"<?php }?>>22px</option>
						<option value="23px" <?php if(get_option('clipit_expiration_font_size') == '23px'){?>selected="selected"<?php }?>>23px</option>
						<option value="24px" <?php if(get_option('clipit_expiration_font_size') == '24px'){?>selected="selected"<?php }?>>24px</option>
						<option value="25px" <?php if(get_option('clipit_expiration_font_size') == '25px'){?>selected="selected"<?php }?>>25px</option>
						<option value="26px" <?php if(get_option('clipit_expiration_font_size') == '26px'){?>selected="selected"<?php }?>>26px</option>
						<option value="27px" <?php if(get_option('clipit_expiration_font_size') == '27px'){?>selected="selected"<?php }?>>27px</option>
						<option value="28px" <?php if(get_option('clipit_expiration_font_size') == '28px'){?>selected="selected"<?php }?>>28px</option>
						<option value="29px" <?php if(get_option('clipit_expiration_font_size') == '29px'){?>selected="selected"<?php }?>>29px</option>
						<option value="30px" <?php if(get_option('clipit_expiration_font_size') == '30px'){?>selected="selected"<?php }?>>30px</option>
						<option value="31px" <?php if(get_option('clipit_expiration_font_size') == '31px'){?>selected="selected"<?php }?>>31px</option>
						<option value="32px" <?php if(get_option('clipit_expiration_font_size') == '32px'){?>selected="selected"<?php }?>>32px</option>
						<option value="33px" <?php if(get_option('clipit_expiration_font_size') == '33px'){?>selected="selected"<?php }?>>33px</option>
						<option value="34px" <?php if(get_option('clipit_expiration_font_size') == '34px'){?>selected="selected"<?php }?>>34px</option>
						<option value="35px" <?php if(get_option('clipit_expiration_font_size') == '35px'){?>selected="selected"<?php }?>>35px</option>
						<option value="36px" <?php if(get_option('clipit_expiration_font_size') == '36px'){?>selected="selected"<?php }?>>36px</option>
						<option value="37px" <?php if(get_option('clipit_expiration_font_size') == '37px'){?>selected="selected"<?php }?>>37px</option>
						<option value="38px" <?php if(get_option('clipit_expiration_font_size') == '38px'){?>selected="selected"<?php }?>>38px</option>
						<option value="39px" <?php if(get_option('clipit_expiration_font_size') == '39px'){?>selected="selected"<?php }?>>39px</option>
						<option value="40px" <?php if(get_option('clipit_expiration_font_size') == '40px'){?>selected="selected"<?php }?>>40px</option>
						<option value="41px" <?php if(get_option('clipit_expiration_font_size') == '41px'){?>selected="selected"<?php }?>>41px</option>
						<option value="42px" <?php if(get_option('clipit_expiration_font_size') == '42px'){?>selected="selected"<?php }?>>42px</option>
						<option value="43px" <?php if(get_option('clipit_expiration_font_size') == '43px'){?>selected="selected"<?php }?>>43px</option>
						<option value="44px" <?php if(get_option('clipit_expiration_font_size') == '44px'){?>selected="selected"<?php }?>>44px</option>
						<option value="45px" <?php if(get_option('clipit_expiration_font_size') == '45px'){?>selected="selected"<?php }?>>45px</option>
						<option value="46px" <?php if(get_option('clipit_expiration_font_size') == '46px'){?>selected="selected"<?php }?>>46px</option>
						<option value="47px" <?php if(get_option('clipit_expiration_font_size') == '47px'){?>selected="selected"<?php }?>>47px</option>
						<option value="48px" <?php if(get_option('clipit_expiration_font_size') == '48px'){?>selected="selected"<?php }?>>48px</option>
						<option value="49px" <?php if(get_option('clipit_expiration_font_size') == '49px'){?>selected="selected"<?php }?>>49px</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="description_font_size"><?php esc_html_e('Description Font Size'); ?></label><br />
					<em><?php esc_html_e('Enter the font size for your description text'); ?></em><br />					
					<select class="col-input body-style" name="description_font_size" id="description_font_size">
						<option value="" <?php if(get_option('clipit_description_font_size') == ''){?>selected="selected"<?php }?>>Default</option>
						<option value="10px" <?php if(get_option('clipit_description_font_size') == '10px'){?>selected="selected"<?php }?>>10px</option>
						<option value="11px" <?php if(get_option('clipit_description_font_size') == '11px'){?>selected="selected"<?php }?>>11px</option>
						<option value="12px" <?php if(get_option('clipit_description_font_size') == '12px'){?>selected="selected"<?php }?>>12px</option>
						<option value="13px" <?php if(get_option('clipit_description_font_size') == '13px'){?>selected="selected"<?php }?>>13px</option>
						<option value="14px" <?php if(get_option('clipit_description_font_size') == '14px'){?>selected="selected"<?php }?>>14px</option>
						<option value="15px" <?php if(get_option('clipit_description_font_size') == '15px'){?>selected="selected"<?php }?>>15px</option>
						<option value="16px" <?php if(get_option('clipit_description_font_size') == '16px'){?>selected="selected"<?php }?>>16px</option>
						<option value="17px" <?php if(get_option('clipit_description_font_size') == '17px'){?>selected="selected"<?php }?>>17px</option>
						<option value="18px" <?php if(get_option('clipit_description_font_size') == '18px'){?>selected="selected"<?php }?>>18px</option>
						<option value="19px" <?php if(get_option('clipit_description_font_size') == '19px'){?>selected="selected"<?php }?>>19px</option>
						<option value="20px" <?php if(get_option('clipit_description_font_size') == '20px'){?>selected="selected"<?php }?>>20px</option>
						<option value="21px" <?php if(get_option('clipit_description_font_size') == '21px'){?>selected="selected"<?php }?>>21px</option>
						<option value="22px" <?php if(get_option('clipit_description_font_size') == '22px'){?>selected="selected"<?php }?>>22px</option>
						<option value="23px" <?php if(get_option('clipit_description_font_size') == '23px'){?>selected="selected"<?php }?>>23px</option>
						<option value="24px" <?php if(get_option('clipit_description_font_size') == '24px'){?>selected="selected"<?php }?>>24px</option>
						<option value="25px" <?php if(get_option('clipit_description_font_size') == '25px'){?>selected="selected"<?php }?>>25px</option>
						<option value="26px" <?php if(get_option('clipit_description_font_size') == '26px'){?>selected="selected"<?php }?>>26px</option>
						<option value="27px" <?php if(get_option('clipit_description_font_size') == '27px'){?>selected="selected"<?php }?>>27px</option>
						<option value="28px" <?php if(get_option('clipit_description_font_size') == '28px'){?>selected="selected"<?php }?>>28px</option>
						<option value="29px" <?php if(get_option('clipit_description_font_size') == '29px'){?>selected="selected"<?php }?>>29px</option>
						<option value="30px" <?php if(get_option('clipit_description_font_size') == '30px'){?>selected="selected"<?php }?>>30px</option>
						<option value="31px" <?php if(get_option('clipit_description_font_size') == '31px'){?>selected="selected"<?php }?>>31px</option>
						<option value="32px" <?php if(get_option('clipit_description_font_size') == '32px'){?>selected="selected"<?php }?>>32px</option>
						<option value="33px" <?php if(get_option('clipit_description_font_size') == '33px'){?>selected="selected"<?php }?>>33px</option>
						<option value="34px" <?php if(get_option('clipit_description_font_size') == '34px'){?>selected="selected"<?php }?>>34px</option>
						<option value="35px" <?php if(get_option('clipit_description_font_size') == '35px'){?>selected="selected"<?php }?>>35px</option>
						<option value="36px" <?php if(get_option('clipit_description_font_size') == '36px'){?>selected="selected"<?php }?>>36px</option>
						<option value="37px" <?php if(get_option('clipit_description_font_size') == '37px'){?>selected="selected"<?php }?>>37px</option>
						<option value="38px" <?php if(get_option('clipit_description_font_size') == '38px'){?>selected="selected"<?php }?>>38px</option>
						<option value="39px" <?php if(get_option('clipit_description_font_size') == '39px'){?>selected="selected"<?php }?>>39px</option>
						<option value="40px" <?php if(get_option('clipit_description_font_size') == '40px'){?>selected="selected"<?php }?>>40px</option>
						<option value="41px" <?php if(get_option('clipit_description_font_size') == '41px'){?>selected="selected"<?php }?>>41px</option>
						<option value="42px" <?php if(get_option('clipit_description_font_size') == '42px'){?>selected="selected"<?php }?>>42px</option>
						<option value="43px" <?php if(get_option('clipit_description_font_size') == '43px'){?>selected="selected"<?php }?>>43px</option>
						<option value="44px" <?php if(get_option('clipit_description_font_size') == '44px'){?>selected="selected"<?php }?>>44px</option>
						<option value="45px" <?php if(get_option('clipit_description_font_size') == '45px'){?>selected="selected"<?php }?>>45px</option>
						<option value="46px" <?php if(get_option('clipit_description_font_size') == '46px'){?>selected="selected"<?php }?>>46px</option>
						<option value="47px" <?php if(get_option('clipit_description_font_size') == '47px'){?>selected="selected"<?php }?>>47px</option>
						<option value="48px" <?php if(get_option('clipit_description_font_size') == '48px'){?>selected="selected"<?php }?>>48px</option>
						<option value="49px" <?php if(get_option('clipit_description_font_size') == '49px'){?>selected="selected"<?php }?>>49px</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="fineprint_font_size"><?php esc_html_e('Fine Print Font Size'); ?></label><br />
					<em><?php esc_html_e('Enter the font size for your fine print'); ?></em><br />					
					<select class="col-input body-style" name="fineprint_font_size" id="fineprint_font_size">
						<option value="" <?php if(get_option('clipit_fineprint_font_size') == ''){?>selected="selected"<?php }?>>Default</option>
						<option value="10px" <?php if(get_option('clipit_fineprint_font_size') == '10px'){?>selected="selected"<?php }?>>10px</option>
						<option value="11px" <?php if(get_option('clipit_fineprint_font_size') == '11px'){?>selected="selected"<?php }?>>11px</option>
						<option value="12px" <?php if(get_option('clipit_fineprint_font_size') == '12px'){?>selected="selected"<?php }?>>12px</option>
						<option value="13px" <?php if(get_option('clipit_fineprint_font_size') == '13px'){?>selected="selected"<?php }?>>13px</option>
						<option value="14px" <?php if(get_option('clipit_fineprint_font_size') == '14px'){?>selected="selected"<?php }?>>14px</option>
						<option value="15px" <?php if(get_option('clipit_fineprint_font_size') == '15px'){?>selected="selected"<?php }?>>15px</option>
						<option value="16px" <?php if(get_option('clipit_fineprint_font_size') == '16px'){?>selected="selected"<?php }?>>16px</option>
						<option value="17px" <?php if(get_option('clipit_fineprint_font_size') == '17px'){?>selected="selected"<?php }?>>17px</option>
						<option value="18px" <?php if(get_option('clipit_fineprint_font_size') == '18px'){?>selected="selected"<?php }?>>18px</option>
						<option value="19px" <?php if(get_option('clipit_fineprint_font_size') == '19px'){?>selected="selected"<?php }?>>19px</option>
						<option value="20px" <?php if(get_option('clipit_fineprint_font_size') == '20px'){?>selected="selected"<?php }?>>20px</option>
						<option value="21px" <?php if(get_option('clipit_fineprint_font_size') == '21px'){?>selected="selected"<?php }?>>21px</option>
						<option value="22px" <?php if(get_option('clipit_fineprint_font_size') == '22px'){?>selected="selected"<?php }?>>22px</option>
						<option value="23px" <?php if(get_option('clipit_fineprint_font_size') == '23px'){?>selected="selected"<?php }?>>23px</option>
						<option value="24px" <?php if(get_option('clipit_fineprint_font_size') == '24px'){?>selected="selected"<?php }?>>24px</option>
						<option value="25px" <?php if(get_option('clipit_fineprint_font_size') == '25px'){?>selected="selected"<?php }?>>25px</option>
						<option value="26px" <?php if(get_option('clipit_fineprint_font_size') == '26px'){?>selected="selected"<?php }?>>26px</option>
						<option value="27px" <?php if(get_option('clipit_fineprint_font_size') == '27px'){?>selected="selected"<?php }?>>27px</option>
						<option value="28px" <?php if(get_option('clipit_fineprint_font_size') == '28px'){?>selected="selected"<?php }?>>28px</option>
						<option value="29px" <?php if(get_option('clipit_fineprint_font_size') == '29px'){?>selected="selected"<?php }?>>29px</option>
						<option value="30px" <?php if(get_option('clipit_fineprint_font_size') == '30px'){?>selected="selected"<?php }?>>30px</option>
						<option value="31px" <?php if(get_option('clipit_fineprint_font_size') == '31px'){?>selected="selected"<?php }?>>31px</option>
						<option value="32px" <?php if(get_option('clipit_fineprint_font_size') == '32px'){?>selected="selected"<?php }?>>32px</option>
						<option value="33px" <?php if(get_option('clipit_fineprint_font_size') == '33px'){?>selected="selected"<?php }?>>33px</option>
						<option value="34px" <?php if(get_option('clipit_fineprint_font_size') == '34px'){?>selected="selected"<?php }?>>34px</option>
						<option value="35px" <?php if(get_option('clipit_fineprint_font_size') == '35px'){?>selected="selected"<?php }?>>35px</option>
						<option value="36px" <?php if(get_option('clipit_fineprint_font_size') == '36px'){?>selected="selected"<?php }?>>36px</option>
						<option value="37px" <?php if(get_option('clipit_fineprint_font_size') == '37px'){?>selected="selected"<?php }?>>37px</option>
						<option value="38px" <?php if(get_option('clipit_fineprint_font_size') == '38px'){?>selected="selected"<?php }?>>38px</option>
						<option value="39px" <?php if(get_option('clipit_fineprint_font_size') == '39px'){?>selected="selected"<?php }?>>39px</option>
						<option value="40px" <?php if(get_option('clipit_fineprint_font_size') == '40px'){?>selected="selected"<?php }?>>40px</option>
						<option value="41px" <?php if(get_option('clipit_fineprint_font_size') == '41px'){?>selected="selected"<?php }?>>41px</option>
						<option value="42px" <?php if(get_option('clipit_fineprint_font_size') == '42px'){?>selected="selected"<?php }?>>42px</option>
						<option value="43px" <?php if(get_option('clipit_fineprint_font_size') == '43px'){?>selected="selected"<?php }?>>43px</option>
						<option value="44px" <?php if(get_option('clipit_fineprint_font_size') == '44px'){?>selected="selected"<?php }?>>44px</option>
						<option value="45px" <?php if(get_option('clipit_fineprint_font_size') == '45px'){?>selected="selected"<?php }?>>45px</option>
						<option value="46px" <?php if(get_option('clipit_fineprint_font_size') == '46px'){?>selected="selected"<?php }?>>46px</option>
						<option value="47px" <?php if(get_option('clipit_fineprint_font_size') == '47px'){?>selected="selected"<?php }?>>47px</option>
						<option value="48px" <?php if(get_option('clipit_fineprint_font_size') == '48px'){?>selected="selected"<?php }?>>48px</option>
						<option value="49px" <?php if(get_option('clipit_fineprint_font_size') == '49px'){?>selected="selected"<?php }?>>49px</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="button_font_size"><?php esc_html_e('Button Font Size'); ?></label><br />
					<em><?php esc_html_e('Enter the font size for your button'); ?></em><br />					
					<select class="col-input body-style" name="button_font_size" id="button_font_size">
						<option value="" <?php if(get_option('clipit_button_font_size') == ''){?>selected="selected"<?php }?>>Default</option>
						<option value="10px" <?php if(get_option('clipit_button_font_size') == '10px'){?>selected="selected"<?php }?>>10px</option>
						<option value="11px" <?php if(get_option('clipit_button_font_size') == '11px'){?>selected="selected"<?php }?>>11px</option>
						<option value="12px" <?php if(get_option('clipit_button_font_size') == '12px'){?>selected="selected"<?php }?>>12px</option>
						<option value="13px" <?php if(get_option('clipit_button_font_size') == '13px'){?>selected="selected"<?php }?>>13px</option>
						<option value="14px" <?php if(get_option('clipit_button_font_size') == '14px'){?>selected="selected"<?php }?>>14px</option>
						<option value="15px" <?php if(get_option('clipit_button_font_size') == '15px'){?>selected="selected"<?php }?>>15px</option>
						<option value="16px" <?php if(get_option('clipit_button_font_size') == '16px'){?>selected="selected"<?php }?>>16px</option>
						<option value="17px" <?php if(get_option('clipit_button_font_size') == '17px'){?>selected="selected"<?php }?>>17px</option>
						<option value="18px" <?php if(get_option('clipit_button_font_size') == '18px'){?>selected="selected"<?php }?>>18px</option>
						<option value="19px" <?php if(get_option('clipit_button_font_size') == '19px'){?>selected="selected"<?php }?>>19px</option>
						<option value="20px" <?php if(get_option('clipit_button_font_size') == '20px'){?>selected="selected"<?php }?>>20px</option>
						<option value="21px" <?php if(get_option('clipit_button_font_size') == '21px'){?>selected="selected"<?php }?>>21px</option>
						<option value="22px" <?php if(get_option('clipit_button_font_size') == '22px'){?>selected="selected"<?php }?>>22px</option>
						<option value="23px" <?php if(get_option('clipit_button_font_size') == '23px'){?>selected="selected"<?php }?>>23px</option>
						<option value="24px" <?php if(get_option('clipit_button_font_size') == '24px'){?>selected="selected"<?php }?>>24px</option>
						<option value="25px" <?php if(get_option('clipit_button_font_size') == '25px'){?>selected="selected"<?php }?>>25px</option>
						<option value="26px" <?php if(get_option('clipit_button_font_size') == '26px'){?>selected="selected"<?php }?>>26px</option>
						<option value="27px" <?php if(get_option('clipit_button_font_size') == '27px'){?>selected="selected"<?php }?>>27px</option>
						<option value="28px" <?php if(get_option('clipit_button_font_size') == '28px'){?>selected="selected"<?php }?>>28px</option>
						<option value="29px" <?php if(get_option('clipit_button_font_size') == '29px'){?>selected="selected"<?php }?>>29px</option>
						<option value="30px" <?php if(get_option('clipit_button_font_size') == '30px'){?>selected="selected"<?php }?>>30px</option>
						<option value="31px" <?php if(get_option('clipit_button_font_size') == '31px'){?>selected="selected"<?php }?>>31px</option>
						<option value="32px" <?php if(get_option('clipit_button_font_size') == '32px'){?>selected="selected"<?php }?>>32px</option>
						<option value="33px" <?php if(get_option('clipit_button_font_size') == '33px'){?>selected="selected"<?php }?>>33px</option>
						<option value="34px" <?php if(get_option('clipit_button_font_size') == '34px'){?>selected="selected"<?php }?>>34px</option>
						<option value="35px" <?php if(get_option('clipit_button_font_size') == '35px'){?>selected="selected"<?php }?>>35px</option>
						<option value="36px" <?php if(get_option('clipit_button_font_size') == '36px'){?>selected="selected"<?php }?>>36px</option>
						<option value="37px" <?php if(get_option('clipit_button_font_size') == '37px'){?>selected="selected"<?php }?>>37px</option>
						<option value="38px" <?php if(get_option('clipit_button_font_size') == '38px'){?>selected="selected"<?php }?>>38px</option>
						<option value="39px" <?php if(get_option('clipit_button_font_size') == '39px'){?>selected="selected"<?php }?>>39px</option>
						<option value="40px" <?php if(get_option('clipit_button_font_size') == '40px'){?>selected="selected"<?php }?>>40px</option>
						<option value="41px" <?php if(get_option('clipit_button_font_size') == '41px'){?>selected="selected"<?php }?>>41px</option>
						<option value="42px" <?php if(get_option('clipit_button_font_size') == '42px'){?>selected="selected"<?php }?>>42px</option>
						<option value="43px" <?php if(get_option('clipit_button_font_size') == '43px'){?>selected="selected"<?php }?>>43px</option>
						<option value="44px" <?php if(get_option('clipit_button_font_size') == '44px'){?>selected="selected"<?php }?>>44px</option>
						<option value="45px" <?php if(get_option('clipit_button_font_size') == '45px'){?>selected="selected"<?php }?>>45px</option>
						<option value="46px" <?php if(get_option('clipit_button_font_size') == '46px'){?>selected="selected"<?php }?>>46px</option>
						<option value="47px" <?php if(get_option('clipit_button_font_size') == '47px'){?>selected="selected"<?php }?>>47px</option>
						<option value="48px" <?php if(get_option('clipit_button_font_size') == '48px'){?>selected="selected"<?php }?>>48px</option>
						<option value="49px" <?php if(get_option('clipit_button_font_size') == '49px'){?>selected="selected"<?php }?>>49px</option>
					</select>
				</td>
			</tr>
		</table>
		</fieldset>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
			<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
		</p>
		<p class="submit">
			<input type="button" name="Submit" class="button-primary reset" value="Reset" />
		</p>
	</div>	
	<div id="tabs-4" class="right-col">	
		<fieldset>
		<div class="admin-page-title"><?php esc_html_e('Custom CSS'); ?></div>
		<div class="save-top">
				<p class="submit">
					<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
					<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
				</p>	
				<p class="submit">
					<input type="button" name="Submit" class="button-primary reset" value="Reset" />
				</p>
			</div>
			<div class="clear"></div>
			<hr>
			<table class="form-table">
			<tr>
				<td>
					<label for="css_styling"><?php esc_html_e('Custom CSS Code'); ?></label><br />
					<em><?php esc_html_e('Paste your css codes. Do not include <stlye></stlye> tags or any html tag in this field.'); ?></em><br />				
					<textarea name="css_styling" id="css_styling" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_css_styling')); ?></textarea>
				</td>
			</tr>				
		</table>
		</fieldset>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
			<input type="hidden" name="clipit_settings" value="save" style="display:none;" />
		</p>
		<p class="submit">
			<input type="button" name="Submit" class="button-primary reset" value="Reset" />
		</p>			
	</div>
	</form>
</div>
<?php } ?>