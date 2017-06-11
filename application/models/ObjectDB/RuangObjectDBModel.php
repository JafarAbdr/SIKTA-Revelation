<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RuangObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'ruang';
		$this->tempDataArrayIndexPrimary = array(
			'idr'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%idr%>='<|idr|>'"
		);
		$this->tempCodeOfWhere = array(
			"idr" => array(
				'kode' => "<%idr%>",
				'value' => "<|idr|>"
			),
			"detailr" => array(
				'kode' => "<%detailr%>",
				'value' => "<|detailr|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getId(){ return $this->getData('idr'); }
	public function getDetail(){ return $this->getData('detailr'); }
	
	public function setId($tempData,$tempAsWhere = false){
		return $this->setData('idr',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('detailr',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}