var startSeminarPage = true;
var tahunForSeminar = null;
var semesterForSeminar = null;
var namaForSeminar = null;
var tahunForSidang = null;
var semesterForSidang = null;
var namaForSidang = null;
var changeInitSeminar = false;
function openXLFormSem(url){
	var xx = document.createElement("a");
	xx.target = "_blank";
	xx.href = url+"/"+tahunForSeminar+""+semesterForSeminar;
	xx.click();
}
function openXLFormSid(url){
	var xx = document.createElement("a");
	xx.target = "_blank";
	xx.href = url+"/"+tahunForSidang+""+semesterForSidang;
	xx.click();
}
function tableTA1TA2Seminar(){
	//alert("");
	changeInitSeminar = true;
	if(tahunForPemerataan!=null)
		$("#tahun-seminar").val(tahunForSeminar);
	else 
		tahunForSeminar = $("#tahun-seminar").val();
	if(semesterForPemerataan != null)
		$("#semester-seminar").val(semesterForSeminar);
	else
		semesterForSeminar = $("#semester-seminar").val();
	if(namaForPemerataan != null)
		$("#search-name-seminar").val(namaForSeminar);
	else
		namaForSeminar = $("#search-name-seminar").val();
	if(tahunForPemerataan!=null)
		$("#tahun-sidang").val(tahunForSidang);
	else
		tahunForSidang = $("#tahun-sidang").val();
	if(semesterForPemerataan != null)
		$("#semester-sidang").val(semesterForSidang);
	else
		semesterForSidang = $("#semester-sidang").val();
	if(namaForPemerataan != null)
		$("#search-name-sidang").val(namaForSidang);
	else
		namaForSidang = $("#search-name-sidang").val();
	refreshTableSeminarTA1();
	$("#search-name-seminar").keyup(function(event){
		if(event.keyCode == 13){
			refreshTableSeminarTA1();
		}
	});
	if(changeInitSeminar){
		 changeInitSeminar = false;
		$("#tahun-seminar").on('change',function(){
			refreshTableSeminarTA1();
		});
		$("#semester-seminar").on('change',function(){
			refreshTableSeminarTA1();
		});
		$("#semester-sidang").on('change',function(){
			activecanvasnow = 6;	
			//alert(9);
			reloadChartSeminarAll(lastActive);	
			refreshTableSeminarTA2();
		});
		$("#tahun-sidang").on('change',function(){
			activecanvasnow = 6;	
			//alert(10);
			reloadChartSeminarAll(lastActive);	
			refreshTableSeminarTA2();
		});
	}
	$("#search-name-sidang").keyup(function(event){
		if(event.keyCode == 13){
			refreshTableSeminarTA2();
		}
	});
	Chart.defaults.global.responsive = true;
	window.myLines = null;
	startSeminarPage = true;
	var ff = function(){
		if(startSeminarPage){
			startSeminarPage = false;
			reloadChartSeminar("canvas1","getJsonTableNow","controller-diagram-1");
			refreshTableSeminarTA2();
			$("#seminar-ta2-pemerataan").unbind('click',ff);
		}
	};
	$("#seminar-ta2-pemerataan").bind('click',ff);
}
var lastActive;
var activecanvasnow = 0;
function reloadChartSeminarAll(activeCanvas){
	if(activeCanvas != activecanvasnow){
		lastActive = activeCanvas;
		switch(activeCanvas){
			case 1 :
			reloadChartSeminar("canvas1","getJsonTableNow","controller-diagram-1");
			break;
			case 2 :
			reloadChartSeminar("canvas2","getJsonTableTesterS","controller-diagram-2");
			break;
			case 3 :
			reloadChartSeminar("canvas3","getJsonTableTesterD","controller-diagram-3");
			break;
			case 4 :
			reloadChartSeminar("canvas4","getJsonTableTesterT","controller-diagram-4");
			break;
		}	
		activecanvasnow = activeCanvas;
		refreshTableSeminarTA2();
	}
}
var lineChartDataS = {
	labels : ["Adit","February","john","jojo","May","June","July","Adit","February","john","jojo","May","June","July","Adit","February","john","jojo","May","June","July"],
	datasets : [
	{
		label: "My First dataset",
		fillColor : "rgba(20,20,20,0.1)",
		strokeColor : "#666",
		pointColor : "rgba(20,20,220,0.8)",
		pointStrokeColor : "#fff",
		pointHighlightFill : "#fff",
		pointHighlightStroke : "rgba(220,220,220,1)",
		data : [89,67,23,54,56,21,24,89,67,23,54,56,21,24,89,67,23,54,56,21,24]
	}]
}
function reloadChartSeminar(id,url,dia){
	$('#'+dia).html("");
	$('#'+dia).html("<canvas id='"+id+"' height='500' width='2048'  style='color: rgba(220,220,200,1);'></canvas>");
	tahunForSidang = $("#tahun-sidang").val();
	semesterForSidang = $("#semester-sidang").val();
	openLoadingBar("mengambil diagram ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlresultseminar/'+url+'',
		bool : true,
		content : "kode=JASERVCONTROL&"+
					"tahun="+tahunForSidang+"&"+
					"semester="+semesterForSidang,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response diagram diproses ...");
				var temm = JSON.parse(a.substr(1,a.length-1));
				
				lineChartDataS.labels = temm.data[0];
				lineChartDataS.datasets[0].data = temm.data[1];
				
				var ctk = document.getElementById(id).getContext("2d");
				window.myLines = new Chart(ctk).Line(lineChartDataS);
			}else{
				setLoadingBarMessage("response diagram gagal  ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},500);
		},
		sucEr : function(a,b){
			if(parseInt(b) == 200){
				console.log("server response chart");
				if(parseInt(a) == 1){
					console.log("loading chart");
					setLoadingBarMessage("mengambil response data ...");
				}
				if(parseInt(a) == 2){
					console.log("loaded chart");
					setLoadingBarMessage("memperoleh response data ...");
				}
				if(parseInt(a) == 3){
					console.log("interactive chart");
					setLoadingBarMessage("menjawab response data ...");
				}
			}
			if(parseInt(b) == 500){
				console.log("error internal server chart");
				setLoadingBarMessage("server mengalami kesalahan instruksi ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},750);	
			}
			if(parseInt(b) == 404){
				console.log("server not found chart");
				setLoadingBarMessage("response tidak ditemukan ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},750);	
			}
			if(parseInt(b) >= 301 && parseInt(b) <= 303){
				console.log("page has been removed chart");
				setLoadingBarMessage("response di tolak ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},750);	
			}
		}
	});
}
function showImageTA1(namafile,md5source){
	data="<div style='max-width:100%; text-align:center; margin-left : auto; margin-right:auto;'><img style='max-width : 100%;' src='Filesupport/"+md5source+"/"+namafile+".jsp'></div>";
	modalStaticSingleInformation("Melihat gambar",data);
}
function showPdfTA1(namafile,md5source){
	data = '<div id="pdf-preview" style="max-width : 100%; text-align : center; margin-left : auto; margin-right:auto;">'+
	'<object type="application/pdf" data="'+"Filesupport/"+md5source+"/"+namafile+".jsp"+'" style="width : 100%; height : 540px" ><p>Browser anda tidak support pdf</p></object>'+
	'</div>';
	modalStaticSingleInformation("Melihat PDF",data);
}
function seminarTA1Agreement(a,b){
	openLoadingBar("merubah status seminar ...");
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Controlresultseminar/setNewStatusSeminarTA",
		content : "nim="+a+"&status="+$(b).val()+"&ta=1&symbolize=JASERVTECH-SET-NEW-STATUS-SEMINAR-TA",
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				setTimeout(function(){
					closeLoadingBar();
				},750);
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
				setTimeout(function(){
					refreshTableSeminarTA1();
				},1500);
			}
		},
		sucEr : function(a,b){
			
		}
	});
}

