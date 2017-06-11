<?php
if(!defined('BASEPATH'))
	exit('you dont have access this path');
?>
<div class="block" >
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6" style="height : 100%; text-align : center;">
				<img style="max-height : 100%; max-width: 100px; text-align : center;" src="<?php echo base_url()."resources/mystyle/image/undip.png";?>">
			</div>
			<div class="col-md-6" style="height : 100%; text-align : center;">
				<img style="max-height : 100%; max-width: 100px;  text-align : center;" src="<?php echo base_url().'filesupport/getPhotoMahasiswaProfil/'.$nim.".aspx";?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6" style="text-align : center;"><?php echo $dosenNama;?></div>
			<div class="col-md-6" style="text-align : center;"><?php echo $nama;?></div>
		</div>
		<div class="row">
			<div class="col-md-6"  style="text-align : center;"><?php echo $dosenNip;?></div>
			<div class="col-md-6"  style="text-align : center;"><?php echo $nim;?></div>
		</div>
		<div class="row">
			<div class="col-md-6" style="text-align : center;"><?php echo $dosenBidris;?></div>
			<div class="col-md-6" style="text-align : center;"><?php echo $minat;?></div>
		</div>
		<div class="row">
			<div class="col-md-6" style="text-align : center;"><?php echo $dosenFavor;?></div>
			<div class="col-md-6" style="text-align : center;">dosen favorit</div>
		</div>
	</div>
</div>