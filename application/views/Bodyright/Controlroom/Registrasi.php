<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
	 

<div class="block">
	<div>
		<div class="block">
			<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
				<div id="controller-diagram" style="min-width: 1500px;">
					<canvas id="canvas" style=""></canvas>
				</div>
			</div>
		</div>
		<div class="block"> 
			<div class="header"> 
				<h2>Registrasi Pemerataan Mahasiswa</h2>
			</div> 
			<div class="content">
				<div>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='
						$("#search-name-pemerataan").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-name-pemerataan").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<!--<a style="position : absolute; color : #666666; font-size : 22px; right : 0; margin-right : 26px;" class="pointer" onclick="hello()"><i class="icon-search"></i></a>-->
						<input type="text" id="search-name-pemerataan" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
					</label>
					<label style="margin : 10px; float: right;">
						<select id="tahun-ajaran">
							<?php 
							for($i=2013; $i<= $year;$i++){
								if($i == $year)
									echo "<option value='".$i."' selected>Tahun ajaran ".$i."-".($i+1)."</option>";
								else
									echo "<option value='".$i."'>Tahun ajaran ".$i."-".($i+1)."</option>";
							}
							?>
						</select>
					</label>
					<label style="margin : 10px; float: right;">
						<select id="semester-ajaran">
							<option value="1" <?php if($smts) echo "selected"?>>Semester 1</option>
							<option value="2" <?php if($smtd) echo "selected"?>>Semester 2</option>
						</select>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='openXLForm(base_url+"Controlresultregistrasi/getDataWithExcel")'><i class="icon-file-alt" title="download sebagai excel"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='saveAllPemerataanList()'><i class="icon-save" title="Simpan semua perubahan pada page ini"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a class='pointer'><i onclick='setOnThisPageAsJustOne(3)' style='color : #00cc00'  class="icon-remove" title="Tolak satu page"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a class='pointer'><i onclick='setOnThisPageAsJustOne(1)'  style='color : #00cc00'  class="icon-time" title="Menunggu satu page"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a class='pointer'><i onclick='setOnThisPageAsJustOne(2)'  style='color : #00cc00'  class="icon-ok" title="Setujui satu page"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a class='pointer'><i onclick='setOnThisPageAsForAll(3)' style='color : #ff3300'  class="icon-remove" title="Tolak semua"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a class='pointer'><i onclick='setOnThisPageAsForAll(1)' style='color : #ff3300'  class="icon-time" title="Menunggu semua"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a class='pointer'><i onclick='setOnThisPageAsForAll(2)' style='color : #ff3300' class="icon-ok" title="Setujui semua"></i></a></span>
					</label>
					<div>
					</div>
				</div> 
				<div style="overflow-x : auto; margin-top : 120px;">
					<table class="table table-striped table-hover "> 
						<thead> 
							<tr> 
								<th>No</th>
								<th>Nama Mahasiswa</th>
								<th>Registrasi</th>   
								<th>Dosen Pembimbing</th>
								<th>Dosen Sebelumnya</th>
								<th>Dosen log</th> 
								<th>Dosen review</th>
								<th>Action</th>
								<th style="width : 400px;">Pesan Info</th>
							</tr> 
						</thead> 
						<tbody id="tabel-pemerataan-mahasiswa" style="overflow-y : auto; max-height: 250px;">  
							<tr > 
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
				<div class="dataTables_paginate paging_two_button" id="table-pemerataan-next-prev">
					<a class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">Previous</a>
					<a class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">Next</a>
				</div>
			</div> 
		</div>
	</div>
</div>