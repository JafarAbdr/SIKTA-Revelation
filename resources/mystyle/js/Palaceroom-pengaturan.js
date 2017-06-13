
function ubahPasswordAdmin(){
	openLoadingBar("mencoba merubah password");
	j("#setAjax").setAjax({
		url : "Palacepengaturan/changePasswordAdmin",
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
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sessi merubah password");
		}
	});
}
var updateDataDiri;
function setUpdateInfoAdmin(gg){
	updateDataDiri = gg;
	$(updateDataDiri).attr("disabled","true");
	openLoadingBar('mengirim data');
	z = parseInt($('#info-jam-ta2-durasi').val())*60;
	y = parseInt($('#info-menit-ta2-durasi').val());
	zz = parseInt($('#info-jam-ta1-durasi').val())*60;
	yy = parseInt($('#info-menit-ta1-durasi').val());
	
	j('setAjax').setAjax({
		url : base_url+'Palacepengaturan/getUpdateInfoDiri',
		methode : "POST",
		bool : true,
		content : "symbolize=JASERVTECH-GET-JSON-DATA-ADMIN&"+
		"nama="+$("#info-anda-nama").val()+"&"+
		"nip="+$("#info-anda-nip").val()+"&"+
		"email="+$("#info-anda-email").val()+"&"+
		"alamat="+$("#info-anda-alamat").val()+"&"+
		"nohp="+$("#info-anda-kontak").val()+"&"+
		"kajur="+$("#info-anda-kajur").val()+"&"+
		"wakil="+$("#info-anda-wakil").val()+"&"+
		"tasd="+(yy+zz)+"&"+
		"tadd="+(y+z)
		,
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			$(updateDataDiri).removeAttr("disabled");
			setTimeout(function(){
				closeLoadingBar();
			},400);
		},
		suckEr : function(a,b){

		}
	});
}
function getDataDiriJson(){
	j('setAjax').setAjax({
		url : base_url+'Palacepengaturan/getJSONDataAdmin',
		methode : "POST",
		bool : true,
		content : "symbolize=JASERVTECH-GET-JSON-DATA-ADMIN",
		sucOk : function(a){
			if(a[0] == '0'){
				$('#info-anda-nama').val("");
				$('#info-anda-nip').val("");
				$('#info-anda-alamat').val("");
				$('#info-anda-wakil').val("");
				$('#info-anda-kontak').val("");
				$('#info-anda-email').val("");
				$('#info-anda-kajur').val("");
				$('#info-jam-ta1-durasi').val("");
				$('#info-menit-ta1-durasi').val("");
				$('#info-jam-ta2-durasi').val("");
				$('#info-menit-ta2-durasi').val("");
			}else{
				a = a.substr(1,a.length-1);
				a = JSON.parse(a);
				$('#info-anda-nama').val(a.nama);
				$('#info-anda-nip').val(a.nip);
				$('#info-anda-alamat').val(a.alamat);
				$('#info-anda-wakil').val(a.wakil);
				$('#info-anda-kontak').val(a.nohp);
				$('#info-anda-email').val(a.email);
				$('#info-anda-kajur').val(a.kajur);
				x = parseInt(a.tasd);
				y = parseInt(x/60);
				z = parseInt(x%60);
				$('#info-jam-ta1-durasi').val(y);
				$('#info-menit-ta1-durasi').val(z);
				x = parseInt(a.tadd);
				y = parseInt(x/60);
				z = parseInt(x%60);
				$('#info-jam-ta2-durasi').val(y);
				$('#info-menit-ta2-durasi').val(z);
			}
		},
		sucEr : function(a,b){

		}
		});
}