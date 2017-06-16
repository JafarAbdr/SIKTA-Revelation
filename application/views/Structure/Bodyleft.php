<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>
<div class='col-md-2'>
	  <div class="block block-transparent"> 
		<div class="head"> 
			<div class="user"> 
				<div class="info user-change"> 
					<img src="<?php echo $image;?> " class="img-circle img-thumbnail"> 
					<div class="user-change-button"> 
						<span class="icon-off"></span> 
					</div> 
				</div>
			</div> 
		</div> 
		<div class="content controls npt"> 
			<div class="form-row"> 
				<div class="col-md-12"> 
					<div class="input-group"> 
						<div class="input-group-addon"> 
							<span class="icon-user"></span> 
						</div> 
						<input type="text" class="form-control" disabled value="<?php echo $nama;?>" placeholder="Login"> 
					</div> 
				</div> 
			</div>
			<?php if($core == null){
			echo '
			<div class="form-row"> 
				<div class="col-md-12"> 
					<a href="Gateinout" class="btn btn-default btn-block btn-clean">Masuk</a> 
				</div> 
			</div>'; 
			}
			else{
			echo '
			<div class="form-row"> 
				<div class="col-md-12"> 
					<a href="'.base_url().'Gateinout" class="btn btn-default btn-block btn-clean">Masuk ke Sistem Akun</a> 
				</div> 
			</div>
			<div class="form-row"> 
				<div class="col-md-12"> 
					<a id="keluar-local" class="btn btn-default btn-block btn-clean">Keluar</a> 
				</div> 
			</div>'; 
			}?>
		</div> 
	</div>
</div>