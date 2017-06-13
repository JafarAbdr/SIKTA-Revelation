function dosenBimbinganView(){
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
	startNotifikasiActive = 1;
	startUpBimbinganPage = true;
	reloadTableBimbinganDosen();
	$("#search-by-name").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaBimbingan = $(this).val();
			reloadTableBimbinganDosen();
		}
	});
	$('#refresh-yes-cup').on('click',function(){
		if(startNotifikasiActive == 1){
			reloadListNotificationCup();
		}else{
			reloadListProsesCup();
		}
	});
	$('#notifikasi-cup-refresh').on('click',function(){
		if(startNotifikasiActive != 1){
			startNotifikasiActive = 1;
			reloadListNotificationCup();
		}
	});
	$('#proses-cup-refresh').on('click',function(){
		if(startNotifikasiActive != 2){
			startNotifikasiActive = 2;
			reloadListProsesCup();
		}
	});
	$("#search-notifikasi-cup").keyup(function(event){
		if(event.keyCode == 13){
			//alert('not');
			keyNameNotifikasiCup = $(this).val();
			reloadListNotificationCup();
		}
	});
	
	reloadTableBimbinganDosen();
	$("#search-proses-cup").keyup(function(event){
		if(event.keyCode == 13){
			keyNameProsesCup = $(this).val();
			reloadListProsesCup();
		}
	});
}
function cupThisGuys(d){
	openLoadingBar('Cup mahasiswa ini');
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/setThisMyCup",
		methode : "post",
		content : "nim="+d,
		bool : true,
		sucOk : function(a){
			//alert(a);
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(a[0]=="1"){
				reloadListNotificationCup();
				reloadListProsesCup();
			}
			setTimeout(function(){
				closeLoadingBar();
			},1000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
function unCupThisGuys(d){
	openLoadingBar('UnCup mahasiswa ini');
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/setThisUnMyCup",
		methode : "post",
		content : "nim="+d,
		bool : true,
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(a[0]=="1"){
				reloadListNotificationCup();
				reloadListProsesCup();
			}
			setTimeout(function(){
				closeLoadingBar();
			},1000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
var startUpBimbinganPage = false;
var startNotifikasiActive = 1;
function reloadListNotificationCup(){
	//if(!startUpBimbinganPage) return;
	if(keyNameNotifikasiCup==null){
		$("#search-notifikasi-cup").val("");
		keyNameNotifikasiCup = "";
	}else{
		$("#search-notifikasi-cup").val(keyNameNotifikasiCup);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/getListNotifikasiCup",
		methode : "post",
		content : "keyword="+keyNameNotifikasiCup,
		bool : true,
		sucOk : function(a){
			if(a[0]=="1")
				$("#tabel-notifikasi-cup").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
function reloadListProsesCup(){
	if(keyNameProsesCup==null){
		$("#search-proses-cup").val("");
		keyNameProsesCup = "";
	}else{
		$("#search-proses-cup").val(keyNameProsesCup);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/getListProsesCup",
		methode : "post",
		content : "keyword="+keyNameProsesCup,
		bool : true,
		sucOk : function(a){
			if(a[0]=="1")
				$("#tabel-proses-cup").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
var keyNameInfoMahasiswaBimbingan=null;
var keyNameNotifikasiCup=null;
var keyNameProsesCup=null;
function reloadTableBimbinganDosen(){
	if(keyNameInfoMahasiswaBimbingan==null){
		$("#search-by-name").val("");
		keyNameInfoMahasiswaBimbingan = "";
	}else{
		$("#search-by-name").val(keyNameInfoMahasiswaBimbingan);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/getTableInfoPublicRegistrasi",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaBimbingan,
		bool : true,
		sucOk : function(a){
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
		url : base_url+"Kingbimbingan/bannishThisGuysFromMe",
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
			setTimeout(function(){closeLoadingBar();},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi tolak mahasiswa");
		}
	});
}
function resommitThisGuysTA1(ass){
	openLoadingBar("melakukan rekomendasi seminar TA 2 ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/recomendationTA",
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
			setTimeout(function(){closeLoadingBar();},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi tolak mahasiswa");
		}
	});
}
function resommitThisGuysTA2(ass){
	openLoadingBar("melakukan rekomendasi seminar TA 2 ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/recomendationTA",
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
			setTimeout(function(){closeLoadingBar();},750);
		},
		sucEr : function(a,b){
			template(a,b,"sesi tolak mahasiswa");
		}
	});
}
function seeThisGuysFullOfIt(ass,data){
	openLoadingBar("mengambil data ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingbimbingan/getInfoMahasiswaFull",
		bool : true,
		content : "message="+data+"&nim="+ass+"&kode=JASERVTECH-KODE",
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Data diproses ...");
			if(a[0]=='1'){
				modalStaticSingleInformation("Tentang Mahasiswa",a.substr(1,a.length-1));
				setLoadingBarMessage("Berhasil memperoleh info ...");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
			}
			setTimeout(function(){closeLoadingBar();},750);
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