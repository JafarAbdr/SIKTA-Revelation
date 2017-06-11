function refreshKodeTA21(a){
	buttonLoaderFunctionFull({
		idC : "s-k-bimbingan",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 1
	});
	$('#seminar1form').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			
			if(returnResponse[0] ==  "="){
				window.location = base_url+"Gateinout.jsp";
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
		if(!failedInput(1,"FUJ 21 wajib dilampirkan")){
			return;
		}
		$("#seminar1form").trigger('submit');
	});
	$("#resetForm").on('click',function(){
		errorInFile({
			idC : "s-k-bimbingan",
			kodeValid : 1
		});
	});
}
function refreshKodeTA22(a){}
var ruangAktiveNow = 1;
var ruang1 = null;
var ruang2 = null;
var ruang3 = null;
var ruang4 = null;
var ruang1tanggal = null;
var ruang2tanggal = null;
var ruang3tanggal = null;
var ruang4tanggal = null;
function ruangActiveNowF(a){
	a = parseInt(a);
	switch(a){
		case 1 : ruangAktiveNow = 1; break;
		case 2 : ruangAktiveNow = 2; break;
		case 3 : ruangAktiveNow = 3; break;
		case 4 : ruangAktiveNow = 4; break;
	}
	//alert(ruangAktiveNow);
}
function refreshKodeTA23(a){
	if($(".accordion").length>0){
		$(".accordion").accordion({heightStyle:"content"});
		$(".accordion .ui-accordion-header:last").css("border-bottom","0px");
	}
	buttonLoaderFunctionFull({
		idC : "s-k-fuj20",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 1
	});
	buttonLoaderFunctionFull({
		idC : "s-k-fuj25",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 2
	});
	buttonLoaderFunctionFull({
		idC : "s-k-transkrip",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 3
	});
	buttonLoaderFunctionFull({
		idC : "s-k-toefl",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 4
	});
	buttonLoaderFunctionFull({
		idC : "s-k-krs",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 5
	});
	buttonLoaderFunctionFull({
		idC : "s-k-bimbingan",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 6
	});
	$('#seminar1form').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			
			if(returnResponse[0] ==  "="){
				window.location = base_url+"Gateinout.jsp";
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
		if(!failedInput(1,"FUJ 20 wajib dilampirkan")){
			return;
		}
		if(!failedInput(2,"FUJ 25 Wajib dilampirkan")){
			return;
		}
		if(!failedInput(3,"Transkrip nilai Wajib dilampirkan")){
			return;
		}
		if(!failedInput(4,"Hasil Toefl Wajib dilampirkan")){
			return;
		}
		if(!failedInput(5,"krs Wajib dilampirkan")){
			return;
		}
		if(!failedInput(6,"Kartu Bimbingan Wajib dilampirkan")){
			return;
		}
		if(CalenderOnSemTA2ID[ruangAktiveNow] == null){
			modalStaticSingleInformation("Peringatan",
			'<div class="panel panel-warning">'+
				'<div class="panel-heading">'+
					'<h3 class="panel-title">Mohon Perhatiannya.</h3>'+
				'</div>'+
				'<div class="panel-body"> Anda Harus memilih salah satu ruang yang tersedia, silahkan pilih dan ruang yang anda pilih adalah tidak boleh kosong. </div> <div class="panel-footer"></div> </div>');
			closeLoadingBar();
			return;
		}
		switch(ruangAktiveNow){
			case 1 : $("#s-k-ruangan").val("TA1"); $("#s-k-tanggal").val(CalenderOnSemTA2TANGGAL[ruangAktiveNow]+""); break;
			case 2 : $("#s-k-ruangan").val("TA2"); $("#s-k-tanggal").val(CalenderOnSemTA2TANGGAL[ruangAktiveNow]+""); break;
			case 3 : $("#s-k-ruangan").val("MAT"); $("#s-k-tanggal").val(CalenderOnSemTA2TANGGAL[ruangAktiveNow]+""); break;
			case 4 : $("#s-k-ruangan").val("PUS"); $("#s-k-tanggal").val(CalenderOnSemTA2TANGGAL[ruangAktiveNow]+""); break;
		}
		$("#seminar1form").trigger('submit');
	});
	$("#resetForm").on('click',function(){
		errorInFile({
			idC : "s-k-fuj20",
			kodeValid : 1
		});
		errorInFile({
			idC : "s-k-fuj25",
			kodeValid : 2
		});
		errorInFile({
			idC : "s-k-transkrip",
			kodeValid : 3
		});
		errorInFile({
			idC : "s-k-toefl",
			kodeValid : 4
		});
		errorInFile({
			idC : "s-k-krs",
			kodeValid : 5
		});
		errorInFile({
			idC : "s-k-bimbingan",
			kodeValid : 6
		});
		setTimeout(function(){
			$("#show-calendar-1").trigger('click');
			getNullOnCalender(1);
			setTimeout(function(){
				$("#show-calendar-2").trigger('click');
				getNullOnCalender(2);
				setTimeout(function(){
					$("#show-calendar-3").trigger('click');
					getNullOnCalender(3);
					setTimeout(function(){
						$("#show-calendar-4").trigger('click');
						getNullOnCalender(4);
					},500);
				},500);
			},500);
		},10);
	});
	setTimeout(function(){
		$("#show-calendar-1").trigger('click');
		createCalenderOn({
			id : "calendar-1",
			room : "TA1",
			kodeId : 1
		});
		setTimeout(function(){
			$("#show-calendar-2").trigger('click');
			createCalenderOn({
				id : "calendar-2",
				room : "TA2",
				kodeId : 2
			});
			setTimeout(function(){
				$("#show-calendar-3").trigger('click');
				createCalenderOn({
					id : "calendar-3",
					room : "MAT",
					kodeId : 3
				});				
				setTimeout(function(){
					$("#show-calendar-4").trigger('click');
					createCalenderOn({
						id : "calendar-4",
						room : "PUS",
						kodeId : 4
					});
					setTimeout(function(){
						getDataOnForCalendar();
					},500);
				},500);
			},500);
		},500);
	},10);
}
function refreshKodeTA24(a){}
function refreshKodeTA25(a){
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
	$("#resetForm").on('click',function(){
		errorInFile({
			idC : "s-k-bimbingan",
			kodeValid : 1
		});
		errorInFile({
			idC : "s-k-peserta",
			kodeValid : 2
		});
	});
	$('#seminar1form').submit(function(){
		iframe = $('#frame-layout').load(function (){
			response = iframe.contents().find('body');
			returnResponse = response.html();
			iframe.unbind('load');
			
			if(returnResponse[0] ==  "="){
				window.location = base_url+"Gateinout.jsp";
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
		if(!failedInput(1,"FUJ 22 wajib dilampirkan")){
			return;
		}
		if(!failedInput(2,"FUJ 23 wajib dilampirkan")){
			return;
		}
		$("#seminar1form").trigger('submit');
	});
}
function refreshKodeTA26(a){}
function SeminarTAD(a){
	kodeActive = a;
	switch(a[1]){
		case 'A' :
		refreshKodeTA21(a);
		break;
		case 'B' :
		refreshKodeTA22(a);
		break;
		case 'C' :
		refreshKodeTA23(a);
		break;
		case 'D' :
		refreshKodeTA24(a);
		break;
		case 'E' :
		refreshKodeTA25(a);
		break;
		case 'F' :
		refreshKodeTA26(a);
		break;
	}
}
var CalenderOnSemTA2 = [];
var CalenderOnSemTA2ID = [];
CalenderOnSemTA2ID[1] = null;
CalenderOnSemTA2ID[2] = null;
CalenderOnSemTA2ID[3] = null;
CalenderOnSemTA2ID[4] = null;
var CalenderOnSemTA2TANGGAL = [];
CalenderOnSemTA2TANGGAL[1] = null;
CalenderOnSemTA2TANGGAL[2] = null;
CalenderOnSemTA2TANGGAL[3] = null;
CalenderOnSemTA2TANGGAL[4] = null;
function getNullOnCalender(kode){
	if(CalenderOnSemTA2ID[kode] != null){
		CalenderOnSemTA2['calendar-'+kode].fullCalendar("removeEvents",CalenderOnSemTA2ID[kode]);
		CalenderOnSemTA2ID[kode] = null;
		CalenderOnSemTA2TANGGAL[kode] = null;
	}
}

/*
data.id, ["calendar-1","calender-2","calender-3","calender-4"]
data.room, ["TA1","TA2","PUS","MAT"]
data.kodeId [1,2,3,4]
*/
function getDataOnForCalendar(){
	openLoadingBar("get all list data seminar ta 1");
	j("#setAjax").setAjax({
		methode : "GET",
		bool : true,
		url :"Classseminartad/getJSONDataSeminarTA2.jsp",
		content : "",
		sucOk : function(a){
			if(a[0] ==  "="){
				window.location = base_url+"Gateinout.jsp";
			}else if(a[0] == "0"){
				setLoadingBarMessage("Refresh halaman ...");
			}else{
				setLoadingBarMessage("Data sedang diproses ...");
				jsonList = JSON.parse(a.substr(1,a.length-1));
				for(h=1;h<=jsonList.content;h++){
					$("#show-calendar-"+h).trigger('click');
					if(jsonList[h].kode){
						for(i=0;i<jsonList[h].lengths;i++){		
							var START_DAY = moment(jsonList[h][i].tanggal);
							var END_DAY = moment(jsonList[h][i].endTanggal);
							CalenderOnSemTA2["calendar-"+h].fullCalendar('renderEvent',{
								id: jsonList[h][i].namaAcara+"|"+jsonList[h][i].nama+"|"+jsonList[h][i].status,
								title: jsonList[h][i].namaAcara,
								start: START_DAY,
								end: END_DAY},true);
						}
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
function createCalenderOn(data){
	$("#"+data.id).html("");
	if($("#"+data.id).length>0){
		var e=new Date();
		var t=e.getDate();
		var n=e.getMonth();
		var r=e.getFullYear(); //2016
		$("#external-events .external-event").each(function(){
			var e={title:$.trim($(this).text())};$(this).data("eventObject",e);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0})});
		
		CalenderOnSemTA2[data.id] = $("#"+data.id).fullCalendar({
			header:{
				left:"prev,next today",
				center:"title",
				right : ""
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
						url:"Classseminartad/getCheck.jsp",
						bool : true,
						content: "variabel="+data.room+"&value="+TEMP_DATE_TIME,
						sucOk : function(a){
							if(a[0] ==  "="){
								window.location = base_url+"Gateinout.jsp";
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
								if(CalenderOnSemTA2ID[data.kodeId] == null){
									CalenderOnSemTA2ID[data.kodeId] = "aktifNow";	
									CalenderOnSemTA2[data.id].fullCalendar('renderEvent',{
										id:CalenderOnSemTA2ID[data.kodeId],
										title:"Seminar Ku",
										start: START_DAY,
										end: END_DAY,
										allDay:TEMP_N},true);
								}else{
									CalenderOnSemTA2[data.id].fullCalendar('removeEvents', CalenderOnSemTA2ID[data.kodeId]);
									CalenderOnSemTA2[data.id].fullCalendar('renderEvent',{
										id:CalenderOnSemTA2ID[data.kodeId],
										title:"Seminar Ku",
										start: START_DAY,
										end: END_DAY,
										allDay:TEMP_N},true);
								}
								CalenderOnSemTA2TANGGAL[data.kodeId] = TEMP_DATE_TIME;
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
				if(CalenderOnSemTA2ID[data.kodeId] != null){
					if(calEvent.id == CalenderOnSemTA2ID[data.kodeId])
						modalStaticMultipleButton("Anda ingin menghapus even ini ",function(){
							$("#s-tanggal").val("");
							$("s-ruang").val("");
							CalenderOnSemTA2[data.id].fullCalendar('removeEvents', calEvent.id);
							CalenderOnSemTA2TANGGAL[data.kodeId] = null;
							CalenderOnSemTA2ID[data.kodeId] = null;
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
	}
}





























































var pengantarButtonControlD=true;
var defaultpageclass = 1;
var RUANGIF=false;
var RUANGIFCHOOSE="";
var RUANGIFTIME=new Date();
var RUANGMATH=false;
var RUANGMATHCHOOSE="";
var RUANGMATHTIME=new Date(); 
var CalendersRev = {};
var TotalCalender = 0;
var idTanggalD = null;
var catTanggal = null;
var tanggalSewaRuangTA2;
var TEMP_ND;
var tanggalSewaRuangTA2_TEMP;
var tanggalSewaRuangDefault2; 
//alert("");
function inputFormSeinarta1danta2(){
	openLoadingBar("Memeriksa input ...");
	if(!failedInput(4,"kartu peserta wajib dilampirkan")){
		return;
	}
	if(!failedInput(5,"scan kartu bimbingan wajib dilampirkan")){
		return;
	}
	if(!failedInput(6,"transkrip wajib dilampirkan")){
		return;
	}
	if(pengantarButtonControlD){
		if(!failedInput(7,"Wajib melampirkan kartu pengantar")){
			return;
		}
	}
	if(defaultpageclass == 1){		
		if(!RUANGIF){
			setLoadingBarMessage("anda belum memilih ruang apa pun");
			setTimeout(function(){
				closeLoadingBar();
				return;
			},2000);
			return;
		}else{
			$("#s_tanggald").val(RUANGIFTIME);
			$("#s_ruangd").val(RUANGIFCHOOSE);
		}
	}else{
		//alert(RUANGMATH+" "+RUANGMATHCHOOSE+" "+RUANGMATHTIME);
		if(!RUANGMATH){
			setLoadingBarMessage("anda belum memilih ruang apa pun");
			setTimeout(function(){
				closeLoadingBar();
				return;
			},2000);
			return;
		}else{
			$("#s_tanggald").val(RUANGMATHTIME);
			$("#s_ruangd").val(RUANGMATHCHOOSE);
		}
	}
	//alert("sending data");
	$("#seminar2form").trigger('submit');
}
function resetFormSeminarTA1danTA2(){	
	
	errorInFile({
		idC : "s-k-pesertad",
		kodeValid : 4
	});
	errorInFile({
		idC : "s-k-bimbingand",
		kodeValid : 5
	});
	errorInFile({
		idC : "s-transkripd",
		kodeValid : 6
	});
	if(pengantarButtonControlD){		
		errorInFile({
			idC : "s-pengantard",
			kodeValid : 7
		});
	}
	$("#s-ruangd").val("");
	$("#s-tanggald").val("");
	$("#s-ruangmd").val("");
	$("#s-tanggalmd").val("");
	$("#ruang-ta-math").val("");
	RUANGMATH = false;
	RUANGMATHCHOOSE="";
	RUANGMATHTIME=new Date();
	if(idTanggalD != null){
		CalendersRev[catTanggal].fullCalendar('removeEvents', idTanggalD);
		catTanggal = "";
		idTanggalD = null;
		RUANGIF = false;
		RUANGIFCHOOSE ="";
		RUANGIFTIME=new Date();
	}
	$("#ruang-ta-math").val("");
	//SeminarTAD();
}

function generateTanggalMath(temp){
	z = temp.toArray();
	return z[0]+"/"+(z[1]+1)+"/"+z[2]+" "+z[3]+":"+z[4];
}
function validasiTanggal(DATA){
	if(DATA.now == null){
		DATA.no(moment());
		return;
	}
	var TEMP_DATE_TIME = DATA.now.toArray();
	var TEMP_DATE_COMPARATOR = null;
	if(DATA.min != null){
		var ERROR = false;
		TEMP_DATE_COMPARATOR = DATA.min.toArray();
		if(TEMP_DATE_TIME[0] < TEMP_DATE_COMPARATOR[0]){
			ERROR = true;
		}else if(TEMP_DATE_TIME[0] == TEMP_DATE_COMPARATOR[0]){
			if(TEMP_DATE_TIME[1] < TEMP_DATE_COMPARATOR[1]){
				ERROR = true;
			}else if(TEMP_DATE_TIME[1] == TEMP_DATE_COMPARATOR[1]){
				if(TEMP_DATE_TIME[2] < TEMP_DATE_COMPARATOR[2]+1){
					ERROR=true;
				}
			}
		}
		if(ERROR){
			DATA.no(DATA.min);
			return;
		}
	}
	if(DATA.max != null){
		TEMP_DATE_COMPARATOR = DATA.max.toArray();
		var ERROR = false;
		if(TEMP_DATE_TIME[0] > TEMP_DATE_COMPARATOR[0]){
			ERROR = true;
		}else if(TEMP_DATE_TIME[0] == TEMP_DATE_COMPARATOR[0]){
			if(TEMP_DATE_TIME[1]+1 > TEMP_DATE_COMPARATOR[1]+1){
				ERROR = true;
			}else if(TEMP_DATE_TIME[1]+1 == TEMP_DATE_COMPARATOR[1]+1){
				if(TEMP_DATE_TIME[2] > TEMP_DATE_COMPARATOR[2]){
					ERROR=true;
				}
			}
		}
		if(ERROR){
			DATA.no(DATA.max);
			return;
		}
	}
	DATA.yes(DATA.now);
	return;
}
/*
DATA->
->ID
->KEY
*/
function rebuildCalenderStillGetOne(DATA){
	var valueTotalCalendar = TotalCalender;
	if($("#"+DATA.ID).length>0){
		var e=new Date();
		var t=e.getDate();
		var n=e.getMonth();
		var r=e.getFullYear(); //2016
		$("#external-events .external-event").each(function(){
			var e={title:$.trim($(this).text())};$(this).data("eventObject",e);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0})});
		
		CalendersRev[DATA.ID] = $("#"+DATA.ID).fullCalendar({
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
				TEMP_ND = n;
				tanggalSewaRuangTA2_TEMP = moment(e);
				tanggalSewaRuangTAStart_TEMP = moment(e);
				tanggalSewaRuangTAEnd_TEMP = moment(e);
				
				//alert(tanggalSewaRuangTA1_TEMP.toISOString());
				modalStaticBodyMultipleButton("Masukan Jam Seminar anda",templateCalendarTAS,function(finalis){
					openLoadingBar("Validasi tanggal dan jam ...");
					var TEMP_DATE_TIME = moment("0000-00-00 "+$("#jam-rung-tas").val());
					//alert($("#jam-rung-tas").val());
					tanggalSewaRuangTA2_TEMP.hour(TEMP_DATE_TIME.hours());
					tanggalSewaRuangTAStart_TEMP.hour(TEMP_DATE_TIME.hours());
					tanggalSewaRuangTAEnd_TEMP.hour(TEMP_DATE_TIME.hours());
					tanggalSewaRuangTA2_TEMP.minute(TEMP_DATE_TIME.minutes());
					tanggalSewaRuangTAStart_TEMP.minute(TEMP_DATE_TIME.minutes());
					tanggalSewaRuangTAEnd_TEMP.minute(TEMP_DATE_TIME.minutes());
					
					//tanggalSewaRuangTA2_TEMP.minute(tanggalSewaRuangTA2_TEMP.minute()-30);
					TEMP_DATE_TIME = tanggalSewaRuangTA2_TEMP.toArray();
					//console.log(tanggalSewaRuangTA1_TEMP.toArray());
					//alert(tanggalSewaRuangTA1_TEMP.toISOString());
					TEMP_DATE_TIME = generateNormalTime(TEMP_DATE_TIME);
					//alert(TEMP_DATE_TIME);
					j("#ajax").setAjax({
						methode: "POST",
						url:"Classseminartad/getCheck.jsp",
						bool : true,
						content: "variabel="+DATA.KEY+"&value="+TEMP_DATE_TIME,
						sucOk : function(a){
							//alert(a);
							if(parseInt(a[0]) ==  9){
								$(location).attr('href',a.substr(1,a.length-1));
							}else if(parseInt(a[0]) ==  1){
								setLoadingBarMessage(a.substr(1,a.length-1)+" ...");
								var START_DAY = tanggalSewaRuangTAStart_TEMP;
								var END_DAY = tanggalSewaRuangTAEnd_TEMP;
								END_DAY.minutes(END_DAY.minutes()+30);
								if(END_DAY.minutes > 59){
									END_DAY.minutes(END_DAY.minutes()-59);
									END_DAY.hours(END_DAY.hours()+1);
								}
								tanggalSewaRuangDefault2 = false;
								RUANGIF = true;
								RUANGIFCHOOSE = DATA.KEY;
								RUANGIFTIME = generateNormalTime(tanggalSewaRuangTA2_TEMP.toArray());
								
								//alert(RUANGIFTIME);
								if(idTanggalD == null){
									idTanggalD = "aktifNow";	
									catTanggal = DATA.ID;
									CalendersRev[DATA.ID].fullCalendar('renderEvent',{
										id:idTanggalD,
										title:"Seminar Ku",
										start: START_DAY,
										end: END_DAY,
										allDay:TEMP_N},true);
								}else{
									CalendersRev[catTanggal].fullCalendar('removeEvents', idTanggalD);
									catTanggal = DATA.ID;
									CalendersRev[DATA.ID].fullCalendar('renderEvent',{
										id:idTanggalD,
										title:"Seminar Ku",
										start: START_DAY,
										end: END_DAY,
										allDay:TEMP_N},true);
								}
								//insert ruang
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
				
				var wkwk2 = moment(calEvent.end);
				
				if(idTanggalD != null){
					if(calEvent.id == idTanggalD)
						modalStaticMultipleButton("Anda ingin menghapus even ini ",function(){
							CalendersRev[DATA.ID].fullCalendar('removeEvents', calEvent.id);
							tanggalSewaRuangDefault = false;
							idTanggalD = null;
							catTanggal = null;
							RUANGIF = false;
							RUANGIFCHOOSE = "";
							RUANGIFTIME = new Date();
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
								wkwk.format("dddd, MMMM Do YYYY, HH:mm:ss")+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Berakhir"+
							"</td>"+
							"<td>"+
								wkwk2.format("dddd, MMMM Do YYYY, HH:mm:ss")+" WIB"+
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
								wkwk.format("dddd, MMMM Do YYYY, HH:mm:ss")+" WIB"+
							"</td>"+
						"</tr>"+
						"<tr>"+
							"<td style='width : 25%; padding-left : 10px;'>"+
								"Berakhir"+
							"</td>"+
							"<td>"+
								wkwk2.format("dddd, MMMM Do YYYY, HH:mm:ss")+" WIB"+
							"</td>"+
						"</tr>"+
					 "</table>"
					 );
				}
			}
		});
		TotalCalender += 1;
	}
}