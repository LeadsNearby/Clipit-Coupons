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
            <span class="lnbCoupon__save">
            <svg version="1.1" class="clpt-save-gfx" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 100 100" xml:space="preserve">
                <style>.clpt-save-gfx .letters {fill: #fff} .clpt-save-gfx .background {fill: var(--save-bkg)}</style>
                <path class="background" d="M100 0H1.3C.9.4.4.7 0 1.1c4.6 3.8 8.9 7.5 13.4 11.3-3.3 4.8-6.6 9.5-10 14.3 5.4 2.6 10.6 5 15.9 7.5-2 5.6-3.9 10.9-5.9 16.4 6 1.1 11.5 2.1 17.3 3.1-.5 5.8-.9 11.4-1.4 17.3 5.9-.4 11.7-.9 17.5-1.3C48 75.5 49 81 50.1 86.8c5.7-2 11.1-3.9 16.6-5.8 2.6 5.4 5 10.4 7.6 15.7 5-3.4 9.6-6.6 14.5-9.9 3.8 4.4 7.4 8.6 11.3 13.2L100 0z"/>
                <path class="letters" d="M45.6 16.4c.1-.6.9-1.7 1.2-2-.3-.5-.8-1.2-1.3-1.7-1-1-2.2-1.1-3.1-.2-.9.9-1.1 1.7-.1 3.5l1.3 2.4c1.2 2.2 1.8 4.7-.8 7.3-3 2.9-7 2.2-10-.7-1.6-1.5-3.2-3.9-3.6-6 .8-.9 2.6-2.1 3.7-2.5l2 2c-.2.6-.7 1.4-1.3 2.1.3.8.9 1.5 1.4 2 1.2 1.2 2.8 1.6 4 .4.7-.6 1.2-1.4.3-3.1l-1.5-2.8c-1.3-2.3-1.6-4.9.9-7.4 2.6-2.5 6.3-2.1 9.1.7 1.4 1.4 2.7 3.4 3.4 5.4-.8.9-2.6 2.1-3.7 2.5l-1.9-1.9zM53.5 40.1c.3.7.5 1.4.5 1.9l-2 1.5-4.9-4.8 1.5-1.9c.4-.1 1 .1 1.6.4l1.2-2.3-4.2-4.1L45 32c.3.6.4 1.3.4 1.8l-2 1.5-4.8-4.7 1.5-1.9c.6-.1 1.4.2 2.2.6l16.1-7.9 2.9 2.8-7.8 15.9zm-3.7-10.7l3 3 1.8-3.3c1.2-2.3 2.5-3.5 2.5-3.5l-.3-.3s-1.3 1.3-3.5 2.4l-3.5 1.7zM63.2 30.8c-.3-.7-.5-1.4-.5-1.9l2-1.5 4.9 4.8-1.6 2c-.5.1-1.1-.1-1.7-.4l-4.4 7.9c-1.2 2.2-2.5 3.5-2.5 3.5l.3.3s1.3-1.2 3.5-2.4l8.1-4.3c-.3-.6-.5-1.3-.4-1.8l2-1.5 4.8 4.7-1.5 1.9c-.6.1-1.4-.2-2.2-.6l-16 8-3-2.8 8.2-15.9zM73.8 65l-9.7-9.6 1.5-1.9c.5-.1 1.2.1 1.8.5l9.6-9.5c-.3-.7-.5-1.4-.4-1.8l2-1.5 9.6 9.4-3.6 3.6-1.7-1.3c0-.6.3-1.5.8-2.3l-3.3-3.2-3.6 3.6 2.9 2.9c.5-.2 1-.4 1.4-.4l1.2 1.4-3.7 3.7-1.5-1.1c0-.4.1-.9.4-1.4l-2.9-2.9-4 4 3.4 3.4c.8-.5 1.7-.8 2.3-.8l1.4 1.7-3.9 3.5zM80.3 65.7c1 1 1.3 2 .1 3.2-1.2 1.2-2.2.9-3.2-.1s-1.3-2-.1-3.2c1.2-1.1 2.2-.9 3.2.1zm.4-2.2c2-3.2 5.4-7 9.7-10.6l3 2.9c-3.7 4.2-7.6 7.6-10.8 9.5l-1.9-1.8z"/>
            </svg>
            </span>
            <span class="lnbCoupon__title"><?php the_title();?></span>
            <span class="lnbCoupon__description">
                <?php
                    if(($display === 'single' || $display === 'multi') || $display !== 'single-page') {
                        echo wp_strip_all_tags(get_the_content());
                    } else {
                        the_content();
                    }
                ?>
            </span>
            <span class="lnbCoupon__expiration<?php echo $coupon_dynamic_expiration == 'on' ? ' lnbCoupon__expiration--limited' : ''; ?>"><?php echo clipit_get_expiration_text($coupon_expiration, $coupon_dynamic_expiration, $coupon_dynamic_expiration_plus_days); ?></span>
            <?php if ($display !== 'multi') {?>
            <span class="lnbCoupon__finePrint"><?php echo $coupon_fineprint; ?></span>
            <span class="lnbCoupon__image">
                <img src="<?php echo $logo_url; ?>" />
            </span>
            <?php } else {?>
            <div class="lnbCoupon__actions lnbCoupon__actions--multi">
                <?php
                    $button_text = 'More Details';
                    $custom_button_text = get_post_meta($post->ID, 'coupon_button_text', true);
                    if($custom_button_text) $button_text = $custom_button_text;
                ?>
                <a href="<?php echo get_post_permalink($post) ?>" class="lnbCoupon__button lnbCoupon__button--smaller lnbCoupon__button--fullwidth"><?php echo $button_text; ?></a>
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