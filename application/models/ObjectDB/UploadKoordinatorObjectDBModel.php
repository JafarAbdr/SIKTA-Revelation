<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UploadKoordinatorObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'uploadkoordinator';
		$this->tempDataArrayIndexPrimary = array(
			'identified'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identified%>='<|identified|>'",
			"1=1 order by `uploadkoordinator`.`identified` desc"
		);
		$this->tempCodeOfWhere = array(
			"identified" => array(
				'kode' => "<%identified%>",
				'value' => "<|identified|>"
			),
			"detail" => array(
				'kode' => "<%detail%>",
				'value' => "<|detail|>"
			),
			"namadata" => array(
				'kode' => "<%namadata%>",
				'value' => "<|namadata|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getIdentified(){ return $this->getData('identified'); }
	public function getDetail(){ return $this->getData('detail'); }
	public function getNamaData(){ return $this->getData('namadata'); }
	
	public function setidentified($tempData,$tempAsWhere = false){
		return $this->setData('identified',$tempData,$tempAsWhere,function($x,$tempResult){
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
	public function setNamaData($tempData,$tempAsWhere = false){
		return $this->setData('namadata',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}