<?php

function add_tables(){
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $my_products_db_version = '1.0.0';
    $charset_collate = $wpdb->get_charset_collate();    

    $table_name = $wpdb->prefix . "mp_proof_variabili";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `merge_tag` text NOT NULL,
    `slug_tag` text NOT NULL,
    `visible` ENUM('0','1') NOT NULL,    
    PRIMARY KEY  (ID)) $charset_collate;";
    dbDelta($sql);

    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `impostazioni` text NOT NULL,
    `slug` text NOT NULL,
    `valore` text NOT NULL,
    PRIMARY KEY  (ID)) $charset_collate;";    
    dbDelta($sql);

    add_option( 'my_db_version', $my_products_db_version );
}

function add_settings(){
    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $insert = array("impostazioni" => "forma",
                    "slug" => "MP_PROOF_forma",
                    "valore" => "default");
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "colore-bordo",
                    "slug" => "MP_PROOF_colore_bordo",
                    "valore" => "#155724");
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "colore-background",
                    "slug" => "MP_PROOF_colore_background",
                    "valore" => "#fdfdfd");
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "timer",
                    "slug" => "MP_PROOF_timer",
                    "valore" => "5000");
    $wpdb->insert($table_name,$insert);

    /* Posizione Proof
    // In alto a sinistra:  up-sx
    // In alto a destra:    up-dx
    // In alto al centro:   up-ct
    // In basso a sinistra: bt-sx
    // In basso a destra:   bt-dx
    // In basso al centro:  bt-ct    
    */
    $insert = array("impostazioni" => "posizione",
                    "slug" => "MP_PROOF_posizione",
                    "valore" => "bt-sx");
    $wpdb->insert($table_name,$insert);
}