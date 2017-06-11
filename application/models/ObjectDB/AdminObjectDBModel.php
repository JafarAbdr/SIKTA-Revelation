<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AdminObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'admin';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedad'
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedad%>='<|identifiedad|>'",
			"<%statusad%>='<|statusad|>'"
		);
		$this->tempCodeOfWhere = array(
			"identifiedad" => array(
				'kode' => "<%identifiedad%>",
				'value' => "<|identifiedad|>"
			),
			"namaad" => array(
				'kode' => "<%namaad%>",
				'value' => "<|namaad|>"
			),
			"emailad" => array(
				'kode' => "<%emailad%>",
				'value' => "<|emailad|>"
			),
			"alamatad" => array(
				'kode' => "<%alamatad%>",
				'value' => "<|alamatad|>"
			),
			"nohpad" => array(
				'kode' => "<%nohpad%>",
				'value' => "<|nohpad|>"
			),
			"tasdurasi" => array(
				'kode' => "<%tasdurasi%>",
				'value' => "<|tasdurasi|>"
			),
			"taddurasi" => array(
				'kode' => "<%taddurasi%>",
				'value' => "<|taddurasi|>"
			),
			"kajur" => array(
				'kode' => "<%kajur%>",
				'value' => "<|kajur|>"
			),
			"wakil" => array(
				'kode' => "<%wakil%>",
				'value' => "<|wakil|>"
			),
			"nipad" => array(
				'kode' => "<%nipad%>",
				'value' => "<|nipad|>"
			),
			"statusad" => array(
				'kode' => "<%statusad%>",
				'value' => "<|statusad|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getIdentified(){ return $this->getData('identifiedad'); }
	public function getEmail(){ return $this->getData('emailad'); }
	public function getStatus(){ return $this->getData('statusad'); }
	public function getNama(){ return $this->getData('namaad'); }
	public function getNoHp(){ return $this->getData('nohpad'); }
	public function getKajur(){ return $this->getData('kajur'); }
	public function getWakil(){ return $this->getData('wakil'); }
	public function getTaSDurasi(){ return $this->getData('tasdurasi'); }
	public function getTaDDurasi(){ return $this->getData('taddurasi'); }
	public function getNip(){ return $this->getData('nipad'); }
	public function getAlamat(){ return $this->getData('alamatad'); }
	
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statusad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setEmail($tempData,$tempAsWhere = false){
		return $this->setData('emailad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNama($tempData,$tempAsWhere = false){
		return $this->setData('namaad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKajur($tempData,$tempAsWhere = false){
		return $this->setData('kajur',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNoHp($tempData,$tempAsWhere = false){
		return $this->setData('nohpad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setWakil($tempData,$tempAsWhere = false){
		return $this->setData('wakil',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setAlamat($tempData,$tempAsWhere = false){
		return $this->setData('alamatad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNip($tempData,$tempAsWhere = false){
		return $this->setData('nipad',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTaSDurasi($tempData,$tempAsWhere = false){
		return $this->setData('tasdurasi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTaDDurasi($tempData,$tempAsWhere = false){
		return $this->setData('taddurasi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}