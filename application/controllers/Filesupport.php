<?php
if(!defined('BASEPATH')){
	redirect("/Gateinout");
}
/*
-Mahasiswa
-Dosen
-Koordinator
-Admin
-LoginFilter(-)
-GateControlModel(-)
-Inputjaservfilter(-)
-ControlMahasiswa
-ControlRegistrasi
-ControlTime
*/
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Filesupport extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper("Download");
		$this->load->helper("Url");
	}
	
	
	//fix2
	public function getPhotoDosenProfil($namafile = null){
		if(!$this->loginFilter->isLogin($this->dosen))
			redirect(base_url().'Gateinout.aspx');
		if($namafile == null){
			echo "0Maaf file tidak ditemukan";
			exit();
		}
		$patch4 = "upload/foto/dosen/default-dosen.png";
		$patch3 = "upload\\foto\\dosen\\default-dosen.png";
		$patch2 = "upload/foto/dosen/".$namafile."-dosen.png";
		$patch = "upload\\foto\\dosen\\".$namafile."-dosen.png";
		$path = str_ireplace("system\\","",BASEPATH).$patch;
		$path2 = str_ireplace("system/","",BASEPATH).$patch2;
		$path3 = str_ireplace("system\\","",BASEPATH).$patch3;
		$path4 = str_ireplace("system/","",BASEPATH).$patch4;
		if (file_exists($path)) {
			$this->sendDataFormat("application/png", "filePreview.png", $path);
		}else if (file_exists($path2)) {
			$this->sendDataFormat("application/png", "filePreview.png", $path2);
		}else if (file_exists($path3)) {
			$this->sendDataFormat("application/png", "filePreview.png", $path3);
		}else if (file_exists($path4)) {
			$this->sendDataFormat("application/png", "filePreview.png", $path4);
		}else{
			echo "Maaf file tidak ditemukan";
		}
	}
	public final function getLayoutPDF($url){
		$data['url'] = base_url().str_ireplace(":","/",$url);
		
		$this->load->view("Pdf/Viewer",$data);
	}
	
	public final function getPreviewPDFSeminarTA2($namafile = null){
		if(!$this->loginFilter->isLogin($this->koordinator))
			redirect(base_url().'Gateinout.aspx');
		if($namafile == null){
			echo "0Maaf file tidak ditemukan";
			exit();
		}
		$patch = "upload\\seminarta\\seminarta2\\pdf\\".$namafile.".pdf";
		$patch2 = "upload/seminarta/seminarta2/pdf/".$namafile.".pdf";
		$path = str_ireplace("system\\","",BASEPATH).$patch;
		$path2 = str_ireplace("system/","",BASEPATH).$patch2;
		
		//$path .= $patch;
		//exit($path);
		if (file_exists($path)) {
			$this->sendDataFormat("application/pdf","filePreview.pdf",$path);
		}else if (file_exists($path2)) {
			$this->sendDataFormat("application/pdf","filePreview.pdf",$path2);
		}else{
			echo "Maaf file tidak ditemukan";
		}
	}
	//fix
	public final function getPreviewPictureSeminarTA2($namafile = null){
		if(!$this->koordinator->getStatusLoginKoordinator())
			redirect(base_url().'Gateinout.aspx');
		if($namafile == null){
			echo "0Maaf file tidak ditemukan";
			exit();
		}
		$pth    =   file_get_contents(base_url()."upload/seminarta/seminarta2/png/".$namafile.".png");
		$nme    =   "picture.png";
		force_download($nme, $pth);
	}
	//fix
	public final function getPreviewPictureSeminarTA1($namafile = null){
		if(!$this->loginFilter->isLogin($this->koordinator))
			redirect(base_url().'Gateinout.jsp');
		if($namafile == null){
			echo "0Maaf file tidak ditemukan";
			exit();
		}
		$pth = file_get_contents(base_url()."upload/seminarta/seminarta1/png/".$namafile.".png");
		$nme  =   "picture.png";
		force_download($nme, $pth);
	}
	//fix2
	public final function getPreviewPDFSeminarTA1($namafile = null){
		if(!$this->loginFilter->isLogin($this->koordinator))
			redirect(base_url().'Gateinout.jsp');
		if($namafile == null){
			echo "0Maaf file tidak ditemukan";
			exit();
		}
		$patch = "upload\\seminarta\\seminarta1\\pdf\\".$namafile.".pdf";
		$patch2 = "upload/seminarta/seminarta1/pdf/".$namafile.".pdf";
		$path = str_ireplace("system\\","",BASEPATH).$patch;
		$path2 = str_ireplace("system/","",BASEPATH).$patch2;
		//echo "".$path;
		//return;
		if (file_exists($path)) {
			$this->sendDataFormat("application/pdf","preview.pdf",$path);
		}else if (file_exists($path2)) {
			$this->sendDataFormat("application/pdf","preview.pdf",$path2);
		}else{
			echo "Maaf file tidak ditemukan";
		}
	}
	//fix2
	public function getFotoUserDefault(){
		$patch = "resources\img\user.jpg";
		$patch2 = "resources/img/user.jpg";
		$path = str_ireplace("system\\","",BASEPATH).$patch;
		$path2 = str_ireplace("system/","",BASEPATH).$patch2;
		
		if (file_exists($path)) {
			$this->sendDataFormat("image/png","preview.png",$path);
		}else if (file_exists($path2)) {
			$this->sendDataFormat("image/png","preview.png",$path2);
		}else{
			echo "Maaf file tidak ditemukan";
		}
	}
	//wait for fix
	public function getKRS($nim=null){
		if($this->loginFilter->isLogin($this->koordinator) || $this->loginFilter->isLogin($this->dosen)){
			if($nim == null)
				exit("Maaf file tidak ditemukan");
			$this->mahasiswa->initial($this->inputJaservFilter);
			if(!$this->mahasiswa->getCheckNim($nim,1)[0])
				exit("Maaf file tidak ditemukan");
			$this->loadLib('ControlMahasiswa');
			$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getDataByNim($nim);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
				exit("Maaf file tidak ditemukan");
			//exit('koko1');
			if(intval($tempObjectDB->getStatus()) == 2)
				exit("Maaf file tidak ditemukan");
			$identified = $tempObjectDB->getIdentified();
			//exit();
		}else if($this->loginFilter->isLogin($this->mahasiswa)){
			$identified = $this->loginFilter->getIdentifiedActive();
		}else{
			exit("Maaf file tidak ditemukan");
		}
		$this->loadLib('ControlRegistrasi');
		$this->loadLib('ControlTime');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$tempObjectDBD = (new ControlRegistrasi($this->gateControlModel))->getAllData($tahunAk,$identified,1,null);
		if(!$tempObjectDBD) exit("Maaf file tidak ditemukan");
		if(!$tempObjectDBD->getNextCursor()) exit("Maaf file tidak ditemukan");
		
		$patch = "upload/krs/".$tempObjectDBD->getNamaKRS();
		$patch2 = "upload\\krs\\".$tempObjectDBD->getNamaKRS();
		$path = str_ireplace("system/","",BASEPATH).$patch;
		$path2 = str_ireplace("system\\","",BASEPATH).$patch2;
		if (file_exists($path)) {
			$this->sendDataFormat("application/pdf","filePreview.pdf",$path);
		}else if (file_exists($path2)) {
			$this->sendDataFormat("application/pdf","filePreview.pdf",$path2);
		}else{
			exit("Maaf file tidak ditemukan");
		}
	}
	protected function sendDataFormat($type,$name,$path){
		header('Content-type: '.$type);
		header('Content-Disposition: inline; filename="'.$name.'"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		readfile($path);
		return true;
	}
	//Mahasiswa
	public function getTranskrip($nim=null){
		if($this->loginFilter->isLogin($this->koordinator) || $this->loginFilter->isLogin($this->dosen)){
			if($nim == null)
				redirect(base_url().'Gateinout.jsp');
			$this->mahasiswa->initial($this->inputJaservFilter);
			if(!$this->mahasiswa->getCheckNim($nim,1)[0])
				redirect(base_url().'Gateinout.jsp');
			
			$this->loadLib('ControlMahasiswa');
			$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getDataByNim($nim);
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
				redirect(base_url().'Gateinout.jsp');
			//exit('koko1');
			if(intval($tempObjectDB->getStatus()) == 2)
				redirect(base_url().'Gateinout.jsp');
		}else if($this->loginFilter->isLogin($this->mahasiswa)){
			$this->loadLib('ControlMahasiswa');
			$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getAllData($this->loginFilter->getIdentifiedActive());
			if(!$tempObjectDB || !$tempObjectDB->getNextCursor())
				redirect(base_url().'Gateinout.jsp');
			$nim = $tempObjectDB->getNim();
		}else{
			redirect(base_url().'Gateinout.jsp');
		}
		$patch2 = "upload/transkrip/".$nim."-transkrip.pdf";
		$patch = "upload\\transkrip\\".$nim."-transkrip.pdf";
		$path = str_ireplace("system\\","",BASEPATH).$patch;
		$path2 = str_ireplace("system/","",BASEPATH).$patch2;
		if (file_exists($path)) {
			$this->sendDataFormat("application/pdf","preview.pdf",$path);
		}else if (file_exists($path2)) {
			$this->sendDataFormat("application/pdf","preview.pdf",$path2);
		}else{
			echo "Maaf file tidak ditemukan";
		}
	}
	//fix
	public final function getPhotoMahasiswaProfil($nim){
		$nim = str_ireplace(".aspx","",$nim);
		$nim = str_ireplace(".jsp","",$nim);
		if(!$this->loginFilter->isLogin($this->mahasiswa)){
			if(!$this->loginFilter->isLogin($this->koordinator)){
				if(!$this->loginFilter->isLogin($this->dosen)){
					redirect(base_url().'Gateinout.jsp');
				}
			}
		}
		$this->mahasiswa->initial($this->inputJaservFilter);
		if(!$this->mahasiswa->getCheckNim($nim,1)[0]) redirect(base_url().'Gateinout.jsp');
		$this->loadLib('ControlMahasiswa');
		$tempObjectDB = (new ControlMahasiswa($this->gateControlModel))->getDataByNim($nim);
		
		if(!$tempObjectDB->getNextCursor())
			redirect(base_url().'Gateinout.jsp');
		$r = explode(".",$tempObjectDB->getNamaFoto());
		$r = $r[count($r)-1];
		$patch2 = "upload/foto/".$tempObjectDB->getNamaFoto();
		$patch = "upload\\foto\\".$tempObjectDB->getNamaFoto();
		$patch4 = "upload/foto/user.png";
		$patch3 = "upload\\foto\user.png";
		$path = str_ireplace("system\\","",BASEPATH).$patch;
		$path2 = str_ireplace("system/","",BASEPATH).$patch2;
		$path3 = str_ireplace("system\\","",BASEPATH).$patch3;
		$path4 = str_ireplace("system/","",BASEPATH).$patch4;
		if (file_exists($path)) {
			return $this->sendDataFormat('image/png','filePreview.'.$r,$path);
		}else if (file_exists($path2)) {
			return $this->sendDataFormat('image/png','filePreview.'.$r,$path2);
		}else if (file_exists($path3)) {
			return $this->sendDataFormat('image/png','filePreview.png',$path3);
		}else if (file_exists($path4)) {
			return $this->sendDataFormat('image/png','filePreview.png',$path4);
		}else{
			exit("Maaf file tidak ditemukan");
		}
	}
	
	//-->
}