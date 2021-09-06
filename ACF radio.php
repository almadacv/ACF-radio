<?php
/**
 * Plugin Name:       ACF radio
 * Description:       tentativa
 * Requires at least: 4.0
 * Author:            ninguem ainda
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define("RADIO_DINAMICO_PLUGIN_PATH", plugin_dir_path( __FILE__ ));
define("RADIO_DINAMICO_PLUGIN_TEMPLATES_PATH", RADIO_DINAMICO_PLUGIN_PATH . 'templates/');
define("RADIO_DINAMICO_PLUGIN_ASSETS", plugin_dir_url( __FILE__ ) .'assets/');

include 'classes/ACF radio.php';

new RadioDinamico;


?>