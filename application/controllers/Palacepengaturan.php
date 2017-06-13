<?php
if(!defined('BASEPATH')) exit("you don't have permission to access");

/*
-LoginFilter
-Admin
-Datejaservfilter
-Inputjaservfilter
-GateControlModel
-ControlAdmin
-ControlDosen
*/
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Palacepengaturan extends CI_Controller_Modified {
	function __CONSTRUCT(){
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
		$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->admin))
			redirect(base_url().'Gateinout.jsp');
	}
	public function getJSONDataAdmin(){
		$this->loadLib('ControlAdmin');
		$tempObjectDB = (new ControlAdmin($this->gateControlModel))->getDataByIdentified($this->loginFilter->getIdentifiedActive());
		$this->loadLib('ControlDosen');
		$controlDosen = new ControlDosen($this->gateControlModel);
		if($tempObjectDB->getNextCursor()){
			$tempObjectDBD = $controlDosen->getAllData($tempObjectDB->getKajur());
			$tempObjectDBD->getNextCursor();
			$tempObjectDBT = $controlDosen->getAllData($tempObjectDB->getWakil());
			$tempObjectDBT->getNextCursor();
			$data['nama'] = $tempObjectDB->getNama();
			$data['nip'] = $tempObjectDB->getNip();
			$data['alamat'] = $tempObjectDB->getAlamat();
			$data['email'] = $tempObjectDB->getEmail();
			$data['kajur'] = $tempObjectDBD->getNip();
			$data['wakil'] = $tempObjectDBT->getNip();
			$data['tasd'] = $tempObjectDB->getTaSDurasi();
			$data['tadd'] = $tempObjectDB->getTaDDurasi();
			$data['nohp'] = $tempObjectDB->getNoHp();
			echo "1".json_encode($data);
		}else{
			echo "0";
		}
	}
	public function getUpdateInfoDiri(){
		$data['nama'] = $this->isNullPost('nama');
		$this->admin->initial($this->inputJaservFilter);
		if(!$this->admin->getCheckName($data['nama'],1)[0]){
			exit("0Nama anda tidak valid");
		}
		$data['nip'] = $this->input->post('nip')."";
		if($data['nip'] == '0') $data['nip']="";
		if($data['nip'] !== "") {
			if(!$this->admin->getCheckNip($data['nip'],1)[0]){
				exit("0Nip anda tidak valid");
			}
		}
		$data['email'] = $this->isNullPost('email');
		if(!$this->inputJaservFilter->emailFiltering($data['email'])[0]){ exit('Email yang anda ajukan tidak valid'); }
		$data['alamat'] = $this->input->post('alamat')."";
		if($data['alamat'] !== "") {
			$data['alamat'] = $this->inputJaservFilter->stringFiltering($data['alamat']);
		}
		$data['nohp'] = $this->isNullPost('nohp');
		if(!$this->inputJaservFilter->numberFiltering($data['nohp'])[0]){ exit("0No hp anda tidak valid"); }
		$this->loadLib('ControlDosen');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$data['kajur'] = $this->input->post('kajur');
		if($data['kajur'] == '0' || $data['kajur'] == null || strtolower($data['kajur']) == 'null') $data['kajur'] = "";
		
		if($data['kajur'] !== "") {
			if(!$this->admin->getCheckNip($data['kajur'],1)[0]){exit("0anda melakukan debugs");}
			$tempObjectDB = $controlDosen->getDataByNip($data['kajur']);
			if(!$tempObjectDB->getNextCursor()){
				exit("0maaf ketua jurusan ini tidak terdaftar sebagai dosen");
			}else{
				$data['kajur'] = $tempObjectDB->getIdentified();
			}
		}
		
		$data['wakil'] = $this->input->post('wakil');
		if($data['wakil'] == '0' || is_null($data['wakil']) || strtolower($data['wakil']) == 'null') $data['wakil'] = "";
		if($data['wakil'] !== "") {
			if(!$this->admin->getCheckNip($data['wakil'],1)[0]){exit("0anda melakukan debugd");}
			$tempObjectDB = $controlDosen->getDataByNip($data['wakil']);
			if(!$tempObjectDB->getNextCursor()){
				exit("0maaf wakil ini tidak terdaftar sebagai dosen");
			}else{
				$data['wakil'] = $tempObjectDB->getIdentified();
			}
		}
		if($data['wakil'] == $data['kajur']) exit("wakil tidak boleh sama dengan ketua jurusan");
		
		
		$data['tasd'] = intval($this->isNullPost('tasd'));
		if($data['tasd'] < 0 || $data['tasd'] > 300){
			exit('0Durasi TA 1 tidak benar');
		}
		$data['tadd'] = intval($this->isNullPost('tadd'));
		if($data['tasd'] < 0 || $data['tasd'] > 300){
			exit('0Durasi TA 2 tidak benar');
		}
	//	exit("0tryit".$data['tasd']." ".$data['tadd']);
		$this->loadLib('ControlAdmin');
		if((new ControlAdmin($this->gateControlModel))->updateInformasiAdmin(array(
			"email" =>$data['email'],
			"nohp" =>$data['nohp'],
			"tasd" =>$data['tasd'],
			"tadd" =>$data['tadd'],
			"kajur" =>$data['kajur'],
			"wakil" =>$data['wakil'],
			"nama" =>$data['nama'],
			"alamat" =>$data['alamat'],
			"nip" =>$data['nip'],
			"identified" => $this->loginFilter->getIdentifiedActive()
		))) exit("1Berhasil merubah informasi");
		exit("0gagal merubah informasi");
	}
	
	public function changePasswordAdmin(){
		$oldPass = $this->isNullPost('oldpass');
		if($oldPass == "")
			exit("0password lama tidak boleh kosong");
		if(!$this->inputJaservFilter->passwordFiltering($oldPass)[0])
			exit("0password lama memiliki format yang salah");
		$newPass = $this->isNullPost('newpass');
		if($newPass == "")
			exit("0password baru tidak boleh kosong");
		if(!$this->inputJaservFilter->passwordFiltering($newPass)[0])
			exit("0password baru memiliki format yang salah");
		$conPass = $this->isNullPost('conpass');
		if($conPass == "")
			exit("0password konfirmasi tidak boleh kosong");
		if(!$this->inputJaservFilter->passwordFiltering($conPass)[0])
			exit("0password konfirmasi memiliki format yang salah");
		if($conPass != $newPass)
			exit("0password baru harus sama dengan konfirmasi"); 
		if($oldPass == $newPass)
			exit("0password baru tidak boleh sama dengan password baru"); 
		if(!$this->loginFilter->isPasswordOfThisGuy($oldPass))
			exit("0Password lama tidak sama dengan password di server");
		
		if($this->loginFilter->setNewPassword($newPass)){
			echo "1Berhasil melakukan perubahan";
		}else{
			echo "0Gagal melakukan perubahan";
		}
	}
}