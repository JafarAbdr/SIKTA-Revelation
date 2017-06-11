<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MinatObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'minat';
		$this->tempDataArrayIndexPrimary = array(
			'idm'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%idm%>='<|idm|>'"
		);
		$this->tempCodeOfWhere = array(
			"idm" => array(
				'kode' => "<%idm%>",
				'value' => "<|idm|>"
			),
			"detailm" => array(
				'kode' => "<%detailm%>",
				'value' => "<|detailm|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getId(){ return $this->getData('idm'); }
	public function getDetail(){ return $this->getData('detailm'); }
	
	public function setId($tempData,$tempAsWhere = false){
		return $this->setData('idm',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('detailm',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}