<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
class ControlDetail{
	private $gateControlModel;
	public function __CONSTRUCT(GateControlModel $tempGateControlModel=null){
		$this->gateControlModel = $tempGateControlModel;
	}
	public function getDetail($kategori=null,$id=null){
		if(is_null($kategori)) return false;
		$tempObjectDB = null;
		switch($kategori){
			case 'dataproses' :
			$tempObjectDB = $this->gateControlModel->loadObjectDB('DataProses');
			break;
			case 'ruang' :
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Ruang');
			break;
			case 'minat' :
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Minat');
			break;
			case 'kategori' :
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Kategori');
			break;
			case 'status' :
			$tempObjectDB = $this->gateControlModel->loadObjectDB('Status');
			break;
		}
		if(!is_null($id)){
			$tempObjectDB->setId("".$id."",true);
			$tempObjectDB->setWhere(1);
		}
		return $this->gateControlModel->executeObjectDB($tempObjectDB)->takeData();
	}
}