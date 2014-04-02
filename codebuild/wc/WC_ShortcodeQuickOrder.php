<?php

/**
 * Class WC_ShortcodeQuickOrder
 * gyors rendelés shortcode
 *
 * @author Keresztúry Zoltán - Codebuild
 * @version 1.0
 */
class WC_ShortcodeQuickOrder
{
    /**
     * Output the cart shortcode.
     *
     * @global WC_QuickOrder $wcQuickOrder
     * @param array $atts
     */
    public static function output( $atts ) {

        global $wcQuickOrder;

        // Check cart class is loaded or abort
        if ( is_null( WC()->cart ) ) {
            return;
        }

        // Constants
        if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
            define( 'WOOCOMMERCE_CART', true );
        }

        // Constants
        if ( ! defined( 'WOOCOMMERCE_QUICK_ORDER' ) ) {
            define( 'WOOCOMMERCE_QUICK_ORDER', get_the_ID() );
        }

        // Check cart items are valid
        do_action('woocommerce_check_cart_items');

        // Calc totals
        WC()->cart->calculate_totals();

        /** @var WC_QuickOrder $wcQuickOrder */
        $wcQuickOrder->loadTemplate('quick-order');
    }
} 