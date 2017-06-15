<?php if(!defined('BASEPATH')) exit("");
	require_once(APPPATH.'controllers/CI_Controller_Modified.php');
	/*
	dependencies
	-ControlDetail
	-ControlDosen(-)
	-ControlMahasiswa(-)
	-ControlRegistrasi
	-ControlTime
	-inputjaservfilter(-)
	*/
class Baseregistrasi extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
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
		if($this->input->post("keyword")!==NULL && $this->input->post("keyword")!= "" && $this->input->post("keyword")!= " "){
			$keyword = $this->input->post("keyword")."";
		}
		if($this->input->post('page') === NULL)
			$page = 1;
		else{		
			$page = intval($this->isNullPost('page'));
			if($page < 1)
				$page = 1;	
		}
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlTime');
		$this->loadLib('ControlDetail');
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$tempRegistrasiS = $controlRegistrasi->getAllDataWithDosbing((new ControlTime($this->gateControlModel))->getYearNow(),null,1,2,true);
		$n = 1;
		$z = 1;
		$koko = 0;
		$string = "";
		$i = 1;
		if($tempRegistrasiS){
			while($tempRegistrasiS->getNextCursor()){
				$tempRegistrasi = $tempRegistrasiS->getTableStack(1);
				$tempDosen = $tempRegistrasiS->getTableStack(2);
				$tempMahasiswa = $tempRegistrasiS->getTableStack(3);
				if(
					$keyword == "*" || 
					strpos($tempMahasiswa->getNim(),$keyword) !== false ||
					strpos(strtolower($tempMahasiswa->getNama()),strtolower($keyword)) !== false ||
					strpos(strtolower($tempDosen->getNama()),strtolower($keyword)) !== false ||
					strpos(strtolower($tempRegistrasi->getJudulTA()),strtolower($keyword)) !== false
				){
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