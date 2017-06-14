<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
require_once APPPATH."libraries/Datejaservfilter.php";
class ControlAdmin extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	public function getDataByIdentified($identified=null){
		if(is_null($identified)) return false;
		if(!$this->filterIdentified($identified)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Admin');
		$tempObjectDB->setIdentified($identified,true);
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function updateInformasiAdmin($tempData){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Admin');
		
		$tempObjectDB->setIdentified($tempData['identified'],true);
		$tempObjectDB->setEmail($tempData['email']);
		$tempObjectDB->setNama($tempData['nama']);
		$tempObjectDB->setNoHp($tempData['nohp']);
		$tempObjectDB->setKajur($tempData['kajur']);
		$tempObjectDB->setWakil($tempData['wakil']);
		$tempObjectDB->setTaSDurasi($tempData['tasd']);
		$tempObjectDB->setTaDDurasi($tempData['tadd']);
		$tempObjectDB->setNip($tempData['nip']);
		$tempObjectDB->setAlamat($tempData['alamat']);
		
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	public function getDataByStatus($status = 1){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('admin');
		$tempObjectDB->setStatus($status,true);
		$tempObjectDB->setWhere(2);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	public function getTADurasi($ta = 1,$status=1){
		if(is_null($ta)) return false;
		if(is_null($status)) return false;
		$tempObjectDB = $this->getDataByStatus($status);
		if($tempObjectDB->getNextCursor()){
			switch($ta){
				case 1 :
					return  $tempObjectDB->getTaSDurasi();
				break;
				case 2 :
					return  $tempObjectDB->getTaDDurasi();
				break;
			}	
		}
		return false;
	}
	public function isAvailableroomOnThisSemester($mulai,$berakhir,$tahunak=null,$ruang=1,$cat=0,$returnID=false){
		$dateJaservFilter = new Datejaservfilter();
		//$this->loadLib('ControlMahasiswa');
		if($dateJaservFilter->nice_date($mulai,"Y-m-d H:i:s") == "Invalid Date"){
			return $this->setCategoryPrintMessage($cat,false,"tanggal yang anda masukan tidak valid");
		}
		if($dateJaservFilter->nice_date($berakhir,"Y-m-d H:i:s") == "Invalid Date"){
			return $this->setCategoryPrintMessage($cat,false,"tanggal yang anda masukan tidak valid");
		}
		if($dateJaservFilter->nice_date($mulai,"Y-m-d") != $dateJaservFilter->nice_date($berakhir,"Y-m-d")){
			return $this->setCategoryPrintMessage($cat,false,"tanggal yang anda masukan lebih dari 1 hari");
		}
		if(!$dateJaservFilter->setDate($mulai,true)->isBefore($berakhir)){
			return $this->setCategoryPrintMessage($cat,false,"waktu berakhir sesudah waktu mulai");
		}
		if($dateJaservFilter->setDate($mulai,true)->isBefore(date("Y-m-d H:i:s"))){
			return $this->setCategoryPrintMessage($cat,false,"waktu Dimulai hari Ini");
		}
		$id="";
		$error = 0;
		//if($tahunak == null)
			//return $this->setCategoryPrintMessage($cat,false,"tahun akademik tidak boleh kosong");
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWaktu($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$states="TD";
		$statesD="2_";
		if($ruang == 1) {
			$states="TS";
			$states="1_";
		}
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
				$tempMahasiswa->setCaseData(1);
				$tempMahasiswa->setIdentified($tempObjectDB->getMahasiswa(),true);
				$tempMahasiswa->setWhere(1);
				$tempMahasiswa = $this->gateControlModel->executeObjectDB($tempMahasiswa)->takeData();
				$tempMahasiswa->getNextCursor();
				$id = $states."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu()).$statesD.$tempMahasiswa->getNim();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getWaktuEnd(),true)->getDate("Y-m-d H:i:s");
				//$tempEnd = $dateJaservFilter->setPlusOrMinMinute($this->getTADurasi(1),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}
			
		}
		
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan seminar sebelum anda");
				else{
					return array(FALSE,"Maaf, waktu anda tabrakan dengan seminar sebelum anda",$id);
				}
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan seminar sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan seminar sesudah anda",$id);
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWaktu($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(6);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		$error = 0;
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
				$tempMahasiswa->setCaseData(1);
				$tempMahasiswa->setIdentified($tempObjectDB->getMahasiswa(),true);
				$tempMahasiswa->setWhere(1);
				$tempMahasiswa = $this->gateControlModel->executeObjectDB($tempMahasiswa)->takeData();
				$tempMahasiswa->getNextCursor();
				$id = $states."".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getWaktu()).$statesD.$tempMahasiswa->getNim();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getWaktu(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getWaktuEnd(),true)->getDate("Y-m-d H:i:s");
				//$tempEnd = $dateJaservFilter->setPlusOrMinMinute($this->getTADurasi(2),true)->getDate("Y-m-d H:i:s"); 
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}
			
		}
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan sidang sebelum anda");
				else{
					return array(FALSE,"Maaf, waktu anda tabrakan dengan sidang sebelum anda",$id);
				}
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan sidang sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan sidang sesudah anda",$id);
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Acara');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setmulai($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		
		
		
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$id = "AC".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getMulai(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getBerakhir(),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}
		}
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda",$id);
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda",$id);
		}
		$tempMorning = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 07:30:00";
		$tempEvening = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 15:00:00";
		if($dateJaservFilter->setDate($mulai,true)->isBefore($tempMorning)){
			$error+=1;
		}
		if($dateJaservFilter->setDate($mulai,true)->isAfter($tempEvening)){
			$error+=2;
		}
		if($error > 0){
			if($error == 1)
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 07.30 adalah waktu paling pagi");
			else
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 02.00 adalah waktu paling sore utuk TA 1");
		}
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Pinjam');
		$tempObjectDB->setRuang($ruang,true);
		$tempObjectDB->setmulai($dateJaservFilter->nice_date($mulai,"Y-m-d"),true);
		$tempObjectDB->setWhere(4);
		$tempObjectDB = $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
		
		
		
