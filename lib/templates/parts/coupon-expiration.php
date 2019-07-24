<?php

$coupon_expiration = get_post_meta(get_the_ID(), 'coupon_expiration', true);
$coupon_expiration_text = 'Available for a Limited Time';
$act_text = 'Act now!';

if ($coupon_expiration) {
    $expiration = date_create(date('Y-m-d', strtotime($coupon_expiration)));
    $current_date = date_create(date('Y-m-d'));

    $interval = date_diff($current_date, $expiration);

    $diff = $interval->format('%a');

    $days = 'days';
    if ($diff < 2) {
        $days = 'day';
    }

    if ($diff == 0) {
        $coupon_expiration_text = 'Expires: ' . $coupon_expiration;
        $act_text = 'Act now, expires today!';
    }

    if ($diff > 0 && $diff < 16) {
        $coupon_expiration_text = 'Expires: ' . $coupon_expiration;
        $act_text = 'Act now, ' . $diff . ' ' . $days . ' left!';
    }
}

?>

<span class="clipit-coupon__expiration"><?php echo $coupon_expiration_text; ?></span>
<span class="clipit-coupon__act"><?php echo $act_text; ?></span>
