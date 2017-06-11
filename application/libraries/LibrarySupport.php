<?php
if(!defined('BASEURL_REDIRECT'))
	define('BASEURL_REDIRECT',"http://www.google.com/");
if(!defined('BASEPATH')) header("location:".BASEURL_REDIRECT);
if(!defined('APPPATH')) header("location:".BASEURL_REDIRECT);
require_once APPPATH."libraries/Datejaservfilter.php";
require_once APPPATH."libraries/Inputjaservfilter.php";
require_once APPPATH."libraries/Librarian.php";
defined('BASEPATH') OR exit('What Are You Looking For ?');
class LibrarySupport extends Librarian{
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->typeSCode = array(
		array(
			"50SIKTA67",
			"+",
			"-",
			"#",
			"?",
			"/"
		),
		array(
			"78SIKTA39",
			"(",
			"(",
			")",
			")",
			"/"
		),
		array(
			"@4SIKTA#7",
			"+",
			"?",
			"#",
			"-",
			"/"
		)
	);
	}
	protected $typeSCode;
	protected function filterIdentified($tempId = ""){
		if($tempId == '' || $tempId == ' ') return false;
		if($tempId[0] != 'A'){ //admin
			if($tempId[0] != 'K'){ //koordinator
				if($tempId[0] != 'D'){ //dosen
					if($tempId[0] != 'M'){ // mahasiswa
						if($tempId[0] != 'E'){ //event
							if($tempId[0] != 'U'){ //file koordinator
								if($tempId[0] != 'R'){ //registrasi
									if($tempId[0] != 'S'){ //Seminar
										if($tempId[0] != 'Z'){ //sidang
											if($tempId[0] != 'C'){ //acara
												return false;
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$tempId = substr($tempId,1,strlen($tempId)-1);
		$max = count($this->typeSCode);
		for($i=0;$i<$max;$i++){
			$tempId = str_ireplace($this->typeSCode[$i][0],"",$tempId);
			if(strlen($tempId) == 30){
				$tempId[4] = "-";
				$tempId[7] = "-";
				$tempId[10] = " ";
				$tempId[13] = ":";
				$tempId[16] = ":";
				$tempId = explode("$",$tempId);
				break;
			}
		}
		if(count($tempId) != 2) return false;
		if(number_format(floatval($tempId[1]),8)."" != $tempId[1]."") return false;
		if((new Datejaservfilter())->nice_date($tempId[0],"Y-m-d H:i:s") == 'Invalid Date') return false;
		
		return true;
	}
	function generateIdentified($kode=null, $type=0){
		if(is_null($kode))return false;
		$type = intval($type);
		$max = count($this->typeSCode);
		if($type < 0 || $type >= $max) $type = 0;
		$date1 = explode(" ",microtime())[0];
		$date2 = date("Y-m-d H:i:s");
		$result = $kode."".$this->typeSCode[$type][0];
		$date2[4] = $this->typeSCode[$type][1];
		$date2[7] = $this->typeSCode[$type][2];
		$date2[10] = $this->typeSCode[$type][3];
		$date2[13] = $this->typeSCode[$type][4];
		$date2[16] = $this->typeSCode[$type][5];
		return $result.$date2."$".$date1;
	}
	protected function setCategoryPrintMessage($cat,$status,$message){if($cat==0){if($status){echo "1".$message;return ;}else{echo "0".$message;	return ;}}else{	return array($status,$message);}}
}

class tempObject {
	
}