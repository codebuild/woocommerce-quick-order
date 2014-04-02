<?php
/**
 * Class Plugin
 * WP plugin alap osztály
 * Néhány alap dolgot elintéz helyettünk
 *
 * @version 1.0
 * @author Codebuild - Keresztúry Zoltán
 * @package codebuild\wp
 *
 */
abstract class CB_Plugin
{
    /**
     * Plugin betöltése
     *
     * @acceess public
     * @constructor
     */
    public function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'activation'));
        register_deactivation_hook(__FILE__, array($this, 'deactivation'));

        add_action('wp_enqueue_scripts', array($this, 'loadScripts'));
        add_action('wp_enqueue_scripts', array($this, 'loadStyles'));
        add_action( 'init',  array($this, 'init'));
    }

    /**
     * wp_register_style('test_style', plugins_url('style.css', __FILE__));
     * wp_enqueue_style('test_style');
     * Stilus lapok regisztrálása és betöltése
     *
     * @access public
     * @return void
     */
    abstract public function loadStyles();

    /**
     * wp_enqueue_script('jquery');
     * Scriptek regisztrálása betöltése
     *
     * @access public
     * @return void
     */
    abstract public function loadScripts();

    /**
     * bővitmény (Plugin) aktiválása
     *
     * @access public
     * @return void
     */
    abstract public function activation();

    /**
     * bővitmény (Plugin) deaktiválása
     *
     * @access public
     * @return void
     */
    abstract public function deactivation();

    /**
     * bővitmény (Plugin) betöltése
     *
     * @access public
     * @return void
     */
    abstract public function init();
}