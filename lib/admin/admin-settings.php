<?php
global $clipitGBPoauth2;
$clipitGBPoauth2 = "https://homeserviceapps.com/integrations/clipit/clipitoauth2";

add_action('admin_init', 'admin_add_get_val');
function admin_add_get_val()
{
    if (!is_null($_GET['data']) && !is_null($_GET['accounts']) && !is_null($_GET['locations'])) {

        if (!get_option('gbp_isConnected') || get_option('gbp_isConnected') != '') {

            $data = json_decode(stripslashes(urldecode($_GET['data'])));
            $accounts = json_decode(stripslashes(urldecode($_GET['accounts'])));
            $locations = json_decode(stripslashes(urldecode($_GET['locations'])));

            if (get_option('gbp_locations') || get_option('gbp_locations') == '') {
                update_option('gbp_locations', $locations, false);
            } else {
                add_option('gbp_locations', $locations, false);
            }
            if (get_option('gbp_accounts') || get_option('gbp_accounts') == '') {
                update_option('gbp_accounts', $accounts, false);
            } else {
                add_option('gbp_accounts', $accounts, false);
            }

            if (get_option('gbp_access_token') || get_option('gbp_access_token') == '') {
                update_option('gbp_access_token', $data->access_token, false);
            } else {
                add_option('gbp_access_token', $data->access_token, false);
            }
            if (get_option('gbp_refresh_token') || get_option('gbp_refresh_token') == '') {
                update_option('gbp_refresh_token', $data->refresh_token, false);
            } else {
                add_option('gbp_refresh_token', $data->refresh_token, false);
            }
            if (get_option('gbp_id_token') || get_option('gbp_id_token') == '') {
                update_option('gbp_id_token', $data->id_token, false);
            } else {
                add_option('gbp_id_token', $data->id_token, false);
            }
            if (get_option('gbp_scope') || get_option('gbp_scope') == '') {
                update_option('gbp_scope', $data->scope, false);
            } else {
                add_option('gbp_scope', $data->scope, false);
            }
            update_option('gbp_isConnected', true, false);
        } else {
            add_option('gbp_isConnected', true, false);
        }
    }
}


add_action("admin_menu", "coupon_plugin_settings");
function coupon_plugin_settings()
{
    add_submenu_page("edit.php?post_type=coupon", "ClipIt Coupons Settings", "Clipit Settings", "list_users", basename(__FILE__), "clipit_settings");
}

function clipit_settings()
{
    global $title, $clipitGBPoauth2;
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
                                $gbpLocations = get_option('gbp_locations', null);
                                $gbpAccessToken = get_option('gbp_access_token');
                                $gbpAccounts = get_option('gbp_accounts');

                                if (!is_array($gbpLocations)) {
                                    $gbpLocations = array();
                                }

                                $domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                $action = 'connect';
                                ?>

                                <input type="hidden" id="page_url" value="<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . "?post_type=" . $_GET['post_type'] . "&page=" . $_GET['page']; ?>">

                                <?php
                                if ((count($gbpLocations) === 0) && ($gbpAccounts != '')) {
                                ?>
                                    <p class='status-danger'>Location Not Found.</p>
                                    <?php
                                } else {
                                    if ($gbpAccessToken != '' && (count($gbpLocations) !== 0)) {
                                        echo "";
                                    ?>
                                        <p class='status-success'>Your GBP account is successfully connected.</p>
                                    <?php
                                    }

                                    $locations = $gbpLocations;
                                    $selected_location_value = get_option('gbp_selected_location');

                                    if (count($locations) !== 0 || $gbpAccessToken != "") {
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

                                        if (count($locations) !== 0 || $locations != "") {
                                            foreach ($locations as $loc) {

                                                $checked = '';
                                                $locName = '';
                                                $locTitle = '';
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
                                            ?>
                                                <div class='list_mb'>
                                                    <input type='checkbox' name='gbp_radio_loc[]' value='<?php echo $locName; ?>' id='<?php echo $locTitle; ?>' style='display: inline-block;visibility: visible;' <?php echo $checked ?>>
                                                    <label for='<?php echo $locTitle; ?>'><?php echo $locTitle; ?></label>
                                                </div>
                                            <?php
                                            }
                                        }
                                        if ($gbpAccessToken != '') {
                                            ?>
                                            <hr>
                                            <input type="button" name="save" class="button-primary save_location" value="Save Location" />
                                            <div style="height: 30px; display: flex; align-items: flex-end;">
                                                <p style="color: green; margin: 0px 0px;" id="responseText"></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        </div>
                                    <?php
                                }
                                if ($gbpAccessToken == '') {
                                    ?>
                                        <a href="<?php echo $clipitGBPoauth2; ?>/index.php?domain=<?php echo $domain; ?>&action=<?php echo $action; ?>" type="button" class="button-primary 1" id="" value="Connect GBP Account">Connect GBP Account</a>
                                    <?php
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
                <script>
                    jQuery(function($) {
                        var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";

                        function check_token() {
                            var data = {
                                'action': 'check_access_token',
                            };
                            jQuery.post(ajax_url, data, function(response) {});
                        }
                        check_token();

                        $(".refresh_page").click(function() {

                            var data = {
                                'action': 'get_locations',
                            };
                            jQuery.post(ajax_url, data, function(response) {
                                if (response) {
                                    window.location.href = $("#page_url").val();
                                }
                            });
                        });

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
                                    $('#responseText').text(response);
                                    $("#responseText").show().delay(1000).fadeOut();
                                });
                            }
                        });

                        $("#disconnect_gbp").click(function() {
                            if (confirm('Are you sure?')) {
                                var data = {
                                    'action': 'disconnect_gbp',
                                };
                            } else {
                                return false;
                            }
                            jQuery.post(ajax_url, data, function(response) {
                                if(response){

                                    window.location.href = $('#page_url').val();
                                }
                            });
                            window.location.href = $('#page_url').val();
                        });
                    });
                </script>
        </div>
        </form>

    </div>
<?php }
