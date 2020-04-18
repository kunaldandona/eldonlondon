<?php

add_action('wp_enqueue_scripts', 'stockie_child_local_enqueue_parent_styles');

function stockie_child_local_enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

function payment_gateway_disable_country($available_gateways)
{
    global $woocommerce;
    if (isset($available_gateways['cod']) && $woocommerce->customer->get_country() != 'IN') {
        unset($available_gateways['cod']);
    }
    return $available_gateways;
}

add_filter('woocommerce_available_payment_gateways', 'payment_gateway_disable_country');