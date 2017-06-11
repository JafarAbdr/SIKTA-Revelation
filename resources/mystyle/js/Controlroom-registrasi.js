var initializingNewChart = false;
var chacheJavascriptChart = null;
var tahunForPemerataan = null;
var semesterForPemerataan = null;
var namaForPemerataan = null;
var pageApprove = 1;
var totalListPemerataanAktive = 0;
var nimListPemerataanAktive = "";
var initChangeColumn = false;
function reloadRegistrasiPemerataan(){
	if(tahunForPemerataan!=null)
		$("#tahun-ajaran").val(tahunForPemerataan);
	if(semesterForPemerataan != null)
		$("#semester-ajaran").val(semesterForPemerataan);
	if(namaForPemerataan != null)
		$("#search-name-pemerataan").val(namaForPemerataan);
	initChangeColumn = true;
	initializingNewChart = false;
	refreshTablePemerataanDanChart();
	$("#search-name-pemerataan").keyup(function(event){
		if(event.keyCode == 13){
			pageApprove = 1;
			initializingNewChart = false;
			refreshTablePemerataanDanChart();
		}
	});
}
function refreshTablePemerataanDanChart(){
	tahunForPemerataan = $("#tahun-ajaran").val();
	semesterForPemerataan = $("#semester-ajaran").val();
	namaForPemerataan = $("#search-name-pemerataan").val();
	reloadChart();
	reloadTable();
}
function reloadChart(){
	openLoadingBar("mengambil diagram ...");
	if(!initializingNewChart){
		initializingNewChart = true;
		j('#setAjax').setAjax({
			methode : 'POST',
			url : 'Controlresultregistrasi/getJsonTableNow.jsp',
			bool : true,
			content : "kode=JASERVCONTROL&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
			sucOk : function(a){
				if(a[0]=='1'){
					setLoadingBarMessage("response diagram diproses ...");
					chacheJavascriptChart = JSON.parse(a.substr(1,a.length-1));
					reloadTableChart();
				}else{
					setLoadingBarMessage("response diagram gagal  ...");
				}
				setTimeout(function(){
					closeLoadingBar();
				},800);
			},
			sucEr : function(a,b){
				
			}
		});
		return;
	}
	setLoadingBarMessage("response diagram diproses ...");
	closeLoadingBar();
}
function reloadTableChart(){
	
	lineChartData.labels = chacheJavascriptChart.data[0];
	lineChartData.datasets[0].data = chacheJavascriptChart.data[1];
	resetDiagram();
	var ctx = document.getElementById("canvas").getContext("2d");
	window.myLine = null;
	window.myLine = new Chart(ctx).Line(lineChartData, {
		responsive: true
	});
}
var randomScalingFactor = function(){ 
	return Math.round(Math.random()*100)
};
var lineChartData = {
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
function openXLForm(url){
	var year = $('#tahun-ajaran').val();
	var semester = $('#semester-ajaran').val();
	var xx = document.createElement("a");
	xx.target = "_blank";
	xx.href = url+"/"+year+""+semester;
	xx.click();
}
function resetDiagram(){
	j('#controller-diagram').setInHtml("");
	j('#controller-diagram').setInHtml("<canvas id='canvas' height='450' width='2048' style='color: rgba(220,220,200,1);'></canvas>");
}
function reloadTable(){
	openLoadingBar("refresh tabel ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlresultregistrasi/getPemerataanListMahasiswa.jsp",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan+"&page="+pageApprove,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('proses data ...');
				a=a.split("|");
				j('#tabel-pemerataan-mahasiswa').setInHtml(a[0].substr(1,a[0].length-1));
				j('#table-pemerataan-next-prev').setInHtml(a[1]);
				totalListPemerataanAktive = parseInt(a[2]);
				nimListPemerataanAktive = "";
				if(totalListPemerataanAktive > 0){
					nimListPemerataanAktive = a[3].split(",");
				}
				if(initChangeColumn){
					initChangeColumn = false;
					$("#tahun-ajaran").on('change',function(){
						pageApprove = 1;
						initializingNewChart = false;
						refreshTablePemerataanDanChart();
					});
					$("#semester-ajaran").on('change',function(){
						pageApprove = 1;
						initializingNewChart = false;
						refreshTablePemerataanDanChart();
					});
				}
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				closeLoadingBar();
				//reloadChart();
			},600);
		}
	});
}
function previousPageRegistrasiBase(){
	pageApprove-=1;
	reloadTable();
}
function nextPageRegistrasiBase(){
	pageApprove+=1;
	reloadTable();
}
function changeValueOfDosenOnChart(nip,cat){
	tempI = 0;
	while(chacheJavascriptChart.data[2][tempI]){
		//alert(chacheJavascriptChart.data[2][tempI]+" "+nip);
		if(chacheJavascriptChart.data[2][tempI] == nip){
			switch(cat){
				case '+' : chacheJavascriptChart.data[1][tempI] = (parseInt(chacheJavascriptChart.data[1][tempI]) + 1); break;
				case '-' : chacheJavascriptChart.data[1][tempI] = (parseInt(chacheJavascriptChart.data[1][tempI]) - 1); break;
			}
		}
		tempI++;
	}
}
function changeDospem(nim,id,tempRight){
	console.log(id.oldvalue+" "+id.value);
	//alert(id.value+" "+id.oldvalue);
	if(parseInt(id.value) == 0){
		if(parseInt(tempRight.value) == 0){
			tempRight.value = id.oldvalue;
		}
	}else{
		changeValueOfDosenOnChart(id.value,"+");
		if(parseInt(tempRight.value) == 0){
			tempRight.value = id.oldvalue;
		}else if(tempRight.value == id.value){
			tempRight.value = 0;
		}
	}
	if(parseInt(id.oldvalue) != 0){
		changeValueOfDosenOnChart(id.oldvalue,"-");
	}
	id.oldvalue = id.value;
	reloadTableChart();
}
function saveAllPemerataanList(){
	openLoadingBar("Process this page ...");
	if(totalListPemerataanAktive <= 0){
		setLoadingBarMessage("tidak ada data yang aktif pada list1");
		setTimeout(function(){
			closeLoadingBar();
		},800);
		return;
	}
	nim = "";
	nip = "";
	dataNimNip = 0;
	for(tempI = 1; tempI <= totalListPemerataanAktive;tempI++){
		if(document.getElementById('select-satu-'+tempI)){	
			nim += nimListPemerataanAktive[tempI-1]+",";
			nip += document.getElementById('select-satu-'+tempI).value+",";
			dataNimNip++;
			/* if(document.getElementById('select-dua-'+tempI).value != 0){
				
			} */
		}
	}
	//alert(nim+" "+nip+" "+dataNimNip);
	nim = nim.substr(0,nim.length-1);
	nip = nip.substr(0,nip.length-1);
	if(dataNimNip>1){
		tempSenDospem(nim,nip,'two');
	}else if(dataNimNip == 1){
		tempSenDospem(nim,nip,'one');
	}else{
		setLoadingBarMessage("tidak ada data yang aktif pada list2");
		setTimeout(function(){
			closeLoadingBar();
		},800);
	}
	return;
}
function tempSenDospem(nim,nip,kode){
	openLoadingBar("menyimpan perubahan ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : "Controlresultregistrasi/setDospem.jsp",
		content : "nim="+nim+"&nip="+nip+"&kode=JASERVCONTROL&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&kodes="+kode,
		bool : true,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('perubahan berhasil disimpan ...');	
				setTimeout(function(){
					closeLoadingBar();
					initializingNewChart = false;
					reloadChart();
					reloadTable();
				},800);	
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+' ...');
				setTimeout(function(){
					closeLoadingBar();
					initializingNewChart = false;
					reloadChart();
					reloadTable();
				},800);	
			}
		},
		sucEr : function(a,b){
		
		}
	});
}
















