<?php
/*
dependencies:
-LoginFilter
-Koordinator
-Inputjaservfilter
-Dosen
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlTime
*/
	if(!defined("BASEPATH")) exit("You dont have permission");
	require_once(APPPATH.'controllers/CI_Controller_Modified.php');
	class Controldosens extends CI_Controller_Modified {
		public function __CONSTRUCT(){
			parent::__CONSTRUCT();
			$this->load->library("Aktor/Koordinator");
			$this->load->library("Inputjaservfilter");
			$this->loadMod("GateControlModel");
			$this->gateControlModel = new GateControlModel();
			$this->loadLib('LoginFilter');
			$this->load->library('Session');
			$this->load->helper('url');
			$this->loadLib('ControlTime');
			$this->load->helper('html');
			$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
			if(!$this->loginFilter->isLogin($this->koordinator)){
				redirect(base_url()."Gateinout.jsp");
			}
		}
		public function getLayoutDosen(){
			echo"1";
			$this->load->view("Bodyright/Controlroom/Dosen.php");
		}
		public function setNewStatusDosen(){
			$kode = $this->isNullPost('kode');
			if($kode!="JASERVCONTROL")
				exit("0maaf, anda melakukan debugging");
			$nip = $this->isNullPost('nip');
			$stat = $this->isNullPost('status');
			if(intval($stat) != 2){
				if(intval($stat) != 1){
					exit("0maaf, anda melakukan debugging");
				}
			}
			
			$this->load->library('datejaservfilter');
			$this->loadLib('Aktor/Dosen');
			$dosen = new Dosen($this->inputjaservfilter);
			$temp = $dosen->getCheckNip($nip,1);
			if(!$temp[0]){
				echo "0".$temp[1];
				return;
			}
			$this->loadLib('ControlDosen');
			$this->loadLib('ControlTime');
			$tahunak = (new ControlTime($this->gateControlModel))->getYearNow();
			$errorChangeStatus = 0;
			
			$controlDosen = new ControlDosen($this->gateControlModel);
			if($stat == 2){
				if($controlDosen->tryToDeactivated($nip,$tahunak)) exit("1Berhasil menonaktifkan dosen");
			}else{
				if($controlDosen-> ActivateDosen($nip)) exit("1Berhasil mengaktifkan dosen");
			}
			exit('0Gagal melakukan proses, check dosen apa kah sedang menjabat atau memiliki kegiatan lain');
		}
		//valid
		public function getJsonListMahasiswa(){
			$nip = $this->isNullPost('nip');
			$this->loadLib('Aktor/Dosen');
			$dosen = new Dosen($this->inputjaservfilter);
			if(!$dosen->getCheckNip($nip,1))
				exit("0Anda melakukan debuging");
			$this->loadLib('ControlDosen');
			$this->loadLib('ControlTime');
			$this->loadLib('ControlRegistrasi');
			$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip,null);
			if(!$tempObjectDB->getNextCursor()) exit("0maaf nip tidak terdaftar sebagai dosen");
			$srt = (new ControlTime($this->gateControlModel))->getYearNow();
			$tempObjectDBD = (new ControlRegistrasi($this->gateControlModel))->getAllDataByDosen($srt,$tempObjectDB->getIdentified());
			$temp2="";
			$temp=0;
			
			if($tempObjectDBD->getCountData() > 0){
				$temp+=$tempObjectDBD->getCountData();
				$this->loadLib('ControlMahasiswa');
				$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
				while($tempObjectDBD->getNextCursor()){
					$tempObjectDBT = $controlMahasiswa->getAllData($tempObjectDBD->getMahasiswa());
					$tempObjectDBT->getNextCursor();
					$temp2.='["'.$tempObjectDBT->getNama().'",'.$tempObjectDBT->getNim().',"upload/foto/'.$tempObjectDBT->getNamaFoto().'"],';
				}
			}
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
			$json = '{"data": ['.$temp;
			$json .= ",[";
			$json .= $temp2;
			$json .= "]]}";
			echo "1".$json;
		}
		//true on new
		public function getTableDosen(){
			$_POST['kode'] ="JASERVCONTROL";
			/* $_POST[''] */
			$kode = $this->isNullPost('kode');
			if($kode!="JASERVCONTROL")
				exit("0maaf, anda melakukan debugging");
			if($this->input->post('page') === NULL)
				$page = 1;
			else{		
				$page = intval($this->isNullPost('page'));
				if($page < 1)
					$page = 1;	
			}
			$key = null;
			if($this->input->post('key') === NULL)
				$key = "*";
			else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
				$key = "*";
			}else{
				if(!$this->inputjaservfilter->nameLevelFiltering($this->isNullPost('key'))[0]){
					echo "0Kata kunci harus berupa bagian nama dari seseorang";
					return;
				}else
					$key = $this->isNullPost('key');
			}	
			$this->loadLib('ControlDosen');
			$this->loadLib('ControlRegistrasi');
	
			$tempObjectDB = (new ControlDosen($this->gateControlModel))->getAllData();
			$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
			$srt = (new ControlTime($this->gateControlModel))->getYearNow();
	
			$rest="";
			$i=1;
			$n = 1;
			$z = 1;
			$koko = 0;
			
		
			while($tempObjectDB->getNextCursor()){
				if($key == "*" || !is_bool(strpos(strtolower($tempObjectDB->getNama()),strtolower($key)))){
					if($n <= 15 && $z == $page){
						$rest.="<tr>";
						$rest.="<td>".$i."</td>";
						$rest.="<td>".$tempObjectDB->getNip()."</td>";
						$rest.="<td>".$tempObjectDB->getNama()."</td>";
						$rest.="<td>".$tempObjectDB->getBidangRiset()."</td>";
						$rest.="<td>";
						$tempObjectDBD = $controlRegistrasi->getAllDataByDosen($srt,$tempObjectDB->getIdentified());
						$rest.="<input type='button' value='lihat (".$tempObjectDBD->getCountData().")' class='btn btn-info' onclick='showListMahasiswaAmpuan(".'"'.$tempObjectDB->getNip().'"'.")'>";
						$rest.="</td>";
						$rest.="<td><select onchange='statusDosen(".'"'.$tempObjectDB->getNip().'"'.",this.value);'>";
						if(intval($tempObjectDB->getStatus()) == 1){
							$rest.= "<option value='2'>Tidak Aktif</option>".
									"<option  value='1' selected>Aktif</option>";
						}else{
							$rest.= "<option value='2' selected>Tidak Aktif</option>".
									"<option value='1'>Aktif</option>";
						}
						$rest.="</tr>";
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
			if($i == 1)
				$rest.="<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
			$result['string'] = $rest;
			echo "1".json_encode($result);
		}
		//vlaid
		public function addNewDosen(){
			$nama = $this->isNullPost('nama'); 
			$nip = $this->isNullPost('nip'); 
			$kode = $this->isNullPost('kode'); 
			if($kode != 'JASERVTECH-CODE-CREATE-NEW-DOSEN')
				exit('0Maaf, anda melakukan debugging');
			$this->loadLib('Aktor/Dosen');
			$dosen = new Dosen(new Inputjaservfilter());
			$temp = $dosen->getCheckName($nama,1);
			if(!$temp[0])
				exit("0".$temp[1]);
			$temp = $dosen->getCheckNip($nip,1);
			if(!$temp[0])
				exit("0".$temp[1]);
			$this->loadLib('ControlDosen');
			if((new ControlDosen($this->gateControlModel))->getDataByNip($nip,null)->getNextCursor())
				exit("0Nip ditemukan, ganti nip yang lain");

			if((new ControlDosen($this->gateControlModel))->addNewData(array(
				"nickname"=>$nip,
				"keyword"=>"dosenif56NEW",
				"nip"=>$nip,
				"nama"=>$nama
			)))
				exit('1Berhasil Menambahkan dosen');
			else
				exit("0Gagal menambahkan Dosen");
		}
		//valid
		public function getCheck($value=null,$kode=null,$cat=null){
			
			if($value == null){
				$value = $this->isNullPost('value'); 
			}
			if($kode == null){
				$kode = $this->isNullPost('kode');
			}
			if($cat == null){
				$cat = $this->isNullPost('cat');
			}
			$this->loadLib('Aktor/Dosen');
			$dosen = new Dosen($this->inputjaservfilter);
			switch ($kode){
				case 'NAMA' :
					return $dosen->getCheckName($value,$cat);
					break;
				case 'NIP' :
					$temp = $dosen->getCheckNip($value,1);
					if(!$temp[0])
						exit("0".$temp[1]);
					$this->loadLib('ControlDosen');
					if((new ControlDosen($this->gateControlModel))->getDataByNip($value,null)->getNextCursor())
						exit("0Nip ditemukan, ganti nip yang lain");
					else
						exit("1Nip Diterima");
					break;
				default : 
					exit("0Kesalahan");
					break;
			}
		}
	}
	
	