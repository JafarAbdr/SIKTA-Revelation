<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlFile extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	public function getAllData(){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('UploadKoordinator');
		$tempObjectDB->setWhere(2);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function addFile($tempData = null){
		if(!is_array($tempData)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('UploadKoordinator');
		$tempObjectDB->setIdentified($this->getNewIdentified());
		$tempObjectDB->setDetail($tempData['detail']);
		$tempObjectDB->setNamaData($tempData['namadata']);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
	protected function getNewIdentified(){
		return "U((SIKTA((".date("Y(m(d/H)i)s");
	}
	public function updateFile($tempData = null){
		if(!is_array($tempData)) return false;
		if(!$this->filterIdentified($tempData['identified'])) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('UploadKoordinator');
		$tempObjectDB->setIdentified($tempData['identified'],true);
		$tempObjectDB->setDetail($tempData['detail']);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function deleteFile($identified=null){
		if(is_null($identified)) return false;
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('UploadKoordinator');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		$tempUpload = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$tempUpload->getNextCursor();
		//exit(str_ireplace("system\\","",BASEPATH)."upload/file/".$tempUpload->getNamaData());
		$tempBool = $this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
		//var_dump($tempBool);
		//exit();
		if($tempBool)
			unlink(str_ireplace("system\\","",BASEPATH)."upload/file/".$tempUpload->getNamaData());
		return $tempBool;
	}
}