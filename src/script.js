function rclCloseNotice(e){
    var idCook = jQuery(e).data('gtr_notice_id');
    var timeCook = jQuery(e).data('gtr_notice_time');
    var block = jQuery(e).parents('.gtr_notify');

    jQuery(block).animateCss('flipOutX',function(){
        jQuery(block).remove();
    });

    jQuery.cookie(idCook, '1', {expires:timeCook, path:'/'});

    return false;
}
