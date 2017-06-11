<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Aktor/Pegawai.php";
class Dosen extends Pegawai{
	public function __CONSTRUCT(Inputjaservfilter $tempInputJaservFilter = null){
		parent::__CONSTRUCT();
		$this->levelCode = 'D';
		$this->inputJaservFilter = $tempInputJaservFilter;
	}
	//public function 
	//<--
	public function getCheckBidang($tempValue = "",$cat = 0){
		if($tempValue == "")
			return $this->setCategoryPrintMessage($cat, true, "valid"); //boleh kosong tau tidak
		$tempValue = $this->inputJaservFilter->textFiltering($tempValue);
		return $this->setCategoryPrintMessage($cat, $tempValue[0], $tempValue[1]);
	}
	public function getCheckLokasi($tempValue = "",$cat = 0){
		if($tempValue == "")
			return $this->setCategoryPrintMessage($cat, true, "valid"); //boleh kosong tau tidak
		$tempValue = $this->inputJaservFilter->textFiltering($tempValue);
		return $this->setCategoryPrintMessage($cat, $tempValue[0], $tempValue[1]);
	}
	//-->
}