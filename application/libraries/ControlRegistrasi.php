<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/LibrarySupport.php";
class ControlRegistrasi extends LibrarySupport {
	private $functionOpen;
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		parent::__CONSTRUCT();
		$this->gateControlModel = $tempGateControlModel;
	}
	//complex - sequence ok
	public function getAllData($tahunAk=null,$mahasiswa = null,$status="1" , $dataproses = '2'){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setStatus($status,true);
		$tempObjectDB->setDataProses($dataproses,true);
		if(!is_null($tahunAk) && !is_null($mahasiswa) && !is_null($status) && !is_null($dataproses)){
			$tempObjectDB->setWhere(3);
		}
		if(!is_null($tahunAk) && !is_null($mahasiswa) && !is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(4);
		}
		if(!is_null($tahunAk) && is_null($mahasiswa) && !is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(6);
		}
		if(!is_null($tahunAk) && is_null($mahasiswa) && !is_null($status)  && !is_null($dataproses)){
			$tempObjectDB->setWhere(2);
		}
		if(!is_null($tahunAk) && !is_null($mahasiswa) && is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(7);
		}
		if(is_null($tahunAk) && !is_null($mahasiswa) && is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(8);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
	//reverse
	//use - I
	public function getAllDataWithDosbing($tahunAk=null,$mahasiswa = null,$status="1" , $dataproses = '2',$mahasiswaEx = false){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		$tempDosbing = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempGuru = $this->gateControlModel->loadObjectDB('Guru');
		$tempDosbing->setStatus($status,true);
		$tempDosbing->setWhere(5);
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setStatus($status,true);
		$tempObjectDB->setDataProses($dataproses,true);
		if(!is_null($tahunAk) && !is_null($mahasiswa) && !is_null($status) && !is_null($dataproses)){
			$tempObjectDB->setWhere(12);
		}
		if(!is_null($tahunAk) && !is_null($mahasiswa) && !is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(13);
		}
		if(!is_null($tahunAk) && is_null($mahasiswa) && !is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(14);
		}
		if(!is_null($tahunAk) && is_null($mahasiswa) && !is_null($status)  && !is_null($dataproses)){
			$tempObjectDB->setWhere(11);
		}
		if(!is_null($tahunAk) && !is_null($mahasiswa) && is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(15);
		}
		if(is_null($tahunAk) && !is_null($mahasiswa) && is_null($status)  && is_null($dataproses)){
			$tempObjectDB->setWhere(16);
		}
		$tempDosbing->setWhereMultiple(3);
		$tempMultiple->addTable($tempDosbing);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->addTable($tempGuru);
		if(!$mahasiswaEx)
			return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
		$tempDosbing->setWhereMultiple(6);
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple->addTable($tempMahasiswa);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//end of reverse
	public function tryUpdate(ObjectDBModel $tempObjectDB){
		$tempObjectDB->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->updateData();
	}
	//error
	public function getDosenPembimbing($identified){
		if(!$this->filterIdentified($identified)) return false;
		$dosbing = $this->gateControlModel->loadObjectDB('Dosbing');
		$dosbing->setRegistrasi($identified,true);
		$dosbing->setStatus(1,true);
		$dosbing->setWhere(2);
		return $this->gateControlModel->executeObjectDB($dosbing)->takeData();
	}
	public function getListAllDosenBimbinganLog($mahasiswa=null){
		if(is_null($mahasiswa)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDBS = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setWhere(8);
		//$tempObjectDBS->setDosen("dosen",true);
		$tempObjectDBS->setWhere(6);
		$tempObjectDBS->setWhereMultiple(2);
		$tempMultiple->addTable($tempObjectDBS);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple->setCaseData(1);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//complex - sequence ok
	public function tryLog($tahunAk=null,$mahasiswa=null){
		if(is_null($tahunAk)) return false;
		if(is_null($mahasiswa)) return false;
		$tempObjectDBS = $this->getAllData($tahunAk,$mahasiswa,1,null);
		if(!$tempObjectDBS->getNextCursor()) return false;
		$tempObjectDBD = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDBE = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempObjectDBL = $this->gateControlModel->loadObjectDB('Dosbing');
		//where
		$tempObjectDBD->setStatus(2);
		$tempObjectDBS->setWhere(1);
		$tempObjectDBE->setRegistrasi($tempObjectDBS->getIdentified(),true);
		$tempObjectDBE->setStatus(1,true);
		$tempObjectDBE->setWhere(2);
		$tempObjectDBL->setStatus(2);
		//data edit
		if(!$this->gateControlModel->executeObjectDB($tempObjectDBL)->updateData($tempObjectDBE)) return false;
		return $this->gateControlModel->executeObjectDB($tempObjectDBD)->updateData($tempObjectDBS);
	} 
	//complex - sequence ok
	public function addNew($array){
		if(!is_array($array)) return false;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$regIdentified = $this->generateIdentified("R",2);
		$tempObjectDB->setIdentified($regIdentified,true);
		$tempObjectDB->setTahunAk($array['codeRegist']);
		$tempObjectDB->setMahasiswa($array['identified']);
		$dosbing = "";
		if(array_key_exists('dosbing',$array)){
			$dosbing = $array['dosbing'];
		}
		$pesan = "Mendaftar baru";
		if(array_key_exists("pesan",$array))
			$pesan = $array['pesan'];
		if(!$this->addNewDosbing($regIdentified,$pesan,$dosbing)){
			return false;
		}
		$tempObjectDB->setJudulTA($array['judulta']);
		$tempObjectDB->setMetode($array['metode']);
		$tempObjectDB->setLokasi($array['lokasi']);
		$tempObjectDB->setRefS($array['ref1']);
		$tempObjectDB->setRefD($array['ref2']);
		$tempObjectDB->setRefT($array['ref3']);
		$tempObjectDB->setStatus(1);
		$tempObjectDB->setDataProses(1);
		$tempObjectDB->setNamaKRS($array['namakrs']);
		$tempObjectDB->setKategori($array['kategori']);
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->addData();
	}
	//fixed with new return table stack
	public function getAllDataByDosen($tahunAk=null,$dosen = null,$status="1",$mahasiswa = false,$sidang=false){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDBS = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		if(!is_null($tahunAk) && !is_null($dosen)){
			$tempObjectDB->setTahunAk($tahunAk,true);
			$tempObjectDB->setStatus($status,true);	
			$tempObjectDB->setWhere(9);
			$tempObjectDBS->setDosen($dosen,true);
			$tempObjectDBS->setStatus($status,true);	
			$tempObjectDBS->setWhere(4);
			$tempObjectDBS->setWhereMultiple(1);
		}else return false;
		$tempMultiple->addTable($tempObjectDBS);
		$tempMultiple->addTable($tempObjectDB);
		if(!$mahasiswa)
			return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
		$tempObjectDBS->setWhereMultiple(4);
		$tempMahasiswa = $this->gateControlModel->loadObjectDB('Murid');
		$tempMultiple->addTable($tempMahasiswa);
		if(!$sidang)
			return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
		$tempObjectDBS->setWhereMultiple(5);
		$tempSidang = $this->gateControlModel->loadObjectDB('Sidang');
		$tempSidang->setNilai(3,true);
		$tempSidang->setTahunAk($tahunAk,true);
		$tempSidang->setStatus(1,true);
		$tempSidang->setWhere(24);
		$tempMultiple->addTable($tempSidang);
		return $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
	}
	//complex - sequence ok
	public function getCodeRegLastTA(ObjectDBModel $tempMahasiswa = null,$tahunAk = null,$now = false){
		if(is_null($tahunAk)) return array(false,null,null);
		if(is_null($tempMahasiswa)) return array(false,null,null);
		$tempEnd = intval(substr($tahunAk, 0,strlen($tahunAk)-1));
		$tempEndK = $tahunAk[strlen($tahunAk)-1];
		if(!$now){		
			if(intval($tempEndK) == 2){
				$tempEndK = "1";
			}else{
				$tempEndK = "2";
				$tempEnd = $tempEnd-1;
			}	
		}
		$tempEndKV = intval($tempEnd."".$tempEndK);
		$tempStart = intval(substr($tempMahasiswa->getAktifTahun(), 0,strlen($tempMahasiswa->getAktifTahun())-1));
		$tempStartK = $tempMahasiswa->getAktifTahun()[strlen($tempMahasiswa->getAktifTahun())-1];
		$tempStartKV = intval($tempStart."".$tempStartK);
		$tempTotalLoor = 0;
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDB->setMahasiswa($tempMahasiswa->getIdentified(),true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWhere(4);
		for($i=$tempEnd; $i>= $tempStart;$i--){
			for($j=2;$j>=1;$j--){
				$tempIdBefore = intval($i."".$j);
				if($tempIdBefore < $tempEndKV && $tempIdBefore >= $tempStartKV){
					$tempTotalLoor+=1;
				}
				if($tempIdBefore <= $tempEndKV && $tempIdBefore >= $tempStartKV){
					$tempObjectDB->setTahunAk($tempIdBefore,true);
					if($this->gateControlModel->executeObjectDB($tempObjectDB)->takeData()->getNextCursor()){ //getHaveLastTAInfo
						return array(true,$tempIdBefore,$tempTotalLoor);
					}
				}
			}
		}
		return array(false,null,null);
	}
	//optimized
	public function setDospemForTA($mahasiswa,$dosen,$tahunAk,$NamaDosen=false){
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Registrasi');
		$tempObjectDBS = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempMultiple = $this->gateControlModel->loadObjectDB('Multiple');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWhere(10);
		$tempObjectDBS->setStatus(1,true);
		$tempObjectDBS->setWhere(5);
		$tempObjectDBS->setWhereMultiple(1);
		$tempMultiple->addTable($tempObjectDBS);
		$tempMultiple->addTable($tempObjectDB);
		$tempMultiple = $this->gateControlModel->executeObjectDB($tempMultiple)->takeData();
		if(!$tempMultiple->getNextCursor())
			return array(false,"maaf nim ini belum melakukan registrasi");
		//check if ever request seminar
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Seminar');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWhere(5);
		if($this->gateControlModel->executeObjectDB($tempObjectDB)->takeData()->getNextCursor())
			return array(false,"Mahasiswa sudah masuk sesi seminar tidak dapat dirubah");
		//check if ever request sidang
		$tempObjectDB = $this->gateControlModel->loadObjectDB('Sidang');
		$tempObjectDB->setTahunAk($tahunAk,true);
		$tempObjectDB->setMahasiswa($mahasiswa,true);
		$tempObjectDB->setStatus(1,true);
		$tempObjectDB->setWhere(12);
		if($this->gateControlModel->executeObjectDB($tempObjectDB)->takeData()->getNextCursor())
			return array(false,"Mahasiswa sudah masuk sesi sidang, tidak dapat dirubah");
		$tempDosbing = $tempMultiple->getTableStack(0);
		$tempRegistrasi = $tempMultiple->getTableStack(1);
		$tempRegistrasi->setDataProses(1);
		$tempRegistrasi->setWhere(1);
		$this->gateControlModel->executeObjectDB($tempRegistrasi)->updateData();
		if(strlen($tempDosbing->getDosen()) == 40){
			$tempDosbing->setDosen($dosen);
			$pesan = "melakukan pergantian dosen oleh koordinator";
			if(!is_bool($NamaDosen)){
				$pesan = $NamaDosen." tidak menyetujui sebagai dosen pembimbing";
			}
			if($this->tryLogDosbing($tempDosbing->getIdentified())){
				return array($this->addNewDosbing($tempDosbing->getRegistrasi(), $pesan, $dosen),"check");
			}else{
				return array(false,"tidak dapat melog");
			}
			
		}else{
			
			$tempDosbing->setDosen($dosen);
			$tempDosbing->setPesan("melakukan pergantian dosen oleh koordinator");
			if(!is_bool($NamaDosen)){
				$tempDosbing->setPesan($NamaDosen." tidak menyetujui sebagai dosen pembimbing");
			}
			$tempDosbing->setWhere(1);
			return array($this->gateControlModel->executeObjectDB($tempDosbing)->updateData(),"check");
		}
	}
	protected function tryLogDosbing($identified){
		$tempObjectDBS = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempObjectDBS->setIdentified($identified,true);
		$tempObjectDBS->setStatus(2);
		$tempObjectDBS->setWhere(1);
		return $this->gateControlModel->executeObjectDB($tempObjectDBS)->updateData();
	}
	
	protected function addNewDosbing($registrasi=null, $pesan="Belum ada kegiatan",$dosen=""){
		if(is_null($registrasi)) return false;
		$tempObjectDBS = $this->gateControlModel->loadObjectDB('Dosbing');
		$tempObjectDBS->setDosen($dosen);
		$tempObjectDBS->setIdentified($this->generateIdentified("B",1));
		$tempObjectDBS->setRegistrasi($registrasi);
		$tempObjectDBS->setStatus(1);
		$tempObjectDBS->setPesan($pesan);
		return $this->gateControlModel->executeObjectDB($tempObjectDBS)->addData();
	}
}