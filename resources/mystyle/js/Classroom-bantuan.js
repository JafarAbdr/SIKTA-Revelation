function bantuanLayout(){
	baseBantuanLayout();
}
function baseBantuanLayout(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutIntro();"> <b>Intro</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;"> <b>Beranda</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasi();"> <b>Registrasi</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;"> <b>Seminar TA</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;"> <b>Lihat</b></div>'+
	"</div>"
	);
}
function baseBantuanLayoutIntro(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<iframe style="width : 100%; height : 345px;" src="https://www.youtube.com/embed/QzlJFIZn0ik" frameborder="0" allowfullscreen></iframe>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayout();"> <b>Kembali</b></div>'+
	"</div>"
	);
}
function baseBantuanLayoutRegistrasi(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasiBaru();"> <b>Registrasi Baru</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasiLama();"> <b>Registrasi Lama</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayout();"> <b>Kembali</b></div>'+
	"</div>"
	);
}
function baseBantuanLayoutRegistrasiBaru(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasiBaru1();"> <b>Registrasi Baru Tutorial 1</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasi();"> <b>Kembali</b></div>'+
	"</div>"
	);
}
function baseBantuanLayoutRegistrasiLama(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasiLama1();"> <b>Registrasi Baru Tutorial 1</b></div>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasi();"> <b>Kembali</b></div>'+
	"</div>"
	);
}
function baseBantuanLayoutRegistrasiBaru1(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<iframe style="width : 100%; height : 345px;" src="https://www.youtube.com/embed/doiVFPFLU5s" frameborder="0" allowfullscreen></iframe>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasiBaru();"> <b>Kembali</b></div>'+
	"</div>"
	);
}
function baseBantuanLayoutRegistrasiLama1(){
	modalStaticSingleInformation("Bantuan",
	"<div style='width : 100%;'>"+
		'<iframe style="width : 100%; height : 345px;" src="https://www.youtube.com/embed/EvoYAbtIdGE" frameborder="0" allowfullscreen></iframe>'+
		'<div class="alert alert-success" style="margin-bottom : 1px; margin-top : 1px; cursor : pointer;" onclick="baseBantuanLayoutRegistrasiLama();"> <b>Kembali</b></div>'+
	"</div>"
	);
}