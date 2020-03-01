<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<section class="woo-cart-empty">
		<div class="page-container">

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
		</div>
	</section>
<?php endif; ?>
