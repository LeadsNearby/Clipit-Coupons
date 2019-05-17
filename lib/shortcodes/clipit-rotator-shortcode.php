<?php
function clipit_rotator_shortcode_html($attributes) {
    extract(shortcode_atts(
        array(
            'tag' => '',
        ),
        $attributes));
    if (is_numeric($tag)) {
        $tag_id = $tag;
    } else {
        $term = get_term_by('slug', $tag, 'post_tag');
        $tag_id = $term->term_id;
    }
    wp_enqueue_style('clipit-rotator');
    wp_enqueue_script('clipit-rotator-js');
    return '<div data-api-url="' . get_rest_url(null, 'wp/v2/coupons') . '" data-coupon-rotator="' . $tag_id . '"></div>';
}

add_shortcode('clipit_rotator', 'clipit_rotator_shortcode_html');
