<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlDosen extends LibrarySupport {
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	//optimized
	//use - III
	public function getAllData($identified = null,$status = null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Guru');
		if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setIdentified("".$identified."",true);
			$tempObjectDB->setWhere(1);
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(5);
			}
		}else{
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(3);
			}
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getDataByNip($nip = null,$status=1){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Guru');
		if(!is_null($nip)){
			$tempObjectDB->setNip("".$nip."",true);
			$tempObjectDB->setWhere(4);	
			if(!is_null($status)){
				$tempObjectDB->setStatus("".$status."",true);
				$tempObjectDB->setWhere(2);	
			}
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		}else{
			return false;
		}
	}
	//optimized
	//use - I
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function getDataByStatus($status = 1){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Guru');
		$tempObjectDB->setStatus("".$status."",true);
		$tempObjectDB->setWhere(3);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function addNewData($tempData){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempData['identified'] = $this->generateIdentified("D");
		$tempObjectDB->setIdentified($tempData['identified']);
		$tempObjectDB->setNickName(md5(sha1(md5(sha1(md5($tempData['nickname'])).sha1("account").md5(sha1($tempData['nickname']))).sha1("SIKTA"))));
		$tempObjectDB->setKeyWord(md5(sha1(md5($tempData['keyword'])).md5(sha1($tempData['keyword']))));
		$tempObjectDB->setFailedLogin("0");
		if(!$this->gateControlModel->executeObjectDB($tempObjectDB)->addData()){
			return false;
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Guru');
		$tempObjectDB->setIdentified($tempData['identified']);
		$tempObjectDB->setNip($tempData['nip']);
		$tempObjectDB->setNama($tempData['nama']); 
		if(!$this->gateControlModel->executeObjectDB($tempObjectDB)->addData()){
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
			$tempObjectDB->setIdentified($tempObjectDB);
			$this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
			return false;
		}
		return true;
	}
}