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
			<div class="col-md-3">Operasi </div>
			<div class="col-md-9">
			<?php 
				if($mydosen){
					echo "
					<div >
					<div class='col-md-12'>
					<span class='icon-ok pointer' style='color:green' onclick='beNotMyFavorThisGuys(".'"'.$nip.'"'.",1);' title='Dosen Favorit : Ya'></span>
					</div>
					</div>";
				}else{ 
					echo "
					<div >
					<div class='col-md-12'>
					<span class='icon-remove pointer' style='color:red' onclick='beMyFavorThisGuys(".'"'.$nip.'"'.",1);' title='Dosen Favorit : Tidak'></span>
					</div>
					</div>";
					
				}
			?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">favorit anda </div>
			<div class="col-md-9">
				<table>
					<thead>
						<tr>
							<th>No </th>
							<th>Nip </th>
							<th>Nama </th>
							<th>Operasi </th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if($favorite == null){
						echo "
						<tr>
							<th>-</th>
							<th>-</th>
							<th>-</th>
							<th>tidak ada</th>
						</tr>";
					}else {
						foreach ($favorite as $value){
							echo "
							<tr>
								<th>".$value[0]."</th>
								<th>".$value[1]."</th>
								<th>".$value[2]."</th>
								<th>
									<div style='text-align : center;'>
										<div class='col-md-12'>
											<span class='icon-ok pointer' style='color:green' onclick='beNotMyFavorThisGuys(".'"'.$value[1].'"'.",1);' title='Dosen Favorit : Ya'></span>
										</div>
									</div>
								</th>
							</tr>";
						}
					}
					?>
					</tbody>
					
				</table>
			</div>
		</div>
	</div>
</div>