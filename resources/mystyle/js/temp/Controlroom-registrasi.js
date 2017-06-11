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
var tahunForPemerataan = null;
var semesterForPemerataan = null;
var namaForPemerataan = null;
function refreshTablePemerataanDanChart(){
	tahunForPemerataan = $("#tahun-ajaran").val();
	semesterForPemerataan = $("#semester-ajaran").val();
	namaForPemerataan = $("#search-name-pemerataan").val();
	reloadTable();
}
function resetDiagram(){
	j('#controller-diagram').setInHtml("");
	j('#controller-diagram').setInHtml("<canvas id='canvas' height='450' width='2048' style='color: rgba(220,220,200,1);'></canvas>");
	
}
function reloadChart(){
	openLoadingBar("mengambil diagram ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlregistrasi/getJsonTableNow.aspx',
		bool : true,
		content : "kode=JASERVCONTROL&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
		sucOk : function(a){
			if(a[0]=='1'){
				setLoadingBarMessage("response diagram diproses ...");
				var temm = JSON.parse(a.substr(1,a.length-1));
				lineChartData.labels = temm.data[0];
				lineChartData.datasets[0].data = temm.data[1];
				resetDiagram();
				var ctx = document.getElementById("canvas").getContext("2d");
				window.myLine = null;
				window.myLine = new Chart(ctx).Line(lineChartData, {
					responsive: true
				});
			}else{
				setLoadingBarMessage("response diagram gagal  ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
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
var pageApprove = 1;
function reloadRegistrasiPemerataan(){
	if(tahunForPemerataan!=null)
		$("#tahun-ajaran").val(tahunForPemerataan);
	if(semesterForPemerataan != null)
		$("#semester-ajaran").val(semesterForPemerataan);
	if(namaForPemerataan != null)
		$("#search-name-pemerataan").val(namaForPemerataan);
	//reloadTable();
	//cari
	refreshTablePemerataanDanChart();
	$("#search-name-pemerataan").keyup(function(event){
		if(event.keyCode == 13){
			pageApprove = 1;
			refreshTablePemerataanDanChart();
		}
	});
	
}
function reloadTable(){
	openLoadingBar("refresh tabel ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlregistrasi/getPemerataanListMahasiswa.aspx",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan+"&page="+pageApprove,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('proses data ...');
				a=a.split("|");
				j('#tabel-pemerataan-mahasiswa').setInHtml(a[0].substr(1,a[0].length-1));
				j('#table-pemerataan-next-prev').setInHtml(a[1]);
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				closeLoadingBar();
				reloadChart();
			},1500);
		}
	});
}
function setOnThisPageAsJustOne(tempKodeSTM){
	openLoadingBar("Process this page ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlregistrasi/setOnlyThisPage.aspx",
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
		url : "Controlregistrasi/setAllEveryRegister.aspx",
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
function changeDospem(nim,value){
	openLoadingBar("menyimpan perubahan ...");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : "Controlregistrasi/setDospem.aspx",
		content : "nim="+nim+"&nip="+value+"&kode=JASERVCONTROL&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan,
		bool : true,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('perubahan berhasil disimpan ...');	
				setTimeout(function(){
					closeLoadingBar();
					reloadChart();
					reloadTable();
				},2000);	
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+' ...');
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
		},
		sucEr : function(a,b){
			if(parseInt(b) == 200){
				console.log("server response "+nim+" "+value);
				if(parseInt(a) == 1){
					console.log("loading "+nim+" "+value);
					setLoadingBarMessage("mengambil response data ...");
				}
				if(parseInt(a) == 2){
					console.log("loaded "+nim+" "+value);
					setLoadingBarMessage("memperoleh response data ...");
				}
				if(parseInt(a) == 3){
					console.log("interactive "+nim+" "+value);
					setLoadingBarMessage("menjawab response data ...");
				}
			}
			if(parseInt(b) == 500){
				console.log("error internal server "+nim+" "+value);
				setLoadingBarMessage("server mengalami kesalahan instruksi ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
			if(parseInt(b) == 404){
				console.log("server not found "+nim+" "+value);
				setLoadingBarMessage("response tidak ditemukan ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
			if(parseInt(b) >= 301 && parseInt(b) <= 303){
				console.log("page has been removed "+nim+" "+value);
				setLoadingBarMessage("response di tolak ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
		}
	});
}
function addSession(a){
	openLoadingBar("tagging pada nim");
	j("#setAjax").setAjax({
		url : "Controlregistrasi/setOnOrOfHandleLog.aspx",
		bool : true,
		methode : "POST",
		content : "kode=JASERVCONTROL&nim="+a,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('perubahan berhasil disimpan ...');	
				setTimeout(function(){
					closeLoadingBar();
					reloadChart();
					reloadTable();
				},2000);	
			}else{
				setLoadingBarMessage(a.substr(1,a.length-1)+' ...');
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
		},
		sucEr : function(a,b){
			if(parseInt(b) == 200){
				console.log("server response "+nim+" "+value);
				if(parseInt(a) == 1){
					console.log("loading "+nim+" "+value);
					setLoadingBarMessage("mengambil response data ...");
				}
				if(parseInt(a) == 2){
					console.log("loaded "+nim+" "+value);
					setLoadingBarMessage("memperoleh response data ...");
				}
				if(parseInt(a) == 3){
					console.log("interactive "+nim+" "+value);
					setLoadingBarMessage("menjawab response data ...");
				}
			}
			if(parseInt(b) == 500){
				console.log("error internal server "+nim+" "+value);
				setLoadingBarMessage("server mengalami kesalahan instruksi ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
			if(parseInt(b) == 404){
				console.log("server not found "+nim+" "+value);
				setLoadingBarMessage("response tidak ditemukan ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
			if(parseInt(b) >= 301 && parseInt(b) <= 303){
				console.log("page has been removed "+nim+" "+value);
				setLoadingBarMessage("response di tolak ...");
				setTimeout(function(){
					closeLoadingBar();
					reloadTable();
				},2000);	
			}
		}
	});
}
function dropSession(a){
	addSession(a);
}
//
function detailThisGuys(a){
	//dataActive = a;
	openLoadingBar("mengambil data mahasiswa");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlregistrasi/getInfoMahasiswaFull.aspx',
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
	
	x = x.parentNode;
	x = x.parentNode;
	x = x.parentNode;
	x = x.childNodes[0];
	nip = x.childNodes[0].value;
	if(nip == "0")
		return;
	//dataActive = a;
	openLoadingBar("mengambil data dosen");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlregistrasi/getInfoDosenFull.aspx',
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
	
	x = x.parentNode;
	x = x.parentNode;
	x = x.parentNode;
	x = x.childNodes[0];
	nip = x.childNodes[0].value;
	if(nip == "0")
		return;
	//alert(nip);
	//return;
	//dataActive = a;
	openLoadingBar("mengambil data dosen compare");
	j('#setAjax').setAjax({
		methode : 'POST',
		url : 'Controlregistrasi/getInfoDosenAndMahasiswaComparasiFull.aspx',
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
		url : 'Controlregistrasi/setStatusMahasiswaRegister.aspx',
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
function previousPageRegistrasiBase(){
	pageApprove-=1;
	reloadTable();
}
function nextPageRegistrasiBase(){
	pageApprove+=1;
	reloadTable();
}