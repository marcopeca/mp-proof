<?php 

wp_register_script('mp-media-js', MP_PROOF_URL."/js/media.js?v=".MP_PROOF_VERSION, array('jquery'));

if(isset($_POST["MP_PROOF_action"])){
    global $wpdb;
    $redirect = $_POST["MP_PROOF_redirect"];
    $action = $_POST["MP_PROOF_action"];

    if($action == "add_variable"){
        $nome = ucwords(strtolower($_POST["MP_PROOF_name_var"]));
        $visibile = $_POST["MP_PROOF_visible_var"];
        $use_img = $_POST["MP_PROOF_datause_img"];

        $table_name = $wpdb->prefix . "mp_proof_variabili";
        $insert = array("merge_tag" => $nome,
                        "slug_tag" => slugify($nome),
                        "use_immagine" => $use_img,
                        "visible" => $visibile);
        $wpdb->insert($table_name,$insert);
    }
    if($action == "add_data_variable"){
        $id = $_POST["MP_PROOF_id_var"];
        $img = $_POST["MP_PROOF_img_var"];

        $data = explode("\n", $_POST["MP_PROOF_data_text"]);        
        $table_name = $wpdb->prefix . "mp_proof_variabili_val";
        foreach($data as $d){
            $insert = array("id_variabile" => $id,
                            "valore" => trim($d),
                            "immagine" => $img);
            $wpdb->insert($table_name,$insert);
        }
    }
    if($action == "upd_data_variable"){
        $id = $_POST["MP_PROOF_id_var"];
        $id_val = $_POST["MP_PROOF_id_val"];
        $img = $_POST["MP_PROOF_img_var"];
        $d = $_POST["MP_PROOF_data_text"];

        $update = array("id_variabile" => $id,
                        "valore" => trim($d),
                        "immagine" => $img);
        $table_name = $wpdb->prefix . "mp_proof_variabili_val";
        $wpdb->update($table_name,$update,array("ID" => $id_val));
    }
    if($action == "edit_settings"){
        $table_name = $wpdb->prefix . "mp_proof_impostazioni";
        
        $active = $_POST["MP_PROOF_active"];
        $update = array("valore" => $active);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_active"));

        $forma = $_POST["MP_PROOF_forma"];
        $update = array("valore" => $forma);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_forma"));
        
        $colore_bordo = $_POST["MP_PROOF_colore_bordo"];
        $update = array("valore" => $colore_bordo);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_colore_bordo"));

        $colore_background = $_POST["MP_PROOF_colore_background"];
        $update = array("valore" => $colore_background);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_colore_background"));

        $time_min = $_POST["MP_PROOF_time_min"];
        $update = array("valore" => $time_min);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_time_min"));

        $time_max = $_POST["MP_PROOF_time_max"];
        $update = array("valore" => $time_max);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_time_max"));

        $timer = $_POST["MP_PROOF_timer"];
        $update = array("valore" => $timer);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_timer"));

        $timer_permanenza = $_POST["MP_PROOF_timer_permanenza"];
        $update = array("valore" => $timer_permanenza);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_timer_permanenza"));

        $posizione = $_POST["MP_PROOF_posizione"];
        $update = array("valore" => $posizione);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_posizione"));
    }

    header("location: $redirect");
}

function mp_proof_update_options_form(){}

