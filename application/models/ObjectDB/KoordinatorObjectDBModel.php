<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class KoordinatorObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'koordinator';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedko'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedko%>='<|identifiedko|>'",
			"status='1'",
			"<%status%>='<|status|>'"
		);
		$this->tempCodeOfWhere = array(
			"identifiedko" => array(
				'kode' => "<%identifiedko%>",
				'value' => "<|identifiedko|>"
			),
			"dosenk" => array(
				'kode' => "<%dosenk%>",
				'value' => "<|dosenk|>"
			),
			"startganjil" => array(
				'kode' => "<%startganjil%>",
				'value' => "<|startganjil|>"
			),
			"startgenap" => array(
				'kode' => "<%startgenap%>",
				'value' => "<|startgenap|>"
			),
			"mulai" => array(
				'kode' => "<%mulai%>",
				'value' => "<|mulai|>"
			),
			"berakhir" => array(
				'kode' => "<%berakhir%>",
				'value' => "<|berakhir|>"
			),
			"status" => array(
				'kode' => "<%status%>",
				'value' => "<|status|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getIdentified(){ return $this->getData('identifiedko'); }
	public function getDosenK(){ return $this->getData('dosenk'); }
	public function getMulai(){ return $this->getData('berakhir'); }
	public function getBerakhir(){ return $this->getData('berakhir'); }
	public function getStatus(){ return $this->getData('status'); }
	public function getStartGanjil(){ return $this->getData('startganjil'); }
	public function getStartGenap(){ return $this->getData('startgenap'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedko',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenK($tempData,$tempAsWhere = false){
		return $this->setData('dosenk',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMulai($tempData,$tempAsWhere = false){
		return $this->setData('mulai',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setBerakhir($tempData,$tempAsWhere = false){
		return $this->setData('berakhir',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('status',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStartGanjil($tempData,$tempAsWhere = false){
		return $this->setData('startganjil',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStartGenap($tempData,$tempAsWhere = false){
		return $this->setData('startgenap',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}