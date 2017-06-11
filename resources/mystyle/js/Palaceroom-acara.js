function acaraAkademikFullArea(){
	reloadTableRuangTa1();
	reloadTableRuang();
}
function reloadTableRuang(){
	$("#lingk-TA2").on("click",function(){
		if(table2){
			reloadTableRuangTa2();
			table2 = false;
			table1 = true;
			table3 = true;
			table4 = true;
		}
	});
	$("#lingk-TA1").on("click",function(){
		if(table1){
			reloadTableRuangTa1();
			table1 = false;
			table2 = true;
			table3 = true;
			table4 = true;
		}
	});
	$("#lingk-TAM").on("click",function(){
		if(table3){
			reloadTableRuangTaM();
			table3 = false;
			table1 = true;
			table2 = true;
			table4 = true;
		}
	});
	$("#lingk-PUS").on("click",function(){
		if(table4){
			reloadTableRuangPus();
			table4 = false;
			table1 = true;
			table2 = true;
			table3 = true;
		}
	});
}
var table4  = true;
var table3  = true;
var table2  = true;
var table1  = false;
function reloadTableRuangTaM(){
	$("#calendar-ta-m").html("");
	setTimeout(function(){	
		rebuildCalenderStillGetOne({
			ID : "calendar-ta-m",
			KEY : "TAM"
		});
		setTimeout(function(){
			reloadDataTableCalender({
				idCalender : "calendar-ta-m",
				title : "update calender 3",
				urlpostfix : "getJSONAcaraRuangTAM",
				
			})
		},1000);
	},500);
}
function reloadTableRuangPus(){
	$("#calendar-pu-s").html("");
	setTimeout(function(){	
		rebuildCalenderStillGetOne({
			ID : "calendar-pu-s",
			KEY : "PUS"
		});
		setTimeout(function(){
			reloadDataTableCalender({
				idCalender : "calendar-pu-s",
				title : "update calender 4",
				urlpostfix : "getJSONAcaraRuangPUS",
				
			})
		},1000);
	},500);
}
function reloadTableRuangTa1(){
	$("#calendar-ta-1").html("");
	setTimeout(function(){	
		rebuildCalenderStillGetOne({
			ID : "calendar-ta-1",
			KEY : "TA1"
		});
		setTimeout(function(){
			reloadDataTableCalender({
				idCalender : "calendar-ta-1",
				title : "update calender 1",
				urlpostfix : "getJSONAcaraRuangTA1",
				
			})
		},1000);
	},500);
}
function reloadTableRuangTa2(){
	$("#calendar-ta-2").html("");
	setTimeout(function(){		
		rebuildCalenderStillGetOne({
			ID : "calendar-ta-2",
			KEY : "TA2"
		});
		setTimeout(function(){
			reloadDataTableCalender({
				idCalender : "calendar-ta-2",
				title : "update calender 2",
				urlpostfix : "getJSONAcaraRuangTA2",
				
			})
		},1000);
	},500);
}
/*
DATA.title
DATA.urlpostfix
DATA.idCalender
*/
var tempIDListTable = [];
function reloadDataTableCalender(DATA){
	openLoadingBar("memperoleh data "+DATA.title);
	j("#setAjax").setAjax({
		methode : "GET",
		bool : true,
		url :base_url+"Palaceareaacara/"+DATA.urlpostfix+".jsp",
		content : "",
		sucOk : function(a){
			//alert(a);
			if(parseInt(a[0]) ==  3){
				$(location).attr('href', base_url+a.substr(1,a.length-1));
			}else if(a[0] == "0"){
				setLoadingBarMessage("Refresh halaman ...");
			}else{
				setLoadingBarMessage("Data sedang diproses ...");
				
				jsonList = JSON.parse(a.substr(1,a.length-1));
				if(jsonList.kode){
					for(i=0;i<jsonList.content;i++){		
						var START_DAY = moment(jsonList[i].tanggal);
						//alert(START_DAY.toArray());
						var END_DAY = moment(jsonList[i].endTanggal);
						//END_DAY.hour(END_DAY.hour()+2);
						//END_DAY.minute(END_DAY.minute()+30);
						//CalendersRev[kodeCalenderActive].fullCalendar('removeEvent',kodeSeminarTanggalShare);
						if(jsonList[i].id.substr(0,2) == "TD"){
							tempIDListTable[jsonList[i].id] = [];
							tempIDListTable[jsonList[i].id]['ketua'] = jsonList[i].ketua;
							tempIDListTable[jsonList[i].id]['pengujis'] = jsonList[i].pengujis;
							tempIDListTable[jsonList[i].id]['pengujid'] = jsonList[i].pengujid;
							tempIDListTable[jsonList[i].id]['pengujit'] = jsonList[i].pengujit;
						}
						CalendersRev[DATA.idCalender].fullCalendar('renderEvent',{
							title: jsonList[i].nama,
							start: START_DAY,
							id : jsonList[i].id,
							end: END_DAY},true);
					}
				}
			}
			setTimeout(function(){
				closeLoadingBar();
				//reloadTable();
			},400);	
		},
		sucEr : function(a,b){
			template(a,b,"get all table");
		}
	});
}
var TotalCalender = 0;
var CalendersRev = [];
var nGlobal=null;
var dateGlobal=null;
var templateCalendarTAS2 = 
	'<div style=" color:#333333;">'+
		'<div class=form-row> '+
			'<div class=col-md-3>Nama acara : </div> '+
			'<div class=col-md-9> '+
				'<input id="add-acara-title" type="username" placeholder="Masukan judul acara anda(maksimal 250 karakter)" max="250" style="width : 100%;">'+			
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>Penanggung jawab : </div> '+
			'<div class=col-md-9> '+
				'<input id="add-acara-penanggung" type="username" placeholder="Penanggung jawab acara (maksimal 70 karakter)" max="70"  style="width : 100%;">'+
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>Mulai acara : </div> '+
			'<div class=col-md-9> '+
				'<div class=input-group> '+
					'<div class=input-group-addon>'+
						'<span class=icon-time></span>'+
					'</div> '+
					'<input id="add-jam-mulai" type=text class="timepicker form-control" value="12:17"/> '+
				'</div>'+ 
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>Berakir acara : </div> '+
			'<div class=col-md-9> '+
				'<div class=input-group> '+
					'<div class=input-group-addon>'+
						'<span class=icon-time></span>'+
					'</div> '+
					'<input id="add-jam-berakhir" type=text class="timepicker form-control" value="12:17"/> '+
				'</div>'+ 
			'</div>'+ 
		'</div>'+
		'<div>'+
		'<h6 style="font-size : 0.8em;">*Silahkan masukan sesuai dengan kondisi yang berlaku</h6>'+
		'</div>'+
	'</div>'
