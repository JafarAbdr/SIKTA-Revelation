var tanggalSewaRuangTA1;
var TEMP_N;
var tanggalSewaRuangTA1_TEMP;
var tanggalSewaRuangDefault;
var uploadFileState = {
	satu : false,
	dua : false,
	tiga : false,
	empat : false
}
var idTanggal = null;
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
var pengantarButtonControl;
function SeminarTAS(a){
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
	});
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
	buttonLoaderFunctionFull({
		idC : "s-transkrip",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 2
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
/*
array
data 
->idC
->size
->regexC
->messageFalse
->data.kodeValid

*/
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
var Calenders;
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
				//alert(e);
				TEMP_N = n;
				tanggalSewaRuangTA1_TEMP = moment(e);
				//alert(tanggalSewaRuangTA1_TEMP.toISOString());
				modalStaticBodyMultipleButton("Masukan Jam Seminar anda",templateCalendarTAS,function(finalis){
					openLoadingBar("Validasi tanggal dan jam ...");
					var TEMP_DATE_TIME = moment("0000-00-00T"+$("#jam-rung-tas").val());
					//alert($("#jam-rung-tas").val());
					tanggalSewaRuangTA1_TEMP.hour(TEMP_DATE_TIME.hours());
					tanggalSewaRuangTA1_TEMP.minute(TEMP_DATE_TIME.minutes());
					tanggalSewaRuangTA1_TEMP.minute(tanggalSewaRuangTA1_TEMP.minute()-30);
					TEMP_DATE_TIME = tanggalSewaRuangTA1_TEMP.toArray();
					//console.log(tanggalSewaRuangTA1_TEMP.toArray());
					//alert(tanggalSewaRuangTA1_TEMP.toISOString());
					TEMP_DATE_TIME = generateNormalTime(TEMP_DATE_TIME);
					//alert(TEMP_DATE_TIME);
					j("#ajax").setAjax({
						methode: "POST",
						url:"Classseminartas/getCheck.aspx",
						bool : true,
						content: "variabel=TA1&value="+TEMP_DATE_TIME,
						sucOk : function(a){
							//alert(a);
							if(parseInt(a[0]) ==  9){
								$(location).attr('href',a.substr(1,a.length-1));
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
								STSTTS = START_DAY.toArray();
								STSTTS = generateNormalTime(STSTTS);
								//alert(STSTTS);
								$('#s_tanggal').val(STSTTS);
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
					//= moment();
					/*
					Calenders.fullCalendar("renderEvent",{
						title:"koklllloko",
						start:tanggalSewaRuangTA1_TEMP,
						end:tanggalSewaRuangTA1_TEMP,
						allDay:TEMP_N},true);
						finalis(true);
						*/
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
			//	update Event
		    /*
			eventClick: function(calEvent, jsEvent, view) {
				modalStaticMultipleButton(message,a);
				$('#calendar').fullCalendar('removeEvents', event.id);
		   	}
			*/
			eventClick: function(calEvent, jsEvent, view) {
				var wkwk = moment(calEvent.start);
				wkwk = wkwk.toArray();
				var wkwk2 = moment(calEvent.start);
				wkwk2.minute(wkwk2.minute()+30);
				wkwk2.hour(wkwk2.hour()+2);
				wkwk2 = wkwk2.toArray();
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
						 modalStaticSingleInformation("Pelaku seminar TA ",
					 "<table style='width : 100%;'>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Nama"+
							"</td>"+
							"<td style='width : 75%;'>"+
								calEvent.title+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Mulai"+
							"</td>"+
							"<td>"+
								"Pukul "+wkwk[3]+":"+wkwk[4]+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Berakhir"+
							"</td>"+
							"<td>"+
								"Pukul "+wkwk2[3]+":"+wkwk2[4]+" WIB"+
							"</td>"+
						"</tr>"+
					 "</table>"
					 );
					}
						
				}else{
					 modalStaticSingleInformation("Pelaku seminar TA ",
					 "<table style='width : 100%;'>"+
						"<tr >"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Nama"+
							"</td>"+
							"<td style='width : 75%;'>"+
								calEvent.title+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Mulai"+
							"</td>"+
							"<td>"+
								"Pukul "+wkwk[3]+":"+wkwk[4]+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Berakhir"+
							"</td>"+
							"<td>"+
								"Pukul "+wkwk2[3]+":"+wkwk2[4]+" WIB"+
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
			url :"Classseminartas/getJSONDataSeminarTA1.aspx",
			content : "",
			sucOk : function(a){
				if(parseInt(a[0]) ==  9){
					$(location).attr('href',a.substr(1,a.length-1));
				}else if(a[0] == "0"){
					setLoadingBarMessage("Refresh halaman ...");
				}else{
					setLoadingBarMessage("Data sedang diproses ...");
					jsonList = JSON.parse(a.substr(1,a.length-1));
					if(jsonList.kode){
						for(i=0;i<jsonList.content;i++){		
							var START_DAY = moment(jsonList[i].tanggal);
							var END_DAY = START_DAY;
							END_DAY.minutes(END_DAY.minutes()+30);
							if(END_DAY.minutes > 59){
								END_DAY.minutes(END_DAY.minutes()-59);
								END_DAY.hours(END_DAY.hours());
							}
							Calenders.fullCalendar('renderEvent',{
								title: jsonList[i].nama,
								start: START_DAY,
								end: END_DAY},true);
						}
					}
				}
				setTimeout(function(){
					closeLoadingBar();
					//reloadTable();
				},2000);	
			},
			sucEr : function(a,b){
				template(a,b,"get all table");
			}
		});
	}
}
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