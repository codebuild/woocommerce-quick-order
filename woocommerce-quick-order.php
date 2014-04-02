<?php
/*
Plugin Name: Woocommerce Quick Order
Plugin URI: http://codebuild.hu/
Description: Woocommerce gyors rendelés oldal
Version: 1.0
Author: Keresztúry Zoltán
Author URI: http://codebuild.hu/
License: GPLv2 or later
*/

define('WC_QUICK_ORDER', dirname(__FILE__));
define('CODEBUILD', WC_QUICK_ORDER.'/codebuild/');

require CODEBUILD . 'wp/CB_Plugin.php';
require CODEBUILD . 'wc/WC_ShortcodeQuickOrder.php';


/**
 * Class WC_QuickOrder
 *
 * @version 1.0
 * @author Codebuild - Keresztúry Zoltán
 *
 */
class WC_QuickOrder extends CB_Plugin
{
    public function __construct()
    {
        parent::__construct();
        add_action( 'init',  array($this, 'update_cart'), 20);
        add_action( 'plugins_loaded', array($this, 'load_textdomain') );
    }


    /**
     * wp_register_style('test_style', plugins_url('style.css', __FILE__));
     * wp_enqueue_style('test_style');
     * Stilus lapok regisztrálása és betöltése
     *
     * @access public
     * @return void
     */
    public function loadStyles()
    {
        // TODO: Implement loadStyles() method.
    }

    /**
     * wp_enqueue_script('jquery');
     * Scriptek regisztrálása betöltése
     *
     * @access public
     * @return void
     */
    public function loadScripts()
    {
        // TODO: Implement loadScripts() method.
    }

    /**
     * bővitmény (Plugin) aktiválása
     *
     * @access public
     * @return void
     */
    public function activation()
    {
        // http://codex.wordpress.org/Class_Reference/WP_Error
        // TODO: Implement activation() method.
    }

    /**
     * bővitmény (Plugin) deaktiválása
     *
     * @access public
     * @return void
     */
    public function deactivation()
    {
        // TODO: Implement deactivation() method.
    }

    /**
     * Load nyelvi fájlok
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('wc-quick-order', false, 'woocommerce-quick-order/languages');
    }

    /**
     * Kosár frissitésekor jöjjünk vissza erre az oldalra
     *
     * @access public
     * @return void
     */
    public function update_cart()
    {
        if(isset($_POST['update_cart']))
        {
            $referer = ( $this->get_page_id() ) ?  get_permalink($this->get_page_id()) : wp_get_referer();
            wp_safe_redirect( $referer );
            exit;
        }
    }

    /**
     * @access public
     * @param $templateName
     * @return void
     */
    public function loadTemplate($templateName)
    {
        if(locate_template($templateName.'.php') == '')
        {
            include WC_QUICK_ORDER .'/templates/'.$templateName.'.php';
        }
    }

    /**
     * ShortTag [woocommerce_quick_order]
     *
     * @access public
     * @param array $atts
     * @return string
     */
    public function shortcode($atts)
    {
        return WC_Shortcodes::shortcode_wrapper( array( 'WC_ShortcodeQuickOrder', 'output' ), $atts , array('class' => 'quick_order'));
    }

    /**
     * Beállítások mezői
     *
     * @access public
     * @return array
     */
    private function getSettingsField()
    {
        return array
        (
            array
            (
                'title'     =>  __( 'Quick Order Page', 'wc-quick-order' ),
                'desc' 		=> __( 'Page contents:', 'woocommerce' ) . ' [' . apply_filters( 'woocommerce_quick_order_shortcode_tag', 'woocommerce_quick_order' ) . ']',
                'id' 		=> 'woocommerce_quick_order_page_id',
                'type' 		=> 'single_select_page',
                'default'	=> '',
                'class'		=> 'chosen_select_nostd',
                'css' 		=> 'min-width:300px;',
                'desc_tip'	=> true,
            )
        );
    }

    /**
     * Beállítáások mentése
     */
    public function settingsSave()
    {
        WC_Admin_Settings::save_fields( $this->getSettingsField() );
    }

    /**
     * Beállításhoz szügséges mezök legenerálása az admin oldalon
     *
     */
    public function settings()
    {
        WC_Admin_Settings::output_fields( $this->getSettingsField() );
    }

    public function get_page_id()
    {
        return get_option('woocommerce_quick_order_page_id');
    }

    /**
     * Link kirajzolása
     *
     * @access public
     * @return void
     */
    public function link()
    {
        $id = $this->get_page_id();
        if(!empty($id))
        {
            $title = get_the_title($id);
            echo '<a class="quick_order_link" href="'. get_permalink($id).'" title="'.$title.'" >' .$title.'</a>';
        }
    }

    /**
     * bővitmény (Plugin) betöltése
     *
     * @access public
     * @return void
     */
    public function init()
    {
        if(is_admin())
        {
            add_action( 'woocommerce_settings_' . sanitize_title('checkout_page_options' ) . '_end', array($this, 'settings'));
            // add_action( 'woocommerce_settings_checkout', array( $this, 'output' ) );
            add_action( 'woocommerce_settings_save_checkout', array( $this, 'settingsSave' ) );
        }
        add_shortcode( apply_filters( "'woocommerce_quick_order_shortcode_tag", 'woocommerce_quick_order' ), array($this, 'shortcode'));
    }
}
$GLOBALS['wcQuickOrder'] = new WC_QuickOrder();

function wc_quick_order_link()
{
    /** @var WC_QuickOrder $wcQuickOrder */
    global $wcQuickOrder;
    $wcQuickOrder->link();
}

function wc_get_cart_table_template()
{
    /** @var WC_QuickOrder $wcQuickOrder */
    global $wcQuickOrder;
    // TODO dinamikusnak kéne lenni a sablon mappában is kéne keresnie
    $wcQuickOrder->loadTemplate('cart-table');
}
?>