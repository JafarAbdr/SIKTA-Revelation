function baseRegistrasi(){
	reloadTableInfoPublicRegistrasi();
	$("#search-name-info-public").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoRegistrasipublic = $(this).val();
			reloadTableInfoPublicRegistrasi();
		}
	});
}
var keyNameInfoRegistrasipublic=null;
function reloadTableInfoPublicRegistrasi(){
	if(keyNameInfoRegistrasipublic==null){
		$("#search-name-info-public").val("");
		keyNameInfoRegistrasipublic = "";
	}else{
		$("#search-name-info-public").val(keyNameInfoRegistrasipublic);
	}
	j("#setAjax").setAjax({
		url : base_url+"Baseregistrasi/getTableInfoPublicRegistrasi.aspx",
		methode : "post",
		content : "keyword="+keyNameInfoRegistrasipublic,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-imfo-public-registrasi").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel registrasi");
		}
	});
}