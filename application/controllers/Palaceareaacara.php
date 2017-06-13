<?php
if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
dependencies:
-LoginFilter
-Admin
-Inputjaservfilter
-Datejaservfilter
-ControlAcara
-ControlAdmin
-ControlMahasiswa
-ControlSeminar
-ControlSidang
-ControlTime
-GateControlModel
*/
/*
ControlDosen
ControlRegistrasi
*/
class Palaceareaacara extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('Aktor/Admin');
		$this->load->library('Session');
		$this->loadLib('Datejaservfilter');
		$this->loadLib('Inputjaservfilter');
		$this->dateJaservFilter = new Datejaservfilter();
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->loadLib('LoginFilter');
		$this->loadMod('GateControlModel');
		$this->gateControlModel = new GateControlModel();
		$this->loginFilter = new LoginFilter($this->session);
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->admin))
			redirect(base_url().'Gateinout.jsp');
	}
	//layout for acara bagi admin
	public function getLayoutAreaAcara(){
		echo "1";
		$this->load->view("Bodyright/Palaceroom/Areaacara");
	}
	//Optimized
	//memeperoleh eegala macam kegiatan dari ruang Sidang TA 1
	public function getJSONAcaraRuangTA1(){
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$data['kode'] = false;
		$i=0;
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempAdmin = (new ControlAdmin($this->gateControlModel))->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$tempAdmin->getNextCursor();
		$semester = 1;
		$tahun = 2014;
		while(intval($tahun."".$semester) <= intval($tahunAk)){
			$tempTahunAk = $tahun."".$semester;
			//your kode
			$tempObjectDBs =(new ControlSeminar($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tempTahunAk);
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempMahasiswa = $tempObjectDBs->getTableStack(1);
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempMahasiswa->getNextCursor();
					$data[$i]['nama'] = $tempMahasiswa->getNama();
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
					
					$STATE="TS";
					$data[$i]['id'] = $STATE."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu())."1_".$tempMahasiswa->getNim();
					$i++;
				}
				
			}
			
			$tempObjectDB = (new ControlAcara($this->gateControlModel))->getAllData($tempTahunAk,"1");
			if($tempObjectDB->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDB->getNextCursor()){
					$data[$i]['nama'] = $tempObjectDB->getDetail();
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs =(new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tempTahunAk,"1");
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempMahasiswa = $tempObjectDBs->getTableStack(1);
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$data[$i]['nama'] = $tempMahasiswa->getNama();
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
					$data[$i]['ketua'] = "";
					$data[$i]['pengujis'] = "";
					$data[$i]['pengujid'] = "";
					$data[$i]['pengujit'] = "";
					if(strlen($tempObjectDB->getDosenS()) == 40){
						$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenS());
						if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
							$data[$i]['ketua'] = $tempObjectDBE->getNip();
						}
					}
					if(strlen($tempObjectDB->getDosenD()) == 40){
						$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenD());
						if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
							$data[$i]['pengujis'] = $tempObjectDBE->getNip();
						}
					}
					if(strlen($tempObjectDB->getDosenT()) == 40){
						$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenT());
						if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
							$data[$i]['pengujid'] = $tempObjectDBE->getNip();
						}
					}
					$tempObjectDBEs = $controlRegistrasi->getAllDataWithDosbing($tempObjectDB->getTahunAk(),$tempObjectDB->getMahasiswa());
					if($tempObjectDBEs && $tempObjectDBEs->getNextCursor()){
						$tempObjectDBL = $tempObjectDBEs->getTableStack(2);
						if($data[$i]['pengujid'] == ""){
							$data[$i]['pengujid'] = $tempObjectDBL->getNip();
						}else{
							$data[$i]['pengujit'] = $tempObjectDBL->getNip();
						}
					}
					$STATE="TD";
					$data[$i]['id'] = $STATE."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu())."2_".$tempMahasiswa->getNim();
					$i++;
				}
				
			}
			//end of kode
			if($semester == 1){
				$semester = 2;
			}else{
				$semester = 1;
				$tahun += 1;
			}
		}
		$data['content'] = $i;
		echo "1".json_encode($data);
	}
	//Optimized
	//memeperoleh eegala macam kegiatan dari ruang Sidangg TA 2
	public function getJSONAcaraRuangTA2(){
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$data['kode'] = false;
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempAdmin = (new ControlAdmin($this->gateControlModel))->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$tempAdmin->getNextCursor();
		$i=0;
		$semester = 1;
		$tahun = 2014;
		while(intval($tahun."".$semester) <= intval($tahunAk)){
			$tempTahunAk = $tahun."".$semester;
			//your kode
			
			$tempObjectDB = (new ControlAcara($this->gateControlModel))->getAllData($tempTahunAk,"2");
			if($tempObjectDB->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDB->getNextCursor()){
					$data[$i]['nama'] = $tempObjectDB->getDetail();
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs =(new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tempTahunAk,"2");
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempMahasiswa = $tempObjectDBs->getTableStack(1);
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$data[$i]['nama'] = $tempMahasiswa->getNama();
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->setPlusOrMinMinute($tempAdmin->getTaDDurasi(),true)->getDate("Y-m-d H:i:s");
					$data[$i]['ketua'] = "";
					$data[$i]['pengujis'] = "";
					$data[$i]['pengujid'] = "";
					$data[$i]['pengujit'] = "";
					if(strlen($tempObjectDB->getDosenS()) == 40){
						$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenS());
						if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
							$data[$i]['ketua'] = $tempObjectDBE->getNip();
						}
					}
					if(strlen($tempObjectDB->getDosenD()) == 40){
						$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenD());
						if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
							$data[$i]['pengujis'] = $tempObjectDBE->getNip();
						}
					}
					if(strlen($tempObjectDB->getDosenT()) == 40){
						$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenT());
						if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
							$data[$i]['pengujid'] = $tempObjectDBE->getNip();
						}
					}
					$tempObjectDBE = $controlRegistrasi->getAllDataWithDosbing($tempObjectDB->getTahunAk(),$tempObjectDB->getMahasiswa());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$tempObjectDBL = $tempObjectDBE->getTableStack(2);
						if($data[$i]['pengujid'] == ""){
							$data[$i]['pengujid'] = $tempObjectDBL->getNip();
						}else{
							$data[$i]['pengujit'] = $tempObjectDBL->getNip();
						}
					}
					$STATE="TD";
					$data[$i]['id'] = $STATE."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu())."2_".$tempMahasiswa->getNim();
					$i++;
				}
				
			}
			//end of kode
			if($semester == 1){
				$semester = 2;
			}else{
				$semester = 1;
				$tahun += 1;
			}
		}
		$data['content'] = $i;
		echo "1".json_encode($data);
	}
	//Optimized
	//memeperoleh eegala macam kegiatan dari ruang sidang matematika yang terdata pada sistem
	public function getJSONAcaraRuangTAM(){
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$data['kode'] = false;
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempAdmin = (new ControlAdmin($this->gateControlModel))->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$tempAdmin->getNextCursor();
		//$this->load->model("sc_arte");
		$i=0;
		$tempObjectDB = (new ControlAcara($this->gateControlModel))->getAllData($tahunAk,"3");
		if($tempObjectDB->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDB->getNextCursor()){
				$data[$i]['nama'] = $tempObjectDB->getDetail();
				$data[$i]['tanggal'] = $tempObjectDB->getMulai();
				$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
				$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
				$i++;
			}
		}
		$tempObjectDBs =(new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tahunAk,"3");
		if($tempObjectDBs->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDBs->getNextCursor()){
				$tempMahasiswa = $tempObjectDBs->getTableStack(1);
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$data[$i]['nama'] = $tempMahasiswa->getNama();
				$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
				$data[$i]['endTanggal'] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->setPlusOrMinMinute($tempAdmin->getTaDDurasi(),true)->getDate("Y-m-d H:i:s");
				$data[$i]['ketua'] = "";
				$data[$i]['pengujis'] = "";
				$data[$i]['pengujid'] = "";
				$data[$i]['pengujit'] = "";
				if(strlen($tempObjectDB->getDosenS()) == 40){
					$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenS());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$data[$i]['ketua'] = $tempObjectDBE->getNip();
					}
				}
				if(strlen($tempObjectDB->getDosenD()) == 40){
					$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenD());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$data[$i]['pengujis'] = $tempObjectDBE->getNip();
					}
				}
				if(strlen($tempObjectDB->getDosenT()) == 40){
					$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenT());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$data[$i]['pengujid'] = $tempObjectDBE->getNip();
					}
				}
				$tempObjectDBE = $controlRegistrasi->getAllDataWithDosbing($tempObjectDB->getTahunAk(),$tempObjectDB->getMahasiswa());
				if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
					$tempObjectDBL = $tempObjectDBE->getTableStack(2);
					if($data[$i]['pengujid'] == ""){
						$data[$i]['pengujid'] = $tempObjectDBL->getNip();
					}else{
						$data[$i]['pengujit'] = $tempObjectDBL->getNip();
					}
				}
				$STATE="TD";
				$data[$i]['id'] = $STATE."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu())."2_".$tempMahasiswa->getNim();
				$i++;
			}
			
		}
		$data['content'] = $i;
		echo "1".json_encode($data);
	}
	//Optimized
	//memeperoleh eegala macam kegiatan dari ruang puspital
	public function getJSONAcaraRuangPUS(){
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$data['kode'] = false;
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempAdmin = (new ControlAdmin($this->gateControlModel))->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$tempAdmin->getNextCursor();
		$i=0;
		$tempObjectDB = (new ControlAcara($this->gateControlModel))->getAllData($tahunAk,"4");
		if($tempObjectDB->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDB->getNextCursor()){
				$data[$i]['nama'] = $tempObjectDB->getDetail();
				$data[$i]['tanggal'] = $tempObjectDB->getMulai();
				$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
				$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
				$i++;
			}
		}
		$tempObjectDBs =(new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tahunAk,"4");
		if($tempObjectDBs->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDBs->getNextCursor()){
				$tempMahasiswa = $tempObjectDBs->getTableStack(1);
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$data[$i]['nama'] = $tempMahasiswa->getNama();
				$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
				$data[$i]['endTanggal'] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->setPlusOrMinMinute($tempAdmin->getTaDDurasi(),true)->getDate("Y-m-d H:i:s");
				$data[$i]['ketua'] = "";
				$data[$i]['pengujis'] = "";
				$data[$i]['pengujid'] = "";
				$data[$i]['pengujit'] = "";
				if(strlen($tempObjectDB->getDosenS()) == 40){
					$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenS());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$data[$i]['ketua'] = $tempObjectDBE->getNip();
					}
				}
				if(strlen($tempObjectDB->getDosenD()) == 40){
					$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenD());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$data[$i]['pengujis'] = $tempObjectDBE->getNip();
					}
				}
				if(strlen($tempObjectDB->getDosenT()) == 40){
					$tempObjectDBE = $controlDosen->getAllData($tempObjectDB->getDosenT());
					if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
						$data[$i]['pengujid'] = $tempObjectDBE->getNip();
					}
				}
				$tempObjectDBE = $controlRegistrasi->getAllDataWithDosbing($tempObjectDB->getTahunAk(),$tempObjectDB->getMahasiswa());
				if($tempObjectDBE && $tempObjectDBE->getNextCursor()){
					$tempObjectDBL = $tempObjectDBE->getTableStack(2);
					if($data[$i]['pengujid'] == ""){
						$data[$i]['pengujid'] = $tempObjectDBL->getNip();
					}else{
						$data[$i]['pengujit'] = $tempObjectDBL->getNip();
					}
				}
				$STATE="TD";
				$data[$i]['id'] = $STATE."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu())."2_".$tempMahasiswa->getNim();
				$i++;
			}
			
		}
		$data['content'] = $i;
		echo "1".json_encode($data);
	}
	//Optimized
	//memperoleh kode surat yang pernah dimasukan sebelumnya
	public function getKodeSurat(){
		$this->load->helper('url');
		$id = $this->isNullPost('idSurat');
		$this->loadLib("Aktor/Mahasiswa");
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		if(strlen($id) < 25) exit("anda melakukan debugging");
		$header = substr($id,0,2);
		$tempData = substr($id, 2, strlen($id)-2);
		$tempData = explode("_",$tempData);
		if(array_key_exists(0,$tempData)){
			$tahunAk = intval($tempData[0]);
			if($tahunAk < 20000 || $tahunAk > 99999) exit("anda melakukan debugging");
		}else exit("anda melakukan debugging");
		if(array_key_exists(1,$tempData)){
			$time = substr($tempData[1],0,strlen($tempData[1])-1);
			$time = $this->dateJaservFilter->nice_date($time,"Y-m-d H:i:s");
			if($time == "Invalid Date") exit("anda melakukan debugging");
		}else exit("anda melakukan debugging");
		if(array_key_exists(2,$tempData)){
			$nim = $tempData[2];
			if(!$mahasiswa->getCheckNim($nim,1)[0]) exit("anda melakukan debugging");
		}else exit("anda melakukan debugging");
		$dataId = $tempData[1][strlen($tempData[1])-1];
		$typeKode = null;
		if($header == "TD"){
			if($dataId != '2'){
				exit("anda melakukan debugging");
			}else{
				$typeKode = 2;
			}
		}else if($header == "TS"){
			if($dataId != '1'){
				exit("anda melakukan debugging");
			}else{
				$typeKode = 1;
			}
		}else{
			exit("anda melakukan debugging");
		}
		$this->loadLib("ControlMahasiswa");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) 
			exit("0error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=NIM-CODE-1'>NIM-CODE-1</a>");
		$tempControl;
		$dataKode = "SIDANG";
		if($typeKode == 1){
			$dataKode = "SEMINAR";
			$this->loadLib("ControlSeminar");
			$tempControl = new ControlSeminar($this->gateControlModel);
		}else{
			$this->loadLib("ControlSidang");
			$tempControl = new ControlSidang($this->gateControlModel);
		}
		$tempObjectDBE = $tempControl->getDataByMahasiswa($tahunAk, $tempObjectDB->getIdentified());
		if(!$tempObjectDBE || !$tempObjectDBE->getNextCursor()) 
			exit("0error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=".$dataKode."-CODE-1'>".$dataKode."-CODE-1</a>");
		if($typeKode == 1){
			echo "1".json_encode(array("nosuratundangan"=>$tempObjectDBE->getNoSuratUndangan()));
		}else{
			echo "1".json_encode(array("nosuratundangan"=>$tempObjectDBE->getNoSuratUndangan(),"nosurattugas"=>$tempObjectDBE->getNoSuratTugas()));
		}
		
	}
	//Optimized
	//print surat undangan untuk sidang maupun seminar, merupakan link yang tampak dari client
	public function getPrintOfThis(){
		$this->load->helper('url');
		$id = $this->isNullPost('idSurat');
		$this->loadLib("Aktor/Mahasiswa");
		$mahasiswa = new Mahasiswa($this->inputJaservFilter);
		if(strlen($id) < 25) exit("anda melakukan debugging");
		$header = substr($id,0,2);
		$tempData = substr($id, 2, strlen($id)-2);
		$tempData = explode("_",$tempData);
		if(array_key_exists(0,$tempData)){
			$tahunAk = intval($tempData[0]);
			if($tahunAk < 20000 || $tahunAk > 99999) exit("anda melakukan debugging");
		}else exit("anda melakukan debugging");
		if(array_key_exists(1,$tempData)){
			$time = substr($tempData[1],0,strlen($tempData[1])-1);
			$time = $this->dateJaservFilter->nice_date($time,"Y-m-d H:i:s");
			if($time == "Invalid Date") exit("anda melakukan debugging");
		}else exit("anda melakukan debugging");
		if(array_key_exists(2,$tempData)){
			$nim = $tempData[2];
			if(!$mahasiswa->getCheckNim($nim,1)[0]) exit("anda melakukan debugging");
		}else exit("anda melakukan debugging");
		$dataId = $tempData[1][strlen($tempData[1])-1];
		$typeKode = null;
		if($header == "TD"){
			if($dataId != '2'){
				exit("anda melakukan debugging");
			}else{
				$typeKode = 2;
			}
		}else if($header == "TS"){
			if($dataId != '1'){
				exit("anda melakukan debugging");
			}else{
				$typeKode = 1;
			}
		}else{
			exit("anda melakukan debugging");
		}
		$this->loadLib("ControlMahasiswa");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) 
			exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=NIM-CODE-1'>NIM-CODE-1</a>");
		$tempControl;
		$dataKode = "SIDANG";
		if($typeKode == 1){
			$suratundangan = $_POST['noSuratUnd'];
			if(!$this->kodeNoSuratFiltering($suratundangan)){
				exit("kode surat tidak valid");
			}
			$this->printDocumentSeminar(
				array(
					"mahasiswa" => $tempObjectDB,
					"tahunAk" => $tahunAk,
					'suratundangan'=>$suratundangan,
					'time' =>$time
				)
			);
		}else{
			$this->loadLib("Aktor/Dosen");
			$dosen = new Dosen($this->inputJaservFilter);
			$nip = $this->isNullPost('nip');
			if(!$dosen->getCheckNip($nip,1)[0]) exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=NIP-CODE-1'>NIP-CODE-1</a>");
			$surattugas = $_POST['noSuratTug'];
			$suratundangan = $_POST['noSuratUnd'];
			if(!$this->kodeNoSuratFiltering($suratundangan)){
				exit("kode surat tidak valid");
			}
			if(!$this->kodeNoSuratFiltering($surattugas)){
				exit("kode surat tugas tidak valid");
			}
			$this->printDocumentSidang(
				array(
					"mahasiswa" => $tempObjectDB,
					"tahunAk" => $tahunAk,
					'nip'=>$nip,
					'surattugas'=>$surattugas,
					'suratundangan'=>$suratundangan,
					'time' =>$time
				)
			);
		}
	}
	protected function kodeNoSuratFiltering($surat){
		if(!preg_match("#^[a-zA-Z0-9./ ]*$#",$surat))
			return false;
		else
			return true;
	}
	//Optimized
	//print surat undangan untuk seminar
	protected function printDocumentSeminar($data){
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlSeminar');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$controlSeminar = new ControlSeminar($this->gateControlModel);
		
		#sessionn registrasi
		$tempObjectDBs = $controlRegistrasi->getAllDataWithDosbing($data['tahunAk'],$data['mahasiswa']->getIdentified());
		if(!$tempObjectDBs || !$tempObjectDBs->getNextCursor()){
			exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=REGISTRASI-CODE-1'>REGISTRASI-CODE-1</a>");
		}
		
		$dosenPembimbing= $tempObjectDBs->getTableStack(2);
		$tempObjectDB= $tempObjectDBs->getTableStack(1);
		if(strlen($dosenPembimbing->getIdentified()) < 40 ) exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=REGISTRASI-CODE-2'>REGISTRASI-CODE-2</a>");
		#sessionn Sidang
		$tempObjectDBD = $controlSeminar->getDataByMahasiswa($data['tahunAk'],$data['mahasiswa']->getIdentified());
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=SEMINAR-CODE-1'>SEMINAR-CODE-1</a>");
		}
		if(
			$tempObjectDBD->getWaktu() != $data['time'] 
		|| 
			$tempObjectDBD->getWaktu() == ""
		|| 
			$data['time'] == ""
		|| 
			$data['time'] == " "
		) exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=SIDANG-CODE-2'>SIDANG-CODE-2</a>");
		$changeKode = false;
		if($tempObjectDBD->getNoSuratUndangan() != $data['suratundangan']){
			$tempObjectDBD->setNoSuratUndangan($data['suratundangan']);
			$changeKode = true;
		}
		if($changeKode){
			$controlSeminar->tryUpdate($tempObjectDBD);
		}
		#admin
		$tempAdmin = $controlAdmin->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$tempAdmin->getNextCursor();
		$typeKetua = true;
		if($tempAdmin->getKajur() == $dosenPembimbing->getIdentified()){
			$typeKetua = false;
		}
		
		$TEMP_ARRAY['dosenPembimbing'] = $dosenPembimbing->getNama();
		if($dosenPembimbing->getKelamin() == '0' || $dosenPembimbing->getKelamin() == '1'){
			$TEMP_ARRAY['kelamin'] = "Bapak";
		}else{
			$TEMP_ARRAY['kelamin'] = "Ibu";
		}
		if($typeKetua){
			$TEMP_ARRAY['statusPenandaTangan']="Ketua";
			$dosPenS = $controlDosen->getAllData($tempAdmin->getKajur());
			$dosPenS->getNextCursor();
			$TEMP_ARRAY["penandaTangan"]= $dosPenS->getNama();
			$TEMP_ARRAY["nipPenandaTangan"]=$dosPenS->getNip();
		}else{
			$TEMP_ARRAY['statusPenandaTangan']="Wakil";
			$dosPenS = $controlDosen->getAllData($tempAdmin->getWakil());
			$dosPenS->getNextCursor();
			$TEMP_ARRAY["penandaTangan"]= $dosPenS->getNama();
			$TEMP_ARRAY["nipPenandaTangan"]=$dosPenS->getNip();
		}
		$TEMP_ARRAY['namaPeserta'] = $data['mahasiswa']->getNama();
		$TEMP_ARRAY['nimPeserta'] = $data['mahasiswa']->getNim();
		$TEMP_ARRAY['kodeUndangan'] = $data['suratundangan'];
		$TEMP_ARRAY['judulTAPeserta'] = $tempObjectDB->getJudulTA();
		$TEMP_ARRAY['hariSeminar'] = $this->dateJaservFilter->setDate($tempObjectDBD->getWaktu(),true)->getDate("WDD / L WMM Y",false);
		$TEMP_ARRAY['jamSeminar'] = $this->dateJaservFilter->nice_date($tempObjectDBD->getWaktu(), "H:i")." - ".$this->dateJaservFilter->nice_date($tempObjectDBD->getWaktuEnd(), "H:i")." WIB";
		if($tempObjectDBD->getRuang() == '1'){
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Sidang 1, Lt.3, Gedung E, Departemen Ilmu Komputer / Informatika";
		}else if($tempObjectDBD->getRuang() == '1'){
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Sidang 2, Lt.3, Gedung E, Departemen Ilmu Komputer / Informatika";
		}else if($tempObjectDBD->getRuang() == '1'){
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Sidang 1, Lt.2, Gedung A, Departemen Matematika";
		}else{
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Puspital, Lt.3, Gedung E, Departemen Ilmu Komputer / Informatika";
		}
		$this->loadLib("FPDF/Printcontrol",true);
		$print = new Printcontrol();
		$print->printUndanganTAS($TEMP_ARRAY); 
	}
	//Optimized
	//print surat undangan untuk sidang
	protected function printDocumentSidang($data){
	
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlSidang');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$controlSeminar = new ControlSeminar($this->gateControlModel);
		$controlSidang = new ControlSidang($this->gateControlModel);
		
		$tempObjectDBDosenChoose = $controlDosen->getDataByNip($data['nip']);
		if(!$tempObjectDBDosenChoose || !$tempObjectDBDosenChoose->getNextCursor()){
			exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=NIP-CODE-1'>NIP-CODE-1</a>");
		}
		#sessionn registrasi
		$tempObjectDBs = $controlRegistrasi->getAllDataWithDosbing($data['tahunAk'],$data['mahasiswa']->getIdentified());
		if(!$tempObjectDBs || !$tempObjectDBs->getNextCursor()){
			exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=REGISTRASI-CODE-1'>REGISTRASI-CODE-1</a>");
		}
		$tempObjectDB = $tempObjectDBs->getTableStack(1);
		$dosenPembimbing = $tempObjectDBs->getTableStack(2);
		if(strlen($dosenPembimbing->getIdentified()) < 40 ) exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=REGISTRASI-CODE-2'>REGISTRASI-CODE-2</a>");
		#sessionn Sidang
		$tempObjectDBD = $controlSidang->getDataByMahasiswa($data['tahunAk'],$data['mahasiswa']->getIdentified());
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=SIDANG-CODE-1'>SIDANG-CODE-1</a>");
		}
		if(
			$tempObjectDBD->getWaktu() != $data['time'] 
		|| 
			$tempObjectDBD->getWaktu() == ""
		|| 
			$data['time'] == ""
		|| 
			$data['time'] == " "
		) exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=SIDANG-CODE-2'>SIDANG-CODE-2</a>");
		$changeKode = false;
		if($tempObjectDBD->getNoSuratTugas() != $data['surattugas']){
			$tempObjectDBD->setNoSuratTugas($data['surattugas']);
			$changeKode = true;
		}
		if($tempObjectDBD->getNoSuratUndangan() != $data['suratundangan']){
			$tempObjectDBD->setNoSuratUndangan($data['suratundangan']);
			$changeKode = true;
		}
		if($changeKode){
			$controlSidang->tryUpdate($tempObjectDBD);
		}
		#admin
		$tempAdmin = $controlAdmin->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$tempAdmin->getNextCursor();
		$typeKetua = true;
		#Dosen seksi
		$dosPenS = $controlDosen->getAllData($tempObjectDBD->getDosenS());
		$nipChoice = false;
		if($dosPenS && $dosPenS->getNextCursor()){
			$TEMP_ARRAY['pengujiS'] = $dosPenS->getNama();
			if($tempAdmin->getKajur() == $dosPenS->getIdentified()){
				$typeKetua = false;
			}
			if($dosPenS->getNip() == $data['nip']){
				$TEMP_ARRAY['kodeDosenYangDituju'] = 1;
				if($dosPenS->getKelamin() == '0' || $dosPenS->getKelamin() == '1'){
					$TEMP_ARRAY['kelamin'] = "Bapak";
				}else{
					$TEMP_ARRAY['kelamin'] = "Ibu";
				}
				$nipChoice=true;
			}
		}
		$dosPenS = $controlDosen->getAllData($tempObjectDBD->getDosenD());
		if($dosPenS && $dosPenS->getNextCursor()){
			$TEMP_ARRAY['pengujiD'] = $dosPenS->getNama();
			if($tempAdmin->getKajur() == $dosPenS->getIdentified()){
				$typeKetua = false;
			}
			if($dosPenS->getNip() == $data['nip']){
				$TEMP_ARRAY['kodeDosenYangDituju'] = 2;
				if($dosPenS->getKelamin() == '0' || $dosPenS->getKelamin() == '1'){
					$TEMP_ARRAY['kelamin'] = "Bapak";
				}else{
					$TEMP_ARRAY['kelamin'] = "Ibu";
				}
				$nipChoice=true;
			}
		}
		$dosPenS = $controlDosen->getAllData($tempObjectDBD->getDosenT());
		if($dosPenS && $dosPenS->getNextCursor()){
			$TEMP_ARRAY['pengujiT'] = $dosPenS->getNama();
			if($tempAdmin->getKajur() == $dosPenS->getIdentified()){
				$typeKetua = false;
			}
			if($dosPenS->getNip() == $data['nip']){
				$TEMP_ARRAY['kodeDosenYangDituju'] = 3;
				if($dosPenS->getKelamin() == '0' || $dosPenS->getKelamin() == '1'){
					$TEMP_ARRAY['kelamin'] = "Bapak";
				}else{
					$TEMP_ARRAY['kelamin'] = "Ibu";
				}
				$nipChoice=true;
			}
			$TEMP_ARRAY['pengujiE'] = $dosenPembimbing->getNama();
			if($tempAdmin->getKajur() == $dosenPembimbing->getIdentified()){
				$typeKetua = false;
			}
			if($dosenPembimbing->getNip() == $data['nip']){
				$TEMP_ARRAY['kodeDosenYangDituju'] = 4;
				if($dosenPembimbing->getKelamin() == '0' || $dosenPembimbing->getKelamin() == '1'){
					$TEMP_ARRAY['kelamin'] = "Bapak";
				}else{
					$TEMP_ARRAY['kelamin'] = "Ibu";
				}
				$nipChoice=true;
			}
		}else{
			if(strlen($dosenPembimbing->getIdentified()) == 40){
				$TEMP_ARRAY['pengujiT'] = $dosenPembimbing->getNama();
				if($tempAdmin->getKajur() == $dosenPembimbing->getIdentified()){
					$typeKetua = false;
				}
				if($dosenPembimbing->getNip() == $data['nip']){
					$TEMP_ARRAY['kodeDosenYangDituju'] = 3;
					if($dosenPembimbing->getKelamin() == '0' || $dosenPembimbing->getKelamin() == '1'){
						$TEMP_ARRAY['kelamin'] = "Bapak";
					}else{
						$TEMP_ARRAY['kelamin'] = "Ibu";
					}
					$nipChoice=true;
				}
			}
		}
		
		if(!$nipChoice) exit("error code <a href='".base_url()."c00a0fe01f87645da894a5c1033e39f4.php?key=NIP-CODE-3'>NIP-CODE-3</a>");
		if($typeKetua){
			$TEMP_ARRAY['statusPenandaTangan']="Ketua";
			$dosPenS = $controlDosen->getAllData($tempAdmin->getKajur());
			$dosPenS->getNextCursor();
			$TEMP_ARRAY["penandaTangan"]= $dosPenS->getNama();
			$TEMP_ARRAY["nipPenandaTangan"]=$dosPenS->getNip();
		}else{
			$TEMP_ARRAY['statusPenandaTangan']="Wakil";
			$dosPenS = $controlDosen->getAllData($tempAdmin->getWakil());
			$dosPenS->getNextCursor();
			$TEMP_ARRAY["penandaTangan"]= $dosPenS->getNama();
			$TEMP_ARRAY["nipPenandaTangan"]=$dosPenS->getNip();
		}
		$TEMP_ARRAY['namaPeserta'] = $data['mahasiswa']->getNama();
		$TEMP_ARRAY['nimPeserta'] = $data['mahasiswa']->getNim();
		$TEMP_ARRAY['kodeUndangan'] = $data['suratundangan'];
		$TEMP_ARRAY['kodeSuratTugas'] = $data['surattugas'];
		$TEMP_ARRAY['judulTAPeserta'] = $tempObjectDB->getJudulTA();
		$TEMP_ARRAY['hariSeminar'] = $this->dateJaservFilter->setDate($tempObjectDBD->getWaktu(),true)->getDate("WDD / L WMM Y",false);
		$TEMP_ARRAY['jamSeminar'] = $this->dateJaservFilter->nice_date($tempObjectDBD->getWaktu(), "H:i")." - ".$this->dateJaservFilter->nice_date($tempObjectDBD->getWaktuEnd(), "H:i")." WIB";
		if($tempObjectDBD->getRuang() == '1'){
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Sidang 1, Lt.3, Gedung E, Departemen Ilmu Komputer / Informatika";
		}else if($tempObjectDBD->getRuang() == '1'){
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Sidang 2, Lt.3, Gedung E, Departemen Ilmu Komputer / Informatika";
		}else if($tempObjectDBD->getRuang() == '1'){
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Sidang 1, Lt.2, Gedung A, Departemen Matematika";
		}else{
			$TEMP_ARRAY['tempatSeminar'] = "Ruang Puspital, Lt.3, Gedung E, Departemen Ilmu Komputer / Informatika";
		}
		$this->loadLib("FPDF/Printcontrol",true);
		$print = new Printcontrol();
		$print->printUndanganTAD($TEMP_ARRAY); 
	}
	//Optimized
	//menambahkan acara yang mendaftar melalui admin admin
	public function setNewAcara(){
		$namaAcara = $this->isNullPost('namaAcara');
		if(strlen($namaAcara) > 250)
		{
			exit("0Maaf jumlah karakter nama acara anda terlalu banyak");
		}
		$TEMP_ERROR = $this->inputJaservFilter->titleFiltering($namaAcara);
		if(!$TEMP_ERROR[0]){
			exit("0Format nama acara tidak valid");
		}
		$penanggung = $this->isNullPost('penanggung');
		if(strlen($penanggung) > 70)
		{
			exit("0Maaf jumlah karakter penangung jawab acara anda terlalu banyak");
		}
		$TEMP_ERROR = $this->inputJaservFilter->nameLevelFiltering($penanggung);
		if(!$TEMP_ERROR[0]){
			exit("0Format nama penanggung jawab tidak valid");
		}
		$ruang = $this->isNullPost('kode');
		switch($ruang){
			case 'TA1' :
			$ruang = 1;
			break;
			case 'TA2' :
			$ruang = 2;
			break;
			case 'TAM' :
			$ruang = 3;
			break;
			case 'PUS' :
			$ruang = 4;
			break;
			default :
			exit("0Maaf kode anda tidak valid");
			break;
		}
		$mulai = $this->dateJaservFilter->nice_date($this->isNullPost('startEvent'),"Y-m-d H:i:s");
		if($mulai == "Invalid Date"){
			exit("0Tanggal format tidak dipenuhi");
		}
		$berakhir = $this->dateJaservFilter->nice_date($this->isNullPost('endEvent'),"Y-m-d H:i:s");
		if($berakhir == "Invalid Date"){
			exit("0Tanggal format tidak dipenuhi");
		}
		if(!$this->dateJaservFilter->setDate($mulai,true)->isBefore($berakhir)) exit("0waktu mulai acara harus sebelum waktu akhir");
		if($this->dateJaservFilter->setDate($this->dateJaservFilter->nice_date($mulai,"Y-m-d"),true)->isBefore(date("Y-m-d"))) exit("0waktu mulai acara harus sebelum hari ini");
		
		$this->loadLib('ControlTime');
		$this->loadLib('ControlAdmin');
		
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		//exit("0Tanggal format tidak dipenuhi");
		$tempResult = (new ControlAdmin($this->gateControlModel))->isAvailableroomOnThisSemester($mulai,$berakhir,$tahunAk,$ruang,1);
		if($tempResult[0] == '0') exit("0".$tempResult[1]);
		
		
		
		$this->loadLib('ControlAcara');
		if((new ControlAcara($this->gateControlModel))->addAcara(array(
			'tahunak' => $tahunAk,
			'detail' => $namaAcara,
			'penanggungjawab' => $penanggung,
			'ruang' => $ruang,
			'mulai' => $mulai,
			'berakhir' => $berakhir
		))) exit("1Berhasil menambahkan data|".$tahunAk);
		exit("0terjadi kesalahan dalam menyimpan acara");
	}
	//optimized
	//get data of acara that has been add before
	public function getJSONDataAcara(){
		//$_POST['id'] ="AC20171_2017-06-13.09:17:001";
		$id = $this->isNullPost('id');
		
		$kode = substr($id,0,2);
		$tempString = substr($id,2,strlen($id)-2);
		$tempString = explode("_",$tempString);
		if(count($tempString) < 2 || count($tempString) > 2){
			exit("0data tidak ditemukan");
		}
		$tahunAk = intval($tempString[0]); //sudah di filter
		if($tahunAk < 10000 && $tahunAk > 99999){
			exit("D0data tidak ditemukan");
		}
		$ruang = intval($tempString[1][strlen($tempString[1])-1]); //sudah difilter
		$mulai = str_ireplace("."," ",substr($tempString[1],0,strlen($tempString[1])-1)); //sudah difilter
		if($this->dateJaservFilter->nice_date($mulai,"Y-m-d H:i:s") == 'Invalid Date'){
			exit("0data tidak ditemukan");
		}
		$mulai = $this->dateJaservFilter->nice_date($mulai,"Y-m-d H:i:s");
		if($ruang > 4 || $ruang < 1){
			exit("0data tidak ditemukan");
		}
		//echo $ruang." ".$mulai;
		$this->loadLib('ControlAcara');
		$tempObjectDB = (new ControlAcara($this->gateControlModel))->getAllData($tahunAk,$ruang,$mulai);
		if($tempObjectDB->getNextCursor()){	
			$data = array(
				'namaAcara' => $tempObjectDB->getDetail(),
				'responsive' => $tempObjectDB->getPenanggungJawab(),
				'start' => $this->dateJaservFilter->nice_date($tempObjectDB->getMulai(),"H:i"),
				'end' => $this->dateJaservFilter->nice_date($tempObjectDB->getBerakhir(),"H:i"),
			);
			echo "1".json_encode($data);	
		}else{		
			$data = array(
				'namaAcara' => "",
				'responsive' => "",
				'start' => $this->dateJaservFilter->nice_date(date("Y-m-d H:i:s"),"H:i"),
				'end' => $this->dateJaservFilter->nice_date(date("Y-m-d H:i:s"),"H:i"),
			);
			echo "0".json_encode($data);	
		}
	}
	//Optimized
	//menyimpan hasil perubahan acara yang pernah ditambahkan admin
	public function setUpdateAcara(){
		
		$id= $this->isNullPost('id'); //id
		
		$namaAcara = $this->isNullPost('namaAcara'); //nama acara
		if(strlen($namaAcara) > 250)
		{
			exit("0Maaf jumlah karakter nama acara anda terlalu banyak");
		}
		$TEMP_ERROR = $this->inputJaservFilter->titleFiltering($namaAcara);
		if(!$TEMP_ERROR[0]){
			exit("0Format nama acara tidak valid");
		}
		$penanggungjawab = $this->isNullPost('penanggung'); //penanggung
		if(strlen($penanggungjawab) > 70)
		{
			exit("0Maaf jumlah karakter penangung jawab acara anda terlalu banyak");
		}
		$TEMP_ERROR = $this->inputJaservFilter->nameLevelFiltering($penanggungjawab);
		if(!$TEMP_ERROR[0]){
			exit("0Format nama penanggung jawab tidak valid");
		}
		$startEvent = $this->dateJaservFilter->nice_date($this->isNullPost('startEvent'),"Y-m-d H:i:s"); //startEvent
		if($startEvent == "Invalid Date"){
			exit("0Tanggal format tidak dipenuhi");
		}
		$endEvent = $this->dateJaservFilter->nice_date($this->isNullPost('endEvent'),"Y-m-d H:i:s"); //endEvent
		if($endEvent == "Invalid Date"){
			exit("0Tanggal format tidak dipenuhi");
		}
		$kode = substr($id,0,2);
		$tempString = substr($id,2,strlen($id)-2);
		$tempString = explode("_",$tempString);
		if(count($tempString) < 2 || count($tempString) > 2){
			exit("0data tidak ditemukan");
		}
		$tahunAk = intval($tempString[0]); //sudah di filter
		if($tahunAk < 10000 && $tahunAk > 99999){
			exit("D0data tidak ditemukan");
		}
		$ruang = intval($tempString[1][strlen($tempString[1])-1]); //sudah difilter
		$mulai = str_ireplace("."," ",substr($tempString[1],0,strlen($tempString[1])-1)); //sudah difilter
		
		if($this->dateJaservFilter->nice_date($mulai,"Y-m-d H:i:s") == 'Invalid Date'){
			exit("0data tidak ditemukan");
		}
		$mulai = $this->dateJaservFilter->nice_date($mulai,"Y-m-d H:i:s");
		if($ruang > 4 || $ruang < 1){
			exit("0data tidak ditemukan");
		}
		if($this->dateJaservFilter->setDate($mulai,true)->isBefore(date("Y-m-d H:i:s"))){
			exit("0data tidak ditemukan");
		}
		if($this->dateJaservFilter->nice_date($startEvent,"Y-m-d") != $this->dateJaservFilter->nice_date($mulai,"Y-m-d")){
			exit("0data tidak ditemukan");
		}
		if($this->dateJaservFilter->nice_date($endEvent,"Y-m-d") != $this->dateJaservFilter->nice_date($mulai,"Y-m-d")){
			exit("0data tidak ditemukan");
		}
		$this->loadLib('ControlAcara');
		$controlAcara = new ControlAcara($this->gateControlModel);
		
		$tempObjectDB = $controlAcara->getAllData($tahunAk,$ruang,$mulai);
		if(!$tempObjectDB->getNextCursor()){
			exit('0data tidak ditemukan');
		}
		$tempObjectDB->setWhere(6);
		
		if($controlAcara->updateAcara(array(
			'tahunak'=>$tahunAk,
			'detail'=>$namaAcara,
			'ruang'=>$tempObjectDB->getRuang(),
			'penanggungjawab'=>$penanggungjawab,
			'mulai'=>$startEvent,
			'berakhir'=>$endEvent
		),$tempObjectDB)){
			exit("1Berhasil merubah acara");
		}
		exit('0terjadi kesalahan saat merubah acara');
	}
	//Optimized
	//menghapus acara yang pernah ditambahkan admin
	public function setDeleteOrRejected(){
		
		$id=$this->isNullPost('id');
		$kode = substr($id,0,2);
		$TEMP_STRING = substr($id,2,strlen($id)-2);
		$TEMP_STRING = explode("_",$TEMP_STRING);
		if(count($TEMP_STRING) < 2 || count($TEMP_STRING) > 3){
			exit("0data tidak ditemukan");
		}
		$SRT = intval($TEMP_STRING[0]); //sudah di filter
		if($SRT < 10000 && $SRT > 99999){
			exit("D0data tidak ditemukan");
		}
		$ROOM = intval($TEMP_STRING[1][strlen($TEMP_STRING[1])-1]); //sudah difilter
		$TANGGAL = str_ireplace("."," ",substr($TEMP_STRING[1],0,strlen($TEMP_STRING[1])-1)); //sudah difilter
		if(count($TEMP_STRING) == 3){
			$NIM = $TEMP_STRING[2]; 
			//$this->load->library("Mahasiswa");
			if(!$this->mahasiswa->getCheckNim($NIM,1)[0]){
				exit("0data tidak valid");
			}
		}
		if($this->dateJaservFilter->nice_date($TANGGAL,"Y-m-d H:i:s") == 'Invalid Date'){
			exit("0data tidak ditemukan");
		}
		$TANGGAL = $this->dateJaservFilter->nice_date($TANGGAL,"Y-m-d H:i:s");
		if($ROOM > 2 || $ROOM < 1){
			exit("0data tidak ditemukan");
		}
		
		switch($kode){
			case "TS" : 
		
			if($TEMP_REST[0]){
				exit("1Seminar berhasil ditolak");
			}else{
				exit("0Gagal melakukan Penolakan seminar");
			}
			break;
			case "TD" : 
			
			if($TEMP_REST[0]){
				exit("1Seminar berhasil ditolak");
			}else{
				exit("0Gagal melakukan Penolakan seminar");
			}
			break;
			case "AC" : 
			
			$this->loadLib('ControlAcara');
			if((new ControlAcara($this->gateControlModel))->deleteAcara(array("tahunak"=>$SRT, "mulai"=>$TANGGAL, "ruang"=>$ROOM))){
				exit("1Data acara berhasil dihapus");
			}else{
				exit("0Data acara gagal dihapus");
			}
			break;
			default :
			exit("0data tidak ditemukan");
		}
	}
}