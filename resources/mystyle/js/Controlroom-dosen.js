function statusDosen(a,b){
	openLoadingBar("melakukan perubahan data");
	j("#setajax").setAjax({
		methode : 'POST',
		url : 'Controldosens/setNewStatusDosen',
		bool : true,
		content : "kode=JASERVCONTROL&nip="+a+"&status="+b,
		sucOk : function(a){
			//alert(a);
			if(parseInt(a[0]) > 0){
				setLoadingBarMessage("response berhasil diproses ...");
				setTimeout(function(){
					refreshTable();	
					closeLoadingBar();
				},400);
			}else{
				//alert("response gagal");
				setLoadingBarMessage("response gagal  ...");
				setTimeout(function(){
					refreshTable();	
					closeLoadingBar();
				},400);
			}
		},
		sucEr : function(a,b){
			template(a,b,"status editing dosen");
		}
	});
}
var keyDosenSearch = null;
var tempDosenNextPreControl = null;
function reloadLayoutDosen(){
	if(keyDosenSearch != null)
		$("#search-dosen").val(keyDosenSearch);
	refreshTable(1);
	$("#search-dosen").keyup(function(event){
		if(event.keyCode == 13){
			tempDosenNextPreControl.setPage(1);
			refreshTable(1);
		}
	});
	tempDosenNextPreControl = new NextPreControlClass({
		id : "table-dosen-next-prev",
		func : function(a){
			//alert(a);
			refreshTable(a);
		}
	});
}
function addNewDosen(){
	dataNewEvent['nama'] = 1;
	dataNewEvent['nip'] = 1;
	var temp = createInputModal("Nama Dosen","TEXT","","Masukan Nama Dosen","","add-nama-dosen","add-nama-dosen","");
	temp += createInputModal("Nip Dosen","TEXT","","mmasukan nip","","add-nip-dosen","add-nip-dosen","");
	openModalForm(temp,function(a){
		openLoadingBar("Data input proses ...");	
			setTimeout(function(){
				var error = 0;
				if(dataNewEvent['nama'] == 1){
					setLoadingBarMessage("input data judul salah ...");	
					error+=1;
					showDataErrorInput('title-event-new','Periksalah inputan anda, tidak boleh kosong');
				}
				if(dataNewEvent['nip'] == 1){
					setLoadingBarMessage("input data Nip salah ...");	
					error+=1;
					showDataErrorInput('summary-event-new','Periksalah inputan anda, tidak boleh kosong');
				}
				if(error == 0){
					j('#setAjax').setAjax({
						methode : "POST",
						bool : true,
						url : "Controldosens/addNewDosen",
						content : 
						"nama="+$('#add-nama-dosen').val()+
						"&nip="+$('#add-nip-dosen').val()+
						"&kode=JASERVTECH-CODE-CREATE-NEW-DOSEN",
						sucOk : function(b){
							if(b[0] == '1'){
								setLoadingBarMessage("input data diproses ...");
								//refreshAcaraNonDefault();
								reloadLayoutDosen();
								a(true);
							}else{
								setLoadingBarMessage("kesalahan "+b.substr(1,b.length-1)+" ...");	
							}
							setTimeout(function(){
								closeLoadingBar();
							},400);
						},
						sucEr : function(a,b){
							template(a,b,"<i>Submitting </i> Data ke server");
						}
					});
				}else{
					setTimeout(function(){
						closeLoadingBar();
					},400);
				}
			},400);
		}
	);
	$('#add-nama-dosen').on('change',function(){
		openLoadingBar("check input title ...");
		if($(this).val() == ""){
			showDataErrorInput('add-nama-dosen','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controldosens/getCheck",
				bool : true,
				content : "value="+$(this).val()+"&kode=NAMA&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataNewEvent['nama'] = 0;
						hideDataErrorInput('add-nama-dosen');
					}else{
						dataNewEvent['title'] = 1;
						showDataErrorInput('add-nama-dosen',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},400);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
	$('#add-nip-dosen').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showDataErrorInput('add-nip-dosen','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controldosens/getCheck",
				bool : true,
				content : "value="+$(this).val()+"&kode=NIP&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataNewEvent['nip'] = 0;
						hideDataErrorInput('add-nip-dosen');
					}else{
						dataNewEvent['nip'] = 1;
						showDataErrorInput('add-nip-dosen',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},400);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
}

function showListMahasiswaAmpuan(g){
	openLoadingBar("mencoba mengambil data ...");
	j("#setAjax").setAjax(
	{
		methode : 'POST',
		url : 'Controldosens/getJsonListMahasiswa',
		bool : true,
		content : "nip="+g,
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
function refreshTable(page){
	keyDosenSearch = $("#search-dosen").val();
	openLoadingBar("refreshing tabel ...");
	j("#setajax").setAjax({
		methode : 'POST',
		url : 'Controldosens/getTableDosen',
		bool : true,
		content : "kode=JASERVCONTROL&key="+keyDosenSearch+"&page="+page,
		sucOk : function(a){
			var tempJson = JSON.parse(a.substr(1,a.length-1));
			if(a[0]=='1'){
				setLoadingBarMessage("response berhasil diproses ...");
				j('#data-table-dosen').setInHtml(null);
				$("#data-table-dosen").html(tempJson.string);
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
				tempDosenNextPreControl.initialize({
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