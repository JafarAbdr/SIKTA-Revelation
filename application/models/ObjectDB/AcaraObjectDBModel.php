<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AcaraObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'acara';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedac'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%tahunak%>='<|tahunak|>'",
			"<%ruang%>='<|ruang|>'",
			"<%tahunak%>='<|tahunak|>' AND <%ruang%>='<|ruang|>'",
			"<%mulai%> LIKE '<|mulai|>%' AND <%ruang%>='<|ruang|>'",
			"<%tahunak%>='<|tahunak|>' AND <%ruang%>='<|ruang|>' AND <%mulai%>='<|mulai|>'",
			"<%identifiedac%>='<|identifiedac|>'"
		);
		$this->tempCodeOfWhere = array(
			"tahunak" => array(
				'kode' => "<%tahunak%>",
				'value' => "<|tahunak|>"
			),
			"mulai" => array(
				'kode' => "<%mulai%>",
				'value' => "<|mulai|>"
			),
			"berakhir" => array(
				'kode' => "<%berakhir%>",
				'value' => "<|berakhir|>"
			),
			"detail" => array(
				'kode' => "<%detail%>",
				'value' => "<|detail|>"
			),
			"penanggungjawab" => array(
				'kode' => "<%penanggungjawab%>",
				'value' => "<|penanggungjawab|>"
			),
			"ruang" => array(
				'kode' => "<%ruang%>",
				'value' => "<|ruang|>"
			),
			"identifiedac" => array(
				'kode' => "<%identifiedac%>",
				'value' => "<|identifiedac|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getTahunAk(){ return $this->getData('tahunak'); }
	public function getBerakhir(){ return $this->getData('berakhir'); }
	public function getMulai(){ return $this->getData('mulai'); }
	public function getPenanggungJawab(){ return $this->getData('penanggungjawab'); }
	public function getRuang(){ return $this->getData('ruang'); }
	public function getDetail(){ return $this->getData('detail'); }
	public function getIdentified(){ return $this->getData('identifiedac'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedac',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunak',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setBerakhir($tempData,$tempAsWhere = false){
		return $this->setData('berakhir',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMulai($tempData,$tempAsWhere = false){
		return $this->setData('mulai',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setPenanggungJawab($tempData,$tempAsWhere = false){
		return $this->setData('penanggungjawab',$tempData,$tempAsWhere,function($x,$tempResult){
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
	public function setRuang($tempData,$tempAsWhere = false){
		return $this->setData('ruang',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}