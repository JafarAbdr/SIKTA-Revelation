<?php if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Baseseminar extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Inputjaservfilter");
	}
	/*
	dependencies:
	-ControlDosen
	-ControlDetail
	-ControlMahasiswa
	-ControlRegistrasi
	-ControlSeminar
	-ControlSidang
	-ControlTime
	-Inputjaservfilter
	*/
	//optimized
	//get page layout seminar
	public function getLayoutSeminar(){
		echo "1";
		$this->load->view("Bodyright/Baseroom/Seminar");
	}
	//optimized
	//get content list of ta registration 
	public function getTableSeminarTA1InfoPublic(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->inputjaservfilter->titleFiltering($keyword)[0]){
				$keyword = "*";
			}
		}
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDetail');
		$this->loadMod('GateControlModel');
		$gateControlModel = new GateControlModel();
		$controlRegistrasi = new ControlRegistrasi($gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($gateControlModel);
		$controlDosen = new ControlDosen($gateControlModel);
		$controlDetail = new ControlDetail($gateControlModel);
		$kode = 1;
		$string = "";
		$tempSeminarS = (new ControlSeminar($gateControlModel))->getAllDataWithMahasiswa((new ControlTime($gateControlModel))->getYearNow());
		if($tempSeminarS){
			while($tempSeminarS->getNextCursor()){
				$tempSeminar = $tempSeminarS->getTableStack(0);
				$tempMahasiswa = $tempSeminarS->getTableStack(1);
				$tempRegistrasiS = $controlRegistrasi->getAllDataWithDosbing($tempSeminar->getTahunAk(),$tempSeminar->getMahasiswa());
				if($tempRegistrasiS->getNextCursor()){
					$tempRegistrasi = $tempRegistrasiS->getTableStack(1); 
					$tempDosen = $tempRegistrasiS->getTableStack(2); 
					if($keyword == "*" || strpos($tempRegistrasi->getJudulTa(),$keyword) !== false){	
						$tempRuang = $controlDetail->getDetail('ruang',$tempRegistrasi->getDataProses());
						if($tempRuang->getNextCursor()){
							$string .=
							"<tr>
								<td style='text-align : center;'>".$tempMahasiswa->getNim()."</td>
								<td style='text-align : center;'>".$tempMahasiswa->getNama()."</td>
								<td style='text-align : center;'>".$tempRegistrasi->getJudulTa()."</td>
								<td style='text-align : center;'>".$tempRuang->getDetail()."</td>
								<td style='text-align : center;'>".$tempSeminar->getWaktu()."</td>
								<td style='text-align : center;'>".$tempDosen->getNama()."</td>
							</tr>
							";	
						}
					}
					
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	//optimized
	//get content list of final exam step 2 registration 
	public function getTableSeminarTA2InfoPublic(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->inputjaservfilter->titleFiltering($keyword)[0]){
				$keyword = "*";
			}
		}
		$kode = 1;
		$string = "";
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDetail');
		$this->loadMod('GateControlModel');
		$gateControlModel = new GateControlModel();
		$controlRegistrasi = new ControlRegistrasi($gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($gateControlModel);
		$controlDosen = new ControlDosen($gateControlModel);
		$controlDetail = new ControlDetail($gateControlModel);
		$tempSidangS = (new ControlSidang($gateControlModel))->getAllDataWithMahasiswa((new ControlTime($gateControlModel))->getYearNow());
		
		if($tempSidangS){
			while($tempSidangS->getNextCursor()){
				$tempSidang = $tempSidangS->getTableStack(0);
				$tempMahasiswa = $tempSidangS->getTableStack(1);
				$tempRegistrasiS = $controlRegistrasi->getAllDataWithDosbing($tempSidang->getTahunAk(),$tempSidang->getMahasiswa());
				if($tempRegistrasiS->getNextCursor()){
					$tempRegistrasi = $tempRegistrasiS->getTableStack(1);
					$tempDosen = $tempRegistrasiS->getTableStack(2);
					if($keyword == "*" || !is_bool(strpos(strtolower($tempRegistrasi->getJudulTA()),strtolower($keyword)))){	
						$tempRuang = $controlDetail->getDetail('ruang',$tempRegistrasi->getDataProses());
						if($tempRuang->getNextCursor()){
							$string .=
							"<tr>
								<td style='text-align : center;'>".$tempMahasiswa->getNim()."</td>
								<td style='text-align : center;'>".$tempMahasiswa->getNama()."</td>
								<td style='text-align : center;'>".$tempRegistrasi->getJudulTa()."</td>
								<td style='text-align : center;'>".$tempRuang->getDetail()."</td>
								<td style='text-align : center;'>".$tempSidang->getWaktu()."</td>
								<td style='text-align : center;'>".$tempDosen->getNama()."</td>
							</tr>
							";	
						}
					}
					
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
}