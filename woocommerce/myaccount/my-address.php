<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
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
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => esc_html__( 'Billing address', 'stockie' ),
		'shipping' => esc_html__( 'Shipping address', 'stockie' )
	), $customer_id );
} else {
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' =>  esc_html__( 'Billing address', 'stockie' )
	), $customer_id );
}

$oldcol = 1;
$col    = 1;
$allowed_html = array(
   'br' => array(  )
 ); 
?>

<h2 class="account-title second-title"><?php esc_html__( 'Addresses', 'stockie' ); ?></h2>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'stockie' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) echo '<div class="u-columns woocommerce-Addresses col2-set addresses">'; ?>
<div class="vc_row">
<?php foreach ( $get_addresses as $name => $title ) : ?>

	<div class="vc_col-md-6 woo-my-address">
		<div class="wrap">
			<header class="woocommerce-Address-title title">
				<h4 class="title account-title"><?php echo esc_attr( $title ); ?></h4>
				<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="btn btn-small edit">
					<?php esc_html_e( 'Edit', 'stockie' ); ?>
				</a>
			</header>
			<address>
				<?php
					$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
						'first_name'  => get_user_meta( $customer_id, $name . '_first_name', true ),
						'last_name'   => get_user_meta( $customer_id, $name . '_last_name', true ),
						'company'     => get_user_meta( $customer_id, $name . '_company', true ),
						'address_1'   => get_user_meta( $customer_id, $name . '_address_1', true ),
						'address_2'   => get_user_meta( $customer_id, $name . '_address_2', true ),
						'city'        => get_user_meta( $customer_id, $name . '_city', true ),
						'state'       => get_user_meta( $customer_id, $name . '_state', true ),
						'postcode'    => get_user_meta( $customer_id, $name . '_postcode', true ),
						'country'     => get_user_meta( $customer_id, $name . '_country', true )
					), $customer_id, $name );
	 
					$formatted_address = WC()->countries->get_formatted_address( $address );

					if ( ! $formatted_address ) {
						esc_html_e( 'You have not set up this type of address yet.', 'stockie' );
					} else {
						echo  wp_kses( $formatted_address,  $allowed_html);
					}
				?>
			</address>
		</div>
	</div>

<?php endforeach; ?>
</div>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) echo '</div>'; ?>
