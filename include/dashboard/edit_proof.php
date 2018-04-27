<?php

// Stili e Script
wp_register_script('mp-add-proof-js', MP_PROOF_URL."/js/add-proof.js?v=".MP_PROOF_VERSION, array('jquery'));
wp_enqueue_script('mp-add-proof-js');

$all_variables = proof_get_results_query($table_variabili,"*",array("visible" => "1"));
$value_variables = array();
foreach($all_variables as $mpv){
    $x = proof_get_var_query($table_variabili_val, "valore", array("id_variabile" => $mpv->ID));
    $value_variables[] = array($mpv->slug_tag => $x);
}
$json_val_variables = json_encode($value_variables);

$url_back = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-dashboard";
$redirect = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-dashboard";

?>

<h3>MP Proof - Aggiungi un Proof</h3>
<a href="<?php echo $url_back; ?>">Torna indietro</a>
<hr/>

<form action="" method="post" id="vdati_form_upd">
    <div class="mp-proof-50">
        <div class="content">
            <input type="hidden" name="MP_PROOF_hidden_val" id="MP_PROOF_hidden_val" value='<?php echo $json_val_variables?>'/>
            <input type="hidden" name="MP_PROOF_hidden_val_used" id="MP_PROOF_hidden_val_used" value='<?php echo $json_val_variables?>'/>
            <input type="hidden" name="MP_PROOF_action" value="add_proof_text"/>
            <input type="hidden" name="MP_PROOF_redirect" value="<?php echo $redirect;?>"/>


            <table class="mp-proof-table">
                <tbody>
                    <tr valign="center">
                        <th scope="row">
                            <label for="MP_PROOF_text_proof">
                                Testo Proof
                            </label>
                        </th>
                        <td>
                            <textarea name="MP_PROOF_text_proof" id="MP_PROOF_text_proof" cols="50" rows="5"></textarea>
                        </td>
                    </tr>
                    <tr valign="center">
                        <th scope="row">
                            <label for="MP_PROOF_active_proof">
                                Proof Attivo
                            </label>
                        </th>
                        <td>
                            <select name="MP_PROOF_active_proof" id="MP_PROOF_active_proof">
                                <option value="1" selected="selected">Sì</option>
                                <option value="0">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label>
                                Usa le variabili
                            </label>
                        </th>
                        <td>
                            <?php foreach($all_variables as $mpv) : ?>
                                <button class="js_proof_var_click mp-proof-btn mp-proof-btn-sm mp-proof-btn-action" btn-data="<?php echo $mpv->slug_tag?>"><?php echo $mpv->merge_tag ?></button>
                            <?php endforeach; ?>
                        </td>
                    </tr>                    
                    <tr>
                        <td colspan="2">
                            <p><strong>NB:</strong> Aggiungi e rimuovi le variabili con gli opportuni pulsanti.<br/>
                            Una volta selezionata sarà possibile fare copia/incolla all'interno dell'area di testo se si vuole utilizzare più volte.</p>
                        </td>
                    </tr>
                </tbody>
            </table>        
        </div>
    </div>
    <div class="mp-proof-50">
        <div class="content">
            <h3>Preview Testo Proof:</h3>
            <p id="preview_proof"></p>
        </div>
    </div>
    <div class="mp-proof-100">
        <div class="content">
            <table>
                <tbody>
                    <tr valign="top">
                        <th>
                            <input type="submit" value="Salva" class="mp-proof-btn mp-proof-btn-success"/>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>