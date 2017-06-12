<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SidangObjectDBModel extends ObjectDBModel {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'sidang';
		$this->tempDataArrayIndexPrimary = array(
			"identifiedsi"
		);
		$this->tempDataArrayCase = array(
			"*"
		);
		$this->tempDataArrayWhereMultiple = array(
			"",
			"<%astablem%>.mahasiswasi=<%astable1%>.<%table1primary%>",
			"<%astablem%>.mahasiswasi=<%astable1%>.<%table1primary%> AND <%astablem%>.ruangsi=<%astable2%>.<%table2primary%> AND <%astablem%>.statussi=<%astable3%>.<%table3primary%>", //astable1 = mahasiswa /astable1 = ruang /astable3 = dataproses /astable3 = status ;
			"<%astablem%>.mahasiswasi=<%astable1%>.<%table1primary%> AND <%astablem%>.ruangsi=<%astable2%>.<%table2primary%> AND <%astablem%>.statussi=<%astable3%>.<%table3primary%> AND <%astablem%>.mahasiswasi=<%astable4%>.mahasisware AND <%astable4%>.identifiedre=<%astable5%>.registrasido AND <%astable5%>.dosendo=<%astable6%>.<%table6primary%>", //astable1 = mahasiswa /astable1 = ruang /astable3 = dataproses /astable3 = status ;
		);
		$this->tempDataArrayWhere = array(
			"",
			"<%identifiedsi%>='<|identifiedsi|>'",
			"<%tahunaksi%>='<|tahunaksi|>' AND <%statussi%>='<|statussi|>' AND <%dataprosesdsi%>='<|dataprosesdsi|>'",
			"<%tahunaksi%>='<|tahunaksi|>' AND <%statussi%>='<|statussi|>' AND waktusi<>'1000-01-01 00:00:00'",
			"<%tahunaksi%>='<|tahunaksi|>' AND <%statussi%>='<|statussi|>' AND waktusi<>'1000-01-01 00:00:00' AND <%ruangsi%>='<|ruangsi|>'",
			"<%statussi%>='<|statussi|>' AND waktusi<>'1000-01-01 00:00:00' AND <%ruangsi%>='<|ruangsi|>'",
			"<%statussi%>='<|statussi|>' AND waktusi<>'1000-01-01 00:00:00' AND <%ruangsi%>='<|ruangsi|>'",
			"<%statussi%>='<|statussi|>' AND <%waktusi%> LIKE '<|waktusi|>%' AND <%ruangsi%>='<|ruangsi|>'",
			"<%tahunaksi%>='<|tahunaksi|>' AND <%mahasiswasi%>='<|mahasiswasi|>' AND <%statussi%>='<|statussi|>'",
			"<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%dosenssi%>='<|dosenssi|>' AND <%statussi%>='<|statussi|>'",
			"<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%dosendsi%>='<|dosendsi|>' AND <%statussi%>='<|statussi|>'",
			"<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%dosentsi%>='<|dosentsi|>' AND <%statussi%>='<|statussi|>'",
			"<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%mahasiswasi%>='<|mahasiswasi|>' AND <%statussi%>='<|statussi|>'",
			"<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%mahasiswasi%>='<|mahasiswasi|>'",
			"<%tahunaksi%>='<|tahunaksi|>' AND <%statussi%>='<|statussi|>'",
			"<%tahunaksi%>='<|tahunaksi|>' AND <%statussi%>='<|statussi|>' AND <%ruangsi%>='<|ruangsi|>'",
			"<%statussi%>='<|statussi|>' AND <%ruangsi%>='<|ruangsi|>'",
			
			"<%astable%>.<%tahunaksi%>='<|tahunaksi|>' AND <%astable%>.<%statussi%>='<|statussi|>'",
			"<%astable%>.<%tahunaksi%>='<|tahunaksi|>' AND <%astable%>.<%statussi%>='<|statussi|>' AND <%astable%>.<%ruangsi%>='<|ruangsi|>'",
			"<%astable%>.<%statussi%>='<|statussi|>' AND <%astable%>.<%ruangsi%>='<|ruangsi|>'",
			"<%astable%>.<%tahunaksi%>='<|tahunaksi|>' AND <%astable%>.<%statussi%>='<|statussi|>' AND <%astable%>.<%dataprosesdsi%>='<|dataprosesdsi|>'",
			"<%astable%>.<%tahunaksi%>='<|tahunaksi|>' AND <%astable%>.<%statussi%>='<|statussi|>'",
			"<%astable%>.<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%astable%>.<%mahasiswasi%>='<|mahasiswasi|>' AND <%astable%>.<%statussi%>='<|statussi|>'",
			"<%astable%>.<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%astable%>.<%mahasiswasi%>='<|mahasiswasi|>'",
			"<%astable%>.<%tahunaksi%> LIKE '<|tahunaksi|>%' AND <%astable%>.<%nilaisi%><<|nilaisi|> AND <%astable%>.<%statussi%>='<|statussi|>'",
			
		);
		$this->tempCodeOfWhere = array(
			"identifiedsi" => array(
				'kode' => "<%identifiedsi%>",
				'value' => "<|identifiedsi|>"
			),
			"tahunaksi" => array(
				'kode' => "<%tahunaksi%>",
				'value' => "<|tahunaksi|>"
			),
			"mahasiswasi" => array(
				'kode' => "<%mahasiswasi%>",
				'value' => "<|mahasiswasi|>"
			),
			"fujddsi" => array(
				'kode' => "<%fujddsi%>",
				'value' => "<|fujddsi|>"
			),
			"fujdtsi" => array(
				'kode' => "<%fujdtsi%>",
				'value' => "<|fujdtsi|>"
			),
			"fujdlsi" => array(
				'kode' => "<%fujdlsi%>",
				'value' => "<|fujdlsi|>"
			),
			"statussi" => array(
				'kode' => "<%statussi%>",
				'value' => "<|statussi|>"
			),
			"toeflsi" => array(
				'kode' => "<%toeflsi%>",
				'value' => "<|toeflsi|>"
			),
			"fujdpsi" => array(
				'kode' => "<%fujdpsi%>",
				'value' => "<|fujdpsi|>"
			),
			"fujdssi" => array(
				'kode' => "<%fujdssi%>",
				'value' => "<|fujdssi|>"
			),
			"dataprosesssi" => array(
				'kode' => "<%dataprosesssi%>",
				'value' => "<|dataprosesssi|>"
			),
			"dataprosesdsi" => array(
				'kode' => "<%dataprosesdsi%>",
				'value' => "<|dataprosesdsi|>"
			),
			"waktuendsi" => array(
				'kode' => "<%waktuendsi%>",
				'value' => "<|waktuendsi|>"
			),
			"waktusi" => array(
				'kode' => "<%waktusi%>",
				'value' => "<|waktusi|>"
			),
			"ruangsi" => array(
				'kode' => "<%ruangsi%>",
				'value' => "<|ruangsi|>"
			),
			"nilaisi" => array(
				'kode' => "<%nilaisi%>",
				'value' => "<|nilaisi|>"
			),
			"namatranskripsi" => array(
				'kode' => "<%namatranskripsi%>",
				'value' => "<|namatranskripsi|>"
			),
			"rekomendasisi" => array(
				'kode' => "<%rekomendasisi%>",
				'value' => "<|rekomendasisi|>"
			),
			"dosenssi" => array(
				'kode' => "<%dosenssi%>",
				'value' => "<|dosenssi|>"
			),
			"dosendsi" => array(
				'kode' => "<%dosendsi%>",
				'value' => "<|dosendsi|>"
			),
			"dosentsi" => array(
				'kode' => "<%dosentsi%>",
				'value' => "<|dosentsi|>"
			),
			"namakrssi" => array(
				'kode' => "<%namakrssi%>",
				'value' => "<|namakrssi|>"
			),
			"karbimsi" => array(
				'kode' => "<%karbimsi%>",
				'value' => "<|karbimsi|>"
			),
			"kosurunsi" => array(
				'kode' => "<%kosurunsi%>",
				'value' => "<|kosurunsi|>"
			),
			"kosurtugsi" => array(
				'kode' => "<%kosurtugsi%>",
				'value' => "<|kosurtugsi|>"
			)
		);
	}
	public function resetValue(){
		parent::resetValue();
	}
	public function getTahunAk(){ return $this->getData('tahunaksi'); }
	public function getIdentified(){ return $this->getData('identifiedsi'); }
	public function getFujDL(){ return $this->getData('fujdlsi'); }
	public function getFujDT(){ return $this->getData('fujdtsi'); }
	public function getMahasiswa(){ return $this->getData('mahasiswasi'); }
	public function getStatus(){ return $this->getData('statussi'); }
	public function getFujDD(){ return $this->getData('fujddsi'); }
	public function getFujDP(){ return $this->getData('fujdpsi'); }
	public function getFujDS(){ return $this->getData('fujdssi'); }
	public function getToefl(){ return $this->getData('toeflsi'); }
	public function getDataProsesS(){ return $this->getData('dataprosesssi'); }
	public function getDataProsesD(){ return $this->getData('dataprosesdsi'); }
	public function getWaktu(){ return $this->getData('waktusi'); }
	public function getWaktuEnd(){ return $this->getData('waktuendsi'); }
	public function getRuang(){ return $this->getData('ruangsi'); }
	public function getNilai(){ return $this->getData('nilaisi'); }
	public function getNamaTranskrip(){ return $this->getData('namatranskripsi'); }
	public function getRekomendasi(){ return $this->getData('rekomendasisi'); }
	public function getDosenS(){ return $this->getData('dosenssi'); }
	public function getDosenD(){ return $this->getData('dosendsi'); }
	public function getDosenT(){ return $this->getData('dosentsi'); }
	public function getNamaKRS(){ return $this->getData('namakrssi'); }
	public function getKarBim(){ return $this->getData('karbimsi'); }
	public function getNoSuratUndangan(){ return $this->getData('kosurunsi'); }
	public function getNoSuratTugas(){ return $this->getData('kosurtugsi'); }
	
	public function setNoSuratUndangan($tempData,$tempAsWhere = false){
		return $this->setData('kosurunsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNoSuratTugas($tempData,$tempAsWhere = false){
		return $this->setData('kosurtugsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setIdentified($tempData,$tempAsWhere = false){
		return $this->setData('identifiedsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setTahunAk($tempData,$tempAsWhere = false){
		return $this->setData('tahunaksi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setStatus($tempData,$tempAsWhere = false){
		return $this->setData('statussi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujDL($tempData,$tempAsWhere = false){
		return $this->setData('fujdlsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujDT($tempData,$tempAsWhere = false){
		return $this->setData('fujdtsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setMahasiswa($tempData,$tempAsWhere = false){
		return $this->setData('mahasiswasi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujDD($tempData,$tempAsWhere = false){
		return $this->setData('fujddsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujDP($tempData,$tempAsWhere = false){
		return $this->setData('fujdpsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setFujDS($tempData,$tempAsWhere = false){
		return $this->setData('fujdssi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setToefl($tempData,$tempAsWhere = false){
		return $this->setData('toeflsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDataProsesS($tempData,$tempAsWhere = false){
		return $this->setData('dataprosesssi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDataProsesD($tempData,$tempAsWhere = false){
		return $this->setData('dataprosesdsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setWaktuEnd($tempData,$tempAsWhere = false){
		return $this->setData('waktuendsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setWaktu($tempData,$tempAsWhere = false){
		return $this->setData('waktusi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRuang($tempData,$tempAsWhere = false){
		return $this->setData('ruangsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNilai($tempData,$tempAsWhere = false){
		return $this->setData('nilaisi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaTranskrip($tempData,$tempAsWhere = false){
		return $this->setData('namatranskripsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setRekomendasi($tempData,$tempAsWhere = false){
		return $this->setData('rekomendasisi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenS($tempData,$tempAsWhere = false){
		return $this->setData('dosenssi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenD($tempData,$tempAsWhere = false){
		return $this->setData('dosendsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setDosenT($tempData,$tempAsWhere = false){
		return $this->setData('dosentsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setNamaKRS($tempData,$tempAsWhere = false){
		return $this->setData('namakrssi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
	public function setKarBim($tempData,$tempAsWhere = false){
		return $this->setData('karbimsi',$tempData,$tempAsWhere,function($x,$tempResult){
			/*
			Your Code to Filter
			*/
			return $tempResult;
		});
	}
}