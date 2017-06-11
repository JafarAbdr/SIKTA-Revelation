<?php
if(!defined('BASEPATH'))
	exit('you dont have access this path');
?>
<div class="block" >
	<div class="col-md-2" style="height : 100%;">
		<img style="max-height : 100%; width: 100%;" src="<?php echo base_url()."resources/mystyle/image/undip.png";?>">
	</div>
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-3">Nama </div>
			<div class="col-md-9"><?php echo $nama;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Nip </div>
			<div class="col-md-9"><?php echo $nip;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Bidang riset </div>
			<div class="col-md-9"><?php echo $bidris;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Alamat </div>
			<div class="col-md-9"><?php echo $alamat;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Email </div>
			<div class="col-md-9"><?php echo $email;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">No telp </div>
			<div class="col-md-9"><?php echo $notelp;?></div>
		</div>
		<div class="row">
			<div class="col-md-3">Dosen Favorit </div>
			<div class="col-md-9"><?php echo $dosenFavor;?></div>
		</div>
	</div>
</div>