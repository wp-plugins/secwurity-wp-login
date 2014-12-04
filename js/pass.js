jQuery(document).ready(function(){
    jQuery('.cw-login-security .char').keyup(function(){
		if (this.value.length == this.maxLength){
			var sayi = $(this).index('.char');
			sayi++;
			$('.char').eq(sayi).focus();
		}
	})
});