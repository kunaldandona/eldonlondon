<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

    if(isset($_GET['popup']) && $_GET['popup'] == true) {
        include( get_template_directory() . '/woocommerce/product_popup.php');
        return;

    }


	StockieHelper::add_required_script( 'accordion' );
	StockieHelper::add_required_script( 'tabs' );

	$page_wrapped = StockieSettings::page_is_wrapped();

	get_header( 'shop' );

	$page_container_class = '';
	if ( !$page_wrapped ) {
		$page_container_class .= ' full';
	}

	$header_menu_style = StockieSettings::header_menu_style();
	$header_classes = '';
	if ( $header_menu_style == 'style6' || $header_menu_style == 'style7') {
		$header_classes .= ' sticky_product_position';
	}
	
	$sticky_header = StockieSettings::header_is_fixed();
	$submenu = StockieSettings::get( 'header_menu_hide_contacts_bar', 'global' );
	$header_spacer = StockieSettings::get( 'woocommerce_header_add_cap', 'global' );
	if ( in_array( $header_spacer, array('inherit', NULL) ) ) {
		$header_spacer = StockieSettings::get( 'header_menu_add_cap', 'global' );
	}
?>

<div class="woo_c-product single-product <?php echo esc_attr($submenu ? 'subheader_excluded' : 'subheader_included');?> <?php echo esc_attr($header_spacer == 'yes' ? 'spacer_included' : 'spacer_excluded');?> <?php echo esc_attr($sticky_header ? 'sticky_included' : 'sticky_excluded');?> <?php echo esc_attr($header_classes)?>">
	<?php
		while ( have_posts() ) {
			the_post();
			wc_get_template_part( 'content', 'single-product' );
		}
		do_action( 'woocommerce_after_main_content' );
	?>
</div>
<?php get_footer( 'shop' );?>