function dosenPengujiView(){
	
	reloadPengujiTA1Dosen();
	$("#search-name-penguji-ta1").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaPengujiTA1 = $(this).val();
			reloadPengujiTA1Dosen();
		}
	});
	reloadPengujiTA2Dosen();
	$("#search-name-penguji-ta2").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaPengujiTA2 = $(this).val();
			reloadPengujiTA2Dosen();
		}
	});
	reloadPengujiTA2DosenPembantu2();
	$("#search-name-penguji-ta2-pembantu2").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaPengujiTA2Pembantu2 = $(this).val();
			reloadPengujiTA2DosenPembantu2();
		}
	});
	reloadPengujiTA2DosenPembantu();
	$("#search-name-penguji-ta2-pembantu").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaPengujiTA2Pembantu = $(this).val();
			reloadPengujiTA2DosenPembantu();
		}
	});
	reloadPengujiTA2DosenKetua();
	$("#search-name-penguji-ta2-ketua").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoMahasiswaPengujiTA2Ketua = $(this).val();
			reloadPengujiTA2DosenKetua();
		}
	});
	$("#penguji-TA1").on("click",function(){
		reloadPengujiTA1Dosen();
	});
	$("#penguji-TA2").on("click",function(){
		reloadPengujiTA2Dosen();
	});
	$("#penguji-TA2-pembantu2").on("click",function(){
		reloadPengujiTA2DosenPembantu2();
	});
	$("#penguji-TA2-pembantu").on("click",function(){
		reloadPengujiTA2DosenPembantu();
	});
	$("#penguji-TA2-ketua").on("click",function(){
		reloadPengujiTA2DosenKetua();
	});
	//alert("penguji");
}
var activeTab = 1;
//sesi penguji TA 1
function bannishThisGuysFromSeminar(a){
	modalStaticMultipleButton('Apakah anda yakin ingin membatalkan mahasiswa dengan nim '+a+" dari Seminar TA 1 anda?",function(){
		realBannishThisGuysFromSeminar(a,1);	
	});
}
function realBannishThisGuysFromSeminar(ass,dd){
	openLoadingBar("melakukan penolakan data ...");
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/reRegisterPengujiTA.jsp",
		bool : true,
		content : "Nim="+ass+"&TA="+dd,
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Data diproses ...");
			if(a[0]=='1'){
				setLoadingBarMessage("Berhasil melakukan penolakan ...");
				if(dd==1)
					reloadPengujiTA1Dosen();
				else
					reloadPengujiTA2Dosen();
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
var keyNameInfoMahasiswaPengujiTA1 = null;
function reloadPengujiTA1Dosen(){
	if(keyNameInfoMahasiswaPengujiTA1 == null){
		$("#search-name-penguji-ta1").val("");
		keyNameInfoMahasiswaPengujiTA1 = "";
	}else{
		$("#search-name-penguji-ta1").val(keyNameInfoMahasiswaPengujiTA1);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/getTablePengujiTA1.jsp",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaPengujiTA1,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-penguji-TA1").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
//sesi penguji TA 2

function bannishThisGuysFromSeminarTA2(a){
	modalStaticMultipleButton('Apakah anda yakin ingin membatalkan mahasiswa dengan nim '+a+" dari Seminar TA 2 anda?",function(){
		realBannishThisGuysFromSeminar(a,2);	
	});
}
var keyNameInfoMahasiswaPengujiTA2 = null;
function reloadPengujiTA2Dosen(){
	if(keyNameInfoMahasiswaPengujiTA2 == null){
		$("#search-name-penguji-ta2").val("");
		keyNameInfoMahasiswaPengujiTA2 = "";
	}else{
		$("#search-name-penguji-ta2").val(keyNameInfoMahasiswaPengujiTA2);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/getTablePengujiTA2.jsp",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaPengujiTA2,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-penguji-TA2").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
//
function realBannishMeFromHerTA(a,b){
	openLoadingBar("menolah proses uji seminar");
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/banishLeaderOrMember.jsp",
		methode : "post",
		content : "kode="+b+"&nim="+a,
		bool : true,
		sucOk : function(bb){
			//alert(a);
			setLoadingBarMessage(bb.substr(1,bb.length-1));
			if(bb[0]=='1'){
				switch(b){
					case 'pembantu' :
					reloadPengujiTA2DosenPembantu();
					break;
					case 'pembantu2' :
					reloadPengujiTA2DosenPembantu2();
					break;
					case 'ketua' :
					reloadPengujiTA2DosenKetua();
					break;
				}
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
//sesi pembantu

function bannishThisGuysFromSeminarTA2Pembantu(a){
	modalStaticMultipleButton('Apakah anda yakin ingin membatalkan menjadi penguji 1 pada seminar TA 2 mahasiswa dengan nim  '+a+" ?",function(){
		realBannishMeFromHerTA(a,"pembantu");
	});
}
function bannishThisGuysFromSeminarTA2Pembantu2(a){
	modalStaticMultipleButton('Apakah anda yakin ingin membatalkan menjadi penguji 2 pada seminar TA 2 mahasiswa dengan nim  '+a+" ?",function(){
		realBannishMeFromHerTA(a,"pembantu2");
	});
}

var keyNameInfoMahasiswaPengujiTA2Pembantu = null;
var keyNameInfoMahasiswaPengujiTA2Pembantu2 = null;
function reloadPengujiTA2DosenPembantu(){
	if(keyNameInfoMahasiswaPengujiTA2Pembantu == null){
		$("#search-name-penguji-ta2-pembantu").val("");
		keyNameInfoMahasiswaPengujiTA2Pembantu = "";
	}else{
		$("#search-name-penguji-ta2-pembantu").val(keyNameInfoMahasiswaPengujiTA2Pembantu);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/getDataNipsOrNipd.jsp",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaPengujiTA2Pembantu+"&kode=pembantu",
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-penguji-TA2-pembantu").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
function reloadPengujiTA2DosenPembantu2(){
	if(keyNameInfoMahasiswaPengujiTA2Pembantu == null){
		$("#search-name-penguji-ta2-pembantu2").val("");
		keyNameInfoMahasiswaPengujiTA2Pembantu2 = "";
	}else{
		$("#search-name-penguji-ta2-pembantu2").val(keyNameInfoMahasiswaPengujiTA2Pembantu2);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/getDataNipsOrNipd.jsp",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaPengujiTA2Pembantu2+"&kode=pembantu2",
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-penguji-TA2-pembantu2").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}
//sesi ketua

function bannishThisGuysFromSeminarTA2Ketua(a){
	modalStaticMultipleButton('Apakah anda yakin ingin membatalkan menjadi ketua penguji pada seminar TA 2 mahasiswa dengan nim '+a+" ?",function(){
		realBannishMeFromHerTA(a,"ketua");
	});
}
var keyNameInfoMahasiswaPengujiTA2Ketua = null;
function reloadPengujiTA2DosenKetua(){
	if(keyNameInfoMahasiswaPengujiTA2Ketua == null){
		$("#search-name-penguji-ta2-ketua").val("");
		keyNameInfoMahasiswaPengujiTA2Ketua = "";
	}else{
		$("#search-name-penguji-ta1-ketua").val(keyNameInfoMahasiswaPengujiTA2Ketua);
	}
	j("#setAjax").setAjax({
		url : base_url+"Kingpenguji/getDataNipsOrNipd.jsp",
		methode : "post",
		content : "keyword="+keyNameInfoMahasiswaPengujiTA2Ketua+"&kode=ketua",
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-penguji-TA2-ketua").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel beranda");
		}
	});
}