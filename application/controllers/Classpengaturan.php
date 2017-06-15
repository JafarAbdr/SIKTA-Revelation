<?php
/*
dependecies:
-Mahasiswa
-LoginFilter
-Inputjaservfilter
-ControlMahasiswa
*/
	if(!defined('BASEPATH'))
		exit("You don't have accsees to this site");
	require_once(APPPATH.'controllers/CI_Controller_Modified.php');
	class Classpengaturan extends CI_Controller_Modified {
		public function __CONSTRUCT(){
			parent::__CONSTRUCT();
			$this->load->library("Aktor/Mahasiswa");
			$this->load->helper('url');
			$this->load->helper('html');
			if(!$this->loginFilter->isLogin($this->mahasiswa)){
				redirect(base_url()."Gateinout.jsp");
			}
		}
		//fix
		public function getJsonProfile(){
			$this->loadLib('ControlMahasiswa');
			$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
			$data['state'] = false;
			if($tempObjectDB && $tempObjectDB->getNextCursor()){
				$data['nama'] = $tempObjectDB->getNama();
				$data['nim'] = $tempObjectDB->getNim();
				$data['email'] = $tempObjectDB->getEmail();
				$data['nohp'] = $tempObjectDB->getNoHp();
				$data['ortu'] = $tempObjectDB->getNamaOrangTua();
				$data['nohportu'] = $tempObjectDB->getNoHpOrangTua();
				$data['dataMinat'] = $tempObjectDB->getMinat();
				$data['state'] = true;
			}
			echo json_encode($data);
		}
		//fix
		public function setNewPassword(){
			$passwordLama = $this->isNullPost("password-old");
			$passwordNew = $this->isNullPost("password-new");
			$passwordNewCon = $this->isNullPost("password-new-confirm");
			$ERROR = 0;
			$ERRORMESSAGE = "";
			$this->mahasiswa->initial($this->inputJaservFilter);
			if(!$this->mahasiswa->getCheckPassword($passwordLama,1)[0]){
				$ERRORMESSAGE .= "password lama tidak valid,";
				$ERROR += 1;	
			}
			if(!$this->mahasiswa->getCheckPassword($passwordNew,1)[0]){
				$ERRORMESSAGE .= "password baru tidak valid,";
				$ERROR += 1;	
			}
			if(!$this->mahasiswa->getCheckPassword($passwordNewCon,1)[0]){
				$ERRORMESSAGE .= "password baru confirmasi tidak valid,";
				$ERROR += 1;	
			}
			if($ERROR > 0)
				exit("0".$ERRORMESSAGE);
			if($passwordNew != $passwordNewCon){
				exit("0Password baru tidak sama dengan password confiirmasinya");
			}
			
			if(!$this->loginFilter->isPasswordOfThisGuy($passwordLama)){
				exit("0Password lama anda tidak sesuai");
			}
			if(!$this->loginFilter->setNewPassword($passwordNew)){
				exit("0Gagal melakukan perubahan terhadap password");
			}
			exit("1Proses perubahan berhasil");
		}
		//fix
		public function setNewTranskrip(){
			$this->loadLib('ControlMahasiswa');
			$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
				redirect(base_url().'Gateinout.jsp');
			$filename = "";
			$conPic['upload_path'] = './upload/transkrip/';	
			$conPic['allowed_types'] = 'pdf'; 
			$conPic['file_name'] =  $tempObjectDB->getNim()."-transkrip";	
			$conPic['overwrite'] = true; 
			$conPic['remove_spaces'] = true; 
			$conPic['max_size'] = 1000;	 
			$this->load->library('upload');
			$this->upload->initialize($conPic);
			if(!$this->upload->do_upload('upgrade-transkrip')){
				exit('0Gagal mengganti Transkrip');		
			}	
			$filename = $this->upload->data('file_name');
			if($filename == ""){
				exit("0data kosong, silahkan pilih jika ingin merubah");
			}
			exit("1Berhasil Mengganti Transkrip");
		}
		//fix
		public function setNewProfile(){
			$this->loadLib('ControlMahasiswa');
			$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
			$tempObjectDB = $controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
				redirect(base_url().'Gateinout.jsp');
			$filename = "";		
			
			$conPic['upload_path'] = './upload/foto/';	
			$conPic['allowed_types'] = 'png|jpg'; 
			$conPic['file_name'] = $tempObjectDB->getNim()."-foto";	
			$conPic['overwrite'] = true; 
			$conPic['remove_spaces'] = true; 
			$conPic['max_size'] = 500;	
			$conPic['max_width'] = 600;	
			$conPic['max_height'] = 800; 
			$this->load->library('upload');
			//$this->load->library('upload',$conPic);
			$this->upload->initialize($conPic);
			if(!$this->upload->do_upload('data-gambar')){
				exit('0Gagal upload foto, format yang didukung png dan jpg, maksimal resolusi 800 x 600 pixel, dengan ukuran file 500kb');		
			}	
			$tempObjectDB->setNamaFoto($this->upload->data('file_name'));
			if($controlMahasiswa->tryUpdate($tempObjectDB))
				exit("1Berhasil merubah foto");
			exit("0Gagal merubah foto profil");
		}
		
		public function dataSupport(){
			$this->loadLib('ControlMahasiswa');
			$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
			$tempObjectDB = $controlMahasiswa->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
				redirect(base_url().'Gateinout.jsp');
			$email = $this->isNullPost("support-email");
			$nohp = $this->isNullPost("support-no-hp");
			$namaortu = $this->isNullPost("support-nama-ortu");
			$otunohp = $this->isNullPost("support-no-hp-ortu");
			$minat = $this->isNullPost("support-peminatan");
			$this->mahasiswa->initial($this->inputJaservFilter);
			if(intval($minat) < 1 || intval($minat)>4){
				exit('0harus memilih salah satu minat yang disediakan');
			}
			if(!$this->mahasiswa->getCheckEmail($email,1)[0]){
				exit("0Email tidak valid");
			}
			if(!$this->mahasiswa->getCheckNuTelphone($nohp,1)[0]){
				exit("0No hp anda tidak valid");
			}
			if(!$this->mahasiswa->getCheckNuTelphone($otunohp,1)[0]){
				exit("0No hp orang tua anda tidak valid");
			}
			if(!$this->mahasiswa->getCheckName($namaortu,1)[0]){
				exit("0Format nama tidak valid");
			}
			
			$tempObjectDB->setNoHp($nohp);
			$tempObjectDB->setNamaOrangTua($namaortu);
			$tempObjectDB->setNoHpOrangTua($otunohp);
			$tempObjectDB->setEmail($email);
			$tempObjectDB->setMinat($minat);
			if($controlMahasiswa->tryUpdate($tempObjectDB))
				exit("1Berhasil merubah foto");
			exit("0Gagal merubah foto profil");
		}
	}