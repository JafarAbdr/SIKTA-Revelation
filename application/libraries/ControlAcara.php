<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlAcara extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	public function getAllData($tahunAk=null,$ruang=null,$mulai = null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Acara');
		if(!is_null($tahunAk)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setWhere(1);
			if(!is_null($ruang)){
				$tempObjectDB->setRuang($ruang,true);
				$tempObjectDB->setWhere(3);
				if(!is_null($mulai)){
					$tempObjectDB->setMulai($mulai,true);
					$tempObjectDB->setWhere(5);
				}
			}
		}else if(!is_null($ruang)){
			$tempObjectDB->setRuang($ruang,true);
			$tempObjectDB->setWhere(2);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function addAcara($tempData = null){
		if(!is_array($tempData)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Acara');
		$tempObjectDB->setTahunAk($tempData['tahunak']);
		$tempObjectDB->setIdentified($this->generateIdentified("C",1));
		$tempObjectDB->setMulai($tempData['mulai']);
		$tempObjectDB->setBerakhir($tempData['berakhir']);
		$tempObjectDB->setDetail($tempData['detail']);
		$tempObjectDB->setPenanggungJawab($tempData['penanggungjawab']);
		$tempObjectDB->setRuang($tempData['ruang']);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
	public function updateAcara($tempData = null,ObjectDBModel $objectDB=null){
		if(!is_array($tempData)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Acara');
		$tempObjectDB->setTahunAk($tempData['tahunak'],true);
		$tempObjectDB->setMulai($tempData['mulai'],true);
		$tempObjectDB->setBerakhir($tempData['berakhir']);
		$tempObjectDB->setDetail($tempData['detail']);
		$tempObjectDB->setPenanggungJawab($tempData['penanggungjawab']);
		$tempObjectDB->setRuang($tempData['ruang'],true);
		if(is_null($objectDB)){
			$tempObjectDB->setWhere(6);
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
		}
		else
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData($objectDB);
	}
	public function deleteAcara($tempData = null){
		if(!is_array($tempData)) return false;
		$tempObjectDB = $this->getAllData($tempData['tahunak'],$tempData['ruang'],$tempData['mulai']);
		if(!$tempObjectDB->getNextCursor()){
			return false;
		}
		$tempObjectDB->setWhere(6);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
	}
}