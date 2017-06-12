<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
<div class="block"> 
	<div class="header"> 
		<div>
			<h2>Rekapitulasi Dosen</h2>
		</div>
	</div> 
	<div class="content">
	
		<div>
			<label style="margin : 10px; float: right;">
				<!--<a style="position : absolute; color : #666666; font-size : 22px; right : 0; margin-right : 26px;" class="pointer" onclick="hello()"><i class="icon-search"></i></a>-->
				<input type="text" id="search-name-rekapitulasi" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
			</label>
			<label style="margin : 10px; float: right;">
				<select id="tahun-ajaran" onchange="checkSemesterOnRekap(this)">
					<?php 
					$year= intval(substr($srt,0,4));
					for($i=2013; $i<= $year;$i++){
						if($i == $year)
							echo "<option value='".$i."' selected>Tahun ajaran ".$i."-".($i+1)."</option>";
						else
							echo "<option value='".$i."'>Tahun ajaran ".$i."-".($i+1)."</option>";
					}
					?>
				</select>
			</label>
			<label id="label-semester-ajaran" style=" margin : 10px; float: right;">
				<select id="semester-ajaran">
					<!--<option value="0" selected>satu tahun ajaran</option>-->
					<option value="1" <?php if($srt[4] == '1') echo 'selected';?>>Semester 1</option>
					<option value="2" <?php if($srt[4] == '2') echo 'selected';?>>Semester 2</option>
				</select>
			</label>
			<label style="margin : 10px; float: right;">
				<span style='font-size : 21px; color : blue;'><a onclick='openXLRekap(base_url+"/Controlrekap/getDataWithExcel")'><i class="icon-file-alt" title="download sebagai excel"></i></a></span>
			</label>	
			
		</div> 
		<div style="overflow-x : auto; margin-top : 120px;"  class="table-responsive">
			<table class="table table-striped table-hover"> 
			<thead> 
				<tr> 
					<th>No</th> 
					<th>Nip</th> 
					<th>Nama Dosen</th> 
					<th>Jumlah Bimbingan</th> 
					<th>Jumlah Menguji</th>
					<th>Jumlah Lulusan</th> 
					<th>Masa Bimbingan</th> 
				</tr> 
			</thead> 
			<tbody id="data-table-rekap">  
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tbody> 
		</table>
		</div> 
		<div class="dataTables_paginate paging_two_button" id="table-rekap-next-prev">
			<a class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">Previous</a>
			<a class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">Next</a>
		</div> 
	</div> 
</div>
<div class="block">
	
</div>