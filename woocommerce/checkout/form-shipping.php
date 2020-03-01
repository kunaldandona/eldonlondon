<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
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
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
?>
<div class="woocommerce-shipping-fields woo-c_shipping">

    <?php if (true === WC()->cart->needs_shipping_address()) :

        $default_fields = [
            'shipping_first_name',
            'shipping_last_name',
            'shipping_company',
            'shipping_country',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_city',
            'shipping_state',
            'shipping_postcode'
        ];

        $fields = $checkout->get_checkout_fields('shipping');

        ?>

        <h3 class="heading-md">
            <?php esc_html_e('Shipping address', 'stockie'); ?>
        </h3>

        <p id="ship-to-different-address">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input id="ship-to-different-address-checkbox"
                       class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0), 1); ?>
                       type="checkbox" name="ship_to_different_address" value="1"/>
                <span><?php esc_html_e('Ship to a different address?', 'stockie'); ?></span>
            </label>
        </p>

        <div class="shipping_address">

            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

            <div class="vc_row customer_details">
                <div class="vc_col-md-6">
                    <?php
                    if (isset($checkout->checkout_fields['shipping']['shipping_first_name'])) {
                        woocommerce_form_field('shipping_first_name', $checkout->checkout_fields['shipping']['shipping_first_name'], $checkout->get_value('shipping_first_name'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_last_name'])) {
                        woocommerce_form_field('shipping_last_name', $checkout->checkout_fields['shipping']['shipping_last_name'], $checkout->get_value('shipping_last_name'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_company'])) {
                        woocommerce_form_field('shipping_company', $checkout->checkout_fields['shipping']['shipping_company'], $checkout->get_value('shipping_company'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_phone'])) {
                        woocommerce_form_field('shipping_phone', array(
                            'type' => 'text',
                            'class' => array('input-text'),
                            'label' => esc_html_e('Phone', 'stockie'),
                            'required' => false,
                        ), $checkout->get_value('shipping_phone'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_email'])) {
                        woocommerce_form_field('shipping_email', array(
                            'type' => 'text',
                            'class' => array('input-text'),
                            'label' => esc_html_e('Email address', 'stockie'),
                            'required' => false,
                        ), $checkout->get_value('shipping_email'));
                    }
                    ?>
                </div>
                <div class="vc_col-md-6">
                    <?php
                    if (isset($checkout->checkout_fields['shipping']['shipping_country'])) {
                        woocommerce_form_field('shipping_country', $checkout->checkout_fields['shipping']['shipping_country'], $checkout->get_value('shipping_country'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_address_1'])) {
                        woocommerce_form_field('shipping_address_1', $checkout->checkout_fields['shipping']['shipping_address_1'], $checkout->get_value('shipping_address_1'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_address_2'])) {
                        woocommerce_form_field('shipping_address_2', array(
                            'type' => 'text',
                            'class' => array('input-text'),
                            'label' => esc_html_e('Street address', 'stockie'),
                            'required' => false,
                        ), $checkout->get_value('shipping_address_2'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_city'])) {
                        woocommerce_form_field('shipping_city', $checkout->checkout_fields['shipping']['shipping_city'], $checkout->get_value('shipping_city'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_state'])) {
                        woocommerce_form_field('shipping_state', $checkout->checkout_fields['shipping']['shipping_state'], $checkout->get_value('shipping_state'));
                    }
                    if (isset($checkout->checkout_fields['shipping']['shipping_postcode'])) {
                        woocommerce_form_field('shipping_postcode', $checkout->checkout_fields['shipping']['shipping_postcode'], $checkout->get_value('shipping_postcode'));
                    }

                    foreach ($fields as $key => $field) {
                        if (!in_array($key, $default_fields)) {
                            woocommerce_form_field($key, $field, $checkout->get_value($key));
                        }
                    }

                    ?>

                </div>
            </div>

            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

        </div>

    <?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
    <?php do_action('woocommerce_before_order_notes', $checkout); ?>

    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

        <?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()) : ?>

            <h3><?php esc_html_e('Additional information', 'stockie'); ?></h3>

        <?php endif; ?>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>