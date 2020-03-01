<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}


if ( !isset( $use_masonry_grid ) ) {
	$use_masonry_grid = false;
}

$li_class = '';
if ( $use_masonry_grid ) {
	$li_class .= ' masonry-block grid-item';
}


$double_width = StockieSettings::get( 'product_style_in_grid' );
if ($double_width == "2col") {
    $li_class .= " double_width";
}

$hover_type = StockieSettings::get( 'woocommerce_grid_hover', 'global' );

$hover_type_class = '';

if ($hover_type == NULL) {
    $hover_type_class = 'product-hover-1';
}
if ($hover_type == 'type_1') {
    $hover_type_class = 'product-hover-1';
}
if ( $hover_type == 'type_2') {
    $hover_type_class = 'product-hover-2';
}
if ( $hover_type == 'type_3') {
    $hover_type_class = 'product-hover-3';
    $bg_color = StockieSettings::get( 'woocommerce_overlay_background_color', 'global' );
}

$photos_count = StockieSettings::get('woocommerce_product_images_count', 'global');
if(empty($photos_count)) {
    $photos_count = 2;
}

$text_align = StockieSettings::get( 'woocommerce_text_alignment', 'global');
if(empty($text_align)){
    $text_align = 'left';
}

?>
<li <?php post_class( $li_class ); ?> data-product-item="true" data-lazy-item="true">
	<div class="product-content trans-shadow text-<?php echo esc_attr($text_align) ?> <?php echo esc_attr($hover_type_class) ?>">
		<div class="image-wrap">
			<div class="product-buttons">
				<?php
				if ( function_exists( 'YITH_WCWL' ) ) {
					echo do_shortcode( '<div class="prod-hidden-link">[yith_wcwl_add_to_wishlist]</div>' );
				}
				$is_lightbox = StockieSettings::get( 'woocommerce_product_lightbox_preview', 'global' );
				if ( $is_lightbox) { ?>

				<div class="prod-hidden-link quickview-link" data-product-id="<?php echo esc_attr($product->get_id()) ?>">
					<div class="btn btn-small quickview-inner open-popup">
	                    <?php _e('Quickview', 'stockie') ?>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			<div class="slider">
				<a href="<?php echo esc_url( get_post_permalink() ); ?>">
					<?php echo woocommerce_get_product_thumbnail();?>
				</a>
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                $i = 1;
                foreach ( $attachment_ids as $attachment_id ) {
                    $i++;
                    if($i > $photos_count) {
                        break;
                    } ?>
                    <a href="<?php echo esc_url( get_post_permalink() ); ?>">
                        <?php echo wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail' ); ?>
                        <?php if( $hover_type == 'type_3'): ?>
                            <div class="product-hover-overlay" style="background: <?php echo esc_attr($bg_color) ?>"></div>
                        <?php endif ?>
                    </a>
                    <?php
                }
                ?>
			</div>
		</div>

		<?php
		/**
		* woocommerce_after_shop_loop_item hook.
		*
		* @hooked woocommerce_template_loop_product_link_close - 5
		* @hooked woocommerce_template_loop_add_to_cart - 10
		*/
		?>
		<div class="wc-product-title-wrap<?php if ( $product->get_price_html() == '' ) { echo ' without-price'; } ?>">
			<?php
				$categories = explode(', ', wc_get_product_category_list( $product->get_id() ) );
				$categories = array_filter( $categories );
				$i = 0;
				if ( !empty( $categories ) ) :
					foreach ( $categories as $category ):
			 ?>
				<div class="category">
					<?php
						echo preg_replace('/(<a)(.+\/a>)/i', '${1} class="trans-hover" ${2}', $category);
						if ( (++$i) < count( $categories ) ) {
							echo ',';
						}
					?>
				</div>
			<?php
					endforeach;
				endif;
			?>
			<h5 class="font-titles">
				<a href="<?php echo esc_url( get_post_permalink() ); ?>" class="color-dark">
					<?php echo esc_attr( get_post( $product->get_id() )->post_title ); ?>
				</a>
			</h5>
			<div class="hide-price-and-cart">
				<div class="price">
                    <?php echo wp_kses($product->get_price_html(), 'default'); ?>
				</div>
				<div class="add-to-cart">
					<?php
						$classes = '';
						if (! $product->is_in_stock() && ($product->managing_stock() && $product->get_stock_quantity()) == 0)
						$classes = 'out-of-stock';
						echo apply_filters( 'woocommerce_loop_add_to_cart_link',
						sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s product_type_%s single_add_to_cart_button btn-loading-disabled %s">%s</a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( $product->get_id() ),
						esc_attr( $product->get_sku() ),
						$product->is_purchasable() ? 'add_to_cart_button' : '',
						esc_attr( $product->get_type() ),
						$classes,
						esc_html( $product->add_to_cart_text() )
					),
					$product );
					?>

					<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
					<input type="hidden" name="variation_id" class="variation_id" value="0" />

				</div>
			</div>
		</div>
	</div>
</li>
