<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Classseminartad extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();$this->load->library("Aktor/Mahasiswa");
		$this->loadMod("GateControlModel");
		$this->gateControlModel = new GateControlModel();
		$this->loadLib('LoginFilter');
		$this->loadLib('Inputjaservfilter');
		$this->loadLib('Datejaservfilter');
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->dateJaservFilter = new Datejaservfilter();
		$this->load->library('Session');
		$this->load->helper('url');
		//$this->load->model('sc_ea');
		$this->load->helper('html');
		$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
		if(!$this->loginFilter->isLogin($this->mahasiswa)){
			exit("=<script>window.location = '".base_url().'Gateinout.jsp'."';</script>");
		}
		$this->prosesOpen = false;
		$errorProsesOpen = 0;
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlTime");
		$this->tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = $this->controlRegistrasi->getAllData($this->tahunAk,$this->loginFilter->getIdentifiedActive(),1,null);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			$errorProsesOpen += 1;
		}else{
			if(intval($tempObjectDB->getDataProses()) != 2){
				$errorProsesOpen += 1;
			}
		}
		$this->loadLib("ControlSeminar");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlSidang");
		$this->loadLib("ControlAcara");
		$this->controlSeminar = new ControlSeminar($this->gateControlModel);
		$this->controlSidang = new ControlSidang($this->gateControlModel);
		$this->controlAcara = new ControlAcara($this->gateControlModel);
		$this->controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		if($errorProsesOpen == 0)
			$this->prosesOpen = true;
		$this->fuj20 = false;
		$this->fuj21 = false;
		$this->fuj22 = false;
		$this->fuj25 = false;
		$this->fuj11U = true;
		$tempObjectDBD = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		//var_dump($tempObjectDBD->getCountData());
		if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
			//echo $tempObjectDBD->getRekomendasi()." ".$tempObjectDBD->getDataProsesD()."<br>";
			if(intval($tempObjectDBD->getRekomendasi()) == 1 && $tempObjectDBD->getWaktu() == "1000-01-01 00:00:00"){
				if(intval($tempObjectDBD->getDataProsesS()) == 2){
					if(strlen($tempObjectDBD->getFujDP()) > 6 && strlen($this->sc_sta_d->getFujDL()) > 6){
						if(intval($tempObjectDBD->getDataProsesD()) == 1){
							$this->kodeForm = 4;
						}else if(intval($tempObjectDBD->getDataProsesD()) == 2){
							$this->fuj22 = true;
							$this->kodeForm = 5;
						}else{
							if(intval($tempObjectDBD->getRekomendasi()) == 1){
								$this->setSeminarTA2Proses(array('kartbim'=>""));
								$this->kodeForm = 2;
							}else
								$this->kodeForm = 1;
						}
					}else{
						$this->fuj20 = true;
						$this->fuj25 = true;
						$this->kodeForm = 3;
					}
				}else{
					$this->kodeForm = 2;	
				}
			}/* else if(intval($tempObjectDBD->getRekomendasi()) == 1 && intval($tempObjectDBD->getDataProsesD()) == 3){
				$this->kodeForm = 2;	
			} */else{
				if(intval($tempObjectDBD->getDataProsesS()) == 2){
					if(strlen($tempObjectDBD->getFujDP()) > 6 && strlen($tempObjectDBD->getFujDL()) > 6){
						if(intval($tempObjectDBD->getDataProsesD()) == 1){
							$this->kodeForm = 4;
						}else if(intval($tempObjectDBD->getDataProsesD()) == 2){
							$this->fuj22 = true;
							$this->kodeForm = 5;
						}else{
							if(intval($tempObjectDBD->getRekomendasi()) == 1){
								$this->setSeminarTA2Proses(array());
								$this->kodeForm = 2;
							}else
								$this->kodeForm = 1;
						}
					}else{
						$this->fuj20 = true;
						$this->fuj25 = true;
						$this->kodeForm = 3;
					}
				}else{
					$this->kodeForm = 2;	
				}
			}
		}else{
			$this->kodeForm = 1;
			$this->fuj21 = true;
		}
	}
	protected function setSeminarTA2Proses($tempArray){
		$dosenRekomendasi = false;
		$dataBefore = false;
		$tempObjectDB = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			if(intval($tempObjectDB->getRekomendasi()) == 1){
				$dosenRekomendasi = true;
			}
			$dataBefore = true;
		}
		$NUM = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive(),null,null)->getCountData();
		$tempObjectDBD = $this->controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDBD->getNextCursor();
		if(!$dosenRekomendasi){	
			$this->load->library('upload');
			$conPdf['upload_path'] = './upload/seminarta/seminarta2/pdf/';
			$conPdf['allowed_types'] = 'pdf';
			$conPdf['overwrite'] = true;
			$conPdf['remove_spaces'] = true;
			$conPdf['max_size'] = 1024;
			//Kartu bimbingan
			$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDBD->getNim()."-".$NUM."-fuj21";
			$this->upload->initialize($conPdf);
			if(!$this->upload->do_upload($tempArray['kartbim'])){
				return array( false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
			}
			$fujds = $this->upload->data('file_name');
			$dosenRek = "2";
		}else{
			$fujds = "";
			$dosenRek = "1";
		}
		if($dataBefore){
			$this->controlSidang->logSidangActive($this->tahunAk,$tempObjectDBD->getIdentified());
		}
		$tempObjectDB->resetValue();
		$tempObjectDB->setTahunAk($this->tahunAk);
		$tempObjectDB->setMahasiswa($tempObjectDBD->getIdentified());
		$tempObjectDB->setStatus(1);
		$tempObjectDB->setDataProsesS(1);
		$tempObjectDB->setFujDS($fujds);
		$tempObjectDB->setRekomendasi($dosenRek);
		if($this->controlSidang->addNew($tempObjectDB)){
			return array(true,'Data berhasil dimasukan');
		}
		return array(false,'Data gagal dimasukan');
	}
	public function index(){
		if($this->prosesOpen){
			switch($this->kodeForm){
				case 1 :
					echo "0A";
					$this->load->view("Bodyright/Classroom/Seminartad/Langkahs"); 
					break;
				case 2 :
					echo "0B";
					$this->load->view("Bodyright/Classroom/Seminartad/Langkahd"); 
					break;
				case 3 :
					echo "0C";
					$this->load->view("Bodyright/Classroom/Seminartad/Langkaht"); 
					break;
				case 4 :
					echo "0D";
					$this->load->view("Bodyright/Classroom/Seminartad/Langkahe"); 
					break;
				case 5 :
					echo "0E";
					$this->load->view("Bodyright/Classroom/Seminartad/Langkahl"); 
					break;
			}			
		}else{
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
		}
		return;
	}
	public function printPdfAcara($pdfKode=0){
		if(!$this->prosesOpen) exit("anda tidak memiliki izin membuka ini");
		$this->loadLib("FPDF/Printcontrol"); $printControl = new Printcontrol();
		$this->loadLib("Datejaservfilter"); $dateJaservFilter = new Datejaservfilter();
		$this->loadLib("ControlDosen");
		$this->loadLib("ControlMahasiswa");
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
		$tanggal = $dateJaservFilter->setDate(date("Y-m-d"),true)->getDate("VDD WMM Y",false);
		$TEMP_ARRAY['namaPeserta'] = $tempObjectDB->getNama();
		$TEMP_ARRAY['nimPeserta'] = $tempObjectDB->getNim();
		$TEMP_ARRAY['tanggalTerbit'] = $tanggal;
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk, $this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()) exit("0data tidak ditemukan");
		$TEMP_ARRAY['judulTAPeserta'] = $tempObjectDBD->getJudulTA();
		$TEMP_ARRAY["tempat"]= "Ruang Seminar TA 1";
		$controlDosen = new ControlDosen($this->gateControlModel);
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		$tempDosbing->getNextCursor();
		$tempObjectDB = $controlDosen->getAllData($tempDosbing->getDosen());
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
		$TEMP_ARRAY['moderator'] = $tempObjectDB->getNama();
		$TEMP_ARRAY['moderatorNip'] = $tempObjectDB->getNip();
		
		//exit($pdfKode);
		switch(intval($pdfKode)){
			case 22 :
			case 23 :
				if($this->kodeForm != 5) exit("anda tidak memiliki izin membuka ini"); 
				$tempObjectDB = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
				$tempObjectDB->getNextCursor();
				$TEMP_ARRAY["hariTanggal"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD / VDD WMM Y",false);
				$TEMP_ARRAY["hari"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD, VDD WMM Y",false);
				$TEMP_ARRAY["dayStartPeserta"] = "";
				$TEMP_ARRAY["prodiPeserta"] = "Ilmu Komputer / Informatika";
				$TEMP_ARRAY["jam"] = "Pukul ".$this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("H:i")." WIB";
				switch($tempObjectDB->getRuang()){
					case '1' : $TEMP_ARRAY["tempat"]= "Ruang Seminar TA 1 Informatika"; break;
					case '2' : $TEMP_ARRAY["tempat"]= "Ruang Sidang TA 2 Informatika"; break;
					case '3' : $TEMP_ARRAY["tempat"]= "Ruang Sidang Matematika"; break;
					case '4' : $TEMP_ARRAY["tempat"]= "Ruang Puspital"; break;
				}
				$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getDosenS());
				$tempObjectDBT->getNextCursor();
				$TEMP_ARRAY['ketua'] = $tempObjectDBT->getNama();
				$TEMP_ARRAY['nip'] = $tempObjectDBT->getNip();
				$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getDosenD());
				$tempObjectDBT->getNextCursor();
				$TEMP_ARRAY['sekertaris'] = $tempObjectDBT->getNama();
				$TEMP_ARRAY['sekertarisNip'] = $tempObjectDBT->getNip();
				if(strlen($tempObjectDB->getDosenT()) == 29){
					$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getDosenT());
					$tempObjectDBT->getNextCursor();
					$TEMP_ARRAY['sekertariss'] = $tempObjectDBT->getNama();
					$TEMP_ARRAY['sekertarissNip'] = $tempObjectDBT->getNip();
				}else{
					$TEMP_ARRAY['sekertariss'] = "*";
					$TEMP_ARRAY['sekertarissNip'] = "*";
				}
				if($this->kodeForm != 5) exit("anda tidak memiliki izin membuka ini"); 
				break;
			case 21 :
				if($this->kodeForm != 1) exit("anda tidak memiliki izin membuka ini"); 
				break;
			case 20 :
				if($this->kodeForm != 3) exit("anda tidak memiliki izin membuka ini"); 
				$tempObjectDB = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
				$tempObjectDB->getNextCursor();
				$TEMP_ARRAY["hariTanggal"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD / VDD WMM Y",false);
				$TEMP_ARRAY["prodiPeserta"] = "Ilmu Komputer / Informatika";
				$TEMP_ARRAY["jam"] = "Pukul ".$this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("H:i")." WIB";
				
				break;
			case 25 :
				if($this->kodeForm != 3) exit("anda tidak memiliki izin membuka ini"); 
				$tempObjectDB = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
				$tempObjectDB->getNextCursor();
				$TEMP_ARRAY["hariTanggal"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD / VDD WMM Y",false);
				$TEMP_ARRAY["hari"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD, VDD WMM Y",false);
				$TEMP_ARRAY["dayStartPeserta"] = "";
				$TEMP_ARRAY["prodiPeserta"] = "Ilmu Komputer / Informatika";
				switch($tempObjectDB->getRuang()){
					case '1' : $TEMP_ARRAY["tempat"]= "Ruang Seminar TA 1 Informatika"; break;
					case '2' : $TEMP_ARRAY["tempat"]= "Ruang Sidang TA 2 Informatika"; break;
					case '3' : $TEMP_ARRAY["tempat"]= "Ruang Sidang Matematika"; break;
					case '4' : $TEMP_ARRAY["tempat"]= "Ruang Puspital"; break;
				}
				$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getDosenS());
				$tempObjectDBT->getNextCursor();
				$TEMP_ARRAY['ketua'] = $tempObjectDBT->getNama();
				$TEMP_ARRAY['nip'] = $tempObjectDBT->getNip();
				$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getDosenD());
				$tempObjectDBT->getNextCursor();
				$TEMP_ARRAY['sekertaris'] = $tempObjectDBT->getNama();
				$TEMP_ARRAY['sekertarisNip'] = $tempObjectDBT->getNip();
				if(strlen($tempObjectDB->getDosenT()) == 29){
					$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getDosenT());
					$tempObjectDBT->getNextCursor();
					$TEMP_ARRAY['sekertariss'] = $tempObjectDBT->getNama();
					$TEMP_ARRAY['sekertarissNip'] = $tempObjectDBT->getNip();
				}else{
					$TEMP_ARRAY['sekertariss'] = "*";
					$TEMP_ARRAY['sekertarissNip'] = "*";
				}
				break;
			break;
			default :
			exit("0data tidak ditemukan");
			break;
		}
		$this->loadLib("ControlKoordinator");
		$tempObjectDB = (new ControlKoordinator($this->gateControlModel))->getDataByStatus();
		$tempObjectDB->getNextCursor();
		$tempObjectDB = $controlDosen->getAllData($tempObjectDB->getDosenK());
		$tempObjectDB->getNextCursor();
		$TEMP_ARRAY['namaKoor'] = $tempObjectDB->getNama();
		$TEMP_ARRAY['nipKoor'] = $tempObjectDB->getNip();
		
		switch($pdfKode){
			case 21 :
			$this->printcontrol->printFUJ21($TEMP_ARRAY);
			break;
			case 20 :
			$this->printcontrol->printFUJ20($TEMP_ARRAY);
			break;
			case 25 :
			$this->printcontrol->printFUJ25($TEMP_ARRAY);
			break;
			case 22 :
			$this->printcontrol->printFUJ22($TEMP_ARRAY);
			break;
			case 23 :
			$this->printcontrol->printFUJ23($TEMP_ARRAY);
			break;
			default :
			exit("0data tidak ditemukan");
			break;
		}
	}
	public function setSeminarTA2(){
		if(!$this->prosesOpen){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
			return;
		}
		if($this->kodeForm != 1){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
			return;
		}
		$temp = $this->setSeminarTA2Proses(array("kartbim"=>"s-k-bimbingan"));
		if(!$temp[0]){
			exit("0".$temp[1]);
		}
		echo "1";
		$this->load->view("Bodyright/Classroom/Successregistrasi",array("data"=> "Terima kasih, Data Anda berhasil dimasukan")); 
		return;
	}
	public function getJSONDataSeminarTA2(){
		if(!$this->prosesOpen){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
			return;
		}
		if($this->kodeForm != 3){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
			return;
		}
		
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlSidang');
/* 		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel); */
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		/* $tasD = $controlAdmin->getTADurasi(1);
		$tadD = $controlAdmin->getTADurasi(2); */
		$this->loadLib('ControlTime');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlPinjam');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('Datejaservfilter');
		$dateJaservFilter = new Datejaservfilter();
		$controlSeminar = new ControlSeminar($this->gateControlModel);
		$controlSidang = new ControlSidang($this->gateControlModel);
		$controlAcara = new ControlAcara($this->gateControlModel);
		$controlPinjam = new ControlPinjam($this->gateControlModel);
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempObjectDBs = $controlSeminar->getAllDataHaveATimeWithMahasiswa($tahunAk);
		$data[1]['kode'] = false;
		$i=0;
		$data[1]['lengths']=0;
		$data[2]['lengths']=0;
		$data[3]['lengths']=0;
		$data[4]['lengths']=0;
		if($tempObjectDBs){
			$data[1]['kode'] = true;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$tempObjectDBD = $tempObjectDBs->getTableStack(1);
				$data[1][$i]['nama'] = "Pelakasaan seminar proposal";
				$data[1][$i]['contact'] = $tempObjectDBD->getNama()." (".$tempObjectDBD->getNoHp().")";
				$data[1][$i]['namaAcara'] = "Seminar TA 1";
				$data[1][$i]['tanggal'] = $tempObjectDB->getWaktu();
				$data[1][$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
				if(intval($tempObjectDB->getDataProses()) == 2)
					$data[1][$i]['status'] = 'Disetujui';	
				else
					$data[1][$i]['status'] = "Menunggu";	
				$data[1]['lengths'] += 1;
				$i++;	
			}
		}
		
		for($j=1; $j<=4;$j++){
			if($j != 1){
				$i=0;
				$data[$j]['kode'] = false;
			}
			//$this->load->library('admin');
			
			
			
			
			$tempObjectDBs = $controlSidang->getAllDataHaveATimeWithMahasiswa($tahunAk,$j);
			if($tempObjectDBs){
				$data[$j]['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempObjectDBD = $tempObjectDBs->getTableStack(1);
					$data[$j][$i]['nama'] = "Pelaksaan Sidang Laporan";
					$data[$j][$i]['contact'] = $tempObjectDBD->getNama()." (".$tempObjectDBD->getNoHp().")";
					$data[$j][$i]['namaAcara'] = "Sidang TA 2";
					$data[$j][$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$j][$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
					if(intval($tempObjectDB->getDataProsesD()) == 2)
						$data[$j][$i]['status'] = 'Disetujui';	
					else
						$data[$j][$i]['status'] = "Menunggu";	
					$data[$j]['lengths'] += 1;
					$i++;	
				}
			}
			$tempObjectDB = $controlAcara->getAllData($tahunAk,$j);
			if($tempObjectDB){
				$data[$j]['kode'] = true;
				while($tempObjectDB->getNextCursor()){
					$data[$j][$i]['nama'] = $tempObjectDB->getDetail();
					$data[$j][$i]['namaAcara'] = "Acara Lain";
					$data[$j][$i]['contact'] = "Admin Departemen";
					$data[$j][$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$j][$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$j][$i]['status'] = "Disetujui";
					$data[$j]['lengths'] += 1;
					$i++;
				}
			}
			$tempObjectDBs = $controlPinjam->getAllData($tahunAk,$j,null, true);
			if($tempObjectDBs){
				$data[$j]['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempObjectDBn = $tempObjectDBs->getTableStack(1);
					$data[$j][$i]['nama'] = $tempObjectDB->getDetail();
					$data[$j][$i]['namaAcara'] = "Peminjam ruang";
					$data[$j][$i]['contact'] = $tempObjectDBn->getNama()." (".$tempObjectDBn->getNoHp().")";
					$data[$j][$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$j][$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$j][$i]['status'] = "Disetujui";
					$data[$j]['lengths'] += 1;
					$i++;
				}
			}
		}
		$data['content'] = $j-1;
		echo "1".json_encode($data);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function setSeminarTA2next(){
		if(!$this->prosesOpen){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
			return;
		}
		if($this->kodeForm != 3){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
			return;
		}
		$ruangan = $this->isNullPost('s-k-ruangan');
		$tanggal = $this->isNullPost('s-k-tanggal');
		$temp = $this->getCheck($ruangan,$tanggal,true);
		if(!$temp[0]){
			exit("0".$temp[1]);
		}
		switch($ruangan){
			case 'TA1' : $ruangan = 1; break;
			case 'TA2' : $ruangan = 2; break;
			case 'MAT' : $ruangan = 3; break;
			case 'PUS' : $ruangan = 4; break;
		}
		if($this->dateJaservFilter->nice_date($tanggal,"Y-m-d H:i:s") == "Invalid Date"){
			exit("0Format Tanggal tidak didukung");
		}
		$tanggal = $this->dateJaservFilter->nice_date($tanggal,"Y-m-d H:i:s");
		//exit("0".$ruangan." ".$tanggal);
		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$taDDurasi = $controlAdmin->getTADurasi(2);
		$temp = $this->setSeminarTA2nextProcess(array(
			'fuj20'=>"s-k-fuj20",
			'fuj25'=>"s-k-fuj25",
			'transkrip'=>"s-k-transkrip",
			'toefl'=>"s-k-toefl",
			'krs'=>"s-k-krs",
			'kartbim'=>"s-k-bimbingan",
			'ruang'=>$ruangan,
			'tanggal'=>$tanggal,
			'tanggalend'=>$this->dateJaservFilter->setDate($tanggal,true)->setPlusOrMinMinute($taDDurasi,true)->getDate("Y-m-d H:i:s")
		));
		if(!$temp[0]){
			exit("0".$temp[1]);
		}
		echo "1";
		$this->load->view("Bodyright/Classroom/Successregistrasi",array("data"=> "Terima kasih, Data Anda berhasil dimasukan")); 
	}
	protected function setSeminarTA2nextProcess($tempArray){
		$tempObjectDB = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive(),null);
		$NUM = $tempObjectDB->getCountData()-1;
		$tempObjectDB = $this->controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$tempObjectDBD = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());

		if(!$tempObjectDBD->getNextCursor()) return array(false,"anda belum mendaftar sidang");
		$this->load->library('Upload');
		$conPdf['upload_path'] = './upload/seminarta/seminarta2/pdf/';
		$conPdf['allowed_types'] = 'pdf';
		$conPdf['overwrite'] = true;
		$conPdf['remove_spaces'] = true;
		$conPdf['max_size'] = 1024;
		//fuj20
		$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDB->getNim()."-".$NUM."-fuj20";
		$this->upload->initialize($conPdf);
		if(!$this->upload->do_upload($tempArray['fuj20'])){
			return array(false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$fujdp = $this->upload->data('file_name');
		//fuj25
		$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDB->getNim()."-".$NUM."-fuj25";
		$this->upload->initialize($conPdf);
		if(!$this->upload->do_upload($tempArray['fuj25'])){
			return array(false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$fujdl = $this->upload->data('file_name');
		//transkrip
		$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDB->getNim()."-".$NUM."-trans";
		$this->upload->initialize($conPdf);
		if(!$this->upload->do_upload($tempArray['transkrip'])){
			return array(false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$transkrip = $this->upload->data('file_name');
		//toefl
		$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDB->getNim()."-".$NUM."-toefl";
		$this->upload->initialize($conPdf);
		if(!$this->upload->do_upload($tempArray['toefl'])){
			return array(false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$toefl = $this->upload->data('file_name');
		//krs
		$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDB->getNim()."-".$NUM."-krs";
		$this->upload->initialize($conPdf);
		if(!$this->upload->do_upload($tempArray['krs'])){
			return array(false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$krs = $this->upload->data('file_name');
		//kartu bimbingan
		$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDB->getNim()."-".$NUM."-karbi";
		$this->upload->initialize($conPdf);
		if(!$this->upload->do_upload($tempArray['kartbim'])){
			return array(false, 'file yang di dupload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		//check before save it, about validity

		if(!$this->dateJaservFilter->setDate($tempArray['tanggal'])){
			exit('0Tanggal tidak valid');
		}
		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$tempStart = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
		$this->dateJaservFilter->setPlusOrMinMinute($controlAdmin->getTADurasi(2));
		$tempEnd = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
		$tempResult = $controlAdmin->isAvailableRoomOnThisSemester($tempStart,$tempEnd,NULL,$tempArray['ruang'],1);
		if(!$tempResult[0]){
			return array(false,"seseorang mendahului anda, reload halaman");
		}
		
		//set data
		
		$kartbim = $this->upload->data('file_name');
		
		$tempObjectDBD->setFujDP($fujdp);
		$tempObjectDBD->setFujDL($fujdl);
		$tempObjectDBD->setToefl($toefl);
		$tempObjectDBD->setNamaKRS($krs);
		$tempObjectDBD->setKarBim($kartbim);
		$tempObjectDBD->setNamaTranskrip($transkrip);
		$tempObjectDBD->setRuang($tempArray['ruang']);
		$tempObjectDBD->setWaktu($tempArray['tanggal']);
		$tempObjectDBD->setWaktuEnd($tempArray['tanggalend']);
		//exit("0okay".$tempObjectDB->getCaseData());
		if($this->controlSidang->tryUpdate($tempObjectDBD)){
			return array(true,'Data berhasil dimasukan');
		}
		return array(false,'Data gagal dimasukan');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//<<--DISABLE
	public function setSeminarTA2next2(){
		exit("this link has been disabled for developer");
		if(!$this->prosesOpen){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Classroom_room/Body_right/warning-no-button-seminar-ta",$DATA);
			exit();
		}
		if($this->kodeForm != 5){
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 2, dikarenakan anda sudah pernah registrasi. atau anda bukan mahasiswa aktif. Terima kasih";
			echo "03";
			$this->load->view("Classroom_room/Body_right/warning-no-button-seminar-ta",$DATA);
			exit();
		}
		$temp = $this->mahasiswa->setSeminarTA2next2(array(
			'kartbim'=>"s-k-bimbingan",
			'kartbim'=>"s-k-peserta"
		));
		if(!$temp[0]){
			exit("0".$temp[1]);
		}
		echo "1";
		$this->load->view("Classroom_room/Body_right/success_registrasi",array("data"=> "Terima kasih, Data Anda berhasil dimasukan")); 
	}
	//<<--
	public function getCheck($variabel=null,$value=null,$type=false){
		/* $_POST['variabel']="TA2";
		$_POST['value']="2017-04-22 10:00:00"; */
		if($variabel == null){
			$this->isNullPost('variabel');
			$variabel = $this->input->post('variabel');
			$variabel.="";
		}
		if($value == null){
			$this->isNullPost('value');
			$value = $this->input->post('value');
		}
		//exit("0".$variabel." ".$value);
		$value.="";
		if(!$this->dateJaservFilter->setDate($value)){
			exit('0Tanggal tidak valid');
		}
		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$START = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
		switch ($variabel){
			case 'TA1' : 
				$this->dateJaservFilter->setPlusOrMinMinute($controlAdmin->getTADurasi(2));
				$END = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
				if($type)
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,1,1);
				else
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,1,0);
				break;
			case 'TA2' : 
				$this->dateJaservFilter->setPlusOrMinMinute($controlAdmin->getTADurasi(2));
				$END = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
				if($type)
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,2,1);
				else
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,2,0);
				break;
			case 'MAT' : 
				$this->dateJaservFilter->setPlusOrMinMinute($controlAdmin->getTADurasi(2));
				$END = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
				if($type)
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,3,1);
				else
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,3,0);
				break;
			case 'PUS' : 
				$this->dateJaservFilter->setPlusOrMinMinute($controlAdmin->getTADurasi(2));
				$END = $this->dateJaservFilter->getDate("Y-m-d H:i:s");
				if($type)
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,4,1);
				else
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,4,0);
				break;
			default :
				if($type)
					return array(false,"kode tidak valid");
				else
					echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
	
}