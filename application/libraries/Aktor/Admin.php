<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Aktor/Jabatan.php";
class Admin extends Jabatan{
	public function __CONSTRUCT(Inputjaservfilter $tempInputJaservFilter = null){
		parent::__CONSTRUCT();
		$this->levelCode = 'A';
		$this->inputJaservFilter = $tempInputJaservFilter;
	}
}