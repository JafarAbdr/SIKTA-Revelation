<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
$dataMonth = array(
	'Januari',
	'Februari',
	'Maret',
	'April',
	'Mei',
	'Juni',
	'Juli',
	'Agustus',
	'September',
	'Oktober',
	'Nopember',
	'Desember'
);
?>
<div class="col-md-7" id="right-layout">
	<div class="block block-drop-shadow" id="content-intern">
	</div>
	<div class="block block-drop-shadow" id="content-setting" style="display : none;"> 
		<div class="header"> 
			<h2>Data Pendukung</h2> 
		</div> 
		<div class="content controls"> 
			<div class="form-row">				
				<div class="col-md-2">Mulai Ganjil:</div> 
				<div class="col-md-10"> 	
					<div class="form-row"> 
						<div class="col-md-3">Bulan:</div> 
						<div class="col-md-9"> 
							<select class='form-control' onchange="getDataTabel1(this.value,1)" id="bulan-ganjil-1">
								<?php
									for($i=0;$i<12;$i++){
										echo '<option value="'.($i+1).'">'.$dataMonth[$i].'</option>';
									}
								
								?>
							</select>
						</div>
					</div> 	
					<div class="form-row"> 
						<div class="col-md-3">Tanggal:</div> 
						<div class="col-md-9" id='tanggalganjil'> 
							
						</div>
					</div> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class="col-md-2">Mulai Genap:</div> 
				<div class="col-md-10">
					<div class="form-row"> 
						<div class="col-md-3">Bulan:</div> 
						<div class="col-md-9"> 
							<select class='form-control' onchange="getDataTabel2(this.value,1)" id="bulan-genap-1">
								<?php
									for($i=0;$i<12;$i++){
										echo '<option value="'.($i+1).'">'.$dataMonth[$i].'</option>';
									}
								
								?>
							</select>
						</div>
					</div> 	
					<div class="form-row"> 
						<div class="col-md-3">Tanggal:</div> 
						<div class="col-md-9" id='tanggalgenap'> 
							
						</div>
					</div> 
				</div> 
			</div> 
		</div> 
		<div class="footer tar"> 
			<button class="btn btn-default btn-clean" onclick="ubahDataGanjilGenapTahunConstrain()" id="ubah-profile">Konfirmasi</button> 
		</div> 
		<form id="picture-session" class="hidden" >
			<input type="file" name="data-gambar" id="support-gambar">
		</form>
	</div>
	<div class="block block-drop-shadow"  id="content-setting-2" style="display : none;"> 
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
			<button class="btn btn-default btn-clean" onclick="ubahPasswordKoor()" id="ubah-password">Konfirmasi</button> 
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
