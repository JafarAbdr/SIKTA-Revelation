<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
require_once APPPATH."libraries/Datejaservfilter.php";
class ControlMahasiswa extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
		
	}
	//complex - sequence ok
	public function getAllData($identified = null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Murid');
		if(!is_null($identified)){
			if(!$this->filterIdentified($identified)) return false;
			$tempObjectDB->setIdentified("".$identified."",true);
			$tempObjectDB->setWhere(1);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//complex - sequence ok
	//use - II
	public function getDataByNama($nama = null,$status=1,$dosenId=null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Murid');
		$status = intval($status);
		if(!is_null($nama)){
			$tempObjectDB->setNama($nama,true);
			$tempObjectDB->setStatus($status,true);
			$tempObjectDB->setWhere(5);
			if(!is_null($dosenId)){
				$tempObjectDB->setDosenS($dosenId,true);
				$tempObjectDB->setDosenD($dosenId,true);
				$tempObjectDB->setDosenT($dosenId,true);
				$tempObjectDB->setWhere(6);
			}
		}else{
			return false;
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		
		
	}
	//complex - sequence ok
	public function getDataByNim($nim = null){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Murid');
		if(!is_null($nim)){
			$tempObjectDB->setNim("".$nim."",true);
			$tempObjectDB->setWhere(2);
		}else{
			return false;
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function setNewTanpaWaktu($nim = null){
		$tempObjectDB = $this->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			return false;
		}
		if(intval($tempObjectDB->getStatus()) != 1) return false;
		if(intval($tempObjectDB->getTanpaWaktu()) == 1){
			$tempObjectDB->setTanpaWaktu(2);
		}else{
			$tempObjectDB->setTanpaWaktu(1);
		}
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function setNewStatus($nim = null){
		$tempObjectDB = $this->getDataByNim($nim);
		//echo "koko";
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			return false;
		}
		//echo "koko";
		if(intval($tempObjectDB->getStatus()) == 1){
			$tempObjectDB->setStatus(2);
		}else{
			$tempObjectDB->setStatus(1);
		}
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	//complex - sequence ok
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function trySendEmail($nim,$waktuCookie,$kodeCookie){
		$tempObjectDB = $this->getDataByNim($nim);
		if(!$tempObjectDB->getNextCursor()){
			return false;
		}
		if($tempObjectDB->getStatus() == '2') return false;
		if(!valid_email($tempObjectDB->getEmail())) return false;
		$email = $tempObjectDB->getEmail();
		//$tempObjectDB->setIdentified($tempObjectDB->getIdentified(),true);
		$tempObjectDB->setKodeCookie($kodeCookie);
		$tempObjectDB->setWaktuCookie($waktuCookie);
		$tempObjectDB->setWhere(1);
		if(!$this->gateControlModel->executeObjectDB($tempObjectDB)->updateData()) return false;
		return $email;
	}
	public function getDataByKodeCookie($kode=null){
		if($kode == null) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Murid');
		$tempObjectDB->setKodeCookie($kode,true);
		$tempObjectDB->setWhere(3);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function setOverWaktuCookie($kode=null,$waktuCookie=null){
		//echo "lo";
		$tempObjectDB = $this->getDataByKodeCookie($kode);
		if(!$tempObjectDB) return false;
		if(!$tempObjectDB->getNextCursor()) return false;
		if(is_null($waktuCookie))return false;
		//echo $tempObjectDB->getIdentified();
		$tempObjectDB->setWaktuCookie($waktuCookie);
		$tempObjectDB->setWhere(1);
		//return true;
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function addNewData($tempData){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
		$tempData['identified'] = $this->generateIdentified("M");
		$tempObjectDB->setIdentified($tempData['identified']);
		$tempObjectDB->setNickName(md5(sha1(md5(sha1(md5($tempData['nickname'])).sha1("account").md5(sha1($tempData['nickname']))).sha1("SIKTA"))));
		$tempObjectDB->setKeyWord(md5(sha1(md5($tempData['keyword'])).md5(sha1($tempData['keyword']))));
		$tempObjectDB->setFailedLogin("0");
		if(!$this->gateControlModel->executeObjectDB($tempObjectDB)->addData()){
			return false;
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Murid');
		$tempObjectDB->setIdentified($tempData['identified']);
		$tempObjectDB->setNim($tempData['nim']);
		$tempObjectDB->setNama($tempData['nama']); 
		$tempObjectDB->setEmail($tempData['email']);	
		$tempObjectDB->setNoHp($tempData['nohp']); 
		$tempObjectDB->setAktifTahun($tempData['aktiftahun']); 
		$tempObjectDB->setNamaFoto($tempData['namafoto']); 
		$tempObjectDB->setNamaTranskrip($tempData['namatranskrip']); 
		$tempObjectDB->setKodeCookie(md5($tempData['nim'].DATE('Y-m-d')));
		if(!$this->gateControlModel->executeObjectDB($tempObjectDB)->addData()){
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Pengguna');
			$tempObjectDB->setIdentified($tempObjectDB);
			$this->gateControlModel->executeObjectDB($tempObjectDB)->deleteData();
			return false;
		}
		return true;
	}
	public function isMyDosenReview($dosen,$mahasiswa = null){
		if($mahasiswa == null) return false;
		if($dosen == null) return false;
		$tempObjectDB = $this->getAllData($mahasiswa);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		if($tempObjectDB->getDosenS() == $dosen){
			return true;
		}
		if($tempObjectDB->getDosenD() == $dosen){
			return true;
		}
		if($tempObjectDB->getDosenT() == $dosen){
			return true;
		}
		return false;
	}
	//optimized - fix
	//menaambahkan dosen favorit
	public function setAddNewFavor($dosen,$mahasiswa){
		if($mahasiswa == null) return false;
		if($dosen == null) return false;
		$tempObjectDB = $this->getAllData($mahasiswa);
		if(!$tempObjectDB | !$tempObjectDB->getNextCursor()) return false;
		if(strlen($tempObjectDB->getDosenS()) != 40){
			$tempObjectDB->setDosenS($dosen);
			return $this->tryUpdate($tempObjectDB);
		}else if(strlen($tempObjectDB->getDosenD()) != 40){
			$tempObjectDB->setDosenD($dosen);
			return $this->tryUpdate($tempObjectDB);
		}else if(strlen($tempObjectDB->getDosenT()) != 40){
			$tempObjectDB->setDosenT($dosen);
			return $this->tryUpdate($tempObjectDB);
		}
		return false;
	}
	//optimized
	//remove dosenfavorite - valid
	public function setRemoveOldFavor($dosen,$mahasiswa){
		if($mahasiswa == null) return false;
		if($dosen == null) return false;
		$tempObjectDB = $this->getAllData($mahasiswa);
		if(!$tempObjectDB | !$tempObjectDB->getNextCursor()) return false;
		if($tempObjectDB->getDosenS() == $dosen){
			$tempObjectDB->setDosenS(" ");
			return $this->tryUpdate($tempObjectDB);
		}else if($tempObjectDB->getDosenD() == $dosen){
			$tempObjectDB->setDosenD(" ");
			return $this->tryUpdate($tempObjectDB);
		}else if($tempObjectDB->getDosenT() == $dosen){
			$tempObjectDB->setDosenT(" ");
			return $this->tryUpdate($tempObjectDB);
		}
		return false;
	} 
}