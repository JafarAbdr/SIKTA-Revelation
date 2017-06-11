function baseSeminar(){
	//alert("baseSeminar");
	reloadTableInfoPublicTA1();
	$("#search-judul-seminar-ta1").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoSeminarTA1public = $(this).val();
			reloadTableInfoPublicTA1();
		}
	});
	reloadTableInfoPublicTA2();
	$("#search-judul-seminar-ta2").keyup(function(event){
		if(event.keyCode == 13){
			keyNameInfoSeminarTA2public = $(this).val();
			reloadTableInfoPublicTA2();
		}
	});
	$("#reload-seminar-ta1").on("click",function(){
		reloadTableInfoPublicTA1();
	});
	$("#reload-seminar-ta2").on("click",function(){
		reloadTableInfoPublicTA2();
	});
}

var keyNameInfoSeminarTA1public=null;
var keyNameInfoSeminarTA2public=null;
function reloadTableInfoPublicTA1(){
	if(keyNameInfoSeminarTA1public==null){
		$("#searchsearch-judul-seminar-ta1").val("");
		keyNameInfoSeminarTA1public = "";
	}else{
		$("#search-judul-seminar-ta1").val(keyNameInfoSeminarTA1public);
	}
	j("#setAjax").setAjax({
		url : base_url+"Baseseminar/getTableSeminarTA1InfoPublic.aspx",
		methode : "post",
		content : "keyword="+keyNameInfoSeminarTA1public,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-list-public-seminar-ta1").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel registrasi");
		}
	});
}
function reloadTableInfoPublicTA2(){
	if(keyNameInfoSeminarTA2public==null){
		$("#search-judul-seminar-ta2").val("");
		keyNameInfoSeminarTA2public = "";
	}else{
		$("#search-judul-seminar-ta2").val(keyNameInfoSeminarTA2public);
	}
	j("#setAjax").setAjax({
		url : base_url+"Baseseminar/getTableSeminarTA2InfoPublic.aspx",
		methode : "post",
		content : "keyword="+keyNameInfoSeminarTA2public,
		bool : true,
		sucOk : function(a){
			//alert(a);
			if(a[0]=="1")
				$("#tabel-list-public-seminar-ta2").html(a.substr(1,a.length-1));
		},
		sucEr : function(a,b){
			template(a,b,"sesi pengambilan tabel registrasi");
		}
	});
}