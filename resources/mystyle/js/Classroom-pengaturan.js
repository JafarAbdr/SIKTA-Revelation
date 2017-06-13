$(document).ready(function(){
	$("#ubah-password").on('click',function(){
		openLoadingBar("Check password ...");
		if($("#support-old-password").val() == ""){
			failedTask("password lama tidak boleh kosong ...");
			return;
		}
		if($("#support-new-password").val() == ""){
			failedTask("password baru tidak boleh kosong ...");
			return;
		}
		if($("#support-con-password").val() == ""){
			failedTask("password konfirmasi tidak boleh kosong ...");
			return;
		}
		if($("#support-con-password").val() != $("#support-new-password").val()){
			failedTask("password konfirmasi harus sama dengan password baru ...");
			return;
		}
		j("#setAjax").setAjax({
			methode : "POST",
			url : "Classpengaturan/setNewPassword",
			bool : true,
			content : "password-old="+$("#support-old-password").val()+"&"+
			"password-new="+$("#support-new-password").val()+"&"+
			"password-new-confirm="+$("#support-con-password").val(),
			sucOk : function(a){
				if(a[0] == '0'){
					failedTask(a.substr(1,a.length));
				}else{
					resetPasswordCoulumn();
					failedTask("data berhasil diperbaharui");
				}
			},
			sucEr : function(a,b){
				template(a,b,"password side");
			}
		});
	});
	$("#ubah-profile").on('click',function(){
		openLoadingBar("Check password ...");
		if($("#support-email").val() == ""){
			failedTask("email tidak boleh kosong ...");
			return;
		}
		if($("#support-no-hp").val() == ""){
			failedTask("No hp tidak boleh kosong ...");
			return;
		}
		if($("#support-nama-ortu").val() == ""){
			failedTask("nama oranng tua wajib diisi ...");
			return;
		}
		if($("#support-no-hp-ortu").val()== ""){
			failedTask("No hp orang tua wajib diisi ...");
			return;
		}
		if($("#support-peminatan").val()== "0"){
			failedTask("Peminatan tidak boleh kosong ...");
			return;
		}
		j("#setAjax").setAjax({
			methode : "POST",
			url : "Classpengaturan/dataSupport",
			bool : true,
			content : "support-email="+$("#support-email").val()+"&"+
			"support-no-hp="+$("#support-no-hp").val()+"&"+
			"support-no-hp-ortu="+$("#support-no-hp-ortu").val()+"&"+
			"support-nama-ortu="+$("#support-nama-ortu").val()+"&"+
			"support-peminatan="+$("#support-peminatan").val(),
			sucOk : function(a){
				if(a[0] == '0'){
					failedTask(a.substr(1,a.length));
				}else{
					//resetPasswordCoulumn();
					failedTask("data berhasil diperbaharui");
				}
			},
			sucEr : function(a,b){
				template(a,b,"password side");
			}
		});
	});
	$("#picture-exe").on('click',function(){
		$("").trigger("click");
	})
});
function failedTask(a){
	setLoadingBarMessage(a);
	setTimeout(function(){
		closeLoadingBar();
	},750);
}
function pengaturanMahasiswaDefault(){
	resetValueSupport();
}
function resetPasswordCoulumn(){
	$("#support-old-password").val("");
	$("#support-new-password").val("");
	$("#support-con-password").val("");
}
function resetProfileCoulumn(){
	$("#support-email").val("");
	$("#support-no-hp").val("");
	$("#support-nama-ortu").val("");
	$("#support-no-hp-ortu").val("");
	$("#support-peminatan").val("0");
}
function resetPictureCoulumn(){
	$("#support-nim").val("");
	$("#support-nama").val("");
	$("#support-gambar").val(null);
}
function resetValueSupport(){
	resetPasswordCoulumn();
	resetPictureCoulumn();
	resetProfileCoulumn();
	j("#setAjax").setAjax({
		methode : "POST",
		bool : true,
		content : "",
		url : "Classpengaturan/getJsonProfile",
		sucOk : function(a){
			var data = JSON.parse(a);
			if(data.state){
				$("#support-nim").val(data.nim);
				$("#support-nama").val(data.nama);
				$("#support-email").val(data.email);
				$("#support-no-hp").val(data.nohp);
				$("#support-nama-ortu").val(data.ortu);
				$("#support-no-hp-ortu").val(data.nohportu);
				$("#support-peminatan").val(data.dataMinat);
			}else{
				$("#support-nim").val("");
				$("#support-nama").val("");
				$("#support-email").val("");
				$("#support-no-hp").val("");
				$("#support-nama-ortu").val("");
				$("#support-no-hp-ortu").val("");
				$("#support-peminatan").val("0");
			}
		},
		sucEr : function(a,b){
			template(a,b,"default value");
		} 
	});
}
function lihatTranskrip(){
	modalStaticSingleInformation("PDF viewer",
	"<iframe src='"+base_url+"Filesupport/getTranskrip' style='width : 100%;  height : 500px;'></iframe>"
	);
}
function updateTranskrip(){
	$("#support-transkrip").trigger('click');
}
function ubahGambarFoto(){
	$("#support-gambar").trigger('click');
}
function uploadTranskrip(){
	openLoadingBar("upload transkrip");
	var kk = document.getElementById('support-transkrip');
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
		},4000);
	}else{
		var TEMP_VIDEO_SIZE = kk.files[0].size/(1024*1024);
		//size maksimum 500 mb
		if(TEMP_VIDEO_SIZE > 1){
			setLoadingBarMessage("Ukuran maksimal 1 MB");
			setTimeout(function(){
				closeLoadingBar();
			},4000);
		}else{
			// if true do submit on background
			console.log(kk.files);
			
			var tempTransSes = $('#transkrip-session').submit(function(){
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
			$('#transkrip-session').trigger('submit');
		}
	}
}
function uploadGambar(){
	openLoadingBar("upload gambar");
	var kk = document.getElementById('support-gambar');
	var TEMP_VIDEO = kk.files[0].name.substr(kk.files[0].name.length-4,4);
	var err = 0;
	//mp4 format
	if(TEMP_VIDEO != ".jpg" ) {
		err+=1;
	}
	if(TEMP_VIDEO != ".JPG" ) {
		err+=1;
	}
	if(TEMP_VIDEO != ".png" ) {
		err+=1;
	}
	if(TEMP_VIDEO != ".PNG" ) {
		err+=1;
	}
	
	if(err == 4){
		setLoadingBarMessage("format yang didukung jpg/png");
		setTimeout(function(){
		   uploadVideo = false;
		   closeLoadingBar();
		},4000);
	}else{
		var TEMP_VIDEO_SIZE = kk.files[0].size/(1024*1024);
		//size maksimum 500 mb
		if(TEMP_VIDEO_SIZE > 0.5){
			setLoadingBarMessage("Ukuran maksimal 500 KB");
			setTimeout(function(){
				closeLoadingBar();
			},4000);
		}else{
			// if true do submit on background
			console.log(kk.files);
			
			var tempTransSes = $('#picture-session').submit(function(){
				iframest = $('#frame-upload-pengaturan').load(function(){
					response = iframest.contents().find('body');
					returnResponse = response.html();
					iframest.unbind('load');
					setLoadingBarMessage(returnResponse.substr(1,returnResponse.length-1)+" ...");
					if(returnResponse[0] == '1'){
						setTimeout(function(){							
							 var x = document.getElementById("gambar-utama").src+"";
							document.getElementById("gambar-utama").src = x;
							x = document.getElementById("gambar-upload").src + "";
							document.getElementById("gambar-upload").src = x;
						},1500);
					}
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
			$('#picture-session').trigger('submit');
		}
	}
}