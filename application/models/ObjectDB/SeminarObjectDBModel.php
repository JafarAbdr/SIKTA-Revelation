<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SeminarObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'seminar';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedse'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedse%>='<|identifiedse|>'",
			"<%tahunakse%>='<|tahunakse|>' AND <%statusse%>='<|statusse|>' AND <%dataprosesse%>='<|dataprosesse|>'",
			"<%tahunakse%>='<|tahunakse|>' AND <%statusse%>='<|statusse|>' AND waktuse<>'1000-01-01 00:00:00'",
			"<%ruangse%>='<|ruangse|>' AND <%waktuse%> LIKE '<|waktuse|>%' AND <%statusse%>='<|statusse|>'",
			"<%tahunakse%>='<|tahunakse|>' AND <%mahasiswase%>='<|mahasiswase|>' AND <%statusse%>='<|statusse|>'",
			"<%tahunakse%>='<|tahunakse|>' AND <%mahasiswase%>='<|mahasiswase|>'",
			"<%astable%>.<%tahunakse%>='<|tahunakse|>' AND <%astable%>.<%statusse%>='<|statusse|>' AND <%astable%>.waktuse<>'1000-01-01 00:00:00'",
			""
		);
		$this->tempDataArrayWhereMultiple = array(
			"",
			"<%astablem%>.mahasiswase=<%astable1%>.<%table1primary%>"
		);
		$this->tempCodeOfWhere = array(
			"identifiedse" => array(
				'kode' => "<%identifiedse%>",
				'value' => "<|identifiedse|>"
			),
			"tahunakse" => array(
				'kode' => "<%tahunakse%>",
				'value' => "<|tahunakse|>"
			),
			"mahasiswase" => array(
				'kode' => "<%mahasiswase%>",
				'value' => "<|mahasiswase|>"
			),
			"karbimse" => array(
				'kode' => "<%karbimse%>",
				'value' => "<|karbimse|>"
			),
			"karfolsemse" => array(
				'kode' => "<%karfolsemse%>",
				'value' => "<|karfolsemse|>"
			),
			"ruangse" => array(
				'kode' => "<%ruangse%>",
				'value' => "<|ruangse|>"
			),
			"fujsse" => array(
				'kode' => "<%fujsse%>",
				'value' => "<|fujsse|>"
			),
			"fujdse" => array(
				'kode' => "<%fujdse%>",
				'value' => "<|fujdse|>"
			),
			"fujtse" => array(
				'kode' => "<%fujtse%>",
				'value' => "<|fujtse|>"
			),
			"waktuendse" => array(
				'kode' => "<%waktuendse%>",
				'value' => "<|waktuendse|>"
			),
			"waktuse" => array(
				'kode' => "<%waktuse%>",
				'value' => "<|waktuse|>"
			),
			"rekomendasise" => array(
				'kode' => "<%rekomendasise%>",
				'value' => "<|rekomendasise|>"
			),
			"statusse" => array(
				'kode' => "<%statusse%>",
				'value' => "<|statusse|>"
			),
			"nilaise" => array(
				'kode' => "<%nilaise%>",
				'value' => "<|nilaise|>"
			),
			"dataprosesse" => array(
				'kode' => "<%dataprosesse%>",
				'value' => "<|dataprosesse|>"
			),
			"kosurunse" => array(
				'kode' => "<%kosurunse%>",
				'value' => "<|kosurunse|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getTahunAk(){ return $this->getData('tahunakse'); }
	public function getMahasiswa(){ return $this->getData('mahasiswase'); }
	public function getKarBim(){ return $this->getData('karbimse'); }
	public function getKarFolSem(){ return $this->getData('karfolsemse'); }
	public function getRuang(){ return $this->getData('ruangse'); }
	public function getFujS(){ return $this->getData('fujsse'); }
	public function getFujD(){ return $this->getData('fujdse'); }
	public function getFujT(){ return $this->getData('fujtse'); }
	public function getWaktu(){ return $this->getData('waktuse'); }
	public function getWaktuEnd(){ return $this->getData('waktuendse'); }
	public function getRekomendasi(){ return $this->getData('rekomendasise'); }
	public function getStatus(){ return $this->getData('statusse'); }
	public function getNilai(){ return $this->getData('nilaise'); }
	public function getDataProses(){ return $this->getData('dataprosesse'); }
	public function getNoSuratUndangan(){ return $this->getData('kosurunse'); }
	public function getIdentified(){ return $this->getData('identifiedse'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunakse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNoSuratUndangan($tempData,$tempAsWhere = false){
		return $this->setData('kosurunse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMahasiswa($tempData,$tempAsWhere = false){
		return $this->setData('mahasiswase',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKarBim($tempData,$tempAsWhere = false){
		return $this->setData('karbimse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKarFolSem($tempData,$tempAsWhere = false){
		return $this->setData('karfolsemse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRuang($tempData,$tempAsWhere = false){
		return $this->setData('ruangse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujS($tempData,$tempAsWhere = false){
		return $this->setData('fujsse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujD($tempData,$tempAsWhere = false){
		return $this->setData('fujdse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujT($tempData,$tempAsWhere = false){
		return $this->setData('fujtse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setWaktuEnd($tempData,$tempAsWhere = false){
		return $this->setData('waktuendse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setWaktu($tempData,$tempAsWhere = false){
		return $this->setData('waktuse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRekomendasi($tempData,$tempAsWhere = false){
		return $this->setData('rekomendasise',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statusse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNilai($tempData,$tempAsWhere = false){
		return $this->setData('nilaise',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDataProses($tempData,$tempAsWhere = false){
		return $this->setData('dataprosesse',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}