<?php

function clipit_get_expiration_text($coupon_expiration, $coupon_dynamic_expiration = null, $coupon_dynamic_expiration_plus_days = null) {
    if ($coupon_expiration) {
        $expiration = date_create(date('Y-m-d', strtotime($coupon_expiration)));
        $current_date = date_create(date('Y-m-d'));

        $interval = date_diff($current_date, $expiration);

        $diff = $interval->format('%a');

        $days = 'days';
        if ($diff < 2) {
            $days = 'day';
        }

        if ($diff > 0 && $diff < 16) {
            return 'Expires: ' . $coupon_expiration . '<span class="lnbCoupon__expirationSub">Act now, ' . $diff . ' ' . $days . ' left!</span>';
        }

        return 'Expires: ' . $coupon_expiration;
    }

    return 'Limited time offer.';
}

function clipit_render_single_coupon($post, $display = 'single', $to_be_deprecated = array()) {
    extract($to_be_deprecated);
    ob_start();?>
    <article class="lnbCoupon" data-coupon-id="<?php echo $post->ID; ?>">
        <span class="lnbCoupon__icon"><i class="far fa-cut"></i></span>
        <div class="lnbCoupon__content">
            <span class="lnbCoupon__title"><?php the_title();?></span>
            <span class="lnbCoupon__description"><?php the_content();?></span>
            <span class="lnbCoupon__expiration<?php echo $coupon_dynamic_expiration == 'on' ? ' lnbCoupon__expiration--limited' : ''; ?>"><?php echo clipit_get_expiration_text($coupon_expiration, $coupon_dynamic_expiration, $coupon_dynamic_expiration_plus_days); ?></span>
            <?php if ($display !== 'multi') {?>
            <span class="lnbCoupon__finePrint"><?php echo $coupon_fineprint; ?></span>
            <span class="lnbCoupon__image">
                <img src="<?php echo $logo_url; ?>" />
            </span>
            <?php } else {?>
            <div class="lnbCoupon__actions lnbCoupon__actions--multi">
                <a href="<?php echo get_post_permalink($post) ?>" class="lnbCoupon__button lnbCoupon__button--smaller lnbCoupon__button--fullwidth">More Details</a>
            </div>
            <?php }?>
        </div>
        <?php if ($display !== 'multi') {?>
        <div class="lnbCoupon__actions">
            <a href="javascript:window.print()" class="lnbCoupon__button">Print Coupon <span style="display: inline-block; width: 0.5rem;"></span><i class="fas fa-print"></i></a>
        </div>
        <?php }?>
    </article>
    <?php return ob_get_clean();
}