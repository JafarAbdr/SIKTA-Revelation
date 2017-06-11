<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
		<form id=validate method=POST action="javascript:alert('Form #validate submited');"> 
			<div class=block> 
				<div class=header> 
					<h2>Pengaturan</h2> 
					<div class="side pull-right"> 
						<button class="btn btn-default btn-clean"  type=button>Clear form</button> 
					</div> 
				</div> 
				<div class="content controls"> 
					<div class=form-row> 
						<div class=col-md-3>Nama :
						</div> 
						<div class=col-md-9> 
							<input type=text class="form-control"/> 
							<span class=help-block>wajib diisi, a-z A-Z (spasi)</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Nim :
						</div> 
						<div class=col-md-9> 
							<input type=text class="form-control"/> 
							<span class=help-block>wajib diisi, J2F000000 &lt; <b>2009</b> &lt; 00000000000000 (spasi)</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Password :
						</div> 
						<div class=col-md-9> 
							<input type=text class="form-control"/> 
							<span class=help-block>wajib diisi, J2F000000 &lt; <b>2009</b> &lt; 00000000000000 (spasi)</span> 
						</div> 
					</div> 
					<div class="form-row"> 
						<div class="col-md-3">Bidang Minat:
						</div> 
						<div class="col-md-9"> 
							<select name="s_example" class="form-control" id="form-validation-field-0"> 
								<option value=""></option> 
								<option value="1">Rekayasa Perangkat Lunak</option> 	
								<option value="2">Sistem Informasi</option>  	
								<option value="3">Sistem Cerdas</option>  	
								<option value="4">Komputasi</option> 
							</select> 
							<span class="help-block">wajib dipilih salah satu</span> 
						</div> 
					</div>	
					<div class=form-row> 
						<div class=col-md-3>E-mail :
						</div> 
						<div class=col-md-9> 
							<input type="email" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = jafarabdurrahman50@live.com</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Nama Orang Tua :
						</div> 
						<div class=col-md-9> 
							<input type=text pattern="[a-zA-Z]{1}[a-zA-Z ]{48}[a-zA-Z]{1}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = Abdurrahman Albasyir</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>No Hp Orang Tua :
						</div> 
						<div class=col-md-9> 
							<input type=text pattern="[0-1]{9,13}" class="form-control"/> 
							<span class=help-block>wajib diisi, Contoh = 087829315699</span> 
						</div> 
					</div> 
					<div class=form-row> 
						<div class=col-md-3>Uploa Foto :
						</div> 
						<div class=col-md-2>
							<img alt="preview" src="<?php echo $fotoprofil;?>" style="max-width : 100%">
						</div> 
						<div class="col-md-7 center"> 
							<input type=file class="form-control hidden"/> 
							<button class="btn btn-default" type=button >Hide prompts</button>
							<span class=help-block>wajib di unggah, format = *.png/*.jpg</span> 
						</div> 
					</div> 		
				</div>
				<div class=footer> 
					<div class="side pull-right"> 
						<div class="btn-group"> 
							<button class="btn btn-default" type=button onClick="$('#validate').validationEngine('hide')">Batalkan</button> 
							<button class="btn btn-success" type=submit>Submit</button> 
						</div> 
					</div> 
				</div> 
			</div>
		</form>