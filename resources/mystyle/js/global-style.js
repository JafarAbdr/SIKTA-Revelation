//
//modal name id=mod-sta-mul-but
//require jquery anda jaserv
//
//control system base
var jaservtechCortana = true;
var pageActive = "";
function setBreadCrumb(a){
	var temp="";
	for(var i=0;a[i] != undefined;i++){
		temp=temp+"<li>"+a[i]+"</li>";
	}
	document.getElementById('content-breadcrumb').innerHTML = temp;
}
function modalStaticBodyMultipleButtonFullControl(message,message2,a,b,bool,c,d){
	j('#msmb-message-mod-sta-tit-mes-butodec').setInHtml(message);
	$("#msmb-body-mod-sta-tit-mes-butodec").html(message2);
	
	$('#msmb-yes-mod-sta-tit-mes-butodec').html(c);	
	$('#msmb-no-mod-sta-tit-mes-butodec').html(d);
	if(!bool){
		$('#msmb-yes-mod-sta-tit-mes-butodec').attr("disabled","true");	
	}else{
		$('#msmb-yes-mod-sta-tit-mes-butodec').removeAttr("disabled");	
	}
	var yes = function(){
		a(function(a){
			if(a){
				$('#msmb-yes-mod-sta-tit-mes-butodec').unbind('click',yes);	
				$('#msmb-no-mod-sta-tit-mes-butodec').unbind('click',no);
				$('#mod-sta-mul-but').modal('hide');
			}
		});
	};
	var no = function(){
		$('#msmb-yes-mod-sta-tit-mes-butodec').unbind('click',yes);
		$('#msmb-no-mod-sta-tit-mes-butodec').unbind('click',no);
		$('#mod-sta-mul-but').modal('hide');
	}
	$('#msmb-yes-mod-sta-tit-mes-butodec').bind('click',yes).focus();
	$('#msmb-no-mod-sta-tit-mes-butodec').bind('click',no);
	$('#mod-sta-tit-mes-butodec').modal({backdrop : 'static'});
	b();
}
function modalStaticBodyMultipleButton(message,message2,a,b){
	j('#msmb-message').setInHtml(message);
	$("#msmb-body").html(message2);
	var yes = function(){
		a(function(a){
			if(a){
				$('#msmb-yes').unbind('click',yes);	
				$('#msmb-no').unbind('click',no);
				$('#mod-sta-mul-but').modal('hide');
			}
		});
	};
	var no = function(){
		$('#msmb-yes').unbind('click',yes);
		$('#msmb-no').unbind('click',no);
		$('#mod-sta-mul-but').modal('hide');
	}
	$('#msmb-yes').bind('click',yes).focus();
	$('#msmb-no').bind('click',no);
	$('#mod-sta-mul-but').modal({backdrop : 'static'});
	b();
}
function modalStaticMultipleButton(message,a){
	j('#msmb-message').setInHtml(message);
	$("#msmb-body").css({
		"display" : "none"
	});
	var yes = function(){
		$('#msmb-yes').unbind('click',yes);
		$('#msmb-no').unbind('click',no);
		$('#mod-sta-mul-but').modal('hide');
		$("#msmb-body").css({
			"display" : "block"
		});
		a();
	};
	var no = function(){
		$("#msmb-body").css({
			"display" : "block"
		});
		$('#msmb-yes').unbind('click',yes);
		$('#msmb-no').unbind('click',no);
		$('#mod-sta-mul-but').modal('hide');
	}
	$('#msmb-yes').bind('click',yes).focus();
	$('#msmb-no').bind('click',no);
	$('#mod-sta-mul-but').modal({backdrop : 'static'});
}
function modalStaticSingleInformation(title,message){
	$('#mssw-body').css({
		'display' : 'block'
	});
	j('#mssw-message').setInHtml(title);
	j('#mssw-body').setInHtml(message);
	$('#mod-sta-sing-warn').modal({backdrop : 'static'});
}
//warning message
function modalStaticSingleWarning(message){
	$('#mssw-body').css({
		'display' : 'none'
	});
	j('#mssw-message').setInHtml(message);
	$('#mod-sta-sing-warn').modal({backdrop : 'static'});
}
function addModalToComponent(datamodal){
	var temp = document.getElementById('modal-component');
	var temp2 = temp.innerHTML;
	temp.innerHTML = temp.innerHTML+datamodal;
}
function createContact(urlfoto,nama,nim){
a='<a class="pointer list-item">'+
'<div class="list-info">'+
'<img src="'+urlfoto+'" style="max-width:50px; max-heigt:50px;"class="img-circle img-thumbnail">'+
'</div>'+
'<div class="list-text">'+
'<span class="list-text-name">'+nama+'</span>'+
'<div class="list-text-info">'+
	'<i class="icon-info"></i> '+nim+
'</div>'+
'</div>'+
'</a>';
return a;
}
function openModalContact(contact,header){
	j('#mdc-message').setInHtml(header);
	j('#content-contact').setInHtml(contact);
	$('#modal_default_contact').modal({backdrop : 'static'});
}
function hideModalContact(a){
	$('#modal_default_contact').modal("hide");
	a();
}
function openModalForm(content,startSubmit){
	j('#content-form-modal').setInHtml();
	j('#content-form-modal').setInHtml(content);
	var yes = function(){
		var he = function(a){
			if(a){
				$('#submit-edit-acara-default').unbind('click',yes);
				$("#modal_default_form").modal("hide");
			}
		};
		startSubmit(he);
	};
	$('#submit-edit-acara-default').bind('click',yes).focus();
	$("#modal_default_form").modal({backdrop : 'static'});
	var close = function(){
		$('#submit-edit-acara-default').unbind('click',yes);
		$("#modal_default_form").modal("hide");
		$('#close-form-modal').unbind('click',close);
	};
	$("#close-form-modal").bind('click',close);
}
function template(a,b,c){
if(parseInt(b) == 200){
				console.log("server response status");
				if(parseInt(a) == 1){
					console.log("loading "+c);
					setLoadingBarMessage("mengambil response data ...");
				}
				if(parseInt(a) == 2){
					console.log("loaded "+c);
					setLoadingBarMessage("memperoleh response data ...");
				}
				if(parseInt(a) == 3){
					console.log("interactive "+c);
					setLoadingBarMessage("menjawab response data ...");
				}
			}
			if(parseInt(b) == 500){
				console.log("error internal server "+c);
				setLoadingBarMessage("server mengalami kesalahan instruksi ...");
				setTimeout(function(){
					closeLoadingBar();
					//reloadTable();
				},2000);	
			}
			if(parseInt(b) == 404){
				console.log("server not found "+c);
				setLoadingBarMessage("response tidak ditemukan ...");
				setTimeout(function(){
					closeLoadingBar();
					//reloadTable();
				},2000);	
			}
			if(parseInt(b) >= 301 && parseInt(b) <= 303){
				console.log("page has been removed "+c);
				setLoadingBarMessage("response di tolak ...");
				setTimeout(function(){
					closeLoadingBar();
				},2000);	
			}
}
/*
 * type = all input except checkbox and radio
 * value = nilai
 * placeholder = for text
 * clas = class if exist
 * id = id if exist
 * option = array for type == select default ""
 * */
