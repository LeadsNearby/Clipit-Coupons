<?php

$theme = strtolower(wp_get_theme()->get('Template'));
switch ($theme) {
    case 'avada':
        if (class_exists('Avada')) {
            $logo_src = Avada()->settings->get('logo', 'url');
        }
        break;
    case 'hypercore':
        $logo_id = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_url($logo_id, 'medium');
    default:
        '';
        break;
}
?>
<img src="<?php echo apply_filters('clipit_logo_url', $logo_src); ?>">