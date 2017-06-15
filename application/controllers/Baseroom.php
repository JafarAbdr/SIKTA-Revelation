<?php if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Baseroom extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		/*
		dependencies:
		-Mahasiswa
		-Dosen
		-Koordinator
		-Admin
		-LoginFilter
		-ControlDosen
		-ControlMahasiswa
		*/
		parent::__CONSTRUCT();
		$this->loadLib('LoginFilter');
		$this->load->helper("Html");
		$this->load->helper("Url");
		$this->load->library('Session');
	}
	//optimized
	//filter login account in this current device
	protected function getDataLocalNameLogin(){
		$this->load->library('Aktor/Mahasiswa');
		$this->load->library('Aktor/Koordinator');
		$this->load->library('Aktor/Dosen');
		$this->load->library('Aktor/Admin');
		$loginFilter = new LoginFilter($this->session);
		if($loginFilter->isLogin($this->mahasiswa)){
			$this->loadLib('ControlMahasiswa');
			$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
			$tempObjectDB = $controlMahasiswa->getAllData($loginFilter->getIdentifiedActive());
			$tempObjectDB->getNextCursor();
			$image = 'filesupport/getPhotoMahasiswaProfil/'.$tempObjectDB->getNim().".aspx";
			return array("Mahasiswa",array(
				"nim" => "",
				"nama" => $tempObjectDB->getNama(),
				"foto" => $image,
				"title" => "Mahasiswa | SIKTA halaman utama"
			));
		}
		if($loginFilter->isLogin($this->koordinator)){
			return array("Koordinator",array(
				"nim" => "",
				"nama" => "Koordinator TA",
				"foto" => "resources/mystyle/image/koor.png",
				"title" => "Koordinator | SIKTA halaman utama"
			));
		}
		if($loginFilter->isLogin($this->admin)){
			return array("Administrator",array(
				"nim" => "",
				"nama" => "Administrator TA",
				"foto" => "resources/mystyle/image/koor.png",
				"title" => "Administrator | SIKTA halaman utama"
			));
		}
		if($loginFilter->isLogin($this->dosen)){
			$this->loadLib('ControlDosen');
			$this->loadMod('GateControlModel');
			$controlDosen = new ControlDosen($this->gateControlModel);
			$tempObjectDB = $controlDosen->getAllData($loginFilter->getIdentifiedActive());
			$tempObjectDB->getNextCursor();
			return array("Dosen",array(
				"nim" => "",
				"nama" => $tempObjectDB->getNama(),
				"foto" => "filesupport/getPhotoDosenProfil/".$tempObjectDB->getNip().".aspx",
				"title" => "Dosen | SIKTA halaman utama"
			));
		} 
		return array(NULL,array(
			"nim" => "",
			"nama" => "Pengunjung",
			"foto" => "filesupport/getFotoUserDefault.jsp",
			"title" => "Pengunjung | SIKTA halaman utama"
		));
	}
	//optimized
	//logout with default as desktop if login
	public function signOutLocalLogin(){
		(new LoginFilter($this->session))->setLogOut();
		redirect(base_url());
	}
	//optimized
	//load main page of default
	public function index(){
		$data['url_script'] = array(
				"resources/taurus/js/plugins/jquery/jquery.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui.min.js",
				"resources/taurus/js/plugins/jquery/jquery-migrate.min.js",
				"resources/taurus/js/plugins/jquery/globalize.js",
				"resources/taurus/js/plugins/bootstrap/bootstrap.min.js",
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
				"resources/taurus/js/plugins/select2/select2.min.js",
				"resources/taurus/js/plugins/tagsinput/jquery.tagsinput.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui-timepicker-addon.js",
				"resources/taurus/js/plugins/fullcalendar/fullcalendar.min.js",
				"resources/plugins/fullcalendar/v2/lib/moment.min.js",
				"resources/taurus/js/settings.js",
				"resources/taurus/js/plugins/noty/jquery.noty.js",
				"resources/taurus/js/plugins/noty/layouts/topCenter.js",
				"resources/taurus/js/plugins/noty/layouts/topLeft.js",
				"resources/taurus/js/plugins/noty/layouts/topRight.js",
				"resources/taurus/js/plugins/noty/themes/default.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js",
				"resources/mystyle/js/global-style.js",
				"resources/LibraryJaserv/NextPreControl.js",
				"resources/mystyle/js/Baseroom.js",
				"resources/mystyle/js/Baseroom-beranda.js",
				"resources/mystyle/js/Baseroom-registrasi.js",
				"resources/mystyle/js/Baseroom-seminar.js"
				
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/baseroom.css"
		);
		$statusData = $this->getDataLocalNameLogin();
		$data['core'] = $statusData[0];
		$data['nim'] = $statusData[1]['nim'];
		$data['nama'] = $statusData[1]['nama'];
		$data['title'] = $statusData[1]['title'];
		$this->load->view('Structure/Header',$data);
		$this->load->view('Structure/Bodytop');
		$dataleft['core'] = $statusData[0];
		$dataleft['image'] = $statusData[1]['foto'];
		$dataleft['nama'] = $statusData[1]['nama'];
		$this->load->view('Structure/Bodyleft',$dataleft);
		$this->load->view('Bodyright/Baseroom/Bodyright');
		$this->load->view('Structure/Bodyplug');
		$dataFoot['url_script'] = array(
				"resources/plugins/calender/underscore-min.js",
				"resources/plugins/calender/moment-2.2.1.js",
				"resources/plugins/calender/clndr.js",
				"resources/plugins/calender/site.js"
		);
		$dataFoot['url_link'] = array(
				"resources/plugins/calender/clndr.css"
		);
		$this->load->view('Structure/Footer',$dataFoot);
	}
}