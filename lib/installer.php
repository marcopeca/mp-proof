<?php

function add_tables(){
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $my_products_db_version = '1.0.0';
    $charset_collate = $wpdb->get_charset_collate();    

    /*
    Tabella per inserire le variabili dei proof
    */
    $table_name = $wpdb->prefix . "mp_proof";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `proof_text` text NOT NULL,
    `variabili` longtext NOT NULL,
    `visible` ENUM('0','1') NOT NULL,    
    PRIMARY KEY  (ID)) $charset_collate;";
    dbDelta($sql);

    /*
    Tabella per inserire le variabili dei proof
    */
    $table_name = $wpdb->prefix . "mp_proof_variabili";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `merge_tag` text NOT NULL,
    `slug_tag` text NOT NULL,
    `use_immagine` text NOT NULL,    
    `visible` ENUM('0','1') NOT NULL,    
    PRIMARY KEY  (ID)) $charset_collate;";
    dbDelta($sql);

    /*
    Tabella per associare dei valori alle variabili
    */
    $table_name = $wpdb->prefix . "mp_proof_variabili_val";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `id_variabile` mediumint(9) NOT NULL,
    `valore` text NOT NULL,
    `immagine` text NOT NULL,    
    PRIMARY KEY  (ID)) $charset_collate;";
    dbDelta($sql);

    /*
    Tabella per gestire le impostazioni di MP Proof
    */
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `impostazioni` text NOT NULL,
    `slug` text NOT NULL,
    `valore` text NOT NULL,
    `type_input` text NOT NULL,
    `ordine` mediumint(9) NOT NULL,
    PRIMARY KEY  (ID)) $charset_collate;";    
    dbDelta($sql);

    /*
    Tabella per gestire le variabili multimple delle impostazioni di MP Proof
    */
    $table_name = $wpdb->prefix . "mp_proof_impostazioni_val";
    $sql = "CREATE TABLE $table_name (
    ID mediumint(9) NOT NULL AUTO_INCREMENT,
    `ID_impostazioni` mediumint(9) NOT NULL,    
    `label` text NOT NULL,        
    `valore` text NOT NULL,        
    PRIMARY KEY  (ID)) $charset_collate;";    
    dbDelta($sql);

    add_option( 'my_db_version', $my_products_db_version );
}

function add_settings(){
    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $insert = array("impostazioni" => "attivo",
                    "slug" => "MP_PROOF_active",
                    "valore" => "0",
                    "type_input" => "radio",
                    "ordine" => 1);
    $wpdb->insert($table_name,$insert);
    $MP_PROOF_active = $wpdb->insert_id;

    $insert = array("impostazioni" => "forma",
                    "slug" => "MP_PROOF_forma",
                    "valore" => "default",
                    "type_input" => "select",
                    "ordine" => 2);
    $wpdb->insert($table_name,$insert);
    $MP_PROOF_forma = $wpdb->insert_id;

    $insert = array("impostazioni" => "colore-bordo",
                    "slug" => "MP_PROOF_colore_bordo",
                    "valore" => "#155724",
                    "type_input" => "text",
                    "ordine" => 3);
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "colore-background",
                    "slug" => "MP_PROOF_colore_background",
                    "valore" => "#fdfdfd",
                    "type_input" => "text",
                    "ordine" => 4);
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "time_min",
                    "slug" => "MP_PROOF_time_min",
                    "valore" => "1",
                    "type_input" => "text",
                    "ordine" => 5);
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "time_max",
                    "slug" => "MP_PROOF_time_max",
                    "valore" => "15",
                    "type_input" => "text",
                    "ordine" => 6);
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "timer",
                    "slug" => "MP_PROOF_timer",
                    "valore" => "5000",
                    "type_input" => "text",
                    "ordine" => 7);
    $wpdb->insert($table_name,$insert);

    $insert = array("impostazioni" => "timer-permanenza",
                    "slug" => "MP_PROOF_timer_permanenza",
                    "valore" => "2000",
                    "type_input" => "text",
                    "ordine" => 8);
    $wpdb->insert($table_name,$insert);
    
    $insert = array("impostazioni" => "posizione",
                    "slug" => "MP_PROOF_posizione",
                    "valore" => "bt-sx",
                    "type_input" => "select",
                    "ordine" => 9);
    $wpdb->insert($table_name,$insert);
    $MP_PROOF_posizione = $wpdb->insert_id;

    $table_name = $wpdb->prefix . "mp_proof_impostazioni_val";

    /* Inserisci Opzioni Attivo */
    $insert = array("ID_impostazioni" => $MP_PROOF_active,
                    "label" => "Sì",
                    "valore" => "1");
    $wpdb->insert($table_name,$insert);
    $insert = array("ID_impostazioni" => $MP_PROOF_active,
                    "label" => "No",
                    "valore" => "0");
    $wpdb->insert($table_name,$insert);

    /* Inserisci Opzioni Forma */    
    $insert = array("ID_impostazioni" => $MP_PROOF_forma,
                    "label" => "Default",
                    "valore" => "default");
    $wpdb->insert($table_name,$insert);

    /* Inserisci Opzioni Posizioni */
    $mp_position = array();
    array_push($mp_position, array("In Alto a Sinistra","up-sx"));
    array_push($mp_position, array("In Alto a Destra","up-dx"));
    //array_push($mp_position, array("In Alto al Centro","up-ct"));
    array_push($mp_position, array("In Basso a Sinistra","bt-sx"));
    array_push($mp_position, array("In Basso a Destra","bt-dx"));
    //array_push($mp_position, array("In Basso al Centro","bt-ct"));    

    foreach($mp_position as $val){
        $insert = array("ID_impostazioni" => $MP_PROOF_posizione,
                        "label" => $val[0],
                        "valore" => $val[1]);
        $wpdb->insert($table_name,$insert);
    }    

}