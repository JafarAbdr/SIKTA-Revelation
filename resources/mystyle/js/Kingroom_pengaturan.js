function defaultPengaturan(){
	resetValueSupport();
}
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
			url : base_url+"Kingpengaturan/setNewPassword.jsp",
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
		openLoadingBar("Check data support ...");
		if($("#support-email").val() == ""){
			failedTask("email tidak boleh kosong ...");
			return;
		}
		if($("#support-nohp").val() == ""){
			failedTask("No hp tidak boleh kosong ...");
			return;
		}
		if($("#support-alamat").val() == ""){
			failedTask("Alamat wajib diisi ...");
			return;
		}
		if($("#support-bidang").val()== ""){
			failedTask("bidang wajib diisi ...");
			return;
		}
		if($("#support-gender").val()== "0"){
			failedTask("gender wajib diisi ...");
			return;
		}
		j("#setAjax").setAjax({
			methode : "POST",
			url : "Kingpengaturan/dataSupport.jsp",
			bool : true,
			content : "support-email="+$("#support-email").val()+"&"+
			"support-nohp="+$("#support-nohp").val()+"&"+
			"support-alamat="+$("#support-alamat").val()+"&"+
			"support-gender="+$("#support-gender").val()+"&"+
			"support-bidang="+$("#support-bidang").val(),
			sucOk : function(a){
				if(a[0] == '0'){
					failedTask(a.substr(1,a.length));
				}else{
					//resetPasswordCoulumn();
					failedTask("data berhasil diperbaharui");
				}
			},
			sucEr : function(a,b){
				template(a,b,"support side");
			}
		});
	});
	$("#ubah-gambar").on('click',function(){
		
	});
	$("#picture-exe").on('click',function(){
		$("").trigger("click");
	});
});
function failedTask(a){
	setLoadingBarMessage(a);
	setTimeout(function(){
		closeLoadingBar();
	},1000);
}
//ok
function resetPasswordCoulumn(){
	$("#support-old-password").val("");
	$("#support-new-password").val("");
	$("#support-con-password").val("");
}
//ok
function resetProfileCoulumn(){
	$("#support-email").val("");
	$("#support-nohp").val("");
	$("#support-bidang").val("");
	$("#support-alamat").val("");
}
//ok
function resetPictureCoulumn(){
	$("#support-nim").val("");
	$("#support-nama").val("");
	$("#support-gambar").val(null);
}
//ok
function resetValueSupport(){
	resetPasswordCoulumn();
	resetPictureCoulumn();
	resetProfileCoulumn();
	j("#setAjax").setAjax({
		methode : "POST",
		bool : true,
		content : "",
		url : "Kingpengaturan/getJsonProfile.jsp",
		sucOk : function(a){
			
			var data = JSON.parse(a);
			if(data.state){
				$("#support-nip").val(data.nip);
				$("#support-nama-dos").val(data.nama);
				$("#support-email").val(data.email);
				$("#support-nohp").val(data.nohp);
				$("#support-alamat").val(data.alamat);
				$("#support-bidang").val(data.bidang);
				$("#support-gender").val(data.kelamin);
			}else{
				$("#support-nip").val("");
				$("#support-nama-dos").val("");
				$("#support-email").val("");
				$("#support-nohp").val("");
				$("#support-alamat").val("");
				$("#support-bidang").val("");
				$("#support-gender").val("0");
			}
		},
		sucEr : function(a,b){
			template(a,b,"default value");
		} 
	});
}