<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');

?>

<div class="block" >
	<div class='accordion accordion-transparent'> 
		<h3>Selamat <?php
		$time = intval(date("H"));
		if($time > 0 && $time < 8){
			echo "Pagi";
		}else if($time >= 8 && $time < 14){
			echo "Siang";
		}else  if($time >= 14 && $time < 19){
			echo "Sore";
		}else{
			echo "Malam";
		}
		?></h3> 
		<div> 
			<p>Selamat datang di Sistem Informasi Akademik Tugas Akhir V 5.0 Beta Release Core JaservTech base CodeIgniter.<br>
				Sistem menyediakan proses registrasi baru maupun registrasi lama Tugas Akhir, serta proses pendaftaran seminar.<br>
				untuk selengkapnya, silahkan pilih menu bantuan untuk video tutorial penggunaan sistem ini.
				<br>
				<br>
				Terima kasih ^_^
			</p> 
		</div> 
		<h3>Info Cepat Registrasi</h3> 
		<div> 
			<div id="info-cepat-registrasi">
				<div class="block block-drop-shadow" id="content-info-fast"> 
					<div class="header"> 
						<h2>Ubah data registrasi (Berlaku saat belum disetujui)</h2>
					</div> 
					<div class="content controls"> 					
						<div class="form-row">
							<div class="col-md-3">Nama : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-nama" disabled>
								<span class="help-block">Tidak dapat diganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Dosen pembimbing : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-dosbing" disabled>
								<span class="help-block">Tidak dapat diganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Status : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-status" disabled>
								<span class="help-block">Tidak dapat diganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Kategori : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-kategori" disabled>
								<span class="help-block">Tidak dapat diganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Judul TA : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' onchange='ubahDataOnetoSix(1,this.value);' id="preview-judulta">
								<span class="help-block">File auto save, hati-hati sebelum mengganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Metode : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-metode" onchange='ubahDataOnetoSix(2,this.value);'>
								<span class="help-block">File auto save, hati-hati sebelum mengganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Lokasi : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="preview-lokasi" onchange='ubahDataOnetoSix(3,this.value);'>
								<span class="help-block">File auto save, hati-hati sebelum mengganti</span>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Referensi 1 : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="referensis" onchange='ubahDataOnetoSix(4,this.value);'>
								<span class="help-block">File auto save, hati-hati sebelum mengganti</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Referensi 2 : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="referensid" onchange='ubahDataOnetoSix(5,this.value);'>
								<span class="help-block">File auto save, hati-hati sebelum mengganti</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Referensi 3 : </div>
							<div class="col-md-9">
								<input type='text' class='form-control' id="referensit" onchange='ubahDataOnetoSix(6,this.value);'>
								<span class="help-block">File auto save, hati-hati sebelum mengganti</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">KRS : </div>
							<div class="col-md-9">
								<span  style='font-size : 30px; color : green; cursor : pointer; margin-right : 20px;'><i onclick="lihatKRS()" title='lihat KRS' class="icon-eye-open"></i></span>
								<span  style='font-size : 30px; color : green; cursor : pointer;'><i onclick="gantiKRS();" title='ganti KRS' class="icon-upload-alt"></i></span>
								<span class="help-block">File auto upload, hati-hati sebelum mengganti</span> 
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3">Transkrip : </div>
							<div class="col-md-9">
								<span  style='font-size : 30px; color : green; cursor : pointer; margin-right : 20px;'><i onclick="lihatTranskrip()" title='lihat Transkrip' class="icon-eye-open"></i></span>
								<span  style='font-size : 30px; color : green; cursor : pointer;' onclick="updateTranskrip()"><i title='ganti Transkrip' class="icon-upload-alt"></i></span>
								<span class="help-block">File auto upload, hati-hati sebelum mengganti</span> 
							</div>
						</div>
						<form id="KRS-session" class="hidden" method='POST' target="frame-upload-pengaturan" enctype="multipart/form-data" action="<?php echo base_url()?>Classroom/setReferences.jsp">
							<input type="file" onchange='uploadKRS(7,"upgrade-krs");' accept=".pdf" name="upgrade-krs" id="support-krs">
							<input type="text" name="kode" value="7">
							<input type="text" name="referensi" value="upgrade-krs">
						</form>						
					</div>
				</div>
			</div>
		</div> 
		<h3>Bantuan Textual</h3> 
		<div> 
			<div class="panel">
				<div class="panel-heading">
					<h5 class="center">Beranda :</h5>
				</div>
				<div class="panel-body">
					<p>Pada bagian ini, Menampilkan pesan Sapaan terhadap mahasiswa yang masuk kedalam sistem. Terdiri dari</p>
					<ol>
						<li>Selamat (Pagi|Siang|Sore|Malam) - Sapaan Formal -</li>
						<li>Info Cepat Registrasi - Menampilkan hasil registrasi pribadi yang telah diilakukan pada semester terkini -</li>
						<li>Info Cepat Seminar - Menampilkan hasil registrasi seminar yang telah diakukan pada semester terkini</li>
						<li>Bantuan Textual - Menu bantuan tidak dalam bentuk film pendek, melainkan berupa text -</li>
					</ol>
				</div>
			</div>
			<div class="panel">
				<div class="panel-heading">
					<h5 class="center">Registrasi TA :</h5>
				</div>
				<div class="panel-body">
					<div class="panel">
						<div class="panel-heading">
							<h5 class="center">Baru :</h5>
						</div>
						<div class="panel-body">
							<p>Akan menampilkan form registrasi baru dengan syarat :</p>
							<ol>
								<li>Belum pernah melakukan registrasi pada semester terkini</li>
								<li>Dilakukan pada jarak <i>interval</i> tanggal yang sudah ditetapkan koordinator pada daftar acara</li>
							</ol>
							<p>Untuk pengecualian : Hubungi Mbak nisa</p>
							<ol>
								<li>Melakukan her registrasi</li>
								<li>Her registrasi hanya bisa dilakukan selama waktu pendaftaran registrasi masih terbuka</li>
								<li>Dianggap gugur jika tidak melakukan registrasi</li>
								<li>Dianggap data yang dimasukan valid jika tidak segera melakukan her-registrasi</li>
							</ol>
						</div>
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h5 class="center">Lama :</h5>
						</div>
						<div class="panel-body">
							<p>Akan menampilkan form registrasi lama dengan syarat :</p>
							<ol>
								<li>Sudah pernah melakukan registrasi pada semester sebelumnya</li>
								<li>Dilakukan pada jarak <i>interval</i> tanggal yang sudah ditetapkan koordinator pada daftar acara</li>
							</ol>
							<p>Untuk pengecualian : Hubungi Mbak nisa</p>
							<ol>
								<li>Melakukan her registrasi</li>
								<li>Her registrasi hanya bisa dilakukan selama waktu pendaftaran registrasi masih terbuka</li>
								<li>Dianggap gugur jika tidak melakukan registrasi</li>
								<li>Dianggap data yang dimasukan valid jika tidak segera melakukan her-registrasi</li>
								<li><b>Catatan khusus untuk mahasiswa yang melakukan registrasi secara manual sebelum sistem terbentuk, diharapkan menghubungi segera mbak nisa untuk melakukan perizinan registrasi lama</b></li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="panel">
				<div class="panel-heading">
					<h5 class="center">Seminar TA :</h5>
				</div>
				<div class="panel-body">
					<div class="panel">
						<div class="panel-heading">
							<h5 class="center">Pertama :</h5>
						</div>
						<div class="panel-body">
							<p>Menampilkan form seminar TA 1, dengan syarat : </p>
							<ol>
								<li>Belum pernah melakukan Seminar TA 1 Sebelumnya</li>
							</ol>
							<p>Jika belum bisa menampilkan halaman form : hubungi mbak nisa untuk membukakan feature Registrasi Seminar TA 1</p>
						</div>
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h5 class="center">Kedua :</h5>
						</div>
						<div class="panel-body">
							<p>Menampilkan form seminar TA 2(Sidang), dengan syarat : </p>
							<ol>
								<li>Sudah pernah melakukan Seminar TA 1 Sebelumnya</li>
							</ol>
							<p>Jika belum bisa menampilkan halaman form : hubungi mbak nisa untuk membukakan feature Registrasi Seminar TA 1</p>
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div> 
</div>