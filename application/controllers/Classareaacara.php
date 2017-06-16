<?php
if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
dependencies:
-ControlAcara
-ControlAdmin
-ControlMahasiswa
-ControlSeminar
-ControlSidang
-ControlTime
-ControlPinjam (+)
*/
/*
ControlDosen
ControlRegistrasi
*/
class Classareaacara extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->mahasiswa))
			redirect(base_url().'Gateinout.jsp');
	}
	//layout for acara bagi admin
	public function getLayoutAreaAcara(){
		echo "1";
		$this->load->view("Bodyright/Classroom/Areaacara");
	}
	//Optimized
	//memeperoleh eegala macam kegiatan dari ruang Sidang TA 1
	public function getJSONAcaraRuangTA1(){
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlPinjam');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlSeminar = new ControlSeminar($this->gateControlModel);
		$controlSidang = new ControlSidang($this->gateControlModel);
		$controlPinjam = new ControlPinjam($this->gateControlModel);
		$controlAcara = new ControlAcara($this->gateControlModel);
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
			$tempObjectDBs =$controlSeminar->getAllDataHaveATimeWithMahasiswa($tempTahunAk);
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempMahasiswa = $tempObjectDBs->getTableStack(1);
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempMahasiswa->getNextCursor();
					$data[$i]['nama'] = $tempMahasiswa->getNama();
					$data[$i]['contact'] = $tempMahasiswa->getNoHp();
					$data[$i]['deskripsi'] = "Seminar TA";
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
					
					$STATE="TS";
					$data[$i]['id'] = $STATE."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu())."1_".$tempMahasiswa->getNim();
					$i++;
				}
				
			}
			
			$tempObjectDB = $controlAcara->getAllData($tempTahunAk,"1");
			if($tempObjectDB->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDB->getNextCursor()){
					$data[$i]['nama'] = $tempObjectDB->getPenanggungJawab();
					$data[$i]['deskripsi'] = $tempObjectDB->getDetail();
					$data[$i]['contact'] = "Admin Departemen";
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs = $controlPinjam->getAllData($tempTahunAk,"1",null,true);
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempObjectDBn = $tempObjectDBs->getTableStack(1);
					$data[$i]['nama'] = $tempObjectDBn->getNama();
					$data[$i]['contact'] = $tempObjectDBn->getNoHp();
					$data[$i]['deskripsi'] = $tempObjectDB->getDetail();
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					if($tempObjectDBn->getIdentified() == $this->loginFilter->getIdentifiedActive())
						$data[$i]['id'] = "PM".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					else
						$data[$i]['id'] = "NP".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs =$controlSidang->getAllDataHaveATimeWithMahasiswa($tempTahunAk,"1");
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempMahasiswa = $tempObjectDBs->getTableStack(1);
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$data[$i]['nama'] = $tempMahasiswa->getNama();
					$data[$i]['deskripsi'] = "Sidang TA";
					$data[$i]['contact'] = $tempMahasiswa->getNoHp();
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
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
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlPinjam');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlSidang = new ControlSidang($this->gateControlModel);
		$controlPinjam = new ControlPinjam($this->gateControlModel);
		$controlAcara = new ControlAcara($this->gateControlModel);
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
			
			$tempObjectDB = $controlAcara->getAllData($tempTahunAk,"2");
			if($tempObjectDB->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDB->getNextCursor()){
					$data[$i]['nama'] = $tempObjectDB->getPenanggungJawab();
					$data[$i]['deskripsi'] = $tempObjectDB->getDetail();
					$data[$i]['contact'] = "Admin Departemen";
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs = $controlPinjam->getAllData($tempTahunAk,"2",null,true);
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempObjectDBn = $tempObjectDBs->getTableStack(1);
					$data[$i]['nama'] = $tempObjectDBn->getNama();
					$data[$i]['deskripsi'] = $tempObjectDB->getDetail();
					$data[$i]['contact'] = $tempObjectDBn->getNoHp();
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					if($tempObjectDBn->getIdentified() == $this->loginFilter->getIdentifiedActive())
						$data[$i]['id'] = "PM".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					else
						$data[$i]['id'] = "NP".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
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
					$data[$i]['deskripsi'] = "Sidang TA 2";
					$data[$i]['contact'] = $tempMahasiswa->getNoHp();
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
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
	//memeperoleh eegala macam kegiatan dari ruang puspital
	public function getJSONAcaraRuangPUS(){
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlAcara');
		$this->loadLib('ControlPinjam');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlTime');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlSidang = new ControlSidang($this->gateControlModel);
		$controlPinjam = new ControlPinjam($this->gateControlModel);
		$controlAcara = new ControlAcara($this->gateControlModel);
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
			
			$tempObjectDB = $controlAcara->getAllData($tempTahunAk,"4");
			if($tempObjectDB->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDB->getNextCursor()){
					$data[$i]['nama'] = $tempObjectDB->getPenanggungJawab();
					$data[$i]['deskripsi'] = $tempObjectDB->getDetail();
					$data[$i]['contact'] = "Admin Departemen";
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					$data[$i]['id'] = "AC".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs = $controlPinjam->getAllData($tempTahunAk,"4",null,true);
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$tempObjectDBn = $tempObjectDBs->getTableStack(1);
					$data[$i]['nama'] = $tempObjectDBn->getNama();
					$data[$i]['deskripsi'] = $tempObjectDB->getDetail();
					$data[$i]['contact'] = $tempObjectDBn->getNoHp();
					$data[$i]['tanggal'] = $tempObjectDB->getMulai();
					$data[$i]['endTanggal'] = $tempObjectDB->getBerakhir();
					if($tempObjectDBn->getIdentified() == $this->loginFilter->getIdentifiedActive())
						$data[$i]['id'] = "PM".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					else
						$data[$i]['id'] = "NP".$tempObjectDB->getTahunAk()."|".str_ireplace(" ","&",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
					$i++;
				}
			}
			$tempObjectDBs =(new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tempTahunAk,"4");
			if($tempObjectDBs->getCountData() > 0){
				$data['kode'] = true;
				while($tempObjectDBs->getNextCursor()){
					$tempMahasiswa = $tempObjectDBs->getTableStack(1);
					$tempObjectDB = $tempObjectDBs->getTableStack(0);
					$data[$i]['nama'] = $tempMahasiswa->getNama();
					$data[$i]['deskripsi'] = "Sidang TA 2";
					$data[$i]['contact'] = $tempMahasiswa->getNoHp();
					$data[$i]['tanggal'] = $tempObjectDB->getWaktu();
					$data[$i]['endTanggal'] = $tempObjectDB->getWaktuEnd();
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
		
		$penanggung = $this->loginFilter->getIdentifiedActive();
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
		$this->loadLib('ControlMahasiswa');
		$tempData = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempResult = (new ControlAdmin($this->gateControlModel))->isAvailableroomOnThisSemester($mulai,$berakhir,$tahunAk,$ruang,1);
		if($tempResult[0] == '0') exit("0".$tempResult[1]);
		
		
		$tempData->getNextCursor();
		$this->loadLib('ControlPinjam');
		if((new ControlPinjam($this->gateControlModel))->addAcara(array(
			'tahunak' => $tahunAk,
			'detail' => $namaAcara,
			'penanggungjawab' => $penanggung,
			'ruang' => $ruang,
			'mulai' => $mulai,
			'berakhir' => $berakhir
		))) exit("1Berhasil menambahkan data|".$tahunAk."|".$tempData->getNama()."|".$tempData->getNoHp());
		exit("0terjadi kesalahan dalam menyimpan acara");
	}
	//optimized
	//get data of acara that has been add before
	public function getJSONDataAcara(){
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
		$this->loadLib('ControlPinjam');
		$tempObjectDB = (new ControlPinjam($this->gateControlModel))->getAllData($tahunAk,$ruang,$mulai);
		if($tempObjectDB->getNextCursor() && $tempObjectDB->getPenanggungJawab() == $this->loginFilter->getIdentifiedActive()){	
			$data = array(
				'namaAcara' => $tempObjectDB->getDetail(),
				'responsive' => "Anda",
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
		$penanggungjawab = $this->loginFilter->getIdentifiedActive();
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
		$this->loadLib('ControlPinjam');
		$this->loadLib('ControlAdmin');
		$controlPinjam = new ControlPinjam($this->gateControlModel);
		
		$tempObjectDB = $controlPinjam->getAllData($tahunAk,$ruang,$mulai);
		if(!$tempObjectDB->getNextCursor()){
			exit('0data tidak ditemukan');
		}
		if($tempObjectDB->getPenanggungJawab() != $this->loginFilter->getIdentifiedActive()) exit('0data tidak ditemukan');
		$mulai = $tempObjectDB->getMulai();
		$berakhir = $tempObjectDB->getBerakhir();
		$tempObjectDB->setMulai("1000-01-01 00:00:00");
		$tempObjectDB->setBerakhir("1000-01-01 00:00:00");
		$controlPinjam->tryUpdate($tempObjectDB);
		$tempResult = (new ControlAdmin($this->gateControlModel))->isAvailableroomOnThisSemester($startEvent,$endEvent,$tahunAk,$tempObjectDB->getRuang(),1);
		if($tempResult[0] == '0') {
			$tempObjectDB->setMulai($mulai);
			$tempObjectDB->setBerakhir($berakhir);
			$controlPinjam->tryUpdate($tempObjectDB);
			exit("0".$tempResult[1]);
		}
		$tempObjectDB->setTahunAk($tahunAk);
		$tempObjectDB->setDetail($namaAcara);
		$tempObjectDB->setMulai($startEvent);
		$tempObjectDB->setBerakhir($endEvent);
		if($controlPinjam->tryUpdate($tempObjectDB)){
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
			if(!$this->mahasiswa->getCheckNim($NIM,1)[0]){
				exit("0data tidak valid");
			}
		}
		if($this->dateJaservFilter->nice_date($TANGGAL,"Y-m-d H:i:s") == 'Invalid Date'){
			exit("0data tidak ditemukan");
		}
		$TANGGAL = $this->dateJaservFilter->nice_date($TANGGAL,"Y-m-d H:i:s");
		if($ROOM > 4 || $ROOM < 1){
			exit("0data tidak ditemukan");
		}
		switch($kode){
			case "PM" : 
			$this->loadLib('ControlPinjam');
			$controlPinjam = new ControlPinjam($this->gateControlModel);
			$tempObjectDB = $controlPinjam->getAllData($SRT,$ROOM,$TANGGAL);
			if(!$tempObjectDB->getNextCursor()){
				exit('0data tidak ditemukan');
			}
			if($tempObjectDB->getPenanggungJawab() != $this->loginFilter->getIdentifiedActive()) exit('0data tidak ditemukan');
			if($controlPinjam->deleteAcara(array("tahunak"=>$SRT, "mulai"=>$TANGGAL, "ruang"=>$ROOM))){
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