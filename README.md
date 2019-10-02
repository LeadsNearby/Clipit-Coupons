# ClipIt Coupons

ClipIt Coupons uses CPT to create coupons for your visitors to print, view or use directly on your website or blog.

## Filters

### clipit_logo_url

Filters the logo used on the coupon. Use case would be, client has a white logo or logo that contains white and it needs to be visible on a white background.

## Shortcodes

### [clipit_coupons]

#### Attributes

* **post_id**: Specify a specific coupon to be displayed. *No default*
* **number_posts**: Specify number of coupons to be displayed. *Default is 15*
* **tag**: Pull coupons in by tag slug, e.g., **monthly-deals**. *No default*
* **category**: Pull coupons in by display category slug, e.g., **website**. *No default*

### [clipit_rotator]

#### Attributes

* **tag**: Pull coupons in by tag slug, e.g., **monthly-deals**. *No default*
* **auto_play**: *Boolean* - Auto play coupon rotator. *Default is true*
* **duration**: Coupon rotator timing in milliseconds. *Default is 3500*
