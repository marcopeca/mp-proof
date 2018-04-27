<?php

function remove_tables(){
    global $wpdb;

    foreach(json_decode(MP_PROOF_TABLE) as $table){
        $table_name = $wpdb->prefix . $table;
        //$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
    }
    delete_option("my_db_version");
}