<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencies :
-LoginFilter
-Mahasiswa
-GateControlModel
-ControlAcara
-ControlAdmin
-ControlDosen
-ControlKoordinator
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Classseminartas extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Aktor/Mahasiswa");
		$this->load->library('Session');
		$this->load->helper('url');
		$this->load->helper('html');
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
		$this->loadLib("ControlSidang");
		$this->loadLib("ControlAcara");
		$this->loadLib("ControlPinjam");
		$this->controlSeminar = new ControlSeminar($this->gateControlModel);
		$this->controlSidang = new ControlSidang($this->gateControlModel);
		$this->controlAcara = new ControlAcara($this->gateControlModel);
		$this->controlPinjam = new ControlPinjam($this->gateControlModel);
		if($errorProsesOpen == 0)
			$this->prosesOpen = true;
		
		$this->fuj11 = false;
		$this->fuj12 = false;
		$this->fuj13 = false;
		$this->fuj11U = true;
		$tempObjectDBD = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		if($tempObjectDBD && $tempObjectDBD->getNextCursor()){
			if(intval($tempObjectDBD->getRekomendasi()) == 1 && $tempObjectDBD->getWaktu() == "1000-01-01 00:00:00"){
				$this->fuj11 = true;
				$this->fuj11U = false;
				$this->kodeForm = 1;
			}else if(intval($tempObjectDBD->getRekomendasi()) == 1 && intval($tempObjectDBD->getDataProses()) == 3){
				$this->fuj11 = true;
				$this->fuj11U = false;
				$this->kodeForm = 1;
			}else{
				if(intval($tempObjectDBD->getDataProses()) == 1){
					$this->kodeForm = 2;
				}else if(intval($tempObjectDBD->getDataProses()) == 2){
					$this->kodeForm = 3;
					$this->fuj12 = true;
					$this->fuj13 = true;
				}else{
					if(intval($tempObjectDBD->getDataProses()) == 1)
						$this->fuj11U = false;
					$this->kodeForm = 1;
					$this->fuj11 = true;
				}
			}
		}else{
			$this->kodeForm = 1;
			$this->fuj11 = true;
		}
	}
	//show form
	public function index(){
		if($this->prosesOpen){
			switch($this->kodeForm){
				case 1 :
					if($this->fuj11U)
						echo "1A";
					else
						echo "0A";
					$data['fuj11U'] = $this->fuj11U;
					$this->load->view("Bodyright/Classroom/Seminartas/Langkahs",$data); 
					break;
				case 2 :
					echo "0B";
					$this->load->view("Bodyright/Classroom/Seminartas/Langkahd"); 
					break;
				case 3 :
					echo "0C";
					$this->load->view("Bodyright/Classroom/Seminartas/Alternateaction"); 
					break;
			}			
		}else{
			$DATA['message'] = "Anda tidak memiliki izin untuk registrasi seminar ta 1, dikarenakan anda sudah pernah, atau anda sudah harus lanjut ke seminar ta 2. Terima kasih";
			echo "03";
			$this->load->view("Bodyright/Classroom/Warningnobuttonseminarta",$DATA);
		}
	}
	public function getJSONDataSeminarTA1(){
		if(!$this->prosesOpen){
			exit();
		}
		$data['kode'] = false;
		$i=0;
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$taSDurasi = $controlAdmin->getTADurasi(1);
		$taDDurasi = $controlAdmin->getTADurasi(2);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$dateJaservFilter = new Datejaservfilter();
		$tempObjectDBs =$this->controlSeminar->getAllDataHaveATimeWithMahasiswa($this->tahunAk);
		if($tempObjectDBs->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$tempMahasiswa = $tempObjectDBs->getTableStack(1);
				$data[$i]['nama'] = "Pelakasaan seminar proposal";
				$data[$i]['contact'] = $tempMahasiswa->getNama()." (".$tempMahasiswa->getNoHp().")";
				$data[$i]['namaAcara'] = "Seminar TA 1";
				$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
				$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
				if($tempObjectDB->getDataProses() == 2)
					$data[$i]['status'] = "Disetujui";
				else if($tempObjectDB->getDataProses() == 1)
					$data[$i]['status'] = 'Menunggu';
				else
					$data[$i]['status'] = 'Ditolak';
				$i++;		
			}
		}
		$tempObjectDB = $this->controlAcara->getAllData($this->tahunAk,"1");
		if($tempObjectDB && $tempObjectDB->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDB->getNextCursor()){
				$data[$i]['nama'] = $tempObjectDB->getDetail();
				$data[$i]['namaAcara'] = "Acara Lain";
				$data[$i]['contact'] = "Admin Departemen";
				$data[$i]['tanggal'] = $tempObjectDB->getMulai();
				$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
				$data[$i]['status'] = "Disetujui";
				$i++;
			}
		}
		$tempObjectDBs = $this->controlPinjam->getAllData($this->tahunAk,"1",null,true);
		if($tempObjectDBs && $tempObjectDB->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$tempObjectDBn = $tempObjectDBs->getTableStack(1);
				$data[$i]['nama'] = $tempObjectDB->getDetail();
				$data[$i]['namaAcara'] = "peminjam ruang";
				$data[$i]['contact'] = $tempObjectDBn->getNama()." (".$tempObjectDBn->getNoHp().")";
				$data[$i]['tanggal'] = $tempObjectDB->getMulai();
				$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
				$data[$i]['status'] = "Disetujui";
				$i++;
			}
		}
		$tempObjectDBs = $this->controlSidang->getAllDataHaveATimeWithMahasiswa($this->tahunAk,"1");
		if($tempObjectDBs->getCountData() > 0){
			$data['kode'] = true;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$tempMahasiswa = $tempObjectDBs->getTableStack(1);
				$data[$i]['nama'] = "Pelaksaan Sidang Laporan";
				$data[$i]['namaAcara'] = "Sidang TA 2";
				$data[$i]['contact'] = $tempMahasiswa->getNama()." (".$tempMahasiswa->getNoHp().")";
				$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
				$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
				if(intval($tempObjectDB->getDataProsesD()) == 2)
					$data[$i]['status'] = "Disetujui";
				else if(intval($tempObjectDB->getDataProsesD()) == 1)
					$data[$i]['status'] = 'Menunggu';
				else
					$data[$i]['status'] = 'Ditolak';
				$i++;
			}
			
		}
		$data['content'] = $i;
		echo "1".json_encode($data);
	}
	public function printPdfAcara($pdfKode=0){
		if(!$this->prosesOpen) exit("anda tidak memiliki izin membuka ini");
		$this->loadLib("FPDF/Printcontrol"); $printControl = new Printcontrol();
		$this->loadLib("ControlDosen");
		$this->loadLib("ControlMahasiswa");
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
		$tanggal = $this->dateJaservFilter->setDate(date("Y-m-d"),true)->getDate("VDD WMM Y",false);
		$TEMP_ARRAY['namaPeserta'] = $tempObjectDB->getNama();
		$TEMP_ARRAY['nimPeserta'] = $tempObjectDB->getNim();
		$TEMP_ARRAY['tanggalTerbit'] = $tanggal;
		$tempObjectDB = $this->controlRegistrasi->getAllData($this->tahunAk, $this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
		$TEMP_ARRAY['judulTAPeserta'] = $tempObjectDB->getJudulTA();
		$TEMP_ARRAY["tempat"]= "Ruang Seminar TA 1";
		$controlDosen = new ControlDosen($this->gateControlModel);
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDB->getIdentified());
		$tempDosbing->getNextCursor();
		$tempObjectDB = $controlDosen->getAllData($tempDosbing->getDosen());
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
		$TEMP_ARRAY['moderator'] = $tempObjectDB->getNama();
		$TEMP_ARRAY['moderatorNip'] = $tempObjectDB->getNip();
		switch(intval($pdfKode)){
			case 11 :
				if($this->kodeForm != 1) exit("anda tidak memiliki izin membuka ini"); 
				
				break;
			case 12 :
				if($this->kodeForm != 3) exit("anda tidak memiliki izin membuka ini"); 
				$tempObjectDB = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
				if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
				$TEMP_ARRAY["hariTanggal"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD / VDD WMM Y",false);
				$TEMP_ARRAY["jam"] = "Pukul ".$this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("H:i")." WIB";
				$TEMP_ARRAY["prodiPeserta"] = "Departemen Ilmu Komputer / Informatika";
				break;
			case 13 :
				if($this->kodeForm != 3) exit("anda tidak memiliki izin membuka ini"); 
				$tempObjectDB = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
				if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) exit("0data tidak ditemukan");
				$TEMP_ARRAY["hariTanggal"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD / VDD WMM Y",false);
				$TEMP_ARRAY["hari"] = $this->dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("WDD, VDD WMM Y",false);
				$TEMP_ARRAY["prodiPeserta"] = "Departemen Ilmu Komputer / Informatika";
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
			case 11 :
			$this->printcontrol->printFUJ11($TEMP_ARRAY);
			break;
			case 12 :
			$this->printcontrol->printFUJ12($TEMP_ARRAY);
			break;
			case 13 :
			$this->printcontrol->printFUJ13($TEMP_ARRAY);
			break;
			default :
			exit("0data tidak ditemukan");
			break;
		}
	}
	protected function setSeminarTA1Proses($DATA_ARRAY){
		$tempObjectDB = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive(),null,null);
		$NUM = $tempObjectDB->getCountData();		
		//pdfConfig
		$conPdf['upload_path'] = './upload/seminarta/seminarta1/pdf/';
		$conPdf['allowed_types'] = 'pdf';
		$conPdf['overwrite'] = true;
		$conPdf['remove_spaces'] = true;
		$conPdf['max_size'] = 1024;
		//pngConfig
		$conPic['upload_path'] = './upload/seminarta/seminarta1/png/';
		$conPic['allowed_types'] = 'png|PNG';
		$conPic['overwrite'] = true;
		$conPic['remove_spaces'] = true;
		$conPic['max_size'] = 1024;
        $conPic['max_width'] = 1366;
        $conPic['max_height'] = 2556;
		
		$this->load->library('upload');
		$pengantar_upload_state = true;
		$tempObjectDB = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		$tempHaveTABefore = $tempObjectDB->getNextCursor();
		if($tempHaveTABefore){
			if($tempObjectDB->getRekomendasi() == 1){
				$pengantar_upload_state = false;
			}
		}
		$this->loadLib("ControlMahasiswa");
		$tempObjectDBD = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDBD->getNextCursor();
		$pengantar = "";
		if($pengantar_upload_state){
			$conPdf['file_name'] = $this->tahunAk."-".$tempObjectDBD->getNim()."-".$NUM."-pngtr";
			$this->upload->initialize($conPdf);
			if(!$this->upload->do_upload($DATA_ARRAY['pengantar'])){
				return array( false, 'file yang di upload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
			}
			$pengantar = $this->upload->data('file_name');
		}
		//Kartu bimbingan
		$conPic['file_name'] = $this->tahunAk."-".$tempObjectDBD->getNim()."-".$NUM."-krtbm";
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($DATA_ARRAY['kartbim'])){
			return array(false, 'file yang di upload adalah, png(1366 x 2556). dan ukuran maksimal 1 mb.');
		}
		$kartbim = $this->upload->data('file_name');
		//kartu seminar ta
		$conPic['file_name'] = $this->tahunAk."-".$tempObjectDBD->getNim()."-".$NUM."-krtta"; 
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($DATA_ARRAY['kartsemta'])){
			return array(false, 'file yang di upload adalah, png(1366 x 2556). dan ukuran maksimal 1 mb.');
		}
		$kartsemta = $this->upload->data('file_name');
		//date
		$date = $DATA_ARRAY['datestart'];
		$ruang = $DATA_ARRAY['ruang'];
		$tempSS = $this->getCheck("TA1",$date,true);
		if(!$tempSS[0]){
			return array(false,$tempSS[1]);
		}
		
		//sett
		if($tempHaveTABefore){
			$this->controlSeminar->logSeminarActive($this->tahunAk,$this->loginFilter->getIdentifiedActive());
		}
		
		$tempObjectDB->setMahasiswa($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->setStatus(1);
		$tempObjectDB->setTahunAk($this->tahunAk);
		$tempObjectDB->setDataProses(1);
		$tempObjectDB->setRuang($ruang);
		$tempObjectDB->setWaktu($date);
		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		$taSDurasi = $controlAdmin->getTADurasi(1);
		$tempObjectDB->setWaktuEnd($this->dateJaservFilter->setDate($date,true)->setPlusOrMinMinute($taSDurasi,true)->getDate("Y-m-d H:i:s"));
		$tempObjectDB->setFujS($pengantar);
		$tempObjectDB->setKarBim($kartbim);
		$tempObjectDB->setKarFolSem($kartsemta);
		if($pengantar_upload_state)
			$tempObjectDB->setRekomendasi(2);
		else
			$tempObjectDB->setRekomendasi(1);
		if($this->controlSeminar->addNew($tempObjectDB)){
			return array(true,'Data berhasil dimasukan');
		}
		return array(false,'Data gagal dimasukan');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//submit
	//<<--DISABLED
	public function setSeminarTA1next(){
		exit("this link has been disabled for developer");
		if(!$this->prosesOpen){
			echo "0maaf anda tidak memiliki izin set seminar secara paksa";
			exit();
		}
		if($this->kodeForm != 3){
			echo "0maaf anda tidak memiliki izin set seminar secara paksa";
			exit();
		}
		$temp = $this->mahasiswa->setSeminarTA1next1(array("kartbim"=>"s-k-bimbingan", "kartsemta"=>"s-k-peserta"));
		if(!$temp[0]){
			exit("0".$temp[1]);
		}
		echo "1";
		$this->load->view("Classroom_room/Body_right/success_registrasi",array("data"=> "Terima kasih, Data Anda berhasil dimasukan")); 
	}
	//<<--
	public function setSeminarTA1(){
		if(!$this->prosesOpen){
			echo "0maaf anda tidak memiliki izin set seminar secara paksa";
			return;
		}
		if($this->kodeForm != 1){
			echo "0maaf anda tidak memiliki izin set seminar secara paksa";
			return;
		}
		$DATE_SEMINAR = $this->isNullPost("s_tanggal");
		$ROOM_SEMINAR = $this->isNullPost('s_ruang');
		$DATA_ARRAY = array(
		'pengantar' => 's-pengantar',
		'kartbim' => 's-k-bimbingan',
		'kartsemta' => 's-k-peserta',
		'datestart' => $DATE_SEMINAR,
		'ruang' => 1
		);
		//exit("0sukse");
		$ff = $this->setSeminarTA1Proses($DATA_ARRAY);
		if(intval($ff[0]) == 1){
			echo "1";
			$this->load->view("Bodyright/Classroom/Successregistrasi",array("data"=> "Terima kasih, Data Anda berhasil dimasukan, status diproses seleksi dosen penguji")); 
		}else{
			echo "0".$ff[1];
		}
		//process to mahasiswa
	}
	
	public function getCheck($variabel=null,$value=null,$type=false){
		if($variabel == null){
			$this->isNullPost('variabel');
			$variabel = $this->input->post('variabel');
			$variabel.="";
		}
		if($value == null){
			$this->isNullPost('value');
			$value = $this->input->post('value');
		}
		$value.="";
		$dateJaservFilter = new Datejaservfilter();
		$this->loadLib('ControlAdmin');
		$controlAdmin = new ControlAdmin($this->gateControlModel);
		if(!$dateJaservFilter->setDate($value)){
			exit('0Tanggal tidak valid');
		}
		$START = $dateJaservFilter->getDate("Y-m-d H:i:s");
		switch ($variabel){
			case 'TA1' : 
				$dateJaservFilter->setPlusOrMinMinute($controlAdmin->getTADurasi(1));
				$END = $dateJaservFilter->getDate("Y-m-d H:i:s");
				if($type)
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,1,1);
				else
					return $controlAdmin->isAvailableRoomOnThisSemester($START,$END,NULL,1,0);
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