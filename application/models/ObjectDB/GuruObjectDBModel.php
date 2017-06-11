<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GuruObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'guru';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedgu'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedgu%>='<|identifiedgu|>'",
			"<%nipgu%>='<|nipgu|>' AND <%statusgu%>='<|statusgu|>'",
			"<%statusgu%>='<|statusgu|>'",
			"<%nipgu%>='<|nipgu|>'",
			"<%identifiedgu%>='<|identifiedgu|>' AND <%statusgu%>='<|statusgu|>'"
		);
		$this->tempCodeOfWhere = array(
			"identifiedgu" => array(
				'kode' => "<%identifiedgu%>",
				'value' => "<|identifiedgu|>"
			),
			"namagu" => array(
				'kode' => "<%namagu%>",
				'value' => "<|namagu|>"
			),
			"nohpgu" => array(
				'kode' => "<%nohpgu%>",
				'value' => "<|nohpgu|>"
			),
			"emailgu" => array(
				'kode' => "<%emailgu%>",
				'value' => "<|emailgu|>"
			),
			"nipgu" => array(
				'kode' => "<%nipgu%>",
				'value' => "<|nipgu|>"
			),
			"alamatgu" => array(
				'kode' => "<%alamatgu%>",
				'value' => "<|alamatgu|>"
			),
			"bidangriset" => array(
				'kode' => "<%bidangriset%>",
				'value' => "<|bidangriset|>"
			),
			"statusgu" => array(
				'kode' => "<%statusgu%>",
				'value' => "<|statusgu|>"
			),
			"kelamingu" => array(
				'kode' => "<%kelamingu%>",
				'value' => "<|kelamingu|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getIdentified(){ return $this->getData('identifiedgu'); }
	public function getNip(){ return $this->getData('nipgu'); }
	public function getEmail(){ return $this->getData('emailgu'); }
	public function getNama(){ return $this->getData('namagu'); }
	public function getAlamat(){ return $this->getData('alamatgu'); }
	public function getStatus(){ return $this->getData('statusgu'); }
	public function getNoHp(){ return $this->getData('nohpgu'); }
	public function getBidangRiset(){ return $this->getData('bidangriset'); }
	public function getKelamin(){ return $this->getData('kelamingu'); }
	
	public function setKelamin($tempData,$tempAsWhere = false){
		return $this->setData('kelamingu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statusgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNip($tempData,$tempAsWhere = false){
		return $this->setData('nipgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setEmail($tempData,$tempAsWhere = false){
		return $this->setData('emailgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNama($tempData,$tempAsWhere = false){
		return $this->setData('namagu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setAlamat($tempData,$tempAsWhere = false){
		return $this->setData('alamatgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNoHp($tempData,$tempAsWhere = false){
		return $this->setData('nohpgu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setBidangRiset($tempData,$tempAsWhere = false){
		return $this->setData('bidangriset',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}