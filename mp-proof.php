<?php 

/*
Plugin Name:  MP Proof
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Random Proof da far comparire sul sito
Version:      0.9.0
Author:       Marco Peca
Author URI:   https://developer.wordpress.org/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'MP_PROOF_ADMIN_URL', admin_url() . "admin.php" );

define( 'MP_PROOF_VERSION', '0.9.1' );
define( 'MP_PROOF_MAINDIR', plugin_dir_path(__FILE__));
define( 'MP_PROOF_URL', plugins_url("mp-proof"));

// Menu
define( 'MP_PROOF_MAIN_MENU_SLUG', 'mp-proof-options-page' );

$mp_proof_table_array = array();
array_push($mp_proof_table_array, "mp_proof_variabili");
array_push($mp_proof_table_array, "mp_proof_impostazioni");

define( 'MP_PROOF_TABLE', json_encode($mp_proof_table_array) );

// Code Activate
function installer(){
    include_once(MP_PROOF_MAINDIR . "lib/installer.php");
    add_tables();
    add_settings();
}
register_activation_hook( __FILE__, 'installer' );

// Code Dectivate
function uninstaller(){
    include_once(MP_PROOF_MAINDIR . "lib/uninstaller.php");
    remove_tables();
}
register_deactivation_hook(__FILE__, 'uninstaller' );

/*
function tl_save_error() {
    update_option( 'plugin_error',  ob_get_contents() );
}
add_action( 'activated_plugin', 'tl_save_error' );
echo get_option( 'plugin_error' );
*/

require_once( MP_PROOF_MAINDIR . "init.php");
require_once( MP_PROOF_MAINDIR . "mp-main-setting-page.php");

require_once( MP_PROOF_MAINDIR . "mp-onpage.php");