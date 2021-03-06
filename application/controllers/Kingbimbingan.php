<?php
if(!defined('BASEPATH')) exit("You dont have permission");
require_once APPPATH.'controllers/CI_Controller_Modified.php';
/*
dependencies:
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
class Kingbimbingan extends CI_Controller_Modified{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->dosen))
			redirect(base_url().'Gateinout.jsp');
		$this->mahasiswa->initial($this->inputJaservFilter);
		$this->loadLib('ControlTime');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlSeminar');
		$this->loadLib('ControlSidang');
		$this->loadLib('ControlDosen');
		$this->controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$this->controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$this->controlSeminar = new ControlSeminar($this->gateControlModel);
		$this->controlSidang = new ControlSidang($this->gateControlModel);
		$this->controlDosen = new ControlDosen($this->gateControlModel);
		$this->tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
	}
	//fix
	public function getLayoutBimbingan(){
		echo '1';
		$this->load->view("Bodyright/Kingroom/Bimbingan.php");
	}
	//fixx
	//optimized
	public function getListNotifikasiCup(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->mahasiswa->getCheckName($keyword,1)[0]){
				$keyword = "";
			}
		}else{
			$keyword = "";
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNama($keyword,1,$this->loginFilter->getIdentifiedActive());
		$tempObjectDBD = $this->controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		$string = "";
		$kode = 1;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				if(strlen($tempObjectDB->getDosenRespon()) != 40){
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDB->getNim()."</td>
						<td style='text-align : center;'>".$tempObjectDB->getNama()."</td>
						<td style='text-align : center;'><span style='font-size : 14pt; color : grey; margin-right : 10px;font-weight : bolder;' class='icon-star-empty'></span><span onclick='cupThisGuys(".'"'.$tempObjectDB->getNim().'"'.")' style='font-size : 14pt ; color : green;' class='icon-arrow-right'></span></td>
					</tr>
					";
					
				}else if($tempObjectDB->getDosenRespon() != $this->loginFilter->getIdentifiedActive()){
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDB->getNim()."</td>
						<td style='text-align : center;'>".$tempObjectDB->getNama()."</td>
						<td style='text-align : center;'><span style='font-size : 14pt;margin-right : 10px; color : grey;font-weight : bolder;' class='icon-star-empty'></span><span style='color : red;font-size : 14pt ;' class='icon-arrow-right'></span></td>
					</tr>
					";
					
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	//optimized
	public function getListProsesCup(){
		$keyword = "*";
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->mahasiswa->getCheckName($keyword,1)[0]){
				$keyword = "";
			}
		}else{
			$keyword = "";
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNama($keyword,1,$this->loginFilter->getIdentifiedActive());
		$string = "";
		$kode = 1;
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				if($tempObjectDB->getDosenRespon() == $this->loginFilter->getIdentifiedActive()){
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDB->getNim()."</td>
						<td style='text-align : center;'>".$tempObjectDB->getNama()."</td>
						<td style='text-align : center;'><span style='font-size : 14pt;margin-right : 10px; color : orange; font-weight : bolder;' class='icon-star-empty'></span><span onclick='unCupThisGuys(".'"'.$tempObjectDB->getNim().'"'.")'  style='color : green; font-size : 14pt ;' class='icon-remove'></span></td>
					</tr>
					";
					
				}
			}
		}
		if($string == ""){
			$string .=
			"<tr>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
				<td style='text-align : center;'>-</td>
			</tr>
			";
		}
		echo $kode."".$string;
	}
	//fix
	public function getTableInfoPublicRegistrasi(){
		$keyword = "*";
		
		if($this->input->post("keyword")!==NULL){
			$keyword = $this->input->post("keyword");
			if(!$this->mahasiswa->getCheckName($keyword,1)[0]){
				$keyword = "*";
			}
		}
		$kode = 1;
		$string = "";
		
		$bool = false;
		$tempObjectDBs = $this->controlRegistrasi->getAllDataByDosen($this->tahunAk,$this->loginFilter->getIdentifiedActive(),1,true);
		if($tempObjectDBs){
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDBD = $tempObjectDBs->getTableStack(2);
				$tempObjectDB = $tempObjectDBs->getTableStack(1);
				if($keyword == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($keyword)))){
					$error = 0;
					$tempObjectDBT = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$tempObjectDBD->getIdentified());
					if($tempObjectDBT->getNextCursor()){
						$error += 1;
						$TA1 = "style='font-size : 17px; color : red;' disabled";
					}else{
						$TA1 = "style='font-size : 17px; color : green; cursor : pointer;' onclick='recomTA1ThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")'";	
					}
					$tempObjectDBT = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$tempObjectDBD->getIdentified());
					if($tempObjectDBT->getNextCursor()){
						$error += 1;
						$TA2 = "style='font-size : 17px; color : red;' disabled";
					}else{
						$TA2 = "style='font-size : 17px; color : green; cursor : pointer;' onclick='recomTA2ThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")'";	
					}
					if($error > 0){
						$tolak = "style='font-size : 17px; color : red;' disabled";
					}else{
						$tolak = "style='font-size : 17px; color : green; cursor : pointer;' onclick='bannishThisGuys(".'"'.$tempObjectDBD->getNim().'"'.")'";
					}
					$color = "blue";
					$message = "seeThisGuysFullOfIt(".$tempObjectDBD->getNim().',"sudah memasuki sesi seminar, dalam sistem tidak dapat melakukan penolakan"'.")";
					$tempObjectDBT = $this->controlDetail->getDetail('kategori',$tempObjectDB->getKategori());
					$tempObjectDBT->getNextCursor();
					$string .=
					"<tr>
						<td style='text-align : center;'>".$tempObjectDBD->getNim()."</td>
						<td style='text-align : center;'>".$tempObjectDBD->getNama()."</td>
						<td style='text-align : center;'>".$tempObjectDB->getJudulTA()."</td>
						<td style='text-align : center;'>".$tempObjectDBT->getDetail()."</td>
						<td style='width : 100px;'>
							<span><i onclick='".$message."' class='icon-info-sign' style='font-size : 17px; color : ".$color.";'></i></span>
							<span><i title='Tolak menjadi mahasiswa bimbingan saya' ".$tolak." type='button' class='icon-remove'></i></span>
							<span><i title='Rekomendasikan seminar TA 1' ".$TA1." type='button' class='icon-tag'></i></span>
							<span><i title='Rekomendasikan seminar TA 2' ".$TA2." type='button' class='icon-tag'></i></span>
						</td>
					</tr>
					";
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
			</tr>
			";
		}
		echo $kode."".$string;
	}
	//optimized - fix
	//menolak sebagai mahasiswa bimbingannya
	public function bannishThisGuysFromMe(){
		$nim = $this->isNullPost("Nim");
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit("0nim tidak sesuai, anda melakukan debugging");
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		if(!$tempDosbing || !$tempDosbing->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		if($tempDosbing->getDosen() != $this->loginFilter->getIdentifiedActive()) exit("0anda melakukan debugging terhadap system");
		$tempObjectDBS = $this->controlDosen->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDBS->getNextCursor();
		if($this->controlRegistrasi->setDospemForTA($tempObjectDB->getIdentified(),"0",$this->tahunAk,$tempObjectDBS->getNama())[0]) 
			exit('1berhasil merubah data');
		else exit("0gagal melakukan perubahan data");
	}
	//fix
	public function recomendationTA(){
		$TA = $this->isNullPost('TA');
		$nim = $this->isNullPost('Nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit("nim tidak valid");
		}
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		if(!$tempDosbing || !$tempDosbing->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		if($tempDosbing->getDosen() != $this->loginFilter->getIdentifiedActive()) exit("0anda melakukan debugging terhadap system");
		
		if(intval($tempObjectDBD->getDataProses()) != 2){
			exit("0mahasiswa ini belum disetujui oleh koordinator ta");
		}
		$TA = intval($TA);
		if($TA<1 || $TA>2)
			exit("0Kode TA anda tidak valid");
		$error = 0;
		if($TA == 1){
			$tempObjectDBT = $this->controlSeminar->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getIdentified());
			if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				exit('0mahasiswa ini sudah mendaftar seminar TA 1');
			}
			$tempObjectDBT->setTahunAk($this->tahunAk);
			$tempObjectDBT->setMahasiswa($tempObjectDB->getIdentified());
			$tempObjectDBT->setStatus(1);
			$tempObjectDBT->setRekomendasi(1);
			$tempObjectDBT->setWaktu("1000-01-01 00:00:00");
			$tempResult = $this->controlSeminar->addNew($tempObjectDBT);
		}else{
			$tempObjectDBT = $this->controlSidang->getDataByMahasiswa($this->tahunAk,$tempObjectDB->getIdentified());
			if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
				exit('0mahasiswa ini sudah mendaftar seminar TA 1');
			}
			$tempObjectDBT->setTahunAk($this->tahunAk);
			$tempObjectDBT->setMahasiswa($tempObjectDB->getIdentified());
			$tempObjectDBT->setStatus(1);
			$tempObjectDBT->setRekomendasi(1);
			$tempObjectDBT->setWaktu("1000-01-01 00:00:00");
			$tempResult = $this->controlSidang->addNew($tempObjectDBT);
		}
		if($tempResult) exit("1Berhasil merujuk dosen rekomendasi mahasiswa ini");
		else exit("0Gagal melakukan perubahan");
	}
	//fix
	public function getInfoMahasiswaFull(){
		$temp = $this->isNullPost('kode');
		$nim = $this->isNullPost('nim');
		$mess = $this->isNullPost('message');
		if($temp != 'JASERVTECH-KODE')
			exit('0anda melakukan debugging terhadap system');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0])
			exit('0anda melakukan debugging terhadap system');
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0anda melakukan debugging terhadap system");
		}
		$tempObjectDBD = $this->controlRegistrasi->getAllData($this->tahunAk,$tempObjectDB->getIdentified(),1,null);
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		$tempDosbing = $this->controlRegistrasi->getDosenPembimbing($tempObjectDBD->getIdentified());
		if(!$tempDosbing || !$tempDosbing->getNextCursor())
			exit("0anda melakukan debugging terhadap system");
		if($tempDosbing->getDosen() != $this->loginFilter->getIdentifiedActive()) exit("0anda melakukan debugging terhadap system");
		$tempObjectDBT = $this->controlDetail->getDetail("kategori",$tempObjectDBD->getKategori());
		$tempObjectDBT->getNextCursor();
		$tempObjectDBE = $this->controlDetail->getDetail("minat",$tempObjectDB->getMinat());
		$tempObjectDBE->getNextCursor();
		$data = array(
				'nim' => $tempObjectDB->getNim(),
				'nama' => $tempObjectDB->getNama(),
				'minat' => $tempObjectDBE->getDetail(),
				'foto' => $tempObjectDB->getNamaFoto(),
				'email' => $tempObjectDB->getEmail(),
				'notelp' => $tempObjectDB->getNoHp(),
				'judulTA' => $tempObjectDBD->getJudulTA(),
				'statusTA' => $tempObjectDBT->getDetail(),
				'urltranskrip' => base_url()."Filesupport/getTranskrip/".$tempObjectDB->getNim().".jsp",
				'urlkrs' => base_url()."Filesupport/getKrs/".$tempObjectDB->getNim().".jsp",
				'message' => $mess
		);
		echo "1";
		$this->load->view('Bodyright/Kingroom/Infomahasiswaview',$data);
	}
	
	public function setThisMyCup(){
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Anda melakukan debugging');
		}
		if($this->setThisMyCupProcess($nim)) exit('1Brhasil merubah data');
		else exit('0Gagal merubah data');
	}
	public function setThisUnMyCup(){
		$nim = $this->isNullPost('nim');
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Anda melakukan debugging');
		}
		if($this->setThisUnMyCupProcess($nim)) exit('1Brhasil merubah data');
		else exit('0Gagal merubah data');
	}
	protected function setThisMyCupProcess($nim=null){
		if($nim == null) return false;
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		if(strlen($tempObjectDB->getDosenRespon()) == 40) return false;	
		$exit = true;
		if($tempObjectDB->getDosenS() == $this->loginFilter->getIdentifiedActive()) $exit = false;
		if($tempObjectDB->getDosenD() == $this->loginFilter->getIdentifiedActive()) $exit = false;
		if($tempObjectDB->getDosenT() == $this->loginFilter->getIdentifiedActive()) $exit = false;
		if($exit) return false;
		$tempObjectDB->setDosenRespon($this->loginFilter->getIdentifiedActive());
		return $this->controlMahasiswa->tryUpdate($tempObjectDB);
	}
	protected function setThisUnMyCupProcess($nim=null){
		if($nim == null) return false;
		$tempObjectDB = $this->controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()) return false;
		if($tempObjectDB->getDosenRespon() != $this->loginFilter->getIdentifiedActive()) return false;	
		$tempObjectDB->setDosenRespon("");
		return $this->controlMahasiswa->tryUpdate($tempObjectDB);
	}
	
}