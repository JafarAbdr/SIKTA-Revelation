<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."models/ObjectDB/DetailIdentified.php";
class RuangObjectDBModel extends DetailIdentified {
	public function __construct(){
		parent::__construct();
		$this->tempTableName = 'ruang';
	}
}