jQuery.noConflict();
jQuery(document).ready(function($){
    $("input[name='MP_PROOF_datause_img']").change(function(){
        var datause = $("input[name='MP_PROOF_datause_img']:checked").val()
        if(datause == 1){
            $("#js_tr_img").show();
        } else {
            $("#js_tr_img").hide();
            $("#MP_PROOF_img_var").val("");
            $("#mp-proof_img_data_default").empty();
        }
    });
});