;
var templateCalendarTAS = 
	'<div style=" color:#333333;">'+
		'<div class=form-row> '+
			'<div class=col-md-3>Nama acara : </div> '+
			'<div class=col-md-9> '+
				'<input id="acara-title" type="username" placeholder="Masukan judul acara anda(maksimal 250 karakter)" max="250" style="width : 100%;">'+			
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>Penanggung jawab : </div> '+
			'<div class=col-md-9> '+
				'<input id="acara-penanggung" type="username" placeholder="Penanggung jawab acara (maksimal 70 karakter)" max="70"  style="width : 100%;">'+
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>Mulai acara : </div> '+
			'<div class=col-md-9> '+
				'<div class=input-group> '+
					'<div class=input-group-addon>'+
						'<span class=icon-time></span>'+
					'</div> '+
					'<input id="jam-mulai" type=text class="timepicker form-control" value="12:17"/> '+
				'</div>'+ 
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>Berakir acara : </div> '+
			'<div class=col-md-9> '+
				'<div class=input-group> '+
					'<div class=input-group-addon>'+
						'<span class=icon-time></span>'+
					'</div> '+
					'<input id="jam-berakhir" type=text class="timepicker form-control" value="12:17"/> '+
				'</div>'+ 
			'</div>'+ 
		'</div>'+
		'<div>'+
		'<h6 style="font-size : 0.8em;">*Silahkan masukan sesuai dengan kondisi yang berlaku</h6>'+
		'</div>'+
	'</div>'
;
var templateCalendarTADKode = 
		'<div class=form-row> '+
			'<div class=col-md-3>No Surat Undangan : </div> '+
			'<div class=col-md-9> '+
				'<input id="nosuratundangan" type="kode" placeholder="No Surat Undangan" max="70" style="width : 100%;">'+			
			'</div>'+ 
		'</div>'+
		'<div class=form-row> '+
			'<div class=col-md-3>No Surat Tugas : </div> '+
			'<div class=col-md-9> '+
				'<input id="nosurattugas" type="username" placeholder="No SUrat Tugas " max="70"  style="width : 100%;">'+
			'</div>'+ 
		'</div>'
;
var templateCalendarTASKode = 
		'<div class=form-row> '+
			'<div class=col-md-3>No Surat Undangan : </div> '+
			'<div class=col-md-9> '+
				'<input id="nosuratundangan" type="kode" placeholder="No Surat Undangan" max="70" style="width : 100%;">'+			
			'</div>'+ 
		'</div>'
