<?php
/*
dependencies:
-LoginFilter
-Koordinator
-GateControlModel
-ControlFile
*/
if(!defined('BASEPATH')) exit('you dont have permition');
	require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Controlfileupload extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->library("Aktor/Koordinator");
		$this->loadMod("GateControlModel");
		$this->gateControlModel = new GateControlModel();
		$this->loadLib('LoginFilter');
		$this->load->library('Session');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->loginFilter = new LoginFilter($this->session,$this->gateControlModel);
		if(!$this->loginFilter->isLogin($this->koordinator)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	public function addNewRecord(){
		$title = htmlspecialchars($this->input->post('file-data-keterangan-name'));
		$id1 = date("Y-m-d");
		$id2 = date("H:i:s");
		$id=$id1." ".$id2;
		$data = str_ireplace("-",":",$id1."".$id2);
		//exit("0".$data);
		$this->load->library('upload',array(
			'upload_path' => "./upload/file/",
			"allowed_types" => "doc|DOC|pdf|PDF|xls|XLS|docx|DOCX|xlsx|XLSX",
			"max_size" => 10240,
			"overwrite" => true,
			"file_name" => md5($id1).md5($id2)
		));
		//$this->upload->initialize($conPic);
		if(!$this->upload->do_upload('file-data-name')){
			exit('0Gagal, format yang didukung .pdf .doc .docx .xls .xlsx , maksimal dengan ukuran file 10MB');		
		}
		$filename = $this->upload->data('file_name');
		$this->loadLib('ControlFile');
		if((new ControlFile($this->gateControlModel))->addFile(array("detail"=>$title,"namadata"=>$filename))) exit("1File berhasil ditambahkan");
		exit("0File gagal di unggah");
	}
	public function updateRecord(){
		if($this->isNullPost('kode') != 'JASERVCONTROL') exit("0anda melakukan debuging");
		$title = htmlspecialchars($this->input->post('content'));
		$id = $this->isNullPost('ID');
		$id = str_ireplace(sha1(" ")," ",$id);
		$id = str_ireplace(sha1("-"),"-",$id);
		$id = str_ireplace(sha1(":"),":",$id);
		$this->loadLib('ControlFile');
		if((new ControlFile($this->gateControlModel))->updateFile(array("detail"=>$title,"identified"=>$id))) exit("1Informasi file berhasil dirubah");
		exit("0Detail file gagal di rubah");
		
	}
	public function getListRecord(){
		if($this->isNullPost('kode') != 'JASERVCONTROL') exit("0anda melakukan debuging");
		$this->loadLib('ControlFile');
		$tempObjectDB = (new ControlFile($this->gateControlModel))->getAllData();
		if($tempObjectDB->getCountData() > 0){
			$i=1;
			echo "1";
			while($tempObjectDB->getNextCursor()){
				$id = str_ireplace(" ",sha1(" "),$tempObjectDB->getIdentified());
				$id = str_ireplace("-",sha1("-"),$id);
				$id = str_ireplace(":",sha1(":"),$id);
				
				echo "<tr><td><a target='_BLANK' href='".base_url()."/upload/file/".$tempObjectDB->getNamaData()."'><span class='icon-file-alt'></span>File ".$i."</a></td><td>".$tempObjectDB->getDetail()."</td><td><span class='icon-pencil pointer' style='color : green' onclick='editFileKeterangan(".'"'.$id.'"'.",this);' title='Ubah keterangan file'></span>        <span class='icon-remove pointer' style='color : green' onclick='hapusFile(".'"'.$id.'"'.",this);' title='Hilangkan file'></span></td></tr>";
				$i++;
			}
		}else{
			echo "1<tr><td>-</td><td>-</td><td>-</td></tr>";
		}
	}
	public function removeRecord(){
		if($this->isNullPost('kode') != 'JASERVCONTROL') exit("0anda melakukan debuging");
		$id = $this->isNullPost('ID');
		$id = str_ireplace(sha1(" ")," ",$id);
		$id = str_ireplace(sha1("-"),"-",$id);
		$id = str_ireplace(sha1(":"),":",$id);
		$this->loadLib('ControlFile');
		if((new ControlFile($this->gateControlModel))->deleteFile($id)) exit("1File berhasil dihapus");
		exit("0File gagal di hapus");
	}
}