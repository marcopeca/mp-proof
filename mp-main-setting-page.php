<?php 

if(isset($_POST["MP_PROOF_action"])){
    global $wpdb;
    $redirect = $_POST["MP_PROOF_redirect"];
    $action = $_POST["MP_PROOF_action"];

    if($action == "add_variable"){
        $nome = $_POST["MP_PROOF_name_var"];
        $visibile = $_POST["MP_PROOF_visible_var"];

        $table_name = $wpdb->prefix . "mp_proof_variabili";
        $insert = array("merge_tag" => $nome,
                        "slug_tag" => slugify($nome),
                        "visible" => $visibile);
        $wpdb->insert($table_name,$insert);
    }
    if($action == "edit_settings"){
        $table_name = $wpdb->prefix . "mp_proof_impostazioni";
        
        $forma = $_POST["MP_PROOF_forma"];
        $update = array("valore" => $forma);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_forma"));
        
        $colore_bordo = $_POST["MP_PROOF_colore_bordo"];
        $update = array("valore" => $colore_bordo);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_colore_bordo"));

        $colore_background = $_POST["MP_PROOF_colore_background"];
        $update = array("valore" => $colore_background);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_colore_background"));

        $timer = $_POST["MP_PROOF_timer"];
        $update = array("valore" => $timer);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_timer"));

        $posizione = $_POST["MP_PROOF_posizione"];
        $update = array("valore" => $posizione);
        $wpdb->update($table_name,$update,array("slug" => "MP_PROOF_posizione"));
    }

    header("location: $redirect");
}

function mp_proof_update_options_form(){    
    ?>    

    <div class="wrap">        
        <div class="icon32" id="icon-options-general"><br /></div>
        <h2>MP Proof</h2>    

        <!--
        <form method="post" action="options.php">
            <?php settings_fields('mp_settings'); ?>
            <table>
                <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="ylb_box_bg_color">Colore del Box:</label></th>
                        <td>

                        </td>
                    </tr>
                </tbody>
            </table>
            <?php //var_dump(get_option('mp_options')); ?>
        </form>
    -->
</div>
<?php
}

function mp_proof_update_options_impostazioni(){
    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_impostazioni";
    $mp_impostazioni = $wpdb->get_results("SELECT * FROM $table_name");    

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
                            <tr valign="top">
                                <th scope="row">
                                    <label for="<?php echo $imp->slug; ?>">
                                        <?php echo $imp->impostazioni; ?>
                                    </label>
                                </th>
                                <td>
                                    <input type="text" name="<?php echo $imp->slug; ?>" id="<?php echo $imp->slug; ?>" value="<?php echo $imp->valore; ?>"/>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr valign="top">
                            <th>
                                <input type="submit" value="Salva" />
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
    global $wpdb;
    $table_name = $wpdb->prefix . "mp_proof_variabili";
    
    // Recupero ID variabili in input
    $id_var = $_GET["id_var"];
    if($id_var !== NULL){

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
                                    <label for="MP_PROOF_visible_var">
                                        Variabile Visibile?
                                    </label>
                                </th>
                                <td>
                                    <select name="MP_PROOF_visible_var" id="MP_PROOF_visible_var">
                                        <option value="1">Sì</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th>
                                    <input type="submit" value="Salva" />
                                </th>
                            </tr>
                        </tbody>
                    </table>            
                </form>
            </div>
            <div class="mp-div-table">
                <table class="table table-bordered" border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Variabile</th>
                            <th>Slug</th>
                            <th>Visibile</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <?php
                        foreach($mp_variabili as $x){
                            $url = add_query_arg(array('id_var'=>$x->ID));

                            ?>
                            <tr>
                                <td><?php echo $x->ID; ?></td>
                                <td><?php echo $x->merge_tag; ?></td>
                                <td><?php echo $x->slug_tag; ?></td>
                                <td><?php echo $x->visible; ?></td>
                                <td><!--<a href="<?php echo $url; ?>">vai</a>--></td>
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

