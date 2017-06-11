<?php
/*
dependencies:
-LoginFilter
-Dosen
-Koordinator
-Mahasiswa
-Inputjaservfilter
-ControlDetail
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
if(!defined('BASEPATH'))
	exit("Sorry");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Controlresultregistrasi extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->loadLib("Aktor/Koordinator");
		$this->loadLib("Inputjaservfilter");
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->koordinator = new Koordinator($this->inputJaservFilter);
		$this->loadMod("GateControlModel");
		$this->gateControlModel = new GateControlModel();
		$this->loadLib('LoginFilter');
		$this->load->library('Session');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
		if(!$this->loginFilter->isLogin($this->koordinator)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	//optimized - fix
	//get layout registrasi for coordinator
	public function getLayoutRegistrasi(){
		$this->loadLib('ControlTime');
		echo "1";
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		$smt2=true;
		$smt1=false;
		if(intval($srt[4]) == 1){
			$smt1=true;
			$smt2=false;
		}
		$year = intval(substr($srt,0,4));
		$this->load->view("Bodyright/Controlroom/Registrasi.php",array("smts"=>$smt1, "smtd"=>$smt2, "year"=>$year));
	}   
	//optimized - fix
	//get data for chart on registrasi page on coordinator
	public function getJsonTableNow(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		if($semester == null || $tahun == null){
			$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		}else{
			$srt = "".$tahun."".$semester."";
		}
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$controlRegistrasi = new Controlregistrasi($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getAllData(null,1);
		$temp1 = "";
		$temp2 = "";
		$temp3 = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$temp1 .= '"'.$tempObjectDB->getNama().'",';
				$temp3 .= '"'.$tempObjectDB->getNip().'",';
				$tempObjectDBD = $controlRegistrasi->getAllDataByDosen($srt,$tempObjectDB->getIdentified());
				$negatif = 0;
				if($tempObjectDBD){
					while($tempObjectDBD->getNextCursor()){
						if(intval($tempObjectDBD->getTableStack(1)->getDataProses()) == 3)
							$negatif++;
					}
				}
				$temp2 .= ($tempObjectDBD->getCountData()-$negatif).",";
			}
		}
		if($temp1 != ""){
			$temp1 = substr($temp1, 0,strlen($temp1)-1);
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
			$temp3 = substr($temp3, 0,strlen($temp3)-1);
		}
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "],[";
		$json .= $temp3;
		$json .= "]]}";
		echo "1".$json;
	}
	//optimized - fix
	//get table list any mahasiswa that has been registered on this system.
	public function getPemerataanListMahasiswa(){
		//filter tahun
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){ $tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){ echo "0Tahun ajaran tidak valid"; return; }
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){ $semester = null; 
		}else{	
			if(intval($semester) < 1 || intval($semester) > 2){ echo "0Semester tidak di ketahui"; return; }
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $srt = $controlTime->getYearNow();
		}else{ $srt = "".$tahun."".$semester.""; }
		$changeAvaila = true;
		if(intval($srt) != intval($controlTime->getYearNow()))
			$changeAvaila = false;
		//key
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){ echo "0Kata kunci harus berupa bagian nama dari seseorang"; return;
			}else $key = $this->isNullPost('key');
		}
		$page = 1;
		if($this->input->post("page")!==NULL){ $page = intval($this->input->post("page")); if($page < 0) $page = 1; }
		$s=true;
		$string = "<h4>Informasi Acara</h4><div class='well'>Data Tidak ditemukan</div>";
		$n = 1;	$z = 1;
		$koko = 0; $trueCon = false;
		$tempTotal = 0;	$tempListNim = "";
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$tempObjectDB = $controlRegistrasi->getAllData($srt,null,1,null);
		$tempObjectDBT = $controlDosen->getAllData(null,1);
		$dataTemp = "";
		echo 1;
		$i=0;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				
				$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
				if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
					if($key == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($key)))){
						//
						if($n <= 15 && $z == $page){
							$tempssN=0;	$tempTotal = $i+1;
							$dataTemp .= "<tr><td>".($i+1)."</td><td><div style='width : 210px;'><div class='col-md-10'>".$tempObjectDBD->getNama()."</div><div class='col-md-2'><span><i title='lihat detail mahasiswa ini' onclick='detailThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")' class='icon-info-sign'  style='font-size : 15pt; color : blue; cursor : pointer;'></i></span></div></div></td><td>";
							if(intval($tempObjectDB->getKategori())==1) $dataTemp .= "Baru";
							else $dataTemp .= "Melanjutkan";
							$dataTemp .= "</td><td><div style='width : 200px;'><div class='col-md-12'>";
							$tempListNim .= $tempObjectDBD->getNim().",";
							$tempSelectTwo="";
							$tempSelectTwoID="";
							if($changeAvaila){
								if(intval($tempObjectDB->getDataProses()) == 3) $dataTemp .= "<select disabled>";
								else {
									$dataTemp .= "<select id='select-satu-".($i+1)."' onfocus='this.oldvalue = this.value' onchange=".'"'."changeDospem('".$tempObjectDBD->getNim()."',this,document.getElementById('select-dua-".($i+1)."'));".'"'." >";
									$tempSelectTwoID = " id='select-dua-".($i+1)."' ";
								}
							}
							else
								$dataTemp .= "<select disabled>";
							$dataTemp .= "<option value='0'>Belum ada</option>";
							$tempSelectTwo .= "<option value='0'></option>";
							$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDB->getIdentified());
							$tempDosbing->getNextCursor();
							$nipreview="";
							$tempObjectDBT->resetSendRequest();
							while($tempObjectDBT->getNextCursor()){
								
								$dataTemp .= "<option value='".$tempObjectDBT->getNip()."'";
								if($tempObjectDBT->getIdentified() == $tempDosbing->getDosen())
									$dataTemp .= " selected ";
								$dataTemp .= ">".$tempObjectDBT->getNama()."</option>";
								$tempSelectTwo = $tempSelectTwo."<option value='".$tempObjectDBT->getNip()."'>".$tempObjectDBT->getNama()."</option>";
								if($tempObjectDBT->getIdentified() == $tempObjectDBD->getDosenS()){
									if($tempObjectDBD->getDosenS() == $tempObjectDBD->getDosenRespon())
										$nipreview.="<li>".$tempObjectDBT->getNama()."<span style='font-size : 16px; color : green;'><i class='icon-ok'></i></span></li>";
									else
										$nipreview.="<li>".$tempObjectDBT->getNama()."</li>";
									$tempssN++;
								}else if($tempObjectDBT->getIdentified() == $tempObjectDBD->getDosenD()){
									if($tempObjectDBD->getDosenD() == $tempObjectDBD->getDosenRespon())
										$nipreview.="<li>".$tempObjectDBT->getNama()."<span style='font-size : 16px; color : green;'><i class='icon-ok'></i></span></li>";
									else
										$nipreview.="<li>".$tempObjectDBT->getNama()."</li>";
									$tempssN++;
								}else if($tempObjectDBT->getIdentified() == $tempObjectDBD->getDosenT()){
									if($tempObjectDBD->getDosenT() == $tempObjectDBD->getDosenRespon())
										$nipreview.="<li>".$tempObjectDBT->getNama()."<span style='font-size : 16px; color : green;'><i class='icon-ok'></i></span></li>";
									else
										$nipreview.="<li>".$tempObjectDBT->getNama()."</li>";
									$tempssN++;
								}
								
							}
							
							$dataTemp .= "</select></div></div></td><td><div style='width : 300px'><div class='col-md-9'><select".$tempSelectTwoID." disabled>".$tempSelectTwo."</select></div><div class='col-md-3' style='text-align : center;'>";
							$dataTemp .= "<span><i title='informasi tentang dosen yang dipilih' onclick='detailThisDospem(".'"'.$tempObjectDBD->getNim().'"'.",".($i+1).")' class='icon-info-sign'  style='font-size : 15pt; color : blue; cursor : pointer;'></i></span>";
							$dataTemp .= "<span style='margin-left : 5px;'><i title='tampilkan tabel perbandingan mahasiswa dan dosen yang dipilih' onclick='detailCompareThisGuysWithDospem(".'"'.$tempObjectDBD->getNim().'"'.",".($i+1).")' class='icon-link'  style='font-size : 15pt; color : blue; cursor : pointer;'></i></span>";
							$dataTemp .= "</div></div></td>";
							$scope = 1;
							$same = 1;
							$tempos = "";
							$tempObjectDBE = $controlRegistrasi->getListAllDosenBimbinganLog($tempObjectDBD->getIdentified());
							if($tempObjectDBE){
								while($tempObjectDBE->getNextCursor()){
									$tempDosen = $tempObjectDBE->getTableStack(0)->getDosen();
									if($scope > 3)
										break;
									$allow = true;
									if($same == 1 ){
										$same = 2;
										if($tempDosen == $tempDosbing->getDosen()){
											$allow = false;
										}
									}
									if($allow){
										$tempObjectDBL = $controlDosen->getAllData($tempDosen);
										$tempObjectDBL->getNextCursor();
										$tempos .= $scope ." : ".$tempObjectDBL->getNama()."<br>";
										$scope ++;
									}
								}
							}
							$tempss="<ul style='list-style:none;padding : 0; margin : 0;'>";
							if($tempos == "")
								$tempss.="<li>-</li>";
							else{
								$tempss.="<li>".substr($tempos, 0,strlen($tempos)-4)."</li>";
							}
							$tempss.="</ul>";
							$dataTemp .= "<td><div style='width : 200px;'>".$tempss."</div></td><td><div style='width : 200px;'>";
							
							if($nipreview == "")
								$dataTemp .= "<ul style='list-style:none; margin-left : 0; left : 0; padding :0;'><li >Belum review dosen</li></ul>";
							else 
								$dataTemp .= "<ul style='list-style:none; margin-left : 0; left : 0; padding: 0;'>".$nipreview."</ul>";
						
							$dataTemp .= "</div></td><td><div style='width : 100px;'>";
							
							$dataTemp .= "<select onchange=".'"'."changeDataProses('".$tempObjectDBD->getNim()."',this.value);".'"'." >";
							if(intval($tempObjectDB->getDataProses()) == 1) $dataTemp .= '<option selected value="1">Menunggu</option>';
							else $dataTemp .= '<option value="1">Menunggu</option>';
							if(intval($tempObjectDB->getDataProses()) == 2) $dataTemp .= '<option selected value="2">Disetujui</option>';
							else $dataTemp .= '<option value="2">Disetujui</option>';
							if(intval($tempObjectDB->getDataProses()) == 3) $dataTemp .= '<option selected value="3">Ditolak</option>';
							else $dataTemp .= '<option value="3">Ditolak</option>';
							$dataTemp .= "</select></div></td><td><div style='width : 300px;'>".$tempDosbing->getPesan()."</div></td></tr>";
							$koko++;
							$n++;
							$i++;
						}else if($n == 15 && $z < $page){
							$n = 1;
							$z++;
						}else{
							$n++;
						}
						
					}
				}
			}
		}
		if($dataTemp == ""){
			echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
		}
		else echo $dataTemp;
		echo "|";
		if($page == 1){
			if($koko == 15)
				echo '
						<a class="paginate_disabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sebelumnya </a>
						<a class="paginate_enabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0" onclick="nextPageRegistrasiBase();"> Sesudahnya </a>
					';
			else
				echo '
						<a class="paginate_disabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sebelumnya </a>
						<a class="paginate_disabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sesudahnya </a>
					';
		}else{
			if($koko == 15)
				echo '
						<a class="paginate_enabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"  onclick="previousPageRegistrasiBase();"> Sebelumnya </a>
						<a class="paginate_enabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0"  onclick="nextPageRegistrasiBase();"> Sesudahnya </a>
					';
			else
				echo '
						<a class="paginate_enabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"  onclick="previousPageRegistrasiBase();"> Sebelumnya </a>
						<a class="paginate_disabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sesudahnya </a>
					';
		}
		echo "|".$tempTotal."|";
		if($tempTotal > 0){
			$tempListNim = substr($tempListNim,0,strlen($tempListNim)-1);
			echo $tempListNim;
		}
	}
	//fix
	public function setDospem(){
		$this->loadLib('ControlTime');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$nimEx = explode(",",$this->isNullPost('nim'));
		$nipEx = explode(",",$this->isNullPost('nip'));
		if(count($nimEx) != count($nipEx)){
			echo "0Data nim dan nip tidak valid";
			return;
		}
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('Aktor/Mahasiswa');
		$this->loadLib('Aktor/Dosen');
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		$dosen = new Dosen($this->inputJaservFilter);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$kode = $this->isNullPost('kode');
		if($kode!="JASERVCONTROL")
			exit("0maaf, anda melakukan debugging");
		$succes = 0;
		for($i=0;$i<count($nimEx);$i++){
			$nim = $nimEx[$i];
			$nip = $nipEx[$i];
			if(!$mahasiswa->getCheckNim($nim,1)[0]){
				if(count($nimEx) > 1) exit("0terdapat nim yang tidak sesuai");
				else exit("0nim tidak sesuai");
			}
			$tempBool=true;
			$nipNext=true;
			if($nip != "0"){
				$tempBool=false;
				if(!$dosen->getCheckNip($nip,1)[0]){
					if(count($nimEx) > 1) exit("0terdapat nip yang tidak sesuai");
					else exit("0nim tidak sesuai");
				}
				$tempObjectDBD = $controlDosen->getDataByNip($nip);
				if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
					$nipNext=false;
				else{
					$nip=$tempObjectDBD->getIdentified();
				}
			}
			$tempObjectDB = $controlMahasiswa->getDataByNim($nim); 
			if($tempObjectDB && $tempObjectDB->getNextCursor()){
				if($nipNext){
					if($controlRegistrasi->setDospemForTA($tempObjectDB->getIdentified(),$nip,$tahunAk,$tempBool)[0]) $succes++;
				}
			}
		}
		if(count($nimEx) == $succes){
			echo "1data berhasil dirubah";
		}else{
			echo "0terdapat data yang gagal dirubah";
		}
		return;
	}
	//
	public function getInfoMahasiswaFull(){
		$kode = $this->isNullPost('kode');
		$nim = $this->isNullPost('nim');
		$this->loadLib("Aktor/Mahasiswa");
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$this->loadLib('ControlMahasiswa');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
			exit("0nim ini tidak terdaftar");
		$this->loadLib('ControlDetail');
		$this->loadLib('ControlTime');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->loadLib('ControlRegistrasi');
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDBD = $controlDetail->getDetail('minat',$tempObjectDB->getMinat());
		$tempObjectDBD->getNextCursor();
		$tempObjectDBT = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempObjectDBE = $controlDetail->getDetail('kategori',$tempObjectDBT->getKategori());
		$tempObjectDBE->getNextCursor();
		$data = array(
				'nim' => $tempObjectDB->getNim(),
				'nama' => $tempObjectDB->getNama(),
				'minat' => $tempObjectDBD->getDetail(),
				'foto' => $tempObjectDB->getNamaFoto(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNohp(),
				'judulTA' => $tempObjectDBT->getJudulTa(),
				'statusTA' => $tempObjectDBE->getDetail(),
				'urltranskrip' => base_url()."Filesupport/getTranskrip/".$tempObjectDB->getNim().".jsp",
				'urlkrs' => base_url()."Filesupport/getKRS/".$tempObjectDB->getNim().".jsp"
		);
		echo "1";
		$this->load->view('Bodyright/Controlroom/Infomahasiswaview',$data);
	}
	public function getInfoDosenFull(){
		$kode = $this->isNullPost('kode');
		$nip = $this->isNullPost('nip');
		$nim = $this->isNullPost('nim');
		$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Mahasiswa');
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->dosen->initial($this->inputJaservFilter);
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlDosen->getDataByNip($nip);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0nip tidak terdaftar");
		}
		$tempObjectDBD = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("0nim tidak terdaftar");
		}
		
		$intNo = 1;
		$yourTable = null;
		$dosenFavorit = "Bukan";
		if(strlen($tempObjectDBD->getDosenS()) == 29){
			if($tempObjectDBD->getDosenS() == $nip){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDBD->getDosenD()) == 29){
			if($tempObjectDBD->getDosenD() == $nip){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDBD->getDosenT()) == 29){
			if($tempObjectDBD->getDosenT() == $nip){
				$dosenFavorit = "Ya";
			}
		}
		$data = array(
				'nip' => $tempObjectDB->getNip(),
				'nama' => $tempObjectDB->getNama(),
				'bidris' => $tempObjectDB->getBidangRiset(),
				'alamat' => $tempObjectDB->getAlamat(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'dosenFavor'=> $dosenFavorit
		);
		echo "1";
		$this->load->view('Bodyright/Controlroom/Infodosenview',$data);
	}
	public function getInfoDosenAndMahasiswaComparasiFull(){
		$kode = $this->isNullPost('kode');
		$nip = $this->isNullPost('nip');
		$nim = $this->isNullPost('nim');
		if($kode != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Mahasiswa');
		$this->load->library('Aktor/Dosen');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlDetail');
		$this->loadLib('ControlTime');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->dosen->initial($this->inputJaservFilter);
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0nim tidak terdaftar");
		}
		$tempObjectDBD = $controlDosen->getDataByNip($nip);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("0nim tidak terdaftar");
		}
		$tempObjectDBT = $controlDetail->getDetail('minat',$tempObjectDB->getMinat());
		$tempObjectDBT->getNextCursor();
		$tempObjectDBE = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBE || !$tempObjectDBE->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBL = $controlDetail->getDetail('kategori',$tempObjectDBE->getKategori());
		$tempObjectDBL->getNextCursor();
		$data = array(
				'nim' => $tempObjectDB->getNim(),
				'nama' => $tempObjectDB->getNama(),
				'minat' => $tempObjectDBT->getDetail(),
				'foto' => $tempObjectDB->getNamaFoto(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'judulTA' => $tempObjectDBE->getJudulTA(),
				'statusTA' => $tempObjectDBL->getDetail()
		);
		if(!$this->dosen->getCheckNip($nip,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$intNo = 1;
		$yourTable = null;
		$dosenFavorit = "Bukan";
		if(strlen($tempObjectDB->getDosenS()) == 29){
			if($tempObjectDB->getDosenS() == $nip){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDB->getDosenD()) == 29){
			if($tempObjectDB->getDosenD() == $nip){
				$dosenFavorit = "Ya";
			}
		}
		if(strlen($tempObjectDB->getDosenT()) == 29){
			if($tempObjectDB->getDosenT() == $nip){
				$dosenFavorit = "Ya";
			}
		}
		$data['dosenNip'] = $tempObjectDBD->getNip();
		$data['dosenNama'] = $tempObjectDBD->getNama();
		$data['dosenBidris'] = $tempObjectDBD->getBidangRiset();
		$data['dosenAlamat'] = $tempObjectDBD->getAlamat();
		$data['dosenAmail'] = $tempObjectDBD->getEmail();
		$data['dosenNotelp'] = $tempObjectDBD->getNohp();
		$data['dosenFavor']= $dosenFavorit;		
		echo "1";
		$this->load->view('Bodyright/Controlroom/Infodosenmahasiswaview',$data);
	}
	function setStatusMahasiswaRegister(){
		$this->isNullPost('kode');
		$this->isNullPost('kodeS');
		$this->isNullPost('nim');
		$temp = $this->input->post('kode');
		$tempS = intval($this->input->post('kodeS'));
		if($temp != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if($this->changeStatusMahasiswaRegister(array($this->input->post('nim'),$tempS))){
			echo "1Berhasil melakukan perubahan";
		}else{
			echo "0Gagal melakukan perubahan";
		}
	}
	protected function changeStatusMahasiswaRegister($tempArray){
		$this->loadLib("Aktor/Mahasiswa");
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		if(!$mahasiswa->getCheckNim($tempArray[0],1)[0])
			return false;
		if($tempArray[1] < 1 || $tempArray[1] > 3){
			return false;
		}
		$this->loadLib("ControlTime");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlSeminar");
		$this->loadLib("ControlSidang");
		$controlTime = new ControlTime($this->gateControlModel);
		$tahunAk = $controlTime->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($tempArray[0]);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk, $tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()) return false;
		if((new ControlSeminar($this->gateControlModel))->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified())->getNextCursor()) return false;
		if((new ControlSidang($this->gateControlModel))->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified())->getNextCursor()) return false;
		/* echo "data proses ".$tempObjectDB->getNim()." = ".$tempObjectDBD->getDataProses();
		exit(); */
		switch($tempArray[1]){
			case 1 :
			case 2 :
				if($tempArray[1] == 2){
					$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
					$tempDosbing->getNextCursor();
					if(strlen($tempDosbing->getDosen()) < 40) return false;
				}
				$tempObjectDBD->setDataProses($tempArray[1]);
				if($controlRegistrasi->tryUpdate($tempObjectDBD)){
					$tempObjectDB->setFormBaru(2);
					$tempObjectDB->setRegistrasiBaru(2);
					$tempObjectDB->setRegistrasiLama(2);
					$tempObjectDB->setTanpaWaktu(2);
					return $controlMahasiswa->tryUpdate($tempObjectDB);
				}
			break;
			case 3 :
				$tempObjectDBD->setDataProses($tempArray[1]);
				if($controlRegistrasi->tryUpdate($tempObjectDBD)){
					if(!$controlTime->isRegisterTime()){
						$tempObjectDB->setTanpaWaktu(1);
					}else{
						$tempObjectDB->setTanpaWaktu(2);
					}
					$tempObjectDB->setFormBaru(1);
					if(intval($tempObjectDBD->getKategori()) == 1){
						$tempObjectDB->setRegistrasiBaru(1);
					}else{
						$tempObjectDB->setRegistrasiLama(1);
					}
					return $controlMahasiswa->tryUpdate($tempObjectDB);
				}
			break;
		}
		return false;
	}
	public function setOnlyThisPage(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){ $tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){ echo "0Tahun ajaran tidak valid"; return; }
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){ $semester = null; 
		}else{	
			if(intval($semester) < 1 || intval($semester) > 2){ echo "0Semester tidak di ketahui"; return; }
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $srt = $controlTime->getYearNow();
		}else{ $srt = "".$tahun."".$semester.""; }
		$changeAvaila = true;
		if(intval($srt) != intval($controlTime->getYearNow()))
			exit("0tahun ajaran tidak aktif");
		//key
		$tempS = $this->isNullPost('kodeS');
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){ echo "0Kata kunci harus berupa bagian nama dari seseorang"; return;
			}else $key = $this->isNullPost('key');
		}
		$page = 1;
		if($this->input->post("page")!==NULL){ $page = intval($this->input->post("page")); if($page < 0) $page = 1; }
		$s=true;
		$string = "<h4>Informasi Acara</h4><div class='well'>Data Tidak ditemukan</div>";
		$n = 1;	$z = 1;
		$koko = 0; $trueCon = false;
		$tempTotal = 0;	$tempListNim = "";
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlMahasiswa");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = $controlRegistrasi->getAllData($srt,null,1,null);
		$dataTemp = "";
		echo 1;
		$i=0;
		$dataNim = "<table style='width 100%;'><thead><tr><td>No</td><td>Nama</td><td>Status perubahan</td></tr></thead><tbody>";
		$tempData = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
				if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
					if($key == "*" || !is_bool(strpos(strtolower($this->sc_sm->getName()),strtolower($key)))){
						//
						if($n <= 15 && $z == $page){
							if($this->changeStatusMahasiswaRegister(array($tempObjectDBD->getNim(),$tempS))){
								$tempData .= "<tr><td>".$n."</td><td>".$tempObjectDBD->getNama()."</td><td>berhasil dirubah</td></tr>";
							}else{
								$tempData .= "<tr><td>".$n."</td><td>".$tempObjectDBD->getNama()."</td><td>gagal dirubah</td></tr>";
							}
							$koko++;
							$n++;
							$i++;
						}else if($n == 15 && $z < $page){
							$n = 1;
							$z++;
						}else{
							$n++;
						}
						
					}
				}
			}
		}
		if($tempData == ""){
			$tempData .= "<tr><td>-</td><td>-</td><td>-</td></tr>";
		}
		$tempData .= "</tbody></table>";
		echo $dataNim."".$tempData;
	}
	public function setAllEveryRegister(){
		//filter tahun
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		$tahunAk = $controlTime->getYearNow();
		if($semester == null || $tahun == null){
			$srt = $tahunAk;
		}else{
			$srt = "".$tahun."".$semester."";
		}
		$changeAvaila = true;
		if(intval($srt) != intval($tahunAk))
			exit("0tahun ajaran tidak aktif");
		//key
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){
				echo "0Kata kunci harus berupa bagian nama dari seseorang";
				return;
			}else
				$key = $this->isNullPost('key');
		}
		$tempS = $this->isNullPost('kodeS');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlRegistrasi($this->gateControlModel))->getAllData($srt,null,1,null);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		echo "1";
		$dataNim = "<table style='width 100%;'><thead><tr><td>No</td><td>Nama</td><td>Status perubahan</td></tr></thead><tbody>";
		$tempData = "";
		if($tempObjectDB){
			$j = 1;
			while($tempObjectDB->getNextCursor()){	
				//echo "ll";
				$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
				if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
					if($key == "*" || !is_bool(strpos(strtolower($this->sc_sm->getName()),strtolower($key)))){
						if($this->changeStatusMahasiswaRegister(array($tempObjectDBD->getNim(),$tempS))){
							$tempData .= "<tr><td>".$j."</td><td>".$tempObjectDBD->getNama()."</td><td>berhasil dirubah</td></tr>";
						}else{
							$tempData .= "<tr><td>".$j."</td><td>".$tempObjectDBD->getNama()."</td><td>gagal dirubah</td></tr>";
						}
						$j++; 
					}
				}
			}
		}
		if($tempData == ""){
			$tempData .= "<tr><td>-</td><td>-</td><td>-</td></tr>";
		}
		$tempData .= "</tbody></table>";
		echo $dataNim."".$tempData;
	}
	//optimized - complex
	//print excel document on this table view
	public function getDataWithExcel($year){
		$year = intval($year);
		$this->loadLib("ControlTime");
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		if($year >= 20131 && $year <= intval($srt))
			$srt = $year."";
		$srt = "".$srt."";
		$this->load->library("phpexcel");
		 //membuat objek
		$objPHPExcel = new Phpexcel();
		$listTitle = array(
			'No',
			'Nim',
			'Nama',
			'Judul',
			'Status',
			'Dosen',
			'Metode',
			'Referensi 1',
			'Referensi 2',
			'Referensi 3' 
		);
		// Nama Field Baris Pertama
		$col = 1;
		foreach ($listTitle as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			$col++;
		}
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = $controlRegistrasi->getAllData($srt,null,1,null);
		$i=1;
		$row = 5;
		
		if(!$tempObjectDB) exit("0data tidak ditemukan");
		while($tempObjectDB->getNextCursor()){
			$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
			$tempObjectDBD->getNextCursor();
			$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDB->getIdentified());
			$tempDosbing->getNextCursor();
			$tempObjectDBT = $controlDosen->getAllData($tempDosbing->getDosen());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $i);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tempObjectDBD->getNim());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tempObjectDBD->getNama());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $tempObjectDB->getJudulTA());
			if(intval($tempObjectDB->getKategori()) == 1){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, "Baru");	
			}else{
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, "Melanjutkan");
			}
			if(!$tempObjectDBT || !$tempObjectDBT->getNextCursor())
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "belum dipilihkan");
			else
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $tempObjectDBT->getNama());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $tempObjectDB->getMetode());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $tempObjectDB->getRefS());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $tempObjectDB->getRefD());
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $tempObjectDB->getRefT());
			$row++;
			$i++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		//Set Title
		$objPHPExcel->getActiveSheet()->setTitle('Data Absen');
		//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//Nama File
		header('Content-Disposition: attachment;filename="DataPeserta Registrasi.xlsx"');
		//Download
		$objWriter->save("php://output");
	}
}