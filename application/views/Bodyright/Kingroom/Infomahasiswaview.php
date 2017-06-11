<?php
if(!defined('BASEPATH'))
	exit('you dont have access this path');
?>
<div class="block" >
	<div class='container'>
		<div class='row'>
			<div class="col-md-2" style="height : 100%;">
				<img style="max-height : 100%; width: 100%;" src="<?php echo base_url().'filesupport/getPhotoMahasiswaProfil/'.$nim.".aspx";?>">
			</div>
			<div class="col-md-10">
				<div class="row">
					<div class="col-md-3">Nama </div>
					<div class="col-md-9"><?php echo $nama;?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Nim </div>
					<div class="col-md-9"><?php echo $nim;?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Peminatan </div>
					<div class="col-md-9"><?php echo $minat;?></div>
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
					<div class="col-md-3">Judul TA </div>
					<div class="col-md-9"><?php echo $judulTA;?></div>
				</div>
				<div class="row">
					<div class="col-md-3">Status TA </div>
					<div class="col-md-9"><?php echo $statusTA;?></div>
				</div>
			</div>
			<div class='col-md-12'>
				<ul class="nav nav-tabs"> 
					<li class="active tip" title="KRS">
						<a href="#krs-preview" data-toggle="tab" ><span class="icon-file-alt"></span></a>
					</li>
					<li class="tip" title="Transkrip">
						<a href="#transkrip-preview" data-toggle="tab" ><span class="icon-file-alt"></span></a>
					</li>		
				</ul> 
				<div class="content content-transparent tab-content"> 
					<div class="tab-pane active" id="krs-preview"> 
						<div>
							<iframe name='kode' style='width : 100%; height : 450px;' src='<?php echo $urlkrs;?>'></iframe>
						</div>
					</div>
					<div class="tab-pane" id="transkrip-preview"> 
						<div>
							<iframe name="lolo" style='width : 100%; height : 450px;' src='<?php echo $urltranskrip;?>'></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>