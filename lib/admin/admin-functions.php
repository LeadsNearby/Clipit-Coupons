<?php

/*******************************
Admin Scripts
 ********************************/

add_action('admin_menu', 'clipit_settings_page');
function clipit_settings_page()
{
    if (isset($_POST['clipit_settings'])) {
        $options = array(
            'fineprint_default',
            'contact_form_default',
            'css_styling',
            'accent_color',
        );

        foreach ($options as $opt) {
            $value = isset($_POST[$opt]) ? $_POST[$opt] : '';
            update_option('clipit_' . $opt, $value);
        }
    }
}

// if access token expire use refresh token
add_action('wp_ajax_check_access_token', 'check_access_token');
add_action('wp_ajax_nopriv_check_access_token', 'check_access_token');
function check_access_token()
{
    if (get_option('gbp_access_token') == '') {
        wp_die('Access Token Not Found');
    }
    if (get_option('gbp_refresh_token') == '') {
        wp_die('Refresh Token Not Found');
    }

    $access_token = get_option('gbp_access_token');
    $refresh_token = get_option('gbp_refresh_token');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, CLIPIT_GBP_OAUTH2_URL . "/index.php?action=refresh_token&access_token=" . $access_token . "&refresh_token=" . $refresh_token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = is_string($response) ? json_decode($response) : null;
    if (!is_array($result) || !isset($result[0]) || !is_object($result[0])) {
        wp_die('Unable to refresh the access token.');
    }

    if (isset($result[0]->status) && (int) $result[0]->status === 201 && isset($result[0]->access_token)) {
        update_option("gbp_access_token", $result[0]->access_token);
        echo "token updated";
    } else {
        echo isset($result[0]->message) ? $result[0]->message : 'Unable to refresh the access token.';
    }

    wp_die();
}

// get locations
add_action('wp_ajax_get_locations', 'get_locations', 1, 3);
add_action('wp_ajax_nopriv_get_locations', 'get_locations', 1, 3);

$locations = array();
$i = 0;
function get_locations($token = null, $i = 0, $locations = array())
{

    $allLocations = array();
    $token = null;

    $featchedData = get_more_locations($token, 0, $allLocations);

    if (is_array($featchedData)) {
        update_option('gbp_locations', $featchedData, false);
    } 

    return $featchedData;
}

function get_more_locations($token = null, $i = 0, $locations = array())
{
    $access_token = get_option('gbp_access_token');
    $accounts = get_option('gbp_accounts');
    $account_id = is_object($accounts) && isset($accounts->accounts)
        ? $accounts->accounts
        : $accounts;
    $account_id = is_string($account_id) ? $account_id : '';
    $account_id = str_replace('accounts/', '', $account_id);

    if ($account_id === '') {
        return array();
    }

    $curl = curl_init();
    $url = 'https://mybusinessbusinessinformation.googleapis.com/v1/accounts/' . $account_id . '/locations?readMask=name,title&pageSize=100&pageToken=' . $token;

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $access_token,
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        $oldLocations = get_option('gbp_locations');
        return is_array($oldLocations) ? $oldLocations : array();
    } else {
        $responseObj = is_string($response) ? json_decode($response) : null;
        if (!is_object($responseObj) || !isset($responseObj->locations) || !is_array($responseObj->locations)) {
            return $locations;
        }

        foreach ($responseObj->locations as $loc) {
            if (!is_object($loc) || !isset($loc->name, $loc->title)) {
                continue;
            }
            $locations[$i]['name'] = str_replace('locations/', '', $loc->name);
            $locations[$i]['title'] = $loc->title;
            $i++;
        }

        if (!empty($responseObj->nextPageToken)) {
            $token = $responseObj->nextPageToken;
            return get_more_locations($token, $i, $locations);
        }

        return $locations;
    }
}

// save selected location
add_action('wp_ajax_save_location', 'save_location');
add_action('wp_ajax_nopriv_save_location', 'save_location');
function save_location()
{
    $location_values = isset($_POST['location_value']) && is_array($_POST['location_value'])
        ? $_POST['location_value']
        : array();
    $gbp_selected_value = array_values($location_values);
    // $gbp_selected_value = json_encode($gbp_selected_value);
    update_option('gbp_selected_location', $gbp_selected_value, true);
    echo "location save successfully";
    wp_die();
}

// disconnect the gbp
add_action('wp_ajax_disconnect_gbp', 'disconnect_gbp');
add_action('wp_ajax_nopriv_disconnect_gbp', 'disconnect_gbp');
function disconnect_gbp()
{
    $access_token = get_option('gbp_access_token');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://oauth2.googleapis.com/revoke?token=' . $access_token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    update_option("gbp_access_token", "", true);
    update_option("gbp_refresh_token", "", true);
    update_option("gbp_id_token", "", true);
    update_option("gbp_scope", "", true);
    update_option("gbp_accounts", "", true);
    update_option("gbp_locations", "", true);
    update_option("gbp_selected_location", "", true);
    update_option('gbp_isConnected', false, false);
    wp_die();
}


// create connection
add_action('wp_ajax_connection_create', 'connection_create');
add_action('wp_ajax_nopriv_connection_create', 'connection_create');
function connection_create()
{

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => CLIPIT_GBP_OAUTH2_URL . '/?domain=' . $_SERVER["HTTP_HOST"] . '&action=connect',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    $response = curl_exec($curl);
    // echo $response;
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    // $response = json_decode($response, true);
    wp_die();
}

// store client id
add_action('wp_ajax_store_client_id', 'store_client_id');
add_action('wp_ajax_nopriv_store_client_id', 'store_client_id');
function store_client_id()
{
    update_option('gbp_client_id', $_POST['client_id']);
    echo $_POST['client_id'];
    wp_die();
}

add_action('wp_ajax_save_authentications', 'save_authentications');
add_action('wp_ajax_nopriv_save_authentications', 'save_authentications');
function save_authentications()
{
    $access_token = $_POST['access_token'];
    $expires_in = $_POST['expires_in'];
    $scope = $_POST['scope'];

    if ($access_token == null) {
        echo "Access Token Not Available.";
    } else {
        update_option('gbp_location_found', 'false');
        update_option("access_token", $access_token);
        update_option("expires_in", $expires_in);
        update_option("scope", $scope);

        // gbp account api
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mybusinessaccountmanagement.googleapis.com/v1/accounts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $account = $response['accounts'][0]['name'];
        update_option("gbp_accounts", $account);
        curl_close($curl);

        //  gbp location api
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://mybusinessbusinessinformation.googleapis.com/v1/' . $account . '/locations?readMask=name',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $locations = $response['locations'][0]['name'];
        update_option("gbp_locations", $locations);
        curl_close($curl);
        if ($locations != null) {
            update_option('gbp_location_found', true);
        }
        $result = array([
            "account_id" => $account,
            "location_id" => $locations
        ]);
        echo json_encode($result);
    }
    wp_die();
}
