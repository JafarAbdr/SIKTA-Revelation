<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>
<div class=col-md-2>
      <div class="block block-drop-shadow" id="default-page-content-1">
        <div class="user bg-default bg-light-rtl">
          <div class=info> 
          	<img src=<?php echo $image;?> class="img-circle img-thumbnail"/> 
          </div>
        </div>
        <div class="content list-group list-group-icons"> 
        	<a href=<?php echo base_url();?> class=list-group-item><span class=icon-windows></span> Ke Halaman Pengunjung</a> 
        	<a id="go-to-pengaturan" href=# class=list-group-item><span class=icon-cogs></span> pengaturan</a> 
        	<a id='keluar-confirm-exe' class='list-group-item pointer'><span class=icon-off></span> keluar</a> 
        </div>
      </div>
	  <div class="block block-drop-shadow" id="setting-left-1" style="display : none;"> 
		<div class="head bg-dot30 npb"> 
			<h2>foto profil</h2> 
			<!--
			<div class="pull-right"> 
				<button class="btn btn-default btn-clean" id="ubah-gambar">simpan</button>
			</div>
			-->
		</div>
		<div class="head bg-dot30 np tac"> 
			<img src=<?php echo $image;?> class="img-thumbnail img-circle"> 
		</div> 
		<div class="content controls"> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<input type="text" class="form-control" id="support-nama" placeholder="Nama Mahasiswa" value="Administrator" disabled> 
				</div> 
			</div> 
		</div> 
	</div>
</div>
    