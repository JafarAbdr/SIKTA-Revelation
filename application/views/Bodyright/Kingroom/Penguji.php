<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active" id="penguji-TA1">
			<a href="#tab5" data-toggle="tab" title="penguji Bimbingan TA 1"><span class="icon-calendar-empty"></span></a>
		</li> 
		<li class=""  id="penguji-TA2"><a href="#tab6" data-toggle="tab" title="Penguji 3 TA 2" ><span class="icon-calendar"></span></a></li> 
		<li class=""  id="penguji-TA2-pembantu2"><a href="#tab9" data-toggle="tab" title="Penguji 3 TA 2"><span class="icon-calendar"></span></a></li> 
		<li class=""  id="penguji-TA2-pembantu"><a href="#tab7" data-toggle="tab" title="Penguji 2 TA 2"><span class="icon-calendar"></span></a></li> 
		<li class=""  id="penguji-TA2-ketua"><a href="#tab8" data-toggle="tab" title="Penguji 1 TA 2"><span class="icon-calendar"></span></a></li> 
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Penguji bimbingan Seminar TA 1 Tahun Ajaran <?php 
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
						$("#search-name-penguji-ta1").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta1").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-name-penguji-ta1" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim, nama dan judul ta mahasiswa " placeholder="Ketikan sesuatu ..."/>
					</label>
						
					</div> 
					
					<div style="overflow-x : auto; margin-top : 60px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>nim</th>
									<th>nama</th>
									<th>judul</th>
									<th>waktu</th>
									<th>ruang</th>
									<th>operasi</th>
								</tr>
							</thead> 
							<tbody id="tabel-penguji-TA1" style="overflow-y : auto;">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>

		</div> 
		<div class="tab-pane" id="tab6"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Penguji bimbingan Seminar TA 2 Tahun Ajaran <?php 
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
						$("#search-name-penguji-ta2").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-name-penguji-ta2" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim, nama dan judul ta mahasiswa " placeholder="Ketikan sesuatu ..."/>
					</label>
						
					</div> 
					<div style="overflow-x : auto; margin-top : 60px; ">
						<table class="table table-striped table-hover " style="min-width : 1300px;"> 
							<thead> 
								<tr> 
									<th  style='text-align : center;'>nim</th>
									<th style='text-align : center;'>nama</th>
									<th style='text-align : center;'>judul</th>
									<th style='text-align : center;'>waktu</th>
									<th style='text-align : center;'>ruang</th>
									<th style='text-align : center;'>Ketua</th>
									<th style='text-align : center;'>Pembantu 1</th>
									<th style='text-align : center;'>Pembantu 2</th>
									<th style='text-align : center;'>operasi</th>
								</tr>
							</thead> 
							<tbody id="tabel-penguji-TA2" style="overflow-y : auto; ">   
								<tr style="">
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>
		</div>
<div class="tab-pane" id="tab7"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Anggota Penguji Seminar TA 1 Tahun Ajaran <?php 
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
						$("#search-name-penguji-ta2-pembantu").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2-pembantu").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-name-penguji-ta2-pembantu" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim dan nama mahasiswa " placeholder="Ketikan sesuatu ..."/>
					</label>
						
					</div> 
					<div style="overflow-x : auto; margin-top : 60px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th  style='text-align : center;'>nim</th>
									<th style='text-align : center;'>nama</th>
									<th style='text-align : center;'>judul</th>
									<th style='text-align : center;'>waktu</th>
									<th style='text-align : center;'>ruang</th>
									<th style='text-align : center;'>Ketua</th>
									<th style='text-align : center;'>Pembantu 2</th>
									<th style='text-align : center;'>operasi</th>
								</tr>
							</thead> 
							<tbody id="tabel-penguji-TA2-pembantu" style="overflow-y : auto; ">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>

		</div> 
<div class="tab-pane" id="tab9"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Anggota 2 Penguji Seminar TA 1 Tahun Ajaran <?php 
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
						$("#search-name-penguji-ta2-pembantu2").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2-pembantu2").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-name-penguji-ta2-pembantu2" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim dan nama mahasiswa " placeholder="Ketikan sesuatu ..."/>
					</label>
						
					</div> 
					<div style="overflow-x : auto; margin-top : 60px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th  style='text-align : center;'>nim</th>
									<th style='text-align : center;'>nama</th>
									<th style='text-align : center;'>judul</th>
									<th style='text-align : center;'>waktu</th>
									<th style='text-align : center;'>ruang</th>
									<th style='text-align : center;'>Ketua</th>
									<th style='text-align : center;'>Pembantu 2</th>
									<th style='text-align : center;'>operasi</th>
								</tr>
							</thead> 
							<tbody id="tabel-penguji-TA2-pembantu2" style="overflow-y : auto;">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div> 
				</div> 
			</div>

		</div> 
<div class="tab-pane" id="tab8"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Ketua Penguji Seminar TA 2 Tahun Ajaran <?php 
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
						$("#search-name-penguji-ta2-ketua").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-penguji-ta2-ketua").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-name-penguji-ta2-ketua" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" title="Pencarian berdasarkan nim dan nama mahasiswa " placeholder="Ketikan sesuatu ..."/>
					</label>
						
					</div> 
					<div style="overflow-x : auto; margin-top : 60px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th  style='text-align : center;'>nim</th>
									<th style='text-align : center;'>nama</th>
									<th style='text-align : center;'>judul</th>
									<th style='text-align : center;'>waktu</th>
									<th style='text-align : center;'>ruang</th>
									<th style='text-align : center;'>Pembantu 1</th>
									<th style='text-align : center;'>Pembantu 2</th>
									<th style='text-align : center;'>operasi</th>
								</tr>
							</thead> 
							<tbody id="tabel-penguji-TA2-ketua" style="overflow-y : auto;">   
								<tr>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								</tr>
							</tbody> 
						</table>
					</div>  
				</div> 
			</div>
		</div> 		
	</div> 
</div>