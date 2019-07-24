<?php
/**
 * Clipit shortcode
 */
// [clipit_coupons number_posts="9" post_id="" tag="projects"]

add_shortcode('clipit_coupons', 'shortcode_clipit_coupons');
function shortcode_clipit_coupons($atts) {
    wp_enqueue_style('clipit-styles');
    wp_enqueue_style('clipit-print-styles');

    extract(shortcode_atts(array(
        'tag' => '',
        'number_posts' => 15,
        'post_id' => '',
        'category' => '',
    ), $atts));

    ob_start();
    echo '<div id="clipit" class="clipit-coupons">';

    // WP_Query arguments
    $args = array(
        'p' => $post_id,
        'post_type' => 'coupon',
        'posts_per_page' => $number_posts,
    );

    if (!empty($tag)) {
        $args['tag'] = $tag;
    }

    if ($category !== 'mobile' && !empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'display-category',
                'field' => 'slug',
                'terms' => $category,
            ),
        );
    }

    // The Query
    $custom_posts = new WP_Query($args);

    if ($custom_posts->have_posts()):
        while ($custom_posts->have_posts()): $custom_posts->the_post();
            $coupon_expiration = get_post_meta(get_the_ID(), 'coupon_expiration', true);
            $unix_coupon_expiration = strtotime($coupon_expiration . ' 11:59 pm');
            if (empty($coupon_expiration) || $unix_coupon_expiration > current_time('timestamp')) {
                include ClipIt_TEMPLATES . '/parts/coupon.php';
            }
        endwhile;
    else:
        echo 'No coupons to display';
    endif;
    wp_reset_postdata();

    echo '</div>';
    return ob_get_clean();
}
