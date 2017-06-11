<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DetailIdentified extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'unknown';
		$this->tempDataArrayIndexPrimary = array(
			'id'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%id%>='<|id|>'"
		);
		$this->tempCodeOfWhere = array(
			"id" => array(
				'kode' => "<%id%>",
				'value' => "<|id|>"
			),
			"detail" => array(
				'kode' => "<%detail%>",
				'value' => "<|detail|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getId(){ return $this->getData('id'); }
	public function getDetail(){ return $this->getData('detail'); }
	
	public function setId($tempData,$tempAsWhere = false){
		return $this->setData('id',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('detail',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}