		if($tempObjectDB->getCountData() > 0){
			while($tempObjectDB->getNextCursor()){
				$id = "AC".$tempObjectDB->getTahunAk()."_".str_ireplace(" ",".",$tempObjectDB->getMulai()).$tempObjectDB->getRuang();
				$tempStart = $dateJaservFilter->setDate($tempObjectDB->getMulai(),true)->getDate("Y-m-d H:i:s");
				$tempEnd = $dateJaservFilter->setDate($tempObjectDB->getBerakhir(),true)->getDate("Y-m-d H:i:s");
				if($dateJaservFilter->setDate($mulai,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=1;
					break;
				}
				if($dateJaservFilter->setDate($berakhir,true)->isAfterAndNow($tempStart,true)->isBeforeAndNow($tempEnd)){
					$error+=2;
					break;
				}
			}
		}
		if($error > 0){
			if($error == 1)
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sebelum anda",$id);
			else
				if(!$returnID)
					return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda");
				else
					return array(FALSE,"Maaf, waktu anda tabrakan dengan Acara lain sesudah anda",$id);
		}
		$tempMorning = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 07:30:00";
		$tempEvening = $dateJaservFilter->nice_date($mulai,"Y-m-d")." 15:00:00";
		if($dateJaservFilter->setDate($mulai,true)->isBefore($tempMorning)){
			$error+=1;
		}
		if($dateJaservFilter->setDate($mulai,true)->isAfter($tempEvening)){
			$error+=2;
		}
		if($error > 0){
			if($error == 1)
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 07.30 adalah waktu paling pagi");
			else
				return $this->setCategoryPrintMessage($cat,FALSE,"Maaf, 02.00 adalah waktu paling sore utuk TA 1");
		}
		return $this->setCategoryPrintMessage($cat,true,"waktu di terima");
	}
}