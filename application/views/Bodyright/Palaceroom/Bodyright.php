<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="col-md-7" id="right-layout">
	<div class="block block-drop-shadow" id="content-intern">
	</div>
	<div class="block block-drop-shadow"  id="setting-left-3" style="display : none;"> 
		<div class="header"> 
			<h2>Info Anda</h2> 
		</div> 
		<div class="content controls"> 
			<div class="form-row">
				<div class=col-md-12>
					Info umum
				</div>
			</div>   
			<div class="form-row"> 
				<div class=col-md-3>
					Nama
				</div>
				<div class="col-md-9">
					<input type="text" class="form-control" id="info-anda-nama" placeholder="Nama anda"> 
				</div> 
			</div>  
			<div class="form-row"> 
				<div class=col-md-3>
					Nip
				</div>
				<div class="col-md-9">
					<input type="text" class="form-control" id="info-anda-nip" placeholder="Nip anda"> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class=col-md-3>
					Alamat
				</div>
				<div class="col-md-9">
					<input type="text" class="form-control" id="info-anda-alamat" placeholder="Alamat anda"> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class=col-md-3>
					Email
				</div>
				<div class="col-md-9">
					<input type="text" class="form-control" id="info-anda-email" placeholder="Email anda"> 
				</div> 
			</div> 
			<div class="form-row">
				<div class=col-md-3>
					Kontak
				</div> 
				<div class="col-md-9">
					<input type="text" class="form-control" id="info-anda-kontak"  placeholder="Kontak anda"> 
				</div> 
			</div>
			<div class="form-row">
				<div class=col-md-12>
					Info Jurusan
				</div>
			</div> 
			<div class="form-row">
				<div class=col-md-3>
					Ketua Jurusan
				</div> 
				<div class="col-md-9">
					<select class="form-control" id="info-anda-kajur">
					<option value=0>Belum diplih</option>
					<?php
					foreach($listDosen as $tempData){
						echo "<option value='".$tempData['nip']."'>".$tempData['nama']."</option>"; 
					}
					?>
					</select> 
				</div> 
			</div>
			<div class="form-row">
				<div class=col-md-3>
					Wakil Jurusan
				</div> 
				<div class="col-md-9">
					<select class="form-control" id="info-anda-wakil">
					<option value=0>Belum diplih</option>
					<?php
					foreach($listDosen as $tempData){
						echo "<option value='".$tempData['nip']."'>".$tempData['nama']."</option>"; 
					}
					?>
					</select> 
				</div> 
			</div>
			<div class="form-row">
				<div class=col-md-12>
					Tugas Akhir 1 Durasi
				</div>
			</div> 
			<div class="form-row"> 
				<div class=col-md-3>
					Jam
				</div>
				<div class="col-md-9"> 
					<select type="text" class="form-control" id="info-jam-ta1-durasi">
						<option value="0">0</option>
						<?php
						$j=5;
						for($i=1; $i<=$j;$i++){
							echo "<option value='".$i."'>".$i."</option>"; 
						}
						?>
					</select> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class=col-md-3>
					Menit
				</div>
				<div class="col-md-9"> 
					<select type="text" class="form-control" id="info-menit-ta1-durasi">
						<option value="0">0</option>
						<?php
						$j=60;
						for($i=5; $i<=$j;$i+=5){
							echo "<option value='".$i."'>".$i."</option>"; 
						}
						?>
					</select> 
				</div> 
			</div> 
			<div class="form-row">
				<div class=col-md-12>
					Tugas Akhir 2 Durasi
				</div>
			</div> 
			<div class="form-row"> 
				<div class=col-md-3>
					Jam
				</div>
				<div class="col-md-9"> 
					<select type="text" class="form-control" id="info-jam-ta2-durasi">
						<option value="0">0</option>
						<?php
						$j=5;
						for($i=1; $i<=$j;$i++){
							echo "<option value='".$i."'>".$i."</option>"; 
						}
						?>
					</select> 
				</div> 
			</div> 
			<div class="form-row"> 
				<div class=col-md-3>
					Menit
				</div>
				<div class="col-md-9"> 
					<select type="text" class="form-control" id="info-menit-ta2-durasi">
						<option value="0">0</option>
						<?php
						$j=60;
						for($i=5; $i<=$j;$i+=5){
							echo "<option value='".$i."'>".$i."</option>"; 
						}
						?>
					</select> 
				</div> 
			</div> 
		</div> 
		<div class="footer tar"> 
			<button class="btn btn-default btn-clean" onclick="setUpdateInfoAdmin(this);" id="info-diri-submit">Konfirmasi</button> 
		</div> 
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
			<button class="btn btn-default btn-clean" onclick="ubahPasswordAdmin()" id="ubah-password">Konfirmasi</button> 
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
