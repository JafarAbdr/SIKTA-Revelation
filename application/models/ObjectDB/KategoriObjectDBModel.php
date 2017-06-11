<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class KategoriObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'kategori';
		$this->tempDataArrayIndexPrimary = array(
			'idk'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%idk%>='<|idk|>'"
		);
		$this->tempCodeOfWhere = array(
			"idk" => array(
				'kode' => "<%idk%>",
				'value' => "<|idk|>"
			),
			"detailk" => array(
				'kode' => "<%detailk%>",
				'value' => "<|detailk|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getId(){ return $this->getData('idk'); }
	public function getDetail(){ return $this->getData('detailk'); }
	
	public function setId($tempData,$tempAsWhere = false){
		return $this->setData('idk',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('detailk',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}