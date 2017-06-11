<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>

		<form id=validate target="frame-layout" enctype="multipart/form-data" method="POST" action="Classregistrasilama/getResultRegistrasiLama.jsp"> 
			<div class=block> 
				<div class=header> 
					<h2>Registrasi TA Lama</h2> 
					<div class="side pull-right"> 
						<button id="rest-lama" class="btn btn-default btn-clean"  type=button>bersihkan formulir</button> 
					</div> 
				</div> 
				<div class="content controls"> 
					<div class=form-row> 
						<div class=col-md-3>Nama :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text class="form-control" id="lama-nama" name="lama-nama"/> 
							<span class=help-block>wajib diisi, a-z A-Z (spasi)</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Nim :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text class="form-control" id="lama-nim" name="lama-nim"/> 
							<span class=help-block>wajib diisi, J2F000000 &lt; <b>2009</b> &lt; 00000000000000 (spasi)</span> 
						</div> 
					</div> 
					<div class="form-row"> 
						<div class=col-md-3>No Hp :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text pattern="[0-1]{9,13}" class="form-control" id="lama-nohp" name="lama-nohp"/> 
							<span class=help-block>wajib diisi, Contoh = 087829315699</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>E-mail :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type="email" class="form-control" id="lama-email" name="lama-email"/> 
							<span class=help-block>wajib diisi, Contoh = jafarabdurrahman50@live.com</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Nama Orang Tua :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text pattern="[a-zA-Z]{1}[a-zA-Z ]{48}[a-zA-Z]{1}" id="lama-ortu" name="lama-ortu" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Abdurrahman Albasyir</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>No Hp Orang Tua :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text pattern="[0-1]{9,13}" class="form-control" id="lama-nohportu" name="lama-nohportu"/> 
							<span class=help-block>wajib diisi, Contoh = 087829315699</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Judul TA :
						</div> 
						<div class=col-md-9> 
							<div></div>
							<input type=text pattern="[a-zA-Z]{1}[a-zA-Z ]{48}[a-zA-Z]{1}" id="lama-judulta" name="lama-judulta" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Sistem Pembaca Pikiran Dengan Deteksi Wajah</span> 
						</div> 
					</div> 
					<div class="form-row"> 
						<div class="col-md-3">Dosen pembimbing:
						</div> 
						<div class="col-md-9"> 
							<div></div>
							<select class="form-control" id="lama-dosbing" name="lama-dosbing"> 
								<option value="0"></option> 
								<?php 
								for($i=0;$i<$listdosen['length'];$i++){
									echo "<option value='".$listdosen[$i]['id']."'>".$listdosen[$i]['nama']."</option>";
								}
								?>
							</select> 
							<span class="help-block">wajib dipilih salah satu</span> 
						</div> 
					</div>	
					<div class=form-row> 
						<div class=col-md-3>Upload KRS :
						</div> 
						<div class=col-md-9>
							<div></div>
							<input type=file class="form-control hidden" id="lama-krs" name="lama-krs"/> 
							<button class="btn btn-default" id="krs-lama-exe" type=button >Unggah Krs(.pdf)</button>
							<span class=help-block>wajib di unggah, Contoh = Jafar-Krs.pdf</span> 
						</div> 
					</div> 		
				</div> 
				<div class=footer> 
					<div class="side pull-right"> 
						<div class=btn-group>  
							<button class="btn btn-success"  type="button" id="lama-submit-exe">Selesai</button> 
						</div> 
					</div> 
				</div> 
				<iframe class="hidden" id="frame-layout" name="frame-layout"></iframe>
			</div> 
		</form> 
		
