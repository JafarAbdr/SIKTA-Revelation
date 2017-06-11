<?php
if(!defined('BASEPATH'))
	exit("you dont have access to this path");
?>
<div class="block">
	<ul class="nav nav-tabs"> 
		<li class="active">
			<a href="#tab5" data-toggle="tab"><span class="icon-calendar-empty"></span></a>
		</li> 
		<li class=""><a href="#tab7" data-toggle="tab"><span class="icon-calendar"></span></a></li> 
	</ul> 
	<div class="content content-transparent tab-content"> 
		<div class="tab-pane active" id="tab5"> 
			<div id="tabel-list-beranda-acara" class="content"> 
			</div>

		</div> 
		<div class="tab-pane"  id="tab7"> 
		 	<div class="block"> 
				<div class="header"> 
					<h2>File file pendukung</h2><br>
					<p>klik untuk mengunduh</p>
				</div> 
				<div class="content">
					<div style="overflow-x : auto; margin-top : 10px;">
						<table class="table table-striped table-hover "> 
							<thead> 
								<tr> 
									<th>Judul</th>
									<th>Detail</th>
								</tr> 
							</thead> 
							<tbody id="tabel-file-default" style="overflow-y : auto; max-height: 250px;">   
								<tr>
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