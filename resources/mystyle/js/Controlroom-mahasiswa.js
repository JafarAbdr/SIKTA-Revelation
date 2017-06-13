function registrasiAkademikMahasiswa(){
	tempMahasiswaNextPreControl = new NextPreControlClass({
		id : "table-mahasiswa-next-prev",
		func : function(a){
			//alert(a);
			reloadTableRegistrasiMahasiswa(a);
		}
	});
	reloadTableRegistrasiMahasiswa(1);
	$("#search-nama-mahasiswa-registrasi").keyup(function(event){
		if(event.keyCode == 13){
			keyWordRegistrasiMahasiswa = $(this).val();
			tempMahasiswaNextPreControl.setPage(1);
			reloadTableRegistrasiMahasiswa(1);
		}
	});
}
var tempMahasiswaNextPreControl = null;
var keyWordRegistrasiMahasiswa = null;
function reloadTableRegistrasiMahasiswa(page){
	if(keyWordRegistrasiMahasiswa == null){
		$("#search-nama-mahasiswa-registrasi").val("");
		keyWordRegistrasiMahasiswa = "";
	}else{
		$("#search-nama-mahasiswa-registrasi").val(keyWordRegistrasiMahasiswa)
	}
	openLoadingBar("memperoleh data mahasiswa");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/getTableAllAcountMahasiswa",
		methode : 'post',
		bool : true,
		content : "keyword="+$("#search-nama-mahasiswa-registrasi").val()+"&page="+page,
		sucOk : function(a){
			var tempJson = JSON.parse(a.substr(1,a.length-1));
			//alert();
			if(a[0]=="1"){
				setLoadingBarMessage("data sedang di proses");
				$("#tabel-pemerataan-mahasiswa-registrasi").html(tempJson.string);
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
				tempMahasiswaNextPreControl.initialize({
					left : tempLeft,
					right : tempRight
				});
			}else{
				setLoadingBarMessage("data gagal diproses");
			}
			setTimeout(function(){
				closeLoadingBar();
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi tabel");
		}
	});
}
function aktifkanThisGuysAccount(aa){
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setAktifOrNon",
		methode : 'post',
		bool : true,
		content : "nim="+aa,
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi tabel");
		}
	});
	//alert("aktifkan "+a);
}
function tryNoTime(aa){
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/tryNoTime",
		methode : 'post',
		bool : true,
		content : "nim="+aa,
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi tabel");
		}
	});
	//alert("aktifkan "+a);
}
function setSeminarTA1(aa){
	//alert("semiar ta 2 "+a);
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setOneOrTwo",
		methode : 'post',
		bool : true,
		content : "nim="+aa+"&kode=1",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa seminar ta 1");
		}
	});
}
function setSeminarTA2(aa){
	//alert("seminar ta 2 "+a);
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setOneOrTwo",
		methode : 'post',
		bool : true,
		content : "nim="+aa+"&kode=2",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa seminar ta 2");
		}
	});
}
function nonAktifkanThisGuysAccount(aa){
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setAktifOrNon",
		methode : 'post',
		bool : true,
		content : "nim="+aa,
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi tabel");
		}
	});
	//alert("non aktifkan "+a);
}
function normalSeminar(aa){
	//alert("normal "+a);
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setNormalNewOrOld",
		methode : 'post',
		bool : true,
		content : "nim="+aa+"&kode=1",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi normal");
		}
	});
}
function newForceSeminar(aa){
	//alert("new "+a);
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setNormalNewOrOld",
		methode : 'post',
		bool : true,
		content : "nim="+aa+"&kode=2",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi baru");
		}
	});
}
function lastForceSeminar(aa){
	//alert("last "+a);
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Controlakunmahasiswa/setNormalNewOrOld",
		methode : 'post',
		bool : true,
		content : "nim="+aa+"&kode=3",
		sucOk : function(a){
			setLoadingBarMessage(a.substr(1,a.length-1));
			setTimeout(function(){
				closeLoadingBar();
				if(a[0]=="1"){
					reloadTableRegistrasiMahasiswa();
				}
			},400);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi lama");
		}
	});
}