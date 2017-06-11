<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="block"> 
	<div class="header"> 
		<h2>Seminar Tugas Akir 1</h2> 
	</div> 
	<div class="content controls"> 
		<ul id="wizard-titles" class="stepy-titles">
			<li id="wizard-title-0" class="" style="cursor: default;"><div>Langkah 1</div><span>Upload</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 2</div><span>Informasi</span></li>
			<li id="wizard-title-1" class="" style="cursor: default;"><div>Langkah 3</div><span>Upload</span></li>
			<li id="wizard-title-1" class="current-step" style="cursor: default;"><div>Langkah 4</div><span>Informasi</span></li>
		</ul>
		<div action="" method="POST" id="wizard"> 
			<fieldset title="Step 1" class="step" id="wizard-step-0" style="display: block;"> 
				<legend>Fields</legend> 
				<div class="panel panel-success"> 
					<div class="panel-heading"> 
						<h3 class="panel-title">Selamat kepada anda</h3> 
					</div> 
					<div class="panel-body"> 
						<p>Terima kasih sudah melakukan upload hasil proses pelaksanaan seminar.
						nilai Akan muncul jika sudah dimasukan oleh Koordinator TA</p>
						<p>Nilai akhir : <span style="font-weight : bolder; font-size : 18pt;"><?php echo $nilai;?></span></p>
					</div> 
					<div class="panel-footer">Terima kasih
					
					</div> 	
				</div>
			</fieldset>
		</div> 
	</div> 
</div>