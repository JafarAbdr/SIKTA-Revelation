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

function SeminarTAD(a){
	//alert(moment().toArray()+"=||="+moment("15/5/2016 12:17","DD/MM/YYYY H:m").toArray());
	if(a == '3')
		return;
	if(a=='2')
		pengantarButtonControlD=false;
	$("#masukan-data-seminar-ta2").on('click',function(){
		inputFormSeinarta1danta2();
	});
	$("#reset-data-seminar-ta2").on('click',function(){
		resetFormSeminarTA1danTA2();
		
	});
	$("#lingk-inf").on('click',function(){
		defaultpageclass = 1;
	});
	resetFormSeminarTA1danTA2();
	$("#lingk-math").on('click',function(){
		defaultpageclass = 2;
	});
	buttonLoaderFunctionFull({
		idC : "s-k-pesertad",
		size : 1,
		regexC : "png",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.png)",
		kodeValid : 4
	});
	buttonLoaderFunctionFull({
		idC : "s-k-bimbingand",
		size : 1,
		regexC : "png",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.png)",
		kodeValid : 5
	});
	buttonLoaderFunctionFull({
		idC : "s-transkripd",
		size : 1,
		regexC : "pdf",
		messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
		kodeValid : 6
	});
	if(pengantarButtonControlD){	
		buttonLoaderFunctionFull({
			idC : "s-pengantard",
			size : 1,
			regexC : "pdf",
			messageFalse : "Ukuran file maksimal 1 mb, dan format file yang didukung (.pdf)",
			kodeValid : 7
		});	
	}
	 
	rebuildCalenderStillGetOne({
		ID : "calendar-ta-1",
		KEY : "TA1"
	});
	rebuildCalenderStillGetOne({
		ID : "calendar-ta-2",
		KEY : "TA2"
	});
	$('#seminar2form').submit(function(){
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
	if($("#ruang-ta-math").length>0) $("#ruang-ta-math").datetimepicker({nextText:"",prevText:"",dateFormat:"yy-m-d"});
	$("#ruang-ta-math").on("change",function(){
		//openLoadingBar("Check data tanggal ...");
//setLoadingBarMessage("data "+$("#ruang-ta-math").val()+" on form = "+moment($("#ruang-ta-math").val()).toArray()+" :now = "+moment().toArray());	
		var kks = moment($("#ruang-ta-math").val()).toArray();
		var ERROR = 0;
		for(var ii=0;ii<6;ii++){
			if(isNaN(kks[ii]))
				ERROR += 1;
		}
		if(ERROR == 0){
			validasiTanggal({
				now : moment($(this).val()),
				min : moment(),
				max : null,
				yes : function(a){
					//alert('true');
					RUANGMATH = true;
					RUANGMATHCHOOSE = "MAT";
					RUANGMATHTIME = generateNormalTime(a.toArray());
					//setLoadingBarMessage("data valid ...");
					//setTimeout(function(){closeLoadingBar();},1000);
				},
				no : function(a){
					var ss = a.toArray();
					$("#ruang-ta-math").val(ss[0]+"-"+(ss[1]+1)+"-"+ss[2]+" "+ss[3]+":"+ss[4]);
					RUANGMATH = false;
					RUANGMATHCHOOSE = "";
					RUANGMATHTIME = generateNormalTime(a.toArray());
					//setLoadingBarMessage("data tidak valid ...");
					//setTimeout(function(){closeLoadingBar();},1000);
				}
			});
		}else{
			kks=moment().toArray();
			$(this).val(kks[0]+"-"+(kks[1]+1)+"-"+kks[2]+" "+kks[3]+":"+kks[4]);
		}

		
		//alert(TEMP_DATE_TIME.toISOString());
		//alert(generateNormalTime(moment().toArray()));
	});
	$("#ruang-ta-math").on("keypress",function(){
		var kks = moment($("#ruang-ta-math").val()).toArray();
		var ERROR = 0;
		for(var ii=0;ii<6;ii++){
			if(isNaN(kks[ii]))
				ERROR += 1;
		}
		if(ERROR == 0){
			validasiTanggal({
				now : moment($(this).val()),
				min : moment(),
				max : null,
				yes : function(a){
					//alert('true');
					RUANGMATH = true;
					RUANGMATHCHOOSE = "MAT";
					RUANGMATHTIME = generateNormalTime(a.toArray());
					//setLoadingBarMessage("data valid ...");
					//setTimeout(function(){closeLoadingBar();},1000);
				},
				no : function(a){
					var ss = a.toArray();
					$("#ruang-ta-math").val(ss[0]+"-"+(ss[1]+1)+"-"+ss[2]+" "+ss[3]+":"+ss[4]);
					RUANGMATH = false;
					RUANGMATHCHOOSE = "";
					RUANGMATHTIME = generateNormalTime(a.toArray());
					//setLoadingBarMessage("data tidak valid ...");
					//setTimeout(function(){closeLoadingBar();},1000);
				}
			});
		}else{
			kks=moment().toArray();
			$(this).val(kks[0]+"-"+(kks[1]+1)+"-"+kks[2]+" "+kks[3]+":"+kks[4]);
		}
	});
	$("#ruang-ta-math").on("blur",function(){
		var kks = moment($("#ruang-ta-math").val()).toArray();
		var ERROR = 0;
		for(var ii=0;ii<6;ii++){
			if(isNaN(kks[ii]))
				ERROR += 1;
		}
		if(ERROR == 0){
			validasiTanggal({
				now : moment($(this).val()),
				min : moment(),
				max : null,
				yes : function(a){
					//alert('true');
					RUANGMATH = true;
					RUANGMATHCHOOSE = "MAT";
					RUANGMATHTIME = generateNormalTime(a.toArray());
					//setLoadingBarMessage("data valid ...");
					//setTimeout(function(){closeLoadingBar();},1000);
				},
				no : function(a){
					var ss = a.toArray();
					$("#ruang-ta-math").val(ss[0]+"-"+(ss[1]+1)+"-"+ss[2]+" "+ss[3]+":"+ss[4]);
					RUANGMATH = false;
					RUANGMATHCHOOSE = "";
					RUANGMATHTIME = generateNormalTime(a.toArray());
					//setLoadingBarMessage("data tidak valid ...");
					//setTimeout(function(){closeLoadingBar();},1000);
				}
			});
		}else{
			kks=moment().toArray();
			$(this).val(kks[0]+"-"+(kks[1]+1)+"-"+kks[2]+" "+kks[3]+":"+kks[4]);
		}
	});
	
	openLoadingBar("get all list data seminar ta 1");
	j("#setAjax").setAjax({
		methode : "GET",
		bool : true,
		url :"Classseminartad/getJSONDataSeminarTA1AndTA2.aspx",
		content : "",
		sucOk : function(a){
			//alert(a);
			if(parseInt(a[0]) ==  9){
				$(location).attr('href',a.substr(1,a.length-1));
			}else if(a[0] == "0"){
				setLoadingBarMessage("Refresh halaman ...");
			}else{
				setLoadingBarMessage("Data sedang diproses ...");
				jsonData = JSON.parse(a.substr(1,a.length-1));
				jsonList = jsonData[1];
				if(jsonList.kode){
					for(i=0;i<jsonList.content;i++){		
						var START_DAY = moment(jsonList[i].tanggal);
						var END_DAY = moment(jsonList[i].endTanggal);
						CalendersRev['calendar-ta-1'].fullCalendar('renderEvent',{
							title: jsonList[i].nama,
							start: START_DAY,
							end: END_DAY},true);
					}
				}
				jsonList = jsonData[2];
				if(jsonList.kode){
					for(i=0;i<jsonList.content;i++){		
						var START_DAY = moment(jsonList[i].tanggal);
						var END_DAY = moment(jsonList[i].endTanggal);
						CalendersRev['calendar-ta-2'].fullCalendar('renderEvent',{
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
						url:"Classseminartad/getCheck.aspx",
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