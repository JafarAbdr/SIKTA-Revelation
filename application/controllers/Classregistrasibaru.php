<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencies:
-Mahasiswa
-ControlMahasiswa
-ControlRegistrasi
-ControlTime

*/

defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Classregistrasibaru extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->mahasiswa)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
		
	protected function getGenerateSimpleJson($a,$b){
		if($b === NULL || $b == "" || $b == " " || $b."" == '0'){
			return '"'.$a.'" : { "status" : false, "value" : null}';
		}else{
			return '"'.$a.'" : { "status" : true, "value" : "'.$b.'"}';
		}
	}
	//refreshing data form - valid
	public function getJsonDataPersonal(){
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$temp2="{";
		$temp2.=$this->getGenerateSimpleJson("nama", $tempObjectDB->getNama()).",";
		$temp2.=$this->getGenerateSimpleJson("nim", $tempObjectDB->getNim()).",";
		$temp2.=$this->getGenerateSimpleJson("nohp", $tempObjectDB->getNoHp()).",";
		$temp2.=$this->getGenerateSimpleJson("email", $tempObjectDB->getEmail()).",";
		$temp2.=$this->getGenerateSimpleJson("ortu", $tempObjectDB->getNamaOrangTua()).",";
		$temp2.=$this->getGenerateSimpleJson("nohportu", $tempObjectDB->getNoHpOrangTua()).",";
		$temp2.=$this->getGenerateSimpleJson("minat", $tempObjectDB->getMinat());
		$temp2.="}";
		echo $temp2;
		return true;
	}
	//registrasi baru
	public function index(){
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		//check is register permission
		if(intval($tempObjectDB->getStatus()) != 1){
			$TEMP_ARRAY['message'] = "Maaf, anda Bukan mahasiswa aktif, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
			return;
		}
		if(intval($tempObjectDB->getFormBaru()) != 1){
			$TEMP_ARRAY['message'] = "Maaf, anda sudah melakukan registrasi, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
			return;
		}
		//filter
		$CODE_PERMISSION = "1".$tempObjectDB->getRegistrasiBaru()."".$tempObjectDB->getRegistrasiLama()."";
		$YEAR_ACTIVE = $tempObjectDB->getAktifTahun();
		//check is register Time
		$this->loadLib("ControlTime");
		$controlTime = new ControlTime($this->gateControlModel);
		//var_dump($controlTime->isRegisterTime());
		if(!$controlTime->isRegisterTime()){
			if(intval($tempObjectDB->getTanpaWaktu()) == 2){			
				$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
				echo"0";
				$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
				return ;	
			}
		}
		
		//check data from other semester before
		$tahunAk = $controlTime->getYearNow();
		$this->loadLib('ControlRegistrasi');
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$ARRAY_CODE = $controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk);
		//check if is registerer on this Academic Year
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		$TEMP_BOOLEAN = $tempObjectDBD->getNextCursor();
		
		//var_dump($ARRAY_CODE);
		if(!$ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 111 :
				case 122 :
				//registerasi baru
				$TEMP_ARRAY = NULL;
				$tempObjectDBT = $this->controlDetail->getDetail('minat');
				$i=0;
				while($tempObjectDBT->getNextCursor()){
					$TEMP_ARRAY['peminatan'][$i]['id'] = $tempObjectDBT->getId();
					$TEMP_ARRAY['peminatan'][$i]['nama'] = $tempObjectDBT->getDetail();
					$i++;
				}
				echo "1";
				$this->load->view("Bodyright/Classroom/Registrasibaru",$TEMP_ARRAY);	
				return;
				break;
				case 121 :
				//pemaksaan regigstrasi lama
				case 112 :
				//neutrallized
				break;
			}
		}else if(!$ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				//echo "jojo";
				//neutrallized
				break;
				case 121 :
				//registerasi lama
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda mahasiswa lama , silahkan melanjutkan registrasi lama TA anda',
						'but2' => 'form lama'
				);
				$this->load->view("Bodyright/Classroom/Warningonebuttonregistrasi",$TEMP_ARRAY);
				return ;
				break;
				case 112 :
				//registerasi baru
				$TEMP_ARRAY = NULL;
				$tempObjectDBT = $this->controlDetail->getDetail('minat');
				$i=0;
				while($tempObjectDBT->getNextCursor()){
					$TEMP_ARRAY['peminatan'][$i]['id'] = $tempObjectDBT->getId();
					$TEMP_ARRAY['peminatan'][$i]['nama'] = $tempObjectDBT->getDetail();
					$i++;
				}
				echo "1";
				$this->load->view("Bodyright/Classroom/Registrasibaru",$TEMP_ARRAY);	
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				//registerasi lama
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Telah ditemukan data Ta anda, anda yakin ingin membuat baru? konsultasikan dengan dosen pembimbing anda. dan kontak koordinator Tugas Akhir',
						'but2' => 'form lama'
				);
				$this->load->view("Bodyright/Classroom/Warningonebuttonregistrasi",$TEMP_ARRAY);
				return ;
				break;
				case 112 :
				//registrasi baru
				$TEMP_ARRAY = NULL;
				$tempObjectDBT = $this->controlDetail->getDetail('minat');
				$i=0;
				while($tempObjectDBT->getNextCursor()){
					$TEMP_ARRAY['peminatan'][$i]['id'] = $tempObjectDBT->getId();
					$TEMP_ARRAY['peminatan'][$i]['nama'] = $tempObjectDBT->getDetail();
					$i++;
				}
				echo "1";
				$this->load->view("Bodyright/Classroom/Registrasibaru",$TEMP_ARRAY);	
				return;
				break;
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				//registerasi baru
				$TEMP_ARRAY = NULL;
				$tempObjectDBT = $this->controlDetail->getDetail('minat');
				$i=0;
				while($tempObjectDBT->getNextCursor()){
					$TEMP_ARRAY['peminatan'][$i]['id'] = $tempObjectDBT->getId();
					$TEMP_ARRAY['peminatan'][$i]['nama'] = $tempObjectDBT->getDetail();
					$i++;
				}
				echo "1";
				$this->load->view("Bodyright/Classroom/registrasibaru",$TEMP_ARRAY);
				return;
				break;
				case 122 :
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}
	}
	public function getResultRegistrasiBaru(){
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$CODE_PERMISSION = "1".$tempObjectDB->getRegistrasiBaru()."".$tempObjectDB->getRegistrasiLama()."";
		//check is register Time
		
		$this->loadLib("ControlTime");
		$controlTime = new ControlTime($this->gateControlModel);
		if(!$controlTime->isRegisterTime()){
			if(intval($tempObjectDB->getTanpaWaktu()) == 2){
				$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
				echo"1";
				$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
				return ;	
			}
		}
		//check data from other semester before
		$tahunAk = $controlTime->getYearNow();
		$this->loadLib('ControlRegistrasi');
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$ARRAY_CODE = $controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk);
		//check if is registerer on this Academic Year$this->sc_st->resetValue();
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,0,null);
		$TEMP_BOOLEAN = $tempObjectDBD->getNextCursor();
		//filltering code
		if(!$ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 121 :
				case 112 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if(!$ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				case 121 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}
		/* exit("0succes"); */
		//	
		/* if($this->sc_sm->getOpenForm() == '1'){
			$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
			echo"1";
			$this->load->view("Classroom_room/Body_right/failed_registrasi",$TEMP_ARRAY);
			return ;
		} */
		//$tempDataPersonal = $this->mahasiswa->getDataPersonal();
		//Nama
		$dataTemp['nama'] = $tempObjectDB->getNama();
		//Nim
		$dataTemp['identified'] = $tempObjectDB->getIdentified();
		//Email
		$dataTemp['email'] = $tempObjectDB->getEmail();
		//minat
		if($tempObjectDB->getMinat() === NULL || $tempObjectDB->getMinat() == '0' || $tempObjectDB->getMinat() == "" || $tempObjectDB->getMinat() == " "){
			$dataTemp['minat'] = $this->isNullPost('baru-minat');
			$this->getCheck('baru-minat',$dataTemp['minat'],true);
		}else{
			$dataTemp['minat'] = $tempObjectDB->getMinat();
		}
		//nohp
		$dataTemp['nohp'] = $tempObjectDB->getNoHp();
		//nohportu
		if($tempObjectDB->getNoHpOrangTua() === NULL || $tempObjectDB->getNoHpOrangTua() == "" || $tempObjectDB->getNoHpOrangTua() == " "){
			$dataTemp['nohportu'] = $this->isNullPost('baru-nohportu');
			$this->getCheck('baru-nohportu',$dataTemp['nohportu'],true);
		}else{
			$dataTemp['nohportu'] = $tempObjectDB->getNoHpOrangTua();
		}
		//ortu
		if($tempObjectDB->getNamaOrangTua() === NULL || $tempObjectDB->getNamaOrangTua() == "" || $tempObjectDB->getNamaOrangTua() == " "){
			$dataTemp['ortu'] = $this->isNullPost('baru-ortu');
			$this->getCheck('baru-ortu',$dataTemp['ortu'],true);
		}else{
			$dataTemp['ortu'] = $tempObjectDB->getNamaOrangTua();
		}
		//judulta
		$dataTemp['judulta'] = $this->isNullPost('baru-judulta');
		$this->getCheck('baru-judulta',$dataTemp['judulta'],true);
		//lokasi
		$dataTemp['lokasi'] = $this->isNullPost('baru-lokasi');
		$this->getCheck('baru-lokasi',$dataTemp['lokasi'],true);
		//metode
		$dataTemp['metode'] = $this->isNullPost('baru-metode');
		$this->getCheck('baru-metode',$dataTemp['metode'],true);
		//refs
		$dataTemp['ref1'] = $this->isNullPost('baru-ref1');
		$this->getCheck('baru-ref1',$dataTemp['ref1'],true);
		//refd
		if($this->input->post('baru-ref2') === null)
			$dataTemp['ref2'] = "";
		else {
			$dataTemp['ref2'] = $this->input->post('baru-ref2');
			if($dataTemp['ref2'] != "")
				$this->getCheck('baru-ref2',$dataTemp['ref2'],true);
		}
		//reft
		if($this->input->post('baru-ref3') === null)
			$dataTemp['ref3'] = ""; 
		else {
			$dataTemp['ref3'] = $this->input->post('baru-ref3');
			if($dataTemp['ref3'] != "")
				$this->getCheck('baru-ref3',$dataTemp['ref3'],true);	
		}
		$dataTemp['krs'] = 'baru-krs';
		$dataTemp['codeRegist'] = $tahunAk;
		//exit("0".$dataTemp['codereg']);
		if(intval($tempObjectDB->getRegistrasiLama()) == 1){
			$dataTemp['newf'] = 1;
			$dataTemp['notime'] = 1;
		}else{
			$dataTemp['newf'] = 2;
			$dataTemp['notime'] = 2;
		}
		//foreach($dataTemp as $k => $value){
		//	echo $k." ".$value."<br>";
		//}
		/*  $test="";
		foreach($dataTemp as $key => $value){
			$test .= "|".$key."|=>|".$value."|<br>";
		} 
		exit("0succes2".$test); */
		$temp = $this->setRegistrasiBaru($dataTemp);
		if(!$temp[0]){
			echo "0".$temp[1];
		}else{
			echo "1";
			$data['data'] = "Data berhasil dimasukan, terima kasih atas waktunya";
			$this->load->view("Bodyright/Classroom/Successregistrasi",$data);
		}
		//echo 'succes';
		return;
	}
	//
	public function getCheck($variabel=null,$value=null,$type=false){
		$this->mahasiswa->initial($this->inputJaservFilter);
		if($variabel == null){
			$variabel = $this->isNullPost('variabel');
			$variabel.="";
		}
		if($value == null){
			$value = $this->isNullPost('value');
		}
		$value.="";
		switch ($variabel){
			/* case 'date-is-available' : 
				if($type){
					
				}else{
					$this->mahasiswa->isAnyGuysOnThisDay($value,1);
				}
				break; */
			case 'baru-nim' :
				if($type){
					$temp = $this->mahasiswa->getCheckNim($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckNim($value);
				break;
			case 'baru-nama' :
			case 'baru-ortu' :
				if($type){
					$temp = $this->mahasiswa->getCheckName($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckName($value);
				break;
			case 'baru-email' :
				if($type){
					$temp = $this->mahasiswa->getCheckEmail($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckEmail($value);
				break;
			case 'baru-nohp' :
			case 'baru-nohportu' :
				if($type){
					$temp = $this->mahasiswa->getCheckNuTelphone($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckNuTelphone($value);
				break;
			case 'baru-minat' :
				if($type){
					$temp = $this->mahasiswa->getCheckInterested($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckInterested($value);
				break;
			case 'baru-ref1' :
			case 'baru-ref2' :
			case 'baru-ref3' :
				if($type){
					$temp = $this->mahasiswa->getCheckRefrence($value,1);
					if(!$temp[0]){
						exit("0jj".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckRefrence($value);
				break;
			case 'baru-judulta' :
				if($type){
					$temp = $this->mahasiswa->getCheckTitleFinalTask($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckTitleFinalTask($value);
				break;
			case 'baru-metode' :
				if($type){
					$temp = $this->mahasiswa->getCheckMethode($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckMethode($value);
				break;
			case 'baru-lokasi' :
				if($type){
					$temp = $this->mahasiswa->getCheckLokasi($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckLokasi($value);
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
	//Registerasi Baru proses - valid
	protected function setRegistrasiBaru($data){
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = $controlRegistrasi->getAllData($data['codeRegist'],$data['identified'],null,null,null);
		$NUM = $tempObjectDB->getCountData();
		$conPic['upload_path'] = './upload/krs/';
		$conPic['allowed_types'] = 'pdf';
		$conPic['file_name'] = $data['codeRegist']."".md5($data['identified'])."".$NUM."KR5";
		$conPic['overwrite'] = true;
		$conPic['remove_spaces'] = true;
		$conPic['max_size'] = 1024;
		$this->load->library('upload');
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($data['krs'])){
			return array(false, 'file yang di upload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$data['namakrs'] = $this->upload->data('file_name');
		$data['kategori'] = 1;
		//return array(false,"succes ".strlen($krsname));
		//update data
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDBD = $controlMahasiswa->getAllData($data['identified']);
		$tempObjectDBD->getNextCursor();
		$tempObjectDBD->setMinat($data['minat']);
		$tempObjectDBD->setNamaOrangTua($data['ortu']);
		$tempObjectDBD->setNoHpOrangTua($data['nohportu']);
		$tempObjectDBD->setRegistrasiBaru(2);
		$tempObjectDBD->setFormBaru($data['newf']);
		$tempObjectDBD->setTanpaWaktu($data['notime']);
		if(!$controlMahasiswa->tryUpdate($tempObjectDBD))
			return array(false,"Terjadi kesalahan pada saat registrasi baru");
		//log data
		if($tempObjectDB->getNextCursor()){
			$controlRegistrasi->tryLog($data['codeRegist'],$data['identified'],$tempObjectDB->getCountData());
		}
		//add new item
		if(!$controlRegistrasi->addNew($data)){
			return array(false, "terjadi kesalahan saat memasukan data registrasi");
		}
		return array(true, "Valid");
	}
}