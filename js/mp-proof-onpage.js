jQuery.noConflict();
jQuery(document).ready(function($){

    $(".mp-proof_fixed").hide();

    console.log($(".mp-proof_fixed").attr("mp-proof-colore-bordo"));

    var timer = $(".mp-proof_fixed").attr("mp-proof-timer");
    var colore_bordo = $(".mp-proof_fixed").attr("mp-proof-colore-bordo");
    var colore_background = $(".mp-proof_fixed").attr("mp-proof-colore-background");
    $(".mp-proof_fixed").css("border-color",colore_bordo);
    $(".mp-proof_fixed").css("background-color",colore_background);

    setTimeout(function(){
      $(".mp-proof_fixed").show(500);  
    }, timer);
});