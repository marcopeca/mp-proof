<?php if(count($all_proof)): ?>
    <a href="<?php echo $add_proof_url; ?>" class="mp-proof-btn mp-proof-btn-success mp-proof-btn-sm">Aggiungi Proof</a>
    <hr/>    
    <h3>Lista Proof</h3>
    <div class="mp-proof-100">
        <table class="mp-proof-table">
            <thead class="mp-proof-thead-dark">
                <tr>
                    <th>Proof</th>
                    <th>Visibile</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($all_proof as $mp) : 

                $url_del = add_query_arg(
                    array('id_proof'=>$mp->ID,
                          'action'=>'DEL')
                );

                $visible = "Sì";
                if($mp->visible == "0"){
                    $visible = "No";
                }
                ?>
                <tr>
                    <td><?php echo $mp->proof_text; ?></td>
                    <td><?php echo $visible; ?></td>
                    <td><a href="<?php echo $url_del; ?>" class="mp-proof-btn mp-proof-btn-success mp-proof-btn-sm">Elimina</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>        
    </table>
</div>
<?php else : ?>
    <a href="<?php echo $add_proof_url; ?>" class="mp-proof-btn mp-proof-btn-success">Aggiungi Proof</a>
    <hr/>
    <h3>Al momento non ci sono Proof</h3>    
<?php endif; ?>