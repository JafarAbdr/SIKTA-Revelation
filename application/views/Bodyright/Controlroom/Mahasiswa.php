<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	
	 

<div class="block"> 
			<div class="header"> 
				<h2>Mahasiswa buka fitur registrasi</h2>
			</div> 
			<div class="content">
				<div>
				<label style="margin : 10px; float: right;">
						<span style='font-size : 21px; color : blue;'><a onclick='
						$("#search-nama-mahasiswa-registrasi").val("");
						tempObject = {
							keyCode:13
						};
						$("#search-nama-mahasiswa-registrasi").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
					</label>
					<label style="margin : 10px; float: right;">
						<input type="text" id="search-nama-mahasiswa-registrasi" pattern="[a-zA-Z0-9 @.]{0,50}" onkeypress="" placeholder="Nama mahasiswa ..."/>
					</label>
				</div> 
				<div style="overflow-x : auto; margin-top : 60px;">
					<table class="table table-striped table-hover "  style=""> 
						<thead> 
							<tr> 
								<th>No</th>
								<th>Nim</th> 
								<th>Nama Mahasiswa</th>
								<th>Operasi</th>
							</tr> 
						</thead> 
						<tbody id="tabel-pemerataan-mahasiswa-registrasi" style="overflow-y : auto; max-height: 250px;">  
							<tr > 
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr> 
						</tbody> 
					</table>
				</div> 
				<div class="dataTables_paginate paging_two_button" id="table-mahasiswa-next-prev">
					<a class="paginate_disabled_previous" tabindex="0" role="button" id="DataTables_Table_0_previous" aria-controls="DataTables_Table_0">Previous</a>
					<a class="paginate_enabled_next" tabindex="0" role="button" id="DataTables_Table_0_next" aria-controls="DataTables_Table_0">Next</a>
				</div> 
			</div> 
		</div>