function mp_proof_update_options_impostazioni(){
    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $mp_impostazioni = $wpdb->get_results("SELECT * FROM $table_name ORDER BY ordine");

    wp_enqueue_style('mp-proof-admin-css');

    $redirect = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-impostazioni";
    ?>

    <div class="wrap">
        <h2>MP Proof - Impostazioni</h2>
        <div class="mp-div-form">
            <p>
                Modifica le impostazioni di visualizzazione dei <strong>Proof</strong>.
            </p>
            <form action="" method="post" id="v_form">
                <input type="hidden" name="MP_PROOF_action" value="edit_settings"/>
                <input type="hidden" name="MP_PROOF_redirect" value="<?php echo $redirect;?>"/>
                <table>
                    <tbody>
                        <?php
                        foreach($mp_impostazioni as $imp){
                            ?>
                            <tr>
                                <th colspan="2">
                                    <hr/>
                                </th>
                            </tr>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="<?php echo $imp->slug; ?>">
                                        <?php echo $imp->impostazioni; ?>
                                    </label>
                                </th>
                                <?php
                                if($imp->type_input == "text") :
                                    ?>
                                    <td>
                                        <input type="text" name="<?php echo $imp->slug; ?>" id="<?php echo $imp->slug; ?>" value="<?php echo $imp->valore; ?>"/>
                                    </td>
                                    <?php
                                elseif($imp->type_input == "select") :
                                    $table_name = $wpdb->prefix . "mp_proof_impostazioni_val";
                                    $mp_impostazioni_val = $wpdb->get_results("SELECT * FROM $table_name WHERE ID_impostazioni = ". $imp->ID);
                                    ?>
                                    <td>
                                        <select name="<?php echo $imp->slug; ?>" id="<?php echo $imp->slug; ?>">
                                            <?php
                                            foreach($mp_impostazioni_val as $imp_val){
                                                ?>
                                                <option value="<?php echo $imp_val->valore; ?>" <?php echo ($imp_val->valore == $imp->valore) ? "selected=\"selected\"" : "" ; ?>><?php echo $imp_val->label; ?></option>
                                                <?php
                                            }                                        
                                            ?>
                                        </select>
                                    </td>
                                    <?php
                                elseif($imp->type_input == "radio") :                                   
                                    $table_name = $wpdb->prefix . "mp_proof_impostazioni_val";
                                    $mp_impostazioni_val = $wpdb->get_results("SELECT * FROM $table_name WHERE ID_impostazioni = ". $imp->ID);
                                    ?>
                                    <td>
                                        <?php
                                        foreach($mp_impostazioni_val as $imp_val){
                                            ?>
                                            <label class="mp-proof-admin-radio" for="<?php echo $imp->slug . $imp_val->valore; ?>">
                                                <input type="radio" name="<?php echo $imp->slug; ?>" id="<?php echo $imp->slug . $imp_val->valore; ?>" value="<?php echo $imp_val->valore; ?>" <?php echo ($imp_val->valore == $imp->valore) ? " checked" : "" ; ?> /> <?php echo $imp_val->label; ?>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <?php
                                endif;
                                ?>
                            </tr>                            
                            <?php
                        }
                        ?>
                        <tr>
                            <th colspan="2">
                                <hr/>
                            </th>
                        </tr>
                        <tr valign="top">
                            <th>
                                <input type="submit" value="Salva" class="mp-proof-btn"/>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <?php
}

function mp_proof_update_options_variabili(){
    wp_register_script('mp-proof-admin-js', MP_PROOF_URL."/js/mp-proof-admin-update-options.js?v=".MP_PROOF_VERSION, array('jquery'));
    wp_enqueue_script('mp-proof-admin-js');
    wp_enqueue_style('mp-proof-admin-css');

    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_variabili";
    $table_name_2 = $wpdb->prefix . "mp_proof_variabili_val";

    // Recupero ID variabili in input
    $id_var = $_GET["id_var"];

    // Recupero ACTION in input
    if(isset($_GET["action"]) && $_GET["action"] == "DEL"){
        $id_val = $_GET["id_val"];
        $wpdb->delete( $table_name_2, array('ID' => $id_val ) );
        
        wp_redirect(MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-variabili&id_var=$id_var");        
        exit;
    } else if(isset($_GET["action"]) && $_GET["action"] == "UPD"){
        wp_enqueue_script('mp-media-js');
        $id_val = $_GET["id_val"];

        $mp_use_img = proof_get_var_query($table_name, "use_immagine",array("ID" => $id_var));
        $mp_var = proof_get_var_query($table_name, "merge_tag",array("ID" => $id_var));
        $mp_val = proof_get_results_query($table_name_2,"*",array("ID" => $id_val));
        $mp_val = $mp_val[0];

        
        $redirect = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-variabili&id_var=$id_var";

        $url_back = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-variabili&id_var=$id_var";
        ?>
        <div class="wrap">
            <h2>MP Proof - Modifica dato per la variabile "<?php echo $mp_var;?>"</h2>

            <a href="<?php echo $url_back; ?>">Torna indietro</a>

            <form action="" method="post" id="vdati_form_upd">
                <input type="hidden" name="MP_PROOF_action" value="upd_data_variable"/>
                <input type="hidden" name="MP_PROOF_redirect" value="<?php echo $redirect;?>"/>
                <input type="hidden" name="MP_PROOF_id_var" value="<?php echo $id_var;?>"/>
                <input type="hidden" name="MP_PROOF_id_val" value="<?php echo $id_val;?>"/>
                <input type="hidden" id="MP_PROOF_img_var" name="MP_PROOF_img_var" value="<?php echo $mp_val->immagine; ?>"/>
                <table>
                    <tbody>
                        <?php if($mp_use_img == "1") :?>
                            <tr valign="center">
                                <th scope="row">
                                    <label for="MP_PROOF_data_img">
                                        Immagine di default
                                    </label>
                                </th>
                                <td>
                                    <span id="mp-proof_img_data_default">
                                        <img src="<?php echo $mp_val->immagine; ?>" style='width: 150px;'>
                                    </span><br/>
                                    <button class="set_custom_images button">Imposta immagine</button>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr valign="center">
                            <th scope="row">
                                <label for="MP_PROOF_data_text">
                                    Valore
                                </label>
                            </th>
                            <td>
                                <input type="text" name="MP_PROOF_data_text" id="MP_PROOF_data_text" value="<?php echo $mp_val->valore; ?>"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>
                                <input type="submit" value="Modifica" class="mp-proof-btn"/>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <?php
    } else {

        wp_enqueue_script('mp-media-js');

        $mp_var = $wpdb->get_var("SELECT merge_tag FROM $table_name WHERE ID = $id_var");

        if($id_var !== NULL){
            $mp_data_variabili = $wpdb->get_results("SELECT * FROM $table_name_2 WHERE id_variabile = $id_var");

            $mp_use_img = $wpdb->get_var("SELECT use_immagine FROM $table_name WHERE ID = $id_var");


            $redirect = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-variabili&id_var=$id_var";

            $url_back = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-variabili";

            ?>
            <div class="wrap">
                <h2>MP Proof - Aggiungi dati alla variabile "<?php echo $mp_var;?>"</h2>

                <a href="<?php echo $url_back; ?>">Torna indietro</a>

                <div class="mp-div-form">
                    <form action="" method="post" id="vdati_form">
                        <input type="hidden" name="MP_PROOF_action" value="add_data_variable"/>
                        <input type="hidden" name="MP_PROOF_redirect" value="<?php echo $redirect;?>"/>
                        <input type="hidden" name="MP_PROOF_id_var" value="<?php echo $id_var;?>"/>
                        <input type="hidden" id="MP_PROOF_img_var" name="MP_PROOF_img_var" value=""/>
                        <table>
                            <tbody>
                                <?php if($mp_use_img == "1") :?>
                                    <tr valign="center">
                                        <th scope="row">
                                            <label for="MP_PROOF_data_img">
                                                Immagine di default
                                            </label>
                                        </th>
                                        <td>
                                            <span id="mp-proof_img_data_default"></span><br/>
                                            <button class="set_custom_images button">Imposta immagine</button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr valign="center">
                                    <th scope="row">
                                        <label for="MP_PROOF_data_text">
                                            Data
                                        </label>
                                    </th>
                                    <td>
                                        <textarea name="MP_PROOF_data_text" id="MP_PROOF_data_text" cols="50" rows="5"></textarea>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th>
                                        <input type="submit" value="Salva" class="mp-proof-btn"/>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="mp-div-table">
                    <table class="mp-proof-table">
                        <thead class="mp-proof-thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Variabile</th>
                                <?php if($mp_use_img == "1") :?>
                                    <th>Immagine</th>
                                <?php endif;?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                            foreach($mp_data_variabili as $x){
                                $url = add_query_arg(
                                    array('id_var'=>$x->id_variabile,
                                          'id_val'=>$x->ID,
                                          'action'=>'UPD')
                                );
                                $url_del = add_query_arg(
                                    array('id_var'=>$x->id_variabile,
                                          'id_val'=>$x->ID,
                                          'action'=>'DEL')
                                );

                                ?>
                                <tr>
                                    <td><?php echo $x->ID; ?></td>
                                    <td><?php echo $x->valore; ?></td>
                                    <?php if($mp_use_img == "1") :?>
                                        <td>
                                            <img src="<?php echo $x->immagine; ?>" style="width: 50px;"/>
                                        </td>
                                    <?php endif;?>
                                    <td>
                                        <a class="mp-btn-cta" href="<?php echo $url; ?>">Modifica</a><br/>
                                        <a class="mp-btn-cta" href="<?php echo $url_del; ?>">Elimina</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
        } else {    
            $mp_variabili = $wpdb->get_results("SELECT * FROM $table_name");
            $redirect = MP_PROOF_ADMIN_URL . "?page=mp-proof-admin-variabili";
            ?>
            <div class="wrap">
                <h2>MP Proof - Le variabili</h2>
                <div class="mp-div-form">
                    <p>
                        Inserisci nuove variabili per essere utilizzate all'interno dei proof.
                    </p>
                    <form action="" method="post" id="v_form">
                        <input type="hidden" name="MP_PROOF_action" value="add_variable"/>
                        <input type="hidden" name="MP_PROOF_redirect" value="<?php echo $redirect;?>"/>
                        <table>
                            <tbody>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="MP_PROOF_name_var">
                                            Nome Variabile
                                        </label>
                                    </th>
                                    <td>
                                        <input type="text" name="MP_PROOF_name_var" id="MP_PROOF_name_var" />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="MP_PROOF_datause_img">
                                            La variabile utilizzerà immagini?
                                        </label>
                                    </th>
                                    <td>
                                        <select name="MP_PROOF_datause_img" id="MP_PROOF_datause_img">
                                            <option value="1" selected="selected">Sì</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="MP_PROOF_visible_var">
                                            Variabile Visibile?
                                        </label>
                                    </th>
                                    <td>
                                        <select name="MP_PROOF_visible_var" id="MP_PROOF_visible_var">
                                            <option value="1" selected="selected">Sì</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th>
                                        <input type="submit" value="Salva" class="mp-proof-btn"/>
                                    </th>
                                </tr>
                            </tbody>
                        </table>            
                    </form>
                </div>
                <div class="mp-div-table">
                    <table class="mp-proof-table">
                        <thead class="mp-proof-thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Variabile</th>
                                <th>Slug</th>
                                <th>Usa Immagini</th>
                                <th>Visibile</th>
                                <th>Valori Inseriti</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                            foreach($mp_variabili as $x){
                                $url = add_query_arg(array('id_var'=>$x->ID));
                                $mp_cont = $wpdb->get_var("SELECT COUNT(ID) AS cont FROM $table_name_2 WHERE id_variabile = $x->ID");
                                ?>
                                <tr>
                                    <td><?php echo $x->ID; ?></td>
                                    <td><?php echo $x->merge_tag; ?></td>
                                    <td><?php echo $x->slug_tag; ?></td>
                                    <td><?php echo $x->use_immagine; ?></td>
                                    <td><?php echo $x->visible; ?></td>
                                    <td><?php echo $mp_cont; ?></td>
                                    <td>
                                        <a class="mp-btn-cta" href="<?php echo $url; ?>">Aggiungi</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        }
    }
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)){
    return 'n-a';
}

return $text;
}

