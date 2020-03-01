<?php

global $post;
$shop_page_id = wc_get_page_id( 'shop' );

if ( $post && is_object( $post ) ) {
    $postID = $post->ID;
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        $post->ID = get_option( 'woocommerce_shop_page_id' ); // woocomerce wrong post id fix
    }
}

$page_wrapped = StockieSettings::page_is_wrapped();
$page_container_class = '';
if ( !$page_wrapped ) {
    $page_container_class .= ' full';
}

$grid_type = StockieSettings::get( 'woocommerce_grid_type', 'global' );
if ( $grid_type == NULL ) {
    $grid_type = 'type_1';
}

$product_now = 0;

get_header( 'shop' );

$content_location = StockieSettings::get( 'shop_content_position', 'global' );
if ($content_location == NULL) {
	$content_location = 'top';
}


$products_in_row = StockieSettings::get( 'woocommerce_products_in_row', 'global' );
if ( is_string( $products_in_row ) ) {
    $products_in_row = json_decode( $products_in_row );
}

if( $products_in_row == NULL ){
    $products_in_row = (object) array(
        "large" => "3",
        "medium" => "2",
        "small" => "2"
    );
}

$product_now = 0;

$row_atts = '';
if ( is_object( $products_in_row ) ) {
    $row_atts = ' data-desktop-items=' . $products_in_row->large;
    $row_atts .= ' data-tablet-items=' . $products_in_row->medium;
    $row_atts .= ' data-mobile-items=' . $products_in_row->small;
}


do_action( 'woocommerce_before_main_content' );
?>
<div class="page-container<?php echo esc_attr( $page_container_class  ); ?> woo-shop-container bottom-offset product shop-product-<?php echo esc_attr($grid_type) ?>"<?php echo esc_attr($row_atts) ?>>
    <div class="page-content">

        <!-- Custom content -->
        <?php if ($content_location == 'top'): ?>
            <div class="page_content shop_page_content">
                <?php do_action( 'woocommerce_archive_description' ); ?>
            </div>
        <?php endif; ?>

		<?php

        if ( have_posts() ) :

            if ( is_shop() || is_product_category() || is_product_tag() ) {
				$post->ID = $postID;
			}

            woocommerce_product_loop_start();

			while ( have_posts() ) { the_post();

                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product-type-4' );
			}

        	woocommerce_product_loop_end();

        else:
			wc_get_template( 'loop/no-products-found.php' );
        endif;
        ?>

        <!-- Custom content -->
        <?php if ($content_location == 'bottom'): ?>
            <div class="page_content shop_page_content">
                <?php do_action( 'woocommerce_archive_description' ); ?>
            </div>
        <?php endif; ?>

	</div>
</div><!--.page-container-->
<?php
	do_action( 'woocommerce_after_main_content' );
?>
