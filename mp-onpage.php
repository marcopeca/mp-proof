<?php

add_filter('the_content', 'mp_print_page');
wp_register_style('mp-proof-css-simple',MP_PROOF_URL."/css/simple.css?v=".MP_PROOF_VERSION );
wp_register_script('mp-proof-js', MP_PROOF_URL."/js/mp-proof-onpage.js?v=".MP_PROOF_VERSION, array('jquery'));

function mp_print_page($content){

    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $table_variabili = $wpdb->prefix . "mp_proof_variabili";
    $table_variabili_val = $wpdb->prefix . "mp_proof_variabili_val";
    $mp_active = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_active'"); 
    $table_proof = $wpdb->prefix . "mp_proof";

    $all_proof = proof_get_results_query($table_proof,"*",array("visible" => 1));

    if($mp_active == "1" && count($all_proof)){
        $mp_timer = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_timer'");
        $mp_timer_permanenza = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_timer_permanenza'");

        $mp_colore_bordo = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_colore_bordo'");
        $mp_colore_background = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_colore_background'");

        $mp_posizione = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_posizione'");

        $mp_time_min = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_time_min'");

        $mp_time_max = $wpdb->get_var("SELECT valore FROM $table_name WHERE slug = 'MP_PROOF_time_max'");
        wp_enqueue_style('mp-proof-css-simple');
        wp_enqueue_script('mp-proof-js');

        for($mp_counter = 0; $mp_counter < MP_PROOF_REPEAT; $mp_counter++){
            $single_proof = proof_get_results_query($table_proof,"*",array("visible" => 1), array("random" => true, "limit" => "0,1"));
            $proof = "";    
            foreach($single_proof as $mp_obj){
                $proof = $mp_obj->proof_text;
                foreach(json_decode($mp_obj->variabili) as $key=>$mp_var){

                    $x = $wpdb->get_var("SELECT V.valore 
                                        FROM $table_variabili T
                                        JOIN $table_variabili_val V ON V.id_variabile = T.ID
                                        WHERE T.visible = '1' AND T.use_immagine = '0' AND T.slug_tag = '".$key."'
                                        ORDER BY RAND()");
                    if(count($x)){
                        $proof = str_replace("%%$key%%", $x, $proof);
                    }
                }

                foreach(json_decode($mp_obj->variabili) as $key2=>$mp_var2){

                    $y = $wpdb->get_results("SELECT V.* 
                                            FROM $table_variabili T
                                            JOIN $table_variabili_val V ON V.id_variabile = T.ID
                                            WHERE T.visible = '1' AND T.use_immagine = '1' AND T.slug_tag = '".$key2."'
                                            ORDER BY RAND() LIMIT 0,1");

                    if(count($y)){
                        $proof = str_replace("%%$key2%%", $y[0]->valore, $proof);
                        $mp_img = $y[0]->immagine;
                    }
                }
            }

            $mp_rand_time = rand($mp_time_min,$mp_time_max);
            $mp_minuti = "minuti";
            if($mp_rand_time == 1){
                $mp_minuti = "minuto";
            }

            if(!isset($mp_img)){
                $mp_img = MP_PROOF_URL."/img/icon/warning.png";
            }            
            $mp_time = "$mp_rand_time $mp_minuti fa";        

            $content .= '
            <div class="mp-proof_fixed mp-position_'.$mp_posizione.'" mp-proof-counter="'.$mp_counter.'" mp-proof-timer="'.$mp_timer.'" mp-proof-timer-permanenza="'.$mp_timer_permanenza.'" mp-proof-colore-bordo="'.$mp_colore_bordo.'" mp-proof-colore-background="'.$mp_colore_background.'" style="display: none;">
            <div class="mp-proof-close">
            <span class="js_close_proof">X</span>
            </div>
            <div class="mp-proof-div mp-proof-width25">
            <img src="'. $mp_img.'" class="mp-img-responsive" alt="alert">
            </div>
            <div class="mp-proof-div mp-proof-width75">
            <p class="mp-proof_p">
            '.$proof.'
            <br/>
            <span class="mp-proof_time">'.$mp_time.'</span>
            </p>
            </div>
            </div>';
        }

        return $content;
    }
}
