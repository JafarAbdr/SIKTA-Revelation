var tempRekapNextPreControl = null;
var keyDosenRekapSearch = "";
var yearAktiv = "";
function reloadLayoutRekap(){
	$("#search-name-rekapitulasi").val(keyDosenRekapSearch);
	$("#search-name-rekapitulasi").keyup(function(event){
		if(event.keyCode == 13){
			tempRekapNextPreControl.setPage(1);
			refreshTableRekap(1);
		}
	});
	tempRekapNextPreControl = new NextPreControlClass({
		id : "table-rekap-next-prev",
		func : function(a){
			//alert(a);
			refreshTableRekap(a);
		}
	});
	$("#semester-ajaran").on('change',function(){
		tempRekapNextPreControl.setPage(1);
		refreshTableRekap(1);
	});
	refreshTableRekap(1);
}
function checkSemesterOnRekap(zz){
	var tempLT = document.getElementById('label-semester-ajaran');
	var tempLTS = document.getElementById('semester-ajaran');
	if(zz.value == 2000){
		tempLTS.value = 1;
		tempLT.style.display = 'none';
	}else{
		tempLTS.value = 1;
		tempLT.style.display = 'block';
	}
	$('#semester-ajaran').trigger('change');
}

function openXLRekap(url){
	var xx = document.createElement("a");
	xx.target = "_blank";
	xx.href = url+"/"+yearAktiv;
	xx.click();
}
function showLulus(g){
	openLoadingBar("mencoba mengambil data ...");
	//alert( "kode=JASERVCONTROL&nip="+g+"&year="+yearAktiv);
	j("#setAjax").setAjax(
	{
		methode : 'POST',
		url : 'Controlrekap/getJsonJumlahLulus.jsp',
		bool : true,
		content : "kode=JASERVCONTROL&nip="+g+"&year="+yearAktiv,
		sucOk : function(a){
			var message="";
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				var st = JSON.parse(a.substr(1,a.length-1));
				for(var i=0;i<st.data[0];i++){
					message += createContact(st.data[1][i][2],st.data[1][i][0],st.data[1][i][1]);
				}
				if(st.data[0] == 0)
					message += "<p style='text-align: center;'>data tidak ditemukan</p>";
			}else{
				setLoadingBarMessage("response gagal  ...");
				message += ("<p style='text-align: center;'>"+a.substr(1,a.length-1)+"</p>");
			}
			setTimeout(function(){
				closeLoadingBar();
				openModalContact(message,"daftar mahasiswa peserta lulus");
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"status refreshing list mahasiswa");
		}
	}
	);
}
function showTentor(g){
	openLoadingBar("mencoba mengambil data ...");
	j("#setAjax").setAjax(
	{
		methode : 'POST',
		url : 'Controlrekap/getJsonJumlahBimbingan.jsp',
		bool : true,
		content : "kode=JASERVCONTROL&nip="+g+"&year="+yearAktiv,
		sucOk : function(a){
			var message="";
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				var st = JSON.parse(a.substr(1,a.length-1));
				for(var i=0;i<st.data[0];i++){
					message += createContact(st.data[1][i][2],st.data[1][i][0],st.data[1][i][1]);
				}
				if(st.data[0] == 0)
					message += "<p style='text-align: center;'>data tidak ditemukan</p>";
			}else{
				setLoadingBarMessage("response gagal  ...");
				message += ("<p style='text-align: center;'>"+a.substr(1,a.length-1)+"</p>");
			}
			setTimeout(function(){
				closeLoadingBar();
				openModalContact(message,"daftar mahasiswa bimbingan");
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"status refreshing list mahasiswa");
		}
	}
	);
}
function showUji(g){
	openLoadingBar("mencoba mengambil data ...");
	j("#setAjax").setAjax(
	{
		methode : 'POST',
		url : 'Controlrekap/getJsonJumlahMenguji.jsp',
		bool : true,
		content : "kode=JASERVCONTROL&nip="+g+"&year="+yearAktiv,
		sucOk : function(a){
			var message="";
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				var st = JSON.parse(a.substr(1,a.length-1));
				for(var i=0;i<st.data[0];i++){
					message += createContact(st.data[1][i][2],st.data[1][i][0],st.data[1][i][1]);
				}
				if(st.data[0] == 0)
					message += "<p style='text-align: center;'>data tidak ditemukan</p>";
			}else{
				setLoadingBarMessage("response gagal  ...");
				message += ("<p style='text-align: center;'>"+a.substr(1,a.length-1)+"</p>");
			}
			setTimeout(function(){
				closeLoadingBar();
				openModalContact(message,"daftar mahasiswa peserta uji");
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"status refreshing list mahasiswa");
		}
	}
	);
}
function refreshTableRekap(page){
	keyDosenRekapSearch = $("#search-name-rekapitulasi").val();
	year = $("#tahun-ajaran").val()+""+$("#semester-ajaran").val();
	yearAktiv = year;
	openLoadingBar("refreshing tabel ...");
	//alert(year);
	j("#setajax").setAjax({
		methode : 'POST',
		url : base_url+'Controlrekap/getListDataRekap.jsp',
		bool : true,
		content : "kode=JASERVCONTROL&key="+keyDosenRekapSearch+"&page="+page+"&year="+year,
		sucOk : function(a){
			//alert(base_url+'Controlrekap/getListDataRekap.jsp');
			//alert(a);
			var tempJson = JSON.parse(a.substr(1,a.length-1));
			//alert("right : "+tempJson.right+" left : "+tempJson.left);
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				j('#data-table-rekap').setInHtml(null);
				j('#data-table-rekap').setInHtml(tempJson.output);
				var tempLeft = true;
				var tempRight = true;
				if(parseInt(tempJson.left) == 1)
					tempLeft = true;
				else
					tempLeft = false;
				if(parseInt(tempJson.right) == 1)
					tempRight = true;
				else
					tempRight = false;
				tempRekapNextPreControl.initialize({
					left : tempLeft,
					right : tempRight
				});
			}else{
				setLoadingBarMessage("response gagal  ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"status refreshing table");
		}
	});
}

