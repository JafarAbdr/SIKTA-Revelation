<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="col-md-7">
	<div class="block block-drop-shadow" id="content-intern">
	</div>
	<div class="block block-drop-shadow" id="content-setting" style="display : none;"> 
		<div class="header"> 
			<h2>Data Pendukung</h2> 
		</div> 
		<div class="content controls"> 
			<div class="form-row"> 
				<div class="col-md-3">E-mail:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="Email" name="" id="support-email"> </div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">No Hp:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="No hp" name="" id="support-no-hp"> </div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">Nama Orang tua:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="Nama orang tua" name="" id="support-nama-ortu"></div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">No Hp Orang Tua:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" value="No hp orang tua" name="" id="support-no-hp-ortu"></div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">Bidang Minat:</div>
				<div class="col-md-9"> 
					<select class="form-control" id="support-peminatan"> 
						<option value="0"></option> 
						<option value="1">Rekayasa Perangkat Lunak</option> 	
						<option value="2">Sistem Informasi</option>  	
						<option value="3">Sistem Cerdas</option>  	
						<option value="4">Komputasi</option> 
					</select> 
					<span class="help-block">wajib dipilih salah satu</span> 
				</div> 
			</div>	
		</div> 
		<div class="footer tar"> 
			<button class="btn btn-default btn-clean" id="ubah-profile">Konfirmasi</button> 
		</div> 
		<div class="content controls">
			<div class="form-row"> 
				<div class="col-md-3">Transkrip:</div> 
				<div class="col-md-9"> 
					<span  style='font-size : 30px; color : green; cursor : pointer; margin-right : 20px;'><i onclick="lihatTranskrip()" title='lihat Transkrip' class="icon-eye-open"></i></span>
					<span  style='font-size : 30px; color : green; cursor : pointer;' onclick="updateTranskrip()"><i title='ganti Transkrip' class="icon-upload-alt"></i></span>
					<span class="help-block">File auto upload, hati-hati sebelum mengganti</span> 
				</div> 
			</div> 
		</div> 
		<form id="picture-session" class="hidden" method='POST' target="frame-upload-pengaturan" enctype="multipart/form-data" action="Classpengaturan/setNewProfile.jsp">
			<input type="file"  onchange='uploadGambar();'  name="data-gambar" id="support-gambar" accept='.jpg,.png'>
		</form>
		<form id="transkrip-session" class="hidden" method='POST' target="frame-upload-pengaturan" enctype="multipart/form-data" action="Classpengaturan/setNewTranskrip.jsp">
			<input type="file" onchange='uploadTranskrip();' accept=".pdf" name="upgrade-transkrip" id="support-transkrip">
		</form>
        <iframe id="frame-upload-pengaturan" name="frame-upload-pengaturan" style="display: none;"></iframe>
	</div>
	<div class="block block-drop-shadow"  id="setting-left-2" style="display : none;"> 
		<div class="header"> 
			<h2>Ubah Password</h2> 
		</div> 
		<div class="content controls"> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<input type="text" class="form-control" id="support-old-password" placeholder="Old password"> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<input type="text" class="form-control" id="support-new-password"  placeholder="New password"> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<input type="text" class="form-control" id="support-con-password"  placeholder="Re-password"> 
				</div> 
			</div> 
		</div> 
		<div class="footer tar"> 
			<button class="btn btn-default btn-clean" id="ubah-password">Konfirmasi</button> 
		</div> 
	</div>
</div>







<!-- 

<div class="form-validation-field-0formError parentFormvalidate formError" style="opacity: 0.87; position: absolute; top: 0px; left: 10px; margin-top: -27px;"><div class="formErrorContent">* This field is required<br>
</div>
<div class="formErrorArrow">
<div class="line10">
</div>
<div class="line9">
<div class="line8">
<div class="line7">
<div class="line6">
<div class="line5">
<div class="line4">
<div class="line3">
<div class="line2">
<div class="line1">
</div>
</div>
 -->
