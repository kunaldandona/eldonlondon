<?php
/**
 *
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	$shop_page_id = wc_get_page_id( 'shop' );

	$show_breadcrumbs = false;
	if ( is_product() ) {
		$show_breadcrumbs = StockieSettings::get( 'woocommerce_page_show_breadcrumbs', 'global' );
	} else {
		$show_breadcrumbs = StockieSettings::get( 'page_show_breadcrumbs' );
	}

	if ( $show_breadcrumbs == 'inherit' ) {
		$show_breadcrumbs = (bool) StockieSettings::get( 'page_show_breadcrumbs', 'global' );
	} else {
		$show_breadcrumbs = ( $show_breadcrumbs == 'yes' );
	}


	$product_type = StockieSettings::get_product_type();
	if ( $product_type == NULL ) {
		$product_type = 'type1';
	}

	$product_view = StockieSettings::get_product_view_mode();
	if ( $product_view == NULL ) {
		$product_view = 'left';
	}

	if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	}

	global $post;
	global $product;

?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	switch ($product_type) {
		case 'type1':
			if ($product_view == 'left') {
				wc_get_template_part('single-product/views/type_1');
			} else {
				wc_get_template_part('single-product/views/type_1_reverse');
			}
			break;
		case 'type2':
			if ($product_view == 'left') {
				wc_get_template_part('single-product/views/type_2');
			} else {
				wc_get_template_part('single-product/views/type_2_reverse');
			}
			break;
		case 'type3':
			if ($product_view == 'left') {
				wc_get_template_part('single-product/views/type_3');
			} else {
				wc_get_template_part('single-product/views/type_3_reverse');
			}
			break;
		case 'type4':
			if ($product_view == 'left') {
				wc_get_template_part('single-product/views/type_4');
			} else {
				wc_get_template_part('single-product/views/type_4_reverse');
			}
			break;
		case 'type5':
			if ($product_view == 'left') {
				wc_get_template_part('single-product/views/type_5');
			} else {
				wc_get_template_part('single-product/views/type_5_reverse');
			}
			break;
		default:

			break;
	}?>
