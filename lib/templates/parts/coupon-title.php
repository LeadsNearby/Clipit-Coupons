<?php
$raw_title = get_the_title();
$title = $raw_title;
$title_accent = '';
// preg_match('/^((.*?(free|off|[\$\%0-9\.]+)))/i', $raw_title, $title_matches);
preg_match('/^.*([\$\%0-9\,\.]+|free(?(?=\s)|off(?(?=\s))))/i', $raw_title, $title_matches);
if (!empty($title_matches[0])) {
    $title = trim(str_replace($title_matches[0], '', $raw_title));
    $title_accent = $title_matches[0];
}
?>

<span class="clipit-coupon__title">
    <?php if (!empty($title_accent)): ?>
    <strong><?php echo $title_accent; ?></strong>
    <?php endif;?>
    <?php echo esc_html($title); ?>
</span>