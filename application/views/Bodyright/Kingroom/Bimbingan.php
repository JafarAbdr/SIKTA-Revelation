<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block"> 
	<div class='accordion accordion-transparent'> 
		<h3>Bimbingan</h3> 
		<div> 
			<div class="header"> 
				<h2>Tabel mahasiswa bimbingan anda, periode <?php 
				$temp = intval(DATE('m'));
				if($temp <=6 && $temp >= 1){
					echo (intval(DATE('Y'))-1)."-".intval(DATE('Y'))." Semester 2";
				}else{
					echo intval(DATE('Y'))."-".(intval(DATE('Y'))+1)." Semester 1";
				}
				?></h2>
			</div> 
			<div class="content">
				<div>
						<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='
						$("#search-by-name").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-by-name").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-by-name" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="nama  ..."/>
					</label>
				</div> 
				<div style="overflow-x : auto; margin-top : 60px;">
					<table class="table table-striped table-hover "> 
						<thead> 
							<tr> 
								<th style='text-align : center;'>Nim</th>
								<th style='text-align : center;'>Nama</th> 
								<th style='text-align : center;'>Judul</th> 
								<th style='text-align : center;'>Status</th> 
								<th style='text-align : center;'>Operasi</th> 
							</tr> 
						</thead> 
						<tbody id="tabel-bimbingan-dosen" style="overflow-y : auto; height: 200px;">   
							<tr>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
								<td style='text-align : center;'>-</td>
							</tr>
						</tbody> 
					</table>
				</div> 
			</div>
		</div> 
		<h3 id='refresh-yes-cup'>Cup Mahasiswa</h3> 
		<div> 
			<div class='accordion accordion-transparent'> 
				<h3 id='notifikasi-cup-refresh'>List notifikasi</h3> 
				<div> 
					<div class="content">
						<div>
							
							<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='
						$("#search-notifikasi-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-notifikasi-cup").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-notifikasi-cup" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="nama  ..."/>
					</label>
						</div> 
						<div style="overflow-x : auto; margin-top : 60px;">
							<table class="table table-striped table-hover "> 
								<thead> 
									<tr> 
										<th style='text-align : center;'>Nim</th>
										<th style='text-align : center;'>Nama</th> 
										<th style='text-align : center;'>Operasi</th> 
									</tr> 
								</thead> 
								<tbody id="tabel-notifikasi-cup" style="overflow-y : auto; height: 200px;">   
									<tr>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
									</tr>
								</tbody> 
							</table>
						</div> 
					</div>
					
				</div>
				<h3 id='prooses-cup-refresh'>List proses</h3> 
				<div> 
					<div class="content">
						<div>
							
							<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='
						$("#search-proses-cup").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-proses-cup").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-proses-cup" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="nama  ..."/>
					</label>
						</div> 
						<div style="overflow-x : auto; margin-top : 60px;">
							<table class="table table-striped table-hover "> 
								<thead> 
									<tr> 
										<th style='text-align : center;'>Nim</th>
										<th style='text-align : center;'>Nama</th> 
										<th style='text-align : center;'>Operasi</th> 
									</tr> 
								</thead> 
								<tbody id="tabel-proses-cup" style="overflow-y : auto; height: 200px;">   
									<tr>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
										<td style='text-align : center;'>-</td>
									</tr>
								</tbody> 
							</table>
						</div> 
					</div>

					
				</div>
			</div>
		</div> 
	</div> 
</div>