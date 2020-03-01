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

$sidebar_position = StockieSettings::get_woocommerce_sidebar_position();
$sidebar_page_class = '';
if ( is_active_sidebar( 'wc_shop' ) ) {
    if ( $sidebar_position == 'left' ) {
        $sidebar_page_class = ' with-left-sidebar';
    } elseif ( $sidebar_position == 'right' ) {
        $sidebar_page_class = ' with-right-sidebar';
    }
}
$sidebar_layout = StockieSettings::page_sidebar_layout();
$sidebar_class = '';
if ( $sidebar_layout ) {
    $sidebar_class .= ' sidebar-' . $sidebar_layout;
}

$grid_type = StockieSettings::get( 'woocommerce_grid_type', 'global' );
if ( $grid_type == NULL ) {
    $grid_type = 'type_1';
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

$row_class = '';
if ( is_object( $products_in_row ) ) {
    $row_class = ' columns-' . $products_in_row->large;
    $row_class .= ' columns-md-' . $products_in_row->medium;
    $row_class .= ' columns-sm-' . $products_in_row->small;
}

get_header( 'shop' );
get_template_part( 'parts/elements/header-title' );
get_template_part( 'parts/elements/breadcrumbs' );
do_action( 'woocommerce_before_main_content' );

$content_location = StockieSettings::get( 'shop_content_position', 'global' );
if ($content_location == NULL) {
	$content_location = 'top';
}
?>

<div class="page-container<?php echo esc_attr( $page_container_class ); ?> woo-shop-container bottom-offset product shop-product-<?php echo esc_attr($grid_type) ?>">
      	
  	<!-- Filter bar -->
  	<div class="filter-container">
	  	<div class="mbl-overlay ">
	  		<div class="mbl-overlay-bg"></div>
			<div class="close close-bar">
				<div class="close-bar-btn btn-round round-animation" tabindex="0">
					<i class="ion ion-md-close"></i>
				</div>
			</div>
	  		<div class="mbl-overlay-container">
				<div class="filter">
					<?php do_action( 'woocommerce_before_shop_loop' );?>
				</div>	
	  		</div>
	  	</div>

		<div class="btn-filter">
			<a href="#" class="btn btn-small">
				<i class="ion ion-left ion-md-funnel"></i>
				<span class="text">Filter</span>
			</a>
		</div>
	</div>

	<!-- Custom content -->
	<?php if ($content_location == 'top'): ?>
        <div class="page_content shop_page_content">
	        <?php do_action( 'woocommerce_archive_description' ); ?>
        </div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'wc_shop' ) && $sidebar_position == 'left'  ) : ?>
	<div class="page-sidebar sidebar-left woo-sidebar<?php echo esc_attr( $sidebar_class ); ?>">
		<ul class="sidebar-widgets">
			<?php dynamic_sidebar( 'wc_shop' ); ?>
		</ul>
	</div>
	<?php endif; ?>
	<div class="page-content<?php echo esc_attr( $sidebar_page_class ); ?><?php echo esc_attr( $row_class ); ?>">

		<?php if ( have_posts() ) : ?>
		<?php
			wc_print_notices();

			if ( is_shop() || is_product_category() || is_product_tag() ) {
				$post->ID = $postID;
			}
			?>
			<?php
			woocommerce_product_loop_start();
			woocommerce_product_subcategories();

            global $iteration;
			while ( have_posts() ) {
				the_post();
                $iteration++;
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'grid', 'product' );
			}

			woocommerce_product_loop_end();
			do_action( 'woocommerce_after_shop_loop' );
		?>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
			<?php wc_get_template( 'loop/no-products-found.php' ); ?>
		<?php endif; ?>

        <?php if ($content_location == 'bottom'): ?>
            <div class="page_content shop_page_content">
                <?php do_action( 'woocommerce_archive_description' ); ?>
            </div>
        <?php endif; ?>

	</div>
	<?php if ( is_active_sidebar( 'wc_shop' ) && $sidebar_position == 'right'  ) : ?>
	<div class="page-sidebar sidebar-right woo-sidebar<?php echo esc_attr( $sidebar_class ); ?>">
		<ul class="sidebar-widgets">
			<?php dynamic_sidebar( 'wc_shop' ); ?>
		</ul>
	</div>
	<?php endif; ?>
</div>

<!--.page-container-->
<?php do_action( 'woocommerce_after_main_content' );?>