<?php
/**
 * Clipit shortcode
 */
// [clipit_coupons columns="3" class="" number_posts="9" post_id="" sidebar="" show_title="" show_desc="" show_featured="" show_exp="" show_fine="yes" show_img="" show_views="" tag="projects" trim_desc="" show_discount="" show_comments="" show_countdown=""]

add_shortcode('clipit_coupons', 'shortcode_clipit_coupons');
function shortcode_clipit_coupons($atts) {
    global $data;
    extract(shortcode_atts(array(
        'columns' => 1,
        'class' => '',
        'post_type' => 'coupon',
        'tag' => '',
        'number_posts' => 10,
        'post_id' => '',
        'style' => 'slide-caption',
        'sidebar' => '',
        'show_desc' => 'yes',
        'show_featured' => '',
        'trim_desc' => '',
        'show_fine' => 'yes',
        'show_img' => 'yes',
        'show_title' => 'yes',
        'show_exp' => 'yes',
        'show_views' => 'yes',
        'show_discount' => 'no',
        'show_comments' => 'yes',
        'category' => '',
    ), $atts));

    if ($columns == 1) {
        $columns_words = 'col-1-1';
    } elseif ($columns == 2) {
        $columns_words = 'col-1-2';
    } elseif ($columns == 3) {
        $columns_words = 'col-1-3';
    } elseif ($columns == 4) {
        $columns_words = 'col-1-4';
    }

    $html = '';
    wp_reset_query();
    $html .= '<div id="clipit" class="coupons grid clipshort clipit_shortcode ' . $class . '">';
    $html .= '<div itemtype="http://schema.org/Offer" itemscope="">';

    global $post; // Create and run custom loop

    // WP_Query arguments
    $args = array(
        'p' => $post_id,
        'post_type' => 'coupon',
        'tag' => $tag,
        'posts_per_page' => $number_posts,
        // 'tax_query' => array(
        //     array(
        //         'taxonomy' => 'display-category',
        //         'field' => 'slug',
        //         'terms'    => $category,
        //     ),
        // ),
    );

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
    if ($custom_posts->have_posts()): while ($custom_posts->have_posts()): $custom_posts->the_post();
            $coupon_promo_code = get_post_meta($post->ID, 'coupon_promo_code', true);
            $coupon_action = get_post_meta($post->ID, 'coupon_action', true);
            $coupon_type = get_post_meta($post->ID, 'coupon_type', true);
            $coupon_dynamic_expiration = get_post_meta($post->ID, 'coupon_dynamic_expiration', true);
            $coupon_dynamic_expiration_plus_days = get_post_meta($post->ID, 'coupon_dynamic_expiration_plus_days', true);
            $coupon_expiration = get_post_meta($post->ID, 'coupon_expiration', true);
            $coupon_destination_url = get_post_meta($post->ID, 'coupon_destination_url', true);
            $coupon_feature = get_post_meta($post->ID, 'coupon_feature', true);
            $coupon_views = get_post_meta($post->ID, 'coupon_views', true);
            $coupon_like = get_post_meta($post->ID, 'coupon_like', true);
            $coupon_name = get_post_meta($post->ID, 'coupon_name', true);
            $coupon_savings = get_post_meta($post->ID, 'coupon_savings', true);
            $coupon_value = get_post_meta($post->ID, 'coupon_value', true);
            $coupon_fineprint = get_post_meta($post->ID, 'coupon_fineprint', true);
            $coupon_promo_text = get_post_meta($post->ID, 'coupon_promo_text', true);
            $coupon_button_text = get_post_meta($post->ID, 'coupon_button_text', true);
            $coupon_css_id = get_post_meta($post->ID, 'coupon_css_id', true);
            $coupon_css_class = get_post_meta($post->ID, 'coupon_css_class', true);
            $plusdate = strtotime($coupon_dynamic_expiration_plus_days);
            $dynamic_expirary_date = date('m/d/Y', $plusdate);

            //Sets Expiration
            $expirationtime = get_post_custom_values('coupon_expiration');
            if (is_array($expirationtime)) {
                $expirestring = implode($expirationtime);
            }

            $secondsbetween = strtotime($expirestring) - time();
            if ($secondsbetween > 0) {

                //Limits Views Only to non Admin Users
                if (!current_user_can('manage_options')) {
                    setCouponViews(get_the_ID());
                }

                //Calculate Discount

                $coupon_total = null;

                if (is_int($coupon_value) && is_int($coupon_savings)) {
                    $coupon_total = $coupon_value - $coupon_savings;
                }

                if ($coupon_type == 'Build' && $sidebar == 'yes') {
                    $html .= '<article id="clipit-style-two" class="' . $coupon_css_class . ' sidewidget ' . $columns_words . '">';
                } elseif ($coupon_type == 'Build') {
                $html .= '<article id="clipit-style-two" class="' . $coupon_css_class . ' border-container coupon-container ' . $columns_words . '">';
            } elseif ($sidebar == 'yes') {
            $html .= '<article id="' . $coupon_css_id . '" class="' . $coupon_css_class . ' sidewidget ' . $columns_words . '">';
        } else {
            $html .= '<article id="' . $coupon_css_id . '" class="' . $coupon_css_class . ' border-container coupon-container ' . $columns_words . '">';
        }

        if ($coupon_type == 'Upload') {
            if ($sidebar == 'yes') {
                if ($coupon_action == 'url') {
                    $html .= '<a class="coupon_sidebar_img" href="' . $coupon_destination_url . '">';
                    if (has_post_thumbnail()) {
                        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $html .= '<img itemprop="image" alt="' . get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())) . '" id="image-slide" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                    } else {
                        $html .= '<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
                    }
                    $html .= '</a>';
                    $html .= '<div style="display:none" itemprop="itemOffered">' . get_the_title() . '</div>';
                    $html .= '<div style="display:none" itemprop="validFrom">' . get_the_date('m/d/Y') . '</div>';
                    if ($coupon_dynamic_expiration == 'on' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration today" itemprop="validThrough">' . $dynamic_expirary_date . '</div>';
                        $html .= '</span>';
                    } elseif ($coupon_dynamic_expiration == 'off' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration" itemprop="validThrough">' . $coupon_expiration . '</div>';
                        $html .= '</span>';
                    }
                } elseif ($coupon_action == 'print') {
                    $html .= '<a class="coupon_sidebar_img" href="' . get_permalink() . '">';
                    if (has_post_thumbnail()) {
                        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $html .= '<img itemprop="image" alt="' . get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())) . '" id="image-slide" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                    } else {
                        $html .= '<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
                    }
                    $html .= '</a>';
                    $html .= '<div style="display:none" itemprop="itemOffered">' . get_the_title() . '</div>';
                    $html .= '<div style="display:none" itemprop="validFrom">' . get_the_date('m/d/Y') . '</div>';
                    if ($coupon_dynamic_expiration == 'on' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration today" itemprop="validThrough">' . $dynamic_expirary_date . '</div>';
                        $html .= '</span>';
                    } elseif ($coupon_dynamic_expiration == 'off' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration" itemprop="validThrough">' . $coupon_expiration . '</div>';
                        $html .= '</span>';
                    }
                }
            } else {
                if ($coupon_action == 'url') {
                    $html .= '<a class="coupon_main_img" href="' . $coupon_destination_url . '">';
                    if (has_post_thumbnail()) {
                        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $html .= '<img itemprop="image" alt="' . get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())) . '" id="image-slide" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                    } else {
                        $html .= '<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
                    }
                    $html .= '</a>';
                    $html .= '<div style="display:none" itemprop="itemOffered">' . get_the_title() . '</div>';
                    $html .= '<div style="display:none" itemprop="validFrom">' . get_the_date('m/d/Y') . '</div>';
                    if ($coupon_dynamic_expiration == 'on' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration today" itemprop="validThrough">' . $dynamic_expirary_date . '</div>';
                        $html .= '</span>';
                    } elseif ($coupon_dynamic_expiration == 'off' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration" itemprop="validThrough">' . $coupon_expiration . '</div>';
                        $html .= '</span>';
                    }
                } elseif ($coupon_action == 'print') {
                    $html .= '<a class="coupon_main_img" href="' . get_permalink() . '">';
                    if (has_post_thumbnail()) {
                        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $html .= '<img itemprop="image" alt="' . get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())) . '" id="image-slide" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                    } else {
                        $html .= '<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
                    }
                    $html .= '</a>';
                    $html .= '<div style="display:none" itemprop="itemOffered">' . get_the_title() . '</div>';
                    $html .= '<div style="display:none" itemprop="validFrom">' . get_the_date('m/d/Y') . '</div>';
                    if ($coupon_dynamic_expiration == 'on' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration today" itemprop="validThrough">' . $dynamic_expirary_date . '</div>';
                        $html .= '</span>';
                    } elseif ($coupon_dynamic_expiration == 'off' && $show_exp == 'yes') {
                        $html .= '<span class="div" style="display:none;">';
                        $html .= '<div class="expiration" itemprop="validThrough">' . $coupon_expiration . '</div>';
                        $html .= '</span>';
                    }
                }
            }
        } elseif ($coupon_type == 'Build') {
            $html .= '<div class="single-coup-container">';
            if ($coupon_feature == 'on' && $show_featured == 'yes') {
                $html .= '<div class="featured-banner"></div>';
            }
            if ($show_img == 'yes') {
                $html .= '<div class="col-1-3 single-coup-img">';
                if (has_post_thumbnail()) {
                    $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                    $html .= '<img itemprop="image" alt="' . get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())) . '" id="image-slide" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                } else {
                    $html .= '<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
                }
                $html .= '</div>';
            }
            $html .= '<div class="col-2-3 last single-coup-content">';
            if ($show_title == 'yes') {
                $html .= '<div class="coupon-title" itemprop="itemOffered">' . get_the_title() . '</div>';
            }
            if ($show_desc == 'yes' && $trim_desc == 'yes') {
                $html .= '<p class="description trim" itemprop="description">' . wp_trim_words(get_the_content(), $num_words = 55, $more = null) . '</p>';
            } elseif ($show_desc == 'yes') {
                $html .= '<p class="description" itemprop="description">' . get_the_content() . '</p>';
            }
            if (get_post_meta($post->ID, 'coupon_fineprint', true) && $show_fine == 'yes') {
                $html .= '<hr />';
                $html .= '<div class="fineprint">' . wpautop($coupon_fineprint) . '</div>';
            } elseif (get_option('clipit_fineprint_default') != "" && $show_fine == 'yes') {
                $html .= '<hr />';
                $html .= '<div class="fineprint">' . wpautop(stripslashes(get_option('clipit_fineprint_default'))) . '</div>';
            }
            if ($show_discount == 'yes' && get_post_meta($post->ID, 'coupon_value', true) && get_post_meta($post->ID, 'coupon_savings', true)) {
                $html .= '<div class="deal-discount">';
                $html .= '<table>';
                $html .= '<tbody>';
                $html .= '<tr>';
                $html .= '<th>Value</th>';
                $html .= '<th>Discount</th>';
                $html .= '<th>You Save</th>';
                $html .= '</tr>';
                $html .= '<tr id="discount-data">';
                $html .= '<td id="discount-value">$' . $coupon_value . '</td>';
                $html .= '<td id="discount-percent">$' . $coupon_savings . '</td>';
                $html .= '<td id="discount-you-save">$' . $coupon_total . '</td>';
                $html .= '</tr>';
                $html .= '</tbody>';
                $html .= '</table>';
                $html .= '</div>';
            }
            $html .= '</div>';
            $html .= '<div class="clear"></div>';
            $html .= '</div>';
            $html .= '<div class="coupon-highlight">';
            $html .= '<div style="display:none" itemprop="validFrom">' . get_the_date('m/d/Y') . '</div>';
            $html .= '<div class="col-3-4">';
            if ($coupon_dynamic_expiration == 'on' && $show_exp == 'yes') {
                $html .= '<span class="div">';
                $html .= '<div class="expiration today" itemprop="validThrough">' . $dynamic_expirary_date . '</div>';
                $html .= '</span>';
            } elseif ($coupon_dynamic_expiration == 'off' && $show_exp == 'yes') {
                $html .= '<span class="div">';
                $html .= '<div class="expiration" itemprop="validThrough">' . $coupon_expiration . '</div>';
                $html .= '</span>';
            }
            if ($coupon_views == 'on' && $show_views == 'yes') {
                $html .= '<span class="div">';
                $html .= '<div class="views">' . getCoupontViews(get_the_ID()) . '</div>';
                $html .= '</span>';
            }
            $html .= '</div>';
            $html .= '<div class="col-1-4 last action-buttons" style="margin-bottom:0">';
            if ($coupon_action == 'url') {
                $html .= '<div class="couponbutton">';
                if (get_post_meta($post->ID, 'coupon_button_text', true)) {
                    $html .= '<a target="_blank" href="' . $coupon_destination_url . '" itemprop="potentialAction">' . $coupon_button_text . '</a>';
                } else {
                    $html .= '<a target="_blank" href="' . $coupon_destination_url . '" itemprop="potentialAction">View Deal</a>';
                }
                $html .= '</div>';
                $html .= '</div>';
            } elseif ($coupon_action == 'print') {
                $html .= '<div class="couponbutton">';
                if (get_post_meta($post->ID, 'coupon_button_text', true)) {
                    $html .= '<a href="' . get_permalink() . '">' . $coupon_button_text . '</a>';
                } else {
                    $html .= '<a target="_blank" href="' . get_permalink() . '" itemprop="potentialAction">Print Coupon</a>';
                }
                $html .= '</div>';
                $html .= '</div>';
            } elseif ($coupon_action == 'promo') {
                $html .= '<div class="clicktoreveal">';
                $html .= '<a class="code countable_link" style="text-align: center; text-decoration:none;" id="hide-option" href="' . get_permalink() . '" title="' . $coupon_promo_text . '" itemprop="potentialAction">' . $coupon_promo_code . '</a>';
                $html .= '</div>';
                $html .= '</div>';
            } elseif ($coupon_action == 'peel') {
                add_thickbox();
                $html .= '<div class="clicktoreveal">';
                $html .= '<a href="#TB_inline?width=706&height=661&inlineId=' . get_the_ID() . '" class="thickbox countable_link" itemprop="potentialAction">Click to Reveal</a>';
                $html .= '</div>';
                $html .= '<div id="' . get_the_ID() . '" style="display:none;">';
                $html .= '<p class="promo-text entryinfo">You selected the following coupon:</p>';
                //Start Coupon Copy
                $html .= '<div id="clipit-style-two" class="col-1-1 border-container">';
                if ($coupon_type == 'Build') {
                    $html .= '<div class="single-coup-container">';
                    $html .= '<div class="col-1-3 single-coup-img">';
                    // Default, blog-size thumbnail
                    if (has_post_thumbnail()) {
                        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $html .= '<img alt="' . get_post_field('post_excerpt', get_post_thumbnail_id(get_the_ID())) . '" id="image-slide" src="' . $image_src[0] . '" style="height:auto; width:100%; margin:0; display:block;" />';
                    } else {
                        $html .= '<img id="image-slide" itemprop="image" src="' . plugins_url('clipit-coupons/lib/inc/images/default-image.png') . '" style="max-width:480px; height:auto; width:100%; margin:0; display:block;" />';
                    }
                    $html .= '</div>';
                    $html .= '<div class="col-2-3 last single-coup-content">';
                    $html .= '<div class="coupon-title" itemprop="itemOffered">' . get_the_title() . '</div>';
                    $html .= '<p class="description" itemprop="description">' . get_the_content . '</p>';
                    $html .= '</div>';
                    $html .= '<div class="clear"></div>';
                    $html .= '</div>';
                }
                $html .= '</div>';
                //End Coupon Copy
                if (get_post_meta($post->ID, 'coupon_promo_text', true)) {
                    $html .= '<p class="promo-text">' . $coupon_promo_text . '</p>';
                } else {
                    $html .= '<p class="promo-text">Copy this code, make your purchase and then enter it at the final checkout stage of your purchase.</p>';
                }
                $html .= '<div class="popup-code" style="text-align: center;">' . $coupon_promo_code . '</div>';
                $html .= '<div class="popup-expirydate">Expires on:';
                if ($coupon_dynamic_expiration == 'on') {
                    $html .= '<span class="exptext" itemprop="validThrough">' . date('m/d/Y') . '</span>';
                } else {
                    $html .= '<span class="exptext" itemprop="validThrough">' . $coupon_expiration . '</span>';
                }
                $html .= '</div>';
                $html .= '<div class="clear"></div>';
                $html .= '</div>'; //promo-code
                $html .= '</div>';
            }
            $html .= '<div class="clear"></div>';
            $html .= '</div>';
        }
        $html .= '</article>';
    }
    endwhile;endif;

    wp_reset_postdata();
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}
?>