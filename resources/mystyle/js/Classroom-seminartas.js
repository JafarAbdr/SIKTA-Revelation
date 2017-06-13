//kode langkah 1
var templateCalendarTAS = 
	'<div style=" color:#333333;">'+
		'<div class=form-row> '+
			'<div class=col-md-3>Jam : </div> '+
			'<div class=col-md-9> '+
				'<div class=input-group> '+
					'<div class=input-group-addon>'+
						'<span class=icon-time></span>'+
					'</div> '+
					'<input id="jam-rung-tas" type=text class="timepicker form-control" value="12:17"/> '+
				'</div>'+ 
			'</div>'+ 
		'</div>'+
		'<div>'+
		'<h6 style="font-size : 0.8em;">*Silahkan masukan sesuai dengan kondisi yang berlaku</h6>'+
		'</div>'+
	'</div>'
;
var tanggalSewaRuangTA1;
var TEMP_N;
var tanggalSewaRuangTA1_TEMP;
var tanggalSewaRuangDefault;
var uploadFileState = {
	satu : false,
	dua : false,
	tiga : false
}
var idTanggal = null;


var kodeActive = null;
function resetKode1(){
	errorInFile({
		idC : "s-k-peserta",
		kodeValid : 0
	});
	errorInFile({
		idC : "s-k-bimbingan",
		kodeValid : 1
	});
	if(parseInt(pengantarButtonControl) == 1){		
		errorInFile({
			idC : "s-pengantar",
			kodeValid : 3
		});
		uploadFileState.satu = false;
	}
	$("#s-ruang").val("");
	$("#s-tanggal").val("");
	
	var xx = new Date();
	tanggalSewaRuangTA1 = xx.getDate()+"/"+xx.getMonth()+"/"+xx.getFullYear()+" "+xx.getHours()+":"+xx.getMinutes()+":"+xx.getSeconds();
	tanggalSewaRuangDefault = true;
	uploadFileState.dua = false;
	uploadFileState.tiga = false;
	if(idTanggal != null){
		$('#calendar').fullCalendar('removeEvents', idTanggal);
		idTanggal = null;
	}
}
function refreshKode1(a){
	buttonLoaderFunctionFull({
		idC : "s-k-peserta",
		size : 1,
		regexC : "png",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.png)",
		kodeValid : 2
	});
	buttonLoaderFunctionFull({
		idC : "s-k-bimbingan",
		size : 1,
		regexC : "png",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.png)",
		kodeValid : 3
	});
	if(parseInt(kodeActive[0]) == 1){		
		buttonLoaderFunctionFull({
			idC : "s-pengantar",
			size : 1,
			regexC : "pdf",
			messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
			kodeValid : 1
		});
	}else{
		uploadFileState.satu = true;
	}
	refreshCalendarSeminarTa1();
	
	$('#seminar1form').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			
			if(returnResponse[0] ==  "="){
				window.location = base_url+"Gateinout";
			}else if(parseInt(returnResponse[0]) == 1){
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
	$("#input-data-seminarta1").on('click',function(){
		openLoadingBar("Memeriksa input ...");
		
		if(parseInt(pengantarButtonControl) == 1){
			if(!failedInput(1,"Wajib melampirkan kartu pengantar")){
				return;
			}
		}
		if(!failedInput(2,"kartu peserta wajib dilampirkan")){
			return;
		}
		if(!failedInput(3,"scan kartu bimbingan wajib dilampirkan")){
			return;
		}
		if(idTanggal == null){
			setLoadingBarMessage("Silahkan memilih hari dan waktu seminar anda pada list seminar ruang TA 1");
			setTimeout(function(){
				closeLoadingBar();
			},1000);
			return;
		}
		$("#seminar1form").trigger('submit');
	});
	$("#resetForm").on('click',function(){
		//
		resetKode1();
	});
}
function resetContentKode1(){
	
}
//kode langkah 2
function refreshKode2(){
	
}
function refreshKode3(){
	buttonLoaderFunctionFull({
		idC : "s-k-bimbingan",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 1
	});
	buttonLoaderFunctionFull({
		idC : "s-k-peserta",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 2
	});
	$('#seminar1form').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			
			if(returnResponse[0] ==  "="){
				window.location = base_url+"Gateinout";
			}else if(parseInt(returnResponse[0]) == 1){
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
	$("#input-data-seminarta1").on('click',function(){
		openLoadingBar("Memeriksa input ...");
		if(!failedInput(1,"FUJ 12 wajib dilampirkan")){
			return;
		}
		if(!failedInput(2,"FUJ 13 Wajib dilampirkan")){
			return;
		}
		$("#seminar1form").trigger('submit');
	});
	$("#resetForm").on('click',function(){
		errorInFile({
			idC : "s-k-peserta",
			kodeValid : 2
		});
		errorInFile({
			idC : "s-k-bimbingan",
			kodeValid : 1
		});
	});
}
function showFujPDFTAS(a){
	modalStaticSingleInformation("PDF viewer",
	"<iframe src='"+base_url+"Classseminartas/printPdfAcara/"+a+".jsp' style='width : 100%;  height : 500px;'></iframe>"
	);
}
function showFujPDFTAD(a){
	modalStaticSingleInformation("PDF viewer",
	"<iframe src='"+base_url+"Classseminartad/printPdfAcara/"+a+".jsp' style='width : 100%;  height : 500px;'></iframe>"
	);
}
function refreshKode4(){
	
}
function SeminarTAS(a){
	kodeActive = a;
	switch(a[1]){
		case 'A' :
		refreshKode1(a);
		break;
		case 'B' :
		refreshKode2(a);
		break;
		case 'C' :
		refreshKode3(a);
		break;
		case 'D' :
		refreshKode4(a);
		break;
	}
}
//support

var Calenders;
var TEMP_DATE_TIME;
function refreshCalendarSeminarTa1(){
	$("#calendar").html("");
	if($("#calendar").length>0){
		var e=new Date();
		var t=e.getDate();
		var n=e.getMonth();
		var r=e.getFullYear(); //2016
		$("#external-events .external-event").each(function(){
			var e={title:$.trim($(this).text())};$(this).data("eventObject",e);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0})});
		
		Calenders = $("#calendar").fullCalendar({
			header:{
				left:"prev,next today",
				center:"title",
				right : ""
				//center:"title",
				//right:"month,agendaWeek,agendaDay"
				}
			,editable:true,events:[],
			droppable:false,
			selectable:true,
			selectHelper:false,
			eventStartEditable : false,
			eventDurationEditable : false,
			disableResizing : true,
			select:function(e,t,n){
				TEMP_N = n;
				tanggalSewaRuangTA1_TEMP = moment(e);
				if(moment(e).isBefore(moment())){
					modalStaticSingleInformation("Peringatan",
					'<div class="panel panel-warning">'+
						'<div class="panel-heading">'+
							'<h3 class="panel-title">Mohon Perhatiannya.</h3>'+
						'</div>'+
						'<div class="panel-body"> Waktu yang anda pilih dibatasi harus lebih dari waktu saat ini. </div> <div class="panel-footer"></div> </div>');
					return;
				}
				modalStaticBodyMultipleButton("Masukan Jam Seminar anda",templateCalendarTAS,function(finalis){
					openLoadingBar("Validasi tanggal dan jam ...");
					var TEMP_DATE_TIME = moment("0000-00-00T"+$("#jam-rung-tas").val());
					tanggalSewaRuangTA1_TEMP.hour(TEMP_DATE_TIME.hours());
					tanggalSewaRuangTA1_TEMP.minute(TEMP_DATE_TIME.minutes());
					TEMP_DATE_TIME = tanggalSewaRuangTA1_TEMP.format("YYYY-MM-DD HH:mm:ss");
					j("#ajax").setAjax({
						methode: "POST",
						url:"Classseminartas/getCheck",
						bool : true,
						content: "variabel=TA1&value="+TEMP_DATE_TIME,
						sucOk : function(a){
							if(a[0] ==  "="){
								window.location = base_url+"Gateinout";
							}else if(parseInt(a[0]) ==  1){
								setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
								tanggalSewaRuangTA1 = tanggalSewaRuangTA1_TEMP;
								var START_DAY = tanggalSewaRuangTA1;
								var END_DAY = tanggalSewaRuangTA1;
								END_DAY.minutes(END_DAY.minutes()+30);
								if(END_DAY.minutes > 59){
									END_DAY.minutes(END_DAY.minutes()-59);
									END_DAY.hours(END_DAY.hours()+1);
								}
								tanggalSewaRuangDefault = false;
								if(idTanggal == null){
									idTanggal = "aktifNow";	
									Calenders.fullCalendar('renderEvent',{
										id:idTanggal,
										title:"Seminar Ku",
										start: START_DAY,
										end: END_DAY,
										allDay:TEMP_N},true);
								}else{
									Calenders.fullCalendar('removeEvents', idTanggal);
									Calenders.fullCalendar('renderEvent',{
										id:idTanggal,
										title:"Seminar Ku",
										start: START_DAY,
										end: END_DAY,
										allDay:TEMP_N},true);
								}
								$('#s_tanggal').val(TEMP_DATE_TIME);
								$('#s_ruang').val("TA1");
								finalis(true);
							}else{
								setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
								finalis(false);
							}
							setTimeout(function(){
								closeLoadingBar();
							},3000);
						},
						sucEr : function(a,b){
							template(a,b,"checking tanggal");
						}
						
					});
				},function(){
					$('#jam-rung-tas').on('blur', function(){
						getCheckJam($(this).val(),function(){
							$('#jam-rung-tas').css({
								"borderColor" : "green",
							});
						},function(){
							$('#jam-rung-tas').css({
								"borderColor" : "red",
							});
							var TEMP_DATE = new Date();
							$("#jam-rung-tas").val(TEMP_DATE.getHours()+":"+TEMP_DATE.getMinutes());
							$('#jam-rung-tas').css({
								"borderColor" : "green",
							});
						});
					});
				});
				if($(".timepicker").length>0)$(".timepicker").timepicker();
				if($(".datepicker").length>0)$(".datepicker").datepicker({nextText:"",prevText:""});
			},
			eventClick: function(calEvent, jsEvent, view) {
				var start = moment(calEvent.start);
				var end = moment(calEvent.end);
				var tempEvent = calEvent.id.split("|");
				var title = tempEvent[0];
				var nama = tempEvent[1];
				var status = tempEvent[2];
				if(idTanggal != null){
					if(calEvent.id == idTanggal)
						modalStaticMultipleButton("Anda ingin menghapus even ini ",function(){
							$("#s-tanggal").val("");
							$("s-ruang").val("");
							$('#calendar').fullCalendar('removeEvents', calEvent.id);
							tanggalSewaRuangDefault = false;
							idTanggal = null;
						});
					else{
						 modalStaticSingleInformation(title,
					 "<table style='width : 100%;'>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Pemegang"+
							"</td>"+
							"<td style='width : 75%;'>"+
								nama+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Mulai"+
							"</td>"+
							"<td>"+
								"Tanggal "+start.format("D MMMM YYYY")+", "+start.format("H:mm")+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Berakhir"+
							"</td>"+
							"<td>"+
								"Tanggal "+end.format("D MMMM YYYY")+", "+end.format("H:mm")+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Status"+
							"</td>"+
							"<td>"+
								status+
							"</td>"+
						"</tr>"+
					 "</table>"
					 );
					}
						
				}else{
					 modalStaticSingleInformation(title,
					 "<table style='width : 100%;'>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Pemegang"+
							"</td>"+
							"<td style='width : 75%;'>"+
								nama+ 
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Mulai"+
							"</td>"+
							"<td>"+
								"Tanggal "+start.format("D MMMM YYYY")+", "+start.format("H:mm")+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Berakhir"+
							"</td>"+
							"<td>"+
								"Tanggal "+end.format("D MMMM YYYY")+", "+end.format("H:mm")+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Status"+
							"</td>"+
							"<td>"+
								status+
							"</td>"+
						"</tr>"+
					 "</table>"
					 );
				}
			}
		});
		openLoadingBar("get all list data seminar ta 1");
		j("#setAjax").setAjax({
			methode : "GET",
			bool : true,
			url :"Classseminartas/getJSONDataSeminarTA1",
			content : "",
			sucOk : function(a){
				if(a[0] ==  "="){
					window.location = base_url+"Gateinout";
				}else if(a[0] == "0"){
					setLoadingBarMessage("Refresh halaman ...");
				}else{
					setLoadingBarMessage("Data sedang diproses ...");
					jsonList = JSON.parse(a.substr(1,a.length-1));
					if(jsonList.kode){
						for(i=0;i<jsonList.content;i++){		
							var START_DAY = moment(jsonList[i].tanggal);
							var END_DAY = moment(jsonList[i].endTanggal);
							Calenders.fullCalendar('renderEvent',{
								id: jsonList[i].namaAcara+"|"+jsonList[i].nama+"|"+jsonList[i].status,
								title: jsonList[i].namaAcara,
								start: START_DAY,
								end: END_DAY},true);
						}
					}
				}
				setTimeout(function(){
					closeLoadingBar();
					//reloadTable();
				},750);	
			},
			sucEr : function(a,b){
				template(a,b,"get all table");
			}
		});
	}
}
function buttonLoaderFunctionFull(data){
	$("#exec-"+data.idC).click(function(){$("#"+data.idC).trigger('click');});
	$("#"+data.idC).change(function () {
		if (typeof (FileReader) != "undefined") {
			var regex;
			var upperC;
			var lowerC;
			if(data.regexC == "pdf"){
				regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.pdf|.PDF)$/;
				upperC = ".PDF";
				lowerC = ".pdf";
			}else if(data.regexC == "png"){
				regex = /^([a-zA-Z0-9()\s_\\.\-:])+(.png|.PNG)$/;
				upperC = ".PNG";
				lowerC = ".png";
			}
			$($(this)[0].files).each(function () {
				var file = $(this);
				if (regex.test(file[0].name.toLowerCase())) {
					var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
					if(parseFloat(TEMP_VIDEO_SIZE+"") > data.size){
						errorInFile({
							idC : data.idC,
							kodeValid : data.kodeValid
						});
						modalStaticSingleWarning(data.messageFalse);
						return false;	
					}else{
						var reader = new FileReader();
						reader.onload = function (e) {
							noErrorInFile({
								idC : data.idC,
								kodeValid : data.kodeValid
							},file[0].name);
							return true;
						}
						reader.readAsDataURL(file[0]);
					}
				} else {
						var t=file[0].name.substr(file[0].name.length-4,4);
						if(t==upperC || t.toLowerCase()==lowerC){
							var TEMP_VIDEO_SIZE = file[0].size/(1024*1024);
							if(parseFloat(TEMP_VIDEO_SIZE+"") > data.size){
								errorInFile({
									idC : data.idC,
									kodeValid : data.kodeValid
								});
								modalStaticSingleWarning(data.messageFalse);
								return false;
							}else{
								noErrorInFile({
									idC : data.idC,
									kodeValid : data.kodeValid
								},file[0].name);
								return true;
							}
						}else{
							errorInFile({
								idC : data.idC,
								kodeValid : data.kodeValid
							});
							modalStaticSingleWarning(data.messageFalse);
							return false;
						}
				}
			});
		} else {
			errorInFile({
				idC : data.idC,
				kodeValid : data.kodeValid
			});
			modalStaticSingleWarning(data.messageFalse);
			return false;
		}
	});
}
function refreshButtonSeminarTa1(){
	buttonLoaderFunctionFull({
		idC : "s-k-peserta",
		size : 1,
		regexC : "png",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.png)",
		kodeValid : 0
	});
	buttonLoaderFunctionFull({
		idC : "s-k-bimbingan",
		size : 1,
		regexC : "png",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.png)",
		kodeValid : 1
	});
	if(parseInt(pengantarButtonControl) == 1){		
		buttonLoaderFunctionFull({
			idC : "s-pengantar",
			size : 1,
			regexC : "pdf",
			messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
			kodeValid : 3
		});
	}
}
function errorInFile(data){
	j("#"+data.idC).setValue(null);
	$("#exec-"+data.idC).css({
		"backgroundColor" : "red"
	});
	uploadFileState[data.kodeValid] = false;
	$("#info-"+data.idC).html(": Data Kosong");
	$("#true-"+data.idC).css({"color":"red"});
	$("#false-"+data.idC).css({"color":"green"});
}
function noErrorInFile(data,a){	
	uploadFileState[data.kodeValid] = true;
	$("#exec-"+data.idC).css({
		"backgroundColor" : "green"
	});
	$("#info-"+data.idC).html(": "+a);
	$("#true-"+data.idC).css({"color":"green"});
	$("#false-"+data.idC).css({"color":"red"});
}



























