function baseRegistrasi(){
	reloadTableInfoPublicRegistrasi(1);
	$("#search-name-info-public").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoRegistrasipublic = $(this).val();
			tempRegistrasiNextPreControl.setPage(1);
			reloadTableInfoPublicRegistrasi(1);
		}
	});
	tempRegistrasiNextPreControl = new NextPreControlClass({
		id : "table-registrasi-next-prev",
		func : function(a){
			reloadTableInfoPublicRegistrasi(a);
		}
	});
}
var tempRegistrasiNextPreControl = null;
var keyNameInfoRegistrasipublic=null;
function reloadTableInfoPublicRegistrasi(page){
	if(keyNameInfoRegistrasipublic==null){
		$("#search-name-info-public").val("");
		keyNameInfoRegistrasipublic = "";
	}else{
		$("#search-name-info-public").val(keyNameInfoRegistrasipublic);
	}
	j("#setAjax").setAjax({
		url : base_url+"Baseregistrasi/getTableInfoPublicRegistrasi",
		methode : "post",
		content : "keyword="+keyNameInfoRegistrasipublic+"&page="+page,
		bool : true,
		sucOk : function(a){
			var tempJson = JSON.parse(a.substr(1,a.length-1));
			if(a[0]=="1"){
				$("#tabel-imfo-public-registrasi").html(tempJson.string);
				var tempLeft = true;
				var tempRight = true;
				if(parseInt(tempJson.left) == 1)
					tempLeft = true;
				else
					tempLeft = false;
				if(parseInt(tempJson.right) == 1)
					tempRight = true;
				else
					tempRight = false;
				tempRegistrasiNextPreControl.initialize({
					left : tempLeft,
					right : tempRight
				});
			}
				$("#").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel registrasi");
		}
	});
}