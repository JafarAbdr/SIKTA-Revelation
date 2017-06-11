<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlSeminar extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	//optimized
	public function getAllDataWithMahasiswa($tahunAk=null,$status="1", $dataproses = '2'){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setDataProses($dataproses,true);
			$tempObjectDB->setWhere(2);
			
		}
		$tempObjectDB->setWhereMultiple(1);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempMahasiswa);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//optimized
	public function getAllData($tahunAk=null,$status="1", $dataproses = '2'){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setDataProses($dataproses,true);
			$tempObjectDB->setWhere(2);
			
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//optimized
	public function getAllDataHaveATime($tahunAk=null,$status="1"){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(3);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//optimized
	public function getAllDataHaveATimeWithMahasiswa($tahunAk=null,$status="1"){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(3);
		}
		$tempObjectDB->setWhereMultiple(1);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempMahasiswa);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//optimized
	public function getDataByMahasiswa($tahunAk=null,$mahasiswa=null,$status="1"){
		if(is_null($tahunAk)) return false;
		if(is_null($mahasiswa)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		if(is_null($status)){
			$tempObjectDB->setWhere(6);
		}else{
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(5);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//optimized 
	//try logging last regist seminar
	public function logSeminarActive($tahunAk=null, $identified = null){
		if(is_null($tahunAk)) return false;
		if(is_null($identified)) return false;
		$tempObjectDB = $this->getDataByMahasiswa($tahunAk,$identified);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Seminar');
		$tempObjectDBD->setTahunAk($tempObjectDB->getTahunAk(),true);
		$tempObjectDBD->setStatus($tempObjectDB->getStatus(),true);
		$tempObjectDBD->setMahasiswa($tempObjectDB->getMahasiswa(),true);
		$tempObjectDBD->setWhere(5);
		$tempObjectDB->setStatus(2);
		$tempObjectDB->setIdentified($this->generateIdentified("S",1));
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData($tempObjectDBD);
	}
	//optimized
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	//optimized
	public function addNew(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setIdentified($this->generateIdentified("S",1));
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
}