<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MuridObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'murid';
		$this->tempDataArrayIndexPrimary = array(
			'identifiedmu'
		);
		$this->tempDataArrayCase = array(
			"*",
			"nimmu"
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedmu%>='<|identifiedmu|>'",
			"<%nimmu%>='<|nimmu|>'",
			"<%kodecookiemu%>='<|kodecookiemu|>' AND statusmu='1'",
			"<%statusmu%>='<|statusmu|>'",
			"<%namamu%> LIKE '%<|namamu|>%' AND <%statusmu%>='<|statusmu|>'",
			"<%namamu%> LIKE '%<|namamu|>%' AND <%statusmu%>='<|statusmu|>' AND (<%dosensmu%>='<|dosensmu|>' OR <%dosendmu%>='<|dosendmu|>' OR <%dosentmu%>='<|dosentmu|>')"
		);
		$this->tempCodeOfWhere = array(
			"identifiedmu" => array(
				'kode' => "<%identifiedmu%>",
				'value' => "<|identifiedmu|>"
			),
			"namamu" => array(
				'kode' => "<%namamu%>",
				'value' => "<|namamu|>"
			),
			"nohpmu" => array(
				'kode' => "<%nohpmu%>",
				'value' => "<|nohpmu|>"
			),
			"emailmu" => array(
				'kode' => "<%emailmu%>",
				'value' => "<|emailmu|>"
			),
			"nimmu" => array(
				'kode' => "<%nimmu%>",
				'value' => "<|nimmu|>"
			),
			"statusmu" => array(
				'kode' => "<%statusmu%>",
				'value' => "<|statusmu|>"
			),
			"minatmu" => array(
				'kode' => "<%minatmu%>",
				'value' => "<|minatmu|>"
			),
			"aktiftahunmu" => array(
				'kode' => "<%aktiftahunmu%>",
				'value' => "<|aktiftahunmu|>"
			),
			"nohporangtuamu" => array(
				'kode' => "<%nohporangtuamu%>",
				'value' => "<|nohporangtuamu|>"
			),
			"namaorangtuamu" => array(
				'kode' => "<%namaorangtuamu%>",
				'value' => "<|namaorangtuamu|>"
			),
			"formbarumu" => array(
				'kode' => "<%formbarumu%>",
				'value' => "<|formbarumu|>"
			),
			"registrasilamamu" => array(
				'kode' => "<%registrasilamamu%>",
				'value' => "<|registrasilamamu|>"
			),
			"registrasibarumu" => array(
				'kode' => "<%registrasibarumu%>",
				'value' => "<|registrasibarumu|>"
			),
			"namafotomu" => array(
				'kode' => "<%namafotomu%>",
				'value' => "<|namafotomu|>"
			),
			"namatranskripmu" => array(
				'kode' => "<%namatranskripmu%>",
				'value' => "<|namatranskripmu|>"
			),
			"kodecookiemu" => array(
				'kode' => "<%kodecookiemu%>",
				'value' => "<|kodecookiemu|>"
			),
			"dosensmu" => array(
				'kode' => "<%dosensmu%>",
				'value' => "<|dosensmu|>"
			),
			"dosendmu" => array(
				'kode' => "<%dosendmu%>",
				'value' => "<|dosendmu|>"
			),
			"dosentmu" => array(
				'kode' => "<%dosentmu%>",
				'value' => "<|dosentmu|>"
			),
			"tanpawaktumu" => array(
				'kode' => "<%tanpawaktumu%>",
				'value' => "<|tanpawaktumu|>"
			),
			"waktucookiemu" => array(
				'kode' => "<%waktucookiemu%>",
				'value' => "<|waktucookiemu|>"
			),
			"dosenresponmu" => array(
				'kode' => "<%dosenresponmu%>",
				'value' => "<|dosenresponmu|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getIdentified(){ return $this->getData('identifiedmu'); }
	public function getNim(){ return $this->getData('nimmu'); }
	public function getEmail(){ return $this->getData('emailmu'); }
	public function getNama(){ return $this->getData('namamu'); }
	public function getStatus(){ return $this->getData('statusmu'); }
	public function getNoHp(){ return $this->getData('nohpmu'); }
	public function getNoHpOrangTua(){ return $this->getData('nohporangtuamu'); }
	public function getNamaOrangTua(){ return $this->getData('namaorangtuamu'); }
	public function getAktifTahun(){ return $this->getData('aktiftahunmu'); }
	public function getFormBaru(){ return $this->getData('formbarumu'); }
	public function getRegistrasiLama(){ return $this->getData('registrasilamamu'); }
	public function getRegistrasiBaru(){ return $this->getData('registrasibarumu'); }
	public function getNamaFoto(){ return $this->getData('namafotomu'); }
	public function getNamaTranskrip(){ return $this->getData('namatranskripmu'); }
	public function getKodeCookie(){ return $this->getData('kodecookiemu'); }
	public function getDosenS(){ return $this->getData('dosensmu'); }
	public function getDosenD(){ return $this->getData('dosendmu'); }
	public function getDosenT(){ return $this->getData('dosentmu'); }
	public function getTanpaWaktu(){ return $this->getData('tanpawaktumu'); }
	public function getWaktuCookie(){ return $this->getData('waktucookiemu'); }
	public function getMinat(){ return $this->getData('minatmu'); }
	public function getDosenRespon(){ return $this->getData('dosenresponmu'); }
	
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statusmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenRespon($tempData,$tempAsWhere = false){
		return $this->setData('dosenresponmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNim($tempData,$tempAsWhere = false){
		return $this->setData('nimmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMinat($tempData,$tempAsWhere = false){
		return $this->setData('minatmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setEmail($tempData,$tempAsWhere = false){
		return $this->setData('emailmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNama($tempData,$tempAsWhere = false){
		return $this->setData('namamu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNoHp($tempData,$tempAsWhere = false){
		return $this->setData('nohpmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNoHpOrangTua($tempData,$tempAsWhere = false){
		return $this->setData('nohporangtuamu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaOrangTua($tempData,$tempAsWhere = false){
		return $this->setData('namaorangtuamu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setAktifTahun($tempData,$tempAsWhere = false){
		return $this->setData('aktiftahunmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFormBaru($tempData,$tempAsWhere = false){
		return $this->setData('formbarumu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRegistrasiLama($tempData,$tempAsWhere = false){
		return $this->setData('registrasilamamu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRegistrasiBaru($tempData,$tempAsWhere = false){
		return $this->setData('registrasibarumu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaFoto($tempData,$tempAsWhere = false){
		return $this->setData('namafotomu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaTranskrip($tempData,$tempAsWhere = false){
		return $this->setData('namatranskripmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKodeCookie($tempData,$tempAsWhere = false){
		return $this->setData('kodecookiemu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenS($tempData,$tempAsWhere = false){
		return $this->setData('dosensmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenD($tempData,$tempAsWhere = false){
		return $this->setData('dosendmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenT($tempData,$tempAsWhere = false){
		return $this->setData('dosentmu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTanpaWaktu($tempData,$tempAsWhere = false){
		return $this->setData('tanpawaktumu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setWaktuCookie($tempData,$tempAsWhere = false){
		return $this->setData('waktucookiemu',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}