<?php
if(!defined('BASEPATH')) exit("You dont have permission");
require_once APPPATH.'controllers/CI_Controller_Modified.php';
/*
dependencie:
-LoginFilter
-Dosen
-Mahasiswa
-GateControlModel
-Inputjaservfilter
-ControlDetail
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
class Kingpenguji extends CI_Controller_Modified{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('Aktor/Dosen');
		$this->load->library('Session');
		$this->loadMod('GateControlModel');
		$this->gateControlModel = new GateControlModel();
		$this->loadLib('LoginFilter');
		$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->dosen))
			redirect(base_url().'Gateinout.jsp');
		$this->loadLib('Aktor/Mahasiswa');
		$this->mahasiswa = new Mahasiswa(new Inputjaservfilter());
		$this->loadLib('ControlTime');
		$this->loadLib('Inputjaservfilter');
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlDetail');
		$this->controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$this->controlSeminar = new ControlSeminar($this->gateControlModel);
		$this->controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$this->controlSidang = new ControlSidang($this->gateControlModel);
		$this->controlDosen = new ControlDosen($this->gateControlModel);
		$this->controlDetail = new ControlDetail($this->gateControlModel);
		$this->tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
	}
	public function getLayoutPenguji(){
		echo '1';
		$this->load->view("Bodyright/Kingroom/Penguji.php");
	}
	//fix
	public function getTablePengujiTA1(){
		//$_POST['keyword']="";
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->inputJaservFilter->titleFiltering($keyword)[0]){
				$keyword = "*";
			}
		}
		
		$tempObjectDB = $this->controlRegistrasi->getAllDataByDosen($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		$kode = 1;
		$string = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$tempObjectDBD = $this->controlMahasiswa->getAllData($tempObjectDB->getTableStack(1)->getMahasiswa());
				if($tempObjectDBD->getNextCursor()){
					if($keyword == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($keyword)))){
						$tempObjectDBT = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getTableStack(1)->getMahasiswa());
						if($tempObjectDBT->getNextCursor()){	
							$tempObjectDBE = $this->controlDetail->getDetail('ruang',$tempObjectDBT->getRuang());
							$tempObjectDBE->getNextCursor();
							if(intval($tempObjectDBT->getRekomendasi()) == 1){
								$color = "green";
								$message = "modalStaticSingleWarning(".'"Merupakan mahasiswa dengan seminar rekomendasi dari anda"'.")";
							}else{
								$color = "red";
								$message = "modalStaticSingleWarning(".'"Merupakan mahasiswa dengan mengajukan seminar secara mandiri ke admin"'.")";
							}
							$onclick = true;
							if(intval($tempObjectDBT->getWaktu()) != "1000-01-01 00:00:00"){
								$onclick = false;
							}
							if($onclick){
								$tolak = "onclick='bannishThisGuysFromSeminar(".'"'.$tempObjectDBD->getNim().'"'.")'";
							}else{
								$tolak = "disabled";
							}
							$string .=
							"<tr>
								<td style='text-align : center;'>".$tempObjectDBD->getNim()."</td>
								<td style='text-align : center;'>".$tempObjectDBD->getNama()."</td>
								<td style='text-align : center;'>".$tempObjectDB->getTableStack(1)->getJudulTA()."</td>
								<td style='text-align : center;'>".$tempObjectDBT->getWaktu()."</td>
								<td style='text-align : center;'>".$tempObjectDBE->getDetail()."</td>
								<td style='text-align : center;'>
									<div style='width : 100px;'>
									<span style=''><i onclick='".$message."' class='icon-info-sign btn' style='font-size : 12px; color : ".$color.";'></i></span>
									</div>
								</td>
							</tr>
							";						
						}
					}
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	/* public function reRegisterPengujiTA(){
		$TA = $this->view->isNullPost('TA');
		$nim = $this->view->isNullPost('Nim');
		
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("nim tidak valid");
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB->getNextCursor()) exit("0nim tidak terdaftar");
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDB->getNextCursor()) exit("0nim tidak terdaftar");
		
		$TA = intval($TA);
		if($TA<1 || $TA>2)
			exit("0Kode TA anda tidak valid");
		$TEMP_SC_STD = new Sc_std();
		$ERROR = 0;
		$TEMP_SC_STD->resetValue();
		$TEMP_SC_STD->setNim($this->sc_st->getNim());
		$TEMP_SC_STD->setKode($this->mahasiswa->getYearNow());
		$TEMP_SC_STD->setKategori($TA);
		if(!$TEMP_SC_STD->isRegisteredOnSeminar()){
			exit("0Maaf belum mendaftar seminar sama sekali");
		}
		//exit("0masuk tahap reset data ".$TA." ".$nim);
		$TEMP_SC_STD->resetValue();
		$TEMP_SC_STD->setKode($this->mahasiswa->getYearNow());
		$TEMP_SC_STD->setNim($nim);
		$TEMP_SC_STD->setKategori($TA);
		$TEMP_SC_STD->setDataProses(3);
		if($TA==2){
			$TEMP_SC_STD->setNips("0");
			$TEMP_SC_STD->setNipd("0");
		}
		if($TEMP_SC_STD->updateDataProsesTA()){
			$this->sc_sm->resetValue();
			$this->sc_sm->setNim($nim);
			if($TA == 1){
				$this->sc_sm->setSeminarTA1(1);
				$this->sc_sm->setSeminarTA1CloseOrOpen();
			}else{
				$this->sc_sm->setSeminarTA2(1);
				$this->sc_sm->setSeminarTA2CloseOrOpen();
			}
		}
		exit("1Rekomendasi berhasil daftarkan");
	} */
	//fix
	public function getTablePengujiTA2(){
		//$_POST['keyword']="";
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->inputJaservFilter->titleFiltering($keyword)[0]){
				$keyword = "*";
			}
		}
		$tempObjectDB = $this->controlRegistrasi->getAllDataByDosen($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		$kode = 1;
		$string = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$tempObjectDBD = $this->controlMahasiswa->getAllData($tempObjectDB->getTableStack(1)->getMahasiswa());
				if($tempObjectDBD->getNextCursor()){
					if($keyword == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($keyword)))){
						$tempObjectDBT = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getTableStack(1)->getMahasiswa());
						if($tempObjectDBT->getNextCursor()){
							$tempObjectDBE = $this->controlDetail->getDetail('ruang',$tempObjectDBT->getRuang());
							$tempObjectDBE->getNextCursor();
							if(intval($tempObjectDBT->getRekomendasi()) == 1){
								$color = "green";
								$message = "modalStaticSingleWarning(".'"Merupakan mahasiswa dengan seminar rekomendasi dari anda"'.")";
							}else{
								$color = "red";
								$message = "modalStaticSingleWarning(".'"Merupakan mahasiswa dengan mengajukan seminar secara mandiri ke admin"'.")";
							}
							//parameter
							$onclick = true;	
							$dosen1 = "";
							$dosen2 = "";
							$dosen3 = "";
							if(strlen($tempObjectDBT->getDosenS()) == 40){
								$onclick = false;
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDBT->getDosenS());
								if($tempObjectDBL->getNextCursor()){
									$dosen1=$tempObjectDBL->getNama();
								}
							}
							if(strlen($tempObjectDBT->getDosenD()) == 40){
								$onclick = false;
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDBT->getDosenD());
								if($tempObjectDBL->getNextCursor()){
									$dosen2=$tempObjectDBL->getNama();
								}
							}
							if(strlen($tempObjectDBT->getDosenT()) == 40) {
								$onclick = false;
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDBT->getDosenT());
								if($tempObjectDBL->getNextCursor()){
									$dosen3=$tempObjectDBL->getNama();
								}
							}
							if($onclick){
								$tolak = "onclick='bannishThisGuysFromSeminarTA2(".'"'.$tempObjectDBD->getNim().'"'.")'";
							}else{
								$tolak = "disabled";
							}
							$string .=
							"<tr>
								<td style='text-align : center;'>".$tempObjectDBD->getNim()."</td>
								<td style='text-align : center;width : 200px;'>".$tempObjectDBD->getNama()."</td>
								<td style='text-align : center;width : 200px;'>".$tempObjectDB->getTableStack(1)->getJudulTA()."</td>
								<td style='text-align : center;width : 200px;'>".$tempObjectDBT->getWaktu()."</td>
								<td style='text-align : center;width : 200px;'>".$tempObjectDBE->getDetail()."</td>
								<td style='text-align : center;width : 200px;'>".$dosen1."</td>
								<td style='text-align : center; width : 200px;'>".$dosen2."</td>
								<td style='text-align : center; width : 200px;'>".$dosen3."</td>
								<td style='text-align : center; width : 150px;'>
									<span style=''><i onclick='".$message."' class='icon-info-sign btn' style='font-size : 12px; color : ".$color.";'></i></span>
								</td>
							</tr>
							";
						}
						
					}
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	public function banishLeaderOrMember(){
		$kode = $this->isNullPost("kode");
		$data = false;
		switch($kode){
			case 'ketua' :
			case 'pembantu' :
			case 'pembantu2' :
				$data = true;
			break;
		}
		if(!$data){
			exit("0Kode tidak valid");
		}
		$nim = $this->isNullPost("nim");
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("0Nim tidak valid");
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB->getNextCursor()) exit("0nim tidak terdaftar");
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBD->getNextCursor()) exit("0nim tidak terdaftar");
		$tempObjectDBT = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBT->getNextCursor()) exit("0nim tidak terdaftar");
		if(strlen($tempObjectDBT->getFujDP()) > 6 || strlen($tempObjectDBT->getFujDL()) > 6) exit("maaf, mahasiswa sudah masuk tahap sidang");
		$data = false;
		switch($kode){
			case 'ketua' :
			if($tempObjectDBT->getDosenS() == $this->loginFilter->getIdentifiedActive()){
				$data = true;
				$tempObjectDBT->setDosenS("");
			}
			break;
			case 'pembantu' :
			if($tempObjectDBT->getDosenD() == $this->loginFilter->getIdentifiedActive()){
				$data = true;
				$tempObjectDBT->setDosenD("");
			}
			break;
			case 'pembantu2' :
			if($tempObjectDBT->getDosenT() == $this->loginFilter->getIdentifiedActive()){
				$data = true;
				$tempObjectDBT->setDosenT("");
			}
			break;
		}
		if(!$data){
			exit("0Mohon maaf, nim ini bukan bimbingan yang anda uji");
		}
		//reset to wait mode
		$tempObjectDBT->setDataProsesS(1);
		if($this->controlSidang->tryUpdate($tempObjectDBT)){
			exit("1Data berhasil dirubah");
		}else{
			exit("0Status gagal dirubah");
		}
	}
	//fix
	public function getDataNipsOrNipd(){
		//$_POST['kode'] = 'ketua';
		$kode = $this->isNullPost("kode");
		//$kode = "pembantu";
		$data = false;
		switch($kode){
			case 'ketua' :
			case 'pembantu' :
			case 'pembantu2' :
				$data = true;
			break;
		}
		if(!$data){
			exit("0Kode tidak valid");
		}
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->inputJaservFilter->titleFiltering($keyword)[0]){
				$keyword = "*";
			}
		}
		$tempObjectDB=false;
		switch($kode){
			case 'ketua' :
				$kodeS = 1;
			break;
			case 'pembantu' :
				$kodeS = 2;
			break;
			case 'pembantu2' :
				$kodeS = 3;
			break;
		}
		$strings="";
		$tempObjectDB = $this->controlSidang->isTesterOfMahasiswa($kodeS,$this->tahunAk,$this->loginFilter->getIdentifiedActive());
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$tempObjectDBD = $this->controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
				if($tempObjectDBD->getNextCursor()){
					if($keyword == '*' || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($keyword)))){
						
						$dosen1="";
						$dosen2="";
						switch($kode){
							case 'ketua' :
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDB->getDosenD());
								$tempObjectDBL->getNextCursor();
								$dosen1=$tempObjectDBL->getNama();
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDB->getDosenT());
								$dosen2="";
								if($tempObjectDBL && $tempObjectDBL->getNextCursor()){
									$dosen2=$tempObjectDBL->getNama();
								}
							break;
							case 'pembantu' :
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDB->getDosenS());
								$tempObjectDBL->getNextCursor();
								$dosen1=$tempObjectDBL->getNama();
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDB->getDosenT());
								if($tempObjectDBL && $tempObjectDBL->getNextCursor()){
									$dosen2=$tempObjectDBL->getNama();
								}
							break;
							case 'pembantu2' :
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDB->getDosenS());
								$tempObjectDBL->getNextCursor();
								$dosen1=$tempObjectDBL->getNama();
								$tempObjectDBL = $this->controlDosen->getAllData($tempObjectDB->getDosenD());
								$tempObjectDBL->getNextCursor();
								$dosen2=$tempObjectDBL->getNama();
							break;
						}
						$tempObjectDBE = $this->controlDetail->getDetail('ruang',$tempObjectDB->getRuang());
						$tempObjectDBE->getNextCursor();
						$tempObjectDBT = $this->controlRegistrasi-> getAllData($this->tahunAk,$tempObjectDB->getMahasiswa(),1, 0,null);
						$tempObjectDBT->getNextCursor();
						$onclick = true;
						if(strlen($tempObjectDB->getFujDP()) > 10 && strlen($tempObjectDB->getFujDL()) > 10){
							$onclick = false;
						}
						$tolak = '';
						if($onclick){
							switch($kode){
								case 'ketua' :
								$tolak = "onclick='bannishThisGuysFromSeminarTA2Ketua(".'"'.$tempObjectDBD->getNim().'"'.")'";
								break;
								case 'pembantu' :	
								$tolak = "onclick='bannishThisGuysFromSeminarTA2Pembantu(".'"'.$tempObjectDBD->getNim().'"'.")'";
								break;
								case 'pembantu2' :	
								$tolak = "onclick='bannishThisGuysFromSeminarTA2Pembantu2(".'"'.$tempObjectDBD->getNim().'"'.")'";
								break;
							}
						}else{
							$tolak = "disabled";
						}
						$waktu = "belum ditentukan";
						if($tempObjectDB->getWaktu() != "1000-01-01 00:00:00"){
							$waktu = $tempObjectDB->getWaktu();
						}
						$strings.="<tr>
						<td>".$tempObjectDBD->getNim()."</td>
						<td>".$tempObjectDBD->getNama()."</td>
						<td>".$tempObjectDBT->getJudulTA()."</td>
						<td>".$waktu."</td>
						<td>".$tempObjectDBE->getDetail()."</td>
						<td>".$dosen1."</td>
						<td>".$dosen2."</td>
						<td>
							<button title='Tolak melakukan seminar' ".$tolak." type='button' class='btn btn-danger'>Tolak</button>
						</td>
						</tr>";
						
					}
				}
			}
		}
		if($strings == ""){
			$strings.="<tr>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			<td style='text-align : center;'>-</td>
			</tr>";
		}
		echo "1".$strings;
	}
}