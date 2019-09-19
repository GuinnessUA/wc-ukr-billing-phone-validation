<?php
/**
 * Plugin Name: WC Ukr Billing Phone Validation
 * Plugin URI: https://github.com/GuinnessUA/wc-ukr-billing-phone-validation
 * Description: Creating input mask and Ukraine phones validation for Woocommerce billing phone field.
 * Version: 1.0.0
 * Author: Kim Kravchenko
 * License URI: license.txt
 * Tested up to: 5.2.2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', 'cbpf_plugin_scripts' );
function cbpf_plugin_scripts()
{
    wp_register_script('maskinput', plugins_url('assets/js/jquery.maskinput.js', __FILE__), array('jquery'), '1.4.1', true);
    wp_enqueue_script('maskinput');
    wp_register_script('maskphone', plugins_url('assets/js/maskphone.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_enqueue_script('maskphone');
}

// Validate  phone number
add_action('woocommerce_checkout_process', 'cbpf_validate_billing_phone_number');
function cbpf_validate_billing_phone_number()
{
    $is_correct = preg_match('/^(\+38[\(]{1}[0-9]{3}[\)]{1}[ |\-]{0,1}|^[0-9]{3}[\-| ])?[0-9]{3}(\-| ){1}[0-9]{2}(\-| ){1}[0-9]{2}$/', $_POST['billing_phone']);
    if ($_POST['billing_phone'] && !$is_correct) {
        wc_add_notice(__('Valid phone number format is  +38(___) ___-__-__'), 'error');
    }
}

// add placeholder
add_filter( 'woocommerce_billing_fields', 'cbpf_phone_placeholder', 12, 1 );
function cbpf_phone_placeholder( $address_fields ) {
    $address_fields['billing_phone']['placeholder'] = '+38(___) ___-__-__';
    return $address_fields;
}
