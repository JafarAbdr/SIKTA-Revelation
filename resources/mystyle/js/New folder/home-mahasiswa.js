function homeOfMahasiswa(){
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
	reloadInfoFastRegister();
	reloadInfoSeminar();
}
function reloadInfoSeminar(){
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Classroom/getJsonInfoFastSeminar.aspx",
		bool : true,
		content : "",
		sucOk : function(a){
			var jsonData = JSON.parse(a);
			setValSemi({
				kategori : parseInt(jsonData.kategori),
				nama : jsonData.name,
				nim : jsonData.nim,
				judul : jsonData.ta,
				waktu  : jsonData.waktu,
				ruang : jsonData.ruang,
				dosen : jsonData.dosen,
				pengujis : jsonData.penguji1,
				pengujid : jsonData.penguji2,
				status : jsonData.status,
				pendukungDokumen : jsonData.pendukungDokumen
			});
		},
		sucEr : function(a,b){
			template(a,b,"sesi info fast ...");
		}
	});
}
function setValRegist(a){
	var temp = document.getElementById('info-cepat-registrasi');
	var nama = temp.childNodes[1];
	nama = nama.childNodes[3];
	nama.innerHTML = a.nama;
	var nim = temp.childNodes[3];
	nim = nim.childNodes[3];
	nim.innerHTML = a.nim;
	var judul = temp.childNodes[5];
	judul = judul.childNodes[3];
	judul.innerHTML = a.judul;
	var dosen = temp.childNodes[7];
	dosen = dosen.childNodes[3];
	dosen.innerHTML = a.dosen;
}
function setValSemi(a){
	var temp = document.getElementById('info-cepat-seminar');
	var title = temp.childNodes[1];
	title = title.childNodes[1];
	if(a.kategori == 1)
		title.innerHTML = "Seminar TA 1";
	else
		title.innerHTML = "Seminar TA 2(Sidang)";
	
	if(a.kategori != 1 && a.kategori != 2)
		title.innerHTML = "Belum daftar seminar";
	var nama = temp.childNodes[3];
	nama = nama.childNodes[3];
	nama.innerHTML = a.nama;
	var nim = temp.childNodes[5];
	nim = nim.childNodes[3];
	nim.innerHTML = a.nim;
	var judul = temp.childNodes[7];
	judul = judul.childNodes[3];
	judul.innerHTML = a.judul;
	var ruang = temp.childNodes[9];
	ruang = ruang.childNodes[3];
	ruang.innerHTML = a.ruang;
	var waktu = temp.childNodes[11];
	waktu = waktu.childNodes[3];
	waktu.innerHTML = a.waktu;
	var dosen = temp.childNodes[17];
	dosenTitle = dosen.childNodes[1];
	dosen = dosen.childNodes[3];
	var dosenP1 = temp.childNodes[13];
	var dosenP2 = temp.childNodes[15];
	if(a.kategori == 1){
		dosenTitle.innerHTML = "Dosen pembimbing";
		dosenP1.style.display = "none";
		dosenP2.style.display = "none";
	}else{		
		if(a.kategori != 1 && a.kategori != 2){
			dosenTitle.innerHTML = "Dosen pembimbing";
			dosenP1.style.display = "none";
			dosenP2.style.display = "none";
		}else{
			dosenTitle.innerHTML = "Dosen penguji 3";
			dosenP1.style.display = "block";
			dosenP1 = dosenP1.childNodes[3];
			dosenP1.innerHTML = a.pengujis;
			dosenP2.style.display = "block";
			dosenP2 = dosenP2.childNodes[3];
			dosenP2.innerHTML = a.pengujid;
		}
	}
	dosen.innerHTML = a.dosen;
	
	var status = temp.childNodes[19];
	//alert(status.innerHTML);
	status = status.childNodes[3];
	status.innerHTML = a.status;
	var dockSup = temp.childNodes[21];
	//alert(status.innerHTML);
	dockSup = dockSup.childNodes[3];
	dockSup.innerHTML = a.pendukungDokumen;
}
function printFUJ(a){
	modalStaticSingleInformation("Dokumen preview",""+
	"<div>"+
		"<iframe id='frame-dokemen-preview-fuj' style='width : 100%; height : 500px;'></iframe>"+
	"</div>"+
	"");
	setTimeout(function(){
		$("#frame-dokemen-preview-fuj").attr("src",base_url+"Classroom/printPdfAcara/"+a+".aspx");
	},2000);
	//alert(a);
}
function reloadInfoFastRegister(){
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Classroom/getJsonInfoFastRegistrasi.aspx",
		bool : true,
		content : "",
		sucOk : function(a){
			var jsonData = JSON.parse(a);
			setValRegist({
				nama : jsonData.name,
				nim : jsonData.nim,
				judul : jsonData.ta,
				dosen : jsonData.dosen
			});
		},
		sucEr : function(a,b){
			template(a,b,"sesi info fast ...");
		}
	});
}