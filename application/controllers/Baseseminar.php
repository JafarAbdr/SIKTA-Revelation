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
		$tempSeminar = (new ControlSeminar($gateControlModel))->getAllData((new ControlTime($gateControlModel))->getYearNow());
		if($tempSeminar){
			while($tempSeminar->getNextCursor()){
				$tempRegistrasi = $controlRegistrasi->getAllData($tempSeminar->getTahunAk(),$tempSeminar->getMahasiswa());
				if($tempRegistrasi->getNextCursor()){
					if($keyword == "*" || strpos($tempRegistrasi->getJudulTa(),$keyword) !== false){	
						$tempMahasiswa = $controlMahasiswa->getAllData($tempRegistrasi->getMahasiswa());
						if($tempMahasiswa->getNextCursor()){
							$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempRegistrasi->getIdentified());
							$tempDosbing->getNextCursor();
							$tempDosen = $controlDosen->getAllData($tempDosbing->getDosen());
							if($tempDosen->getNextCursor()){
								$tempRuang = $controlDetail->getDetail('ruang',$tempRegistrasi->getDataProses());
								if($tempRuang->getNextCursor()){
									//echo "kokoko";
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
		$tempSidang = (new ControlSidang($gateControlModel))->getAllData((new ControlTime($gateControlModel))->getYearNow());
		
		if($tempSidang){
			while($tempSidang->getNextCursor()){
				$tempRegistrasi = $controlRegistrasi->getAllData($tempSidang->getTahunAk(),$tempSidang->getMahasiswa());
				if($tempRegistrasi->getNextCursor()){
					if($keyword == "*" || !is_bool(strpos(strtolower($tempRegistrasi->getJudulTA()),strtolower($keyword)))){	
						$tempMahasiswa = $controlMahasiswa->getAllData($tempRegistrasi->getMahasiswa());
						if($tempMahasiswa->getNextCursor()){
							$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempRegistrasi->getIdentified());
							$tempDosbing->getNextCursor();
							$tempDosen = $controlDosen->getAllData($tempDosbing->getDosen());
							if($tempDosen->getNextCursor()){
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