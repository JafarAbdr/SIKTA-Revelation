<?php
if(!defined('BASEPATH'))
	exit("Sorry you dont have permission to load this page");
?>	

<div class="block"> 
	<ul class="nav nav-tabs"> 
		<li class="active tip" title="tabel seminar ta 1">
			<a href="#tab5" data-toggle="tab" ><span class="icon-table"></span></a>
		</li>
		<li class="tip" title="tabel seminar ta 2">
			<a href="#tab6" data-toggle="tab" id="seminar-ta2-pemerataan" ><span class="icon-table"></span></a>
		</li>		
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 	 
			<div class="block"> 
				<div class="header"> 
					<h2>Seminar TA1</h2>
				</div> 
				<div class="content">
				
					<div>
						<label style="margin : 10px; float: right;">
							<span style='font-size : 21px; color : blue;'><a onclick='
							$("#search-name-seminar").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-name-seminar").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
						</label>
						<label style="margin : 10px; float: right;">
							<input type="text" id="search-name-seminar" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
						</label>
						<label style="margin : 10px; float: right;">
						<select id="tahun-seminar">
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
						<select id="semester-seminar">
							<option value="1" <?php if($smts) echo "selected"?>>Semester 1</option>
							<option value="2" <?php if($smtd) echo "selected"?>>Semester 2</option>
						</select>
					</label>
						<label style="margin : 10px; float: right;">
							<span style='font-size : 21px; color : blue;'><a onclick='openXLFormSem(base_url+"Controlresultseminar/getDataWithExcelSem")'><i class="icon-file-alt" title="download sebagai excel"></i></a></span>
						</label>
					</div> 
					<div style="overflow-x : auto; margin-top : 120px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>No</th>
									<th>Nim</th> 
									<th>Nama Mahasiswa</th>
									<th>Bidang Minat</th>    
									<th>Dosen Pembimbing</th>
									<th>Status kelengkapan</th>
									<th>Aksi</th>
									<th>Nilai</th>
								</tr> 
							</thead> 
							<tbody id="tabel-pemerataan-seminar-ta1" style="overflow-y : auto; max-height: 250px;">  
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
				</div> 
			</div>
		</div>
		<div class="tab-pane" id="tab6">
			<div class="block"> 
				<ul class="nav nav-tabs nav-justified"> 
					<li class="active" onclick="reloadChartSeminarAll(1);"><a href="#tab11" data-toggle="tab">Total Bimbingan</a></li> 
					<li class="" onclick="reloadChartSeminarAll(2);"><a href="#tab12" data-toggle="tab">Total penguji 1</a></li> 
					<li class="" onclick="reloadChartSeminarAll(3);"><a href="#tab13" data-toggle="tab">Total penguji 2</a></li>
					<li class="" onclick="reloadChartSeminarAll(4);"><a href="#tab14" data-toggle="tab">Total penguji 3</a></li> 
				</ul> 
				<div class="content content-transparent tab-content">
					<div class="tab-pane active" id="tab11"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-1" style="min-width: 1000px;">
									<canvas id="canvas1" ></canvas>
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab12"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-2" style="min-width: 1000px;">
									<canvas id="canvas2" ></canvas>
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab13"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-3" style="min-width: 1000px;">
									<canvas id="canvas3"></canvas>
								</div>
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab14"> 
						<div class="block">
							<div style="width:100%; overflow-x : auto; background-color : rgba(0,0,0,0.1);">
								<div id="controller-diagram-4" style="min-width: 1000px;">
									<canvas id="canvas4"></canvas>
								</div>
							</div>
						</div>
					</div> 
				</div> 
			</div>
			<div class="block"> 
				<div class="header"> 
					<h2>Seminar TA 2 pemerataan</h2>
				</div> 
				<div class="content">
					
				
					<div>
						<label style="margin : 10px; float: right;">
							<span style='font-size : 21px; color : blue;'><a onclick='
							$("#search-name-sidang").val("");
							tempObject = {
								keyCode:13
							};
							$("#search-name-sidang").trigger({type:"keyup", keyCode:13})'><i class="icon-refresh" title="refresh table"></i></a></span>
						</label>
						<label style="margin : 10px; float: right;">
							<input type="text" id="search-name-sidang" pattern="[a-zA-Z @.]{0,50}" placeholder="Nama ..."/>
						</label>
						<label style="margin : 10px; float: right;">
						<select id="tahun-sidang">
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
						<select id="semester-sidang">
							<option value="1" <?php if($smts) echo "selected"?>>Semester 1</option>
							<option value="2" <?php if($smtd) echo "selected"?>>Semester 2</option>
						</select>
					</label>
						<label style="margin : 10px; float: right;">
							<span style='font-size : 21px; color : blue;'><a onclick='openXLFormSid(base_url+"Controlresultseminar/getDataWithExcelSid")'><i class="icon-file-alt" title="download sebagai excel"></i></a></span>
						</label>
					</div> 
					<div style="overflow-x : auto; margin-top : 120px;">
						<table class="table table-striped table-hover " style="min-width : 1300px;"> 
							<thead> 
								<tr> 
									<th>No</th>
									<th>Nim</th> 
									<th>Nama Mahasiswa</th>
									<th>Penguji 1</th>
									<th>Penguji 2</th>
									<th>Penguji 3</th>
									<th>Pembimbing</th>
									<th>Aksi Penguji</th>
									<th>Status kelengkapan</th>
									<th>Aksi</th>
									<th>Nilai</th>
								</tr> 
							</thead> 
							<tbody id="tabel-pemerataan-seminar-ta2" style="overflow-y : auto; max-height: 250px;">  
								<tr > 
									<td>-</td>
									<td>-</td>
									<td>-</td>
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
		<div class="tab-pane" id="tab6"> 
		 koko
		</div> 
		<div class="tab-pane" id="tab7"> 
			kiki
		</div> 
	</div> 
</div>