<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StatusObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'status';
		$this->tempDataArrayIndexPrimary = array(
			'ids'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%ids%>='<|ids|>'"
		);
		$this->tempCodeOfWhere = array(
			"ids" => array(
				'kode' => "<%ids%>",
				'value' => "<|ids|>"
			),
			"details" => array(
				'kode' => "<%details%>",
				'value' => "<|details|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getId(){ return $this->getData('ids'); }
	public function getDetail(){ return $this->getData('details'); }
	
	public function setId($tempData,$tempAsWhere = false){
		return $this->setData('ids',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('details',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}