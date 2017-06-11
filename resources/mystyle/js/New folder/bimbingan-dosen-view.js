function dosenBimbinganView(){
	
	reloadTableBimbinganDosen();
	$("#search-by-name").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaBimbingan = $(this).val();
			reloadTableBimbinganDosen();
		}
	});
}
var keyNameInfoMahasiswaBimbingan=null;
function reloadTableBimbinganDosen(){
	if(keyNameInfoMahasiswaBimbingan==null){
		$("#search-by-name").val("");
		keyNameInfoMahasiswaBimbingan = "";
	}else{
		$("#search-by-name").val(keyNameInfoMahasiswaBimbingan);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/getTableInfoPublicRegistrasi.aspx",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaBimbingan,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-bimbingan-dosen").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
function realBannishThisGuys(ass){
	openLoadingBar("melakukan penolakan data ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/bannishThisGuysFromMe.aspx",
		bool : true,
		content : "Nim="+ass,
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Data diproses ...");
			if(a[0]=='1'){
				setLoadingBarMessage("Berhasil melakukan penolakan ...");
				reloadTableBimbinganDosen();
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
			}
			setTimeout(function(){closeLoadingBar();},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi tolak mahasiswa");
		}
	});
}
function resommitThisGuysTA1(ass){
	openLoadingBar("melakukan rekomendasi seminar TA 2 ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/recomendationTA.aspx",
		bool : true,
		content : "Nim="+ass+"&TA=1",
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Data diproses ...");
			if(a[0]=='1'){
				setLoadingBarMessage("Berhasil mendaftarkan ...");
				reloadTableBimbinganDosen();
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
			}
			setTimeout(function(){closeLoadingBar();},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi tolak mahasiswa");
		}
	});
}
function resommitThisGuysTA2(ass){
	openLoadingBar("melakukan rekomendasi seminar TA 2 ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/recomendationTA.aspx",
		bool : true,
		content : "Nim="+ass+"&TA=2",
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Data diproses ...");
			if(a[0]=='1'){
				setLoadingBarMessage("Berhasil mendaftarkan ...");
				reloadTableBimbinganDosen();
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
			}
			setTimeout(function(){closeLoadingBar();},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi tolak mahasiswa");
		}
	});
}
function bannishThisGuys(a){
	modalStaticMultipleButton('Apakah anda yakin ingin mengeluarkan mahasiswa dengan nim '+a+" dari bimbingan anda?",function(){
		realBannishThisGuys(a);	
	});
}
function recomTA1ThisGuys(a){
	modalStaticMultipleButton('Apakah anda yakin ingin merekomendasikan mahasiswa dengan nim '+a+" dari bimbingan anda untuk seminar Tugas Akhir 1 ?",function(){
		resommitThisGuysTA1(a);	
	});
}
function recomTA2ThisGuys(a){
	modalStaticMultipleButton('Apakah anda yakin ingin merekomendasikan mahasiswa dengan nim '+a+" dari bimbingan anda untuk seminar Tugas Akhir 2 ?",function(){
		resommitThisGuysTA2(a);	
	});
}