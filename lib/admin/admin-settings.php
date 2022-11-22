<?php

$data = json_decode($_GET['data']);
$accounts = json_decode($_GET['accounts']);

if ($_GET['data'] && $_GET['accounts'] && $_GET['locations']) {
    update_option("gbp_access_token", $data->access_token, true);
    update_option("gbp_refresh_token", $data->refresh_token, true);
    update_option("gbp_id_token", $data->id_token, true);
    update_option("gbp_scope", $data->scope, true);
    update_option("gbp_accounts", $accounts->accounts, true);
    update_option("gbp_locations", urldecode($_GET['locations']), true);
}

add_action("admin_menu", "coupon_plugin_settings");
function coupon_plugin_settings()
{
    add_submenu_page("edit.php?post_type=coupon", "ClipIt Coupons Settings", "Clipit Settings", "list_users", basename(__FILE__), "clipit_settings");
}

function clipit_settings()
{
    global $title;
?>
    <h2><?php echo $title; ?></h2>
    <script>
        jQuery(document).ready(function() {
            jQuery("#accordion").accordion({
                collapsible: true,
                active: false
            });
            jQuery("#tabs").tabs({
                activate: function(event, ui) {
                    var tabid = jQuery("#tabs").tabs("option", "active");
                    jQuery.cookie("curtab", tabid);
                }
            }).addClass("ui-tabs-vertical ui-helper-clearfix");
            jQuery("#tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");
            var curtab = jQuery.cookie("curtab");
            if (curtab && curtab.length > 0) {
                jQuery("#tabs").tabs({
                    active: curtab
                });
            }

            // jQuery('.clipit_upload_button').click(function() {
            // 	 targetfield = jQuery(this).prev('.upload-url');
            // 	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            // 	 return false;
            // });

            // window.send_to_editor = function(html) {
            // 	 imgurl = jQuery('img',html).attr('src');
            // 	 jQuery(targetfield).val(imgurl);
            // 	 tb_remove();
            // }

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
            <li id="tab1"><a href="#tabs-1">
                    <div class="admin-tools-icon icon"></div>
                    <div class="admin-tabs-link">General Settings</div>
                </a>
                <div class="help">General</div>
            </li>
            <li id="tab4"><a href="#tabs-4">
                    <div class="admin-style-icon icon"></div>
                    <div class="admin-tabs-link">Custom CSS</div>
                </a>
                <div class="help">CSS</div>
            </li>
            <li id="tab1"><a href="#tabs-2">
                    <div class="admin-tools-icon icon"></div>
                    <div class="admin-tabs-link">GBP Settings</div>
                </a>
                <div class="help">General</div>
            </li>
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
                                <label for="coupon-accent-color"><?php esc_html_e('Coupon Accent Color'); ?></label><br /><br />
                                <input name="accent_color" id="coupon-accent-color" type="text" class="color-field" value="<?php echo get_option('clipit_accent_color', '#d40400') ?>">
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
                                <label for="contact_form_default"><?php esc_html_e('Global Contact Form'); ?></label><br />
                                <textarea name="contact_form_default" id="contact_form_default" class="col-input text-style" rows="10" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('clipit_contact_form_default')); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                    </table>
                </fieldset>
                <p class="submit" style="display:none;">
                    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
                    <input type="hidden" name="clipit_settings" value="save" style="display:none;" />
                </p>
                <p class="submit" style="display:none;">
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
        <div id="tabs-2" class="right-col">
            <form id="gbpForm" method="post" action="">
                <fieldset>
                    <div class="admin-page-title">
                        <?php esc_html_e('Google Business Profile Settings'); ?>
                        <input type="hidden" id="site_url" value="<?php echo do_shortcode('[site_url]'); ?>">
                    </div>
                    <div class="clear"></div>
                    <hr>
                    <table class="form-table" id="gbp-table">
                        <tr id="connectBtn">
                            <td>

                                <?php
                                $domain = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                $action = 'connect';
                                ?>

                                <input type="hidden" id="page_url" value="<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?post_type=" . $_GET['post_type'] . "&page=" . $_GET['page']; ?>">

                                <?php

                                if ((get_option('gbp_locations') == '[]' || get_option('gbp_locations') == '') && (get_option('gbp_accounts') != '')) {
                                ?>
                                    <p class='status-danger'>Location Not Found.</p>
                                    <?php
                                } else {
                                    if (get_option('gbp_access_token') != '' && (get_option('gbp_locations') != '[]' || get_option('gbp_locations') != '')) {
                                        echo "";
                                    ?>
                                        <p class='status-success'>Your GBP account is successfully connected.</p>
                                    <?php
                                    }

                                    $locations = json_decode(get_option('gbp_locations'));
                                    $selected_location_value = json_decode(get_option('gbp_selected_location'));

                                    if (!empty($locations)) {
                                    ?>

                                        <p>
                                            <input type="button" name="disconnect" class="button-primary btn-disconnect list_mb list_mt" value="Disconnect" id="disconnect_gbp" />

                                            <input type="button" name="refresh_page" class="button-primary refresh_page" value="Get All Locations" />
                                        </p>

                                        <div class='location_list_div'>
                                            <div class="list_mb">
                                                <b>List of locations: </b>
                                            </div>
                                        <?php
                                    }

                                    foreach ($locations as $loc) {

                                        if (!empty($selected_location_value) && in_array($loc->name, $selected_location_value)) {
                                            $checked = 'checked';
                                        } else {
                                            $checked = '';
                                        }
                                        ?>
                                            <div class='list_mb'>
                                                <input type='checkbox' name='gbp_radio_loc[]' value='<?php echo $loc->name; ?>' id='<?php echo $loc->title; ?>' style='display: inline-block;visibility: visible;' <?php echo $checked ?>>
                                                <label for='<?php echo $loc->title; ?>'><?php echo $loc->title; ?></label>
                                            </div>
                                        <?php
                                    }

                                    if (get_option('gbp_access_token') != '') {

                                        ?>
                                            <hr>
                                            <input type="button" name="save" class="button-primary save_location" value="Save Location" />
                                        <?php } ?>
                                        </div>
                                    <?php
                                }

                                if (get_option('gbp_access_token') == '') {
                                    ?>
                                        <a href="https://wp.digitalapps.studio/clipitoauth2/index.php?domain=<?php echo $domain; ?>&action=<?php echo $action; ?>" type="button" class="button-primary" id="" value="Connect GBP Account">Connect GBP Account</a>
                                    <?php
                                }
                                    ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php
                                if (get_option('gbp_access_token') != '') {

                                    if ((get_option('gbp_locations') == '[]' || get_option('gbp_locations') == '') && (get_option('gbp_accounts') != '')) {
                                ?>
                                        <input type="button" name="disconnect" class="button-primary btn-disconnect" value="Disconnect" id="disconnect_gbp" />
                                    <?php
                                    } else {
                                    ?>
                                <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <p class="submit" style="display: none">
                    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
                    <input type="hidden" name="clipit_settings" value="save" style="display:none;" />
                </p>
        </div>
        </form>
        <script>
            (function($) {

                $(function() {
                    var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";

                    $(".refresh_page").click(function() {
                        window.location.href = $("#page_url").val();
                    });

                    check_token();

                    function check_token() {
                        var data = {
                            'action': 'check_access_token',
                        };
                        jQuery.post(ajax_url, data, function(response) {});
                    }

                    get_location();

                    function get_location() {
                        var data = {
                            'action': 'get_locations',
                        };
                        jQuery.post(ajax_url, data, function(response) {
                            // window.location.reload();
                        });
                    }
                });

                $(function() {
                    var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";

                    $(".save_location").click(function() {

                        var loc_value = new Array();
                        $("input:checked").each(function() {
                            loc_value.push($(this).val());
                        });

                        if (loc_value == '' || loc_value == undefined) {
                            alert("Please Select Atleast One Location.");
                            return false;
                        } else {
                            var data = {
                                'action': 'save_location',
                                'location_value': loc_value
                            };
                            jQuery.post(ajax_url, data, function(response) {
                                window.location.href = $("#page_url").val();
                            });
                        }
                    });

                    $("#disconnect_gbp").click(function() {
                        if (confirm('Are you sure ?')) {
                            var data = {
                                'action': 'disconnect_gbp',
                            };
                        } else {
                            return false;
                        }
                        jQuery.post(ajax_url, data, function(response) {
                            // var pathArray = url.split('#');
                            window.location.href = $('#page_url').val();
                        });
                    });

                    // Gbp Button Click
                    $("#gbpButtonClick").click(function(e) {
                        var data = {
                            'action': 'connection_create',
                        };
                        jQuery.post(ajax_url, data, function(response) {
                            console.log("response => " + response);
                        });
                    });

                    $("#gbpButton").click(function(e) {
                        e.preventDefault();
                        const client_id = $("#gbp_client_number").val();
                        const site_url = $("#site_url").val();

                        if (client_id) {
                            const redirect_url = encodeURIComponent(site_url + '/wp-admin/edit.php?post_type=coupon&page=admin-settings.php');
                            let url = `https://accounts.google.com/o/oauth2/v2/auth/oauthchooseaccount?redirect_uri=${redirect_url}&prompt=consent&response_type=token&client_id=${client_id}&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fbusiness.manage&access_type=online&flowName=GeneralOAuthFlow`;
                            var data = {
                                'action': 'store_client_id',
                                'client_id': client_id, // We pass php values differently!
                            };
                            jQuery.post(ajax_url, data, function(response) {
                                console.log("response => " + response);
                            });
                            window.location.href = url;
                            // window.location.reload();
                        } else {
                            $("#error").text('Please Enter Client ID!!');
                        }
                    });
                });
            })(jQuery);
        </script>
    </div>
<?php }
