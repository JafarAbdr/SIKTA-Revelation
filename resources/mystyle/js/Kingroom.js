var navbarNavigation = {};
var processSomething = true;
var barSettingProfile = false;
$(document).ready(function(){
	if($(".datepickers").length>0)$(".datepickers").datepicker({nextText:"",prevText:""});
	resetControlNavigasi();
	navbarNavigation['form-control']=0;
	navbarNavigation['bimbingan'] = 1;
	setBreadCrumb({0:'Bimbingan'});
	setNewContentIntern("Kingbimbingan/getLayoutBimbingan",function(){
		dosenBimbinganView();
	},function(){},function(){});	
	$('#keluar-confirm-exe').on('click',function(){
		modalStaticMultipleButton('Apakah anda yakin ingin keluar',function(){
			$(location).attr('href', base_url+"Kingroom/signOut.jsp");
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
	$('#bimbingan-layout').on('click',function(){
		closePengaturan();
		setBreadCrumb({0:'Bimbingan'});
		if(navbarNavigation['bimbingan'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['bimbingan']=1;
				setBreadCrumb({0:'Bimbingan'});
				setNewContentIntern("Kingbimbingan/getLayoutBimbingan",function(){
					dosenBimbinganView();
				},function(){},function(){});	
			}
		}
	});
	$('#penguji-layout').on('click',function(){
		closePengaturan();
		setBreadCrumb({0:'Penguji'});
		if(navbarNavigation['penguji'] == 0){
			if(navbarNavigation['form-control'] == 1){
				modalStaticSingleWarning('Terdapat form yang aktif, tolong legkapi terlebih dahulu sebelum melanjutkan pindah form yang lain.');
			}else{
				resetControlNavigasi();
				navbarNavigation['penguji']=1;
				setBreadCrumb({0:'Penguji'});
				setNewContentIntern("Kingpenguji/getLayoutPenguji",function(){
					dosenPengujiView();
				},function(){},function(){});	
			}
		}
	});
});
function resetControlNavigasi(){
	navbarNavigation['bimbingan'] = 0;
	navbarNavigation['penguji'] = 0;
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
var pengaturanDosen=false;
function openPengaturan(){
	if(!pengaturanDosen){
		resetControlNavigasi();
		setBreadCrumb({0:'Pengaturan'});
		pengaturanDosen=true;
		$("#default-page-content-1").slideUp('slow',function(){
			$("#setting-left-1").slideDown('slow',function(){
				defaultPengaturan();
			});
		});
		$("#content-intern").slideUp('slow',function(){
			$('#content-setting').slideDown('slow',function(){
				
			});
			$('#setting-left-2').slideDown('slow',function(){
				
			});
		});
	}
}
function closePengaturan(){
	if(pengaturanDosen){
		pengaturanDosen=false;
		$("#setting-left-1").slideUp('slow',function(){
			$("#default-page-content-1").slideDown('slow',function(){
				
			});
		});
		$("#setting-left-2").slideUp('slow',function(){
			
		});
		$("#content-setting").slideUp('slow',function(){
			
		});
		$("#content-intern").slideUp('slow',function(){
			
		});
	}
}