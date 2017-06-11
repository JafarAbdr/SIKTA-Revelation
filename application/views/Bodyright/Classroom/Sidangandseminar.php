<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>

<div class="block">
	<div class=header> 
		<h2>Registrasi Seminar TA Satu</h2> 
	</div> 
	<div class="content controls">
		<div class=form-row>
			<div class="col-md-3">Nama </div>
			<div class="col-md-9"> </div>
		</div> 
		
		
		<?php 
		if($pengantar){
			echo '
			<div class=form-row>
				<div class=col-md-3>Surat Pegantar </div>
				<div class=col-md-3>
					<button  id=exec-s-pengantard class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
				</div>
				<div class=col-md-4>
					<a style="color : #666;" id="info-s-pengantard"> : Data kosong</a>
				</div>
				<div class="col-md-2" style="font-size : 13px;">
					<div class="col-md-6">
						<span class="icon-ok pointer" id="true-s-pengantard" title="data di terima" style="color : red"></span>
					</div>
					<div class="col-md-6">
						<span class="icon-remove pointer" id="false-s-pengantard" title="data di tolak" style="color : green"></span>
					</div>
				</div>
			</div> 
			';
		}else{
			echo '
			<div class=form-row>
				<div class=col-md-3>Surat Pegantar </div>
				<div class=col-md-3>
					<button  id=exec-s-pengantard class="btn btn-primary btn-block" disabled="true" style="background-color : green;"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
				</div>
				<div class=col-md-4>
					<a style="color : #666;" id="info-s-pengantard"> : By Dosen</a>
				</div>
				<div class="col-md-2" style="font-size : 13px;">
					<div class="col-md-6">
						<span class="icon-ok pointer" id="true-s-pengantard" title="data di terima" style="color : green"></span>
					</div>
					<div class="col-md-6">
						<span class="icon-remove pointer" id="false-s-pengantard" title="data di tolak" style="color : red"></span>
					</div>
				</div>
			</div> 
			';
		}
		?>
		<div class=form-row>
			<div class="col-md-3">Scan Kartu Bimbingan TA </div>
			<div class="col-md-3">
				<button  id="exec-s-k-bimbingand"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.png)</button>
			</div>
			<div class="col-md-4">
				<a style="color : #666;" id="info-s-k-bimbingand"> : Data kosong</a>
			</div>
			<div class="col-md-2" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" id="true-s-k-bimbingand" title="data di terima" style="color : red"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" id="false-s-k-bimbingand" title="data di tolak" style="color : green"></span>
				</div>
			</div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Scan Kartu Peserta TA </div>
			<div class="col-md-3">
				<button  id="exec-s-k-pesertad"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.png)</button>
			</div>
			<div class="col-md-4">
				<a style="color : #666;" id="info-s-k-pesertad"> : Data kosong</a>
			</div>
			<div class="col-md-2" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" id="true-s-k-pesertad" title="data di terima" style="color : red"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" id="false-s-k-pesertad" title="data di tolak" style="color : green"></span>
				</div>
			</div>
		</div> 
		<div class=form-row>
			<div class="col-md-3">Transkrip </div>
			<div class="col-md-3">
				<button  id="exec-s-transkripd"  class="btn btn-primary btn-block"><span class="icon-upload-alt"></span> Unggah(.pdf)</button>
			</div>
			<div class="col-md-4">
				<a style="color : #666;" id="info-s-transkripd"> : Data kosong</a>
			</div>
			<div class="col-md-2" style="font-size : 13px;">
				<div class="col-md-6">
					<span class="icon-ok pointer" id="true-s-transkripd" title="data di terima" style="color : red"></span>
				</div>
				<div class="col-md-6">
					<span class="icon-remove pointer" id="false-s-transkripd" title="data di tolak" style="color : green"></span>
				</div>
			</div>
		</div> 
		<div class="form-row">
			<div class="block"> 
				<div class="header"> 
					<h2>Booking Ruangan</h2> 
				</div> 
				<div class="content" style="">
					<div class="form-row">
						<div class="block"> 
							<ul class="nav nav-tabs"> 
								<li class="active grey-back">
									<a href="#tab5" data-toggle="tab" id="lingk-inf"><span title="Lingkungan Informatika" class="icon-long-arrow-right pointer"></span></a>
								</li> 
								<li class="grey-back"><a href="#tab6" data-toggle="tab" id="lingk-math"><span title="Lingkungan Matematika" class="pointer icon-random"></span></a></li> 
							</ul> 
							<div class="content content-transparent tab-content"> 
								<div class="tab-pane active" id="tab5"> 
									
									<div class="form-row">
										<div class="block"> 
											<div class="header"> 
												<h2>Ruang TA 1</h2> 
											</div> 
											<div class="content" style="">
												<div id='calendar-ta-1'></div>
											</div> 
											<div class="footer" style="display: none;">
											</div> 
										</div>
									</div>
									<div class="form-row">
										<div class="block"> 
											<div class="header"> 
												<h2>Ruang TA 2</h2> 
											</div> 
											<div class="content" style="">
												<div id='calendar-ta-2'></div>
											</div> 
											<div class="footer" style="display: none;">
											</div> 
										</div>
									</div>
								</div> 
								<div class="tab-pane" id="tab6"> 
									<div class="form-row">
										<div class="block"> 
											<div class="header"> 
												<h2>Ruang  TA Matematika</h2> 
											</div> 
											<div class="content" style="">
												<div id="ruang matematika">
													<input type="text" id="ruang-ta-math" format="YYYY-MM-DD H:m">
												</div>
											</div> 
											<div class="footer" style="display: none;">
											</div> 
										</div>
									</div>
								</div> 
							</div> 
						</div>
					</div>
				</div> 
				<div class="footer" style="display: none;">
				</div> 
			</div>
		</div>
		<div class="form-row" style="text-align : center; display : inline-block;">
			<div style="max-width : 320px; margin-left : auto; margin-right : auto;">
				<div style="width: 150px; float: left; margin-right : 10px;">
					<button class="btn btn-block" id="masukan-data-seminar-ta2">Masukan</button>
				</div>
				
				<div style="width: 150px; float : left; margin-left : 10px;">
					<button class="btn btn-block" id="reset-data-seminar-ta2">Bersihkan</button>
				</div>
			</div>			
		</div>
	</div>
	<form class="hidden"  id=seminar2form method=POST target="frame-layout" enctype="multipart/form-data" action="Classseminartad/setSeminarTA2.aspx">
		<input class="hidden" type="file" id="s-pengantard" name="s-pengantard" accept=".pdf">
		<input class="hidden" type="file" id="s-k-bimbingand" name="s-k-bimbingand" accept=".png">
		<input class="hidden" type="file" id="s-k-pesertad" name="s-k-pesertad" accept=".png">
		<input class="hidden" type="file" id="s-transkripd" name="s-transkripd" accept=".pdf">
		<input class="hidden" type="text" id="s_tanggald" name="s_tanggald">
		<input class="hidden" type="text" id="s_ruangd" name="s_ruangd">
	</form>
	<iframe id="frame-layout" name="frame-layout" class="hidden"></iframe>
</div>
