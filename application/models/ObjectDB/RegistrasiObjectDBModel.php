<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RegistrasiObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'registrasi';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedre'
		);
		$this->tempDataArrayCase = array(
			"*",
			"* FROM (SELECT *",
			/*"x.dosen FROM (SELECT *"*/
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedre%>='<|identifiedre|>'",
			"<%tahunakre%>='<|tahunakre|>' AND <%statusre%>='<|statusre|>' AND <%dataprosesre%>='<|dataprosesre|>'",
			"<%tahunakre%>='<|tahunakre|>' AND <%mahasisware%>='<|mahasisware|>' AND <%statusre%>='<|statusre|>' AND <%dataprosesre%>='<|dataprosesre|>'",
			"<%tahunakre%>='<|tahunakre|>' AND <%mahasisware%>='<|mahasisware|>' AND <%statusre%>='<|statusre|>'",
			"<%tahunakre%> LIKE '<|tahunakre|>%' AND <%statusre%>='<|statusre|>'",
			"<%tahunakre%>='<|tahunakre|>' AND <%statusre%>='<|statusre|>'",
			"<%tahunakre%>='<|tahunakre|>' AND <%mahasisware%>='<|mahasisware|>'",
			"<%mahasisware%>='<|mahasisware|>'",
			"<%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%mahasisware%>='<|mahasisware|>' AND <%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%statusre%>='<|statusre|>' AND <%astable%>.<%dataprosesre%>='<|dataprosesre|>'",
			"<%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%mahasisware%>='<|mahasisware|>' AND <%astable%>.<%statusre%>='<|statusre|>' AND <%astable%>.<%dataprosesre%>='<|dataprosesre|>'",
			"<%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%mahasisware%>='<|mahasisware|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%tahunakre%>='<|tahunakre|>' AND <%astable%>.<%mahasisware%>='<|mahasisware|>'",
			"<%astable%>.<%mahasisware%>='<|mahasisware|>'",
			/*"<%statusre%>='<|statusre|>' AND <%mahasisware%>='<|mahasisware|>' AND dosen<>'0' and dosen<>'' group by dosen) as x order by x.tahunakre desc, x.datastatusre desc"*/
		);
		$this->tempCodeOfWhere = array(
			"identifiedre" => array(
				'kode' => "<%identifiedre%>",
				'value' => "<|identifiedre|>"
			),
			"tahunakre" => array(
				'kode' => "<%tahunakre%>",
				'value' => "<|tahunakre|>"
			),
			"mahasisware" => array(
				'kode' => "<%mahasisware%>",
				'value' => "<|mahasisware|>"
			),
			"judultare" => array(
				'kode' => "<%judultare%>",
				'value' => "<|judultare|>"
			),
			"metodere" => array(
				'kode' => "<%metodere%>",
				'value' => "<|metodere|>"
			),
			"refsre" => array(
				'kode' => "<%refsre%>",
				'value' => "<|refsre|>"
			),
			"refdre" => array(
				'kode' => "<%refdre%>",
				'value' => "<|refdre|>"
			),
			"reftre" => array(
				'kode' => "<%reftre%>",
				'value' => "<|reftre|>"
			),
			"lokasire" => array(
				'kode' => "<%lokasire%>",
				'value' => "<|lokasire|>"
			),
			"namakrsre" => array(
				'kode' => "<%namakrsre%>",
				'value' => "<|namakrsre|>"
			),
			"statusre" => array(
				'kode' => "<%statusre%>",
				'value' => "<|statusre|>"
			),
			"kategorire" => array(
				'kode' => "<%kategorire%>",
				'value' => "<|kategorire|>"
			),
			"dataprosesre" => array(
				'kode' => "<%dataprosesre%>",
				'value' => "<|dataprosesre|>"
			)
		);
	}/* 
	public function resetValue(){
		parent::resetValue();
	} */
	public function getTahunAk(){ return $this->getData('tahunakre'); }
	public function getMahasiswa(){ return $this->getData('mahasisware'); }
	public function getJudulTA(){ return $this->getData('judultare'); }
	public function getMetode(){ return $this->getData('metodere'); }
	public function getRefS(){ return $this->getData('refsre'); }
	public function getRefD(){ return $this->getData('refdre'); }
	public function getRefT(){ return $this->getData('reftre'); }
	public function getLokasi(){ return $this->getData('lokasire'); }
	public function getNamaKRS(){ return $this->getData('namakrsre'); }
	public function getStatus(){ return $this->getData('statusre'); }
	public function getIdentified(){ return $this->getData('identifiedre'); }
	public function getKategori(){ return $this->getData('kategorire'); }
	public function getDataProses(){ return $this->getData('dataprosesre'); }
	
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunakre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMahasiswa($tempData,$tempAsWhere = false){
		return $this->setData('mahasisware',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setJudulTA($tempData,$tempAsWhere = false){
		return $this->setData('judultare',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMetode($tempData,$tempAsWhere = false){
		return $this->setData('metodere',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRefS($tempData,$tempAsWhere = false){
		return $this->setData('refsre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRefD($tempData,$tempAsWhere = false){
		return $this->setData('refdre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRefT($tempData,$tempAsWhere = false){
		return $this->setData('reftre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setLokasi($tempData,$tempAsWhere = false){
		return $this->setData('lokasire',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaKRS($tempData,$tempAsWhere = false){
		return $this->setData('namakrsre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statusre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKategori($tempData,$tempAsWhere = false){
		return $this->setData('kategorire',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDataProses($tempData,$tempAsWhere = false){
		return $this->setData('dataprosesre',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}