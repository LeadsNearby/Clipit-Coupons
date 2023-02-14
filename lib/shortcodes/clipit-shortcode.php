<?php
/**
 * Clipit shortcode
 */
// [clipit_coupons number_posts="9" post_id="" tag="projects"]

add_shortcode('clipit_coupons', 'shortcode_clipit_coupons');
function shortcode_clipit_coupons($atts) {
    wp_enqueue_style('clipit-styles');

    extract(shortcode_atts(array(
        'tag' => '',
        'number_posts' => 15,
        'post_id' => '',
        'category' => '',
        'grid' => '1',
    ), $atts));

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

    ob_start();
    if ($custom_posts->have_posts()):
        $accent_color = get_option('clipit_accent_color');
        $coupon_icon = get_post_meta(get_the_ID(), 'coupon_icon', true);
        echo '<div id="clipit" class="clipit-coupons grid-columns__'.$grid.'"', !empty($accent_color) ? "style='--color-accent:{$accent_color}'" : '', '>';
        while ($custom_posts->have_posts()): $custom_posts->the_post();
            $coupon_expiration = get_post_meta(get_the_ID(), 'coupon_expiration', true);
            $unix_coupon_expiration = strtotime($coupon_expiration . ' 11:59 pm');
            if (empty($coupon_expiration) || $unix_coupon_expiration > current_time('timestamp')) {
                include ClipIt_TEMPLATES . '/parts/coupon.php';
            }
        endwhile;
        echo '</div>';
    else:
        echo 'No coupons to display';
    endif;
    wp_reset_postdata();

    return ob_get_clean();
}
