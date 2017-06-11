<?php
/*
dependencie:
LoginFilter
GateControlModel
Mahasiswa
Koordinator
Dosen
Admin
ControlMahasiswa
Datejaservfilter
Inputjaservfilter
*/
if(!defined('BASEPATH')) exit('no direct access allowed');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Resetpassword extends CI_Controller_Modified {
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Aktor/Mahasiswa');
		$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Admin');
		$this->load->library('Aktor/Koordinator');
		$this->loadLib('LoginFilter');
		$session = $this->loadLib('Session',true);
		$this->loadMod("GateControlModel");
		$this->loadLib('Datejaservfilter');
		$this->gateControlModel = new GateControlModel();
		$this->loginFilter = new LoginFilter($session, $this->gateControlModel);
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
		$temp = (new DateJaservFilter())->setDate($tempObjectDB->getWaktuCookie(),true)->setPlusOrMinMinute(60,true)->getDate('Y-m-d H:i:s');
		if(!(new DateJaservFilter)->setDate(date("Y-m-d H:i:s"),true)->isBefore($temp))redirect(base_url()."Gateinout.jsp");
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
		//exit("0lkjkjk");
		//$_POST['passwordbaru'] = "jafar56AAA";
		//$_POST['passwordkonfirmasi'] = "jafar56AAA";
		//$_POST['kode'] = "efcf7c61932b37f89f0f970bbd33c6f9";
		$passwordNew = $this->isNullPost('passwordbaru');
		$passwordKon = $this->isNullPost('passwordkonfirmasi');
		$kode = $this->isNullPost('kode');
		$this->loadLib('Inputjaservfilter');
		$this->loadLib('ControlMahasiswa');
		$this->mahasiswa->initial(new Inputjaservfilter());
		if(!$this->mahasiswa->getCheckPassword($passwordNew,1)[0]) exit('0Password harus terdiri dari huruf besar, kecil dan angka, maksimal 16 dan minimum 8 karakter');
		if(!$this->mahasiswa->getCheckPassword($passwordKon,1)[0]) exit('0Password harus terdiri dari huruf besar, kecil dan angka, maksimal 16 dan minimum 8 karakter');
		if($passwordNew != $passwordKon) exit('0Password baru harus sama dengan password konfirmasi');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getDataByKodeCookie($kode);
		if(!$tempObjectDB->getNextCursor()) exit('0anda melakukan debuging');
		$temp = (new DateJaservFilter())->setDate($tempObjectDB->getWaktuCookie(),true)->setPlusOrMinMinute(60,true)->getDate('Y-m-d H:i:s');
		if(!(new DateJaservFilter)->setDate(date("Y-m-d H:i:s"),true)->isBefore($temp)) exit('0anda melakukan debuging');
		$this->loadLib('LoginFilter');
		if(!(new LoginFilter(null,$this->gateControlModel))->setNewPassword($passwordNew,$tempObjectDB->getIdentified())) 
			exit('0password anda harus berbeda dengan password yang lama');
		//echo (new Datejaservfilter())->setDate(date("Y-m-d H:i:s"),true)->setPlusOrMinMinute(-120,true)->getDate('Y-m-d H:i:s');
		//echo $kode;
		(new ControlMahasiswa($this->gateControlModel))->setOverWaktuCookie($kode,(new Datejaservfilter())->setDate(date("Y-m-d H:i:s"),true)->setPlusOrMinMinute(-120,true)->getDate('Y-m-d H:i:s'));
		exit("1Berhasil melakukan perubahan");
	}
}