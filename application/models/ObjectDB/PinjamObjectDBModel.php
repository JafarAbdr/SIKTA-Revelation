<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PinjamObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'pinjam';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedpi'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%tahunakpi%>='<|tahunakpi|>'",
			"<%ruangpi%>='<|ruangpi|>'",
			"<%tahunakpi%>='<|tahunakpi|>' AND <%ruangpi%>='<|ruangpi|>'",
			"<%mulaipi%> LIKE '<|mulaipi|>%' AND <%ruangpi%>='<|ruangpi|>'",
			"<%tahunakpi%>='<|tahunakpi|>' AND <%ruangpi%>='<|ruangpi|>' AND <%mulaipi%>='<|mulaipi|>'",
			"<%identifiedpi%>='<|identifiedpi|>'",
			"<%astable%>.<%tahunakpi%>='<|tahunakpi|>'",
			"<%astable%>.<%ruangpi%>='<|ruangpi|>'",
			"<%astable%>.<%tahunakpi%>='<|tahunakpi|>' AND <%astable%>.<%ruangpi%>='<|ruangpi|>'",
			"<%astable%>.<%tahunakpi%>='<|tahunakpi|>' AND <%astable%>.<%ruangpi%>='<|ruangpi|>' AND <%astable%>.<%mulaipi%>='<|mulaipi|>'"
		);
		$this->tempDataArrayWhereMultiple = array(
			"",
			"<%astablem%>.penanggungjawabpi=<%astable1%>.<%table1primary%>"
		);
		$this->tempCodeOfWhere = array(
			"tahunakpi" => array(
				'kode' => "<%tahunakpi%>",
				'value' => "<|tahunakpi|>"
			),
			"mulaipi" => array(
				'kode' => "<%mulaipi%>",
				'value' => "<|mulaipi|>"
			),
			"berakhirpi" => array(
				'kode' => "<%berakhirpi%>",
				'value' => "<|berakhirpi|>"
			),
			"detailpi" => array(
				'kode' => "<%detailpi%>",
				'value' => "<|detailpi|>"
			),
			"penanggungjawabpi" => array(
				'kode' => "<%penanggungjawabpi%>",
				'value' => "<|penanggungjawabpi|>"
			),
			"ruangpi" => array(
				'kode' => "<%ruangpi%>",
				'value' => "<|ruangpi|>"
			),
			"identifiedpi" => array(
				'kode' => "<%identifiedpi%>",
				'value' => "<|identifiedpi|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getTahunAk(){ return $this->getData('tahunakpi'); }
	public function getBerakhir(){ return $this->getData('berakhirpi'); }
	public function getMulai(){ return $this->getData('mulaipi'); }
	public function getPenanggungJawab(){ return $this->getData('penanggungjawabpi'); }
	public function getRuang(){ return $this->getData('ruangpi'); }
	public function getDetail(){ return $this->getData('detailpi'); }
	public function getIdentified(){ return $this->getData('identifiedpi'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedpi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunakpi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setBerakhir($tempData,$tempAsWhere = false){
		return $this->setData('berakhirpi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMulai($tempData,$tempAsWhere = false){
		return $this->setData('mulaipi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setPenanggungJawab($tempData,$tempAsWhere = false){
		return $this->setData('penanggungjawabpi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDetail($tempData,$tempAsWhere = false){
		return $this->setData('detailpi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRuang($tempData,$tempAsWhere = false){
		return $this->setData('ruangpi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}