<?php
// GLOBALS
$shop_page_id = wc_get_page_id( 'shop' );
$show_breadcrumbs = false;
$show_breadcrumbs = StockieSettings::get( 'woocommerce_page_show_breadcrumbs', 'global' );
if ( $show_breadcrumbs == 'inherit' ) {
    $show_breadcrumbs = (bool) StockieSettings::get( 'page_show_breadcrumbs', 'global' );
} else {
    $show_breadcrumbs = ( $show_breadcrumbs == 'yes' );
}
if ($show_breadcrumbs) {
    $category_in_breadcrumb = StockieSettings::get('page_show_category_breadcrumbs');
    if ( $category_in_breadcrumb == 'inherit') {
        $category_in_breadcrumb = StockieSettings::get('woocommerce_page_show_category_breadcrumbs', 'global');
    }
    $category_in_breadcrumb = ( $category_in_breadcrumb == 'yes' );
}
global $post;
global $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );

$zoom = StockieSettings::get( 'woocommerce_product_images_zoom', 'global' );

// SLIDER
function get_slides($size = 'shop_single', $zoom = true) {
    global $post;
    global $product;
    $allowed_html = array(
        'div' => array(
            'class' =>true
        ),
        'img' => array(
            'class' => true,
            'src' => true,
            'alt'=> true
        )
    );
    $with_zoom_class = '';
    if ($zoom) {
        $with_zoom_class = ' with-zoom';
    }

    $html = '<div class="image-wrap woocommerce-product-gallery__image'.esc_attr($with_zoom_class).'"><img class="gimg wp-post-image" src="'.wp_get_attachment_image_url( $product->get_image_id(), $size ).'" alt="'.esc_attr($post->post_title).'"></div>';
    $attachment_ids = $product->get_gallery_image_ids();
    $image_class = '';
    $loop = 1;
    foreach ( $attachment_ids as $attachment_id ) {
        $classes = array( 'zoom' );
        $image_class = implode( ' ', $classes );
        $props       = wc_get_product_attachment_props( $attachment_id, $post );
        if ( ! $props['url'] ) {
            continue;
        }
        $html .= '<div class="image-wrap woocommerce-product-gallery__image'.esc_attr($with_zoom_class).'"><img class="gimg wp-post-image" src="'.esc_url( wp_get_attachment_image_url( $attachment_id, $size )).'" alt="'.esc_attr($post->post_title).'"></div>';
        $loop++;
    }
    echo wp_kses( $html, $allowed_html);
}
?>
<div class="page-container full">

    <?php wc_get_template_part("single-product/sticky", "product") ?>

    <div class="vc_row">
        <div class="vc_col-lg-8 vc_col-md-6 vc_col-sm-12 woo_c-product-image">
            <div class="woo_c-product-image-slider container-loading">
                <?php wc_get_template_part('single-product/sale', 'stick'); ?>
                <div class="product_images <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
                    <?php get_slides('shop_single', $zoom); ?>
                </div>
            </div>
        </div>
        <div class="vc_col-lg-4 vc_col-md-6 vc_col-sm-12 woo_c-product-details">
            <div class="summary entry-summary woo_c-product-details-inner">
                <?php if ( $show_breadcrumbs ) : ?>
                <div class="breadcrumbs">
                    <div class="breadcrumbs-inner">
                        <a class="brand-color-hover" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                            <?php echo StockieSettings::breadcrumbs_woocommerce_slug(); ?>
                        </a>
                        <?php
                            $ancestors = get_ancestors( get_the_ID(), 'page', 'post_type' );
                            if (count($ancestors)) {
                                for( $i = count( $ancestors ); $i >= 0; $i-- ) {
                                    $page = get_page( $ancestors[$i] );
                                    printf( '<i class="ion ion-ios-arrow-forward"></i> <a class="brand-color-hover" href="%s">%s</a>', $page->guid, $page->post_title );
                                }  
                            }
                        ?>
                        <?php
                        if($category_in_breadcrumb) {
                            $terms = wp_get_post_terms( $post->ID, 'product_cat', array( 'taxonomy' => 'product_cat' ) );

                            if ( is_array( $terms ) && is_object( $terms[0] ) ) {
                                printf( '<i class="ion ion-ios-arrow-forward"></i> <a class="brand-color-hover hover-underline underline-brand" href="%s">%s</a>', get_term_link( $terms[0] ), $terms[0]->name );
                            }
                        }
                        ?>
                        <i class="ion ion-ios-arrow-forward"></i> <span class="current"><?php the_title(); ?></span>
                    </div>
                    <!-- Prod nav -->
                    <div class="woo_c-product-nav">
                        <a href="<?php next_post_link(); ?>" class="woo_c-product-nav-prev tooltip">
                            <i class="ion ion-ios-arrow-back"></i>
                            <div class="tooltip-item brand-bg-color brand-bg-color-before left">prev</div>
                        </a>
                        <a href="<?php previous_post_link(); ?>" class="woo_c-product-nav-next tooltip">
                            <i class="ion ion-ios-arrow-forward"></i>
                            <div class="tooltip-item brand-bg-color brand-bg-color-before right">next</div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <div class="woo-summary-content">
                    <div class="wrap">
                        <?php
                            do_action( 'woocommerce_before_main_content' );
                            do_action( 'woocommerce_single_product_summary' );
                        ?>
                        </div>
                    </div>
                </div>
                <?php
                    $hide_sharing = StockieSettings::get( 'woocommerce_sharing', 'global' );
                    if ( !$hide_sharing ) {
                        do_shortcode( '[stockie_share_woo]' );
                    } ?>
            </div>
        </div>
    </div>

    <?php wc_get_template_part('single-product/tabs/tabs'); ?>
    <?php
    woocommerce_upsell_display();
    woocommerce_related_products( $product->get_id(), 4 );
    ?>
</div>