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
			"<%tahunak%>='<|tahunak|>' AND <%statusre%>='<|statusre|>' AND <%dataproses%>='<|dataproses|>'",
			"<%tahunak%>='<|tahunak|>' AND <%mahasiswa%>='<|mahasiswa|>' AND <%statusre%>='<|statusre|>' AND <%dataproses%>='<|dataproses|>'",
			"<%tahunak%>='<|tahunak|>' AND <%mahasiswa%>='<|mahasiswa|>' AND <%statusre%>='<|statusre|>'",
			"<%tahunak%> LIKE '<|tahunak|>%' AND <%dosen%>='<|dosen|>' AND <%statusre%>='<|statusre|>'",
			"<%tahunak%>='<|tahunak|>' AND <%statusre%>='<|statusre|>'",
			"<%tahunak%>='<|tahunak|>' AND <%mahasiswa%>='<|mahasiswa|>'",
			"<%mahasiswa%>='<|mahasiswa|>'",
			"<%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%mahasiswa%>='<|mahasiswa|>' AND <%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%statusre%>='<|statusre|>' AND <%astable%>.<%dataproses%>='<|dataproses|>'",
			"<%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%mahasiswa%>='<|mahasiswa|>' AND <%astable%>.<%statusre%>='<|statusre|>' AND <%astable%>.<%dataproses%>='<|dataproses|>'",
			"<%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%mahasiswa%>='<|mahasiswa|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%statusre%>='<|statusre|>'",
			"<%astable%>.<%tahunak%>='<|tahunak|>' AND <%astable%>.<%mahasiswa%>='<|mahasiswa|>'",
			"<%astable%>.<%mahasiswa%>='<|mahasiswa|>'",
			/*"<%statusre%>='<|statusre|>' AND <%mahasiswa%>='<|mahasiswa|>' AND dosen<>'0' and dosen<>'' group by dosen) as x order by x.tahunak desc, x.datastatusre desc"*/
		);
		$this->tempCodeOfWhere = array(
			"identifiedre" => array(
				'kode' => "<%identifiedre%>",
				'value' => "<|identifiedre|>"
			),
			"tahunak" => array(
				'kode' => "<%tahunak%>",
				'value' => "<|tahunak|>"
			),
			"mahasiswa" => array(
				'kode' => "<%mahasiswa%>",
				'value' => "<|mahasiswa|>"
			),
			"judulta" => array(
				'kode' => "<%judulta%>",
				'value' => "<|judulta|>"
			),
			"metode" => array(
				'kode' => "<%metode%>",
				'value' => "<|metode|>"
			),
			"refs" => array(
				'kode' => "<%refs%>",
				'value' => "<|refs|>"
			),
			"refd" => array(
				'kode' => "<%refd%>",
				'value' => "<|refd|>"
			),
			"reft" => array(
				'kode' => "<%reft%>",
				'value' => "<|reft|>"
			),
			"lokasi" => array(
				'kode' => "<%lokasi%>",
				'value' => "<|lokasi|>"
			),
			"namakrs" => array(
				'kode' => "<%namakrs%>",
				'value' => "<|namakrs|>"
			),
			"statusre" => array(
				'kode' => "<%statusre%>",
				'value' => "<|statusre|>"
			),
			"kategori" => array(
				'kode' => "<%kategori%>",
				'value' => "<|kategori|>"
			),
			"dataproses" => array(
				'kode' => "<%dataproses%>",
				'value' => "<|dataproses|>"
			)
		);
	}/* 
	public function resetValue(){
		parent::resetValue();
	} */
	public function getTahunAk(){ return $this->getData('tahunak'); }
	public function getMahasiswa(){ return $this->getData('mahasiswa'); }
	public function getJudulTA(){ return $this->getData('judulta'); }
	public function getMetode(){ return $this->getData('metode'); }
	public function getRefS(){ return $this->getData('refs'); }
	public function getRefD(){ return $this->getData('refd'); }
	public function getRefT(){ return $this->getData('reft'); }
	public function getLokasi(){ return $this->getData('lokasi'); }
	public function getNamaKRS(){ return $this->getData('namakrs'); }
	public function getStatus(){ return $this->getData('statusre'); }
	public function getIdentified(){ return $this->getData('identifiedre'); }
	public function getKategori(){ return $this->getData('kategori'); }
	public function getDataProses(){ return $this->getData('dataproses'); }
	
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunak',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMahasiswa($tempData,$tempAsWhere = false){
		return $this->setData('mahasiswa',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setJudulTA($tempData,$tempAsWhere = false){
		return $this->setData('judulta',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMetode($tempData,$tempAsWhere = false){
		return $this->setData('metode',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRefS($tempData,$tempAsWhere = false){
		return $this->setData('refs',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRefD($tempData,$tempAsWhere = false){
		return $this->setData('refd',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRefT($tempData,$tempAsWhere = false){
		return $this->setData('reft',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setLokasi($tempData,$tempAsWhere = false){
		return $this->setData('lokasi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaKRS($tempData,$tempAsWhere = false){
		return $this->setData('namakrs',$tempData,$tempAsWhere,function($x,$tempResult){
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
		return $this->setData('kategori',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDataProses($tempData,$tempAsWhere = false){
		return $this->setData('dataproses',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}