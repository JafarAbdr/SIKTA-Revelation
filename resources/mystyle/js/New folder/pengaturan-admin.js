
function ubahPasswordAdmin(){
	openLoadingBar("mencoba merubah password");
	j("#setAjax").setAjax({
		url : "Palacepengaturan/changePasswordAdmin.aspx",
		bool : true,
		content : "oldpass="+$("#support-old-password").val()+"&newpass="+$("#support-new-password").val()+"&conpass="+$("#support-con-password").val(),
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(parseInt(a[0]) ==  3){
				$(location).attr('href', base_url+a.substr(1,a.length-1));
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