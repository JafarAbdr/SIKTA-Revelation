<?php
/*
dependencie:
ControlMahasiswa
*/
if(!defined('BASEPATH')) exit('no direct access allowed');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Resetpassword extends CI_Controller_Modified {
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if($this->loginFilter->isLogin($this->mahasiswa))
			redirect(base_url()."Classroom.jsp");
		
		if($this->loginFilter->isLogin($this->koordinator))
			redirect(base_url()."Controlroom.jsp");
		
		if($this->loginFilter->isLogin($this->dosen))
			redirect(base_url()."Kingroom.jsp");
		
		if($this->loginFilter->isLogin($this->admin))
			redirect(base_url()."Palaceroom.jsp");
	}
	public function Akun($kode=null){
		$this->loadLib('ControlMahasiswa');
		if(!preg_match("/^([a-zA-Z0-9]+)$/",$kode)) redirect(base_url()."Gateinout.jsp");
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getDataByKodeCookie($kode);
		if(!$tempObjectDB->getNextCursor()) redirect(base_url()."Gateinout.jsp");
		$temp = $this->dateJaservFilter->setDate($tempObjectDB->getWaktuCookie(),true)->setPlusOrMinMinute(60,true)->getDate('Y-m-d H:i:s');
		if(!$this->dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->isBefore($temp))redirect(base_url()."Gateinout.jsp");
		$tempArray['url_script'] = array(
				"resources/mystyle/js/Reset-password.js",
				"resources/mystyle/js/global-style.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js"
		);
		$tempArray['url_link'] = array(
				"resources/mystyle/css/gateinout.css",
				"resources/mystyle/css/global-style.css"
		);
		$tempArray['kodeValidity'] = $kode;
		$this->load->view('Reset_layout',$tempArray);
	}
	public function resetNowThisGuys(){
		$passwordNew = $this->isNullPost('passwordbaru');
		$passwordKon = $this->isNullPost('passwordkonfirmasi');
		$kode = $this->isNullPost('kode');
		$this->loadLib('ControlMahasiswa');
		$this->mahasiswa->initial($this->inputJaservFilter);
		if(!$this->mahasiswa->getCheckPassword($passwordNew,1)[0]) exit('0Password harus terdiri dari huruf besar, kecil dan angka, maksimal 16 dan minimum 8 karakter');
		if(!$this->mahasiswa->getCheckPassword($passwordKon,1)[0]) exit('0Password harus terdiri dari huruf besar, kecil dan angka, maksimal 16 dan minimum 8 karakter');
		if($passwordNew != $passwordKon) exit('0Password baru harus sama dengan password konfirmasi');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getDataByKodeCookie($kode);
		if(!$tempObjectDB->getNextCursor()) exit('0anda melakukan debuging');
		$temp = $this->dateJaservFilter->setDate($tempObjectDB->getWaktuCookie(),true)->setPlusOrMinMinute(60,true)->getDate('Y-m-d H:i:s');
		if(!$this->dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->isBefore($temp)) exit('0anda melakukan debuging');
		if(!$this->loginFilter->setNewPassword($passwordNew,$tempObjectDB->getIdentified())) 
			exit('0password anda harus berbeda dengan password yang lama');
		(new ControlMahasiswa($this->gateControlModel))->setOverWaktuCookie($kode,$this->dateJaservFilter->setDate(date("Y-m-d H:i:s"),true)->setPlusOrMinMinute(-120,true)->getDate('Y-m-d H:i:s'));
		exit("1Berhasil melakukan perubahan");
	}
}