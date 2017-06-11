<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Aktor/Jabatan.php";
class Koordinator extends Jabatan{
	public function __CONSTRUCT(Inputjaservfilter $tempInputJaservFilter = null){
		parent::__CONSTRUCT();
		$this->levelCode = 'K';
		$this->inputJaservFilter = $tempInputJaservFilter;
	}
	//public function 
	public function getCheckTitle($value="",$cat=0){
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputJaservFilter->titleFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
	//check format suatu isi text - valid
	public function getCheckSummary($value="",$cat=0){
		if(($value=="") || ($value == null)){
			return $this->setCategoryPrintMessage($cat, false, "nilai tidak boleh kosong");
		}
		$temp = $this->inputJaservFilter->textFiltering($value);
		return $this->setCategoryPrintMessage($cat, $temp[0], $temp[1]);
	}
}