jQuery(document).ready(function() {
    var $ = jQuery;    

    if ($('.set_custom_images').length > 0) {
        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $(document).on('click', '.set_custom_images', function(e) {
                e.preventDefault();
                var button = $(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) {
                    console.log(attachment);
                    $("#mp-proof_img_data_default").html("<img src='"+attachment.url+"' style='width: 150px;'/>");
                    $("#MP_PROOF_img_var").val(attachment.url);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
    }
});