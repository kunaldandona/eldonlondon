<?php
/**
 *
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="woo_c-product-details-variations cart woocommerce-add-to-cart" method="post" enctype='multipart/form-data'>
	<?php if ( $product->is_in_stock() ) : ?>

		<div class="simple-qty">
			<div class="label">
				<label for="quantity"><?php esc_html_e( 'QTY', 'stockie' ); ?>:</label>
			</div>
			<?php if ( ! $product->is_sold_individually() ) {
				woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) );
			} ?>
		</div>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
		<div class="variations_button">

            <?php if (StockieSettings::get('woocommerce_add_to_cart_ajax', 'global')) { ?>
                <a class="single_add_to_cart_button btn alt btn-loading-disabled">
                    <i class="icon ion ion-left">
                        <svg version="1.1"  xmlns="http://www.w3.org/2000/svg" width="12px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
                        <path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
                            s2,0.9,2,2v1H4V3z"/>
                        </svg>
                    </i>
                    <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                </a>
            <?php } else { ?>
                <button type="submit" class="single_add_to_cart_button btn alt btn-loading-disabled">

                    <i class="icon ion ion-left">
                        <svg version="1.1"  xmlns="http://www.w3.org/2000/svg" width="12px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
                        <path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
                            s2,0.9,2,2v1H4V3z"/>
                        </svg>
                    </i>
                    <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
                </button>
            <?php } ?>



            <?php
            if ( function_exists( 'YITH_WCWL' ) ) {
                echo do_shortcode('[yith_wcwl_add_to_wishlist]');
            }
            ?>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</div>

	<?php else: ?>
		<div class="single_add_to_cart_button out_of_stock">
			<div class="stockie-message-module-sc message-box error"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'stockie' ); ?></div>
		</div>
	<?php endif; ?>
</form>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
