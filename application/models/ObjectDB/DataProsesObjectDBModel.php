<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."models/ObjectDB/DetailIdentified.php";
class DataProsesObjectDBModel extends DetailIdentified {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'dataproses';
	}
}