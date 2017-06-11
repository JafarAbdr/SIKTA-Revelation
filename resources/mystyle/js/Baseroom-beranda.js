function baseBeranda(){
	reloadTableInfoPublicBeranda();
	$("#search-judul-beranda").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoEventBeranda = $(this).val();
			reloadTableInfoPublicBeranda();
		}
	});
	refreshFileList();
}

var keyNameInfoEventBeranda=null;
var pageDefaultBerandaBase = 1;
function reloadTableInfoPublicBeranda(){
	j("#setAjax").setAjax({
		url : base_url+"Baseberanda/getTableAcara.jsp",
		methode : "post",
		content : "key="+pageDefaultBerandaBase,
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
function nextPageBerandaBase(){
	pageDefaultBerandaBase += 1;
	reloadTableInfoPublicBeranda();
}
function previousPageBerandaBase(){
	pageDefaultBerandaBase -= 1;
	reloadTableInfoPublicBeranda();
}
function refreshFileList(){
	openLoadingBar('refresh list file ...');
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Baseberanda/getListRecord.jsp",
		bool : true,
		content : "kode=JASERVCONTROL",
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage("proses pesan server ...");
				j("#tabel-file-default").setInHtml(a.substr(1,a.length-1));
			}else{
				setLoadingBarMessage("pesan server gagal proses ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"<i>Refreshing</i> tabel acara");
		}
	});
}