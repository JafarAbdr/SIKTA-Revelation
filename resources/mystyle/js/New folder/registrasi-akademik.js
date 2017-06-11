function registrasiAkademikMahasiswa(){
	reloadTableRegistrasiMahasiswa();
	$("#search-nama-mahasiswa-registrasi").keyup(function(event){
		if(event.keyCode == 13){
			keyWordRegistrasiMahasiswa = $(this).val();
			reloadTableRegistrasiMahasiswa();
		}
	});
}
var keyWordRegistrasiMahasiswa = null;
function reloadTableRegistrasiMahasiswa(){
	if(keyWordRegistrasiMahasiswa == null){
		$("#search-nama-mahasiswa-registrasi").val("");
		keyWordRegistrasiMahasiswa = "";
	}else{
		$("#search-nama-mahasiswa-registrasi").val(keyWordRegistrasiMahasiswa)
	}
	openLoadingBar("memperoleh data mahasiswa");
	j("#setAjax").setAjax({
		url : base_url+"Palaceregistrasi/getTableAllAcountMahasiswa.aspx",
		methode : 'post',
		bool : true,
		content : "keyword="+$("#search-nama-mahasiswa-registrasi").val(),
		sucOk : function(a){
			if(a[0]=="1"){
				setLoadingBarMessage("data sedang di proses");
				$("#tabel-pemerataan-mahasiswa-registrasi").html(a.substr(1,a.length-1));
			}else{
				setLoadingBarMessage("data gagal diproses");
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi tabel");
		}
	});
}
function aktifkanThisGuysAccount(aa){
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Palaceregistrasi/setAktifOrNon.aspx",
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
			},2000);
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
		url : base_url+"Palaceregistrasi/setOneOrTwo.aspx",
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
			},2000);
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
		url : base_url+"Palaceregistrasi/setOneOrTwo.aspx",
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
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa seminar ta 2");
		}
	});
}
function nonAktifkanThisGuysAccount(aa){
	openLoadingBar("memproses permintaan");
	j("#setAjax").setAjax({
		url : base_url+"Palaceregistrasi/setAktifOrNon.aspx",
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
			},2000);
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
		url : base_url+"Palaceregistrasi/setNormalNewOrOld.aspx",
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
			},2000);
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
		url : base_url+"Palaceregistrasi/setNormalNewOrOld.aspx",
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
			},2000);
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
		url : base_url+"Palaceregistrasi/setNormalNewOrOld.aspx",
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
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"sesi mahasiswa registrasi lama");
		}
	});
}