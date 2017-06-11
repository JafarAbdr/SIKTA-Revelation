function pengaturanKoordinator(){
	reloadSelectOption();
}
function ubahPasswordKoor(){
	openLoadingBar("mencoba merubah password");
	j("#setAjax").setAjax({
		url : "Controlpengaturan/changePasswordKoor.aspx",
		bool : true,
		content : "oldpass="+$("#support-old-password").val()+"&newpass="+$("#support-new-password").val()+"&conpass="+$("#support-con-password").val(),
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(parseInt(a[0]) ==  3){
				$(location).attr('href',a.substr(1,a.length-1));
			}else if(a[0] == '1'){
				$("#support-old-password").val("");
				$("#support-new-password").val("");
				$("#support-con-password").val("");
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sessi merubah password");
		}
	});
}

function reloadSelectOption(){
	openLoadingBar("mencoba merubah password");
	j("#setAjax").setAjax({
		url : "Controlpengaturan/getSelectListDosen.aspx",
		bool : true,
		content : "oldpass="+$("#support-old-password").val()+"&newpass="+$("#support-new-password").val()+"&conpass="+$("#support-con-password").val(),
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Memproses balasan ...");
			if(parseInt(a[0]) ==  3){
				$(location).attr('href', a.substr(1,a.length-1));
			}else if(a[0] == '1'){
				$("#support-selec-you").html("");
				$("#support-selec-you").html(a.substr(1,a.length-1));
				if($("#support-who-you-are").length>0)$("#support-who-you-are").select2();
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sessi merubah password");
		}
	});
}
function reloadDataKoordinator(aa){
	openLoadingBar("mencoba merubah data koordinator");
	j("#setAjax").setAjax({
		url : "Controlpengaturan/changeNipKoor.aspx",
		bool : true,
		content : "nip="+$(aa).val(),
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(parseInt(a[0]) ==  3){
				$(location).attr('href',a.substr(1,a.length-1));
			}else if(a[0] == '0'){
				setTimeout(function(){reloadSelectOption();},1000);
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sessi merubah password");
		}
	});
}