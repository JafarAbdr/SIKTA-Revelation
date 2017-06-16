<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
-Koordinator
*/
class Controlroom extends CI_Controller_Modified {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->koordinator)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	function index(){
		$data['url_script'] = array(
				"resources/taurus/js/plugins/jquery/jquery.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui.min.js",
				"resources/taurus/js/plugins/jquery/jquery-migrate.min.js",
				"resources/taurus/js/plugins/jquery/globalize.js",
				"resources/taurus/js/plugins/bootstrap/bootstrap.min.js",
				//"resources/taurus/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js",
				"resources/taurus/js/plugins/uniform/jquery.uniform.min.js",
/* 				"resources/taurus/js/plugins/knob/jquery.knob.js",
				"resources/taurus/js/plugins/sparkline/jquery.sparkline.min.js",
				"resources/taurus/js/plugins/flot/jquery.flot.js",
				"resources/taurus/js/plugins/flot/jquery.flot.resize.js", */
				"resources/taurus/js/plugins/select2/select2.min.js",
				"resources/taurus/js/plugins/tagsinput/jquery.tagsinput.min.js",
				"resources/taurus/js/plugins/jquery/jquery-ui-timepicker-addon.js",
/* 				"resources/taurus/js/plugins/ibutton/jquery.ibutton.js",
				"resources/taurus/js/plugins/validationengine/languages/jquery.validationEngine-en.js",
				"resources/taurus/js/plugins/validationengine/jquery.validationEngine.js",
				"resources/taurus/js/plugins/maskedinput/jquery.maskedinput.min.js",
				"resources/taurus/js/plugins/stepy/jquery.stepy.min.js", */
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
				"resources/LibraryJaserv/NextPreControl.js",
				"resources/mystyle/js/global-style.js",
				"resources/mystyle/js/Controlroom.js",
				"resources/mystyle/js/Controlroom-acara.js",
				"resources/mystyle/js/Controlroom-registrasi.js",
				"resources/mystyle/js/Controlroom-seminar.js",
				"resources/mystyle/js/Controlroom-pengaturan.js",
				"resources/mystyle/js/Controlroom-dosen.js",
				"resources/mystyle/js/Controlroom-mahasiswa.js",
				"resources/mystyle/js/Controlroom-rekap.js",
				"resources/Chart/Chart.js"
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/Controlroom.css"
		);
		$data['nim'] = "";
		$data['nama'] = "Koordinator TA";
		$data['title'] = "Acara | Koordinator";
		$this->load->view('Structure/Header',$data);
		$this->load->view('Structure/Bodytopct');
		$dataleft['image'] = 'resources/mystyle/image/koor.png';
		$this->load->view('Structure/Bodyleftct',$dataleft);
		$this->load->view('Bodyright/Controlroom/Bodyright');
		$this->load->view('Structure/Bodyplugct');
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
	public function signOut(){
		$this->loginFilter->setLogOut();
		redirect(base_url()."Gateinout.jsp");
	}
}