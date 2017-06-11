var acaraTableNonDefault = 1000;
//default system call
function mainAcara(){
	refreshAcaraDefault(); //ok
	refreshAcaraNonDefault();
	$("#search-semester").keyup(function(event){
	    if(event.keyCode == 13){
	    	if(!isNaN($(this).val())){
	    		if(parseInt($(this).val())> 1000){
	    			acaraTableNonDefault=parseInt($(this).val());
	    			refreshAcaraNonDefault();
	    		}else{
	    			acaraTableNonDefault=1000;
		    		refreshAcaraNonDefault();
	    		}
	    	}else{
	    		acaraTableNonDefault=1000;
	    		refreshAcaraNonDefault();
	    	}
	    }
	});
	$('#add-new-event').on('click',function(){
		addNewEvent();
	});
}
function refreshAcaraDefault(){
	openLoadingBar("mengambil data tabel ...");
	j('#setAjax').setAjax({
		methode : "POST",
		url : "Controlacara/getTableAcara.aspx",
		bool : true,
		content : "kode=JASERVCONTROL",
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage("proses pesan server ...");
				j("#tabel-acara-default").setInHtml(a.substr(1,a.length-1));
			}else{
				setLoadingBarMessage("pesan server gagal proses ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"<i>Refreshing</i> tabel acara");
		}
	});
}
function refreshAcaraNonDefault(){
	openLoadingBar("mengambil data tabel ...");
	j('#setAjax').setAjax({
		methode : "POST",
		url : "Controlacara/getTableAcaraNonDefault.aspx",
		bool : true,
		content : "kode=JASERVCONTROL&year="+acaraTableNonDefault,
		sucOk : function(a){
			if(a[0] == '1'){
				setLoadingBarMessage("proses pesan server ...");
				j("#tabel-acara-lain").setInHtml(a.substr(1,a.length-1));
			}else{
				setLoadingBarMessage("pesan server gagal proses ...");
			}
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"<i>Refreshing</i> tabel acara");
		}
	});
}
function showMeThisRegistrasiContent(a,b){
	openLoadingBar("mengambil data ...");
	j("#setAjax").setAjax({
		methode : 'POST',
		bool : true,
		url : "Controlacara/getJsonDataRegistrasi.aspx",
		content : "year="+a+"&semester="+b+"&kode=JASERVCONTROL",
		sucOk : function(a){
			setLoadingBarMessage("pesan server diterima ...");
			var header ="";
			var message = "";
			if(a[0] == "1"){
				setLoadingBarMessage("pesan server di proses ...");
				var tempssss = JSON.parse(a.substr(1,a.length-1));
				header += tempssss.data[4];
				message += "Tahun Ajaran "+tempssss.data[0]+"-"+(parseInt(tempssss.data[0])+1)+"<br>";
				message += "Semester "+tempssss.data[1]+"<br>";
				message += "Mulai tanggal "+tempssss.data[2]+"dan berakhir pada tanggal "+tempssss.data[3]+"<br>";
				message += "konten yaitu : "+tempssss.data[5];
			}else{
				setLoadingBarMessage("pesan server gagal ...");
				header="";
				message += "Tahun Ajaran <br>";
				message += "Semester <br>";
				message += "Mulai tanggal  dan berakhir pada tanggal <br>";
				message += "konten yaitu : ";
			}
			openModalDefault(header,message);
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"<i>Refreshing</i> informasi acara");
		}
	});
}

