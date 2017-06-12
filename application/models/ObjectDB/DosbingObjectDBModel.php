<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DosbingObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'dosbing';
		$this->tempDataArrayIndexPrimary = array(
			'identifieddo'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifieddo%>='<|identifieddo|>'",
			"<%registrasido%>='<|registrasido|>' AND <%statusdo%>='<|statusdo|>'",
			"<%registrasido%>='<|registrasido|>' ORDER BY identifieddo",
			"<%astable%>.<%dosendo%>='<|dosendo|>' AND <%astable%>.<%statusdo%>='<|statusdo|>'",
			"<%astable%>.<%statusdo%>='<|statusdo|>'",
			"<%astable%>.dosendo<>'0' AND <%astable%>.dosendo<>''"
		);
		$this->tempDataArrayWhereMultiple = array(
			"",
			"<%astablem%>.registrasido=<%astable1%>.<%table1primary%>",
			"<%astablem%>.registrasido=<%astable1%>.<%table1primary%> group by <%astablem%>.dosendo asc) as y  order by y.identifieddo desc",
			"<%astablem%>.registrasido=<%astable1%>.<%table1primary%> AND <%astablem%>.dosendo=<%astable2%>.<%table2primary%>",
			"<%astablem%>.registrasido=<%astable1%>.<%table1primary%> AND <%astable1%>.mahasisware=<%astable2%>.<%table2primary%>",
			"<%astablem%>.registrasido=<%astable1%>.<%table1primary%> AND <%astable1%>.mahasisware=<%astable2%>.<%table2primary%> AND <%astable1%>.mahasisware=<%astable3%>.mahasiswasi",
			"<%astablem%>.registrasido=<%astable1%>.<%table1primary%> AND <%astablem%>.dosendo=<%astable2%>.<%table2primary%> AND <%astable1%>.mahasisware=<%astable3%>.<%table3primary%>",
		);
		$this->tempCodeOfWhere = array(
			"registrasido" => array(
				'kode' => "<%registrasido%>",
				'value' => "<|registrasido|>"
			),
			"dosendo" => array(
				'kode' => "<%dosendo%>",
				'value' => "<|dosendo|>"
			),
			"statusdo" => array(
				'kode' => "<%statusdo%>",
				'value' => "<|statusdo|>"
			),
			"pesando" => array(
				'kode' => "<%pesando%>",
				'value' => "<|pesando|>"
			),
			"identifieddo" => array(
				'kode' => "<%identifieddo%>",
				'value' => "<|identifieddo|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getRegistrasi(){ return $this->getData('registrasido'); }
	public function getDosen(){ return $this->getData('dosendo'); }
	public function getStatus(){ return $this->getData('statusdo'); }
	public function getPesan(){ return $this->getData('pesando'); }
	public function getIdentified(){ return $this->getData('identifieddo'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifieddo',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRegistrasi($tempData,$tempAsWhere = false){
		return $this->setData('registrasido',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosen($tempData,$tempAsWhere = false){
		return $this->setData('dosendo',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statusdo',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setPesan($tempData,$tempAsWhere = false){
		return $this->setData('pesando',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}