function setOnThisPageAsJustOne(tempKodeSTM){
	openLoadingBar("Process this page ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlresultregistrasi/setOnlyThisPage.jsp",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan+"&page="+pageApprove+"&kodeS="+tempKodeSTM,
		sucOk : function(a){
			if(a[0] == '1'){
				//alert(a);
				modalStaticSingleInformation("Hasil Perubahan","<div style='padding : 10px;'>"+a.substr(1,a.length-1)+"</div>");
				reloadTable();
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				closeLoadingBar();
			},1500);
		}
	});
}

function setOnThisPageAsForAll(tempKodeSTM){
	openLoadingBar("Process this page ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlresultregistrasi/setAllEveryRegister.jsp",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan+"&page="+pageApprove+"&kodeS="+tempKodeSTM,
		sucOk : function(a){
			if(a[0] == '1'){
				//alert(a);
				modalStaticSingleInformation("Hasil Perubahan","<div style='padding : 10px;'>"+a.substr(1,a.length-1)+"</div>");
				reloadTable();
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				closeLoadingBar();
			},800);
		}
	});
}/*  */
//
function detailThisGuys(a){
	//dataActive = a;
	openLoadingBar("mengambil data mahasiswa");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlresultregistrasi/getInfoMahasiswaFull.jsp',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+a,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				openModalContact(a.substr(1,a.length-1),"Tentang Mahasiswa");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi info mahasiswa");
		}
	});
}
function detailThisDospem(a,x){
	nip = document.getElementById('select-satu-'+x).value;
	if(nip == "0")
		return;
	//dataActive = a;
	openLoadingBar("mengambil data dosen");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlresultregistrasi/getInfoDosenFull.jsp',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+a+"&nip="+nip,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				openModalContact(a.substr(1,a.length-1),"Tentang Mahasiswa");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi info dosen");
		}
	});
}
function detailCompareThisGuysWithDospem(a,x){
	
nip = document.getElementById('select-satu-'+x).value;
	if(nip == "0")
		return;
	//alert(nip);
	//return;
	//dataActive = a;
	openLoadingBar("mengambil data dosen compare");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlresultregistrasi/getInfoDosenAndMahasiswaComparasiFull.jsp',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+a+"&nip="+nip,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				openModalContact(a.substr(1,a.length-1),"Tentang Mahasiswa");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi info dosen compare");
		}
	});
}
function changeDataProses(aaa,b){
	//alert(a+" "+b);
	//return;
	//dataActive = a;
	openLoadingBar("merubah data status register");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlresultregistrasi/setStatusMahasiswaRegister.jsp',
		bool : true,
		content : "kode=JASERVTECH-KODE&nim="+aaa+"&kodeS="+b,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1));
			}
			reloadTable();
			reloadChart();
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi status register");
		}
	});
}