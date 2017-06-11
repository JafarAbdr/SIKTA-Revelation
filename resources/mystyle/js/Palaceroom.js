var navbarNavigation = {};
var processSomething = true;
var barSettingProfile = false;

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
$(document).ready(function(){
	if($(".datepickers").length>0)$(".datepickers").datepicker({nextText:"",prevText:""});
	resetControlNavigasi();
	setBreadCrumb({0:'Registrasi'});
	navbarNavigation['form-control']=0;
	navbarNavigation['registrasi'] = 1;
	setNewContentIntern("Palaceareaacara/getLayoutAreaAcara",function(){
		acaraAkademikFullArea();
	},function(){},function(){});	
	$('#keluar-confirm-exe').on('click',function(){
		modalStaticMultipleButton('Apakah anda yakin ingin keluar',function(){
			$(location).attr('href', "Palaceroom/signOut.jsp");
		});
	});
	setTimeout(function(){
		if(nama_user.length > 5){
			noty({text:'Hai '+nama_user+', selamat datang di Sistem Informasi Akademik Tugas Akhir ^_^'});
			setTimeout(function(){
				$.noty.closeAll();
			},5000);
		}
	},3000);
	$('#go-to-pengaturan').on('click',function(){
		openPengaturans();
	});
	/*
	$('#registrasi-layout').on('click',function(){
		closePengaturans();
		setBreadCrumb({0:'Registrasi'});
		if(navbarNavigation['registrasi'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['registrasi']=1;
				setBreadCrumb({0:'Registrasi'});
				setNewContentIntern("Palaceregistrasi/getLayoutRegistrasi",function(){
					registrasiAkademikMahasiswa();
				},function(){},function(){});	
			}
		}
	});
	*/
	$('#seminar-layout').on('click',function(){
		closePengaturans();
		setBreadCrumb({0:'Tabel Acara'});
		if(navbarNavigation['TabelAcara'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['TabelAcara']=1;
				setBreadCrumb({0:'Tabel Acara'});
				setNewContentIntern("Palaceareaacara/getLayoutAreaAcara",function(){
					acaraAkademikFullArea();
				},function(){},function(){});	
			}
		}
	});
});

function resetControlNavigasi(){
	navbarNavigation['TabelAcara'] = 0;
	navbarNavigation['registrasi'] = 0;
}

var openPenaturanStatus=false;
function closePengaturans(){
	if(openPenaturanStatus){
		openPenaturanStatus=false;
		$('#setting-left-1').slideUp('slow',function(){			
			$('#default-page-content-1').slideDown('slow',function(){
				
			});
		});
		$('#setting-left-2').slideUp('slow',function(){			
			$('#content-intern').slideDown('slow',function(){
				
			});
		});
		$('#setting-left-3').slideUp('slow');
	}
}
function openPengaturans(){
	if(!openPenaturanStatus){
		openPenaturanStatus=true;
		$('#default-page-content-1').slideUp('slow',function(){			
			$('#setting-left-1').slideDown('slow',function(){
				
			});
		});
		$('#content-intern').slideUp('slow',function(){			
			$('#setting-left-2').slideDown('slow',function(){
				getDataDiriJson();
			});
			$('#setting-left-3').slideDown('slow');
		});
		
	}
}
function setNewContentIntern(data,aa,yes,not){
	openLoadingBar("mengganti layout ...");
	$("#content-intern").slideUp('slow',function(){
		j("#content-intern").setInHtml();
		j("#setAjax").setAjax({
			methode : 'POST',
			url : base_url+data+".jsp",
			bool : true,
			content : "",
			sucOk : function(a){
				j("#content-intern").setInHtml(a.substr(1,a.length-1));
				if(a[0] == '1'){
					$('#content-intern').slideDown('slow',function(){
						aa();
					});
				}else if(a[0] == '3'){
					$('#force').on('click',function(){
						yes();
					});
					$('#next').on('click',function(){
						not();
					});
					$('#content-intern').slideDown('slow');
				}else if(a[0] == '4'){
					$('#next').on('click',function(){
						not();
					});
					$('#content-intern').slideDown('slow');
				}else{
					$('#content-intern').slideDown('slow');
				}
				closeLoadingBar()
			}
		});
	});
}