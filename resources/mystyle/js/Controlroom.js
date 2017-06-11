var navbarNavigation = {};
$(document).ready(function(){
	if($(".datepicker").length>0)$(".datepicker").datepicker({nextText:"",prevText:""});
	navbarNavigation['form-control']=0;
	navbarNavigation['acara']=1;
	resetControlNavigasi();
	setTimeout(function(){
		noty({text:'Hai '+nama_user+', selamat datang di Sistem Informasi Akademik Tugas Akhir ^_^'});
		setTimeout(function(){
			$.noty.closeAll();
		},5000);
	},3000);
	//default page load
	resetControlNavigasi();
	navbarNavigation['acara']=1;
	setBreadCrumb({0:'Acara'});
	setNewIntern("Controlacarakoor/getLayoutAcara",function(){
		mainAcara();
	},function(){

		showPlugin();
	});
	//default load end
	$('#keluar-confirm-exe').on('click',function(){
		modalStaticMultipleButton('Apakah anda yakin ingin keluar',function(){
			$(location).attr('href', "Controlroom/signOut.jsp");
		});
	});
	$('#acara-layout').on('click',function(){
		if(pengaturanPageNow){
			hidePengaturanKoor(function(){
				if(navbarNavigation['acara'] == 0){
					if(navbarNavigation['form-control'] == 1){
						modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
					}else{
						resetControlNavigasi();
						navbarNavigation['acara']=1;
						setBreadCrumb({0:'Acara'});
						setNewIntern("Controlacarakoor/getLayoutAcara",function(){
							mainAcara();
						},function(){

							showPlugin();
						});
						//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
					}
				}				
			});
		}else{
			if(navbarNavigation['acara'] == 0){
				if(navbarNavigation['form-control'] == 1){
					modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
				}else{
					resetControlNavigasi();
					navbarNavigation['acara']=1;
					setBreadCrumb({0:'Acara'});
					setNewIntern("Controlacarakoor/getLayoutAcara",function(){
						mainAcara();
					},function(){

						showPlugin();
					});
					//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
				}
			}	
		}
	});
	$('#rekap-layout').on('click',function(){
		if(pengaturanPageNow){
			hidePengaturanKoor(function(){
				if(navbarNavigation['rekap'] == 0){
					if(navbarNavigation['form-control'] == 1){
						modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
					}else{
						resetControlNavigasi();
						navbarNavigation['rekap']=1;
						setBreadCrumb({0:'Dosen',1:'Rekapitulasi'});
						hidePlugin();
						setNewIntern("Controlrekap/getLayoutRekap",function(){
							reloadLayoutRekap();
						},
						function(){
							
						});
						//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
					}
				}				
			});
		}else{
			if(navbarNavigation['rekap'] == 0){
				if(navbarNavigation['form-control'] == 1){
					modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
				}else{
					resetControlNavigasi();
					navbarNavigation['rekap']=1;
					setBreadCrumb({0:'Dosen',1:'Rekapitulasi'});
					hidePlugin();
					setNewIntern("Controlrekap/getLayoutRekap",function(){
						reloadLayoutRekap();
					},
					function(){
						
					});
					//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
				}
			}	
		}
	});
	$('#dosen-layout').on('click',function(){
		if(pengaturanPageNow){
			hidePengaturanKoor(function(){
				if(navbarNavigation['dosen'] == 0){
					if(navbarNavigation['form-control'] == 1){
						modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
					}else{
						resetControlNavigasi();
						navbarNavigation['dosen']=1;
						setBreadCrumb({0:'Dosen',1:'List Terdaftar'});
						hidePlugin();
						setNewIntern("Controldosens/getLayoutDosen",function(){
							reloadLayoutDosen();
						},
						function(){
							
						});
						//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
					}
				}				
			});
		}else{
			if(navbarNavigation['dosen'] == 0){
				if(navbarNavigation['form-control'] == 1){
					modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
				}else{
					resetControlNavigasi();
					navbarNavigation['dosen']=1;
					setBreadCrumb({0:'Dosen',1:'List Terdaftar'});
					hidePlugin();
					setNewIntern("Controldosens/getLayoutDosen",function(){
						reloadLayoutDosen();
					},
					function(){
						
					});
					//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
				}
			}	
		}
	});
	
	$('#mahasiswa-layout').on('click',function(){
		if(pengaturanPageNow){
			hidePengaturanKoor(function(){
				if(navbarNavigation['mahasiswa'] == 0){
					if(navbarNavigation['form-control'] == 1){
						modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
					}else{
						resetControlNavigasi();
						navbarNavigation['mahasiswa']=1;
						setBreadCrumb({0:'Mahasiswa'});
						hidePlugin();
						setNewIntern("Controlakunmahasiswa/getLayoutRegistrasi",function(){
							registrasiAkademikMahasiswa();
						},
						function(){
							
						});
						//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
					}
				}				
			});
		}else{
			if(navbarNavigation['mahasiswa'] == 0){
				if(navbarNavigation['form-control'] == 1){
					modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
				}else{
					resetControlNavigasi();
					navbarNavigation['mahasiswa']=1;
					setBreadCrumb({0:'Mahasiswa'});
					hidePlugin();
					setNewIntern("Controlakunmahasiswa/getLayoutRegistrasi",function(){
						registrasiAkademikMahasiswa();
					},
					function(){
						
					});
					//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
				}
			}	
		}
	});
	$('#bantuan-layout').on('click',function(){
		/*
		if(navbarNavigation['bantuan'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['bantuan']=1;
				setBreadCrumb({0:'Bantuan'});
				showPlugin();
				//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
			}
		}*/
	});
	$('#seminar-layout').on('click',function(){
		if(pengaturanPageNow){
			hidePengaturanKoor(function(){
				if(navbarNavigation['seminar'] == 0){
					if(navbarNavigation['form-control'] == 1){
						modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
					}else{
						
						resetControlNavigasi();
						navbarNavigation['seminar']=1;
						setBreadCrumb({0:'Seminar'});
						hidePlugin();
						setNewIntern("Controlresultseminar/getLayoutSeminar",function(){
							tableTA1TA2Seminar();
							//reloadRegistrasiPemerataan();
						},function(){
							
						});
						//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
					}
				}				
			});
		}else{
			if(navbarNavigation['seminar'] == 0){
				if(navbarNavigation['form-control'] == 1){
					modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
				}else{
					
					resetControlNavigasi();
					navbarNavigation['seminar']=1;
					setBreadCrumb({0:'Seminar'});
					hidePlugin();
					setNewIntern("Controlresultseminar/getLayoutSeminar",function(){
						tableTA1TA2Seminar();
						//reloadRegistrasiPemerataan();
					},function(){
						
					});
					//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
				}
			}	
		}
	});
	$('#registrasi-layout').on('click',function(){
		if(pengaturanPageNow){
			hidePengaturanKoor(function(){				
				if(navbarNavigation['registrasi'] == 0){
					if(navbarNavigation['form-control'] == 1){
						modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
					}else{
						resetControlNavigasi();
						navbarNavigation['registrasi']=1;
						setBreadCrumb({0:'Registrasi'});
						hidePlugin();
						setNewIntern("Controlresultregistrasi/getLayoutRegistrasi",function(){
							reloadRegistrasiPemerataan();
						},function(){
							
						});
						//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
					}
				}
			});
		}else{		
			if(navbarNavigation['registrasi'] == 0){
				if(navbarNavigation['form-control'] == 1){
					modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
				}else{
					resetControlNavigasi();
					navbarNavigation['registrasi']=1;
					setBreadCrumb({0:'Registrasi'});
					hidePlugin();
					setNewIntern("Controlresultregistrasi/getLayoutRegistrasi",function(){
						reloadRegistrasiPemerataan();
					},function(){
						
					});
					//setNewContentIntern("getLayoutHome",function(){},function(){},function(){});	
				}
			}	
		}
	});
	$("#go-to-pengaturan").on("click",function(){
		showPengaturanKoor();
	});
});
var pengaturanPageNow = false;
function hidePengaturanKoor(a){
	$("#setting-left-1").slideUp("slow",function(){
		/* $().slideDown("slow",function(){
			
		});
		$().slideDown("slow",function(){
			
		}); */
		pengaturanPageNow = false;
		a();
		$("#default-page-content-1").slideDown("slow");		
		$("#content-intern").slideDown("slow");
	});
	$("#content-setting").slideUp("slow");
	$("#content-setting-2").slideUp("slow");
}
function showPengaturanKoor(){
	$("#default-page-content-1").slideUp("slow",function(){
		$("#setting-left-1").slideDown("slow",function(){
			
		});
		$("#content-setting").slideDown("slow",function(){
			
		});
		$("#content-setting-2").slideDown("slow",function(){
			pengaturanPageNow = true;
			pengaturanKoordinator();
		});
		showPlugin();
	});
	$("#content-intern").slideUp("slow");
}
function hidePlugin(){
	$("#plugin-layout").slideUp('slow',function(){
		$('#right-layout').removeClass('col-md-7');
		$('#right-layout').addClass('col-md-10');
	});
}
function showPlugin(){
	$('#right-layout').removeClass('col-md-10');
	$('#right-layout').addClass('col-md-7');
	$("#plugin-layout").slideDown('slow');
}
function setNewIntern(data,f,g){
	openLoadingBar("mengganti layout ...");
	$("#content-intern").slideUp('slow',function(){
		j("#content-intern").setInHtml();
		j("#setAjax").setAjax({
			methode : "POST",
			url : data+".jsp",
			bool : true,
			content : "kode=JASERV-KOOR",
			sucOk : function(a){
				if(a[0] == 0){
					setLoadingBarMessage("gagal melakukan perubahan ...");
					setTimeout(function(){},200);
				}else if(parseInt(a[0]) == 1){
					j("#content-intern").setInHtml(a.substr(1,a.length-1));
					g();
					$('#content-intern').slideDown('slow',function(){
						f();
					});
					setLoadingBarMessage("berhasil melakukan perubahan ...");
					setTimeout(function(){},200);
				}
				closeLoadingBar();
			},
		sucEr : function(a,b){
			if(parseInt(b) == 200){
				console.log("server response "+data);
				if(parseInt(a) == 1){
					console.log("loading "+data);
					setLoadingBarMessage("mengambil response data ...");
				}
				if(parseInt(a) == 2){
					console.log("loaded "+data);
					setLoadingBarMessage("memperoleh response data ...");
				}
				if(parseInt(a) == 3){
					console.log("interactive "+data);
					setLoadingBarMessage("menjawab response data ...");
				}
			}
			if(parseInt(b) == 500){
				console.log("error internal server "+data);
				setLoadingBarMessage("mengambil response data ...");
			}
			if(parseInt(b) == 404){
				console.log("server not found "+data);
				setLoadingBarMessage("response tidak ditemukan ...");
			}
			if(parseInt(b) >= 301 && parseInt(b) <= 303){
				console.log("page has been removed "+data);
				setLoadingBarMessage("response di tolak ...");
			}
		}
		});
	});
}
function openLoadingBar(a){
	setLoadingBarMessage(a);
	$('#statusbar-loading').fadeIn('slow');
}
function setLoadingBarMessage(a){
	j('#loading-pesan').setInHtml(a);
}
function closeLoadingBar(){
	$('#statusbar-loading').fadeOut('slow');
}
function resetControlNavigasi(){
	navbarNavigation['acara'] = 0;
	navbarNavigation['registrasi'] = 0;
	navbarNavigation['seminar'] = 0;
	navbarNavigation['dosen'] = 0;
	navbarNavigation['bantuan'] = 0;
	navbarNavigation['mahasiswa'] = 0;
	navbarNavigation['rekap'] = 0;
}
var dataDayPengaturanGanjilGenap = [];
dataDayPengaturanGanjilGenap[1] = 31;
dataDayPengaturanGanjilGenap[2] = 29;
dataDayPengaturanGanjilGenap[3] = 31;
dataDayPengaturanGanjilGenap[4] = 30;
dataDayPengaturanGanjilGenap[5] = 31;
dataDayPengaturanGanjilGenap[6] = 30;
dataDayPengaturanGanjilGenap[7] = 31;
dataDayPengaturanGanjilGenap[8] = 31;
dataDayPengaturanGanjilGenap[9] = 30;
dataDayPengaturanGanjilGenap[10] = 31;
dataDayPengaturanGanjilGenap[11] = 30;
dataDayPengaturanGanjilGenap[12] = 31;
function isInDayOnMonth(month,day,febUpToDate){
	month = parseInt(month);
	day = parseInt(day);
	if(month > 12 || month < 1)
		return false;
	if(month == 2){
		year = new Date();
		year = parseInt(year.getFullYear());
		febtrue = false;
		if(year%4 == 0)
			febtrue = true;
		if(febtrue)
			if(febUpToDate){				
				if(day > 29 || day < 1)
					return false;
			}
			else{
				if(day > 28 || day < 1)
					return false;
			}
		else{
			if(day > 28 || day < 1)
				return false;
		}
	}else{
		if(day > dataDayPengaturanGanjilGenap[month] || day < 1)
			return false;
	}
	return true;
}
function generateSelectOption(id,month,daySelected,comment,febUpToDate){
	daySelected = parseInt(daySelected);
	month = parseInt(month);
	dataResult=[];
	dataResult[0]=false;
	dataResult[1]=null;
	if(month > 12 || month < 1)
		return dataResult;
	year = new Date();
	year = parseInt(year.getFullYear());
	febtrue = false;
	if(year%4 == 0)
		febtrue = true;
	if(febtrue)
		if(febUpToDate)
			dataDayPengaturanGanjilGenap[2] = 29;
		else
			dataDayPengaturanGanjilGenap[2] = 28;
	else
		dataDayPengaturanGanjilGenap[2] = 28;
	dataOption="";
	for(iii = 1; iii<= dataDayPengaturanGanjilGenap[month];iii++){
		if(daySelected === iii)
			dataOption+="<option selected value='"+iii+"'>tanggal "+iii+"</option>";
		else
			dataOption+="<option value='"+iii+"'>tanggal "+iii+"</option>";
	}
	dataResult[1] = "<select id='"+id+"'>"+dataOption+"</select><span class='help-block'>"+comment+"</span> ";
	dataResult[0] = true;
	return dataResult;
}