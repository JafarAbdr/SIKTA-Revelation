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
			"<%registrasi%>='<|registrasi|>' AND <%statusdo%>='<|statusdo|>'",
			"<%registrasi%>='<|registrasi|>' ORDER BY identifieddo",
			"<%astable%>.<%dosen%>='<|dosen|>' AND <%astable%>.<%statusdo%>='<|statusdo|>'",
			"<%astable%>.<%statusdo%>='<|statusdo|>'",
			"<%astable%>.dosen<>'0' AND <%astable%>.dosen<>''"
		);
		$this->tempDataArrayWhereMultiple = array(
			"",
			"<%astablem%>.registrasi=<%astable1%>.<%table1primary%>",
			"<%astablem%>.registrasi=<%astable1%>.<%table1primary%> group by <%astablem%>.dosen asc) as y  order by y.identifieddo desc",
			"<%astablem%>.registrasi=<%astable1%>.<%table1primary%> AND <%astablem%>.dosen=<%astable2%>.<%table2primary%>",
		);
		$this->tempCodeOfWhere = array(
			"registrasi" => array(
				'kode' => "<%registrasi%>",
				'value' => "<|registrasi|>"
			),
			"dosen" => array(
				'kode' => "<%dosen%>",
				'value' => "<|dosen|>"
			),
			"statusdo" => array(
				'kode' => "<%statusdo%>",
				'value' => "<|statusdo|>"
			),
			"pesan" => array(
				'kode' => "<%pesan%>",
				'value' => "<|pesan|>"
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
	public function getRegistrasi(){ return $this->getData('registrasi'); }
	public function getDosen(){ return $this->getData('dosen'); }
	public function getStatus(){ return $this->getData('statusdo'); }
	public function getPesan(){ return $this->getData('pesan'); }
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
		return $this->setData('registrasi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosen($tempData,$tempAsWhere = false){
		return $this->setData('dosen',$tempData,$tempAsWhere,function($x,$tempResult){
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
		return $this->setData('pesan',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}