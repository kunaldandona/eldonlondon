<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
$hide_sharing = StockieSettings::get( 'woocommerce_sharing', 'global' );

$tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : ?>
    <div class="woocommerce page-container">
        <div class="tab" data-stockie-tab-box="true" id="product_review">
            <div class="woocommerce-tabs wc-tabs-wrapper tabNav_wrapper">
                <ul class="tabs wc-tabs tabNav" role="tablist">
                    <li class="tabNav_line brand-bg-color"></li>
                    <?php
                    $i = 0;
                    foreach ( $tabs as $key => $tab ) : ?>
                        <li class="tabNav_link <?php echo esc_attr($i == 0 ? ' active' : '' )?>" data-stockie-tab="<?php echo esc_attr( $key ) ?>">
                            <div class="title font-titles"<?php if ( $tab['callback'] == 'comments_template' ) { echo ' id="accordion-reviews"'; } ?>>
                                <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ); ?>
                            </div>
                        </li>
                    <?php
                    $i++;
                    endforeach; ?>
                </ul>
            </div>
            <div class="tabItems">
                <?php
                $i = 0;
                foreach ( $tabs as $key => $tab ) : ?>
                    <div class="tabItems_item<?php echo esc_attr($i == 0 ? ' active' : '') ?>" data-stockie-tab-content="<?php echo esc_attr( $key )?>">
                        <div class="wrap">
                            <?php call_user_func( $tab['callback'], $key, $tab ); ?>
                        </div>
                    </div>
                <?php
                $i++;
                endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>