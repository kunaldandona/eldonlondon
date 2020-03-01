<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="woocommerce-customer-details woo-my-content">

	<table class="woo-c_shop_table woo-my-orders-table woo-customer-details">
		<?php if ( $order->get_customer_note() ) : ?>
			<tr>
				<th><?php esc_html_e( 'Note:', 'stockie' ); ?></th>
				<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<tr>
				<th><?php esc_html_e( 'Email:', 'stockie' ); ?></th>
				<td><?php echo esc_attr( $order->get_billing_email() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<tr>
				<th><?php esc_html_e( 'Phone:', 'stockie' ); ?></th>
				<td><?php echo esc_attr( $order->get_billing_phone() ); ?></td>
			</tr>
		<?php endif; ?>

		<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
	</table>

	<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

	<div class="col2-set woo-my-address">

	<?php endif; ?>
	<div class="vc_row">

		<div class="vc_col-md-6 woo-my-address">
			<div class="wrap">
				<header class="woocommerce-Address-title title">
					<h3 class="heading-sm"><?php esc_html_e( 'Billing Address', 'stockie' ); ?></h3>
				</header>
				<address>
					<?php echo esc_html( $address = $order->get_formatted_billing_address() ) ? $address : esc_html__( 'N/A', 'stockie' ); ?>
				</address>
			</div>
		</div>

	<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

		<div class="vc_col-md-6 woo-my-address">
			<div class="wrap">
				<header class="woocommerce-Address-title title">
					<h3 class="heading-sm"><?php esc_html_e( 'Shipping Address', 'stockie' ); ?></h3>
				</header>
				<address>
					<?php echo esc_html( $address = $order->get_formatted_shipping_address() ) ? $address : esc_html__( 'N/A', 'stockie' ); ?>
				</address>
			</div>
		</div>
	</div><!--.col2-set-->

	<?php endif; ?>
	</div>

</section>
