jQuery(document).ready(function(){
    var sayi = jQuery('.cw-box').length;
    if(sayi>1){
        jQuery('.cw-box').slideUp();
    }else{
        jQuery("a.cw-toggle").hide();
    }

    jQuery('a.cw-toggle').click(function(){		
        if(jQuery(this).parent().next('.cw-box').css('display')==='none')
                {	jQuery(this).removeClass('active');
                        jQuery(this).addClass('inactive');

                }
        else
                {	jQuery(this).removeClass('inactive');
                        jQuery(this).addClass('active');
                }

        jQuery(this).parent().next('.cw-box').slideToggle('slow');
        return false;
    });
});