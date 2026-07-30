<?php
/**
 * Single coupon template.
 */

defined('ABSPATH') || exit;

wp_enqueue_script('print');
wp_enqueue_style('print');

$classes = array(
    'clipit-coupon',
    'clipit-coupon--single',
);

$accent_color = get_option('clipit_accent_color', '');

$coupon_fineprint = isset($coupon_fineprint)
    ? (string) $coupon_fineprint
    : '';

$coupon_shorts = isset($coupon_shorts)
    ? (string) $coupon_shorts
    : '';

$is_print = !empty($print);
?>

<?php the_content(); ?>

<article
    class="<?php echo esc_attr(implode(' ', $classes)); ?>"
    <?php if (!empty($accent_color)) : ?>
        style="<?php echo esc_attr('--color-accent:' . $accent_color . ';'); ?>"
    <?php endif; ?>
>
    <span class="clipit-coupon__icon" aria-hidden="true">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            focusable="false"
        >
            <path d="M263.39 256L445.66 73.37c3.12-3.12 3.12-8.19 0-11.31-18.74-18.74-49.14-18.74-67.88 0L223.82 216.35l-43.1-43.18C187.92 159.71 192 144.33 192 128c0-53.02-42.98-96-96-96S0 74.98 0 128s42.98 96 96 96c16.31 0 31.66-4.07 45.11-11.24L184.26 256l-43.15 43.24C127.66 292.07 112.31 288 96 288c-53.02 0-96 42.98-96 96s42.98 96 96 96 96-42.98 96-96c0-16.33-4.08-31.71-11.28-45.17l43.1-43.18 153.95 154.29c18.74 18.74 49.14 18.74 67.88 0 3.12-3.12 3.12-8.19 0-11.31L263.39 256zM96 176c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48zm0 256c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48z"/>
        </svg>
    </span>

    <?php
    $coupon_title_template = __DIR__ . '/coupon-title.php';

    if (file_exists($coupon_title_template)) {
        include $coupon_title_template;
    }
    ?>

    <span class="clipit-coupon__subtitle">
        <?php echo esc_html(get_the_excerpt()); ?>
    </span>

    <?php
    $facebook_like_enabled = (
        get_post_meta(get_the_ID(), 'coupon_fb_like', true) === 'yes'
    );
    ?>

    <?php if ($facebook_like_enabled) : ?>
        <?php
        $facebook_like_url = add_query_arg(
            array(
                'href'   => get_permalink(get_the_ID()),
                'width'  => 219,
                'layout' => 'button_count',
                'action' => 'recommend',
                'size'   => 'large',
                'share'  => 'true',
                'height' => 46,
                'appId'  => '221733661184896',
            ),
            'https://www.facebook.com/plugins/like.php'
        );
        ?>

        <div class="clipit-coupon__fblike">
            <iframe
                src="<?php echo esc_url($facebook_like_url); ?>"
                width="219"
                height="46"
                style="border:none; overflow:hidden;"
                scrolling="no"
                frameborder="0"
                allowfullscreen
                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                title="<?php echo esc_attr__('Recommend this coupon on Facebook', 'clipit'); ?>"
            ></iframe>
        </div>
    <?php endif; ?>

    <?php
    $coupon_expiration_template = __DIR__ . '/coupon-expiration.php';

    if (file_exists($coupon_expiration_template)) {
        include $coupon_expiration_template;
    }
    ?>

    <span class="clipit-coupon__fine">
        <span>
            <?php
            if (!empty($coupon_fineprint)) {
                echo esc_html(wp_strip_all_tags($coupon_fineprint));
            } else {
                echo esc_html__(
                    'To redeem, call or request an appointment on our website and mention this coupon. The offer is valid for one-time use only. It is not redeemable for cash, is not valid toward previous purchases, and must be requested while making the appointment. The offer may not be combined with other coupons, discounts, offers, or promotions. This offer is not valid on customer-supplied items.',
                    'clipit'
                );
            }
            ?>
        </span>

        <?php
        $coupon_logo_template = __DIR__ . '/coupon-logo.php';

        if (file_exists($coupon_logo_template)) {
            include $coupon_logo_template;
        }
        ?>
    </span>
</article>

<?php if (!$is_print) : ?>
    <button
        class="clipit-coupon__button clipit-coupon__button--print clipit-coupon__button--single"
        type="button"
        onclick="window.print();"
    >
        <?php echo esc_html__('Print Coupon', 'clipit'); ?>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
            aria-hidden="true"
            focusable="false"
        >
            <path d="M400 264c-13.25 0-24 10.74-24 24 0 13.25 10.75 24 24 24s24-10.75 24-24c0-13.26-10.75-24-24-24zm32-88V99.88c0-12.73-5.06-24.94-14.06-33.94l-51.88-51.88c-9-9-21.21-14.06-33.94-14.06H110.48C93.64 0 80 14.33 80 32v144c-44.18 0-80 35.82-80 80v128c0 8.84 7.16 16 16 16h64v96c0 8.84 7.16 16 16 16h320c8.84 0 16-7.16 16-16v-96h64c8.84 0 16-7.16 16-16V256c0-44.18-35.82-80-80-80zM128 48h192v48c0 8.84 7.16 16 16 16h48v64H128V48zm256 416H128v-64h256v64zm80-112H48v-96c0-17.64 14.36-32 32-32h352c17.64 0 32 14.36 32 32v96z"/>
        </svg>
    </button>
<?php endif; ?>

<?php if (!empty($coupon_shorts)) : ?>
    <h3 class="clipit-schedule-title">
        <?php echo esc_html__('Schedule Service', 'clipit'); ?>
    </h3>

    <?php
    echo do_shortcode(
        wp_kses_post(
            stripslashes($coupon_shorts)
        )
    );
    ?>
<?php endif; ?>