var pengantarButtonControl;
function SeminarTASk(a){
	alert(a);
	/* 
	//alert(a);
	if(a == '3')
		return;
	pengantarButtonControl = a;
	refreshCalendarSeminarTa1();
	refreshButtonSeminarTa1();
	//alert("ok = "+$(".datetimepicker").length);
	if($(".datetimepicker").length>0)$(".datetimepicker").datetimepicker({nextText:"",prevText:""});
	resetFormSeminarTA1();
	$('#resetForm').on("click",function(){
		modalStaticMultipleButton("Anda yakin ingin me lakukan reset form?",function(){
			resetFormSeminarTA1();
		});
	});
	$("#input-data-seminarta1").on("click",function(){
		inputFormSeinarta1();
	});
	var datasending = $("#frame-layout").on("change",function(){
		
	});
	$('#seminar1form').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			//alert(returnResponse);
			
			if(parseInt(returnResponse[0]) ==  9){
				$(location).attr('href',a.substr(1,a.length-1));
			}else if(parseInt(returnResponse[0]) == 1){
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
	}); */
}
function inputFormSeinarta1(){
	openLoadingBar("Memeriksa input ...");
	if(!failedInput(0,"kartu peserta wajib dilampirkan")){
		return;
	}
	if(!failedInput(1,"scan kartu bimbingan wajib dilampirkan")){
		return;
	}
	if(!failedInput(2,"transkrip wajib dilampirkan")){
		return;
	}
	if(parseInt(pengantarButtonControl) == 1){
		if(!failedInput(3,"Wajib melampirkan kartu pengantar")){
			return;
		}
	}
	if(idTanggal == null){
		setLoadingBarMessage("Silahkan memilih hari dan waktu seminar anda pada list seminar ruang TA 1");
		setTimeout(function(){
			closeLoadingBar();
		},1000);
		return;
	}
	$("#seminar1form").trigger('submit');
}
function failedInput(index,message){
	if(!uploadFileState[index]){
		setLoadingBarMessage(message);
		setTimeout(function(){
			closeLoadingBar();
		},1000);
		return false;
	}else{
		return true;
	}
}
function resetFormSeminarTA1(){	
	errorInFile({
		idC : "s-k-peserta",
		kodeValid : 0
	});
	errorInFile({
		idC : "s-k-bimbingan",
		kodeValid : 1
	});
	errorInFile({
		idC : "s-transkrip",
		kodeValid : 2
	});
	if(parseInt(pengantarButtonControl) == 1){		
		errorInFile({
			idC : "s-pengantar",
			kodeValid : 3
		});
	}
	$("#s-ruang").val("");
	$("#s-tanggal").val("");
	
	var xx = new Date();
	tanggalSewaRuangTA1 = xx.getDate()+"/"+xx.getMonth()+"/"+xx.getFullYear()+" "+xx.getHours()+":"+xx.getMinutes()+":"+xx.getSeconds();
	tanggalSewaRuangDefault = true;
	uploadFileState.satu = false;
	uploadFileState.dua = false;
	uploadFileState.tiga = false;
	uploadFileState.empat = false;
	if(idTanggal != null){
		$('#calendar').fullCalendar('removeEvents', idTanggal);
		idTanggal = null;
	}
}
/*
array
data 
->idC
->size
->regexC
->messageFalse
->data.kodeValid

*/
function getCheckJam(jam,tr,fl){
	/*
	xx = moment("0000-00-00T"+xx);
	if(isNaN(xx.getHours()) || isNaN(xx.getMinutes())){
		fl();
		return false;
	}
	*/
	
	var TEMP_SPLIT = jam.split(":");
	//alert(TEMP_SPLIT[0]+" "+TEMP_SPLIT[1]);
	if(isNaN(parseInt(TEMP_SPLIT[0]))){
		fl();
		return false;	
	}
	if(isNaN(parseInt(TEMP_SPLIT[1]))){
		fl();
		return false;
	}
	var coy = parseInt(TEMP_SPLIT[0]);
	if(coy > 23 || coy < 0){
		fl();
		return false;
	}
		//alert(TEMP_SPLIT[0]+" "+TEMP_SPLIT[1]);
	coy = parseInt(TEMP_SPLIT[1]);
	if(coy > 59 || coy < 0){
		fl();
		return false;	
	}
	if(!isNaN(parseInt(TEMP_SPLIT[3]))){
		fl();
		return false;
	}
	$("#jam-rung-tas").val(parseInt(TEMP_SPLIT[0])+":"+parseInt(TEMP_SPLIT[1]));
	tr();
	return true;
}
function generateNormalTime(z){
	return z[0]+"-"+(z[1]+1)+"-"+z[2]+" "+z[3]+":"+z[4]+":"+z[5];
}
// 