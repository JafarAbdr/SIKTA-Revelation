<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>

<div class="block">
	
	<div class="header"> 
		<h2>Acara pada ruang Sidang TA 1 dan TA 2</h2> 
	</div> 
	<div class="content" style="">
		<div class="form-row">
			<div class="block"> 
				<ul class="nav nav-tabs"> 
					<li class="active">
						<a href="#tab5" data-toggle="tab" id="lingk-TA1"><span title="Lingkungan Informatika" class="icon-calendar pointer"> Ruang Sidang 1</span></a>
					</li> 
					<li class=""><a href="#tab6" data-toggle="tab" id="lingk-TA2"><span title="Lingkungan Matematika" class="pointer icon-calendar"> Ruang Sidang 2</span></a></li> 
					<li class=""><a href="#tab7" data-toggle="tab" id="lingk-TAM"><span title="Lingkungan Matematika" class="pointer icon-calendar"> Ruang Sidang Matematika</span></a></li> 
					<li class=""><a href="#tab8" data-toggle="tab" id="lingk-PUS"><span title="Lingkungan Matematika" class="pointer icon-calendar"> Ruang Puspital</span></a></li> 
				</ul> 
				<div class="content content-transparent tab-content"> 
					<div class="tab-pane active" id="tab5"> 
						<div class="form-row">
							<div class="block"> 
								<div class="header"> 
									<h2>Ruang TA 1 ( <span style='color : blue;'><a id="REF-TA1" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span> )</h2> 
								</div> 
								<div class="content" style="">
									<div id='calendar-ta-1'>
									<!--Belong calender TA 1-->
									</div>
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
									<h2>Ruang TA 2 ( <span style='color : blue;'><a id="REF-TA2" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span> )</h2> 
								</div> 
								<div class="content" style="">
									<div id='calendar-ta-2'>
									<!--Belong calender TA 1-->
									</div>
								</div> 
								<div class="footer" style="display: none;">
								</div> 
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab7"> 
						<div class="form-row">
							<div class="block"> 
								<div class="header"> 
									<h2>Ruang Sidang Matematika ( <span style='color : blue;'><a id="REF-TAM" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span> )</h2> 
								</div> 
								<div class="content" style="">
									<div id='calendar-ta-m'>
									<!--Belong calender TA 1-->
									</div>
								</div> 
								<div class="footer" style="display: none;">
								</div> 
							</div>
						</div>
					</div> 
					<div class="tab-pane" id="tab8"> 
						<div class="form-row">
							<div class="block"> 
								<div class="header"> 
									<h2>Ruang Puspital ( <span style='color : blue;'><a id="REF-PUS" style="cursor:pointer;"><i class="icon-refresh" title="refresh table"></i></a></span> )</h2> 
								</div> 
								<div class="content" style="">
									<div id='calendar-pu-s'>
									<!--Belong calender TA 1-->
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
