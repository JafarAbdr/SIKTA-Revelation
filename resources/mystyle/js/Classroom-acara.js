function acaraAkademikFullArea(){
	areaReloadTableRuangTa1();
	areaReloadTableRuang();
}
function areaReloadTableRuang(){
	$("#REF-TA2").on("click",function(){
		areaReloadTableRuangTa2();
	});
	$("#REF-TA1").on("click",function(){
		areaReloadTableRuangTa1();
	});
	$("#REF-PUS").on("click",function(){
		areaReloadTableRuangPus();
	});
	$("#lingk-TA2").on("click",function(){
		if(areaTable2){
			areaReloadTableRuangTa2();
			areaTable2 = false;
			areaTable1 = true;
			areaTable4 = true;
		}
	});
	$("#lingk-TA1").on("click",function(){
		if(areaTable1){
			areaReloadTableRuangTa1();
			areaTable1 = false;
			areaTable2 = true;
			areaTable4 = true;
		}
	});
	$("#lingk-PUS").on("click",function(){
		if(areaTable4){
			areaReloadTableRuangPus();
			areaTable4 = false;
			areaTable1 = true;
			areaTable2 = true;
		}
	});
}
var areaTable4  = true;
var areaTable2  = true;
var areaTable1  = false;
function areaReloadTableRuangPus(){
	$("#calendar-pu-s").html("");
	setTimeout(function(){	
		areaRebuildCalenderStillGetOne({
			ID : "calendar-pu-s",
			KEY : "PUS"
		});
		setTimeout(function(){
			areaReloadDataTableCalender({
				idCalender : "calendar-pu-s",
				title : "update calender 4",
				urlpostfix : "getJSONAcaraRuangPUS",
				
			})
		},1000);
	},500);
}
function areaReloadTableRuangTa1(){
	$("#calendar-ta-1").html("");
	setTimeout(function(){	
		areaRebuildCalenderStillGetOne({
			ID : "calendar-ta-1",
			KEY : "TA1"
		});
		setTimeout(function(){
			areaReloadDataTableCalender({
				idCalender : "calendar-ta-1",
				title : "update calender 1",
				urlpostfix : "getJSONAcaraRuangTA1",
				
			})
		},1000);
	},500);
}
function areaReloadTableRuangTa2(){
	$("#calendar-ta-2").html("");
	setTimeout(function(){		
		areaRebuildCalenderStillGetOne({
			ID : "calendar-ta-2",
			KEY : "TA2"
		});
		setTimeout(function(){
			areaReloadDataTableCalender({
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
var areaTempIDListTable = [];
function areaReloadDataTableCalender(DATA){
	openLoadingBar("memperoleh data "+DATA.title);
	j("#setAjax").setAjax({
		methode : "GET",
		bool : true,
		url :base_url+"Classareaacara/"+DATA.urlpostfix+"",
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
						tempStart = moment(jsonList[i].tanggal);
						tempEnd = moment(jsonList[i].endTanggal);
						areaTempIDListTable[jsonList[i].id] = [];
						areaTempIDListTable[jsonList[i].id]['deskripsi'] = jsonList[i].deskripsi;
						areaTempIDListTable[jsonList[i].id]['contact'] = jsonList[i].contact;
						areaCalendersRev[DATA.idCalender].fullCalendar('renderEvent',{
							title: jsonList[i].nama,
							start: tempStart,
							id : jsonList[i].id,
							end: tempEnd},true);
					}
				}
			}
			setTimeout(function(){
				closeLoadingBar();
			},400);	
		},
		sucEr : function(a,b){
			template(a,b,"get all table");
		}
	});
}
var areaTotalCalender = 0;
var areaCalendersRev = [];
var areaNGlobal=null;
var areaDateGlobal=null;
var areaTemplateCalendarTAS2 = 
	'<div style=" color:#333333;">'+
		'<div class=form-row> '+
			'<div class=col-md-3>Nama acara : </div> '+
			'<div class=col-md-9> '+
				'<input id="add-acara-title" type="username" placeholder="Masukan judul acara anda(maksimal 250 karakter)" max="250" style="width : 100%;">'+			
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
var areaTemplateCalendarTAS = 
	'<div style=" color:#333333;">'+
		'<div class=form-row> '+
			'<div class=col-md-3>Nama acara : </div> '+
			'<div class=col-md-9> '+
				'<input id="acara-title" type="username" placeholder="Masukan judul acara anda(maksimal 250 karakter)" max="250" style="width : 100%;">'+			
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
function areaRebuildCalenderStillGetOne(DATA){
	var valueTotalCalendar = areaTotalCalender;
	if($("#"+DATA.ID).length>0){
		var e=new Date();
		var t=e.getDate();
		var n=e.getMonth();
		var r=e.getFullYear(); //2016
		$("#external-events .external-event").each(function(){
			var e={title:$.trim($(this).text())};$(this).data("eventObject",e);
		$(this).draggable({zIndex:999,revert:true,revertDuration:0})});
		
		areaCalendersRev[DATA.ID] = $("#"+DATA.ID).fullCalendar({
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
				var key = DATA.KEY;
				areaNGlobal = n;
				areaDateGlobal = e;
				if(moment(e).isBefore(new Date())){
					modalStaticSingleInformation("Peringatan ",
					 "<div style='padding : 10px; font-family : arial; font-size : 10pt;'>Anda tidak dapat menambahkan acara pada waku yang telah lewat.</div>"
					 );
				}else{
					modalStaticBodyMultipleButton("Data Acara baru",areaTemplateCalendarTAS2,function(finalis){
						openLoadingBar("Validasi tanggal dan jam ...");
						var TEMP_DATE_TIME_START = moment("0000-00-00 "+$("#add-jam-mulai").val());
						var TEMP_DATE_TIME_END = moment("0000-00-00 "+$("#add-jam-berakhir").val());
						var TEMP_START = moment(areaDateGlobal);
						var TEMP_END = moment(areaDateGlobal);
						TEMP_START.hour(TEMP_DATE_TIME_START.hours());
						TEMP_END.hour(TEMP_DATE_TIME_END.hours());
						TEMP_START.minute(TEMP_DATE_TIME_START.minutes());
						TEMP_END.minute(TEMP_DATE_TIME_END.minutes());
						TEMP_END.seconds(TEMP_DATE_TIME_END.seconds());
						TEMP_START.seconds(TEMP_DATE_TIME_START.seconds());
						j("#setAjax").setAjax({
							methode: "POST",
							url:base_url+"Classareaacara/setNewAcara",
							bool : true,
							content: "kode="+DATA.KEY+"&namaAcara="+$("#add-acara-title").val()+"&startEvent="+generateNormalTime(TEMP_START.toArray())+"&endEvent="+generateNormalTime(TEMP_END.toArray()),
							sucOk : function(a){
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
									areaTempIDListTable["PM"+a[1]+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode] = [];
									areaTempIDListTable["PM"+a[1]+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode]['deskripsi'] = $("#add-acara-title").val();
									areaTempIDListTable["PM"+a[1]+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode]['contact'] = a[3];
									areaCalendersRev[DATA.ID].fullCalendar('renderEvent',{
										id:"PM"+a[1]+"|"+TEMP_START.format("YYYY-MM-DD&HH:mm:ss")+kode,
										title: a[2],
										start: TEMP_START,
										end: TEMP_END,
										allDay:areaNGlobal},true);
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
			eventClick: function(calEvent, jsEvent, view) {
				kodeSeminarTanggalShare = calEvent;
				kodeCalenderActive = DATA.ID;
				var wkwk = moment(calEvent.start);
				var wkwk2 = moment(calEvent.end);
				var neutral = moment();
				var buttonTolak = "";
				if(calEvent.id.substr(0,2) == "TS"){
					 modalStaticSingleInformation("Pelaku seminar TA 1 ",
					 "<div style='width : 100%;'>"+
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
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Kontak"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['contact']+
									"</td>"+
								"</tr>"+
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Deskripsi"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['deskripsi']+
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
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}else if(calEvent.id.substr(0,2) == "TD"){
					 modalStaticSingleInformation("Pelaku seminar TA 2 ",
					 "<div style='width : 100%;'>"+
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
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Kontak"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['contact']+
									"</td>"+
								"</tr>"+
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Deskripsi"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['deskripsi']+
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
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}else if(calEvent.id.substr(0,2) == "NP"){
					 modalStaticSingleInformation("Peminjam Ruangan ",
					 "<div style='width : 100%;'>"+
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
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Kontak"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['contact']+
									"</td>"+
								"</tr>"+
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Deskripsi"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['deskripsi']+
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
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}else if(calEvent.id.substr(0,2) == "AC"){
					 modalStaticSingleInformation("Acara Admin Departemen ",
					 "<div style='width : 100%;'>"+
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
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Kontak"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['contact']+
									"</td>"+
								"</tr>"+
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Deskripsi"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['deskripsi']+
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
							 "</table>"+
						"</div>"+
					"</div>"
					 );
				}else if(calEvent.id.substr(0,2) == "PM"){
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
								areaTemplateCalendarTAS+
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
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Kontak"+
									"</td>"+
									"<td style='width : 75%;'>"+
										areaTempIDListTable[calEvent.id]['contact']+
									"</td>"+
								"</tr>"+
								"<tr >"+
									"<td style='width : 25%; padding-left : 10px;'>"+
										"Deskripsi"+
									"</td>"+
									"<td style='width : 75%;' id='base-acara-deskripsi'>"+
										areaTempIDListTable[calEvent.id]['deskripsi']+
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
		areaTotalCalender += 1;
	}
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
			j("#setAjax").setAjax({
				url : base_url+"Classareaacara/getJSONDataAcara",
				bool : true,
				content : "id="+$TEMP,
				methode : "POST",
				sucOk : function(yl){
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
		openLoadingBar("Mengirim peintah penghapusan ...");
		$(x).attr('disabled','true');
		$('#batal-hapus-acara-admin').attr('disabled','true');
		j('#setAjax').setAjax({
			url : base_url+"Classareaacara/setDeleteOrRejected",
			bool : true,
			content : "id="+$TEMP_ID,
			methode : "POST",
			sucOk : function(yl){
				//alert(yl);
				setLoadingBarMessage("proses hasil balasan server ...");
				if(yl[0] == '3'){
					$(location).attr('href', base_url+yl.substr(1,yl.length-1));
				}else if(yl[0]=='1'){
					areaCalendersRev[kodeCalenderActive].fullCalendar("removeEvents",kodeSeminarTanggalShare.id); 
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
			url : base_url+"Classareaacara/setUpdateAcara",
			bool : true,
			methode : "POST",
			content : 
			"id="+$TEMP_ID+"&"+
			"namaAcara="+$("#acara-title").val()+"&"+
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
					areaCalendersRev[kodeCalenderActive].fullCalendar("removeEvents",kodeSeminarTanggalShare.id); 
					tempContact = areaTempIDListTable[kodeSeminarTanggalShare.id]['contact'];
					areaTempIDListTable[kodeSeminarTanggalShare.id]=[]
					areaTempIDListTable[newID]=[];
					areaTempIDListTable[newID]['contact']=tempContact;
					areaTempIDListTable[newID]['deskripsi']=newTitle;
					areaCalendersRev[kodeCalenderActive].fullCalendar('renderEvent',{
							title: kodeSeminarTanggalShare.title,
							start: newStart,
							id : newID,
							end: newEnd},true);
					kodeSeminarTanggalShare.id = newID;
					kodeSeminarTanggalShare.start = newStart;
					kodeSeminarTanggalShare.end = newEnd;
					$("#base-acara-deskripsi").html(newTitle);
					$("#base-acara-start").html(newStart.format("dddd, MMMM Do YYYY, HH:mm:ss"));
					$("#base-acara-end").html(newEnd.format("dddd, MMMM Do YYYY, HH:mm:ss"));
					alertAdminEvent(idBaseAlert).showBase();
				}
				else if(yl[0]=='0'){
					setLoadingBarMessage(yl.substr(1,yl.length-1));
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
			$("#"+id+"-pdf").attr("src",base_url+"Classareaacara/printBeritaAcara/"+$TEMP+"");
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
		j("#setAjax").setAjax({
			url : base_url+"Classareaacara/setDeleteOrRejected",
			content : "id="+kodeSeminarTanggalShare.id,
			methode : "POST",
			bool : true,
			sucOk : function(yy){
				if(parseInt(yy[0]) ==  3){
					$(location).attr('href', base_url+yy.substr(1,yy.length-1));
				}else if(parseInt(yy[0]) ==  1){
					areaCalendersRev[kodeCalenderActive].fullCalendar('removeEvents',kodeSeminarTanggalShare.id);
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
	var TEMP_SPLIT = jam.split(":");
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
