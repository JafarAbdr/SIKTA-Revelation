<?php
class ce52be6c2416624adf15d1782ed729b1 {
	private $dataArray;
	function addKode($key,$value){
		$this->dataArray[$key] = $value;
	}
	function show($id=null){
		echo "<table style='text-align : center;'>";
		echo "<thead><tr><td style='border : 2px solid black; width : 50px;'>no</td><td style='border : 2px solid black;width : 250px;'>kode</td><td style='border : 2px solid black;width : 800px;'>deskripsi</td></tr></thead><tbody>";
		$i = 1;
		if(is_array($this->dataArray)){
			foreach($this->dataArray as $key => $value){
				if(is_null($id) || !is_bool(strpos(strtolower($key),strtolower($id)))){
					echo $this->getRow($i, $key, $value);
					$i++;
				}
			}
		}
		if($i==1) echo "<tr><td style='border : 2px solid black'>-</td><td style='border : 2px solid black'>-</td><td style='border : 2px solid black'>-</td></tr>";
		echo "</tbody></table>";
	}
	private function getRow($num,$key,$value){
		return "<tr><td style='border : 2px solid black'>".$num."</td><td style='border : 2px solid black'>".$key."</td><td style='border : 2px solid black'>".$value."</td></tr>";
	}
}
$varce52be6c2416624adf15d1782ed729b1 = new ce52be6c2416624adf15d1782ed729b1();