;
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
				var key = DATA.KEY;
				nGlobal = n;
				dateGlobal = e;
				if(moment(e).isBefore(new Date())){
					modalStaticSingleInformation("Peringatan ",
					 "<div style='padding : 10px; font-family : arial; font-size : 10pt;'>Anda tidak dapat menambahkan acara pada waku yang telah lewat.</div>"
					 );
				}else{
					modalStaticBodyMultipleButton("Data Acara baru",templateCalendarTAS2,function(finalis){
						openLoadingBar("Validasi tanggal dan jam ...");
						var TEMP_DATE_TIME_START = moment("0000-00-00 "+$("#add-jam-mulai").val());
						var TEMP_DATE_TIME_END = moment("0000-00-00 "+$("#add-jam-berakhir").val());
						//alert($("#jam-rung-tas").val());
						var TEMP_START = moment(dateGlobal);
						var TEMP_END = moment(dateGlobal);
						TEMP_START.hour(TEMP_DATE_TIME_START.hours());
						TEMP_END.hour(TEMP_DATE_TIME_END.hours());
						TEMP_START.minute(TEMP_DATE_TIME_START.minutes());
						TEMP_END.minute(TEMP_DATE_TIME_END.minutes());
						TEMP_END.seconds(TEMP_DATE_TIME_END.seconds());
						TEMP_START.seconds(TEMP_DATE_TIME_START.seconds());
						//tanggalSewaRuangTA2_TEMP.minute(tanggalSewaRuangTA2_TEMP.minute()-30);
						//TEMP_DATE_TIME = tanggalSewaRuangTA2_TEMP.toArray();
						//console.log(tanggalSewaRuangTA1_TEMP.toArray());
						//alert(tanggalSewaRuangTA1_TEMP.toISOString());
						//TEMP_DATE_TIME = generateNormalTime(TEMP_DATE_TIME);
						//alert(TEMP_DATE_TIME);
						j("#setAjax").setAjax({
							methode: "POST",
							url:base_url+"Palaceareaacara/setNewAcara.jsp",
							bool : true,
							content: "kode="+DATA.KEY+"&namaAcara="+$("#add-acara-title").val()+"&penanggung="+$("#add-acara-penanggung").val()+"&startEvent="+generateNormalTime(TEMP_START.toArray())+"&endEvent="+generateNormalTime(TEMP_END.toArray()),
							sucOk : function(a){
								//alert(a);
								if(parseInt(a[0]) ==  3){
									$(location).attr('href', base_url+a.substr(1,a.length-1));
								}else if(parseInt(a[0]) ==  1){
									a=a.split("|");
									setLoadingBarMessage(a[0].substr(1,a[0].length-1)+" ...");
									var z=TEMP_START.toArray();
									var kode = 1;
									switch(DATA.KEY){
										case 'TA1' : kode = 1; break;
										case 'TA2' : kode = 2; break;
									}
									$year = z[0]; 
									$month = z[1]+1; 
									
									//alert("AC"+kodex+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode);
									//alert("AC"+a[1]+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode);
									CalendersRev[DATA.ID].fullCalendar('renderEvent',{
										id:"AC"+a[1]+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode,
										title: $("#add-acara-title").val(),
										start: TEMP_START,
										end: TEMP_END,
										allDay:nGlobal},true);
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
						$('#add-jam-mulai').on('blur', function(){
							getCheckJam("add-jam-mulai",$(this).val(),function(){
								$('#add-jam-mulai').css({
									"borderColor" : "green",
								});
								
							},function(){
								$('#add-jam-mulai').css({
									"borderColor" : "red",
								});
								var TEMP_DATE = new Date();
								$("#add-jam-mulai").val(TEMP_DATE.getHours()+":"+TEMP_DATE.getMinutes());
								$('#add-jam-mulai').css({
									"borderColor" : "green",
								});
							});
						});
						$('#add-jam-berakhir').on('blur', function(){
							getCheckJam("add-jam-berakhir",$(this).val(),function(){
								$('#add-jam-berakhir').css({
									"borderColor" : "green",
								});
							},function(){
								$('#add-jam-berakhir').css({
									"borderColor" : "red",
								});
								var TEMP_DATE = new Date();
								$("#add-jam-berakhir").val(TEMP_DATE.getHours()+":"+TEMP_DATE.getMinutes());
								$('#add-jam-berakhir').css({
									"borderColor" : "green",
								});
							});
						});
					});
				}
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
				kodeSeminarTanggalShare = calEvent;
				kodeCalenderActive = DATA.ID;
				//alert(kodeCalenderActive);
				var wkwk = moment(calEvent.start);
				//wkwk = wkwk.toArray();
				var wkwk2 = moment(calEvent.end);
				//wkwk2 = wkwk2.toArray();
				var neutral = moment();
				var buttonTolak = "";
				if(calEvent.id.substr(0,2) == "TS"){
					buttonTolak += 
						"<div>"+
						"<span class='icon-print' onclick='getNoSuratTAS("+'"ta1"'+").setA("+'"'+calEvent.id+'"'+").showNoSurat()' style='color : green; cursor : pointer;' title='print surat ketua'>&nbsp;Undangan</span>"+
						"</div>";
					 modalStaticSingleInformation("Pelaku seminar TA 1 ",
					 "<div style='width : 100%;'>"+
						"<div id='ta1-content-succes-delete'  style='display : none;'>"+
							"<div>"+
								'<div class="panel panel-success"> <div class="panel-heading"> <h3 class="panel-title">Pemberitahuan</h3> </div> <div class="panel-body"> Data seminar berhasil di tolak </div> <div class="panel-footer"></div> </div>'+
							"</div>"+
						"</div>"+
						"<div id='ta1-content-pdf'  style='display : none;'>"+
							"<div  onclick='alertSeminarDate("+'"ta1"'+").showBase();' style='position : absolute; width : 45px;margin-top : 10px; cursor : pointer; margin-left : 10px; height 45px; text-align : center; border-radius : 45px; background-color : black; '>"+
								"<i  style='font-size : 14px; color : white; line-height : 45px;' class='icon-arrow-left'></i>"+
							"</div>"+
							"<div>"+
								"<iframe id='ta1-pdf' style='width : 100%; min-height : 500px;'></iframe>"+
							"</div>"+
						"</div>"+
						"<div id='ta1-content-edit' style='display : none; height : 145px;'>"+
							"<div>"+
								templateCalendarTASKode+
								"<div class=form-row>"+
									"<div class='col-md-6' style='text-align : center;'>"+
										"<button class='btn btn-success btn-clean'  onclick='getNoSuratTAS("+'"ta1"'+").printThisSurat()'>print</button>"+
									"</div>"+
									"<div class='col-md-6'  style='text-align : center;'>"+
										"<button class='btn btn-danger btn-clean' onclick='getNoSuratTAS("+'"ta1"'+").showBase()'>Batalkan</button>"+
									"</div>"+
									"<form style='display : none;' id='form-print' target='_blank' method='POST' action='Palaceareaacara/getPrintOfThis.jsp'><input type='text' id='idSurat' name='idSurat'><input type='text' id='noSuratUnd' name='noSuratUnd'><input type='submit'></form>"+
								"</div><br>"+
							"</div>"+
						"</div>"+
						"<div id='ta1-content-base' >"+
							 "<table style='width : 100%; font-family : Arial; font-size : 10pt;'>"+
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
										wkwk.format("dddd, MMMM Do YYYY, HH:mm:ss")+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Berakhir"+
									"</td>"+
									"<td>"+
										wkwk2.format("dddd, MMMM Do YYYY, HH:mm:ss")+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										
									"</td>"+
									
									"<td>"+
										buttonTolak+
									"</td>"+
									
								"</tr>"+
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}else if(calEvent.id.substr(0,2) == "TD"){
					buttonTolak += 
						"<div>";
					if(tempIDListTable[calEvent.id]['ketua'] != ""){
						buttonTolak += "<span class='icon-print' onclick='getNoSuratTAD("+'"ta2"'+").setAAndB("+'"'+calEvent.id+'"'+" , "+'"'+tempIDListTable[calEvent.id]['ketua']+'"'+").showNoSurat()' style='color : green; cursor : pointer;' title='print surat ketua'>&nbsp;ketua</span>";
					}else{
						buttonTolak += 
						"<span class='icon-remove' style='color : red;' title='print surat ketua'>&nbsp;ketua</span>";
					}
					if(tempIDListTable[calEvent.id]['pengujis'] != ""){
						buttonTolak += "&nbsp;|&nbsp;<span class='icon-print' onclick='getNoSuratTAD("+'"ta2"'+").setAAndB("+'"'+calEvent.id+'"'+" , "+'"'+tempIDListTable[calEvent.id]['pengujis']+'"'+").showNoSurat()' style='color : green; cursor : pointer;' title='print surat penguji 1'>&nbsp;penguji 1</span>";
					}else{
						buttonTolak += 
						"&nbsp;|&nbsp;<span class='icon-remove' style='color : red;' title='print surat penguji 1'>&nbsp;penguji 1</span>";
					}
					if(tempIDListTable[calEvent.id]['pengujid'] != ""){
					buttonTolak += "&nbsp;|&nbsp;<span class='icon-print' onclick='getNoSuratTAD("+'"ta2"'+").setAAndB("+'"'+calEvent.id+'"'+" , "+'"'+tempIDListTable[calEvent.id]['pengujid']+'"'+").showNoSurat()' style='color : green; cursor : pointer;' title='print surat penguji 2'>&nbsp;penguji 2</span>";
					}else{
						buttonTolak += 
						"&nbsp;|&nbsp;<span class='icon-remove' style='color : red;' title='print surat penguji 2'>&nbsp;penguji 2</span>";
					}
					if(tempIDListTable[calEvent.id]['pengujit'] != ""){
						buttonTolak += "&nbsp;|&nbsp;<span class='icon-print' onclick='getNoSuratTAD("+'"ta2"'+").setAAndB("+'"'+calEvent.id+'"'+" , "+'"'+tempIDListTable[calEvent.id]['pengujit']+'"'+").showNoSurat()' style='color : green; cursor : pointer;' title='print surat penguji 3'>&nbsp;penguji 3</span>";
					}else{
						buttonTolak += 
						"&nbsp;|&nbsp;<span class='icon-remove' style='color : red;' title='print surat penguji 3'>&nbsp;penguji 3</span>";
					}
							
					buttonTolak += 
						"</div>";
					 modalStaticSingleInformation("Pelaku seminar TA 2 ",
					 "<div style='width : 100%;'>"+
						"<div id='ta2-content-succes-delete'  style='display : none;'>"+
							"<div>"+
								'<div class="panel panel-success"> <div class="panel-heading"> <h3 class="panel-title">Pemberitahuan</h3> </div> <div class="panel-body"> Data seminar berhasil di tolak </div> <div class="panel-footer"></div> </div>'+
							"</div>"+
						"</div>"+
						"<div id='ta2-content-pdf' style='display : none;'>"+
							"<div  onclick='alertSeminarDate("+'"ta2"'+").showBase();' style='position : absolute; width : 45px;margin-top : 10px; cursor : pointer; margin-left : 10px; height 45px; text-align : center; border-radius : 45px; background-color : black; '>"+
								"<i  style='font-size : 14px; color : white; line-height : 45px;' class='icon-arrow-left'></i>"+
							"</div>"+
							"<div>"+
								"<iframe id='ta2-pdf' style='width : 100%; min-height : 500px;'></iframe>"+
							"</div>"+
						"</div>"+
						"<div id='ta2-content-edit' style='display : none; height : 145px;'>"+
							"<div>"+
								templateCalendarTADKode+
								"<div class=form-row>"+
									"<div class='col-md-6' style='text-align : center;'>"+
										"<button class='btn btn-success btn-clean'  onclick='getNoSuratTAD("+'"ta2"'+").printThisSurat()'>print</button>"+
									"</div>"+
									"<div class='col-md-6'  style='text-align : center;'>"+
										"<button class='btn btn-danger btn-clean' onclick='getNoSuratTAD("+'"ta2"'+").showBase()'>Batalkan</button>"+
									"</div>"+
									"<form style='display : none;' id='form-print' target='_blank' method='POST' action='Palaceareaacara/getPrintOfThis.jsp'><input type='text' id='nip' name='nip'><input type='text' id='idSurat' name='idSurat'><input type='text' id='noSuratTug' name='noSuratTug'><input type='text' id='noSuratUnd' name='noSuratUnd'><input type='submit'></form>"+
								"</div><br>"+
							"</div>"+
						"</div>"+
						"<div id='ta2-content-base' >"+
							 "<table style='width : 100%; font-family : Arial; font-size : 10pt;'>"+
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
										wkwk.format("dddd, MMMM Do YYYY, HH:mm:ss")+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Berakhir"+
									"</td>"+
									"<td>"+
										wkwk2.format("dddd, MMMM Do YYYY, HH:mm:ss")+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										
									"</td>"+						
									"<td>"+
										buttonTolak+
									"</td>"+
							
								"</tr>"+
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}else if(calEvent.id.substr(0,2) == "AC"){
					if(wkwk2.isBefore(neutral)){
						buttonTolak += 
						"<div>"+
							"<span class='icon-remove' style='color : red;' title='menghapus even'> hapus</span>"+
							"&nbsp;|&nbsp;<span class='icon-edit' style='color : red' title='berita acara'> ubah</span>"+
						"</div>";
					}else{
						buttonTolak +=
						"<div>"+
							"<span style='color : green; cursor : pointer;' onclick='alertAdminEvent("+'"ac"'+").showDelete();' class='icon-remove' title='menghapus even'> hapus</span>"+
							"&nbsp;|&nbsp;<span  onclick='alertAdminEvent("+'"ac"'+").showEdit();' style='color : green; cursor : pointer;' class='icon-edit' title='berita acara'> ubah</span>"+
						"</div>";
					}

					 modalStaticSingleInformation("Even dari anda ",
					  "<div style='width : 100%;'>"+
						"<div id='ac-content-succes-delete'  style='display : none;'>"+
							"<div>"+
								'<div class="panel panel-success"> <div class="panel-heading"> <h3 class="panel-title">Pemberitahuan</h3> </div> <div class="panel-body"> Data Acara berhasil di hapus</div> <div class="panel-footer"></div> </div>'+
							"</div>"+
						"</div>"+
						"<div id='ac-content-edit' style='display : none;'>"+
							"<div>"+
								templateCalendarTAS+
							"</div>"+
							"<div  style='height : 50px' >"+
								"<div class='col-md-6' style='text-align : center;'>"+
									"<button class='btn btn-success btn-clean'  onclick='alertAdminEvent("+'"ac"'+").showSucces(this);'>Simpan</button>"+
								"</div>"+
								"<div class='col-md-6'  style='text-align : center;'>"+
									"<button class='btn btn-danger btn-clean' onclick='alertAdminEvent("+'"ac"'+").showBase();'>Batalkan</button>"+
								"</div>"+
							"</div>"+
						"</div>"+
						"<div id='ac-content-delete' style='display : none;'>"+
							"<div style='text-align : center;'>"+
								"Apa yakin anda ingin menghapus acara ini ?"+
							"</div>"+
							"<div  style='height : 50px' >"+
								"<div class='col-md-6' style='text-align : center;'>"+
									"<button class='btn btn-danger' id='hapus-acara-admin' onclick='alertAdminEvent("+'"ac"'+").showDeletion(this);'>Ya</button>"+
								"</div>"+
								"<div class='col-md-6'  style='text-align : center;'>"+
									"<button class='btn btn-primary' id='batal-hapus-acara-admin' onclick='alertAdminEvent("+'"ac"'+").showBase();'>Tidak</button>"+
								"</div>"+
							"</div>"+
							"<div>"+
							"</div>"+
						"</div>"+
						"<div id='ac-content-base' >"+
							 "<table style='width : 100%;  font-family : Arial; font-size : 10pt;'>"+
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Nama"+
									"</td>"+
									"<td id='base-acara-title' style='width : 75%;'>"+
										calEvent.title+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Mulai"+
									"</td>"+
									"<td id='base-acara-start'>"+
										wkwk.format("dddd, MMMM Do YYYY, HH:mm:ss")+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Berakhir"+
									"</td>"+
									"<td id='base-acara-end'>"+
										wkwk2.format("dddd, MMMM Do YYYY, HH:mm:ss")+
									"</td>"+
								"</tr>"+
								"<tr>"+
									"<td style='width : 25%; padding-left : 10px;'>"+
									"</td>"+
									"<td>"+
										buttonTolak+
									"</td>"+
								"</tr>"+
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}
			}
		});
		TotalCalender += 1;
	}
}
function getNoSuratTAS(id){
	this.id=id;
	this.setA = function(a){
		this.a = a;
		return this;
	}
	this.showBase = function(){
		$("#"+this.id+"-content-base").slideDown('slow');
		$("#"+this.id+"-content-edit").slideUp('slow');
	};
	this.printThisSurat = function(){
		$("#idSurat").val(this.a);
		$("#noSuratUnd").val($('#nosuratundangan').val());
		$("#form-print").submit();
		this.showBase();
	}
	this.showNoSurat = function(){
		$("#"+this.id+"-content-base").slideUp('slow');
		$("#"+this.id+"-content-edit").slideDown('slow');
		$("#nosuratundangan").attr("disabled","true");
		openLoadingBar("getting last kode");
		var a= this.a;
		j("#setAjax").setAjax({
			url : base_url+"Palaceareaacara/getKodeSurat.jsp",
			bool : true,
			content : "idSurat="+a,
			methode : "POST",
			sucOk : function(yl){
				//alert(yl);
				setLoadingBarMessage("proses hasil balasan server ...");
				if(yl[0] == '3'){
					$(location).attr('href', base_url+yl.substr(1,yl.length-1));
				}else if(yl[0]=='1'){
					var dataJSON = JSON.parse(yl.substr(1,yl.length-1));					
					$("#nosuratundangan").val(dataJSON.nosuratundangan);
				}
				else if(yl[0]=='0'){
					setLoadingBarMessage('Maaf gagal melakukan pengambilan data');
					setTimeout(function(){
						alertAdminEvent(idActive).showBase();
					},1000);
				}
				$("#nosurattugas").removeAttr("disabled");
				$("#nosuratundangan").removeAttr("disabled");
				setTimeout(function(){
					closeLoadingBar();
				},400);
			},
			sucEr : function(a,b){
				template(a,b,"sesi edit acara");
			}
		});
	};
	return this;
}
function getNoSuratTAD(id){
	this.id=id;
	this.setAAndB = function(a,b){
		this.a = a;
		this.b = b;
		return this;
	}
	this.showBase = function(){
		$("#"+this.id+"-content-base").slideDown('slow');
		$("#"+this.id+"-content-edit").slideUp('slow');
	};
	this.printThisSurat = function(){		
		$("#nip").val(this.b);
		$("#idSurat").val(this.a);
		$("#noSuratTug").val($('#nosurattugas').val());
		$("#noSuratUnd").val($('#nosuratundangan').val());
		$("#form-print").submit();
		this.showBase();
	}
	this.showNoSurat = function(){
		$("#"+this.id+"-content-base").slideUp('slow');
		$("#"+this.id+"-content-edit").slideDown('slow');
		$("#nosurattugas").attr("disabled","true");
		$("#nosuratundangan").attr("disabled","true");
		openLoadingBar("getting last kode");
		var a= this.a;
		j("#setAjax").setAjax({
			url : base_url+"Palaceareaacara/getKodeSurat.jsp",
			bool : true,
			content : "idSurat="+a,
			methode : "POST",
			sucOk : function(yl){
				//alert(yl);
				setLoadingBarMessage("proses hasil balasan server ...");
				if(yl[0] == '3'){
					$(location).attr('href', base_url+yl.substr(1,yl.length-1));
				}else if(yl[0]=='1'){
					var dataJSON = JSON.parse(yl.substr(1,yl.length-1));					
					$("#nosuratundangan").val(dataJSON.nosuratundangan);
					$("#nosurattugas").val(dataJSON.nosurattugas);
				}
				else if(yl[0]=='0'){
					setLoadingBarMessage('Maaf gagal melakukan pengambilan data');
					setTimeout(function(){
						alertAdminEvent(idActive).showBase();
					},1000);
				}
				$("#nosurattugas").removeAttr("disabled");
				$("#nosuratundangan").removeAttr("disabled");
				setTimeout(function(){
					closeLoadingBar();
				},400);
			},
			sucEr : function(a,b){
				template(a,b,"sesi edit acara");
			}
		});
	};
	return this;
}
var kodeSeminarTanggalShare = null;
var kodeCalenderActive = null;
function alertAdminEvent(id){
	this.id = id;
	this.showBase = function(){
		$("#"+this.id+"-content-base").slideDown('slow');
		$("#"+this.id+"-content-delete").slideUp('slow');
		$("#"+this.id+"-content-edit").slideUp('slow');
	};
	this.showDelete = function(){
		$("#"+this.id+"-content-delete").slideDown('slow');
		$("#"+this.id+"-content-base").slideUp('slow');
		$("#"+this.id+"-content-edit").slideUp('slow');
	};
	this.showEdit = function(){
		var idActive = this.id;
		$("#"+this.id+"-content-edit").slideDown('slow',function(){			
			if($(".timepicker").length>0)$(".timepicker").timepicker();
			if($(".datepicker").length>0)$(".datepicker").datepicker({nextText:"",prevText:""});
			openLoadingBar('memperoleh data asli ...');
			
			$TEMP = kodeSeminarTanggalShare.id.split("&");
			$TEMP = $TEMP[0]+"."+$TEMP[1];
			$TEMP = $TEMP.split("|");
			$TEMP = $TEMP[0]+"_"+$TEMP[1];
			//alert($TEMP);
			j("#setAjax").setAjax({
				url : base_url+"Palaceareaacara/getJSONDataAcara.jsp",
				bool : true,
				content : "id="+$TEMP,
				methode : "POST",
				sucOk : function(yl){
					//alert(yl);
					setLoadingBarMessage("proses hasil balasan server ...");
					if(yl[0] == '3'){
						$(location).attr('href', base_url+yl.substr(1,yl.length-1));
					}else if(yl[0]=='1'){
						var dataJSON = JSON.parse(yl.substr(1,yl.length-1));					
						$("#acara-title").val(dataJSON.namaAcara);
						$("#acara-penanggung").val(dataJSON.responsive);
						$("#jam-mulai").val(dataJSON.start);
						$("#jam-berakhir").val(dataJSON.end);
					}
					else if(yl[0]=='0'){
						setLoadingBarMessage('Maaf gagal melakukan pengambilan data');
						setTimeout(function(){
							alertAdminEvent(idActive).showBase();
						},1000);
					}
					setTimeout(function(){
						closeLoadingBar();
					},400);
				},
				sucEr : function(a,b){
					template(a,b,"sesi edit acara");
				}
			});
		});
		$("#"+this.id+"-content-base").slideUp('slow');
		$("#"+this.id+"-content-delete").slideUp('slow');
	};
	this.showDeletion = function(x){
		var IDs = this.id;
		$TEMP = kodeSeminarTanggalShare.id.split("&");
		$TEMP_ID = $TEMP[0]+"."+$TEMP[1];
		$TEMP_ID = $TEMP_ID.split("|");
		$TEMP_ID = $TEMP_ID[0]+"_"+$TEMP_ID[1];
		//alert($TEMP_ID);
		openLoadingBar("Mengirim peintah penghapusan ...");
		$(x).attr('disabled','true');
		$('#batal-hapus-acara-admin').attr('disabled','true');
		j('#setAjax').setAjax({
			url : base_url+"Palaceareaacara/setDeleteOrRejected.jsp",
			bool : true,
			content : "id="+$TEMP_ID,
			methode : "POST",
			sucOk : function(yl){
				//alert(yl);
				setLoadingBarMessage("proses hasil balasan server ...");
				if(yl[0] == '3'){
					$(location).attr('href', base_url+yl.substr(1,yl.length-1));
				}else if(yl[0]=='1'){
					CalendersRev[kodeCalenderActive].fullCalendar("removeEvents",kodeSeminarTanggalShare.id); 
					$("#"+IDs+"-content-succes-delete").slideDown('slow',function(){
						setTimeout(function(){
							$('#mod-sta-sing-warn-terima-kasih').trigger('click');
						},400);
					});
					$("#"+IDs+"-content-delete").slideUp('slow');
					$("#"+IDs+"-content-base").slideUp('slow');
					$("#"+IDs+"-content-edit").slideUp('slow');
				}
				else if(yl[0]=='0'){
					setLoadingBarMessage('Maaf gagal melakukan pengambilan data');
				}
				$(x).removeAttr("disabled");
				$('#batal-hapus-acara-admin').removeAttr("disabled");
				setTimeout(function(){
					closeLoadingBar();
				},400);
			},
			sucEr : function(a,b){
				template(a,b,"sesi menghapus");
			}
		});
	};
	this.showSucces = function(x){
		openLoadingBar("Mengirim data untuk disimpan ...");
		$(x).attr("disabled","true");
		$(x.parentNode.parentNode.childNodes[1].childNodes[0]).attr("disabled","true");
		var idBaseAlert = this.id;
		$TEMP = kodeSeminarTanggalShare.id.split("&");
		$TEMP_ID = $TEMP[0]+"."+$TEMP[1];
		$TEMP_ID = $TEMP_ID.split("|");
		$TEMP_ID = $TEMP_ID[0]+"_"+$TEMP_ID[1];
		$TEMP = $TEMP[0];
		$TEMP = $TEMP.split("|");
		$TEMP = $TEMP[1];
		$START_EVENT = $TEMP+" "+$("#jam-mulai").val()+":00";
		$END_EVENT = $TEMP+" "+$("#jam-berakhir").val()+":00";
		j("#setAjax").setAjax({
			url : base_url+"Palaceareaacara/setUpdateAcara.jsp",
			bool : true,
			methode : "POST",
			content : 
			"id="+$TEMP_ID+"&"+
			"namaAcara="+$("#acara-title").val()+"&"+
			"penanggung="+$("#acara-penanggung").val()+"&"+
			"startEvent="+$START_EVENT+"&"+
			"endEvent="+$END_EVENT+"",
			sucOk : function(yl){
				setLoadingBarMessage("proses hasil balasan server ...");
				if(yl[0] == '3'){
					$(location).attr('href', base_url+yl.substr(1,yl.length-1));
				}else if(yl[0]=='1'){
					$TEMP = kodeSeminarTanggalShare.id.split("&");
					var newID = $TEMP[0]+"&"+$("#jam-mulai").val()+":00"+kodeSeminarTanggalShare.id[kodeSeminarTanggalShare.id.length-1];
					var newTitle = $("#acara-title").val();
					var newStart = moment($START_EVENT);
					var newEnd = moment($END_EVENT);
					CalendersRev[kodeCalenderActive].fullCalendar("removeEvents",kodeSeminarTanggalShare.id); 
					CalendersRev[kodeCalenderActive].fullCalendar('renderEvent',{
							title: newTitle,
							start: newStart,
							id : newID,
							end: newEnd},true);
					kodeSeminarTanggalShare.id = newID;
					kodeSeminarTanggalShare.title = newTitle;
					kodeSeminarTanggalShare.start = newStart;
					kodeSeminarTanggalShare.end = newEnd;
					$("#base-acara-title").html(newTitle);
					$("#base-acara-start").html(newStart.format("dddd, MMMM Do YYYY, HH:mm:ss"));
					$("#base-acara-end").html(newEnd.format("dddd, MMMM Do YYYY, HH:mm:ss"));
					alertAdminEvent(idBaseAlert).showBase();
				}
				else if(yl[0]=='0'){
					setLoadingBarMessage('Maaf gagal melakukan pengambilan data');
				}
				$(x).removeAttr("disabled");
				$(x.parentNode.parentNode.childNodes[1].childNodes[0]).removeAttr("disabled");
				setTimeout(function(){
					closeLoadingBar();
				},400);
			},
			sucEr : function(a,b){
				template(a,b,"update data side");
			}
		});
	};
	return this;
}
function alertSeminarDate(id){
	this.id = id;
	this.showBase = function(){
		$("#"+this.id+"-content-base").slideDown('slow');
		$("#"+this.id+"-content-delete").slideUp('slow');
		$("#"+this.id+"-content-pdf").slideUp('slow');
	};
	this.showPdf = function(){
		$("#"+this.id+"-content-pdf").slideDown('slow',function(){
			$("#"+id+"-pdf").html("");
			$TEMP = kodeSeminarTanggalShare.id.split("&");
			$TEMP = $TEMP[0]+"."+$TEMP[1];
			$TEMP = $TEMP.split("|");
			$TEMP = $TEMP[0]+"_"+$TEMP[1]+"_"+$TEMP[2];
			//alert(base_url+"Palaceareaacara/printBeritaAcara/"+$TEMP+".aspx");
			$("#"+id+"-pdf").attr("src",base_url+"Palaceareaacara/printBeritaAcara/"+$TEMP+".aspx");
		});
		$("#"+this.id+"-content-delete").slideUp('slow');
		$("#"+this.id+"-content-base").slideUp('slow');
	}
	this.showReject = function(){
		$("#"+this.id+"-content-delete").slideDown('slow');
		$("#"+this.id+"-content-base").slideUp('slow');
		$("#"+this.id+"-content-pdf").slideUp('slow');
	}
	this.showSucces = function(x){
		var xy = this.id;
		openLoadingBar("mencoba menolak data ....");
		$(x).attr("disabled","true");
		
		//alert(kodeCalenderActive+" = "+kodeSeminarTanggalShare);
		
		j("#setAjax").setAjax({
			url : base_url+"Palaceareaacara/setDeleteOrRejected.jsp",
			content : "id="+kodeSeminarTanggalShare.id,
			methode : "POST",
			bool : true,
			sucOk : function(yy){
				if(parseInt(yy[0]) ==  3){
					$(location).attr('href', base_url+yy.substr(1,yy.length-1));
				}else if(parseInt(yy[0]) ==  1){
					CalendersRev[kodeCalenderActive].fullCalendar('removeEvents',kodeSeminarTanggalShare.id);
					setLoadingBarMessage(yy.substr(1,yy.length-1)+" ...");
					$("#"+xy+"-content-succes-delete").slideDown('slow',function(){
						setTimeout(function(){
							$('#mod-sta-sing-warn-terima-kasih').trigger('click');
						},400);
					});
					$("#"+xy+"-content-delete").slideUp('slow');
					$("#"+xy+"-content-base").slideUp('slow');
					$("#"+xy+"-content-pdf").slideUp('slow');
				}else{
					setLoadingBarMessage(yy.substr(1,yy.length-1)+" ...");
					$(x).removeAttr("disabled");
				}
				setTimeout(function(){
					closeLoadingBar();
				},400);
			},
			sucEr : function (yy,b){
				template(yy,b,"sesi penghapusan seminar");
			} 
		});
		
	}
	return this;
}
function getCheckJam(id,jam,tr,fl){
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
	$("#"+id).val(parseInt(TEMP_SPLIT[0])+":"+parseInt(TEMP_SPLIT[1]));
	tr();
	return true;
}
function generateNormalTime(z){
	return z[0]+"-"+(z[1]+1)+"-"+z[2]+" "+z[3]+":"+z[4]+":"+z[5];
}
function deleteContentTable(a){
	alert(a);
}
function editContentTable(a){
	alert(a);
}
function printContentTable(a){
	alert(a);
}
