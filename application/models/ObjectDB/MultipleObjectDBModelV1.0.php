<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include "DosbingObjectDBModel.php";
class MultipleObjectDBModel{
	protected $listTable;
	protected $tempDataArrayWhere;
	protected $tempDataArraySendRequest;
	protected $tempDataArrayIndexSendRequest;
	public function __CONSTRUCT(){
		$this->resetValue();
		$this->tempDataArrayWhere = array(
			"",
		);
		$this->tempDataArraySendRequest = null;
		$this->resetSendRequest();
	}
	public function resetValue(){
		$listTable = array();
	}
	public function addTable(ObjectDBModel $tempObjectDBModel){
		$this->listTable[count($this->listTable)] = $tempObjectDBModel;
	}
	protected function buildNewWhere(){
		if(count($listTable) < 2) return false;
		for($i = 0; $i < count($listTable);$i++){
			
		}
	}
	public function getCaseData(){
		return "*";
	}
	public function setCaseData($tempData = NULL){
		
	}
	public function getTableName(){
		if(count($this->listTable) < 2) return "";
		$result="";
		for($i = 0; $i < count($this->listTable);$i++){
			$result .= $this->listTable[$i]->getTableName()." as table".($i+1).",";
		}
		return substr($result,0,strlen($result)-1);
	}
	public function getWhere(){
		if(count($this->listTable) < 2) return "";
		$result="";
		$resultMultiple = $this->listTable[0]->getWhereMultiple();
		$resultMultiple = str_ireplace("<%astablem%>", "table1", $resultMultiple);
		for($i = 0; $i < count($this->listTable);$i++){
			$tempResult = $this->listTable[$i]->getWhere()." AND ";
			$tempResult = str_ireplace("<%astable%>", "table".($i+1)."", $tempResult);
			$result .= $tempResult;
			if($i != 0){
				$resultMultiple = str_ireplace("<%astable".$i."%>", "table".($i+1)."", $resultMultiple);
				$resultMultiple = str_ireplace("<%table".$i."primary%>", $this->listTable[$i]->getPrimaryKey(), $resultMultiple);
			}
		}
		if($resultMultiple != "")
			return $result."".$resultMultiple;
		else
			return substr($result,0,strlen($result)-4);
	}
	public function setWhere($tempData = NULL){
		
	}
	
	public function resetSendRequest(){
		$this->tempDataArrayIndexSendRequest = 0;
	}
	public function setNewSendRequest($tempDataArray){
		if(!is_array($tempDataArray)) return $this->getFailedResult();
		$max = count($this->listTable);
		for($i=0;$i<$max;$i++){
			$this->listTable[$i]->resetValue();
			$this->listTable[$i]->resetSendRequest();
			$this->listTable[$i]->setNewSendRequest($tempDataArray);
		}
		return $this->getSuccessResult();
	}
	public function getNextCursor(){
		$max = count($this->listTable);
		$j = 0;
		for($i=0;$i<$max;$i++){
			if($this->listTable[$i]->getNextCursor()) $j += 1;
		}
		if($j == $max)
			return $this->getSuccessResult();
		else
			return $this->getFailedResult();
	}
	public function getTableStack(){
		$temp = $this->listTable;
		return $temp;
	}
	protected function getSuccessResult(){ return true; }
	protected function getFailedResult(){ return false; }
}