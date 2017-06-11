<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include "DosbingObjectDBModel.php";
class MultipleDBModel extends CoreObject{
	protected $listTable;
	public function __CONSTRUCT(){
		$this->resetValue();
		$this->tempDataArrayWhere = array(
			"",
		);
		$this->tempDataArrayCase = array(
			"*",
			"* FROM (SELECT *",
		);
		$this->tempDataArrayCaseChoose = 0;
		$this->tempDataArraySendRequest = null;
		$this->resetSendRequest();
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
			if($tempResult != " AND ")
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
	public function getNextCursor(){
		/* var_dump($this->tempDataArraySendRequest[0]);
		exit();   */
		if(is_array($this->tempDataArraySendRequest)){
			if(array_key_exists($this->tempDataArrayIndexSendRequest, $this->tempDataArraySendRequest)){
				$max = count($this->listTable);
				for($i=0;$i<$max;$i++){
					$this->listTable[$i]->resetValue();
					$this->listTable[$i]->resetSendRequest();
					/* var_dump($this->buildingArrayAutomaSetContent($this->tempDataArraySendRequest[$this->tempDataArrayIndexSendRequest],$this->listTable[$i]->getCodeOfWhere()));
					exit();  */
					$this->listTable[$i]->automaSetContent($this->buildingArrayAutomaSetContent($this->tempDataArraySendRequest[$this->tempDataArrayIndexSendRequest],$this->listTable[$i]->getCodeOfWhere()));
				}
				$this->tempDataArrayIndexSendRequest += 1;
				return $this->getSuccessResult();
			}else{
				return $this->getFailedResult();
			}
		}else{
			return $this->getFailedResult();
		}
	}
	protected function buildingArrayAutomaSetContent($source, $template){
		
		$result = array();
		foreach($template as $key=>$value){
			$result[$key] = $source[$key];
		}
		/* var_dump($result);
		//exit; */
		return $result;
	}
	public function resetValue(){
		
	}
	public function resetListTable(){
		$this->listTable = array();
	}
	public function addTable(ObjectDBModel $tempObjectDBModel){
		$this->listTable[count($this->listTable)] = $tempObjectDBModel;
	}
	protected function buildNewWhere(){
		if(count($listTable) < 2) return false;
		for($i = 0; $i < count($listTable);$i++){
			
		}
	}
	public function getTableStack($index){
		$index = intval($index);
		if(!array_key_exists($index, $this->listTable)) return null;
		$temp = $this->listTable[$index];
		return $temp;
	}
	protected function getSuccessResult(){ return true; }
	protected function getFailedResult(){ return false; }
}