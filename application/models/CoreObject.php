<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CoreObject {
	protected $tempDataArraySendRequest;
	protected $tempDataArrayIndexSendRequest;
	protected $tempDataArrayCase;
	protected $tempDataArrayCaseChoose;
	protected function getSuccessResult(){ return true; }
	protected function getFailedResult(){ return false; }
	
	public function resetSendRequest(){
		$this->tempDataArrayIndexSendRequest = 0;
	}
	public function setNewSendRequest($tempDataArray){
		if(!is_array($tempDataArray)) return $this->getFailedResult();
		$this->resetValue();
		$this->tempDataArraySendRequest = $tempDataArray;
		$this->tempDataArrayIndexSendRequest = 0;
		return $this->getSuccessResult();
	}
	public function getCountData(){
		if(is_null($this->tempDataArraySendRequest)) return 0;
		else return count($this->tempDataArraySendRequest);
	}
	public function setCaseData($tempData = null){
		if(is_null($tempData)) return $this->getFailedResult();
		$tempData = intval($tempData);
		if(!array_key_exists($tempData,$this->tempDataArrayCase)) return $this->getFailedResult();
		$this->tempDataArrayCaseChoose = $tempData;
		return $this->getSuccessResult();
	}
	public function getCaseData(){
		$tempResult = $this->tempDataArrayCase[$this->tempDataArrayCaseChoose];
		return $tempResult;
	}
}