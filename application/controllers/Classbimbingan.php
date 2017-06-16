<?php
/*
This Class has been rebuild revision build v3.0 Gateinout.php
Author By : Jafar Abdurrahman Albasyir
Since : 17/5/2016
Work : Home on 08:05 PM
dependencie:
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlTime
*/
defined('BASEPATH') OR exit('What Are You Looking For ?');
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Classbimbingan extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->loadLib('ControlTime');
		$this->dosen->initial($this->inputJaservFilter);
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->mahasiswa)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	//sessi bimbingan
	public function getLayoutBimbingan(){
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlMahasiswa');
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempObjectDB = $controlRegistrasi->getAllDataWithDosbing($tahunAk,$this->loginFilter->getIdentifiedActive(),1,null);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			$TEMP_ARRAY['TEMP_NIP'] = "Belum tersedia";
			$TEMP_ARRAY['TEMP_NAMA'] = "Belum tersedia"; 
			$TEMP_ARRAY['TEMP_BIDANG'] = "Belum tersedia";
			$TEMP_ARRAY['TEMP_DATA'][0] = array(
				'NO' => "-",
				'NIM' => "-",
				'NAMA' => "-",
				'TITLE' => "-",
				'STATUE' => "-"
			); 			
		}else{
			$tempObjectDBD = $tempObjectDB->getTableStack(2);
			$TEMP_ARRAY['TEMP_NIP'] = $tempObjectDBD->getNip();
			$TEMP_ARRAY['TEMP_NAMA'] = $tempObjectDBD->getNama(); 
			$TEMP_ARRAY['TEMP_BIDANG'] = $tempObjectDBD->getBidangRiset();
			$tempObjectDBs = $controlRegistrasi->getAllDataByDosen($tahunAk, $tempObjectDBD->getIdentified());
			if($tempObjectDBs){
				$i=0;
				while($tempObjectDBs->getNextCursor()){
					$tempObjectDB = $tempObjectDBs->getTableStack(1);
					$TEMP_CAT = "lama"; 
					if(intval($tempObjectDB->getKategori()) == 1)
						$TEMP_CAT = 'baru';
					$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDB->getMahasiswa());
					$tempObjectDBD->getNextCursor();
					$TEMP_ARRAY['TEMP_DATA'][$i] = array(
						'NO' =>$i+1,
						'NIM' => $tempObjectDBD->getNim(),
						'NAMA' => $tempObjectDBD->getNama(),
						'TITLE' => $tempObjectDB->getJudulTA(),
						'STATUE' => $TEMP_CAT
					);
					$i++;
				}
			}else{
				$TEMP_ARRAY['TEMP_DATA'][0] = array(
					'NO' => "-",
					'NIM' => "-",
					'NAMA' => "-",
					'TITLE' => "-",
					'STATUE' => "-"
				); 				
			}
		}
		$tempObjectDB = $controlDosen->getDataByStatus();
		$i=0;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$TEMP_ARRAY['DATA_DOSEN'][$i] = array(
					'NO' => $i+1,
					'NIP' => $tempObjectDB->getNip(),
					'NAMA' => $tempObjectDB->getNama()
				);
				$i++;	
			}
		}else{
			$TEMP_ARRAY['DATA_DOSEN'] = null;
		}
		echo "1";
		$this->load->view("Bodyright/Classroom/Bimbingan",$TEMP_ARRAY);
	}
	//get contact list
	public function getJsonListMahasiswa(){
		
		$nip = $this->isNullPost('nip');
		if(!$this->dosen->getCheckNip($nip,1))
			exit("0Anda melakukan debuging");
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		
		$tes = 0;
		$temp2="";
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip);
		if($tempObjectDB && $tempObjectDB->getNextCursor()){
			$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
			$tempObjectDBT = (new ControlRegistrasi($this->gateControlModel))->getAllDataByDosen($tahunAk, $tempObjectDB->getIdentified());
			if($tempObjectDBT){
				$i=0;
				while($tempObjectDBT->getNextCursor()){
					$tes +=1;
					$tempObjectDBD = $controlMahasiswa->getAllData($tempObjectDBT->getTableStack(1)->getMahasiswa());
					$tempObjectDBD->getNextCursor();
					$temp2.='["'.$tempObjectDBD->getNama().'",'.$tempObjectDBD->getNim().',"upload/foto/'.$tempObjectDBD->getNamaFoto().'"],';
				}
			}else{
				$temp2.='["-","-","upload/foto/-user.jpg"],';			
			}
		}else{
			$temp2.='["-","-","upload/foto/-user.jpg"],';			
		}
		
		if($temp2 != "") $temp2 = substr($temp2, 0,strlen($temp2)-1);
		$json = '{"data": ['.$tes;
		$json .= ",[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
}