<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Aktor/Aktor.php";
class Mahasiswa extends Aktor{
	public function __CONSTRUCT(Inputjaservfilter $tempInputJaservFilter = null){
		parent::__CONSTRUCT();
		$this->levelCode = 'M';
		$this->inputJaservFilter = $tempInputJaservFilter;
	}
	//public function 
	//<--
	//nim check - format - valid
	public function getCheckNim($tempNim="",$tempCategory=0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempNim == ""){ return $this->setCategoryPrintMessage($tempCategory, false, "Nim tidak sesuai"); }	
		if(substr($tempNim,0,3) == "J2F"){
			if(strlen($tempNim)!= 9){ return $this->setCategoryPrintMessage($tempCategory, false, "Nim tidak sesuai"); }
			if($this->inputJaservFilter->numberFiltering(substr($tempNim,3,strlen($tempNim)-3))[0]){ return $this->setCategoryPrintMessage($tempCategory, true, "Nim sesuai");}
			else{ return $this->setCategoryPrintMessage($tempCategory, false, "Nim tidak sesuai");	}
		}else{
			if(strlen($tempNim) != 14) return $this->setCategoryPrintMessage($tempCategory, false, "Nim tidak sesuai");
			if($this->inputJaservFilter->numberFiltering($tempNim)[0]){ return $this->setCategoryPrintMessage($tempCategory, true, "Nim sesuai"); }
			else{ return $this->setCategoryPrintMessage($tempCategory, false, "Nim tidak sesuai"); }
		}
	}
	//check methode - format - valid
	public function getCheckMethode($tempValueMethode = "",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempValueMethode == "") return $this->setCategoryPrintMessage($tempCategory, false, "Metode tidak boleh kosong");
		$tempValueMethode = $this->inputJaservFilter->titleFiltering($tempValueMethode);
		return $this->setCategoryPrintMessage($tempCategory, $tempValueMethode[0], $tempValueMethode[1]);
	}
	//check lokasi - format - valid
	public function getCheckLokasi($tempValueLocation = "",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempValueLocation == "") return $this->setCategoryPrintMessage($tempCategory, true, "valid"); //boleh kosong atau tidak
		$tempValueLocation = $this->inputJaservFilter->usernameFiltering($tempValueLocation);
		return $this->setCategoryPrintMessage($tempCategory, $tempValueLocation[0], $tempValueLocation[1]);
	}
	//check refrences - format - valid
	public function getCheckRefrence($tempValueReference = "",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempValueReference == "") return $this->setCategoryPrintMessage($tempCategory, true, "valid"); //boleh kosong atau tidak
		$tempValueReference = $this->inputJaservFilter->titleFiltering($tempValueReference);
		return $this->setCategoryPrintMessage($tempCategory, $tempValueReference[0], $tempValueReference[1]);
	}
	//check peminatan - format - valid
	public function getCheckInterested($tempValueInterest = "",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		$tempValueInterest.="";
		if($tempValueInterest == "") return $this->setCategoryPrintMessage($tempCategory, false, "peminatan tidak booleh kosong"); //boleh kosong atau tidak
		$tempArray = $this->inputJaservFilter->numberFiltering($tempValueInterest);
		if($tempArray[0]){
			if(strlen($tempValueInterest) == 1){
				if((intval($tempValueInterest) > 0) && (intval($tempValueInterest)<5)){ return $this->setCategoryPrintMessage($tempCategory, true, $tempArray[1]); }
				return $this->setCategoryPrintMessage($tempCategory, false, "diwajibkan memilih salah satu");
			}
		}
		return $this->setCategoryPrintMessage($tempCategory, false, "kode anda rubah dari standar");
	}
	//check title - format - valid
	public function getCheckTitleFinalTask($tempValueTitle="",$tempCategory=0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempValueTitle == "")	return $this->setCategoryPrintMessage($tempCategory, true, "valid"); //boleh kosong tau tidak
		$tempValueTitle = $this->inputJaservFilter->textFiltering($tempValueTitle);
		return $this->setCategoryPrintMessage($tempCategory, $tempValueTitle[0], $tempValueTitle[1]);
	}
	//check password - format - valid
	public function getCheckPassword($tempValuePass="",$tempCategory=0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempValuePass == "") return $this->setCategoryPrintMessage($tempCategory, false, "password tidak boleh kosong");
		$tempValuePass = $this->inputJaservFilter->passwordFiltering($tempValuePass);
		return $this->setCategoryPrintMessage($tempCategory, $tempValuePass[0], $tempValuePass[1]);
	}
	//-->
}