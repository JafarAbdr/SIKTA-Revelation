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
			url : "Classpengaturan/setNewPassword.aspx",
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
		j("#setAjax").setAjax({
			methode : "POST",
			url : "Classpengaturan/dataSupport.aspx",
			bool : true,
			content : "support-email="+$("#support-email").val()+"&"+
			"support-no-hp="+$("#support-no-hp").val()+"&"+
			"support-no-hp-ortu="+$("#support-no-hp-ortu").val()+"&"+
			"support-nama-ortu="+$("#support-nama-ortu").val(),
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
	$("#ubah-gambar").on('click',function(){
		
	});
	$("#picture-exe").on('click',function(){
		$("").trigger("click");
	})
});
function failedTask(a){
	setLoadingBarMessage(a);
	setTimeout(function(){
		closeLoadingBar();
	},2000);
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
		url : "Classpengaturan/getJsonProfile.aspx",
		sucOk : function(a){
			var data = JSON.parse(a);
			if(data.state){
				$("#support-nim").val(data.nim);
				$("#support-nama").val(data.nama);
				$("#support-email").val(data.email);
				$("#support-no-hp").val(data.nohp);
				$("#support-nama-ortu").val(data.ortu);
				$("#support-no-hp-ortu").val(data.nohportu);
			}else{
				$("#support-nim").val("");
				$("#support-nama").val("");
				$("#support-email").val("");
				$("#support-no-hp").val("");
				$("#support-nama-ortu").val("");
				$("#support-no-hp-ortu").val("");
			}
		},
		sucEr : function(a,b){
			template(a,b,"default value");
		} 
	});
}