function approveThisPenguji(a,b){
	openLoadingBar("merubah status seminar ...");
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Controlresultseminar/setStatusProsesTester",
		content : "nim="+a+"&status="+b+"&symbolize=JASERVTECH-SET-STATUS-PROSES-TESTER",
		bool : true,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				setTimeout(function(){
					closeLoadingBar();
				},750);
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
				setTimeout(function(){
					refreshTableSeminarTA2();
				},750);
			}
		},
		sucEr : function(a,b){
			
		}
	});
}
function seminarTA2Agreement(a,b){
	openLoadingBar("merubah status seminar ...");
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Controlresultseminar/setNewStatusSeminarTA",
		content : "nim="+a+"&status="+$(b).val()+"&ta=2&symbolize=JASERVTECH-SET-NEW-STATUS-SEMINAR-TA",
		bool : true,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				refreshTableSeminarTA2();
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
				refreshTableSeminarTA2();
			}
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			
		}
	});
}

function changePenguji1(a,b){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/setNewPenguji",
		bool : true,
		methode : "POST",
		content : "nim="+a+"&nip="+$(b).val()+"&penguji=1",
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				if(activecanvasnow == 2){
					activecanvasnow = 5;	
					reloadChartSeminarAll(lastActive);	
				}
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			refreshTableSeminarTA2();
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}
function changePenguji2(a,b){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/setNewPenguji",
		bool : true,
		methode : "POST",
		content : "nim="+a+"&nip="+$(b).val()+"&penguji=2",
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				if(activecanvasnow == 3){
					activecanvasnow = 5;
					reloadChartSeminarAll(lastActive);
				}
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			refreshTableSeminarTA2();
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}
function changePenguji3(a,b){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/setNewPenguji",
		bool : true,
		methode : "POST",
		content : "nim="+a+"&nip="+$(b).val()+"&penguji=3",
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				if(activecanvasnow == 4){
					activecanvasnow = 5;
					reloadChartSeminarAll(lastActive);	
				}
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			refreshTableSeminarTA2();
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}

