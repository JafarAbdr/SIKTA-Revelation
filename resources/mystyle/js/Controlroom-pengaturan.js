function pengaturanKoordinator(){
	reloadSelectOption();
	//alert(generateSelectOption("hello",2,7));
}
function ubahPasswordKoor(){
	openLoadingBar("mencoba merubah password");
	j("#setAjax").setAjax({
		url : "Controlpengaturan/changePasswordKoor",
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
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sessi merubah password");
		}
	});
}
function ubahDataGanjilGenapTahunConstrain(){
	openLoadingBar("Menfilter data ...");
	ganjilBulan = $('#bulan-ganjil-1').val();
	ganjilDay = $('#tanggal-ganjil-1').val();
	genapBulan = $('#bulan-genap-1').val();
	genapDay = $('#tanggal-genap-1').val();
	if(!isInDayOnMonth(ganjilBulan,ganjilDay,false)){
		setLoadingBarMessage("Tanggal ganjil tidak valid");
		setTimeout(function(){
			closeLoadingBar();
		},1000);
	}
	if(!isInDayOnMonth(genapBulan,genapDay,false)){
		setLoadingBarMessage("Tanggal ganjil tidak valid");
		setTimeout(function(){
			closeLoadingBar();
		},1000);
	}
	j("#setAjax").setAjax({
		url : "Controlpengaturan/setNewGanjilGenapConstrain",
		bool : true,
		content : 
		"ganjilMonth="+ganjilBulan+"&"+
		"ganjilDay="+ganjilDay+"&"+
		"genapMonth="+genapBulan+"&"+
		"genapDay="+genapDay
		,
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(parseInt(a[0]) ==  3){
				$(location).attr('href', a.substr(1,a.length-1));
			}else if(a[0] == '0'){	
				setTimeout(function(){
					reloadSelectOption();
				},400);	
			}else{			
				setTimeout(function(){
					closeLoadingBar();
				},400);	
			}
		},
		sucEr : function(a,b){
			template(a,b,"sessi koordinator ganjil genap constrain");
		}
	});
}
function reloadSelectOption(){
	openLoadingBar("mencoba merubah password");
	j("#setAjax").setAjax({
		url : "Controlpengaturan/getSelectListDosen",
		bool : true,
		content : "",
		methode : "POST",
		sucOk : function(a){
			setLoadingBarMessage("Memproses balasan ...");
			if(parseInt(a[0]) ==  3){
				$(location).attr('href', a.substr(1,a.length-1));
			}else if(a[0] == '1'){
				$("#support-selec-you").html("");
				a = a.split("`");
				$("#support-selec-you").html(a[0].substr(1,a[0].length-1));
				if($("#support-who-you-are").length>0)$("#support-who-you-are").select2();
				ganjiltemp = a[1].split("|");
				genaptemp = a[2].split("|");
				$('#bulan-ganjil-1').val(ganjiltemp[0]);
				$('#bulan-genap-1').val(genaptemp[0]);
				getDataTabel1(ganjiltemp[0],ganjiltemp[1]);
				getDataTabel2(genaptemp[0],genaptemp[1]);
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
function getDataTabel1(s,d){
	//alert();
	tempDataResult = generateSelectOption("tanggal-ganjil-1",s,d,"Tanggal 29 ditiadakan",false);
	if(tempDataResult[0])
		$('#tanggalganjil').html(tempDataResult[1]);
	else
		$('#tanggalganjil').html("");
}
function getDataTabel2(s,d){
	//alert();
	tempDataResult = generateSelectOption("tanggal-genap-1",s,d,"Tanggal 29 ditiadakan",false);
	if(tempDataResult[0])
		$('#tanggalgenap').html(tempDataResult[1]);
	else
		$('#tanggalgenap').html("");
}
function reloadDataKoordinator(aa){
	openLoadingBar("mencoba merubah data koordinator");
	j("#setAjax").setAjax({
		url : "Controlpengaturan/changeNipKoor",
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
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sessi merubah password");
		}
	});
}