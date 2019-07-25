<?php

$theme = strtolower(wp_get_theme()->get('Template'));
switch ($theme) {
    case 'avada':
        if (class_exists('Avada')) {
            $logo_src = Avada()->settings->get('logo', 'url');
        }
        break;
    case 'hypercore':
        $logo_src = '';
    default:
        '';
        break;
}
?>
<img src="<?php echo $logo_src; ?>">