var variables = {};
var $ = jQuery;

jQuery(document).ready(function() {    
    if ($('.js_proof_var_click').length > 0) {
        $(".js_proof_var_click").each(function(){
            $(this).click(function(e){
                e.preventDefault();
                e.stopPropagation();
                
                if($(this).hasClass("active")){                    
                    $(this).removeClass("active");
                    delete variables[$(this).attr("btn-data")];                    
                    remove_occurence($(this).attr("btn-data"));
                } else {
                    $(this).addClass("active");
                    variables[$(this).attr("btn-data")] = 1;
                    add_occurrences($(this).attr("btn-data"));
                }
                
                $("#MP_PROOF_hidden_val_used").val(JSON.stringify(variables));

                traslate_proof();
            });
        });
    }

    $("#MP_PROOF_text_proof").focusout(traslate_proof);
});


function add_occurrences(occ){
    var val = $("#MP_PROOF_text_proof").val();
    $("#MP_PROOF_text_proof").val(val + "%%" + occ + "%%");
}

function remove_occurence(occ){
    var val = $("#MP_PROOF_text_proof").val();

    val = val.split("%%"+occ+"%%").join('');
    $("#MP_PROOF_text_proof").val(val);
}

function traslate_proof(){    
    var val_ex = JSON.parse($("#MP_PROOF_hidden_val").val());
    var val = $("#MP_PROOF_text_proof").val();
    for(var i = 0; i < val_ex.length; i++){
        //console.log(val_ex[i]);
        var key = Object.keys(val_ex[i])[0];        
        val = val.split('%%'+key+'%%').join(val_ex[i][key]);
    }    
    $("#preview_proof").html(val);
}