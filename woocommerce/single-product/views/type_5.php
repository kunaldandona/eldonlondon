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
$allowed_html = array(
    'div' => array(
        'class' =>true,
        'data-gallery-item'=>true,
        'data-lazy-item'=>true
    ),
    'i' => array(
        'class' =>true
    ),
    'img' => array(
        'class' => true,
        'src' => true,
        'alt'=> true
    )
);

$zoom = StockieSettings::get( 'woocommerce_product_images_zoom', 'global' );

$with_zoom_class = '';
if ($zoom) {
    $with_zoom_class = ' with-zoom';
}

?>

<div class="page-container">

    <?php wc_get_template_part("single-product/sticky", "product") ?>

    <div class="vc_row">
        <div class="vc_col-lg-7 vc_col-md-6 vc_col-md-6 vc_col-sm-12 woo_c-product-image">
            <div class="woo_c-product-images stockie-gallery-sc gallery-wrap" data-gallery="stockie-custom-<?php echo  esc_attr($product->get_id()) ?>">
                <?php $attachment_ids = $product->get_gallery_image_ids(); ?>
                <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); echo count($attachment_ids) == 0 ? ' without_gallery' : ' with_gallery' ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
                    <?php
                     $is_lightbox = StockieSettings::show_product_lightbox();
                     $lightbox = $is_lightbox ? '<div class="woo_c-product-image-slider-trigger btn-round grid-item gallery-image" data-gallery-item="0" data-lazy-item="true"><i class="ion ion-md-expand"></i></div>': '';

                        if ( has_post_thumbnail() ) {
                            $html = '<div class="image-wrap woocommerce-product-gallery__image'.esc_attr($with_zoom_class).'">'.$lightbox.'<img class="gimg wp-post-image" src="'.wp_get_attachment_image_url( $product->get_image_id(), 'shop_single' ).'" alt="'.esc_attr($post->post_title).'"></div>';
                            $image_class = '';
                            $loop = 1;
                            foreach ( $attachment_ids as $attachment_id ) {
                                $classes = array( 'zoom' );
                                $image_class = implode( ' ', $classes );
                                $props       = wc_get_product_attachment_props( $attachment_id, $post );
                                if ( ! $props['url'] ) {
                                    continue;
                                }
                                $html .= '<div class="image-wrap woocommerce-product-gallery__image'.esc_attr($with_zoom_class).'"><div class="grid-item gallery-image" data-gallery-item="'.$loop.'" data-lazy-item="true"></div><img class="gimg" src="'.wp_get_attachment_image_url( $attachment_id, 'shop_single' ).'" alt="'.esc_attr($post->post_title).'"></div>';
                                $loop++;
                            }
                            echo wp_kses( $html, $allowed_html);
                        } else {
                            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__( 'Placeholder', 'stockie' ) ), $post->ID );
                        }
                    ?>
                </div>
                <?php wc_get_template_part('single-product/sale', 'stick'); ?>
            </div>
        </div>
        <div class="vc_col-lg-5 vc_col-md-6 vc_col-md-6 vc_col-sm-12 woo_c-product-details">
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
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
wc_get_template_part( 'single-product/tabs/tabs' );
woocommerce_upsell_display();
woocommerce_related_products( $product->get_id(), 4 );
function add_gallery_to_footer() {
    global $product;
    echo '
    <div class="stockie-gallery-opened-sc gallery-lightbox" id="stockie-custom-'.$product->get_id().'" data-options="{&quot;navClass&quot;:&quot;&quot;}">
        <div class="expand btn-round">
            <i class="ion ion-md-expand"></i>
        </div>
        <div class="close btn-round">
            <i class="ion ion-md-close"></i>
        </div>
    </div>
    ';
}
add_action( 'wp_footer', 'add_gallery_to_footer', 100 );
