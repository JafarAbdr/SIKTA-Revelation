<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."models/CoreObject.php";
//require_once APPPATH."models/ObjectRedis.php";
require_once APPPATH."models/ObjectDB/ObjectDBModel/ObjectDBModel.php";
//require_once APPPATH."models/ObjectDBR/ObjectDBRModel/ObjectDBRModel.php";
require_once APPPATH."models/ControlModel/ControlModel.php";
class GateControlModel extends CI_Model{
	protected $tempDB;
	protected $tempObjectRedis;
	public function __CONSTRUCT($db = null,$loadDBDefault = true){
		parent::__construct();
		if(is_null($db)){
			if($loadDBDefault){			
				$this->load->database();	
				$this->tempDB = $this->db;
				$this->db = null;	
			}
		}
		else{
			$db = 'mysqli://root:@localhost/'.$db;
			$this->tempDB = $this->load->database($db);
		}
		$this->tempObjectRedis = null;
	}
	public function loadObjectDB($tempData = null){
		if(is_null($tempData)) return null;
		if(!is_string($tempData)) return null;
		if(file_exists(APPPATH."models/ObjectDB/".$tempData."ObjectDBModel.php")){
			require_once APPPATH."models/ObjectDB/".$tempData."ObjectDBModel.php";
			$tempData = $tempData."ObjectDBModel";
			return new $tempData();
		}else if(file_exists(APPPATH."models/ObjectDB/ObjectDBModel/".$tempData."DBModel.php")){
			require_once APPPATH."models/ObjectDB/ObjectDBModel/".$tempData."DBModel.php";
			$tempData = $tempData."DBModel";
			return new $tempData();
		}else{
			return null;
		}
	}
	//public function executeObjectDB(ObjectDBModel $tempObjectDBModel){
	public function executeObjectDB($tempObjectDBModel){
		return new ControlModel($this->tempDB, $tempObjectDBModel);
	}
}