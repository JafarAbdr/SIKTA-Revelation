<?php
if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
dependencies:
-Koordinator
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
class Controlakunmahasiswa extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->mahasiswa->initial($this->inputJaservFilter);
		if(!$this->loginFilter->isLogin($this->koordinator)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	public function getLayoutRegistrasi(){
		echo "1";
		$this->load->view("Bodyright/Controlroom/Mahasiswa");
	}
	public function tryNoTime(){
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("0nim tidak valid");
		}
		$this->loadLib('ControlMahasiswa');
		if((new ControlMahasiswa($this->gateControlModel))->setNewTanpaWaktu($nim)) exit("1data berhasil di rubah");
		exit("0Terjadi kesalahan saat merupah data");
	}
	public function setAktifOrNon(){
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("0nim tidak valid");
		}
		$this->loadLib('ControlMahasiswa');
		if((new ControlMahasiswa($this->gateControlModel))->setNewStatus($nim)) exit("1data berhasil di rubah");
		exit("0Terjadi kesalahan saat merubah data");
	}
	public function setNormalNewOrOld(){
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("0nim tidak valid");
		}
		$this->loadLib('ControlMahasiswa');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0Nim tidak terdaftar");
		}
		if(intval($tempObjectDB->getStatus()) != 1){
			exit("0Nim tidak memiliki izin karena mahasiswa non aktif");
		}
		$kode = intval($this->isNullPost("kode"));
		if($kode < 1 || $kode > 3){
			exit("0Kode tidak tepat");
		}
		if(intval($tempObjectDB->getFormBaru()) == 1)
			if($kode != 3)
				exit("0Silahkan registrasi dahulu sebelum melakukan perubahan");
		
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlTime');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB->setFormBaru(1);
		$tempObjectDB->setRegistrasiLama(2);
		$tempObjectDB->setRegistrasiBaru(2);
		
		
		if($kode == 1){
			if($controlRegistrasi->getAllData($tahunAk ,$tempObjectDB->getIdentified(),1 , 0, null)->getNextCursor()){
				exit("0maaf anda sudah melakukan registrasi pada semester ini");
			}
			
		}else if($kode == 2){
			if(!$controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk)[0]){
				if(!$controlRegistrasi->getAllData($tahunAk ,$tempObjectDB->getIdentified(),1 , 0, null)->getNextCursor()){
					exit("0silahkan registrasi form normal");
				}
			}
			$tempObjectDB->setRegistrasiBaru(1);
		}else if($kode == 3) {
			if($controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk)[0]){
				exit("0TA lama ditemukan, registerasi baru");
			}
			if($controlRegistrasi->getAllData($tahunAk ,$tempObjectDB->getIdentified(),1 , 0, null)->getNextCursor()){
				exit("0anda sudah melakukan registrasi pada semester ini");
			}
			$tempObjectDB->setRegistrasiBaru(1);
			$tempObjectDB->setRegistrasiLama(1);
		}
		
		if($controlMahasiswa->tryUpdate($tempObjectDB)){
			$this->loadLib("ControlSeminar");
			$this->loadLib("ControlSidang");
			(new ControlSeminar($this->gateControlModel))->logSeminarActive($tahunAk, $tempObjectDB->getIdentified());
			(new ControlSidang($this->gateControlModel))->logSidangActive($tahunAk, $tempObjectDB->getIdentified());
			exit("1data berhasil di rubah");
		}
		else exit("0Terjadi kesalahan saat merupah data");
	}
	public function getTableAllAcountMahasiswa(){
		if($this->input->post('page') === NULL)
			$page = 1;
		else{		
			$page = intval($this->isNullPost('page'));
			if($page < 1)
				$page = 1;	
		}
		$key = null;
		if($this->input->post('keyword') === NULL)
			$key = "*";
		else if($this->isNullPost('keyword') == "" || $this->isNullPost('keyword') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('keyword'))[0]){
				echo "0Kata kunci harus berupa bagian nama dari seseorang";
				return;
			}else
				$key = $this->isNullPost('keyword');
		}
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlTime');
		
		
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData();
		
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		
		$string = "";
		$i=1;
		$n = 1;
		$z = 1;
		$koko = 0;
		
		if($tempObjectDB && $tempObjectDB->getCountData() > 0){
			$i=1;
			while($tempObjectDB->getNextCursor()){
				if($key == "*" || !is_bool(strpos(strtolower($tempObjectDB->getNama()),strtolower($key)))){
					if($n <= 15 && $z == $page){
						if(intval($tempObjectDB->getStatus()) != 1){
							$aktivasiAttr = "onClick='aktifkanThisGuysAccount(".'"'.$tempObjectDB->getNim().'"'.")'";
							$noTimeAttr = " style='color : red;'";
							$normalSeminarAttr = "disabled";
							$paksaTA1Attr = "disabled";
							$paksaTA2Attr = "disabled";
							$string.="<tr  style=''>".
							"<td>".$i."</td>".
							"<td>".$tempObjectDB->getNim()."</td>".
							"<td>".$tempObjectDB->getNama()."</td>".
							"<td>".
								"<div  style='font-size : 10pt;'>".
								"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$aktivasiAttr."  style='color : green; cursor : pointer;'  title='klik untuk mengaktifkan mahasiswa' class='icon-eye-close'> non-aktif</i></span>".
								"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$normalSeminarAttr." style='color : red; ' title='aktifkan menu registrasi normal' class='icon-pushpin'> auto</i></span>".
								"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$noTimeAttr." title='aktifkan menu registrasi normal' class='icon-pushpin'> no time</i></span>".
								"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$paksaTA1Attr." style='color : red;' title='aktifkan menu registrasi paksa baru' class='icon-backward'> baru</i></span>".
								"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$paksaTA2Attr." style='color : red;' title='aktifkan menu registrasi paksa melanjutkan' class='icon-forward'> lama</i></span>".
								"</div>".
							"</td>".
							"</tr>";
						}else{
							$colorStyle = 'green';
							if(intval($tempObjectDB->getTanpaWaktu()) == 2)
								$colorStyle = 'red';
							$noTimeAttr = " style='color : ".$colorStyle."; cursor : pointer;' onclick='tryNoTime(".'"'.$tempObjectDB->getNim().'"'.")'";
							if(intval($tempObjectDB->getFormBaru()) == 1){
								$aktivasiAttr = "onClick='nonAktifkanThisGuysAccount(".'"'.$tempObjectDB->getNim().'"'.")'";
								$normalSeminarAttr = "disabled";
								$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk ,$tempObjectDB->getIdentified(),1, 0,null);
								if($tempObjectDB && $tempObjectDB->getCountData() > 0){
									if($controlRegistrasi->getCodeRegLastTA($tempObjectDB,$tahunAk)[0]){
										$paksaTA1Attr = "disabled  style='color : red; ' ";
										$paksaTA2Attr = "disabled  style='color : red;' ";
									}else{
										if(intval($tempObjectDB->getRegistrasiLama()) == 2){								
											$paksaTA1Attr = "disabled  style='color : red; ' ";
											$paksaTA2Attr = "onClick='lastForceSeminar(".'"'.$tempObjectDB->getNim().'"'.")'  style='color : green; cursor : pointer;' ";
										}else{
											$paksaTA1Attr = "disabled  style='color : red; ' ";
											$paksaTA2Attr = "disabled  style='color : red;' ";
										}
									}
								}else{
									$paksaTA1Attr = "disabled  style='color : red; ' ";
									$paksaTA2Attr = "disabled  style='color : red;' ";								
								}
								$string.="<tr style='width : 1000px;'>".
								"<td>".$i."</td>".
								"<td>".$tempObjectDB->getNim()."</td>".
								"<td>".$tempObjectDB->getNama()."</td>".
								"<td >".
									"<div style='font-size : 10pt;'>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$aktivasiAttr."  style='color : green; cursor : pointer;'  title='klik untuk menon-aktifkan mahasiswa' class='icon-eye-open'> aktif</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$normalSeminarAttr." style='color : red; ' title='aktifkan menu registrasi normal' class='icon-pushpin'> auto</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$noTimeAttr." title='aktifkan menu registrasi normal' class='icon-pushpin'> no time</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$paksaTA1Attr." title='aktifkan menu registrasi paksa baru' class='icon-backward'> baru</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$paksaTA2Attr."  title='aktifkan menu registrasi paksa melanjutkan' class='icon-forward'> lama</i></span>".
									"</div>".
								"</td>".
								"</tr>";
							}else{
								$aktivasiAttr = "onClick='aktifkanThisGuysAccount(".'"'.$tempObjectDB->getNim().'"'.")'";
								$tempObjectDBD = $controlRegistrasi->getAllData($tahunAk ,$tempObjectDB->getIdentified(),1, 0,null);
								if($tempObjectDB && $tempObjectDB->getCountData() > 0){
									$normalSeminarAttr = "onClick='normalSeminar(".'"'.$tempObjectDB->getNim().'"'.")' style='color : green; cursor : pointer;' ";
									if($controlRegistrasi->getCodeRegLastTA($tempObjectDB, $tahunAk,true)[0]){
										$paksaTA2Attr = "disabled  style='color : red;' ";
										$paksaTA1Attr = "onClick='newForceSeminar(".'"'.$tempObjectDB->getNim().'"'.")'  style='color : green; cursor : pointer;' ";	
									}else{
										$paksaTA1Attr = "disabled  style='color : red; ' ";
										$paksaTA2Attr = "onClick='lastForceSeminar(".'"'.$tempObjectDB->getNim().'"'.")'  style='color : green; cursor : pointer;' ";	
									}
								}else{
									$normalSeminarAttr = "disabled style='color : red;'";
									$paksaTA2Attr = "disabled  style='color : red;' ";
									$paksaTA1Attr = "onClick='newForceSeminar(".'"'.$tempObjectDB->getNim().'"'.")'  style='color : green; cursor : pointer;' ";	
								}
								$string.="<tr style='width : 1000px;'>".
								"<td>".$i."</td>".
								"<td>".$tempObjectDB->getNim()."</td>".
								"<td>".$tempObjectDB->getNama()."</td>".
								"<td  style=';'>".
									"<div  style='font-size : 10pt;'>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$aktivasiAttr." style='color : green; cursor : pointer;' title='klik untuk menon-aktifkan mahasiswa' class='icon-eye-open'> aktif</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$normalSeminarAttr." title='aktifkan menu registrasi normal' class='icon-pushpin'> auto</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$noTimeAttr." title='aktifkan menu registrasi normal' class='icon-pushpin'> no time</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$paksaTA1Attr." title='aktifkan menu registrasi paksa baru' class='icon-backward'> baru</i></span>".
									"<span style=' margin-left : 7px; margin-right : 7px;'><i ".$paksaTA2Attr." title='aktifkan menu registrasi paksa melanjutkan' class='icon-forward'> lama</i></span>".
								"</td>".
								"</tr>";
							}
						}
					
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
			$string.="<tr>".
			"<td>-</td>".
			"<td>-</td>".
			"<td>-</td>".
			"<td>-</td>".
			"</tr>";	
		}
		$result['string'] = $string;
		echo "1".json_encode($result);
	}
}