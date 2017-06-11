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
	public function tryToDeactivated($nip=null,$tahunak=null){
		if(is_null($tahunak)) return false;
		if(is_null($nip)) return false;
		$tempObjectDB = $this->getDataByNip($nip,null);
		
		if(!$tempObjectDB->getNextCursor()) return false;
		//is koordinator
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Koordinator');
		$tempObjectDBD->setStatus(1,true);
		$tempObjectDBD->setWhere(3);
		$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
		$tempObjectDBD->getNextCursor();
		if($tempObjectDBD->getDosenK() == $tempObjectDB->getIdentified())
			return false;
		//is wakil or kajur
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Admin');
		$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
		$tempObjectDBD->getNextCursor();
		if($tempObjectDBD->getKajur() == $tempObjectDB->getIdentified())
			return false;
		if($tempObjectDBD->getWakil() == $tempObjectDB->getIdentified())
			return false;
		//is have any member
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDBD->setTahunAk($tahunak,true);
		$tempObjectDBD->setStatus(1,true);
		$tempObjectDBD->setDataStatus(0,true);			
		$tempObjectDBD->setDosen($tempObjectDB->getIdentified(),true);
		$tempObjectDBD->setWhere(4);
		$tempObjectDBD = $this->gateControlModel->executeObjectDB($tempObjectDBD)->takeData();
		//if($tempObjectDBD->getCountData() <= 0) return true;
		$error=0;
		while($tempObjectDBD->getNextCursor()){
			$tempObjectDBE = $this->gateControlModel->loadObjectDB('Seminar');
			$tempObjectDBE->setTahunAk($tahunak,true);
			$tempObjectDBE->setMahasiswa($tempObjectDBD->getIdentified(),true);
			$tempObjectDBE->setStatus(1,true);
			$tempObjectDBE->setDataStatus(0,true);
			$tempObjectDBE->setWhere(4);
			$tempObjectDBE = $this->gateControlModel->executeObjectDB($tempObjectDBE)->takeData();
			if($tempObjectDBE->getNextCursor()) $error++;
			$tempObjectDBE = $this->gateControlModel->loadObjectDB('Sidang');
			$tempObjectDBE->setTahunAk($tahunak,true);
			$tempObjectDBE->setMahasiswa($tempObjectDBD->getIdentified(),true);
			$tempObjectDBE->setStatus(1,true);
			$tempObjectDBE->setDataStatus(0,true);
			$tempObjectDBE->setWhere(7);
			$tempObjectDBE = $this->gateControlModel->executeObjectDB($tempObjectDBE)->takeData();
			if($tempObjectDBE->getNextCursor()) $error++;
		}
		//exit("kkk");
		if($error>0) return false;
		$tempObjectDBD->resetSendRequest();
		While($tempObjectDBD->getNextCursor()){
			$tempObjectDBD->setDataProses(1);
			$tempObjectDBD->setDosen("0");
			$tempObjectDBD->setWhere(3);
			$this->gateControlModel->executeObjectDB($tempObjectDBD)->updateData();
		}
		$tempObjectDB->setStatus(2);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function ActivateDosen($nip){
		$tempObjectDB = $this->getDataByNip($nip,null);
		if(!$tempObjectDB->getNextCursor()) return false;
		$tempObjectDB->setStatus(1);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
}