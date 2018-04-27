<?php


if(isset($_POST["MP_PROOF_action"])){
    global $wpdb;
    $redirect = $_POST["MP_PROOF_redirect"];
    $action = $_POST["MP_PROOF_action"];

    if($action == "add_proof_text"){
        $proof = $_POST["MP_PROOF_text_proof"];
        $var = $_POST["MP_PROOF_hidden_val_used"];
        $visibile = $_POST["MP_PROOF_active_proof"];

        $table_name = $wpdb->prefix . "mp_proof";
        $insert = array("proof_text" => trim($proof),
                        "variabili" => $var,
                        "visible" => $visibile);
        $wpdb->insert($table_name,$insert);        

    }    

    header("location: $redirect");
}

function mp_proof_dashboard(){
    global $wpdb;
    $table_variabili = $wpdb->prefix . "mp_proof_variabili";
    $table_variabili_val = $wpdb->prefix . "mp_proof_variabili_val";
    $table_proof = $wpdb->prefix . "mp_proof";
    $count_var = proof_get_var_query($table_variabili, "COUNT(ID) AS tot");
    $all_proof = proof_get_results_query($table_proof);

    $add_proof_url = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-dashboard&action=add";

    // Recupero ID variabili in input
    $mp_proof_action = $_GET["action"];    

    if($mp_proof_action == "DEL"){
        $id_proof = $_GET["id_proof"];
        $wpdb->delete( $table_proof, array('ID' => $id_proof ) );
        
        wp_redirect(MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-dashboard");        
        exit;
    }

    ?>

    <div class="wrap">        
        <div class="icon32" id="icon-options-general"><br /></div>
        <h2>MP Proof - Dashboard</h2>

        <?php if($mp_proof_action == "add"): ?>
            <?php include_once( MP_PROOF_MAINDIR . "include/dashboard/add_proof.php"); ?>
            <?php 
        else : 
            // Visualizza home dashboard
            ?>
            <?php include_once( MP_PROOF_MAINDIR . "include/dashboard/show_proof.php"); ?>
        <?php endif; ?>
    </div>
    <?php
}