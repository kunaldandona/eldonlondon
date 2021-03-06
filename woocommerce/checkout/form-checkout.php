<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<form id="coupon_form" class="checkout_coupon woocommerce-form-coupon" method="post" style="display: none;">
    <input name="coupon_code" type="hidden">
</form>

<div class="woo-c">
	<?php

	// If checkout registration is disabled and not logged in, the user cannot checkout
	if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
		echo wp_kses( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'stockie' ) ), 'post' );
		return;
	}
	$coupon = true;
	if (! wc_coupons_enabled() ) {
		$coupon = false;
	}

	?>
	<div class="woo-c_checkout <?php if (!$coupon) echo 'without-coupon' ?>">

		<div class="wpb_notices">
			<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
		</div>
		<form name="checkout" method="post" class="woo-c_checkout_form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php 
				if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div class="vc_row customer_details">
					<div class="tab vc_col-lg-8 vc_col-lg-push-2 vc_col-md-10 vc_col-md-push-1 vc_col-xs-12 vc_checkout_col" data-stockie-tab-box="true">
						<div class="tabNav_wrapper">
							<ul class="tabNav" role="tablist">
								<li class="tabNav_line brand-bg-color"></li>
								<li class="tabNav_link active">
									<div class="desctop-btn">
										<span class="tabNav_link_stage">1</span>
										<span class="font-titles"><?php esc_html_e( 'Billing details', 'stockie' ); ?></span>
									</div>
									<div class="mobile-btn font-titles"><span><?php esc_html_e( 'Billing', 'stockie' ); ?></span></div>
								</li>
								<li class="tabNav_link">
									<div class="desctop-btn">
										<span class="tabNav_link_stage">2</span>
										<span class="font-titles"><?php esc_html_e( 'Shipping address', 'stockie' ); ?></span>
									</div>
									<div class="mobile-btn font-titles"><span><?php esc_html_e( 'Shipping', 'stockie' ); ?></span></div>
								</li>
								<?php if ( $coupon ) : ?>
									<li class="tabNav_link">
										<div class="desctop-btn">
											<span class="tabNav_link_stage">3</span>
											<span class="font-titles"><?php esc_attr_e( 'Apply Coupon', 'stockie' ); ?></span>
										</div>
										<div class="mobile-btn font-titles"><span><?php esc_html_e( 'Coupon', 'stockie' ); ?></span></div>
									</li>
								<?php endif; ?>
								<li class="tabNav_link">
									<div class="desctop-btn">
										<span class="tabNav_link_stage"><?php echo esc_html( $coupon ? 4 : 3);?></span>
										<span class="font-titles"><?php esc_html_e( 'Review order', 'stockie' ); ?></span>
									</div>
									<div class="mobile-btn font-titles"><span><?php esc_html_e( 'Order', 'stockie' ); ?></span></div>
								</li>
							</ul>
						</div>
						<div class="tabItems" role="tabpanel" >
							<div class="tabItems_item active" data-title="<?php esc_html_e( 'Billing details', 'stockie' ); ?>">
								<div class="wpb_text_column wpb_content_element ">
									<div class="wpb_wrapper" id="customer_details">
										<div class="wpb_notices"><?php wc_print_notices(); ?></div>
										<?php do_action( 'woocommerce_checkout_billing' ); ?>
										<a href="#" class="btn next-btn">
											<span class="text"><?php esc_html_e( 'Continue', 'stockie' ); ?></span>
											<i class="ion-right ion ion-ios-arrow-forward"></i>
										</a>
									</div>
								</div>
							</div>
							<div class="tabItems_item" data-title="<?php esc_html_e( 'Shipping address', 'stockie' ); ?>">
								<div class="wpb_text_column wpb_content_element ">
									<div class="wpb_wrapper">
										<?php do_action( 'woocommerce_checkout_shipping' ); ?>
										<a href="#" class="btn next-btn">
											<span class="text"><?php esc_html_e( 'Continue', 'stockie' ); ?></span>
											<i class="ion-right ion ion-ios-arrow-forward"></i>
										</a>
									</div>
								</div>
							</div>
							<?php if ( $coupon ) : ?>
							<div class="tabItems_item" data-title="<?php esc_attr_e( 'Apply Coupon', 'stockie' ); ?>">
								<div class="wpb_text_column wpb_content_element ">
									<div class="wpb_wrapper">
									<?php do_action( 'woocommerce_after_checkout_form'); ?></div>
								</div>
							</div>
						<?php endif; ?>
							<div class="tabItems_item" data-title="<?php esc_html_e( 'Review order', 'stockie' ); ?>">
								<div class="wpb_text_column wpb_content_element ">
									<div class="wpb_wrapper">
										<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
										<div id="order_review" class="woo-check-order">
											<?php do_action( 'woocommerce_checkout_order_review' ); ?>
										</div>
										<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
									</div>
								</div>
							</div>
						</div>
				<?php endif; ?>
				</div>

		</form>
	</div>
</div>