function showDataErrorInput(id,message){
	var a = document.getElementById(id);
	a = a.parentNode;
	a.childNodes[0].childNodes[0].innerHTML = message;
	a.childNodes[0].style.display = 'block';
}
function hideDataErrorInput(id){
	var a = document.getElementById(id);
	a = a.parentNode;
	a.childNodes[0].style.display = 'none';
}
function createInputModal(a,type,value,placeholder,clas,id,name,option){
	var a = '<div class="form-row">'+
		'<div class="col-md-3 grey-blur">'+a+' : </div>'+
		'<div class="col-md-9 ">';
	a += '<div class="form-validation-field-8formError parentFormvalidate formError" style="display : none;opacity: 0.87; position: absolute; top: 0px; left: 0px; margin-top: -42px;">'+
		'<div class="formErrorContent">* This checkbox is required<br></div>'+
			'<div class="formErrorArrow">'+
			'<div class="line10"></div>'+
			'<div class="line9"></div>'+
			'<div class="line8"></div>'+
			'<div class="line7"></div>'+
			'<div class="line6"></div>'+
			'<div class="line5"></div>'+
			'<div class="line4"></div>'+
			'<div class="line3"></div>'+
			'<div class="line2"></div>'+
			'<div class="line1"></div>'+
		'</div>'+
	'</div>';
	if(type.toLowerCase() == 'select')
	{
		a+=('<select class="'+clas+'" id="'+id+'" value="'+value+'" name="'+name+'">');
		for(var i=0;option[i] ;i++){
			a+=('<option style="margin-bottom : 20px;" value="'+option[i][0]+'">'+option[i][1]+'</option>');
		}
		a+=('</select>');
	}
	else if(type.toLowerCase() == 'textarea'){
		a+=('<textarea class="'+clas+'" id="'+id+'" value="'+value+'" name="'+name+'">');
		a+=('</textarea>');
	}
	else{
			a+=('<input style="margin-bottom : 20px;" type="'+type.toLowerCase()+'" class="'+clas+'" id="'+id+'" value="'+value+'" placeholder="'+placeholder+'" name="'+name+'">');
	}
		a+=('</div>'+
	'</div>');
	return a;
}
function openModalDefault(header, content){
	j('#modal_default_header').setInHtml(header);
	j('#modal_default_message').setInHtml(content);
	$('#modal_default').modal({backdrop : 'static'});
}
//
$('document').ready(function(){
	var temp = document.body;
	var temp2 = temp.innerHTML;
	temp.innerHTML = temp.innerHTML+"<div id='modal-component'></div>";
	addModalToComponent(
			'<div class="modal" id="mod-sta-tit-mes-butodec" tabindex="-1" role="dialog" backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">'+ 
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+ 
						'<div class="modal-header">'+ 
							
							'<h4 class="modal-title" id="msmb-message-mod-sta-tit-mes-butodec"></h4>'+
						'</div>'+
						'<div class="modal-body" id="msmb-body-mod-sta-tit-mes-butodec">'+
							
						'</div>'+
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-success btn-clean" id="msmb-yes-mod-sta-tit-mes-butodec">ya</button>'+
							'<button type="button" class="btn btn-danger btn-clean" id="msmb-no-mod-sta-tit-mes-butodec">tidak</button>'+ 
						'</div>'+ 
					'</div>'+ 
				'</div>'+ 
			'</div>'+
			'<div class="modal" id="mod-sta-mul-but" tabindex="-1" role="dialog" backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">'+ 
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+ 
						'<div class="modal-header">'+ 
							
							'<h4 class="modal-title" id="msmb-message"></h4>'+
						'</div>'+
						'<div class="modal-body" id="msmb-body">'+
							
						'</div>'+
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-success btn-clean" id="msmb-yes">ya</button>'+
							'<button type="button" class="btn btn-danger btn-clean" id="msmb-no">tidak</button>'+ 
						'</div>'+ 
					'</div>'+ 
				'</div>'+ 
			'</div>'+
			'<div class="modal modal-warning" id="mod-sta-sing-warn" tabindex="-1" role="dialog" backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">'+ 
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+ 
						'<div class="modal-header">'+ 
							
							'<h4 class="modal-title" id="mssw-message"></h4>'+
						'</div>'+
						'<div id="mssw-body" class="" style="background-color : rgb(200,200,200); color: #666;">'+
							
						'</div>'+
						'<div class="modal-footer">'+
							'<button id="mod-sta-sing-warn-terima-kasih" type="button" class="btn btn-danger btn-clean" data-dismiss="modal">Terima kasih</button>'+ 
						'</div>'+ 
					'</div>'+ 
				'</div>'+ 
			'</div>'+
			'<div class="modal" id="modal_default_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">'+
				'<div class="modal-dialog"> <div class="modal-content">'+
					'<div class="modal-header">'+
						'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'+
							'<h4 class="modal-title" id="mdc-message">Contacts</h4>'+
						'</div>'+
						'<div class="modal-body clearfix np">'+
							'<div class="list list-contacts" id="content-contact">'+
								
							'</div>'+
						'</div>'+
						'<div class="modal-footer">'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<div class="modal" id="modal_default_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">'+
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+
						'<div class="modal-header">'+
							'<h4 class="modal-title">Formulir</h4>'+
						'</div>'+
						'<div class="modal-body clearfix">'+
							'<div class="controls" id="content-form-modal">'+
								
							'</div>'+
						'</div>'+					
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-default btn-clean" id="close-form-modal">Tutup</button>'+
							'<button type="button" class="btn btn-success btn-clean" id="submit-edit-acara-default">Masukan data</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
			'<div class="modal" id="modal_default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">'+
				'<div class="modal-dialog">'+
					'<div class="modal-content">'+
						'<div class="modal-header">'+
							'<h4 class="modal-title" id="modal_default_header">Informasi sekilas</h4>'+
						'</div>'+
						'<div class="modal-body clearfix">'+
							'<p class="grey-blur" id="modal_default_message" class="" style="word-wrap : true;word-break:break-all;word-wrap:break-word;"></p>'+
						'</div>'+
						'<div class="modal-footer">'+
							'<button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Tutup</button>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'
	);
});