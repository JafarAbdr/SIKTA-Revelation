<?php
/*
Directory Library
->LoginFilter.php
-))untuk mengontrol proses login, logout, maupun mengecek apakah sudah login atau belum
--::
-?isLogin
--))untuk mengecek apakah ada user yang login sebelumnya
-?setLogOut
--))untuk menghapus status login user yang aktif
-?setLogIn
--))untuk mengaktifkan status login user

Status Class
level fix 1 - 10
level fix current 5
*/
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Aktor/Aktor.php";
require_once APPPATH."libraries/LibrarySupport.php";
class LoginFilter extends LibrarySupport {
	private $functionOpen;
	private $session;
	private $gateControlModel;
	public function __CONSTRUCT($tempSession = null, GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->session = $tempSession;
		$this->gateControlModel = $tempGateControlModel;
		
	}
	public function getIdentifiedActive(){
		if(is_null($this->session)) return false;
		if(!$this->session->has_userdata('id_active_account')) return false;
		$tempId = $this->session->userdata("id_active_account");
		return $tempId;
	}
	//complex
	public function isLogin(Aktor $tempAktor=null){
		if(is_null($this->session)) return false;
		if(is_null($tempAktor)) return false;
		if(!$this->session->has_userdata('id_active_account')) return false;
		$tempId = $this->session->userdata("id_active_account");
		if($tempId[0] != $tempAktor->getLevelCode()) return false;
		return $this->filterIdentified($tempId);
	}
	//complex - sequence ok
	public function isPasswordOfThisGuy($keyWord,$identified=null){
		if(is_null($identified)){
			$identified = $this->getIdentifiedActive();
			if(!$identified) return false;
		}
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempObjectDB->getNextCursor();
		//exit($tempObjectDB->getKeyWord()." ==== ".$this->getHashKeyWord($keyWord)."<br>");
		if($tempObjectDB->getKeyWord() == $this->getHashKeyWord($keyWord))
			return true;
		else
			return false;
	}
	//complex - sequence ok
	public function setNewPassword($keyWord,$identified=null){
		if(is_null($identified)){
			$identified = $this->getIdentifiedActive();
			if(!$identified) return false;
		}
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempObjectDB->getNextCursor();
		if($tempObjectDB->getKeyWord() == $this->getHashKeyWord($keyWord))
			return false;
		$tempObjectDB->setKeyWord($this->getHashKeyWord($keyWord));
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	protected function getHashKeyWord($keyWord){
		return md5(sha1(md5($keyWord)).md5(sha1($keyWord)));
	}
	protected function getHashNickName($nickName){
		return md5(sha1(md5(sha1(md5($nickName)).sha1("account").md5(sha1($nickName))).sha1("SIKTA")));
	}
	public function setLogOut(){
		if(is_null($this->session)) return false;
		$this->session->unset_userdata('id_active_account');
		return true;
	}
	//complex - sequence ok
	public function setLogIn($nickName=null, $keyWord=null){
		if(is_null($this->session)) return false;
		if(is_null($this->gateControlModel)) return false;
		if(is_null($nickName)) return false;
		if(is_null($keyWord)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempObjectDB->setNickName($this->getHashNickName($nickName),true);
		$tempObjectDB->setKeyWord($this->getHashKeyWord($keyWord),true);
		$tempObjectDB->setWhere(2);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		if(!$tempObjectDB->getNextCursor()) return false;
		if(is_null($tempObjectDB->getIdentified())) return false;
		$this->setLogOut();
		$this->session->set_userdata('id_active_account',$tempObjectDB->getIdentified());
		return true;
	}
}