<?php
	if(!defined('BASEPATH'))
		exit("Tidak memiliki hak akses");
	?>
<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active">
			<a href="#tab5" data-toggle="tab"><span class="icon-calendar-empty"></span></a>
		</li> 
		<li class=""><a href="#tab6" data-toggle="tab"><span class="icon-calendar"></span></a></li> 
		<li class=""><a href="#tab7" data-toggle="tab"><span class="icon-calendar"></span></a></li> 
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Tahun Ajaran <?php 
						echo $year."-".($year+1)." Semester ".$semester;
					?></h2>
				</div> 
				<div class="content">
					<div style="overflow-x : auto; margin-top : 10px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>Tahun</th>
									<th>Semester</th>
									<th>Mulai</th> 
									<th>Berakhir</th>
									<th>Status</th>
									<th>Operasi</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-acara-default" style="overflow-y : auto; max-height: 250px;">   
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
					<h2>Tahun Ajaran <?php 
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
						<div class="col-md-8">
							<button class="btn grey-back" id="add-new-event" style="position: absolute; right : 0;"><span class="icon-plus"></span></button>
						</div>
						<div class="col-md-4">
						<input type="text" id="search-semester" pattern="[a-zA-Z0-9 @.]{0,50}" placeholder="judul acara ..."/>
						</div>
							
						
					</div> 
					<div style="overflow-x : auto; margin-top : 60px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>Tanggal terbit</th>
									<th>Judul</th> 
									<th>Isi</th>
									<th>Status</th>
									<th>Operasi</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-acara-lain" style="overflow-y : auto; height: 200px;">   
								<tr>
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
		<div class="tab-pane"  id="tab7"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>Tahun Ajaran <?php 
						echo $year."-".($year+1)." Semester ".$semester;
					?></h2>
				</div> 
				<div class="content">
					<div>
						<div class="col-md-12">
						<button class="btn grey-back" id="add-new-file-data" style="position: absolute; right : 0;"><span class="icon-plus"></span></button>
						</div>
							<br>
						<div class='hidden'>
							<form  id="newFile-session" method='POST' target="frame-upload-newFile" enctype="multipart/form-data" action="Controlfileupload/addNewRecord.jsp">
								<input type='file' name='file-data-name' id="file-data-id">
								<input type='text' name='file-data-keterangan-name' id='file-data-keterangan-id'>
							</form>
							<iframe id="frame-upload-newFile" name="frame-upload-newFile" style="display: none;"></iframe>
						</div>
						
					</div> 
					<div style="overflow-x : auto; margin-top : 10px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>Judul</th>
									<th>Detail</th>
									<th>Operasi</th> 
								</tr> 
							</thead> 
							<tbody id="tabel-file-default" style="overflow-y : auto; height: 200px;">   
								<tr>
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