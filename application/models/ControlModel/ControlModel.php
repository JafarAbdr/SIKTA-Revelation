<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ControlModel{
	protected $tempObjectDBModel;
	public function __CONSTRUCT($db, $tempObjectDBModel){
	//public function __CONSTRUCT($db,ObjectDBModel $tempObjectDBModel){
		//parent::__construct();
		$this->db = $db;
		$this->tempObjectDBModel = $tempObjectDBModel;
	}
	public function updateData($tempObjectDBModel=null){
		if($this->tempObjectDBModel->getQueryBuilder() == null){return $this->getFailedResult();}
		//if($this->tempObjectDBModel->getArrayBuilder() == null){return $this->getFailedResult();}
		//if(!$this->tempObjectDBModel->isPrimaryNotnull()){return $this->getFailedResult();}
		if(is_null($tempObjectDBModel))
			return $this->setUpdate($this->tempObjectDBModel->getQueryBuilder() ,$this->tempObjectDBModel->getWhere());
		else
			return $this->setUpdate($this->tempObjectDBModel->getQueryBuilder() ,$tempObjectDBModel->getWhere());
	}
	public function deleteData(){
		if($this->tempObjectDBModel->getArrayBuilder() == null){return $this->getFailedResult();}
		if(!$this->tempObjectDBModel->isPrimaryNotnull()){return $this->getFailedResult();}
		return $this->setDelete($this->tempObjectDBModel->getWhere());
	}
	public function addData(){
		if($this->tempObjectDBModel->getArrayBuilder() == null){return $this->getFailedResult();}
		if(!$this->tempObjectDBModel->isPrimaryNotnull()){return $this->getFailedResult();}
		//var_dump($this->tempObjectDBModel->getArrayBuilder());
		//exit('helo');
		return $this->setInsert($this->tempObjectDBModel->getArrayBuilder());
	}
	public function takeData(){
		$this->tempObjectDBModel->setNewSendRequest($this->setQuery($this->tempObjectDBModel->getCaseData(),$this->tempObjectDBModel->getWhere())->result_array());
		return $this->tempObjectDBModel;
	}
	//Operation Internal
	private function setQuery($select='*',$where=""){
		//echo "<br>".$this->tempObjectDBModel->getCaseData()."<br>".$this->tempObjectDBModel->getWhere()."<br>";
		
		$query="SELECT ".$select." FROM ".$this->tempObjectDBModel->getTableName();
		
		if($where!="")
			$query=$query." WHERE ".$where;
		//echo $query."<br>";
		return $this->db->query($query);
	}
	private function setInsert($data){
		return $this->db->insert($this->tempObjectDBModel->getTableName(),$data);
	}
	private function setUpdate($set="",$where=""){
		$query="UPDATE `".$this->tempObjectDBModel->getTableName()."` SET ".$set;
		if($where!="")
			$query=$query." WHERE ".$where;
		//exit("0".$query."");
		return $this->db->query($query);
	}
	private function setDelete($where = ''){
		$query="DELETE FROM `".$this->tempObjectDBModel->getTableName()."`";
		if($where!="")
			$query=$query." WHERE ".$where;
		return $this->db->query($query);
	}
	protected function getSuccessResult(){ return true; }
	protected function getFailedResult(){ return false;	}
}