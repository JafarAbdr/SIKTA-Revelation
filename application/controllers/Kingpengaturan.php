<?php
/*
dependencies:
-LoginFilter
-Dosen
-GateControlModel
-Inputjaservfilter
-ControlDosen
*/
	if(!defined('BASEPATH'))
		exit("You don't have accsees to this site");
require_once APPPATH."controllers/CI_Controller_Modified.php";
class Kingpengaturan extends CI_Controller_Modified {
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
		$this->loadLib('Inputjaservfilter');
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->dosen->initial($this->inputJaservFilter);
		$this->loadLib('ControlDosen');
		$this->controlDosen = new ControlDosen($this->gateControlModel);
	}
	public function setNewPassword(){
		$passwordLama = $this->isNullPost("password-old");
		$passwordNew = $this->isNullPost("password-new");
		$passwordNewCon = $this->isNullPost("password-new-confirm");
		$ERROR = 0;
		$ERRORMESSAGE = "";
		if(!$this->dosen->getCheckPassword($passwordLama,1)[0]){
			$ERRORMESSAGE .= "password lama tidak valid,";
			$ERROR += 1;	
		}
		if(!$this->dosen->getCheckPassword($passwordNew,1)[0]){
			$ERRORMESSAGE .= "password baru tidak valid,";
			$ERROR += 1;	
		}
		if(!$this->dosen->getCheckPassword($passwordNewCon,1)[0]){
			$ERRORMESSAGE .= "password baru confirmasi tidak valid,";
			$ERROR += 1;	
		}
		if($ERROR > 0)
			exit("0".$ERRORMESSAGE);
		if($passwordNew != $passwordNewCon){
			exit("0Password baru tidak sama dengan password confiirmasinya");
		}
		if(!$this->loginFilter->isPasswordOfThisGuy($passwordLama)){
			exit("password Lama anda salah");
		}
		
		if(!$this->loginFilter->setNewPassword($passwordNew)){
			exit("0Gagal melakukan perubahan terhadap password");
		}
		exit("1Proses perubahan berhasil");
	}
	public function getJsonProfile(){
		$tempObjectDB = $this->controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		if($tempObjectDB->getNextCursor()){
			$data['nama'] = $tempObjectDB->getNama();
			$data['nip'] = $tempObjectDB->getNip();
			$data['email'] = $tempObjectDB->getEmail();
			$data['nohp'] = $tempObjectDB->getNoHp();
			$data['alamat'] = $tempObjectDB->getAlamat();
			$data['bidang'] = $tempObjectDB->getBidangRiset();
			$data['kelamin'] = $tempObjectDB->getKelamin();
			$data['state'] = true;
		}
		echo json_encode($data);
	}
	public function dataSupport(){
		$email = $this->isNullPost("support-email");
		$nohp = $this->isNullPost("support-nohp");
		$alamat = $this->isNullPost("support-alamat");
		$bidang = $this->isNullPost("support-bidang");
		$gender = intval($this->isNullPost("support-gender"));
		if(!$this->dosen->getCheckEmail($email,1)[0]){
			exit("0Email tidak valid");
		}
		if(!$this->dosen->getCheckNuTelphone($nohp,1)[0]){
			exit("0No hp anda tidak valid");
		}
		if(!$this->dosen->getCheckLokasi($alamat,1)[0]){
			exit("0No hp orang tua anda tidak valid");
		}
		if(!$this->dosen->getCheckBidang($bidang,1)[0]){
			exit("0Format bidang tidak valid");
		}
		if($gender < 0 || $gender > 2) $gender = 0;
		$tempObjectDB = $this->controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		if(!$tempObjectDB->getNextCursor()) exit("0gagal melakukan perubahan");
		
		
		$tempObjectDB->setNoHp($nohp);
		$tempObjectDB->setAlamat($alamat);
		$tempObjectDB->setBidangRiset($bidang);
		$tempObjectDB->setEmail($email);
		$tempObjectDB->setKelamin($gender);
		if(!$this->controlDosen->tryUpdate($tempObjectDB))
			exit("0Terjadi kesalahan saat perubahan, silahkan coba lagi");
		exit("1data berhasl dirubah");
	}
}