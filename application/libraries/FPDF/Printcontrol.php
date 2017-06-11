<?php
    //echo "hello<br>";
include("MPDF/mpdf.php");

class Printcontrol {
    public function __CONSTRUCT(){
        $this->mpdf = new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
        $this->mpdf->debug = TRUE;
    }
    /*
    printFUJ input Array (
    "namaPeserta"=>"",
    "nimPeserta"=>"",
    "judulTAPeserta"=>"",
    "hariTanggal"=>"",
    "jam"=>"",
    "tempat"=>"",
    "ketua"=>"",
    "sekertaris"=>"",
    "moderator"=>"",
    "comoderator"=>"",
    "tanggalTerbit"=>"",
    "namaDosen"=>"",
    "nip"=>""
    );
    */
	 public function printUndanganTAD($TEMP_ARRAY){
       $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
		if(array_key_exists('pengujiE',$TEMP_ARRAY))
			$TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/undanganSeminarTADTester.html");
		else
			$TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/undanganSeminarTAD.html");
		$TEMP_HTML = str_ireplace("@GambarUNDIPSymbol;",base_url()."temp_picture_fpdf/UNDIP_SYMBOL.png",$TEMP_HTML);		
		$TEMP_HTML = str_ireplace("@GambarLineS;",base_url()."temp_picture_fpdf/LINES_STRIPS.png",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarLine;",base_url()."temp_picture_fpdf/LINES_STRIP.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
			if($key == "judulTAPeserta"){
				$value2 = $value."";
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=69;
                    if(strlen($word) > 69){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=69;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                        $varRest.='<br><span style="white-space: pre-line; color: rgba(255,255,255,0);"><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>Judul _ s_........: </span><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>'.$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.='<br><span style="white-space: pre-line; color: rgba(255,255,255,0);"><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>Judul _ s_........: </span><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>'.substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest."";
				
				$varRest = "";
				$first=TRUE;
				$word = $value2;
				for(;;){
					$hoho=FALSE;
					$i=67;
					if(strlen($word) > 67){
						for(;$word[$i] != " ";){
							$i--;
							if($i == 0){
								$i=67;
								break;
							}
						}
					}else{
						if($first){
							$varRest.=$word;   
							$first=FALSE;
						}else{
						$varRest.='<br><span style="white-space: pre-line; color: rgba(255,255,255,0);"><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>Judul _ s_........: </span><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>'.$word;  
						}
						$hoho=TRUE;
					}
					if($hoho)
					break;
					if($first){
						$varRest.=substr($word,0,$i);   
						$first=FALSE;
					}else{
						$varRest.='<br><span style="white-space: pre-line; color: rgba(255,255,255,0);"><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>Judul _ s_........: </span><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>'.substr($word,0,$i);   
					}
					$word = substr($word,$i+1,strlen($word)-($i+1));
				}
				$value2=$varRest;
				$TEMP_HTML = str_ireplace("@judulTAPesertaD;",$value2,$TEMP_HTML);
            }
			if($key == "kodeDosenYangDituju"){
				$key = "dosenYangDituju";
				switch($value){
					case 1 :
					case '1':
					$value = $TEMP_ARRAY['pengujiS'];
					break;
					case 2 :
					case '2':
					$value = $TEMP_ARRAY['pengujiD'];
					break;
					case 3 :
					case '3':
					$value = $TEMP_ARRAY['pengujiT'];
					break;
					case 4 :
					case '4':
					$value = $TEMP_ARRAY['pengujiE'];
					break;
				}
			}
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        //echo $TEMP_HTML;
        $this->mpdf->Output();
    }
	 public function printUndanganTAS($TEMP_ARRAY){
       $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
		$TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/undanganSeminarTAS.html");
		$TEMP_HTML = str_ireplace("@GambarUNDIPSymbol;",base_url()."temp_picture_fpdf/UNDIP_SYMBOL.png",$TEMP_HTML);		
		$TEMP_HTML = str_ireplace("@GambarLineS;",base_url()."temp_picture_fpdf/LINES_STRIPS.png",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarLine;",base_url()."temp_picture_fpdf/LINES_STRIP.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
			 if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=69;
                    if(strlen($word) > 69){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=69;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                        $varRest.='<br><span style="white-space: pre-line; color: rgba(255,255,255,0);"><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>Judul _ s_........: </span><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>'.$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.='<br><span style="white-space: pre-line; color: rgba(255,255,255,0);"><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>Judul _ s_........: </span><span style="white-space: pre-line; color: rgba(255,255,255,0);">..</span>'.substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        //echo $TEMP_HTML;
        $this->mpdf->Output();
    }
    public function printFUJ22($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        if($TEMP_ARRAY['sekertariss'] == "*")
            $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ22.html");
        else
            $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ22Tester.html");
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ22.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=68;
                    if(strlen($word) > 68){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=68;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        $this->mpdf->Output();
    }
    
    public function printFUJ12($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ12.html");
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ12.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=68;
                    if(strlen($word) > 68){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=68;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        $this->mpdf->Output();
    }
    public function printFUJ20($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ20.html");
		$TEMP_HTML = str_ireplace("@GambarUNDIPSymbol;",base_url()."temp_picture_fpdf/UNDIP_SYMBOL.png",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarLine;",base_url()."temp_picture_fpdf/LINES_STRIP.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        //echo $TEMP_HTML;
        $this->mpdf->Output();
    }
    public function printFUJ21($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ21.html");
		//$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."Filesupport/getPictureFUJSupport/FUJ21.aspx",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ21.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=68;
                    if(strlen($word) > 68){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=68;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        $this->mpdf->Output();
    }
    public function printFUJ11($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ11.html");
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ11.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=68;
                    if(strlen($word) > 68){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=68;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>_._._._._._._.__._</span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        $this->mpdf->Output();
    }
    public function printFUJ23($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        if($TEMP_ARRAY['sekertariss'] == "*")
            $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ23.html");
        else
            $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ23Tester.html");
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ23.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=57;
                    if(strlen($word) > 57){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=57;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                            $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>Judul Tugas Akhir_______._: </span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>Judul Tugas Akhir_______._: </span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        $this->mpdf->Output();
    }
    public function printFUJ13($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ13.html");
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ13.png",$TEMP_HTML);
        foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=57;
                    if(strlen($word) > 57){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=57;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                            $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>Judul Tugas Akhir_______._: </span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>Judul Tugas Akhir_______._: </span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        $this->mpdf->Output();
    }
     public function printFUJ25($TEMP_ARRAY){
        $this->mpdf->SetDisplayMode("fullpage");
        $this->mpdf->list_indent_first_level = 0;
        $TEMP_HTML = '';
        if($TEMP_ARRAY['sekertariss'] == "*")
            $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ25.html");
        else
            $TEMP_HTML = file_get_contents(APPPATH."libraries/FPDF/FUJ25Tester.html");
		$TEMP_HTML = str_ireplace("@GambarFUJ;",base_url()."temp_picture_fpdf/FUJ25.png",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarCHECK;",base_url()."temp_picture_fpdf/CHECKLISH.png",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarSQUARE;",base_url()."temp_picture_fpdf/SQUARE.png",$TEMP_HTML);
		$TEMP_HTML = str_ireplace("@GambarFUJ25Table;",base_url()."temp_picture_fpdf/TABLE_PICTURE_FUJ25.png",$TEMP_HTML);
         foreach($TEMP_ARRAY as $key=>$value){
            if($key == "judulTAPeserta"){
                $varRest = "";
                $first=TRUE;
                $word = $value;
                for(;;){
                    $hoho=FALSE;
                    $i=50;
                    if(strlen($word) > 50){
                        for(;$word[$i] != " ";){
                            $i--;
							if($i == 0){
								$i=50;
								break;
							}
                        }
                    }else{
                        if($first){
                            $varRest.=$word;   
                            $first=FALSE;
                        }else{
                            $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>Judul Tugas Akhir_______._: _</span>".$word;  
                        }
                        $hoho=TRUE;
                    }
                    if($hoho)
                    break;
                    if($first){
                        $varRest.=substr($word,0,$i);   
                        $first=FALSE;
                    }else{
                        $varRest.="<br><span style='white-space: pre-line; color: rgba(255,255,255,0);'>Judul Tugas Akhir_______._: _</span>".substr($word,0,$i);   
                    }
                    $word = substr($word,$i+1,strlen($word)-($i+1));
                }
                $value=$varRest;
            }
            $TEMP_HTML = str_ireplace("@".$key.";",$value,$TEMP_HTML);
        }
        $this->mpdf->WriteHTML($TEMP_HTML);
        //echo $TEMP_HTML;
        $this->mpdf->Output();
       // $this->mpdf->Output();
    }
}/*
$print = new Printcontrol();
/*
$TEMP_ARRAY = array(
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "hariTanggal"=>"Senin, 12 Januari 2016",
    "jam"=>"08:30",
    "tempat"=>"Ruang Sidang TA 1",
    "ketua"=>"Drs. Nurdin Bachtiar",
    "sekertaris"=>"Drs. Helmie Arief",
    "moderator"=>"Drs. Suhartono",
    "comoderator"=>"Drs. Aris Puji",
    "tanggalTerbit"=>"26 Desember 2015",
    "namaDosen"=>"Drs. helmie arief",
    "nip"=>"19228992891782718972"
    );
$TEMP_ARRAY = array(
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "tanggalTerbit"=>"26 Desember 2015",
    "namaDosen"=>"Drs. helmie arief",
    "nip"=>"19228992891782718972"
    );
    
$TEMP_ARRAY = array(
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "tanggalTerbit"=>"26 Desember 2015",
    "namaDosen"=>"Drs. helmie arief",
    "nip"=>"19228992891782718972"
    );

$TEMP_ARRAY = array(
    "hari"=>"Senin, 24 Januari 2016",
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "prodiPeserta"=>"Ilmu Komputer / Informatika",
    "ketua"=>"Drs. Nurdin Bachtiar",
    "sekertaris"=>"Drs. Helmie Arief",
    "moderator"=>"Drs. Suhartono",
    "tanggalTerbit"=>"26 Desember 2015",
    "nip"=>"19228992891782718972"
    );
    $TEMP_ARRAY = array(
    "hari"=>"Senin, 24 Januari 2016",
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "prodiPeserta"=>"Ilmu Komputer / Informatika",
    "ketua"=>"Drs. Nurdin Bachtiar",
    "sekertaris"=>"Drs. Helmie Arief",
    "moderator"=>"Drs. Suhartono",
    "tanggalTerbit"=>"26 Desember 2015",
    "nip"=>"19228992891782718972"
    );
    
$TEMP_ARRAY = array(
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "tanggalTerbit"=>"26 Desember 2015",
    "namaDosen"=>"Drs. helmie arief",
    "nip"=>"19228992891782718972"
    );
$TEMP_ARRAY = array(
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "hariTanggal"=>"Senin, 12 Januari 2016",
    "jam"=>"08:30",
    "tempat"=>"Ruang Sidang TA 1",
    "moderator"=>"Drs. Suhartono",
    "tanggalTerbit"=>"26 Desember 2015",
    "namaDosen"=>"Drs. helmie arief",
    "nip"=>"19228992891782718972"
    );
    
$TEMP_ARRAY = array(
    "hari"=>"Senin, 24 Januari 2016",
    "namaPeserta"=>"Jafar Abdurrahman Albasyir",
    "nimPeserta"=>"24010313130125",
    "judulTAPeserta"=>"Embeded System dalam siste informasi bebasis automatisasi percepatan kalkulasi perhitungan ketetapan penentuan kalibrasi nilai output",
    "prodiPeserta"=>"Ilmu Komputer / Informatika",
    "ketua"=>"Drs. Nurdin Bachtiar",
    "sekertaris"=>"Drs. Helmie Arief",
    "moderator"=>"Drs. Suhartono",
    "tanggalTerbit"=>"26 Desember 2015",
    "nip"=>"19228992891782718972"
    );
    */
//$print->printFUJ22($TEMP_ARRAY);
//$print->printFUJ20($TEMP_ARRAY);
//$print->printFUJ21($TEMP_ARRAY);
//$print->printFUJ23($TEMP_ARRAY);
//$print->printFUJ25($TEMP_ARRAY);
//$print->printFUJ11($TEMP_ARRAY);
//$print->printFUJ12($TEMP_ARRAY);
//$print->printFUJ13($TEMP_ARRAY);