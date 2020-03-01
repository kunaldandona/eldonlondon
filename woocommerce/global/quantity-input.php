<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
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
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'stockie' ), strip_tags( $args['product_name'] ) ) : '';

?>
<div class="woo-quantity">
	<div class="plus cart_plus brand-bg-color-hover-before brand-bg-color-hover-after wac-btn-inc"></div>
	<div class="minus cart_minus brand-bg-color-hover-before wac-btn-sub"></div>
	<input
		type="number"
		id="<?php echo esc_attr( $input_id ); ?>"
		class="input-text qty text"
		step="<?php echo esc_attr( $step ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		<?php if ( $max_value > 0 ) { ?> max="<?php echo esc_attr($max_value); ?>" <?php } ?>
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'stockie' ) ?>"
		size="4"
		aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />

</div>
