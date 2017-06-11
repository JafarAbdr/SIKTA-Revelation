var baru = {};
var baruMessage = {};
var idInput = {
		0:'baru-nama',
		1:'baru-nim',
		2:'baru-nohp',
		3:'baru-nohportu',
		4:'baru-ortu',
		5:'baru-email',
		6:'baru-lokasi',
		7:'baru-metode',
		8:'baru-judulta',
		9:'baru-minat',
		10:'baru-krs',
		11:'baru-ref1',
		12:'baru-ref2',
		13:'baru-ref3'
};
var idInputMessage = {
		0:'belum diisi',
		1:'belum diisi',
		2:'belum diisi',
		3:'belum diisi',
		4:'belum diisi',
		5:'belum diisi',
		6:'belum diisi',
		7:'belum diisi',
		8:'belum diisi',
		9:'belum diisi',
		10:'file belum dipilih',
		11:'wajib diisi',
		12:'boleh kosong atau terisi',
		13:'boleh kosong atau terisi'
};
function reLoadFormBaru(){
	resetForm();
	$('#validate').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			if(parseInt(returnResponse[0]) == 1){
				$("#content-intern").slideUp('slow',function(){
					j("#content-intern").setInHtml(returnResponse.substr(1,returnResponse.length-1));
					$("#content-intern").slideDown('slow');
				});
				
			}else{
				modalStaticSingleWarning(returnResponse.substr(1,returnResponse.length-1));
			}
			$('#registrasi-baru-submit').removeAttr('disabled');
			$('#krs-exe').removeAttr('disabled');
			closeLoadingBar()
			setTimeout(function ()
			{
				response.html('');
			}, 1);
		});
	});
	$('#reset-form').on('click',function(){
		modalStaticMultipleButton('Apakah anda yakin ingin menghapus isi form ? ',function(){
			resetForm();
		});
	});
	$('#registrasi-baru-submit').on('click',function(){
		$(this).prop('disabled',true);
		$('#krs-exe').prop('disabled',true);
		openLoadingBar("Melakukan Proses Pengecekan ...");
		setTimeout(function(){
			var temp = validateAll();
			if(temp == 0){
				if(validateSecond() == 0){
					setLoadingBarMessage("Mengirim Data...");
					setTimeout(function(){
						$('#validate').trigger('submit');
					},2000);
				}
				else{
					$('#registrasi-baru-submit').removeAttr('disabled');
					$('#krs-exe').removeAttr('disabled');
					closeLoadingBar();
					modalStaticSingleWarning("Tolong lengkapi form sebelum melakukan Registrasi Baru");
				}
			}else{
				$('#registrasi-baru-submit').removeAttr('disabled');
				$('#krs-exe').removeAttr('disabled');
				closeLoadingBar();
				modalStaticSingleWarning("Tolong lengkapi form sebelum melakukan Registrasi Baru");
			}
		},2000);
	});
	$('#baru-nama').on('change',function(){
		checkInput('baru-nama',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-nim').on('change',function(){
		checkInput('baru-nim',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-nohp').on('change',function(){
		checkInput('baru-nohp',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-ortu').on('change',function(){
		checkInput('baru-ortu',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-nohportu').on('change',function(){
		checkInput('baru-nohportu',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-email').on('change',function(){
		checkInput('baru-email',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-minat').on('change',function(){
		checkInput('baru-minat',$(this).val(),'Classregistrasibaru/getCheck',false);
	});
	$('#baru-judulta').on('change',function(){
		checkInput('baru-judulta',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-lokasi').on('change',function(){
		checkInput('baru-lokasi',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-metode').on('change',function(){
		checkInput('baru-metode',$(this).val(),'Classregistrasibaru/getCheck',true);
	});
	$('#baru-ref1').on('change',function(){
		if($('#baru-ref1').val() == ""){
			j('#baru-ref2').setValue("");
			j('#baru-ref3').setValue("");
			baru['#baru-ref1'] = 0;
			baruMessage['#baru-ref1'] = "wajib diisi";
			$('#baru-ref1').focus();
			openDialogAlert(baruMessage['#baru-ref1'],j('#baru-ref1').getObject());
		}else{
			checkInput('baru-ref1',$(this).val(),'Classregistrasibaru/getCheck',true);
		}
	});
	$('#baru-ref2').on('change',function(){
		if(baru['baru-ref1'] == 0){
			j('#baru-ref2').setValue("");
			openDialogAlert("silahkan isikan terlebih dahulu",j('#baru-ref1').getObject());
			$('#baru-ref1').focus();
		}else if($('#baru-ref2').val() == "")
			j('#baru-ref3').setValue("");
		else{
			checkInput('baru-ref2',$(this).val(),'Classregistrasibaru/getCheck',true);
		}
		/*
		if($('#baru-ref1').val()+"" == ""){
			openDialogAlert("silahkan isikan terlebih dahulu dari referensi 1",j('#baru-ref1').getObject());
			baru['baru-ref1'] = 0;
			baruMessage['baru-ref1'] = "belum diisi";
			$('#baru-ref1').focus();
		}else{
			if($(this).val()+"" == ""){
				if($('#baru-ref3').val()+"" != ""){
					openDialogAlert("referensi 2 harus diisi karena referensi 3 sudah diisi",j("#baru-ref2").getObject());
					baru['baru-ref2'] = 0;
					baruMessage['baru-ref2'] = "belum diisi";
					$('#baru-ref2').focus();
				}else
					
			}
		}
		*/
	});
	$('#baru-ref3').on('change',function(){
		var error=0;
		if(baru['baru-ref1'] == 0){
			j('#baru-ref3').setValue('');
			j('#baru-ref2').setValue('');
			openDialogAlert("silahkan isikan terlebih dahulu",j('#baru-ref1').getObject());
			$('#baru-ref1').focus();
		}else if(baru['baru-ref2'] == 0){
			j('#baru-ref3').setValue('');
			openDialogAlert("silahkan isikan terlebih dahulu",j('#baru-ref2').getObject());
			$('#baru-ref2').focus();
		}else if($('#baru-ref2').val() == ""){
			j('#baru-ref3').setValue('');
			openDialogAlert("silahkan isikan terlebih dahulu",j('#baru-ref2').getObject());
			$('#baru-ref2').focus();
		}else{
			checkInput('baru-ref3',$(this).val(),'Classregistrasibaru/getCheck',true);
		}
		/*
		if($('#baru-ref2').val()+"" == ""){
			if($('#baru-ref1').val+"" == ""){
				openDialogAlert("silahkan isikan terlebih dahulu dari referensi 1",j('#baru-ref1').getObject());
				openDialogAlert("Kemudian isi referensi 2 jika perlu",j('#baru-ref2').getObject());
				baru['baru-ref1'] = 0;
				baru['baru-ref2'] = 0;
				baruMessage['baru-ref1'] = "belum diisi";
				baruMessage['baru-ref2'] = "belum diisi";
				$('#baru-ref1').focus();
			}else{
				openDialogAlert("silahkan isikan terlebih dahulu dari referensi 1 ",j('#baru-ref1').getObject());
				baru['baru-ref1'] = 0;
				baruMessage['baru-ref1'] = "belum diisi";
				$('#baru-ref1').focus();
			}
		}
		else{
			if($('#baru-ref2').val+"" == ""){
				openDialogAlert("Kemudian isi referensi 2 jika perlu",j('#baru-ref2').getObject());
				baru['baru-ref2'] = 0;
				baruMessage['baru-ref2'] = "belum diisi";
				$('#baru-ref2').focus();
			}
			else
				
		}

		
		*/
	});
	$('#krs-exe').on('click',function(){
		$('#baru-krs').trigger('click');
	});
	$("#baru-krs").change(function () {
        if (typeof (FileReader) != "undefined") {
            var regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
						baru['baru-krs'] = 0;
						baruMessage['baru-krs'] = file[0].name+" , Ukuran maksimal 1 mb";
						j('#baru-krs').setValue(null);
						openDialogAlertWithClick(baruMessage['baru-krs'],'baru-krs');
						return false;						
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							baru['baru-krs'] = 1;
							baruMessage['baru-krs'] = "Valid";
							closeDialogAlert(j('#baru-krs').getObject());
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
                } else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t=='.PDF' || t.toLowerCase()==".pdf"){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > 1){
								baru['baru-krs'] = 0;
								baruMessage['baru-krs'] = file[0].name+" , Ukuran maksimal 1 mb";
								j('#baru-krs').setValue(null);
								openDialogAlertWithClick(baruMessage['baru-krs'],'baru-krs');
								return false;								
							}else{
								//j("#preview-trans").getObject().src = e.target.result;
								baru['baru-krs'] = 1;
								baruMessage['baru-krs'] = "Valid";
								closeDialogAlert(j('#baru-krs').getObject());
								return true;
							}
						}else{
							baru['baru-krs'] = 0;
							baruMessage['baru-krs'] = file[0].name+" , format file yang di dukung pdf";
							j('#baru-krs').setValue(null);
							openDialogAlertWithClick(baruMessage['baru-krs'],'baru-krs');
							return false;
						}
                }
            });
        } else {
			baru['baru-krs'] = 0;
			baruMessage['baru-krs'] = "Browser anda tidak mendukung HTML5 FileReader";
			j('#baru-krs').setValue(null);
			openDialogAlertWithClick(baruMessage['baru-krs'],'baru-krs');
			return false;
        }
    });
}
function validateAll(){
	var error=0;
	for(var i=0;i<12;i++){
		if(baru[idInput[i]] == 0){
			error+=1;
			openDialogAlert(baruMessage[idInput[i]],j('#'+idInput[i]).getObject());
		}
	}
	return error;
}
function validateSecond(){
	var error=0;
	for(var i=12;i<14;i++){
		if(baru[idInput[i]] == 0){
			error+=1;
			openDialogAlert(baruMessage[idInput[i]],j('#'+idInput[i]).getObject());
		}
	}
return error;
}
function resetForm(){
	for(var i=0;i<12;i++){
		baru[idInput[i]]=0;
		baruMessage[idInput[i]]=idInputMessage[i];
		if(i == 10)
			j('#'+idInput[i]).setValue(null);
		else
			j('#'+idInput[i]).setValue("");
	}
	baru[idInput[12]] = 1;
	baruMessage[idInput[12]]=idInputMessage[12];
	j('#'+idInput[12]).setValue("");
	baru[idInput[13]] = 1;
	baruMessage[idInput[13]]=idInputMessage[13];
	j('#'+idInput[13]).setValue("");
	
	j('#setAjax').setAjax({
		methode : 'GET',
		url : "Classregistrasibaru/getJsonDataPersonal.aspx",
		bool : true,
		content : "",
		sucOk : function(a){
			var tempJson = JSON.parse(a);
			if(tempJson.nama.status){
				j('#baru-nama').setValue(tempJson.nama.value);
				checkInput('baru-nama',j('#baru-nama').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-nama').prop('disabled',"true");
			}
			if(tempJson.nim.status){
				j('#baru-nim').setValue(tempJson.nim.value);
				checkInput('baru-nim',j('#baru-nim').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-nim').prop('disabled',"true");
			}
			if(tempJson.email.status){
				j('#baru-email').setValue(tempJson.email.value);
				checkInput('baru-email',j('#baru-email').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-email').prop('disabled',"true");
			}
			if(tempJson.nohp.status){
				j('#baru-nohp').setValue(tempJson.nohp.value);
				checkInput('baru-nohp',j('#baru-nohp').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-nohp').prop('disabled',"true");
			}
			if(tempJson.nohportu.status){
				j('#baru-nohportu').setValue(tempJson.nohportu.value);
				checkInput('baru-nohportu',j('#baru-nohportu').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-nohportu').prop('disabled',"true");
			}
			if(tempJson.ortu.status){
				j('#baru-ortu').setValue(tempJson.ortu.value);
				checkInput('baru-ortu',j('#baru-ortu').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-ortu').prop('disabled',"true");
			}
			if(tempJson.minat.status){
				j('#baru-minat').setValue(tempJson.minat.value);
				checkInput('baru-minat',j('#baru-minat').getValue(),'Classregistrasibaru/getCheck',true);
				$('#baru-minat').prop('disabled',"true");
			}
		}
	});
	
}
function openDialogAlertWithClick(message,id){
	$('#'+id).trigger('click');
	openDialogAlert(message,j('#'+id).getObject());
}
function openDialogAlert(message,object){
	var temp = object.parentNode;
	temp.childNodes[1].innerHTML = 
		'<div class="form-validation-field-0formError parentFormvalidate formError" style="opacity: 0.87; position: absolute; top: 0px; left: 10px; margin-top: -27px;">'+
			'<div class="formErrorContent">'+message+'</div>'+
			'<div class="formErrorArrow">'+
				'<div class="line10"></div>'+
				'<div class="line9"></div>'+
				'<div class="line8"></div>'+
				'<div class="line7"></div>'+
				'<div class="line6"></div>'+
				'<div class="line5"></div>'+
				'<div class="line4"></div>'+
				'<div class="line3"></div>'+
				'<div class="line2"></div>'+
				'<div class="line1"></div>'+
			'</div>'+
		'</div>'
		;
}
function closeDialogAlert(object){
	var temp = object.parentNode;
	temp.childNodes[1].innerHTML = "";
}

function checkInput(switchs,value,url,onfocus){
	j("#setAjax").setAjax({
		methode : 'POST',
		url : url+".aspx",
		bool : true,
		content : "variabel="+switchs+"&value="+value,
		sucOk : function(a){
			baru[switchs]= parseInt(a[0]);
			baruMessage[switchs]=a.substr(1,a.length-1);
			if(baru[switchs] == 0){
				openDialogAlert(baruMessage[switchs],j("#"+switchs).getObject());
				if(onfocus)
					$('#'+switchs).focus();
			}else{
				closeDialogAlert(j("#"+switchs).getObject());
			}
		}
	});
}