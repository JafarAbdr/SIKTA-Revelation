<?php if(!defined('BASEPATH')) exit("");
	require_once(APPPATH.'controllers/CI_Controller_Modified.php');
	/*
	dependencies
	-ControlDetail
	-ControlDosen
	-ControlMahasiswa
	-ControlRegistrasi
	-ControlTime
	-inputjaservfilter
	*/
class Baseregistrasi extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library('Inputjaservfilter');
		
		$this->load->helper("Url");
	}
	//optimized
	//get template registrasi
	public function getLayoutRegistrasi(){
		echo "1";
		$this->load->view("Bodyright/Baseroom/Registrasi");
	}
	public function getTableInfoPublicRegistrasi(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->inputjaservfilter->numberFiltering($keyword)[0]){
				$keyword = "*";
			}
		}
		if($this->input->post('page') === NULL)
			$page = 1;
		else{		
			$page = intval($this->isNullPost('page'));
			if($page < 1)
				$page = 1;	
		}
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDetail');
		$this->loadMod('GateControlModel');
		$gateControlModel = new GateControlModel();
		$controlRegistrasi = new ControlRegistrasi($gateControlModel);
		$controlDosen = new ControlDosen($gateControlModel);
		$controlDetail = new ControlDetail($gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($gateControlModel);
		$tempRegistrasi = $controlRegistrasi->getAllData((new ControlTime($gateControlModel))->getYearNow());
		$n = 1;
		$z = 1;
		$koko = 0;
		$string = "";
		$i = 1;
		if($tempRegistrasi){
			while($tempRegistrasi->getNextCursor()){
				if($tempRegistrasi->getDataProses() == '2'){
					$tempMahasiswa = $controlMahasiswa->getAllData($tempRegistrasi->getMahasiswa());
					if($tempMahasiswa->getNextCursor()){
						if($keyword == "*" || !is_bool(strpos(strtolower($tempMahasiswa->getNim()),strtolower($keyword)))){
							$tempDosbing = $controlRegistrasi->getDosenPembimbing($tempRegistrasi->getIdentified());
							$tempDosbing->getNextCursor();
							if(strlen($tempDosbing->getDosen()) == 40 ){
								$tempDosen = $controlDosen->getAllData($tempDosbing->getDosen());
								if($tempDosen->getNextCursor()){
									if($n <= 15 && $z == $page){ 
										$tempDataProses = $controlDetail->getDetail('dataproses',$tempRegistrasi->getDataProses());
										$string .=
										"<tr>".
											"<td style='text-align : center;'>".$i."</td>".
											"<td style='text-align : center;'>".$tempMahasiswa->getNim()."</td>".
											"<td style='text-align : center;'>".$tempMahasiswa->getNama()."</td>".
											"<td style='text-align : center;'>".$tempRegistrasi->getJudulTa()."</td>".
											"<td style='text-align : center;'>".$tempDosen->getNama()."</td>".
											"<td style='text-align : center;'>".$tempDataProses->getDetail()."</td>".
										"</tr>";
										
										$koko ++;
										$n++;
									}else if($n == 15 && $z < $page){
										$n = 1;
										$z++;
									}else{
										$n++;
									} 
									$i++;
								}
							}	
						}
					}
				}
			}
		}
		$result['left'] = 1;
		$result['right'] = 1;
		if($page == 1){
			if($koko == 15){				
				$result['left'] = 0;
				$result['right'] = 1;
			}else{				
				$result['left'] = 0;
				$result['right'] = 0;
			}
		}else{
			if($koko == 15){				
				$result['left'] = 1;
				$result['right'] = 1;
			}
			else{				
				$result['left'] = 1;
				$result['right'] = 0;
			}
		}
		if($string == ""){
			$string .=
			"<tr>".
				"<td style='text-align : center;'>-</td>".
				"<td style='text-align : center;'>-</td>".
				"<td style='text-align : center;'>-</td>".
				"<td style='text-align : center;'>-</td>".
				"<td style='text-align : center;'>-</td>".
				"<td style='text-align : center;'>-</td>".
			"</tr>";
		}
		$result['string'] = $string;
		echo "1".json_encode($result);
		
	}
}