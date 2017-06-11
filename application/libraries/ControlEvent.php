<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlEvent extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	//dokumented - optimized
	//take any data with by kode statue or title or three of it
	public function getAllData($kode=null, $status=null,$judul=null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Kejadian');
		if(!is_null($kode)){
			$tempObjectDB->setKode($kode,true);
			$tempObjectDB->setWhere(3);
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(5);
				if(!is_null($judul)){
					$tempObjectDB->setJudul($judul,true);
					$tempObjectDB->setWhere(8);
				}
			}else{
				if(!is_null($judul)){
					$tempObjectDB->setJudul($judul,true);
					$tempObjectDB->setWhere(6);
				}
			}
		}else{
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(4);
				if(!is_null($judul)){
					$tempObjectDB->setJudul($judul,true);
					$tempObjectDB->setWhere(7);
				}
			}else{
				if(!is_null($judul)){
					$tempObjectDB->setJudul($judul,true);
					$tempObjectDB->setWhere(9);
				}else
					$tempObjectDB->setWhere(2);
			}
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}

	public function getDataByTahunAk($tahunak=null,$kode=1,$status=1){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Kejadian');
		if(!is_null($tahunak)){
			$tempObjectDB->setTahunAk($tahunak,true);
			$tempObjectDB->setKode($kode,true);
				$tempObjectDB->setWhere(11);
			if(!is_null($status)){
				$tempObjectDB->setStatus($status,true);
				$tempObjectDB->setWhere(10);
			}
		}else{
			return false;
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getDataByIdentified($identified = null){
		if(is_null($identified)) return false;
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Kejadian');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function setAktifAkademikRegistrasi($mulai,$berakhir,$judul,$isi,$tahunak){
		$tempObjectDB = $this->getAllData(1,1);
		if(!$tempObjectDB) return false;
		if($tempObjectDB->getNextCursor()){
			if(intval($tempObjectDB->getTahunAk()) == intval($tahunak)){
				$tempObjectDB->setMulai($mulai);
				$tempObjectDB->setBerakhir($berakhir);
				$tempObjectDB->setJudul($judul);
				$tempObjectDB->setIsi($isi);
				$tempObjectDB->setWhere(1);
				return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
			}else{
				$tempObjectDB->setStatus(2);
				$tempObjectDB->setWhere(1);
				if($this->gateControlModel->executeObjectDB($tempObjectDB)->updateData()){
					$this->resetAllPermissionOfMahasiswaOnNewAkademik();
					$tempObjectDB->resetValue();
					$tempObjectDB->setTahunAk($tahunak);
					$tempObjectDB->setIdentified($this->generateIdentified("E",1));
					$tempObjectDB->setMulai($mulai);
					$tempObjectDB->setBerakhir($berakhir);
					$tempObjectDB->setJudul($judul);
					$tempObjectDB->setIsi($isi);
					$tempObjectDB->setStatus(1);
					$tempObjectDB->setKode(1);
					return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
				}else{
					return false;
				}
			}
		}else{
			$this->resetAllPermissionOfMahasiswaOnNewAkademik();
			$tempObjectDB->resetValue();
			$tempObjectDB->setTahunAk($tahunak);
			$tempObjectDB->setIdentified($this->generateIdentified("E",1));
			$tempObjectDB->setMulai($mulai);
			$tempObjectDB->setBerakhir($berakhir);
			$tempObjectDB->setJudul($judul);
			$tempObjectDB->setIsi($isi);
			$tempObjectDB->setStatus(1);
			$tempObjectDB->setKode(1);
			return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
		}
	}
	public function setAktifAkademikEvent($mulai,$berakhir,$judul,$isi,$identified){
		if(is_null($identified)) return false;
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Kejadian');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setBerakhir($berakhir);
		$tempObjectDB->setStatus(1);
		$tempObjectDB->setMulai($mulai);
		$tempObjectDB->setJudul($judul);
		$tempObjectDB->setIsi($isi);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	protected function resetAllPermissionOfMahasiswaOnNewAkademik(){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Murid');
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$tempObjectDB->setFormBaru(1);
				$tempObjectDB->setRegistrasiBaru(2);
				$tempObjectDB->setRegistrasiLama(2);
				$tempObjectDB->setTanpaWaktu(2);
				$tempObjectDB->setWhere(1);
				$this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
			}
		}
		return true;
	}
	public function setNewAktifAkademikEvent($mulai,$berakhir,$judul,$isi,$tahunak){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Kejadian');
		$tempObjectDB->setIdentified($this->generateIdentified("E",1));
		$tempObjectDB->setTahunAk($tahunak);
		$tempObjectDB->setMulai($mulai);
		$tempObjectDB->setBerakhir($berakhir);
		$tempObjectDB->setJudul($judul);
		$tempObjectDB->setIsi($isi);
		$tempObjectDB->setStatus(1);
		$tempObjectDB->setkode(3);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
}