function refreshTableSeminarTA1(){
	tahunForSeminar = $("#tahun-seminar").val();
	semesterForSeminar = $("#semester-seminar").val();
	namaForSeminar = $("#search-name-seminar").val();
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/getTableSeminarTA1",
		bool : true,
		methode : "POST",
		content : "key="+namaForSeminar+"&"+
					"semester="+semesterForSeminar+"&"+
					"tahun="+tahunForSeminar,
		sucOk : function(a){
			if(a[0] == '1'){
				$("#tabel-pemerataan-seminar-ta1").html("");
				setLoadingBarMessage('proses respon server ...');
				$("#tabel-pemerataan-seminar-ta1").html(a.substr(1,a.length-1));
			}
			
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}

function refreshTableSeminarTA2(){
	tahunForSidang = $("#tahun-sidang").val();
	semesterForSidang = $("#semester-sidang").val();
	namaForSidang = $("#search-name-sidang").val();
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/getTableSeminarTA2",
		bool : true,
		methode : "POST",
		content : "key="+namaForSidang+"&"+
					"semester="+semesterForSidang+"&"+
					"tahun="+tahunForSidang,
		sucOk : function(a){
			if(a[0] == '1'){
				$("#tabel-pemerataan-seminar-ta2").html("");
				setLoadingBarMessage('proses respon server ...');
				$("#tabel-pemerataan-seminar-ta2").html(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},750);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 2 Session ...");
		}
	});
}
function giviTA1Seminar(nim, value){
	//alert(nim+' '+value);
	openLoadingBar("Mencoba merubah nilai ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/setValueSeminarTA1",
		bool : true,
		methode : "POST",
		content : "value="+value+"&nim="+nim+"&symbolize=JASERVTECH-SET-VALUE-SEMINAR-TA1",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(a[0] == '0'){
				setTimeout(function(){
					refreshTableSeminarTA1();
				},1500);
			}else{
				setTimeout(function(){
					closeLoadingBar();
				},750);	
			}
		},
		sucEr : function(a,b){
		}
	});
}
function giviTA2Seminar(nim, value){
	openLoadingBar("Mencoba merubah nilai ...");
	j("#setAjax").setAjax({
		url : "Controlresultseminar/setValueSeminarTA2",
		bool : true,
		methode : "POST",
		content : "value="+value+"&nim="+nim+"&symbolize=JASERVTECH-SET-VALUE-SEMINAR-TA2",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			if(a[0] == '0'){
				setTimeout(function(){
					refreshTableSeminarTA2();
				},1500);
			}else{
				setTimeout(function(){
					closeLoadingBar();
				},750);	
			}
		},
		sucEr : function(a,b){
			
		}
	});
}