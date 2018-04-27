<?php

add_action('admin_menu','my_admin_menu');
add_action('admin_init','mp_proof_init');
register_activation_hook( __FILE__, 'mp_proof_activate_set_default_options');

// Record nel DB
function mp_proof_activate_set_default_options(){    
    add_option('mp_options', json_encode(array()));
}

function mp_proof_init(){
    register_setting('mp_settings', 'mp_options');
}

// Aggiungi in tab impostazioni la voce del plugin
function my_admin_menu() {
    add_menu_page('MP PROOF', 'MP PROOF', 'administrator', MP_PROOF_MAIN_MENU_SLUG, 'mp_proof_update_options_form');
    add_submenu_page(MP_PROOF_MAIN_MENU_SLUG,'Dashboard','Dashboard','administrator','mp-proof-admin-dashboard','mp_proof_dashboard');
    add_submenu_page(MP_PROOF_MAIN_MENU_SLUG,'Impostazioni','Impostazioni','administrator','mp-proof-admin-impostazioni','mp_proof_update_options_impostazioni');    
    add_submenu_page(MP_PROOF_MAIN_MENU_SLUG,'Variabili','Variabili','administrator','mp-proof-admin-variabili','mp_proof_update_options_variabili');
}