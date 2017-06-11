<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once APPPATH."libraries/Aktor/Pegawai.php";
class Jabatan extends Pegawai {
    public function __CONSTRUCT(){
        parent::__CONSTRUCT();
    }
	public function getCheckKodeUsername($tempValue="",$tempCategory=0){
		if(($tempValue=="") || ($tempValue == null)){
			return $this->setcategoryPrintMessage($tempCategory, false, "nilai tidak boleh kosong");
		}
		if(!preg_match("/^[A-Z-]*$/",$tempValue))
			return $this->setcategoryPrintMessage($tempCategory,false,"username mengandung karakter yang tidak diizinkan");
		if(!strpos($tempValue, "-"))
			return $this->setcategoryPrintMessage($tempCategory, false, "Username tidak valid");
		if(!$this->inputJaservFilter->isContainAlphabetUpper($tempValue))
			return $this->setcategoryPrintMessage($tempCategory, false, "Username tidak valid");
		return $this->setcategoryPrintMessage($tempCategory, true, "valid");
	}
}