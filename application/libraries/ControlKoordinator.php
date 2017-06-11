<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
require_once APPPATH."libraries/Datejaservfilter.php";
class ControlKoordinator  extends LibrarySupport{
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	//optimized
	public function getDataByStatus($status = 1){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Koordinator');
		$tempObjectDB->setStatus("".$status."",true);
		$tempObjectDB->setWhere(3);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getAllData($identified = null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Koordinator');
		if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setIdentified("".$identified."",true);
			$tempObjectDB->setWhere(1);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function setNewGanjilGenapConstrain($identified,$ganjilMonth,$ganjilDay,$genapMonth,$genapDay){
		$ganjil = $ganjilMonth."|".$ganjilDay;
		$genap = $genapMonth."|".$genapDay;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Koordinator');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setStartGanjil($ganjil);
		$tempObjectDB->setStartGenap($genap);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	//repair
	public function setNewKoordinator($identified){
		$tempObjectDB = $this->getDataByStatus();
		if(!$tempObjectDB->getNextCursor()) return false;
		$tempDate = date("Y-m-d H:i:s");
		if($tempObjectDB->getDosenK() != $identified){
			if($tempObjectDB->getDosenK() != "" && $tempObjectDB->getDosenK() != " "){
				$tempMulai = $tempObjectDB->getMulai();
				$tempDosen = $tempObjectDB->getDosenK();
				$tempIdentified = $this->generateIdentified("K");
				$tempObjectDB->setWhere(1);
				$tempObjectDB->setMulai($tempDate);
				$tempObjectDB->setBerakhir("0000-00-00 00:00:00");
				$tempObjectDB->setDosenK($identified);
				if($this->gateControlModel->executeObjectDB($tempObjectDB)->updateData()){
					$tempObjectDB->setIdentified($tempIdentified);
					$tempObjectDB->setDosenK($tempDosen);
					$tempObjectDB->setMulai($tempMulai);
					$tempObjectDB->setBerakhir($tempDate);
					$tempObjectDB->setStatus(2);
					return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
				}else
					false;
			}else{
				$tempObjectDB->setWhere(1);
				$tempObjectDB->setMulai($tempDate);
				$tempObjectDB->setBerakhir("0000-00-00 00:00:00");
				$tempObjectDB->setDosenK($identified);
				return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
			}
			
		}else 
			return false;
	}
}