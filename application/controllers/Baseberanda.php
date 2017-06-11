<?php if(!defined('BASEPATH')) exit("");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
/*
dependencie
-GateControlModel
-ControlEvent
-ControlFile
Revelation : success
*/
class Baseberanda extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper("Html");
		$this->load->helper("Url");
	}
	//optimized
	//getting layout beranda of default page
	public function getLayoutBeranda(){
		echo "1";
		$this->load->view("Bodyright/Baseroom/Beranda");
	}
	//optimized
	//getInformasi dari koordinator tugas akhir
	public function getTableAcara(){
		$key = 1;
		if($this->input->post("key")!==NULL){
			$key = intval($this->input->post("key"));
			if($key < 0) $key = 1;
		}
		$s=true;
		$string = "<h4>Informasi Acara</h4><div class='well'>Data Tidak ditemukan</div>";
		$n = 1;
		$z = 1;
		$koko = 0;
		$trueCon = false;
		$this->loadLib('ControlEvent');
		$this->loadMod('GateControlModel');
		$tempKejadian = (new ControlEvent(new GateControlModel()))->getAllData();
		if($tempKejadian){
			while($tempKejadian->getNextCursor()){
				if($n <= 5 && $z == $key){
					$trueCon;
					if($s){
						$string = "<h4>Informasi Acara</h4>";
						if($tempKejadian->getKode() == '1'){						
							$string .= "<div class='well'>";
							$string .= $tempKejadian->getJudul()."<br>".$tempKejadian->getIsi()." Pada tahun ajaran ".substr($tempKejadian->getTahunAk(),0,strlen($tempKejadian->getTahunAk())-1)."-".(intval(substr($tempKejadian->getTahunAk(),0,strlen($tempKejadian->getTahunAk())-1))+1)." Semester ".$tempKejadian->getTahunAk()[4]." dimulai pada tanggal ".$tempKejadian->getMulai()." hingga tanggal ".$tempKejadian->getBerakhir();
							$string .= "</div>";	
						}else{
							$string .= "<div class='well'>";
							$string .= $tempKejadian->getJudul()."<br>".$tempKejadian->getIsi();
							$string .= "</div>";
						}
						$s = false;
					}else{
						if($tempKejadian->getKode() == '1'){						
							$string .= "<div class='well'>";
							$string .= $tempKejadian->getJudul()."<br>".$tempKejadian->getIsi()." Pada tahun ajaran ".substr($tempKejadian->getTahunAk(),0,strlen($tempKejadian->getTahunAk())-1)."-".(intval(substr($tempKejadian->getTahunAk(),0,strlen($tempKejadian->getTahunAk())-1))+1)." Semester ".$tempKejadian->getTahunAk()[4]." dimulai pada tanggal ".$tempKejadian->getMulai()." hingga tanggal ".$tempKejadian->getBerakhir();
							$string .= "</div>";	
						}else{
							$string .= "<div class='well'>";
							$string .= $tempKejadian->getJudul()."<br>".$tempKejadian->getIsi();
							$string .= "</div>";
						}
					}
					$koko ++;
					$n++;
				}else if($n == 5 && $z < $key){
					$n = 1;
					$z++;
				}else{
					$n++;
				}
			}
		}
		echo "1".$string;
		if($key == 1){
			if($koko == 5)
				echo '<div class="dataTables_paginate paging_two_button">
						<a class="paginate_disabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sebelumnya </a>
						<a class="paginate_enabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0" onclick="nextPageBerandaBase();"> Sesudahnya </a>
					</div>';
			else
				echo '<div class="dataTables_paginate paging_two_button">
						<a class="paginate_disabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sebelumnya </a>
						<a class="paginate_disabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sesudahnya </a>
					</div>';
		}else{
			if($koko == 5)
				echo '<div class="dataTables_paginate paging_two_button">
						<a class="paginate_enabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"  onclick="previousPageBerandaBase();"> Sebelumnya </a>
						<a class="paginate_enabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0"  onclick="nextPageBerandaBase();"> Sesudahnya </a>
					</div>';
			else
				echo '<div class="dataTables_paginate paging_two_button">
						<a class="paginate_enabled_previous" tabindex="0" role="button" aria-controls="DataTables_Table_0"  onclick="previousPageBerandaBase();"> Sebelumnya </a>
						<a class="paginate_disabled_next" tabindex="0" role="button" aria-controls="DataTables_Table_0"> Sesudahnya </a>
					</div>';
		}
		
	}
	//optimized
	//getting file, uploaded by koordinator tugas akhir
	public function getListRecord(){
		$this->loadLib('ControlFile');
		$this->loadMod('GateControlModel');
		$tempObjectDB = (new ControlFile(new GateControlModel()))->getAllData();
		$data = "";
		if($tempObjectDB){
			$i=1;
			while($tempObjectDB->getNextCursor()){
				$data .="<tr><td><a target='_BLANK' href='".base_url()."/upload/file/".$tempObjectDB->getNamaData()."'><span class='icon-file-alt'></span>File ".$i."</a></td><td>".$tempObjectDB->getDetail()."</td></tr>";
				$i++;
			}
		}
		if($data == '') echo "1<tr><td>-</td><td>-</td></tr>";
		else echo "1".$data;
	}
}