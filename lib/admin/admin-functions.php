<?php
/*******************************
Admin Scripts
 ********************************/

add_action('admin_menu', 'clipit_settings_page');
function clipit_settings_page() {
    if (count($_POST) > 0 && isset($_POST['clipit_settings'])) {
        $options = array(
            'fineprint_default',
            'contact_form_default',
            'css_styling',
            'accent_color',
        );

        foreach ($options as $opt) {
            delete_option('clipit_' . $opt, $_POST[$opt]);
            add_option('clipit_' . $opt, $_POST[$opt]);
        }

    }
}
