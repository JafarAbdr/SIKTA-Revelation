<?php
/*
dependencies
-LoginFilter
-GateControlModel
-Admin
-ControlDosen
*/
if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Palaceroom extends CI_Controller_Modified{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('Aktor/Admin');
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->admin))
			redirect(base_url().'Gateinout.jsp');
	}
	function index(){
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
				"resources/mystyle/js/Palaceroom.js",
				"resources/mystyle/js/Palaceroom-pengaturan.js",
				"resources/mystyle/js/Palaceroom-acara.js",
				"resources/Chart/Chart.js"
		);
		$data['url_link'] = array(
				"resources/taurus/css/stylesheets.css",
				"resources/mystyle/css/global-style.css",
				"resources/mystyle/css/Controlroom.css"
		);
		$data['nim'] = "";
		$data['nama'] = "Administrator TA";
		$data['title'] = "Kontrol mahasiswa | Administrator";
		$this->load->view('Structure/Header',$data);
		$this->load->view('Structure/Bodytopp');
		$dataleft['image'] = 'resources/mystyle/image/koor.png';
		$this->load->view('Structure/Bodyleftp',$dataleft);
		$this->loadLib('ControlDosen');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getAllData(null,1);	
		$dataDosen['listDosen'] = array();
		if($tempObjectDB){
			$ii = 0;
			while($tempObjectDB->getNextCursor()){
				$dataDosen['listDosen'][$ii]['nip'] = $tempObjectDB->getNip();
				$dataDosen['listDosen'][$ii]['nama'] = $tempObjectDB->getNama();
				$ii++;
			}
		}
		$this->load->view('Bodyright/Palaceroom/Bodyright',$dataDosen);
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
	public function signOut(){
		$this->loginFilter->setLogOut();
		redirect(base_url()."Gateinout.jsp");
	}
	
	
	
}