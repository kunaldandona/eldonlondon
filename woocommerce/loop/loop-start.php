<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     3.3.0
 */
?>
<?php

$grid_type = StockieSettings::get( 'woocommerce_grid_type', 'global' );
if ( $grid_type == NULL ) {
	$grid_type = 'type_1';
}

$grid_classes = '';
if ( $grid_type == 'type_4' ) {
	$grid_classes .= ' woo-products-slider';
}

$masonry_layout = false;
if ( $grid_type != 'type_4' ) {
	$grid_classes .= ' woo-products-slider';
	$masonry_layout = StockieSettings::get( 'woocommerce_masonry_layout', 'global' );
}
$masonry_atts = '';
if ($masonry_layout) {
	$masonry_atts = ' data-shop-masonry="true"';
}

?>

<div class="">
	<ul class="products woo_c-products<?php echo esc_attr($grid_classes) ?>"<?php echo esc_attr($masonry_atts) ?> data-lazy-container="true">
