<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencie:
-Mahasiswa
-Dosen
-GateControlModel
-LoginFilter
-Inputjaservfilter
-ControlDetail
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlTime
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Classregistrasilama extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Aktor/Mahasiswa");
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->mahasiswa)){
			redirect(base_url()."Gateinout.jsp");
		}
		$this->loadLib("Aktor/Dosen");
		$this->loadLib('ControlDosen');		
		$this->loadLib('ControlRegistrasi');		
		$this->loadLib('ControlMahasiswa');		
		$this->loadLib('ControlTime');		
	}
	
	protected function getGenerateSimpleJson($a,$b){
		if($b === NULL || $b == "" || $b == " " || $b."" == '0'){
			return '"'.$a.'" : { "status" : false, "value" : null}';
		}else{
			return '"'.$a.'" : { "status" : true, "value" : "'.$b.'"}';
		}
	}
	//get data for form is exist before - valid
	public function getJsonDataTA(){
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$temps = $controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk);
		if($temps[0]){
			$tahunAk = $temps[1];
		}
		
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,0,null);
		if(!$tempObjectDB || !$tempObjectDBD->getNextCursor()){
			$temp2="{";
			$temp2.=$this->getGenerateSimpleJson("judulta", null).",";
			$temp2.=$this->getGenerateSimpleJson("dosbing", null);
			$temp2.="}";	
		}else{
			$temp2="{";
			$temp2.=$this->getGenerateSimpleJson("judulta", $tempObjectDBD->getJudulTA()).",";
			$tempObjectDBT = (new ControlDosen($this->gateControlModel))->getAllData($tempObjectDBD->getDosen());
			if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				$temp2.=$this->getGenerateSimpleJson("dosbing", $tempObjectDBT->getNip());
			}else{
				$temp2.=$this->getGenerateSimpleJson("dosbing", null);
			}
			$temp2.="}";
		}
		echo $temp2;
		return;
	}
	//refreshing data form - valid
	public function getJsonDataPersonal(){
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		$temp2="{";
		$temp2.=$this->getGenerateSimpleJson("nama", $tempObjectDB->getNama()).",";
		$temp2.=$this->getGenerateSimpleJson("nim", $tempObjectDB->getNim()).",";
		$temp2.=$this->getGenerateSimpleJson("nohp", $tempObjectDB->getNoHp()).",";
		$temp2.=$this->getGenerateSimpleJson("email", $tempObjectDB->getEmail()).",";
		$temp2.=$this->getGenerateSimpleJson("ortu", $tempObjectDB->getNamaOrangTua()).",";
		$temp2.=$this->getGenerateSimpleJson("nohportu", $tempObjectDB->getNoHpOrangTua()).",";
		$temp2.=$this->getGenerateSimpleJson("minat", $tempObjectDB->getMinat());
		$temp2.="}";
		echo $temp2;
		return true;
	}
	
	/*registrasi lama*/
	//optimized
	public function index(){
		//check is register permission
		
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		//check is register permission
		if(intval($tempObjectDB->getStatus()) != 1){
			$TEMP_ARRAY['message'] = "Maaf, anda Bukan mahasiswa aktif, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
			return;
		}
		if($tempObjectDB->getFormBaru() != 1){
			$TEMP_ARRAY['message'] = "Maaf, anda sudah melakukan registrasi, silahkan kontak admin untuk melakukan perubahan";
			echo "0";
			$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
			return;
		}
		//filter
		$CODE_PERMISSION = "1".$tempObjectDB->getRegistrasiBaru()."".$tempObjectDB->getRegistrasiLama()."";
		$controlTime = new ControlTime($this->gateControlModel);
		//check is register Time
		if(!$controlTime->isRegisterTime()){
			if(intval($tempObjectDB->getTanpaWaktu()) == 2){			
				$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
				echo"0";
				$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
				return ;	
			}
		}
		//check data from other semester before
		$tahunAk = $controlTime->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$ARRAY_CODE = $controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk);
		
		//check if is registerer on this Academic Year
		
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		
		$TEMP_BOOLEAN = $tempObjectDBD->getNextCursor();
		$controlDosen = new ControlDosen($this->gateControlModel);
		//$controlDetail = new ControlDetail($this->gateControlModel);
		//filltering code
		if(!$ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 111 :
				case 122 :
				//registerasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Judul Ta anda tidak ditemukan dimanapun, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi koordinator Tugas Akhir',
						'but2' => 'form baru'
				);
				$this->load->view("Bodyright/Classroom/Warningonebuttonregistrasi",$TEMP_ARRAY);
				return ;
				break;
				case 121 :
				case 112 :
				//neutrallized
				break;
			}
		}else if(!$ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				//neutrallized
				break;
				case 121 :
				//registerasi lama
				$tempObjectDBT = $controlDosen->getDataByStatus();
				$i=0;
				$TEMP_ARRAY['listdosen']['data'] = false;
				while($tempObjectDBT->getNextCursor()){
					$TEMP_ARRAY['listdosen']['data'] = true;
					$TEMP_ARRAY['listdosen'][$i]['id'] = $tempObjectDBT->getNip();
					$TEMP_ARRAY['listdosen'][$i]['nama'] = $tempObjectDBT->getNama();
					$i++;
				}
				$TEMP_ARRAY['listdosen']['length'] = $i;
				echo "1";
				$this->load->view("Bodyright/Classroom/Registrasilama",$TEMP_ARRAY);
				return;
				break;
				case 112 :
				//registerasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda diberikan izin perubahan judul, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi koordinator Tugas Akhir',
						'but2' => 'form baru'
				);
				$this->load->view("Bodyright/Classroom/Warningonebuttonregistrasi",$TEMP_ARRAY);
				return ;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				//registerasi lama
				$tempObjectDBT = $controlDosen->getDataByStatus();
				$i=0;
				$TEMP_ARRAY['listdosen']['data'] = false;
				while($tempObjectDBT->getNextCursor()){
					$TEMP_ARRAY['listdosen']['data'] = true;
					$TEMP_ARRAY['listdosen'][$i]['id'] = $tempObjectDBT->getNip();
					$TEMP_ARRAY['listdosen'][$i]['nama'] = $tempObjectDBT->getNama();
					$i++;
				}
				$TEMP_ARRAY['listdosen']['length'] = $i;
				echo "1";
				$this->load->view("Bodyright/Classroom/Registrasilama",$TEMP_ARRAY);
				return;
				break;
				case 112 :
				//registrasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda diberikan izin perubahan judul, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi koordinator Tugas Akhir',
						'but2' => 'form baru'
				);
				$this->load->view("Bodyright/Classroom/Warningonebuttonregistrasi",$TEMP_ARRAY);
				return ;
				break;
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				//registerasi baru
				echo "3";
				$TEMP_ARRAY = array(
						'message' => 'Anda diberikan izin perubahan judul, silhakan registrasi baru. Jika ini kesalahan silahkan hubungi koordinator Tugas Akhir',
						'but2' => 'form baru'
				);
				$this->load->view("Bodyright/Classroom/Warningonebuttonregistrasi",$TEMP_ARRAY);
				return ;
				break;
				case 122 :
				case 121 :
				case 111 :
				//neutrallized
				break;
			}
		}
	}
	//registrasi lama proses and get result of process
	public function getResultRegistrasiLama(){
		$controlTime = new ControlTime($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
		//filter
		$CODE_PERMISSION = "1".$tempObjectDB->getRegistrasiBaru()."".$tempObjectDB->getRegistrasiLama()."";
		
		//check is register Time
		if(!$controlTime->isRegisterTime(date("Y-m-d"))){
			if(intval($tempObjectDB->getTanpaWaktu()) == 2){
				$TEMP_ARRAY['message'] = "Maaf, waktu registrasi sudah / belum dimulai, silahkan menunggu hingga waktu diumumkan";
				echo"0";
				$this->load->view("Bodyright/Classroom/Failedregistrasi",$TEMP_ARRAY);
				return ;
			}
		}
		//check data from other semester before
		$ARRAY_CODE = $controlRegistrasi->getCodeRegLastTA();
		$tahunAk = $controlTime->getYearNow();
		$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null);
		//check if is registerer on this Academic Year
		$TEMP_BOOLEAN = $tempObjectDBD->getNextCursor();
		//filltering code
		if(!$ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 111 :
				case 122 :
				case 121 :
				case 112 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if(!$ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 122 :
				case 111 :
				case 112 :
				//registerasi baru
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && !$TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}else if($ARRAY_CODE[0] && $TEMP_BOOLEAN){
			SWITCH(intval($CODE_PERMISSION)){
				case 112 :
				case 122 :
				case 121 :
				case 111 :
				echo "0Anda melakukan percobaan";
				return;
				break;
			}
		}
		//Nama
		$dataTemp['nama'] = $tempObjectDB->getNama();
		//Nim
		$dataTemp['identified'] = $tempObjectDB->getIdentified();
		//Email
		$dataTemp['email'] = $tempObjectDB->getEmail();
		//nohp
		$dataTemp['nohp'] = $tempObjectDB->getEmail();
		//nohportu
		$dataTemp['nohportu'] = $tempObjectDB->getNoHpOrangTua();
		//ortu
		$dataTemp['ortu'] = $tempObjectDB->getNamaOrangTua();
		//$temps = $this->mahasiswa->getCodeRegLastTA();
		$dataTemp['codeRegist'] = $ARRAY_CODE[1];
		if(!$ARRAY_CODE[0]){
			if(!$controlRegistrasi->getAllData($tahunAk,$tempObjectDB->getIdentified(),1,null)->getNextCursor()){				
				echo "0Maaf, anda mencoba memasukan paksa form registrasi lama";
				return ;
			}else{
				$dataTemp['codeRegist'] = $tahunAk;
			}
		}
		$dataTemp['codereg'] = $tahunAk;
		$dataTemp['judulta'] = $this->isNullPost('lama-judulta');
		$this->getCheck('lama-judulta',$dataTemp['judulta'],true);
		$dataTemp['dosbing'] = $this->isNullPost('lama-dosbing');
		if(strlen($dataTemp['dosbing']) < 15){
			$dataTemp['dosbing'] = "";
		}else{
			$tempObjectDBT = (new ControlDosen($this->gateControlModel))->getDataByNip($dataTemp['dosbing']);
			if($tempObjectDBT && $tempObjectDBT->getNextCursor())
				$dataTemp['dosbing'] = $tempObjectDBT->getIdentified(); 
		}
		$dataTemp['newf'] = 2;
		$dataTemp['notime'] = 2;
		$dataTemp['krs'] = 'lama-krs';
		$temp = $this->setRegistrasiLama($dataTemp);
		if(!$temp[0]){
			echo "0".$temp[1];
		}else{
			echo "1";
			$data['data'] = "Data berhasil dimasukan, terima kasih atas waktunya";
			$this->load->view("Bodyright/Classroom/Successregistrasi",$data);
		}
	}
	public function getCheck($variabel=null,$value=null,$type=false){
		if($variabel == null){
			$variabel = $this->isNullPost('variabel');
			$variabel.="";
		}
		if($value == null){
			$value = $this->isNullPost('value');
		}
		$value.="";
		$this->mahasiswa->initial($this->inputJaservFilter);
		switch ($variabel){
			case 'lama-nim' :
				if($type){
					$temp = $this->mahasiswa->getCheckNim($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckNim($value);
				break;
			case 'lama-nama' : 
			case 'lama-ortu' :
				if($type){
					$temp = $this->mahasiswa->getCheckName($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckName($value);
				break;
			case 'lama-email' :
				if($type){
					$temp = $this->mahasiswa->getCheckEmail($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckEmail($value);
				break;
			case 'lama-nohp' :
			case 'lama-nohportu' :
				if($type){
					$temp = $this->mahasiswa->getCheckNuTelphone($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else
					$this->mahasiswa->getCheckNuTelphone($value);
				break;
			case 'lama-dosbing'	:
				if($type){
					if(intval($value) == 0)
						exit("0Tidak boleh kosong");
					$dosen = new Dosen($this->inputJaservFilter);
					$temp = $dosen->getCheckNip($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
					if(!(new ControlDosen($this->gateControlModel))->getDataByNip($value)->getNextCursor()) exit("0Dosen tidak terdaftar");
				}
				else
					$dosen = new Dosen($this->inputJaservFilter);
					$temp = $dosen->getCheckNip($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
					if(!(new ControlDosen($this->gateControlModel))->getDataByNip($value)->getNextCursor()) exit("0Dosen tidak terdaftar");
				break;
			case 'lama-judulta' :
				if($type){
					$temp = $this->mahasiswa->getCheckTitleFinalTask($value,1);
					if(!$temp[0]){
						exit("0".$temp);
					}
				}
				else 
					$this->mahasiswa->getCheckTitleFinalTask($value);
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
	protected function setRegistrasiLama($data){
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$NUM = $controlRegistrasi->getAllData($data['codereg'],$data['identified'],null,null,null)->getCountData();
		$conPic['upload_path'] = './upload/krs/';
		$conPic['allowed_types'] = 'pdf';
		$conPic['file_name'] = $data['codeRegist']."".md5($data['identified'])."".$NUM."KR5";
		$conPic['overwrite'] = true;
		$conPic['remove_spaces'] = true;
		$conPic['max_size'] = 1024;
		$this->load->library('upload');
		$this->upload->initialize($conPic);
		if(!$this->upload->do_upload($data['krs'])){
			return array( false, 'file yang di upload adalah, pdf(yanng tidak ter password, maupun terenkripsi). dan ukuran maksimal 1 mb.');
		}
		$tempObjectDB = $controlRegistrasi->getAllData($data['codeRegist'],$data['identified'],null,null,null);
		
	
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
			return array(false,"data tidak dtemukan untuk ta sebelumnya, lihat panduan registrasi");
		$TEMP_ARRAY = array(
			'metode' => $tempObjectDB->getMetode(),
			'lokasi' => $tempObjectDB->getLokasi(),
			'ref1' => $tempObjectDB->getRefS(),
			'ref2' => $tempObjectDB->getRefD(),
			'ref3' => $tempObjectDB->getRefT(),
			'pesan' => "Registras lama"
		);
		$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempObjectDB->getIdentified());
		$tempDosbing->getNextCursor();
		$TEMP_ARRAY['dosbing'] = $tempDosbing->getDosen();
			//check nip
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$nipReviewChange=null;

		if($data['dosbing'] != ""){
			if($TEMP_ARRAY['dosbing'] != $data['dosbing']){
				if(!$controlMahasiswa->setAddNewFavor($data['dosbing'],$this->loginFilter->getIdentifiedActive())){
					$nipReviewChange=true;
					$TEMP_ARRAY['pesan'] = "memasukan nama dosen pembimbing yang berbeda, dimasukan sebagai favorit list teratas";
				}
			}
		}
		//return array(false,$data['codeRegist']." ".$data['codereg']);
		$TEMP_ARRAY['namakrs'] = $this->upload->data('file_name');
		$TEMP_ARRAY['kategori'] = 2;
		$TEMP_ARRAY['judulta'] = $data['judulta'];
		$TEMP_ARRAY['identified'] = $data['identified'];
		$TEMP_ARRAY['codeRegist'] = $data['codereg'];
		
		
		$tempObjectDBD = $controlMahasiswa->getAllData($data['identified']);
		$tempObjectDBD->getNextCursor();
		$tempObjectDBD->setRegistrasiLama(2);
		$tempObjectDBD->setFormBaru($data['newf']);
		$tempObjectDBD->setTanpaWaktu($data['notime']);
		if(is_bool($nipReviewChange)){
			$tempObjectDB->setDosenT($data['dosbing']);
		}
		if(!$controlMahasiswa->tryUpdate($tempObjectDBD))
			return array(false,"Terjadi kesalahan pada saat registrasi lama");
		
		
		
		
		if(intval($data['codeRegist']) == intval($data['codereg'])){		
			$controlRegistrasi->tryLog($data['codeRegist'],$data['identified']);
		}
		if(!$controlRegistrasi->addNew($TEMP_ARRAY)){
			return array(false, "terjadi kesalahan saat memasukan data registrasi");
		} 
		return array(true, "Valid");
	}
}