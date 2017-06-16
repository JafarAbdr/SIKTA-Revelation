<?php
if(!defined('BASEPATH')) header("location:http://siata.undip.ac.id/");
class CI_Controller_Modified extends CI_Controller{
	protected $gateControlModel;
	protected $loginFilter;
	protected $controlDetail;
	protected $inputJaservFilter;
	protected $dateJaservFilter;
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->loadMod('GateControlModel');
		$this->loadLib('LoginFilter');
		$this->loadLib('ControlDetail');
		$this->load->library('Session');
		$this->loadLib('Datejaservfilter');
		$this->loadLib('Inputjaservfilter');
		$this->load->library('Aktor/Mahasiswa');
		$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Koordinator');
		$this->load->library('Aktor/Admin');
		$this->dateJaservFilter = new Datejaservfilter();
		$this->inputJaservFilter = new Inputjaservfilter();
		$this->gateControlModel = new GateControlModel();
		$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
		$this->controlDetail = new ControlDetail($this->gateControlModel);
	}
	protected function isNullPost($tempName,$messageError = null, $forceExit = true){
		if(!is_bool($forceExit)) $forceExit = true;
		if($this->input->post($tempName) === NULL){
			if($messageError == null){
				exit('0'.$tempName." bernilai null");
			}else{
				exit('0'.$messageError);
			}
		}
		return $this->input->post($tempName);
	}
	protected function loadMod($nama,$return = false){
		$this->load->model($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->$nama))
			$tempObject = $this->$nama;
		$this->$nama = null;
		if($return)
			return $tempObject;
	}
	protected function loadLib($nama,$return = false){
		$this->load->library($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->$nama)) 
			$tempObject = $this->$nama;
		$this->$nama = null;
		if($return)
			return $tempObject;
	}
}