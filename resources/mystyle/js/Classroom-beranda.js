function homeOfMahasiswa(){
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
	reloadInfoFastRegisterReference();
}

function lihatKRS(){
	modalStaticSingleInformation("PDF viewer",
	"<iframe src='"+base_url+"Filesupport/getKRS' style='width : 100%;  height : 500px;'></iframe>"
	);
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
	var status = temp.childNodes[9];
	status = status.childNodes[3];
	status.innerHTML = a.statusta;
}
function printFUJ(a){
	modalStaticSingleInformation("Dokumen preview",""+
	"<div>"+
		"<iframe id='frame-dokemen-preview-fuj' style='width : 100%; height : 500px;'></iframe>"+
	"</div>"+
	"");
	setTimeout(function(){
		$("#frame-dokemen-preview-fuj").attr("src",base_url+"Classroom/printPdfAcara/"+a+"");
	},750);
}
function reloadInfoFastRegisterReference(){
	
	$('#save-as-a').attr('disabled','true');
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Classroom/getJsonInfoFastRegistrasi",
		bool : true,
		content : "",
		sucOk : function(a){
			var jsonData = JSON.parse(a);
			$('#preview-nama').val(jsonData.name);
			$('#preview-dosbing').val(jsonData.dosen);
			$('#preview-status').val(jsonData.statusta);
			$('#preview-kategori').val("");
			if(jsonData.tombolsavetoasnew[1]== '1'){
				$('#save-as-a').html('simpan sebagai form baru');
			}else{
				$('#save-as-a').html('simpan sebagai form lama');
			}
			if(jsonData.tombolsavetoasnew[0]== '1'){
				$('#save-as-a').removeAttr('disabled');
			}else{
				$('#save-as-a').html('save as');
				$('#save-as-a').attr('disabled','true');
			}
			if(jsonData.kodeubah[0] == '0'){
				$('#preview-judulta').attr("disabled","true");
				$('#preview-metode').attr("disabled","true");
				$('#preview-lokasi').attr("disabled","true");
				$('#referensis').attr("disabled","true");
				$('#referensid').attr("disabled","true");
				$('#referensit').attr("disabled","true");
			}else{
				$('#preview-judulta').removeAttr("disabled");
				$('#preview-metode').removeAttr("disabled");
				$('#preview-lokasi').removeAttr("disabled");
				$('#referensis').removeAttr("disabled");
				$('#referensid').removeAttr("disabled");
				$('#referensit').removeAttr("disabled");
			}
			if(jsonData.kodeubah[1]=='0'){
				$('#preview-judulta').val("");
				$('#preview-metode').val("");
				$('#preview-lokasi').val("");
				$('#referensis').val("");
				$('#referensid').val("");
				$('#referensit').val("");
				$('#preview-kategori').val("");
			}else{
				$('#preview-judulta').val(jsonData.ta);
				$('#preview-metode').val(jsonData.metode);
				$('#preview-lokasi').val(jsonData.lokasi);
				if(jsonData.referensis == " ")
					$('#referensis').val("");
				else
					$('#referensis').val(jsonData.referensis);
				if(jsonData.referensid == " ")
					$('#referensid').val("");
				else
					$('#referensid').val(jsonData.referensid);
				if(jsonData.referensit == " ")
					$('#referensit').val("");
				else
					$('#referensit').val(jsonData.referensit);
				$('#preview-kategori').val(jsonData.kategori);
			}
		},
		sucEr : function(a,b){
			template(a,b,"sesi info fast referrer ...");
		}
	});
}
function ubahDataOnetoSix(kode,isi){
	openLoadingBar("Mengirim data request ...");
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Classroom/setReferences",
		bool : true,
		content : "kode="+kode+"&referensi="+isi,
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(a[0] == "0"){
				reloadInfoFastRegisterReference();
			}
			setTimeout(function(){
				closeLoadingBar();
			},1500)
		},
		sucEr : function(a,b){
			template(a,b,"sesi ubah info fast ...");
		}
	});
}
function gantiKRS(){
	$('#support-krs').trigger('click');
}
function uploadKRS(kode,referensi){
	openLoadingBar("upload transkrip");
	var kk = document.getElementById('support-krs');
	var TEMP_VIDEO = kk.files[0].name.substr(kk.files[0].name.length-4,4);
	var err = 0;
	//mp4 format
	if(TEMP_VIDEO != ".pdf" ) {
		err+=1;
	}
	if(TEMP_VIDEO != ".PDF" ) {
		err+=1;
	}
	if(err == 2){
		setLoadingBarMessage("format yang didukung pdf");
		setTimeout(function(){
		   uploadVideo = false;
		   closeLoadingBar();
		},750);
	}else{
		var TEMP_VIDEO_SIZE = kk.files[0].size/(1024*1024);
		//size maksimum 500 mb
		if(TEMP_VIDEO_SIZE > 1){
			setLoadingBarMessage("Ukuran maksimal 1 MB");
			setTimeout(function(){
				closeLoadingBar();
			},750);
		}else{
			// if true do submit on background
			console.log(kk.files);
			
			var tempTransSes = $('#KRS-session').submit(function(){
				iframest = $('#frame-upload-pengaturan').load(function(){
					response = iframest.contents().find('body');
					returnResponse = response.html();
					iframest.unbind('load');
					setLoadingBarMessage(returnResponse.substr(1,returnResponse.length-1)+" ...");
					setTimeout(function()
					{
						response.html('');
						setTimeout(function(){
							closeLoadingBar();
						},750);
					}, 1);
				});
				tempTransSes.unbind('submit');
			});
			$('#KRS-session').trigger('submit');
		}
	}
}