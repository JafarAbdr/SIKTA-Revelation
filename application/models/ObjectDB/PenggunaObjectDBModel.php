<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PenggunaObjectDBModel extends ObjectDBModel {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->tempTableName = 'pengguna';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedpe'
		);
		$this->tempDataArrayCase = array(
			"*",
			"identifiedpe, nickname, keyword",
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedpe%>='<|identifiedpe|>'",
			"<%nickname%>='<|nickname|>' AND <%keyword%>='<|keyword|>'"
		);
		$this->tempCodeOfWhere = array(
			"identifiedpe" => array(
				'kode' => "<%identifiedpe%>",
				'value' => "<|identifiedpe|>"
			),
			"nickname" => array(
				'kode' => "<%nickname%>",
				'value' => "<|nickname|>"
			),
			"keyword" => array(
				'kode' => "<%keyword%>",
				'value' => "<|keyword|>"
			),
			"failedlogin" => array(
				'kode' => "<%failedlogin%>",
				'value' => "<|failedlogin|>"
			)
		);
	}/* 
	public function resetValue(){
		parent::resetValue();
	} */
	public function getIdentified(){ return $this->getData('identifiedpe'); }
	public function getNickName(){ return $this->getData('nickname'); }
	public function getKeyWord(){ return $this->getData('keyword'); }
	public function getFailedLogin(){ return $this->getData('failedlogin'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedpe',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNickName($tempData,$tempAsWhere = false){
		return $this->setData('nickname',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKeyWord($tempData,$tempAsWhere = false){
		return $this->setData('keyword',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFailedLogin($tempData,$tempAsWhere = false){
		return $this->setData('failedlogin',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}