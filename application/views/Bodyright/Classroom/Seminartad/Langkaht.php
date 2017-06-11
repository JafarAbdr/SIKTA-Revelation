<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="block"> 
	<div class="header"> 
		<h2>Sidang Tugas Akir 2</h2> 
	</div> 
	<div class="content controls"> 
		<ul id="wizard-titles" class="stepy-titles">
			<li id="wizard-title-0" class="" style="cursor: default;"><div>Langkah 1</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 2</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="current-step" style="cursor: default;"><div>Langkah 3</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 4</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 5</div><span>Get File Support</span></li>
		</ul>
		<div action="" method="POST" id="wizard">
			<fieldset title="Step 1" class="step" id="wizard-step-0" style="display: block;"> 
				<legend>Fields</legend> 
				<div class=form-row>
					<div class="col-md-3">File pendukung </div>
					<div class="col-md-9">
					<div tittle='download fuj 20' onclick="showFujPDFTAD('20');" style="cursor : pointer; width : 100px; height : 45px; text-align : center; float : left; color : white; background-color : black; border-radius : 45px;">
						<i class="icon-file-alt" style="font-size : 16pt; line-height : 45px;"></i> FUJ20
					</div>
					<div tittle='download fuj 25' onclick="showFujPDFTAD('25');" style="cursor : pointer; width : 100px; height : 45px; text-align : center; float : left; color : white; background-color : black; border-radius : 45px;">
						<i class="icon-file-alt" style="font-size : 16pt; line-height : 45px;"></i> FUJ25
					</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">FUJ 20 </div>
					<div class="col-md-3">
						<button  id="exec-s-k-fuj20"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-fuj20"> : Data kosong</a>
					</div>
					<div class="col-md-2" style="font-size : 13px;">
						<div class="col-md-6">
							<span class="icon-ok pointer" id="true-s-k-fuj20" title="data di terima" style="color : red"></span>
						</div>
						<div class="col-md-6">
							<span class="icon-remove pointer" id="false-s-k-fuj20" title="data di tolak" style="color : green"></span>
						</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">FUJ 25 </div>
					<div class="col-md-3">
						<button  id="exec-s-k-fuj25"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-fuj25"> : Data kosong</a>
					</div>
					<div class="col-md-2" style="font-size : 13px;">
						<div class="col-md-6">
							<span class="icon-ok pointer" id="true-s-k-fuj25" title="data di terima" style="color : red"></span>
						</div>
						<div class="col-md-6">
							<span class="icon-remove pointer" id="false-s-k-fuj25" title="data di tolak" style="color : green"></span>
						</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Transkrip </div>
					<div class="col-md-3">
						<button  id="exec-s-k-transkrip"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-transkrip"> : Data kosong</a>
					</div>
					<div class="col-md-2" style="font-size : 13px;">
						<div class="col-md-6">
							<span class="icon-ok pointer" id="true-s-k-transkrip" title="data di terima" style="color : red"></span>
						</div>
						<div class="col-md-6">
							<span class="icon-remove pointer" id="false-s-k-transkrip" title="data di tolak" style="color : green"></span>
						</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Toefl </div>
					<div class="col-md-3">
						<button  id="exec-s-k-toefl"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-toefl"> : Data kosong</a>
					</div>
					<div class="col-md-2" style="font-size : 13px;">
						<div class="col-md-6">
							<span class="icon-ok pointer" id="true-s-k-toefl" title="data di terima" style="color : red"></span>
						</div>
						<div class="col-md-6">
							<span class="icon-remove pointer" id="false-s-k-toefl" title="data di tolak" style="color : green"></span>
						</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Krs </div>
					<div class="col-md-3">
						<button  id="exec-s-k-krs"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-krs"> : Data kosong</a>
					</div>
					<div class="col-md-2" style="font-size : 13px;">
						<div class="col-md-6">
							<span class="icon-ok pointer" id="true-s-k-krs" title="data di terima" style="color : red"></span>
						</div>
						<div class="col-md-6">
							<span class="icon-remove pointer" id="false-s-k-krs" title="data di tolak" style="color : green"></span>
						</div>
					</div>
				</div> 
				<div class=form-row>
					<div class="col-md-3">Kartu Bimbingan </div>
					<div class="col-md-3">
						<button  id="exec-s-k-bimbingan"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
					</div>
					<div class="col-md-4">
						<a style="color : #666;" id="info-s-k-bimbingan"> : Data kosong</a>
					</div>
					<div class="col-md-2" style="font-size : 13px;">
						<div class="col-md-6">
							<span class="icon-ok pointer" id="true-s-k-bimbingan" title="data di terima" style="color : red"></span>
						</div>
						<div class="col-md-6">
							<span class="icon-remove pointer" id="false-s-k-bimbingan" title="data di tolak" style="color : green"></span>
						</div>
					</div>
				</div> 
				<div class="form-row">				
					<div class='accordion accordion-transparent'> 
						<h3 onclick="ruangActiveNowF(1);" id="show-calendar-1">Booking Ruang Seminar TA 1</h3> 
						<div> 
							<div id='calendar-1'></div> 
						</div> 
						<h3 onclick="ruangActiveNowF(2);"  id="show-calendar-2">Booking Ruang Sidang TA 2</h3> 
						<div> 
							<div id='calendar-2'></div> 
						</div> 
						<h3 onclick="ruangActiveNowF(3);"  id="show-calendar-3">Booking Ruang Sidang Matematika</h3> 
						<div> 
							<div id='calendar-3'></div> 
						</div> 
						<h3 onclick="ruangActiveNowF(4);"  id="show-calendar-4">Booking Ruang Puspital</h3> 
						<div> 
							<div id='calendar-4'></div> 
						</div> 
					</div> 
				</div>
				<div class="form-row" style="text-align : center; display : inline-block;">
					<div style="max-width : 320px; margin-left : auto; margin-right : auto;">
						<div style="width: 150px; float: left; margin-right : 10px;">
							<button class="btn btn-primary btn-block" id="input-data-seminarta1">Masukan</button>
						</div>
						
						<div style="width: 150px; float : left; margin-left : 10px;">
							<button class="btn btn-primary btn-block" id="resetForm">Bersihkan</button>
						</div>
					</div>			
				</div>
				<div class="form-row">
					<form class="hidden" id=seminar1form method=POST target="frame-layout" enctype="multipart/form-data" action="Classseminartad/setSeminarTA2next.jsp">
						<input class="hidden" type="file" id="s-k-fuj25" name="s-k-fuj25" accept=".pdf">
						<input class="hidden" type="file" id="s-k-fuj20" name="s-k-fuj20" accept=".pdf">
						<input class="hidden" type="file" id="s-k-transkrip" name="s-k-transkrip" accept=".pdf">
						<input class="hidden" type="file" id="s-k-toefl" name="s-k-toefl" accept=".pdf">
						<input class="hidden" type="file" id="s-k-krs" name="s-k-krs" accept=".pdf">
						<input class="hidden" type="file" id="s-k-bimbingan"  name="s-k-bimbingan" accept=".pdf">
						<input class="hidden" type="text" id="s-k-ruangan"  name="s-k-ruangan" accept=".pdf">
						<input class="hidden" type="text" id="s-k-tanggal"  name="s-k-tanggal" accept=".pdf">
					</form>
					<iframe id="frame-layout" name="frame-layout" class="hidden"></iframe>
				</div>
			</fieldset>
		</div> 
	</div> 
</div>