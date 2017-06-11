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
				<div class="col-md-3">Bidang Riset:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="SC,RPL,SI,KD" name="" id="support-bidang"> </div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">No Hp:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="No handphone" name="" id="support-nohp"> </div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">E-mail:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="Email" name="" id="support-email"> </div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">Alamat:</div> 
				<div class="col-md-9"> <input type="text" class="form-control" placeholder="Alamat " name="" id="support-alamat"> </div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-3">Gender:</div> 
				<div class="col-md-9"> 
				<select class="form-control" name="" id="support-gender">
					<option value="0">belum dipilih</option>
					<option value="1">Pria</option>
					<option value="2">Wanita</option>
				</select>
				</div> 
			</div> 
		</div> 
		<div class="footer tar"> 
			<button class="btn btn-default btn-clean" id="ubah-profile">Konfirmasi</button> 
		</div> 
		<form id="picture-session" class="hidden" >
			<input type="file" name="data-gambar" id="support-gambar">
		</form>
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
