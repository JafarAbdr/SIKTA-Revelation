var lama = {};
var lamaMessage = {};
var idInput2 = {
		0:'lama-nama',
		1:'lama-nim',
		2:'lama-nohp',
		3:'lama-nohportu',
		4:'lama-ortu',
		5:'lama-email',
		6:'lama-judulta',
		7:'lama-dosbing',
		8:'lama-krs'
};
var idInputMessage2 = {
		0:'belum diisi',
		1:'belum diisi',
		2:'belum diisi',
		3:'belum diisi',
		4:'belum diisi',
		5:'belum diisi',
		6:'belum diisi',
		7:'belum diisi',
		8:'file belum dipilih'
};
function reLoadFormLama(){
	resetFormLama();
	$('#krs-lama-exe').on('click',function(){
		$('#lama-krs').trigger('click');
	});
	$('#lama-nama').on('change',function(){
		checkInputLama('lama-nama',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-nim').on('change',function(){
		checkInputLama('lama-nim',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-email').on('change',function(){
		checkInputLama('lama-email',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-ortu').on('change',function(){
		checkInputLama('lama-ortu',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-nohportu').on('change',function(){
		checkInputLama('lama-nohportu',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-nohp').on('change',function(){
		checkInputLama('lama-nohp',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-judulta').on('change',function(){
		checkInputLama('lama-judulta',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#lama-dosbing').on('change',function(){
		checkInputLama('lama-dosbing',$(this).val(),'Classregistrasilama/getCheck',true);
	});
	$('#rest-lama').on('click',function(){
		resetFormLama();
	});
	$('#lama-submit-exe').on('click',function(){
		$(this).prop("disabled","true");
		$('#krs-lama-exe').prop('disabled',"true");
		openLoadingBar("Melakukan Proses Pengecekan ...");
		setTimeout(function(){
			if(isInputFormValid()){
				setLoadingBarMessage("Mengirim Data...");
				setTimeout(function(){
					$('#validate').trigger('submit');
				},2000);
			}else{
				//alert();
				$('#lama-submit-exe').removeAttr('disabled');
				$('#krs-lama-exe').removeAttr('disabled');
				closeLoadingBar();
				modalStaticSingleWarning("Tolong lengkapi form sebelum melakukan Registrasi Lama");
			}
		},2000);
	});
	$('#validate').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			//alert(returnResponse);
			iframe.unbind('load');
			if(parseInt(returnResponse[0]) == 1){
				$("#content-intern").slideUp('slow',function(){
					j("#content-intern").setInHtml(returnResponse.substr(1,returnResponse.length-1));
					$("#content-intern").slideDown('slow');
				});
				
			}else{
				modalStaticSingleWarning(returnResponse.substr(1,returnResponse.length-1));
			}
			$('#lama-submit-exe').removeAttr('disabled');
			$('#krs-lama-exe').removeAttr('disabled');
			closeLoadingBar();
			setTimeout(function ()
			{
				response.html('');
			}, 1);
		});
	});
	$("#lama-krs").change(function () {
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						lama['lama-krs'] = 0;
						lamaMessage['lama-krs'] = file[0].name+" , Ukuran maksimal 1 mb";
						j('#lama-krs').setValue(null);
						openDialogAlertWithClick(lamaMessage['lama-krs'],'lama-krs');
						return false;
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							lama['lama-krs'] = 1;
							lamaMessage['lama-krs'] = "Valid";
							closeDialogAlert(j('#lama-krs').getObject());
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
                } else {
					var t=file[0].name.substr(file[0].name.length-4,4);
					if(t=='.PDF' || t.toLowerCase()==".pdf"){
						var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
						if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
							lama['lama-krs'] = 0;
							lamaMessage['lama-krs'] = file[0].name+" , Ukuran maksimal 1 mb";
							j('#lama-krs').setValue(null);
							openDialogAlertWithClick(lamaMessage['lama-krs'],'lama-krs');
							return false;
						}else{
							lama['lama-krs'] = 1;
							lamaMessage['lama-krs'] = "Valid";
							closeDialogAlert(j('#lama-krs').getObject());
							return true;
						}
						//j("#preview-trans").getObject().src = e.target.result;
						
					}else{
						lama['lama-krs'] = 0;
						lamaMessage['lama-krs'] = file[0].name+" , format file yang di dukung pdf";
						j('#lama-krs').setValue(null);
						openDialogAlertWithClick(lamaMessage['lama-krs'],'lama-krs');
						return false;
					}
                }
            });
        } else {
			lama['lama-krs'] = 0;
			lamaMessage['lama-krs'] = "Browser anda tidak mendukung HTML5 FileReader";
			j('#lama-krs').setValue(null);
			openDialogAlertWithClick(lamaMessage['lama-krs'],'lama-krs');
			return false;
        }
    });
}
function isInputFormValid(){
	$error=0;
	for(var i=0;i<9;i++){
		if(lama[idInput2[i]] == 0){
			openDialogAlert(lamaMessage[idInput2[i]],j("#"+idInput2[i]).getObject());
			$error+=1;
		}	
	}
	if($error == 0)
		return true;
	else
		return false;
}
function resetFormLama(){
	for(var i=0;i<9;i++){
		lama[idInput2[i]] = 0;
		lamaMessage[idInput2[i]] = idInputMessage2[i];
		if(i == 8)
			j('#'+idInput2[i]).setValue(null);
		else
			j('#'+idInput2[i]).setValue("");
	}
	j('#setAjax').setAjax({
		methode : 'GET',
		url : "Classregistrasilama/getJsonDataPersonal.jsp",
		bool : true,
		content : "",
		sucOk : function(a){
			var tempJson = JSON.parse(a);
			if(tempJson.nama.status){
				j('#lama-nama').setValue(tempJson.nama.value);
				checkInputLama('lama-nama',j('#lama-nama').getValue(),'Classregistrasilama/getCheck',true);
				$('#lama-nama').prop('disabled',"true");
			}
			if(tempJson.nim.status){
				j('#lama-nim').setValue(tempJson.nim.value);
				checkInputLama('lama-nim',j('#lama-nim').getValue(),'Classregistrasilama/getCheck',true);
				$('#lama-nim').prop('disabled',"true");
			}
			if(tempJson.email.status){
				j('#lama-email').setValue(tempJson.email.value);
				checkInputLama('lama-email',j('#lama-email').getValue(),'Classregistrasilama/getCheck',true);
				$('#lama-email').prop('disabled',"true");
			}
			if(tempJson.nohp.status){
				j('#lama-nohp').setValue(tempJson.nohp.value);
				checkInputLama('lama-nohp',j('#lama-nohp').getValue(),'Classregistrasilama/getCheck',true);
				$('#lama-nohp').prop('disabled',"true");
			}
			if(tempJson.nohportu.status){
				j('#lama-nohportu').setValue(tempJson.nohportu.value);
				checkInputLama('lama-nohportu',j('#lama-nohportu').getValue(),'Classregistrasilama/getCheck',true);
				$('#lama-nohportu').prop('disabled',"true");
			}
			if(tempJson.ortu.status){
				j('#lama-ortu').setValue(tempJson.ortu.value);
				checkInputLama('lama-ortu',j('#lama-ortu').getValue(),'Classregistrasilama/getCheck',true);
				$('#lama-ortu').prop('disabled',"true");
			}
		}
	});
	j('#setAjax').setAjax({
		methode : 'GET',
		url : "Classregistrasilama/getJsonDataTA.jsp",
		bool : true,
		content : "",
		sucOk : function(a){
			var tempJson = JSON.parse(a);
			if(tempJson.judulta.status){
				j('#lama-judulta').setValue(tempJson.judulta.value);
				checkInputLama('lama-judulta',j('#lama-judulta').getValue(),'Classregistrasilama/getCheck',true);
			//	$('#lama-judulta').prop('disabled',"true");
			}
			if(tempJson.dosbing.status){
				j('#lama-dosbing').setValue(tempJson.dosbing.value);
				checkInputLama('lama-dosbing',j('#lama-dosbing').getValue(),'Classregistrasilama/getCheck',true);
			//	$('#lama-dosbing').prop('disabled',"true");
			}
		}
	});
}
function checkInputLama(switchs,value,url,onfocus){
	j("#setAjax").setAjax({
		methode : 'POST',
		url : url+".jsp",
		bool : true,
		content : "variabel="+switchs+"&value="+value,
		sucOk : function(a){
			lama[switchs]= parseInt(a[0]);
			lamaMessage[switchs]=a.substr(1,a.length-1);
			if(lama[switchs] == 0){
				openDialogAlert(lamaMessage[switchs],j("#"+switchs).getObject());
				if(onfocus)
					$('#'+switchs).focus();
			}else{
				closeDialogAlert(j("#"+switchs).getObject());
			}
		}
	});
}