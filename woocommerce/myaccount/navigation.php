<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<div class="woo-c woocommerce-MyAccount-wrap">
	<div class="vc_row">	
		<div class="vc_col-md-3">
			<div class="woo-my-user">
				<?php 
					$current_user = wp_get_current_user();
					echo get_avatar( $current_user->ID, 80 );
				?>
				<div class="left">
					<h4 class="title">
						<?php echo esc_html($current_user->display_name); ?>
					</h4>
					<a href="<?php echo wp_logout_url( get_permalink() ); ?>">
						<?php esc_html_e( 'Logout', 'stockie' ); ?>
					</a>
				</div>
			</div>
			<nav class="woo-my-nav">
				<ul>
					<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
						<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
							<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_attr( $label ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
