<?php
if(!defined('BASEPATH')) header("location:http://siata.undip.ac.id/");
class CI_Controller_Modified extends CI_Controller{
	
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