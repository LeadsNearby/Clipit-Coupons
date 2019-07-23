<?php
add_action("admin_menu", "coupon_plugin_settings");
function coupon_plugin_settings() {
    add_submenu_page("edit.php?post_type=coupon", "ClipIt Coupons Settings", "Clipit Settings", "edit_themes", basename(__FILE__), "clipit_settings");
}

function clipit_settings() {global $title;?>
	<h2><?php echo $title; ?></h2>
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
$image_library_url = get_upload_iframe_src('image', null, 'library');
    $image_library_url = remove_query_arg(array('TB_iframe'), $image_library_url);
    $image_library_url = add_query_arg(array('context' => 'jpg-default-image', 'TB_iframe' => 1), $image_library_url);
    ?>

<div id="tabs" class="wrap jpgadmin">
    <ul>
		<div id="theme-options-title">
			<a class="admin-logo" href="http://clipitcouponer.com/">
				<img src="<?php echo plugin_dir_url(__FILE__) . 'images/admin-logo.png'; ?>">
			</a>
			<a class="admin-logo-min" href="http://clipitcouponer.com/">
				<img src="<?php echo plugin_dir_url(__FILE__) . 'images/admin-logo-min.png'; ?>">
			</a>
			<div class="theme-options-text">ClipIt OPTIONS</div>
		</div>
		<li id="tab1"><a href="#tabs-1"><div class="admin-tools-icon icon"></div><div class="admin-tabs-link">General Settings</div></a><div class="help">General</div></li>
		<li id="tab4"><a href="#tabs-4"><div class="admin-style-icon icon"></div><div class="admin-tabs-link">Custom CSS</div></a><div class="help">CSS</div></li>
    </ul>
    <div id="tabs-1" class="right-col">
		<form method="post" action="">
		<fieldset>
			<div class="admin-page-title">
				<?php esc_html_e('General Settings');?>
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
						<div class="section-header"><?php esc_html_e('General Settings');?></div>
					</td>
				</tr>
				<tr>
					<td>
						<label for="beta_coupon_display"><?php esc_html_e('Use Beta Coupon Layout');?></label><br />
						<input type="checkbox" name="beta_coupon_display" id="beta_coupon_display" class="col-input text-style" style="font-size:11px;" <?php if (get_option('clipit_beta_coupon_display', true) === 'on') {echo 'checked';}?> />
					</td>
				</tr>
				<tr>
					<td>
						<label for="expired_coupon_text"><?php esc_html_e('Expired Coupon Text');?></label><br />
						<em><?php esc_html_e('Expired Coupon Texr. You can use HTML for links etc.');?></em><br/>
						<textarea name="expired_coupon_text" id="expired_coupon_text" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_expired_coupon_text')); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label for="rules_default"><?php esc_html_e('The Rules Default content');?></label><br />
						<em><?php esc_html_e('Default Coupon Rules. You can use HTML for links etc.');?></em><br/>
						<textarea name="rules_default" id="rules_default" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_rules_default')); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label for="fineprint_default"><?php esc_html_e('The Fine Print Default content');?></label><br />
						<em><?php esc_html_e('Default Fine Print Rules. You can use HTML for links etc.');?></em><br />
						<textarea name="fineprint_default" id="fineprint_default" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_fineprint_default')); ?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<div class="section-header"><?php esc_html_e('Email Settings');?></div>
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
						<label for="email_claim_address"><?php esc_html_e('Email to Claim Coupon');?></label><br />
						<em><?php esc_html_e('Enter the contact email address to receive notifications of when someone enters their contact information to claim a coupon.<br /> Got multiple email addresses? Separate each with a comma and space i.e., test@test.com, test@test.com');?></em><br />
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
	<div id="tabs-4" class="right-col">
		<fieldset>
		<div class="admin-page-title"><?php esc_html_e('Custom CSS');?></div>
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
					<label for="css_styling"><?php esc_html_e('Custom CSS Code');?></label><br />
					<em><?php esc_html_e('Paste your css codes. Do not include <stlye></stlye> tags or any html tag in this field.');?></em><br />
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
<?php }?>