function showMeThisRegistrasiContentNonDefault(a){
	openLoadingBar("mengambil data ...");
	j("#setAjax").setAjax({
		methode : 'POST',
		bool : true,
		url : "Controlacara/getJsonDataRegistrasiNonDefault.aspx",
		content : "id="+a+"&kode=JASERVCONTROL",
		sucOk : function(a){
			setLoadingBarMessage("pesan server diterima ...");
			var header ="";
			var message = "";
			if(a[0] == "1"){
				setLoadingBarMessage("pesan server di proses ...");
				var tempssss = JSON.parse(a.substr(1,a.length-1));
				header += tempssss.data[4];
				message += "Tahun Ajaran "+tempssss.data[0]+"-"+(parseInt(tempssss.data[0])+1)+"<br>";
				message += "Semester "+tempssss.data[1]+"<br>";
				message += "Mulai tanggal "+tempssss.data[2]+"dan berakhir pada tanggal "+tempssss.data[3]+"<br>";
				message += "konten yaitu : "+tempssss.data[5];
			}else{
				setLoadingBarMessage("pesan server gagal ...");
				header="";
				message += "Tahun Ajaran <br>";
				message += "Semester <br>";
				message += "Mulai tanggal  dan berakhir pada tanggal <br>";
				message += "konten yaitu : ";
			}
			openModalDefault(header,message);
			setTimeout(function(){
				closeLoadingBar();
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"<i>Refreshing</i> informasi acara");
		}
	});
}
var dataNewEvent = {};
function addNewEvent(){
	dataNewEvent['start'] = 1;
	dataNewEvent['end'] = 1;
	dataNewEvent['title'] = 1;
	dataNewEvent['summary'] = 1;
	dataNewEvent['data'] = null;
	var temp = createInputModal("Mulai registrasi","DATE","Kode","masukan tanggal mulai","","start-event-new","start-event-new","");
	temp += createInputModal("Akhir Registrasi","DATE","Kode","masukan tanggal berakhir","","end-event-new","end-event-new","");
	temp += createInputModal("Judul Acara","TEXT","","masukan judul","","title-event-new","title-event-new","");
	temp += createInputModal("Keterangan Acara","textarea","","masukan keterangan","","summary-event-new","summary-event-new","");
	openModalForm(temp,function(a){
		openLoadingBar("Data input proses ...");	
			setTimeout(function(){
				var error = 0;
				if(dataNewEvent['start'] == 1){
					setLoadingBarMessage("input data tanggal mulai salah ...");	
					error +=1;
					showDataErrorInput('start-event-new','Periksalah inputan anda, mungkin terjadi kesalahan');
				}
				if(dataNewEvent['end'] == 1){
					setLoadingBarMessage("input data tanggal akhir salah ...");	
					error+=1;
					showDataErrorInput('end-event-new','Periksalah inputan anda, mungkin terjadi kesalahan');
				}
				if(dataNewEvent['title'] == 1){
					setLoadingBarMessage("input data judul salah ...");	
					error+=1;
					showDataErrorInput('title-event-new','Periksalah inputan anda, tidak boleh kosong');
				}
				if(dataNewEvent['summary'] == 1){
					setLoadingBarMessage("input data keterangan salah ...");	
					error+=1;
					showDataErrorInput('summary-event-new','Periksalah inputan anda, tidak boleh kosong');
				}
				if(error == 0){
					j('#setAjax').setAjax({
						methode : "POST",
						bool : true,
						url : "Controlacara/setNewEvent.aspx",
						content : 
						"start="+$('#start-event-new').val()+
						"&end="+$('#end-event-new').val()+
						"&title="+$('#title-event-new').val()+
						"&summary="+$('#summary-event-new').val()+
						"&kode=JASERVTECH-CODE-CREATE-NEW-EVENT-AKADEMIK",
						sucOk : function(b){
							if(b[0] == '1'){
								setLoadingBarMessage("input data diproses ...");
								refreshAcaraNonDefault();
								a(true);
							}else{
								setLoadingBarMessage("kesalahan "+b.substr(1,b.length-1)+" ...");	
							}
							setTimeout(function(){
								closeLoadingBar();
							},2000);
						},
						sucEr : function(a,b){
							template(a,b,"<i>Submitting </i> Data ke server");
						}
					});
				}else{
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				}
			},400);
		}
	);
	$('#title-event-new').on('change',function(){
		openLoadingBar("check input title ...");
		if($(this).val() == ""){
			showdataErrorInput('start-event-new','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=TITLE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataNewEvent['title'] = 0;
						hideDataErrorInput('title-event-new');
					}else{
						dataNewEvent['title'] = 1;
						showDataErrorInput('title-event-new',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});

	$('#summary-event-new').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-event-new','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=SUMMARY&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataNewEvent['summary'] = 0;
						hideDataErrorInput('summary-event-new');
					}else{
						dataNewEvent['summary'] = 1;
						showDataErrorInput('summary-event-new',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
	$('#start-event-new').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-event-new','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=DATE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						if($("#end-event-new").val() == ""){
							setLoadingBarMessage("Data input valid ...");
							hideDataErrorInput('start-event-new');	
							dataNewEvent['start'] = 0;
						}else{
							if(compareIsLessDate($('#start-event-new').val(),$("#end-event-new").val())){
								setLoadingBarMessage("Data input Valid ...");	
								hideDataErrorInput('end-event-new');
								hideDataErrorInput('start-event-new');
								dataNewEvent['end'] = 0;
								dataNewEvent['start'] = 0;	
							}else{
								setLoadingBarMessage("Data input Tidak Valid ...");	
								dataNewEvent['start'] = 1;
								showDataErrorInput('start-event-new',"tanggal akhir harus sebelum tanggal mulai");
							}
						}
					}else{
						dataNewEvent['start'] = 1;
						showDataErrorInput('start-event-new',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});

	$('#end-event-new').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-event-new','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=DATE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						if($("#start-event-new").val() == ""){
							setLoadingBarMessage("Data input Valid ...");	
							hideDataErrorInput('end-event-new');
							dataNewEvent['end'] = 0;
						}else{
							if(compareIsLessDate($("#start-event-new").val(),$("#end-event-new").val())){
								setLoadingBarMessage("Data input Valid ...");
								hideDataErrorInput('end-event-new');
								hideDataErrorInput('start-event-new');
								dataNewEvent['end'] = 0;
								dataNewEvent['start'] = 0;	
							}else{
								showDataErrorInput('end-event-new',"tanggal akhir harus setelah tanggal mulai");
								setLoadingBarMessage("Data input Tidak Valid ...");	
								dataNewEvent['end'] = 1;
							}
						}
					}else{
						showDataErrorInput('end-event-new',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
						dataNewEvent['end'] = 1;
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
}
var dataEditEvent = {};
function editEventAktif(ccc){
	dataEditEvent['start'] = 1;
	dataEditEvent['end'] = 1;
	dataEditEvent['title'] = 1;
	dataEditEvent['summary'] = 1;
	dataEditEvent['data'] = null;
	var temp = createInputModal("Mulai registrasi","DATE","Kode","masukan tanggal mulai","","start-edit-event","start-edit-event","");
	temp += createInputModal("Akhir Registrasi","DATE","Kode","masukan tanggal berakhir","","end-edit-event","end-edit-event","");
	temp += createInputModal("Judul Acara","TEXT","","masukan judul","","title-edit-event","title-edit-event","");
	temp += createInputModal("Keterangan Acara","textarea","","masukan keterangan","","summary-edit-event","summary-edit-event","");
	openModalForm(temp,function(a){
		openLoadingBar("Data input proses ...");	
			setTimeout(function(){

				var error = 0;
				if(dataEditEvent['start'] == 1){
					setLoadingBarMessage("input data tanggal mulai salah ...");	
					error +=1;
					showDataErrorInput('start-edit-event','Periksalah inputan anda, mungkin terjadi kesalahan');
				}
				if(dataEditEvent['end'] == 1){
					setLoadingBarMessage("input data tanggal akhir salah ...");	
					error+=1;
					showDataErrorInput('end-edit-event','Periksalah inputan anda, mungkin terjadi kesalahan');
				}
				if(dataEditEvent['title'] == 1){
					setLoadingBarMessage("input data judul salah ...");	
					error+=1;
					showDataErrorInput('title-edit-event','Periksalah inputan anda, tidak boleh kosong');
				}
				if(dataEditEvent['summary'] == 1){
					setLoadingBarMessage("input data keterangan salah ...");	
					error+=1;
					showDataErrorInput('summary-edit-event','Periksalah inputan anda, tidak boleh kosong');
				}
				if(error == 0){
					j('#setAjax').setAjax({
						methode : "POST",
						bool : true,
						url : "Controlacara/setDataEditEvent.aspx",
						content : 
						"start="+$('#start-edit-event').val()+
						"&end="+$('#end-edit-event').val()+
						"&title="+$('#title-edit-event').val()+
						"&summary="+$('#summary-edit-event').val()+
						"&kode=JASERVTECH-CODE-CREATE-NEW-EVENT"+
						"&id="+ccc,
						sucOk : function(b){
							if(b[0] == '1'){
								setLoadingBarMessage("input data diproses ...");
								refreshAcaraDefault();
								a(true);
							}else{
								setLoadingBarMessage("kesalahan "+b.substr(1,b.length-1)+" ...");	
							}
							setTimeout(function(){
								closeLoadingBar();
							},2000);
						},
						sucEr : function(a,b){
							template(a,b,"<i>Submitting </i> Data ke server");
						}
					});
				}else{
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				}
			},400);
		}
	);
	j("#setAjax").setAjax({
		methode : "POST",
		bool : true,
		url : "Controlacara/getJsonDataEventActive.aspx",
		content : "kode=JASERVCONTROL&id="+ccc,
		sucOk : function(a){
			//var bb = JSON.parse(a);
			//alert(bb.data[0]);
			if(a[0] == '1'){
				dataEditEvent['data'] = JSON.parse(a.substr(1,a.length-1));
			}

			if(dataEditEvent['data'] != null){
				j('#start-edit-event').setValue(dataEditEvent['data'].data[2]);
				j('#end-edit-event').setValue(dataEditEvent['data'].data[3]);
				j('#title-edit-event').setValue(dataEditEvent['data'].data[4]);
				j('#summary-edit-event').setValue(dataEditEvent['data'].data[5]);
				dataEditEvent['start'] = 0;
				dataEditEvent['end'] = 0;
				if(dataEditEvent['data'].data[4] != "")
					dataEditEvent['title'] = 0;
				if(dataEditEvent['data'].data[5] != "")
					dataEditEvent['summary'] = 0;
				$('#start-edit-event').trigger('change');
				$('#end-edit-event').trigger('change');
			}
		},
		sucEr : function(a,b){
			template(a,b,"<i>Contact </i> get date input");
		}
	});
	$('#title-edit-event').on('change',function(){
		openLoadingBar("check input title ...");
		if($(this).val() == ""){
			showdataErrorInput('start-edit-event','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=TITLE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataEditEvent['title'] = 0;
						hideDataErrorInput('title-edit-event');
					}else{
						dataEditEvent['title'] = 1;
						showDataErrorInput('title-edit-event',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});

	$('#summary-edit-event').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-edit-event','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=SUMMARY&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataEditEvent['summary'] = 0;
						hideDataErrorInput('summary-edit-event');
					}else{
						dataEditEvent['summary'] = 1;
						showDataErrorInput('summary-edit-event',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
	$('#start-edit-event').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-edit-event','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=DATE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						if($("#end-edit-event").val() == ""){
							setLoadingBarMessage("Data input valid ...");
							hideDataErrorInput('start-edit-event');	
							dataEditEvent['start'] = 0;
						}else{
							if(compareIsLessDate($('#start-edit-event').val(),$("#end-edit-event").val())){
								setLoadingBarMessage("Data input Valid ...");	
								hideDataErrorInput('end-edit-event');
								hideDataErrorInput('start-edit-event');
								dataEditEvent['end'] = 0;
								dataEditEvent['start'] = 0;	
							}else{
								setLoadingBarMessage("Data input Tidak Valid ...");	
								dataEditEvent['start'] = 1;
								showDataErrorInput('start-edit-event',"tanggal akhir harus sebelum tanggal mulai");
							}
						}
					}else{
						dataEditEvent['start'] = 1;
						showDataErrorInput('start-edit-event',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});

	$('#end-edit-event').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-edit-event','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=DATE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						if($("#start-edit-event").val() == ""){
							setLoadingBarMessage("Data input Valid ...");	
							hideDataErrorInput('end-edit-event');
							dataEditEvent['end'] = 0;
						}else{
							if(compareIsLessDate($("#start-edit-event").val(),$("#end-edit-event").val())){
								setLoadingBarMessage("Data input Valid ...");
								hideDataErrorInput('end-edit-event');
								hideDataErrorInput('start-edit-event');
								dataEditEvent['end'] = 0;
								dataEditEvent['start'] = 0;	
							}else{
								showDataErrorInput('end-edit-event',"tanggal akhir harus setelah tanggal mulai");
								setLoadingBarMessage("Data input Tidak Valid ...");	
								dataEditEvent['end'] = 1;
							}
						}
					}else{
						showDataErrorInput('end-edit-event',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
						dataEditEvent['end'] = 1;
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
	//alert();(new Date()).getYear()
}

var dataRegistrasiForm = {};
function editAkademikAktif(){
	dataRegistrasiForm['start'] = 1;
	dataRegistrasiForm['end'] = 1;
	dataRegistrasiForm['title'] = 1;
	dataRegistrasiForm['summary'] = 1;
	dataRegistrasiForm['data'] = null;
	var temp = createInputModal("Mulai registrasi","DATE","Kode","masukan tanggal mulai","","start-acara","start-acara","");
	temp += createInputModal("Akhir Registrasi","DATE","Kode","masukan tanggal berakhir","","end-acara","end-acara","");
	temp += createInputModal("Judul Acara","TEXT","","masukan judul","","title-acara","title-acara","");
	temp += createInputModal("Keterangan Acara","textarea","","masukan keterangan","","summary-acara","summary-acara","");
	openModalForm(temp,function(a){
		openLoadingBar("Data input proses ...");	
			setTimeout(function(){

				var error = 0;
				if(dataRegistrasiForm['start'] == 1){
					setLoadingBarMessage("input data tanggal mulai salah ...");	
					error +=1;
					showDataErrorInput('start-acara','Periksalah inputan anda, mungkin terjadi kesalahan');
				}
				if(dataRegistrasiForm['end'] == 1){
					setLoadingBarMessage("input data tanggal akhir salah ...");	
					error+=1;
					showDataErrorInput('end-acara','Periksalah inputan anda, mungkin terjadi kesalahan');
				}
				if(dataRegistrasiForm['title'] == 1){
					setLoadingBarMessage("input data judul salah ...");	
					error+=1;
					showDataErrorInput('title-acara','Periksalah inputan anda, tidak boleh kosong');
				}
				if(dataRegistrasiForm['summary'] == 1){
					setLoadingBarMessage("input data keterangan salah ...");	
					error+=1;
					showDataErrorInput('summary-acara','Periksalah inputan anda, tidak boleh kosong');
				}
				if(error == 0){
					j('#setAjax').setAjax({
						methode : "POST",
						bool : true,
						url : "Controlacara/setNewAkademik.aspx",
						content : 
						"start="+$('#start-acara').val()+
						"&end="+$('#end-acara').val()+
						"&title="+$('#title-acara').val()+
						"&summary="+$('#summary-acara').val()+
						"&kode=JASERVTECH-CODE-CREATE-NEW-AKADEMIK",
						sucOk : function(b){
							if(b[0] == '1'){
								setLoadingBarMessage("input data diproses ...");
								refreshAcaraDefault();
								a(true);
							}else{
								setLoadingBarMessage("kesalahan "+b.substr(1,b.length-1)+" ...");	
							}
							setTimeout(function(){
								closeLoadingBar();
							},2000);
						},
						sucEr : function(a,b){
							template(a,b,"<i>Submitting </i> Data ke server");
						}
					});
				}else{
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				}
			},400);
		}
	);
	j("#setAjax").setAjax({
		methode : "POST",
		bool : true,
		url : "Controlacara/getJsonDataRegistrasiActive.aspx",
		content : "kode=JASERVCONTROL",
		sucOk : function(a){
			//var bb = JSON.parse(a);
			//alert(bb.data[0]);
			if(a[0] == '1'){
				dataRegistrasiForm['data'] = JSON.parse(a.substr(1,a.length-1));
			}

			if(dataRegistrasiForm['data'] != null){
				j('#start-acara').setValue(dataRegistrasiForm['data'].data[2]);
				j('#end-acara').setValue(dataRegistrasiForm['data'].data[3]);
				j('#title-acara').setValue(dataRegistrasiForm['data'].data[4]);
				j('#summary-acara').setValue(dataRegistrasiForm['data'].data[5]);
				dataRegistrasiForm['start'] = 0;
				dataRegistrasiForm['end'] = 0;
				if(dataRegistrasiForm['data'].data[4] != "")
					dataRegistrasiForm['title'] = 0;
				if(dataRegistrasiForm['data'].data[5] != "")
					dataRegistrasiForm['summary'] = 0;
				$('#start-acara').trigger('change');
				$('#end-acara').trigger('change');
			}
		},
		sucEr : function(a,b){
			template(a,b,"<i>Contact </i> get date input");
		}
	});
	$('#title-acara').on('change',function(){
		openLoadingBar("check input title ...");
		if($(this).val() == ""){
			showdataErrorInput('start-acara','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=TITLE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataRegistrasiForm['title'] = 0;
						hideDataErrorInput('title-acara');
					}else{
						dataRegistrasiForm['title'] = 1;
						showDataErrorInput('title-acara',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});

	$('#summary-acara').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-acara','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=SUMMARY&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						dataRegistrasiForm['summary'] = 0;
						hideDataErrorInput('summary-acara');
					}else{
						dataRegistrasiForm['summary'] = 1;
						showDataErrorInput('summary-acara',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
	$('#start-acara').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-acara','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=DATE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						if($("#end-acara").val() == ""){
							setLoadingBarMessage("Data input valid ...");
							hideDataErrorInput('start-acara');	
							dataRegistrasiForm['start'] = 0;
						}else{
							if(compareIsLessDate($('#start-acara').val(),$("#end-acara").val())){
								setLoadingBarMessage("Data input Valid ...");	
								hideDataErrorInput('end-acara');
								hideDataErrorInput('start-acara');
								dataRegistrasiForm['end'] = 0;
								dataRegistrasiForm['start'] = 0;	
							}else{
								setLoadingBarMessage("Data input Tidak Valid ...");	
								dataRegistrasiForm['start'] = 1;
								showDataErrorInput('start-acara',"tanggal akhir harus sebelum tanggal mulai");
							}
						}
					}else{
						dataRegistrasiForm['start'] = 1;
						showDataErrorInput('start-acara',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});

	$('#end-acara').on('change',function(){
		openLoadingBar("check input start date ...");
		if($(this).val() == ""){
			showdataErrorInput('start-acara','Data tidak boleh kosong');
		}else{
			j("#setAjax").setAjax({
				methode : "POST",
				url : "Controlacara/getCheck.aspx",
				bool : true,
				content : "value="+$(this).val()+"&kode=DATE&cat=0",
				sucOk : function(a){
					if(a[0] == '1'){
						setLoadingBarMessage("Data input proses ...");	
						if($("#start-acara").val() == ""){
							setLoadingBarMessage("Data input Valid ...");	
							hideDataErrorInput('end-acara');
							dataRegistrasiForm['end'] = 0;
						}else{
							if(compareIsLessDate($("#start-acara").val(),$("#end-acara").val())){
								setLoadingBarMessage("Data input Valid ...");
								hideDataErrorInput('end-acara');
								hideDataErrorInput('start-acara');
								dataRegistrasiForm['end'] = 0;
								dataRegistrasiForm['start'] = 0;	
							}else{
								showDataErrorInput('end-acara',"tanggal akhir harus setelah tanggal mulai");
								setLoadingBarMessage("Data input Tidak Valid ...");	
								dataRegistrasiForm['end'] = 1;
							}
						}
					}else{
						showDataErrorInput('end-acara',a.substr(1,a.length-1));
						setLoadingBarMessage("Data Input Tidak Valid ...");
						dataRegistrasiForm['end'] = 1;
					}
					setTimeout(function(){
						closeLoadingBar();
					},2000);
				},
				sucEr : function(a,b){
					template(a,b,"<i>Checking</i> date input");
				}
			});
		}
	});
	//alert();(new Date()).getYear()
}
function compareIsLessDate(date1,date2){ //date1 lebih dahulu dibading date2
	date1 = new Date(date1);
	date2 = new Date(date2);
	if(parseInt(date1.getFullYear()) > parseInt(date2.getFullYear()))
		return false;
	if(parseInt(date1.getFullYear()) < parseInt(date2.getFullYear()))
		return true;
	if(parseInt(date1.getMonth()) > parseInt(date2.getMonth()))
		return false;
	if(parseInt(date1.getMonth()) < parseInt(date2.getMonth()))
		return true;
	if(parseInt(date1.getDate()) > parseInt(date2.getDate()))
		return false;
	return true;
	
	//if($('start-acara').val() == "")
		
}