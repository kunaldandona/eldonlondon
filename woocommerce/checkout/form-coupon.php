<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */
?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! wc_coupons_enabled() ) {
	return;
}
$applied_coupons = WC()->cart->applied_coupons;
?>
<div class="vc_row checkout_coupon_wrapper woo-c_coupon">
	<div class="vc_col-md-12">
		<h3 class="heading-md">
			<?php esc_html_e( 'Apply Coupon', 'stockie' ); ?>
		</h3>
	</div>
	<div class="vc_col-md-8 woo-c_actions">
		<div class="woo-c_actions_coupon">
			<div class="checkout_coupon">
				<label for="coupon_code" class="field-label"><?php esc_html_e( 'Coupon code', 'stockie' ); ?></label>
				<input type="text" name="coupon_code" class="input-text left" placeholder="<?php esc_attr_e( 'Enter coupon code here', 'stockie' ); ?>" id="coupon_code" value="" />
				<button type="submit" class="btn" name="apply_coupon"><?php esc_attr_e( 'Apply Coupon', 'stockie' ); ?></button>
			</div>
		</div>
	</div>
	<div class="vc_col-md-4">
		<a href="#" class="btn next-btn">
			<span class="text"><?php esc_attr_e( 'Continue', 'stockie' ); ?></span>
			<i class="ion-right ion ion-ios-arrow-forward"></i>
		</a>
	</div>
</div>