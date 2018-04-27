var mp_counter = 0;

jQuery.noConflict();
var $ = jQuery;
jQuery(document).ready(function($){

    $(".js_close_proof").each(function(){
        $(this).click(function(){
            hide_proof();
        });
    });    
    
    var colore_bordo = $(".mp-proof_fixed").attr("mp-proof-colore-bordo");
    var colore_background = $(".mp-proof_fixed").attr("mp-proof-colore-background");
    $(".mp-proof_fixed").css("border-color",colore_bordo);
    $(".mp-proof_fixed").css("background-color",colore_background);    

    show_proof();
});

function show_proof(){
    var $ = jQuery;
    var timer = $(".mp-proof_fixed").attr("mp-proof-timer");
    var timer_permanenza = $(".mp-proof_fixed").attr("mp-proof-timer-permanenza");

    setTimeout(function(){        
        $(".mp-proof_fixed[mp-proof-counter='"+mp_counter+"']").show(500, function(){
            setTimeout(function(){
                hide_proof();
            }, timer_permanenza);
        });  
    }, timer);
}

function hide_proof(){
    var $ = jQuery;
    $(".mp-proof_fixed[mp-proof-counter='"+mp_counter+"']").hide(500);
    mp_counter++;
    show_proof();
}