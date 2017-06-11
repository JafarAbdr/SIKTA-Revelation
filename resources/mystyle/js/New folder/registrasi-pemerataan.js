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
		if(event.keyCode == 13)
			refreshTablePemerataanDanChart();
	});
	
}
function reloadTable(){
	openLoadingBar("refresh tabel ...");
	j("#setAjax").setAjax({
		methode:"POST",
		url : "Controlregistrasi/getPemerataanListMahasiswa.aspx",
		bool : true,
		content : "kode=controlroom&tahun="+tahunForPemerataan+"&semester="+semesterForPemerataan+"&key="+namaForPemerataan,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage('proses data ...');
				j('#tabel-pemerataan-mahasiswa').setInHtml(a.substr(1,a.length-1));
			}else
				setLoadingBarMessage('data gagal diambil ...');
			setTimeout(function(){
				closeLoadingBar();
				reloadChart();
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