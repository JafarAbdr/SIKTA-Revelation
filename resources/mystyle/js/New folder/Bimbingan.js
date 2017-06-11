function mainBimbingan(){
	
}
function seeAllCadetThisGuys(g){
	openLoadingBar("mencoba mengambil data ...");
	j("#setAjax").setAjax(
	{
		methode : 'POST',
		url : 'Classbimbingan/getJsonListMahasiswa.aspx',
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
			},2000);
		},
		sucEr : function(a,b){
			template(a,b,"status refreshing list mahasiswa");
		}
	}
	);
}
