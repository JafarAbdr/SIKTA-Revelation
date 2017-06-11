<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active grey-back">
			<a href="#tab5" data-toggle="tab"><span title="bimbingan saya" class="icon-group pointer"></span></a>
		</li> 
		<li class="grey-back"><a href="#tab6" data-toggle="tab"><span title="Semua Bimbingan" class="pointer icon-globe"></span></a></li> 
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Tahun Ajaran <?php 
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester 2";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester 1";
					}
					?></h2>
					<br>
				</div> 
				<div>
					<div class="header">
						<h2>Dosen Bimbingan</h2>
					</div>
					<div style="width : 100%;" class="header">
						<div class="col-md-3">Nip</div>
						<div class="col-md-9">: <?php echo $TEMP_NIP;?></div>
					</div>
					<div style="width : 100%;" class="header">
						<div class="col-md-3">Nama</div>
						<div class="col-md-9">: <?php echo $TEMP_NAMA;?></div>
					</div>
					<div style="width : 100%;" class="header">
						<div class="col-md-3">Bidang</div>
						<div class="col-md-9">: <?php echo $TEMP_BIDANG;?></div>
					</div>
				</div>
				<div class="content">
					<div style="overflow-x : auto; margin-top : 30px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>No</th>
									<th>Nim</th>
									<th>Nama</th>
									<th>Judul Ta</th> 
									<th>Status</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-acara-default" style="overflow-y : auto; max-height: 250px;">   
									<?php 
									foreach($TEMP_DATA as $TEMP_VALUE){
										echo "<tr><td>".$TEMP_VALUE['NO']."</td>";
										echo "<td>".$TEMP_VALUE['NIM']."</td>";
										echo "<td>".$TEMP_VALUE['NAMA']."</td>";
										echo "<td>".$TEMP_VALUE['TITLE']."</td>";
										echo "<td>".$TEMP_VALUE['STATUE']."</td></tr>";
									}
									?>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>

		</div> 
		<div class="tab-pane" id="tab6"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Tahun Ajaran <?php 
					$temp = intval(DATE('m'));
					if($temp <=6 && $temp >= 1){
						echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester 2";
					}else{
						echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester 1";
					}
					?></h2>
				</div> 
				<div>
					<div class="header">
						<h2>Daftar Semua Dosen Bimbingan Beserta Bimbingan</h2>
					</div>
				</div>
				<div class="content">
					<div style="overflow-x : auto; margin-top : 30px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>No</th>
									<th>Nip</th>
									<th>Nama</th> 
									<th>Operasi</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-acara-lain" style="overflow-y : auto; max-height: 250px;">   
								<?php
								if($DATA_DOSEN != NULL){								
									foreach($DATA_DOSEN as $TEMP_VALUE){
										echo "<tr><td>".$TEMP_VALUE['NO']."</td>";
										echo "<td>".$TEMP_VALUE['NIP']."</td>";
										echo "<td>".$TEMP_VALUE['NAMA']."</td>";
										echo '<td><div style="text-align : center;">
										<div class="col-md-12">
											<span class="icon-eye-open pointer" onclick="seeAllCadetThisGuys(&quot;'.$TEMP_VALUE['NIP'].'&quot;);" style="color : green" title="Lihat Profil Dosen : ya"></span>
										</div>
										
									</div></td></tr>';
									}	
								}else{
									echo "<tr><td>-</td>";
										echo "<td>-</td>";
										echo "<td>-</td>";
										echo '<td>-</td></tr>';
								}
								?>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>
		</div> 
	</div> 
</div>