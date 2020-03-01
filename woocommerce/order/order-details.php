<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id );

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?><br>
<h3 class="heading-sm"><?php esc_html_e( 'Order Details', 'stockie' ); ?></h3>
<table class="woo-c_details_table">
	<thead>
		<tr>
			<th class="woo-c_details_table_label"><?php esc_html_e( 'Product', 'stockie' ); ?></th>
			<th class="woo-c_details_table_label product-total"><?php esc_html_e( 'Total', 'stockie' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach( $order->get_items() as $item_id => $item ) {
				$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );

				wc_get_template( 'order/order-details-item.php', array(
					'order'			     => $order,
					'item_id'		     => $item_id,
					'item'			     => $item,
					'show_purchase_note' => $show_purchase_note,
					'purchase_note'	     => $product ? get_post_meta( $product->get_id(), '_purchase_note', true ) : '',
					'product'	         => $product,
				) );
			}
		?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	</tbody>
	<tfoot>
		<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
		<tr>
			<th class="woo-c_details_table_label" scope="row"><?php echo wp_kses_post( $total['label'] ) ; ?></th>
			<td class="woo-c_details_table_price" ><?php echo wp_kses_post( $total['value'] ); ?></td>
		</tr>
		<?php endforeach; ?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
<?php endif; ?>
