<?php

add_action('wp_enqueue_scripts', 'stockie_child_local_enqueue_parent_styles');

function stockie_child_local_enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}


add_filter( 'woocommerce_available_payment_gateways', 'gateway_disable_country' );

function gateway_disable_country( $available_gateways ) {
    if ( is_admin() ) return $available_gateways;
    if ( isset( $available_gateways['cod'] ) && WC_Customer()->get_billing_country() != 'IN' ) {
        unset( $available_gateways['cod'] );
    }
    return $available_gateways;
}