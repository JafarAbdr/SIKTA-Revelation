<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);

class Librarian {
	protected $CI;
	public function setModel($a){$this->CI->load->model($a);$this->$a = $this->CI->$a;}
	public function setHelper($a){$this->CI->load->helper($a);}
	public function setLibrary($a){	$this->CI->load->library($a);$this->$a = $this->CI->$a;}
	protected function loadMod($nama,$return = false){
		$this->setModel($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->$nama))
			$tempObject = $this->$nama;
		$this->$nama = null;
		if($return)
			return $tempObject;
	}
	protected function loadLib($nama,$return = false){
		$this->setLibrary($nama);
		$nama = strtolower($nama);
		$tempObject = null;
		if(isset($this->$nama)) 
			$tempObject = $this->$nama;
		$this->$nama = null;
		if($return)
			return $tempObject;
	}
	public function __CONSTRUCT(){
		$this->CI = &get_instance();
		
	}
	/*return*/
	protected function getMessage($bool=false,$message=null){
		if(!is_bool($bool)) $bool = false;
		if(is_null($message)){
			return $bool;
		}else{
			return array($bool,$message);
		}
	}
	protected function getFalse($message=null){
		return $this->getMessage(false,$message);
	}
	protected function getTrue($message=null){
		return $this->getMessage(true,$message);
	}
}