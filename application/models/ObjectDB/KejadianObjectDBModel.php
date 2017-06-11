<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class KejadianObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'kejadian';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedke'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedke%>='<|identifiedke|>'",
			"1=1 order by `kejadian`.`tahunak` desc ,`kejadian`.`mulai` desc", //getrule11
			"<%kode%>='<|kode|>' order by identifiedke desc", //getrule1
			"<%status%>='<|status|>' order by identifiedke desc", //getrule1
			"<%status%>='<|status|>' AND <%kode%>='<|kode|>' order by identifiedke desc", //getrule1
			"<%kode%>='<|kode|>' AND <%judul%> LIKE '%<|judul|>%' order by identifiedke desc", //getrule1
			"<%status%>='<|status|>' AND <%judul%> LIKE '%<|judul|>%' order by identifiedke desc", //getrule1
			"<%status%>='<|status|>' AND <%kode%>='<|kode|>' AND <%judul%> LIKE '%<|judul|>%' order by identifiedke desc", //getrule1
			"<%judul%> LIKE '%<|judul|>%' order by identifiedke desc", //getrule1
			"<%status%>='<|status|>' AND <%kode%>='<|kode|>' AND <%tahunak%>='<|tahunak|>' order by identifiedke desc", //getrule1
			"<%kode%>='<|kode|>' AND <%tahunak%>='<|tahunak|>' order by identifiedke desc" //getrule1
		);
		$this->tempCodeOfWhere = array(
			"identifiedke" => array(
				'kode' => "<%identifiedke%>",
				'value' => "<|identifiedke|>"
			),
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
			"kode" => array(
				'kode' => "<%kode%>",
				'value' => "<|kode|>"
			),
			"judul" => array(
				'kode' => "<%judul%>",
				'value' => "<|judul|>"
			),
			"isi" => array(
				'kode' => "<%isi%>",
				'value' => "<|isi|>"
			),
			"status" => array(
				'kode' => "<%status%>",
				'value' => "<|status|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getIdentified(){ return $this->getData('identifiedke'); }
	public function getKode(){ return $this->getData('kode'); }
	public function getBerakhir(){ return $this->getData('berakhir'); }
	public function getTahunAk(){ return $this->getData('tahunak'); }
	public function getJudul(){ return $this->getData('judul'); }
	public function getStatus(){ return $this->getData('status'); }
	public function getMulai(){ return $this->getData('mulai'); }
	public function getIsi(){ return $this->getData('isi'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedke',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('status',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKode($tempData,$tempAsWhere = false){
		return $this->setData('kode',$tempData,$tempAsWhere,function($x,$tempResult){
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
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunak',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setJudul($tempData,$tempAsWhere = false){
		return $this->setData('judul',$tempData,$tempAsWhere,function($x,$tempResult){
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
	public function setIsi($tempData,$tempAsWhere = false){
		return $this->setData('isi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}