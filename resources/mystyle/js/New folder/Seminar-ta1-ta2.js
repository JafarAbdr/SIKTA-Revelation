var startSeminarPage = true;
function tableTA1TA2Seminar(){
	//alert("");
	refreshTableSeminarTA1();
	Chart.defaults.global.responsive = true;
	//reloadChartSeminarAll();
	/*
	 var ctx = document.getElementById("canvas1").getContext("2d");
	window.myLines = null;
	window.myLines = new Chart(ctx).Line(lineChartDataS);
	var ctx = document.getElementById("canvas2").getContext("2d");
	window.myLines = new Chart(ctx).Line(lineChartDataS);
	var ctx = document.getElementById("canvas3").getContext("2d");
	window.myLines = new Chart(ctx).Line(lineChartDataS); */
	window.myLines = null;
	//alert("");
	startSeminarPage = true;
	var ff = function(){
		if(startSeminarPage){
			startSeminarPage = false;
			//alert("");
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
	//alert(id+" "+url+" "+dia);
	//return ;
	$('#'+dia).html("");
	$('#'+dia).html("<canvas id='"+id+"' height='450' width='2048'  style='color: rgba(220,220,200,1);'></canvas>");
	//alert($('#'+dia).html());
	//return;
	openLoadingBar("mengambil diagram ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlseminar/'+url+'.aspx',
		bool : true,
		content : "kode=JASERVCONTROL",
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
				//zzzz();
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
				},2000);	
			}
			if(parseInt(b) == 404){
				console.log("server not found chart");
				setLoadingBarMessage("response tidak ditemukan ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
			if(parseInt(b) >= 301 && parseInt(b) <= 303){
				console.log("page has been removed chart");
				setLoadingBarMessage("response di tolak ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
		}
	});
}
function showImageTA1(namafile,md5source){
	data="<div style='max-width:100%; text-align:center; margin-left : auto; margin-right:auto;'><img style='max-width : 100%;' src='Filesupport/"+md5source+"/"+namafile+".aspx'></div>";
	modalStaticSingleInformation("Melihat gambar",data);
	//alert("image "+url);
}
function showPdfTA1(namafile,md5source){
	data = '<div id="pdf-preview" style="max-width : 100%; text-align : center; margin-left : auto; margin-right:auto;">'+
	//'<iframe src="http://docs.google.com/gview?url=http://infolab.stanford.edu/pub/papers/google.pdf&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>'+
	//'<object data="'+"Filesupport/"+md5source+"/"+namafile+".aspx"+'"></object>'+
	'<object type="application/pdf" data="'+"Filesupport/"+md5source+"/"+namafile+".aspx"+'" style="width : 100%; height : 540px" ><p>Browser anda tidak support pdf</p></object>'+
	'</div>';
	//data="<div width='max-width:100%; text-align:center;'><img style='max-width : 100%;' src='Filesupport/"+md5source+"/"+namafile+".aspx'></div>";
	modalStaticSingleInformation("Melihat PDF",data);
	/*
	setTimeout(function(){
		PDFObject.embed("Filesupport/"+md5source+"/"+namafile+".aspx", "#pdf-preview");
	},2000);
	*/
	//alert("pdf "+namafile);
}
function seminarTA1Agreement(a,b){
	openLoadingBar("merubah status seminar ...");
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Controlseminar/setNewStatusSeminarTA.aspx",
		content : "nim="+a+"&status="+$(b).val()+"&ta=1",
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
				refreshTableSeminarTA1();
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			
		}
	});
}

function seminarTA2Agreement(a,b){
	openLoadingBar("merubah status seminar ...");
	j("#setAjax").setAjax({
		methode : "POST",
		url : "Controlseminar/setNewStatusSeminarTA.aspx",
		content : "nim="+a+"&status="+$(b).val()+"&ta=2",
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				refreshTableSeminarTA2();
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
				refreshTableSeminarTA2();
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			
		}
	});
}

function changePenguji1(a,b){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlseminar/setNewPenguji.aspx",
		bool : true,
		methode : "POST",
		content : "nim="+a+"&nip="+$(b).val()+"&penguji=1",
		sucOk : function(a){
			//alert(a);
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				//alert(activecanvasnow);
				if(activecanvasnow == 2){				
					activecanvasnow = 4;
					reloadChartSeminarAll(lastActive);	
				}
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			refreshTableSeminarTA2();
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}
function changePenguji2(a,b){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlseminar/setNewPenguji.aspx",
		bool : true,
		methode : "POST",
		content : "nim="+a+"&nip="+$(b).val()+"&penguji=2",
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage(a.substr(1,a.length-1));
				if(activecanvasnow == 3){				
					activecanvasnow = 4;
					reloadChartSeminarAll(lastActive);	
				}
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			refreshTableSeminarTA2();
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}

function refreshTableSeminarTA1(){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlseminar/getTableSeminarTA1.aspx",
		bool : true,
		methode : "POST",
		content : "",
		sucOk : function(a){
			//alert(a);
			if(a[0] == '1'){
				$("#tabel-pemerataan-seminar-ta1").html("");
				setLoadingBarMessage('proses respon server ...');
				$("#tabel-pemerataan-seminar-ta1").html(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 1 Session ...");
		}
	});
}

function refreshTableSeminarTA2(){
	openLoadingBar("kontak server ...");
	j("#setAjax").setAjax({
		url : "Controlseminar/getTableSeminarTA2.aspx",
		bool : true,
		methode : "POST",
		content : "",
		sucOk : function(a){
			//alert(a);
			if(a[0] == '1'){
				$("#tabel-pemerataan-seminar-ta2").html("");
				setLoadingBarMessage('proses respon server ...');
				$("#tabel-pemerataan-seminar-ta2").html(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"Seminar TA 2 Session ...");
		}
	});
}
