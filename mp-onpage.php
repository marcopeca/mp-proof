<?php

add_filter('the_content', 'mp_print_page');
wp_register_style('mp-proof-css-simple',MP_PROOF_URL."/css/simple.css?v=".MP_PROOF_VERSION );
wp_register_script('mp-proof-js', MP_PROOF_URL."/js/mp-proof-onpage.js?v=".MP_PROOF_VERSION, array('jquery'));

function mp_print_page($content){
    wp_enqueue_style('mp-proof-css-simple');
    wp_enqueue_script('mp-proof-js');

    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $mp_timer = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_timer'");
    $mp_colore_bordo = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_colore_bordo'");
    $mp_colore_background = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_colore_background'");

    $mp_posizione = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_posizione'");


    $content .= '
    <div class="mp-proof_fixed mp-position_'.$mp_posizione.'" mp-proof-timer="'.$mp_timer.'" mp-proof-colore-bordo="'.$mp_colore_bordo.'" mp-proof-colore-background="'.$mp_colore_background.'" >
    <div class="mp-proof-div mp-proof-width25">
    <img src="'.MP_PROOF_URL.'/img/icon/warning.png" class="mp-img-responsive" alt="alert">
    </div>
    <div class="mp-proof-div mp-proof-width75">
    <p class="mp-proof_p"><strong>37 nome articolo</strong> sono stati venduti nelle ultime 24 ore!</p>
    </div>
    </div>';
    return $content;
}
