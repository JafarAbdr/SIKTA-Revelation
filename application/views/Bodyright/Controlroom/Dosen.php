<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
<div class="block"> 
	<div class="header"> 
		<div>
			<h2>Daftar Dosen</h2>
		</div>
	</div> 
	<div class="content">
	
		<div>
			<div class="col-md-8">
				<button class="btn grey-back" id="add-new-dosen" onclick="addNewDosen();" style="position: absolute; right : 0;"><span class="icon-plus"></span></button>
			</div>
			<div class="col-md-4">
			<input type="text" id="search-dosen"  pattern="[a-zA-Z0-9 @.]{0,50}" placeholder="Nama Dosen ..."/>
			</div>
				
			
		</div> 
		<div style="overflow-x : auto; margin-top : 120px;"  class="table-responsive">
			<table class="table table-striped table-hover"> 
			<thead> 
				<tr> 
					<th>No</th> 
					<th>Nip</th> 
					<th>Nama Dosen</th> 
					<th>Bidang</th> 
					<th>Mahasiswa Bimbingan</th>
					<th>Status</th> 
				</tr> 
			</thead> 
			<tbody id="data-table-dosen">  
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tbody> 
		</table>
		</div>  
		<div class="dataTables_paginate paging_two_button" id="table-dosen-next-prev">
			<a class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">Previous</a>
			<a class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">Next</a>
		</div> 
	</div> 
</div>
<div class="block">
	
</div>