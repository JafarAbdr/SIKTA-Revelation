<?php if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Baseseminar extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Inputjaservfilter");
	}
	/*
	dependencies:
	-ControlDosen(-)
	-ControlDetail(-)
	-ControlMahasiswa(-)
	-ControlRegistrasi(-)
	-ControlSeminar
	-ControlSidang
	-ControlTime
	-Inputjaservfilter(-)
	-GateControlModel(-)
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
		if($this->input->post("keyword")!==NULL && $this->input->post("keyword")!= "" && $this->input->post("keyword")!= " "){
			$keyword = $this->input->post("keyword")."";
		}
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlTime');
		$kode = 1;
		$string = "";
		$tempSeminarS = (new ControlSeminar($this->gateControlModel))->getAllDataWithMahasiswa((new ControlTime($this->gateControlModel))->getYearNow(),1,2,true);
		if($tempSeminarS){
			while($tempSeminarS->getNextCursor()){
				$tempSeminar = $tempSeminarS->getTableStack(0);
				$tempMahasiswa = $tempSeminarS->getTableStack(1);
				$tempRuang = $tempSeminarS->getTableStack(2);
				$tempRegistrasi = $tempSeminarS->getTableStack(5);
				$tempDosen = $tempSeminarS->getTableStack(7);
				if(
					$keyword == "*" || 
					strpos($tempMahasiswa->getNim(),$keyword) !== false ||
					strpos(strtolower($tempMahasiswa->getNama()),strtolower($keyword)) !== false ||
					strpos(strtolower($tempDosen->getNama()),strtolower($keyword)) !== false ||
					strpos(strtolower($tempRegistrasi->getJudulTA()),strtolower($keyword)) !== false
				){	
					if(strlen($tempRuang->getDetail()) > 0){
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
		if($this->input->post("keyword")!==NULL && $this->input->post("keyword")!= "" && $this->input->post("keyword")!= " "){
			$keyword = $this->input->post("keyword")."";
		}
		$kode = 1;
		$string = "";
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlTime');
		$tempSidangS = (new ControlSidang($this->gateControlModel))->getAllDataWithMahasiswa((new ControlTime($this->gateControlModel))->getYearNow(),1,2,true);
		if($tempSidangS){
			while($tempSidangS->getNextCursor()){
				$tempSidang = $tempSidangS->getTableStack(0);
				$tempMahasiswa = $tempSidangS->getTableStack(1);
				$tempRuang = $tempSidangS->getTableStack(2);
				$tempRegistrasi = $tempSidangS->getTableStack(4);
				$tempDosen = $tempSidangS->getTableStack(6);
				if(
					$keyword == "*" || 
					strpos($tempMahasiswa->getNim(),$keyword) !== false ||
					strpos(strtolower($tempMahasiswa->getNama()),strtolower($keyword)) !== false ||
					strpos(strtolower($tempDosen->getNama()),strtolower($keyword)) !== false ||
					strpos(strtolower($tempRegistrasi->getJudulTA()),strtolower($keyword)) !== false
				){	
					if(strlen($tempRuang->getDetail()) > 0){
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