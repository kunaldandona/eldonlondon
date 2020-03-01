<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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

$default_fields = [
    'billing_first_name',
    'billing_last_name',
    'billing_company',
    'billing_country',
    'billing_address_1',
    'billing_address_2',
    'billing_city',
    'billing_state',
    'billing_postcode',
    'billing_phone',
    'billing_email'
];

$fields = $checkout->get_checkout_fields( 'billing' );

?>
    <div class="woocommerce-billing-fields">
        <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>

            <h3 class="heading-md">
                <?php esc_html_e('Billing details', 'stockie'); ?>
            </h3>

        <?php else : ?>

            <h3 class="heading-md">
                <?php esc_html_e('Billing details', 'stockie'); ?>
            </h3>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

        <div class="vc_row customer_details">
            <div class="vc_col-md-6">

                <?php


                if (isset($checkout->checkout_fields['billing']['billing_first_name'])) {
                    woocommerce_form_field('billing_first_name', $checkout->checkout_fields['billing']['billing_first_name'], $checkout->get_value('billing_first_name'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_last_name'])) {
                    woocommerce_form_field('billing_last_name', $checkout->checkout_fields['billing']['billing_last_name'], $checkout->get_value('billing_last_name'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_company'])) {
                    woocommerce_form_field('billing_company', $checkout->checkout_fields['billing']['billing_company'], $checkout->get_value('billing_company'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_phone'])) {
                    woocommerce_form_field('billing_phone', $checkout->checkout_fields['billing']['billing_phone'], $checkout->get_value('billing_phone'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_email'])) {
                    woocommerce_form_field('billing_email', $checkout->checkout_fields['billing']['billing_email'], $checkout->get_value('billing_email'));
                }
                ?>
            </div>
            <div class="vc_col-md-6">
                <?php
                if (isset($checkout->checkout_fields['billing']['billing_country'])) {
                    woocommerce_form_field('billing_country', $checkout->checkout_fields['billing']['billing_country'], $checkout->get_value('billing_country'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_address_1'])) {
                    woocommerce_form_field('billing_address_1', $checkout->checkout_fields['billing']['billing_address_1'], $checkout->get_value('billing_address_1'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_first_name'])) {
                    woocommerce_form_field('billing_address_2', array(
                        'type' => 'text',
                        'class' => array('input-text'),
                        'label' => esc_html_e('Street address', 'stockie'),
                        'required' => false,
                    ), $checkout->get_value('billing_address_2'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_city'])) {
                    woocommerce_form_field('billing_city', $checkout->checkout_fields['billing']['billing_city'], $checkout->get_value('billing_city'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_state'])) {
                    woocommerce_form_field('billing_state', $checkout->checkout_fields['billing']['billing_state'], $checkout->get_value('billing_state'));
                }
                if (isset($checkout->checkout_fields['billing']['billing_postcode'])) {
                    woocommerce_form_field('billing_postcode', $checkout->checkout_fields['billing']['billing_postcode'], $checkout->get_value('billing_postcode'));
                }

                foreach ($fields as $key => $field) {
                    if (!in_array($key, $default_fields)) {
                        woocommerce_form_field($key, $field, $checkout->get_value($key));
                    }
                }

                ?>
            </div>
        </div>

        <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
    </div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields">
        <?php if (!$checkout->is_registration_required()) : ?>

            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                           id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?>
                           type="checkbox" name="createaccount" value="1"/>
                    <span><?php esc_html_e('Create an account?', 'stockie'); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>

            <div class="create-account">
                <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>