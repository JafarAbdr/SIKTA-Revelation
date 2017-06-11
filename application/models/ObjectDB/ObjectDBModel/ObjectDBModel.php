<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ObjectDBModel extends CoreObject{
	//methode
	protected $tempTableName;
	protected $tempDataArray;
	protected $tempDataArrayIndexPrimary;
	protected $tempDataArrayIndexPrefix;
	protected $tempDataArrayWhere;
	protected $tempDataArrayWhereMultiple;
	protected $tempDataArrayWhereChoose;
	protected $tempDataArrayWhereMultipleChoose;
	protected $tempCodeOfWhere;
	//function
	public function __CONSTRUCT(){
		$this->tempTableName = null;
		$this->resetValue();
		$this->tempDataArrayIndexPrimary = null;
		$this->tempDataArrayIndexPrefix="";
		$this->tempDataArrayCase = array(
			"*"
		);
		
		$this->setCaseData(0);
		$this->tempDataArrayWhere = array(
			""
		);
		$this->tempDataArrayWhereMultiple = array(
			""
		);
		$this->setWhere(0);
		$this->setWhereMultiple(0);
		$this->tempCodeOfWhere = null;
		$this->tempDataArraySendRequest = null;
		$this->resetSendRequest();
	}
	public function resetValue(){
		$this->tempDataArray = null;
	}
	public function resetPrefix(){
		$this->tempDataArrayIndexPrefix="";
		$this->resetValue();
	}
	public function getTableName(){
		$tempResult = $this->tempTableName;
		return $tempResult;
	}
	public function getCodeOfWhere(){
		$temp = $this->tempCodeOfWhere;
		return $temp;
	}
	//-iterate next cursor
	public function getNextCursor(){
		if(is_array($this->tempDataArraySendRequest)){
			if(array_key_exists($this->tempDataArrayIndexSendRequest, $this->tempDataArraySendRequest)){
				$this->automaSetContent($this->tempDataArraySendRequest[$this->tempDataArrayIndexSendRequest]);
				$this->tempDataArrayIndexSendRequest += 1;
				return $this->getSuccessResult();
			}else{
				return $this->getFailedResult();
			}
		}else{
			return $this->getFailedResult();
		}
	}
	public function automaSetContent($tempArray){
		$this->resetValue();
		$this->countArray = count($tempArray);
		if($this->countArray <= 0){ return $this->getFailedResult();}
		foreach($tempArray as $tempIndexArray => $tempValue){
			$this->tempDataArray[$tempIndexArray]['value'] = $tempValue;
			if($this->isOneOfKeyPrimary($tempIndexArray))
				$this->tempDataArray[$tempIndexArray]['asWhere'] = true;
			else
				$this->tempDataArray[$tempIndexArray]['asWhere'] = false;
		}
		return $this->getSuccessResult();
	}
	protected function isOneOfKeyPrimary($tempPrimary){
		foreach($this->tempDataArrayIndexPrimary as $tempValue){
			if($tempValue == $tempPrimary){
				return true;
			}
		}
		return false;
	}
	public function isPrimaryNotNull(){
		$tempResult = $this->getSuccessResult();
		foreach($this->tempDataArrayIndexPrimary as $tempValue){
			if(!array_key_exists($tempValue,$this->tempDataArray)){
				$tempResult = $this->getFailedResult();
			}
		}
		return $tempResult;
	}
	/*
	
	*/
	protected function getData($tempIndex){
		$tempResult = null;
		if(is_null($this->tempDataArray)) return null;
		if(array_key_exists($tempIndex,$this->tempDataArray)){
			$tempResult = $this->tempDataArray[$this->tempDataArrayIndexPrefix."".$tempIndex]['value'];
		}
		return $tempResult;
	}
	protected function setData($tempIndex,$tempValue, $tempAsWhere=false,$functionFilter = false){
		$tempResult = $this->getFailedResult(); 
		if(is_bool($functionFilter)) return $tempResult;
		if($functionFilter($tempValue,$this->getSuccessResult())){
			$this->tempDataArray[$tempIndex]['value'] = $tempValue;
			if(!is_bool($tempAsWhere)) $tempAsWhere = false;
			$this->tempDataArray[$tempIndex]['asWhere'] = $tempAsWhere;
			$tempResult = $this->getSuccessResult();
		}
		return $tempResult;
	}
	public function getQueryBuilder(){
		$tempQuery = "";
		if(is_null($this->tempDataArray)) return null;
		foreach($this->tempDataArray as $tempIndex => $tempValue){
			$tempQuery .= $tempIndex."='".$tempValue['value']."',";
		}
		if($tempQuery != "")
			return substr($tempQuery,0,strlen($tempQuery)-1);
		else
			return null;
	}
	public function getArrayBuilder(){
		$tempQuery = null;
		if(is_null($this->tempDataArray)) return null;
		foreach($this->tempDataArray as $tempIndex => $tempValue){
			$tempQuery[$tempIndex] = $tempValue['value'];
		}
		if(count($tempQuery) > 0)
			return $tempQuery;
		else
			return null;
	}
	
	protected function automaGetWhereBuilder($string){
		
		//if(is_null($this->tempDataArray)) return "";
		if(is_array($this->tempDataArray) && count($this->tempDataArray)>0){
			foreach($this->tempDataArray as $tempIndex => $tempValue){
				if($tempValue['asWhere']){
					$string = str_ireplace($this->tempCodeOfWhere[$tempIndex]['kode'], $tempIndex, $string);
					$string = str_ireplace($this->tempCodeOfWhere[$tempIndex]['value'], $tempValue['value'], $string);
				}
			}
		}
		
		return $string;
	}
	public function getPrimaryKey(){
		return $this->tempDataArrayIndexPrimary[0];
	}
	public function setWhere($tempData = null){
		if(is_null($tempData)) return $this->getFailedResult();
		$tempData = intval($tempData);
		if(!array_key_exists($tempData,$this->tempDataArrayWhere)) return $this->getFailedResult();
		$this->tempDataArrayWhereChoose = $tempData;
		return $this->getSuccessResult();
	}
	public function getWhere(){
		if($this->tempDataArrayWhereChoose == 0){
			return $this->tempDataArrayWhere[$this->tempDataArrayWhereChoose];	
		}
		else{
			return $this->automaGetWhereBuilder($this->tempDataArrayWhere[$this->tempDataArrayWhereChoose]);	
		}
	}
	public function setWhereMultiple($tempData = null){
		if(is_null($tempData)) return $this->getFailedResult();
		$tempData = intval($tempData);
		if(!array_key_exists($tempData,$this->tempDataArrayWhereMultiple)) return $this->getFailedResult();
		$this->tempDataArrayWhereMultipleChoose = $tempData;
		return $this->getSuccessResult();
	}
	public function getWhereMultiple(){
		return $this->tempDataArrayWhereMultiple[$this->tempDataArrayWhereMultipleChoose];	
	}
}