<?php
/*
dependencies:
-Koordinator
-ControlDosen
-ControlKoordinator
*/
if(!defined('BASEPATH')) exit("you don't have permission to access");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Controlpengaturan extends CI_Controller_Modified {
	function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->koordinator)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	
	public function changeNipKoor(){
		$nip = $this->isNullPost('nip');
		$this->koordinator->initial($this->inputJaservFilter);
		if(!$this->koordinator->getCheckNip($nip,1)[0]){
			exit('0format nip tidak sesuai');
		}
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlAdmin');
		$this->loadLib('ControlKoordinator');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByNip($nip);
		$tempObjectDBD = (new ControlAdmin($this->gateControlModel))->getDataByStatus();
		if($tempObjectDB->getCountData() <= 0) exit('0nip ini tidak terdaftar sebagai dosen aktif');
		$tempObjectDB->getNextCursor();
		$tempObjectDBD->getNextCursor();
		if($tempObjectDB->getIdentified() == $tempObjectDBD->getKajur())exit('0nip ini menjabat sebagai Ketua departemen');
		if($tempObjectDB->getIdentified() == $tempObjectDBD->getWakil())exit('0nip ini menjabat sebagai Wakil departemen');
		if((new ControlKoordinator($this->gateControlModel))->setNewKoordinator($tempObjectDB->getIdentified())){
			echo "1Berhasil merubah Koordinator";
		}else{
			echo "0Gagal melakukan perubahan";
		}
	}
	public function changePasswordKoor(){
		$oldPass = $this->isNullPost('oldpass');
		$this->koordinator->initial($this->inputJaservFilter);
		if($oldPass == "")
			exit("0password lama tidak boleh kosong");
		if(!$this->koordinator->getCheckPassword($oldPass,1)[0])
			exit("0password lama memiliki format yang salah");
		$newPass = $this->isNullPost('newpass');
		if($newPass == "")
			exit("0password baru tidak boleh kosong");
		if(!$this->koordinator->getCheckPassword($newPass,1)[0])
			exit("0password baru memiliki format yang salah");
		$conPass = $this->isNullPost('conpass');
		if($conPass == "")
			exit("0password konfirmasi tidak boleh kosong");
		if(!$this->koordinator->getCheckPassword($conPass,1)[0])
			exit("0password konfirmasi memiliki format yang salah");
		if($conPass != $newPass)
			exit("0password baru harus sama dengan konfirmasi"); 
		if($conPass == $oldPass)
			exit("0password baru berbeda dengan password lama"); 
		if(!$this->loginFilter->isPasswordOfThisGuy($oldPass)) exit("0password lama tidak terdaftar");
		if($this->loginFilter->setNewPassword($newPass)){
			echo "1Berhasil melakukan perubahan";
		}else{
			echo "0Gagal melakukan perubahan";
		}
	}
	public function setNewGanjilGenapConstrain(){
		$ganjilMonth = intval($this->isNullPost('ganjilMonth'));
		$genapMonth = intval($this->isNullPost('genapMonth'));
		$ganjilDay = intval($this->isNullPost('ganjilDay'));
		$genapDay = intval($this->isNullPost('genapDay'));
		if(!$this->isInDayOnMonth($ganjilMonth,$ganjilDay,false)){
			exit("0tanggal Ganjil tidak di izinkan");
		}
		if(!$this->isInDayOnMonth($genapMonth,$genapDay,false)){
			exit("0tanggal Genap tidak di izinkan");
		}
		$this->loadLib('ControlKoordinator');
		if((new ControlKoordinator($this->gateControlModel))->setNewGanjilGenapConstrain($this->loginFilter->getIdentifiedActive(),$ganjilMonth,$ganjilDay,$genapMonth,$genapDay)){
			echo "1Berhasil";
		}else{
			echo "0Gagal melakukan perubahan";
		}
	}
	protected function isInDayOnMonth($month,$day,$febUpToDate){
		$dataDayPengaturanGanjilGenap = array(
			31,29,31,30,31,30,31,31,30,31,30,31
		);
		$month = intval($month);
		$day = intval($day);
		if($month > 12 || $month < 1)
			return false;
		if($month == 2){
			$year = intval(DATE("Y"));
			$febtrue = false;
			if($year%4 == 0)
				$febtrue = true;
			if($febtrue)
				if($febUpToDate){				
					if($day > 29 || $day < 1)
						return false;
				}
				else{
					if($day > 28 || $day < 1)
						return false;
				}
			else{
				if($day > 28 || $day < 1)
					return false;
			}
		}else{
			if($day > $dataDayPengaturanGanjilGenap[$month] || $day < 1)
				return false;
		}
		return true;
	}
	public function getSelectListDosen(){
		$select = '<select id="support-who-you-are" style=width:100% tabindex=-1 onchange="reloadDataKoordinator(this)">'.
				'<option value=0></option>'.
				'</select>';
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlKoordinator');
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByStatus(1);
		$tempObjectDBD = (new ControlKoordinator($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
		$tempObjectDBD->getNextCursor();
		
		if($tempObjectDB->getCountData()>0){
			$select = '<select id="support-who-you-are" style=width:100% tabindex=-1 onchange="reloadDataKoordinator(this)">';
			while($tempObjectDB->getNextCursor()){
				if($tempObjectDB->getIdentified() == $tempObjectDBD->getDosenK())
					$select .='<option selected value="'.$tempObjectDB->getNip().'">'.$tempObjectDB->getNama().'</option>';
				else
					$select .='<option value="'.$tempObjectDB->getNip().'">'.$tempObjectDB->getNama().'</option>';
			}
			$select.="</select>";	
		}
		echo "1".$select."`".$tempObjectDBD->getStartGanjil()."`".$tempObjectDBD->getStartGenap();
		return;
	}
	
}