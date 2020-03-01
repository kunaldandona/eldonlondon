<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="vc_row">
	<div class="vc_col-lg-8 vc_col-lg-push-2 vc_col-md-10 vc_col-md-push-1 vc_col-xs-12">
		<div class="woo-c_checkout_result">

		<?php if ( $order ) : ?>
				
			<?php if ( $order->has_status( 'failed' ) ) : ?>

				<p class="woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'stockie' ); ?></p>

				<p class="woocommerce-thankyou-order-failed-actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'stockie' ) ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My Account', 'stockie' ); ?></a>
					<?php endif; ?>
				</p>

			<?php else : ?>

				<h3 class="heading-md"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'stockie' ), $order ); ?></h3>

				<ul class="woo-c_order_details">
					<li class="woo-c_order_details_order">
						<?php esc_html_e( 'Order Number:', 'stockie' ); ?>
						<strong><?php echo esc_attr($order->get_order_number()); ?></strong>
					</li>
					<li class="woo-c_order_details_date">
						<?php esc_html_e( 'Date:', 'stockie' ); ?>
						<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->get_date_created() ) ); ?></strong>
					</li>
					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class=" woo-c_order_details_total">
						<?php esc_html_e( 'Email:', 'stockie' ); ?>
						<strong><?php echo esc_attr($order->get_billing_email()); ?></strong>
					</li>
					<?php endif; ?>
					<li class="woo-c_order_details_total">
						<?php esc_html_e( 'Total:', 'stockie' ); ?>
						<strong><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
					</li>
					<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woo-c_order_details_method">
						<?php esc_html_e( 'Payment Method:', 'stockie' ); ?>
						<strong><?php echo esc_attr($order->get_payment_method_title()); ?></strong>
					</li>
					<?php endif; ?>
				</ul>

			<?php endif; ?>

			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

		<?php else : ?>

			<p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'stockie' ), null ); ?></p>

		<?php endif; ?>
		</div>