<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DataProsesObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'dataproses';
		$this->tempDataArrayIndexPrimary = array(
			'iddp'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%iddp%>='<|iddp|>'"
		);
		$this->tempCodeOfWhere = array(
			"iddp" => array(
				'kode' => "<%iddp%>",
				'value' => "<|iddp|>"
			),
			"detaildp" => array(
				'kode' => "<%detaildp%>",
				'value' => "<|detaildp|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getId(){ return $this->getData('iddp'); }
	public function getDetail(){ return $this->getData('detaildp'); }
	
	public function setId($tempData,$tempAsWhere = false){
		return $this->setData('iddp',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('detaildp',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}