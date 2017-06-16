<?php
if(!defined('BASEPATH')) exit("you dont have permission to see this site");
/*
dependencies:
-Dosen
-Mahasiswa
-ControlDosen
*/
require_once APPPATH.'controllers/CI_Controller_Modified.php';
class Kingroom extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->dosen))
			redirect(base_url().'Gateinout.jsp');
	}
	public final function signOut(){
		$this->loginFilter->setLogOut();
		redirect(base_url()."Gateinout.jsp");
	}
	public function index(){
		if(!$this->loginFilter->isLogin($this->dosen))
			redirect(base_url().'Gateinout.jsp');
		$this->loadLib('ControlDosen');
		$controlDosen = new ControlDosen($this->gateControlModel);
		$tempObjectDB = $controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDB->getNextCursor();
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
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
				"resources/taurus/js/plugins/noty/jquery.noty.js",
				"resources/taurus/js/plugins/noty/layouts/topCenter.js",
				"resources/taurus/js/plugins/noty/layouts/topLeft.js",
				"resources/taurus/js/plugins/noty/layouts/topRight.js",
				"resources/taurus/js/plugins/noty/themes/default.js",
				"resources/taurus/js/js.js",
				"resources/PDF/pdfobject.min.js",
				"resources/taurus/js/settings.js",
				"resources/LibraryJaserv/js/jaserv.min.dev.js",
				"resources/mystyle/js/global-style.js",
				"resources/mystyle/js/Kingroom.js",
				"resources/mystyle/js/Kingroom_pengaturan.js",
				"resources/mystyle/js/Kingroom-bimbingan.js",
				"resources/mystyle/js/Kingroom-penguji.js"
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/Controlroom.css"
		);
		$data['nim'] = "";
		$data['nama'] = $tempObjectDB->getNama();
		$data['title'] = "Home | Dosen";
		$this->load->view('Structure/Header',$data);
		$this->load->view('Structure/Bodytopking');
		$dataleft['image'] = "Filesupport/getPhotoDosenProfil/".$tempObjectDB->getNip();
		$this->load->view('Structure/Bodyleftking',$dataleft);
		$this->load->view('Bodyright/Kingroom/Bodyright');
		$this->load->view('Structure/Bodyplugking');
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
