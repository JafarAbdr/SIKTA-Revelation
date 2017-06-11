function baseBeranda(){
	reloadTableInfoPublicBeranda();
	$("#search-judul-beranda").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoEventBeranda = $(this).val();
			reloadTableInfoPublicBeranda();
		}
	});
}

var keyNameInfoEventBeranda=null;
function reloadTableInfoPublicBeranda(){
	if(keyNameInfoEventBeranda==null){
		$("#search-judul-beranda").val("");
		keyNameInfoEventBeranda = "";
	}else{
		$("#search-judul-beranda").val(keyNameInfoEventBeranda);
	}
	j("#setAjax").setAjax({
		url : base_url+"Baseberanda/getTableAcara.aspx",
		methode : "post",
		content : "keyword="+keyNameInfoEventBeranda,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-list-beranda-acara").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}