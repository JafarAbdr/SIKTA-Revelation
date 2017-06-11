<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once APPPATH."libraries/Aktor/Aktor.php";
class Pegawai extends Aktor {
    public function __CONSTRUCT(){
        parent::__CONSTRUCT();
    }
	public function getCheckNip($tempNip="",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if($tempNip == "")
			return $this->setCategoryPrintMessage($cat, false, "Nip tidak boleh kosong");
		if(!$this->inputJaservFilter->numberFiltering($tempNip)[0])
			return $this->setCategoryPrintMessage($tempCategory, false, "Nip mengandng karakter lain");
		if((strlen($tempNip)>=17)&&(strlen($tempNip) <= 20))
			return $this->setCategoryPrintMessage($tempCategory, true, "valid");
		else 
			return $this->setCategoryPrintMessage($tempCategory, false, "Nip tidak valid");
	}
	public function getCheckPassword($tempValue="",$tempCategory = 0){
		if(is_null($this->inputJaservFilter)) return $this->setCategoryPrintMessage($tempCategory, false, "Filter belum diinisialisasi");
		if(($tempValue=="") || ($tempValue == null)){
			return $this->setCategoryPrintMessage($tempCategory, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputJaservFilter->passwordFiltering($tempValue);
		return $this->setCategoryPrintMessage($tempCategory, $temp[0], $temp[1]);
		
	}
}