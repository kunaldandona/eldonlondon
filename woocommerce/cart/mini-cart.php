<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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

$allowed_html = array(
    'a' => array(
    	'href'=> true,
        'class' =>true
    ),
    'img' => array(
        'class' => true,
        'src' => true,
        'alt'=> true
    )
);

$device = '';
if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") == true){
	$device = 'apple-device';
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'stockie' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
						<?php if ( empty( $product_permalink ) ) : ?>
							<a href="" class="mini_cart_item-image">
								<?php echo wp_kses( $thumbnail,  $allowed_html); ?>
							</a>
							<div class="mini_cart_item-desc">
                                <?php echo apply_filters( 'woocommerce_cart_item_name', get_post( $_product->get_id() )->post_title, $cart_item, $cart_item_key ) . '&nbsp;'; ?>
<!--								<a class="font-titles" href="--><?php //echo esc_url( $product_permalink ); ?><!--">-->
<!--									--><?php //echo wp_kses($product_name,  $allowed_html); ?>
<!--								</a>-->
							
						<?php else : ?>
							<a class="mini_cart_item-image" href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo wp_kses( $thumbnail,  $allowed_html); ?>
							</a>
							<div class="mini_cart_item-desc">
                            <?php echo sprintf( '<a class="font-titles" href="%s">%s</a>', esc_url( $product_permalink ), get_post( $_product->get_id() )->post_title ) ?>
                            <?php
                            $product_item = $_product;
                            if ( $product_item->is_type( 'variation' ) ) {
                                $product_item = wc_get_product( $product_item->get_parent_id() );
                            }
                            $cat_ids = $product_item->get_category_ids();
                            if ( $cat_ids ) {
                                echo wc_get_product_category_list( $product_item->get_id(), ', ', '<span class="woo-c_product_category">' . _n( '', '', count( $cat_ids ), 'stockie' ) . ' ', '</span>' );
                            }
                            ?>

						<?php endif; ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
						</div>
					</li>
					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<div class="woocomerce-mini-cart__container <?php esc_attr_e($device); ?>">
		<p class="woocommerce-mini-cart__total total"><strong><?php esc_html_e( 'Subtotal', 'stockie' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>
	</div>

<?php else : ?>

	<!-- EMPT Container -->
	<div class="empt-container">
		<div class="empt-container-image">
			<svg class="image-shape-icon" version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 12 16" xml:space="preserve">
			<path class="st0" d="M9,4V3c0-1.7-1.3-3-3-3S3,1.3,3,3v1H0v10c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V4H9z M4,3c0-1.1,0.9-2,2-2
				s2,0.9,2,2v1H4V3z"/>
			</svg>
		</div>
		<h3 class="heading-md empt-container-headline">
			<?php esc_html_e( 'Cart is empty', 'stockie' ); ?>
		</h3>
		<p class="empt-container-details">
			<?php esc_html_e( 'Check out all the available products and buy some in the shop', 'stockie' ); ?>
		</p>
		<div class="empt-container-cta">
			<a class="btn" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php esc_html_e( 'Go Shopping', 'stockie' ) ?> <i class="ion ion-right ion-ios-arrow-forward"></i>
			</a>
		</div>
	</div>

<?php endif; ?>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>