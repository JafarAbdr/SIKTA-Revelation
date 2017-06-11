<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencies:
-LoginFilter
-GateControlModel
-ControlMahasiswa
-ControlTime
-Inputjaservfilter
-Dosen
-Admin
-Koordinator
-Mahasiswa
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Gateinout extends CI_Controller_Modified {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('Aktor/Mahasiswa');
		$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Admin');
		$this->load->library('Inputjaservfilter');
		$this->load->library('Aktor/Koordinator');
		$this->loadLib('LoginFilter');
		$session = $this->loadLib('Session',true);
		$this->loadMod("GateControlModel");
		$this->loginFilter = new LoginFilter($session, new GateControlModel());
		
	}
	// default - valid
	public function index($tempInput=null){
		if($this->loginFilter->isLogin($this->mahasiswa))
			redirect(base_url()."Classroom.jsp");
		
		if($this->loginFilter->isLogin($this->koordinator))
			redirect(base_url()."Controlroom.jsp");
		
		if($this->loginFilter->isLogin($this->dosen))
			redirect(base_url()."Kingroom.jsp");
		
		if($this->loginFilter->isLogin($this->admin))
			redirect(base_url()."Palaceroom.jsp");
		$tempArray['url_script'] = array(
				"resources/mystyle/js/gateinout.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js"
		);
		$tempArray['url_link'] = array(
				"resources/mystyle/css/gateinout.css",
				"resources/mystyle/css/global-style.css"
		);
		if($tempInput == null)
			$tempArray['backtobaseroom'] = false;
		else if($tempInput == "baseroom")
			$tempArray['backtobaseroom'] = true;
		else{
			$tempArray['backtobaseroom'] = false;
		}
		$this->load->view('Gateinout_layout',$tempArray);
	}
	//sign session - valid
	public function getSignIn(){
		$nickName = $this->isNullPost('login-nim');
		$keyWord = $this->isNullPost('login-password');
		if($this->loginFilter->setLogIn($nickName,$keyWord))
			exit("1Gateinout.jsp");
		exit("0Akun anda tidak terdaftar dimanapun");
	}
	public function resetPassword(){
		$this->mahasiswa->initial($this->inputjaservfilter);
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]) exit('0Nim Tidak Valid');
		$this->loadLib("ControlMahasiswa");
		$waktuCookie = date("Y-m-d H:i:s");
		$this->load->helper('email');
		$kodeCookie = md5($waktuCookie."RequestResetNimBy".$nim);
		$email = (new ControlMahasiswa(new GateControlModel()))->trySendEmail($nim,$waktuCookie,$kodeCookie);
		if(!$email) exit("0terjadi kesalahan, mungkin nim anda tidak terdaftar, maupun akun anda sudah tidak aktif, atau email yang anda tautkan tidak valid");
		$tempHtml = file_get_contents(APPPATH."views/email_template.html");
		$tempArray = array(
			'nim' => $nim,
			'hari' => $waktuCookie,
			'url' => base_url()."Resetpassword/Akun/".$kodeCookie.".jsp"
		);
        foreach($tempArray as $key=>$value){
            $tempHtml = str_ireplace("@".$key.";",$value,$tempHtml);
        }
		//disable this when on internet
		//exit("1".base_url()."Resetpassword/Akun/".$kodeCookie.".jsp");
		// The mail sending protocol.
		$config['protocol'] = 'smtp';
		// SMTP Server Address for Gmail.
		$config['smtp_host'] = 'tls://smtp.gmail.com';
		// SMTP Port - the port that you is required
		$config['smtp_port'] = 465;
		// SMTP Username like. (abc@gmail.com)
		$config['smtp_user'] = "dev.os.sikta.if.undip@gmail.com";
		// SMTP Password like (abc***##)
		$config['smtp_pass'] = "sikta//dev??OS";
		
		$config['mailtype']  = 'html';
		$config['charset']='utf-8';
		$config['newline'] = "\r\n";
		// Load email library and passing configured values to email library
		$this->load->library('email', $config);
		// Sender email address
		$this->email->from('dev.os.sikta.if.undip@gmail.com', 'Developer Web');
		// Receiver email address.for single email
		$this->email->to($email);
		$this->email->reply_to("dev.os.sikta.if.undip@gmail.com");
		// Subject of email
		$this->email->subject('Permintaan pengesetan ulang kata kunci');
		// Message in email
		$this->email->message($tempHtml);
		// It returns boolean TRUE or FALSE based on success or failure
		if(!$this->email->send()) exit('0Email gagal dikirimkan');
		echo "1Berhasil mengirimkan link ke email yang didaftarkan akun ini"; 
	}
	//sign Up session - valid
	public function getSignUp(){
		//getDataPost
		$nim = $this->isNullPost('daftar-nim')."";
		$name = $this->isNullPost('daftar-nama')."";
		$email = $this->isNullPost('daftar-apes')."";
		$passwords = $this->isNullPost('daftar-kunci')."";
		$passwordd = $this->isNullPost('daftar-kuncire')."";
		$telephone = $this->isNullPost('daftar-ntelp')."";
		$foto = 'daftar-foto-exe';
		$trans = 'daftar-trans-exe';
		//init return;
		$tempData = array(
			"nim" => null,
			"nama" => null,
			"email" => null,
			"keyword"=> null,
			"nickname" => null,
			"nohp" =>null,
			"namafoto" =>null,
			"namatranskrip" =>null,
			"aktiftahun" =>null
		);
		//enable fitur
		$this->loadLib("ControlMahasiswa");
		$this->mahasiswa->initial($this->inputjaservfilter);
		//filtering
		$error = 0;	
		$errorMessage = "";	
		$temp = $this->mahasiswa->getCheckNim($nim,1);
		if(!$temp[0]){	
			$error+=1;	$errorMessage.=$temp[1]."<br>";
		}else{	
			if((new ControlMahasiswa(new GateControlModel()))->getDataByNim($nim)->getNextCursor()){	
				exit("0Maaf, nim anda sudah digunakan oleh mahasiswa lain, mohon maaf sebelumnya. pilih menu lupa password jika anda sudah daftar ssebelumnya");	
			}
		}
		$tempData['nim'] = $nim;
		$tempData['nickname'] = $nim;
		$temp = $this->mahasiswa->getCheckName($name,1);
		if(!$temp[0]){	
			$error+=1;	
			$errorMessage.=$temp[1]."<br>";	
		}else{
			$tempData['nama'] = $name;
		} 
		$temp = $this->mahasiswa->getCheckPassword($passwords,1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";
		}else{
			$tempData['keyword'] = $passwords; 
		} 
		$temp = $this->mahasiswa->getCheckPassword($passwordd,1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";	
		}else{	
			$tempData['keyword'] = $passwordd;
		} 
		if($passwords != $passwordd){
			$error+=1;
			$errorMessage.="Password konfirmasi tidak sama dengan password utama<br>";
		} 
		$temp = $this->mahasiswa->getCheckEmail($email,1);
		if(!$temp[0]){
			$error+=1;
			$errorMessage.=$temp[1]."<br>";	
		}else{
			$tempData['email'] = $email; 
		}
		$temp = $this->mahasiswa->getCheckNuTelphone($telephone,1);
		if(!$temp[0]){ $error+=1;	$errorMessage.=$temp[1]."<br>";	}
		else{ $tempData['nohp'] = $telephone; }
		if($error > 0){
			exit("0".$errorMessage);	
		}
		$this->loadLib("ControlTime");
		$tempData['aktiftahun'] = (new ControlTime(new GateControlModel()))->getYearNow();
		/*upload-foto*/
		$conPic['upload_path'] = './upload/foto/';	
		$conPic['allowed_types'] = 'png|jpg'; 
		$conPic['file_name'] = $nim."-foto";	
		$conPic['overwrite'] = true; 
		$conPic['remove_spaces'] = true; 
		$conPic['max_size'] = 500;	
		$conPic['max_width'] = 800;	
		$conPic['max_height'] = 1024; 
		$upload = $this->loadLib('upload',true);
		$upload->initialize($conPic);
		if(!$upload->do_upload($foto)){
			exit('0gagal upload foto, format yang didukung png dan jpg, maksimal resolusi 800 x 600 pixel, dengan ukuran file 500kb');		
		}
		$tempData['namafoto'] = $upload->data('file_name');
		/*upload-transkrip*/
		$conTrans['upload_path'] = './upload/transkrip/'; 
		$conTrans['file_name'] = $nim."-transkrip"; 
		$conTrans['allowed_types'] = 'pdf|PDF'; 
		$conTrans['max_size'] = 1024;	
		$conTrans['overwrite'] = true; 
		$conTrans['remove_spaces'] = true;
		$upload->initialize($conTrans);
		if(!$upload->do_upload($trans)){
			exit("0gagal upload transkrip, format yang didukung transkrip adalah pdf, dengan maksimum ukuran file 1 mb");		
		}
		$tempData['namatranskrip'] = $upload->data('file_name');
		if((new ControlMahasiswa(new GateControlModel()))->addNewData($tempData))
			exit("1berhasil melakukan pendaftaran, silahkan login");
		else
			exit("0Gagal melakukan pendaftaran");
	}
	//check Type of input - valid
	public function getCheck(){
		$this->mahasiswa->initial($this->inputjaservfilter);
		$this->dosen->initial($this->inputjaservfilter);
		$this->koordinator->initial($this->inputjaservfilter);
		$this->admin->initial($this->inputjaservfilter);
		$tempNameVariable = $this->isNullPost('variabel');
		$tempNameValue = $this->isNullPost('value');
		switch ($tempNameVariable){
			case 'login-nim' :
				$tempArray = $this->mahasiswa->getCheckNim($tempNameValue,1);
				if($tempArray[0]){
					echo "1".$tempArray[1];
				}else{
					$tempArray = $this->koordinator->getCheckKodeUsername($tempNameValue,1);
					if($tempArray[0]){
						echo "1".$tempArray[1];
					}else{
						$tempArray = $this->dosen->getCheckNip($tempNameValue,1);
						if($tempArray[0]){
							echo "1".$tempArray[1];
						}else{
							$tempArray = $this->admin->getCheckKodeUsername($tempNameValue,1);
							if($tempArray[0]){
								echo "1".$tempArray[1];
							}else{
								echo "0".$tempArray[1];
							} 
						}
					
					}
				}
				break;
			case 'daftar-nim' :
				$tempArray = $this->mahasiswa->getCheckNim($tempNameValue,1);
				if(!$tempArray[0]){
					echo "0".$tempArray[1];
					return ;
				}
				$this->loadLib('ControlMahasiswa');
				if((new ControlMahasiswa(new GateControlModel()))->getDataByNim($tempNameValue)->getNextCursor()){ //methode repaired
					echo "0Nim sudah ada yang menggunakan, mohon gunakan nim yang lain";
				}else{
					echo "1Valid";
				}
				break;
			case 'login-password' :
				
				$tempArray = $this->koordinator->getCheckPassword($tempNameValue,1);
				if($tempArray[0])
					echo "1".$tempArray[1];
				else {
					$tempArray = $this->mahasiswa->getCheckPassword($tempNameValue,1);
					if($tempArray[0]){
						echo "1".$tempArray[1];
						break;
					}else{
						echo "0".$tempArray[1];
					}
				}
				break;
			case 'daftar-kunci' :
			case 'daftar-kuncire' :
				$this->mahasiswa->getCheckPassword($tempNameValue);
				break;
			case 'daftar-nama' :
				$this->mahasiswa->getCheckName($tempNameValue);
				break;
			case 'daftar-apes' :
				$this->mahasiswa->getCheckEmail($tempNameValue);
				break;
			case 'daftar-ntelp' :
				$this->mahasiswa->getCheckNuTelphone($tempNameValue);
				break;
			case 'login-akun' :
				switch ($tempNameValue) {
					case 'mhs' :
					case 'dos' :
					case 'kor' :
					case 'adm' :
						echo '1valid';
						break;
					default:
						echo '0anda merubah default kategori';
				}
				break;
			default :
				echo "0Kode yang anda kirimkan tidak sesuai, kontak developer";
				break;
		}
	}
}