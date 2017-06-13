function resetPassword(){
	$('#login-exe').attr('disabled','true');
	if($('#set-password').val() == '') {$('#login-exe').removeAttr('disabled'); return;}
	if($('#set-password-con').val() == '') {$('#login-exe').removeAttr('disabled'); return;}
	j('#setAjax').setAjax({
		url : base_url+"Resetpassword/resetNowThisGuys",
		bool : true,
		methode : 'POST',
		content : "passwordbaru="+$('#set-password').val()+"&passwordkonfirmasi="+$('#set-password-con').val()+"&kode="+kodeValidity,
		sucOk : function(a){
			$('#login-exe').removeAttr('disabled');
			//alert(a);
			if(a[0]=='0'){
				modalStaticSingleInformation('Peringatan',a.substr(1,a.length-1));
			}else{
				window.location = base_url+"Gateinout";
			}
		},
		sucEr : function(a,b){
			
		}
	});
}