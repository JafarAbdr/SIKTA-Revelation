<?php
/*
dependencies:
-LoginFilter
-Mahasiswa
-Koordinator
-Dosen
-Inputjaservfilter
-ControlDetail
-ControlDosen
-ControlMahasiswa
-ControlRegistrasi
-ControlSeminar
-ControlSidang
-ControlTime
*/
if(!defined("BASEPATH")) exit("You don't have permission");
require_once(APPPATH.'controllers/CI_Controller_Modified.php');
class Controlresultseminar extends CI_Controller_Modified {
	public function __CONSTRUCT(){
		parent::__CONSTRUCT();
		$this->load->helper('url');
		$this->load->helper('html');
		if(!$this->loginFilter->isLogin($this->koordinator)){
			redirect(base_url()."Gateinout.jsp");
		}
	}
	public function getLayoutSeminar(){
		$this->loadLib('ControlTime');
		echo "1";
		$srt = (new ControlTime($this->gateControlModel))->getYearNow();
		$smt2=true;
		$smt1=false;
		if(intval($srt[4]) == 1){
			$smt1=true;
			$smt2=false;
		}
		$year = intval(substr($srt,0,4));
		$this->load->view("Bodyright/Controlroom/Seminar.php",array("smts"=>$smt1, "smtd"=>$smt2, "year"=>$year));
	}
	public function getDataWithExcelSem($year){
		$year = intval($year);
		$this->loadLib("ControlTime");
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		if($year >= 20131 && $year <= 99999)
			$tahunAk = $year."";
		$tahunAk = "".$tahunAk."";
		$this->load->library("phpexcel");
		 //membuat objek
		$objPHPExcel = new Phpexcel();
		$listTitle = array(
			'No',
			'Nim',
			'Nama',
			'Judul',
			'Dosen',
			'Status',
			'nilai' 
		);
		// Nama Field Baris Pertama
		$col = 1;
		foreach ($listTitle as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			$col++;
		}
		$i=1;
		$row = 5;
		
		$this->loadLib("ControlSeminar");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDetail");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = (new ControlSeminar($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tahunAk);
		$data="";
		if($tempObjectDB){
			$i=1;
			$isExist = false;
			while($tempObjectDB->getNextCursor()){
				$isExist = true;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $i);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tempObjectDB->getTableStack(1)->getNim());
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tempObjectDB->getTableStack(1)->getNama());			
				
				$tempObjectDBE = $controlRegistrasi->getAllDataWithDosbing($tahunAk, $tempObjectDB->getTableStack(1)->getIdentified());
				$tempObjectDBE->getNextCursor();
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $tempObjectDBE->getTableStack(1)->getJudulTA());
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $tempObjectDBE->getTableStack(2)->getNama());
				if($tempObjectDB->getTableStack(0)->getDataProses() == '1'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Menunggu");
				}else if($tempObjectDB->getTableStack(0)->getDataProses() == '2'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Disetujui");
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Ditolak");
				}
				if($tempObjectDB->getTableStack(0)->getNilai() == '0'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Belum dinilai");
				}else if($tempObjectDB->getTableStack(0)->getNilai() == '5'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "E (Sangat Kurang)");
				}else if($tempObjectDB->getTableStack(0)->getNilai() == '4'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "D (Kurang)");
				}else if($tempObjectDB->getTableStack(0)->getNilai() == '3'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "C (Bagus)");
				}else if($tempObjectDB->getTableStack(0)->getNilai() == '2'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "B (Sangat Bagus)");
				}else { 
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "A (Paling Bagus)");
				}
				$i++;
				$row++;
			}	
			if(!$isExist){
				exit("0data tidak ditemukan");
			}
		}else{
			exit("0data tidak ditemukan");
		}
		$objPHPExcel->setActiveSheetIndex(0);
		//Set Title
		$objPHPExcel->getActiveSheet()->setTitle('Data Absen');
		//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//Nama File
		header('Content-Disposition: attachment;filename="DataPeserta Registrasi.xlsx"');
		//Download
		$objWriter->save("php://output");
	}
	//optimized
	public function getTableSeminarTA1(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $tahunAk = $controlTime->getYearNow();
		}else{ $tahunAk = "".$tahun."".$semester.""; }
		$changeAvaila = "";
		if(intval($tahunAk) != intval($controlTime->getYearNow()))
			$changeAvaila = "disabled";
		//key
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){ echo "0Kata kunci harus berupa bagian nama dari seseorang"; return;
			}else $key = $this->isNullPost('key');
		}
		$this->loadLib("ControlSeminar");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDetail");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDB = (new ControlSeminar($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tahunAk);
		$data="";
		if($tempObjectDB){
			$i=1;
			$isExist = false;
			while($tempObjectDB->getNextCursor()){
				$tempObjectDBs = $tempObjectDB->getTableStack(0);
				$tempObjectDBD = $tempObjectDB->getTableStack(1);
				if($key == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($key)))){
					$isExist = true;
					$data .= "<tr>";
					$tempObjectDBT = $controlDetail->getDetail('minat',$tempObjectDBD->getMinat());
					$tempObjectDBT->getNextCursor();
					//full combine get data registrasi
					
					$tempObjectDBE = $controlRegistrasi->getAllDataWithDosbing($tahunAk, $tempObjectDBD->getIdentified());
					$tempObjectDBE->getNextCursor();
					
					$data.="<td>".$i."</td><td>".$tempObjectDBD->getNim()."</td><td>".$tempObjectDBD->getNama()."</td><td>".$tempObjectDBT->getDetail()."</td><td>".$tempObjectDBE->getTableStack(2)->getNama()."</td><td><div class='row'>";
					if($tempObjectDBs->getRekomendasi() == '1'){
						$data .= "<div class='col-md-3'><span style='color : green;' title='rekomendasi'><i class='icon-map-marker'></i></span></div>";
					}else{
						$data .= "<div class='col-md-3'><span style='color : red;' title='tidak direkomendasikan'><i class='icon-map-marker'></i></span></div>";
					}
					if($tempObjectDBs->getFujS() != "" && $tempObjectDBs->getFujS() != " "){
						$data.="<div class='col-md-2'><span style='color : green;' class='pointer' title='sudah mengumpulkan surat pengantar'  onclick='showPdfTA1(".'"'.substr($tempObjectDBs->getFujS(),0,strlen($tempObjectDBs->getFujS())-4).'"'.",".'"getPreviewPDFSeminarTA1"'.")'><i class='icon-file-alt'></i></span></div>";	
					}else{
						$data.="<div class='col-md-2'><span style='color : red;' title='belum mengumpulkan surat pengantar'><i class='icon-file-alt'></i></span></div>";		
					}
					if($tempObjectDBs->getKarBim() != "" && $tempObjectDBs->getKarBim() != " "){
						$data.="<div class='col-md-2'><span style='color:green' class='pointer'  title='sudah mengumpulkan kartu bimbingan' onclick='showImageTA1(".'"'.substr($tempObjectDBs->getKarBim(),0,strlen($tempObjectDBs->getKarBim())-4).'"'.",".'"getPreviewPictureSeminarTA1"'.")'><i class='icon-picture'></i></span></div>";	
					}else{
						$data.="<div class='col-md-2'><span style='color:red' title='belum mengumpulkan kartu bimbingan'><i class='icon-picture'></i></span></div>";	
					}
					if($tempObjectDBs->getKarFolSem() != "" && $tempObjectDBs->getKarFolSem() != " "){
					$data .= "<div class='col-md-2'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan kartu ikut seminar' onclick='showImageTA1(".'"'.substr($tempObjectDBs->getKarFolSem(),0,strlen($tempObjectDBs->getKarFolSem())-4).'"'.",".'"getPreviewPictureSeminarTA1"'.")'><i class='icon-picture'></i></span>".
					"</div>";	
					}else{
					$data .= "<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan kartu ikut seminar'><i class='icon-picture'></i></span>".
					"</div>";	
					}
					$data.="</div></td><td>";
					if($tempObjectDBs->getDataProses() == '3'){
						$data.="<select disabled>";
					}else{
						$data.="<select ".$changeAvaila." onchange='seminarTA1Agreement(".'"'.$tempObjectDBD->getNim().'"'.",this)'>";	
					}
					
					if($tempObjectDBs->getDataProses() == '1'){
						$data.="<option value='1' selected>menunggu</option>";
					}else{
						$data.="<option value='1'>menunggu</option>";
					}
					if($tempObjectDBs->getDataProses() == '2'){
						$data.="<option value='2' selected>disetujui</option>";
					}else{
						$data.="<option value='2'>disetujui</option>";
					}
					if($tempObjectDBs->getDataProses() == '3'){
						$data.="<option value='3' selected>ditolak</option>";
					}else{
						$data.="<option value='3'>ditolak</option>";
					}
					$data.="</select>";
					$data.="</td>";
					$data.="<td><select ".$changeAvaila." onchange='giviTA1Seminar(".'"'.$tempObjectDBD->getNim().'"'.",this.value)'>";
					if($tempObjectDBs->getNilai() == '0'){
						$data.="<option value='0' selected>belum diberikan</option>";
					}else{
						$data.="<option value='0'>belum diberikan</option>";
					}
					if($tempObjectDBs->getNilai() == '5'){
						$data.="<option value='5' selected>E (Sangat Kurang)</option>";
					}else{
						$data.="<option value='5'>E (Sangat Kurang)</option>";
					}
					if($tempObjectDBs->getNilai() == '4'){
						$data.="<option value='4' selected>D (kurang)</option>";
					}else{
						$data.="<option value='4'>D (kurang)</option>";
					}
					if($tempObjectDBs->getNilai() == '3'){
						$data.="<option value='3' selected>C (Bagus)</option>";
					}else{
						$data.="<option value='3'>C (Bagus)</option>";
					}
					if($tempObjectDBs->getNilai() == '2'){
						$data.="<option value='2' selected>B (Sangat Bagus)</option>";
					}else{
						$data.="<option value='2'>B (Sangat Bagus)</option>";
					}
					if($tempObjectDBs->getNilai() == '1'){ $data.="<option value='1' selected>A (Paling Bagus)</option>";
					}else{ $data.="<option value='1'>A (Paling Bagus)</option>"; }
					
					$data.="</select></td>";
					$data.="</tr>";
					$i++;
				}
			}	
			if(!$isExist){
				$data.="<tr>";
				$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
				$data.="</tr>";
			}
		}else{
			$data.="<tr>";
			$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
			$data.="</tr>";
		}
		echo "1".$data;
		
		
	}
	//optimized
	public function getDataWithExcelSid($year){
		$year = intval($year);
		$this->loadLib("ControlTime");
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		if($year >= 20131 && $year <= 99999)
			$tahunAk = $year."";
		$tahunAk = "".$tahunAk."";
		$this->load->library("phpexcel");
		 //membuat objek
		$objPHPExcel = new Phpexcel();
		$listTitle = array(
			'No',
			'Nim',
			'Nama',
			'Judul',
			'Dosen pembimbing',
			'Penguji 1',
			'Penguji 2',
			'Penguji 3',
			'Status',
			'nilai' 
		);
		// Nama Field Baris Pertama
		$col = 1;
		foreach ($listTitle as $field)
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 4, $field);
			$col++;
		}
		$i=1;
		$row = 5;
		
		$this->loadLib("ControlSidang");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDetail");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		
		$tempObjectDBs = (new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tahunAk);
		
		$tempObjectDBEn = $controlDosen->getDataByStatus();
		if($tempObjectDBs){
			$i=1;
			$isExist = false;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDBD = $tempObjectDBs->getTableStack(1);
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $i);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $tempObjectDBD->getNim());
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $tempObjectDBD->getNama());			
				$isExist = true;
				$tempObjectDBEs = $controlRegistrasi->getAllDataWithDosbing($tahunAk, $tempObjectDBD->getIdentified());
				$tempObjectDBEs->getNextCursor();
				$tempObjectDBE = $tempObjectDBEs->getTableStack(1);
				$tempObjectDBL = $tempObjectDBEs->getTableStack(2);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $tempObjectDBE->getJudulTA());	
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $tempObjectDBL->getNama());	
				$dosenS = false;
				$dosenD = false;
				$dosenT = false;
				if($tempObjectDBEn){
					$tempObjectDBEn->resetSendRequest();
					while($tempObjectDBEn->getNextCursor()){
						if($tempObjectDBEn->getNip() != $tempObjectDBL->getIdentified()){
							if($tempObjectDBEn->getIdentified() == $tempObjectDB->getDosenS()){
								$dosenS = true;
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $tempObjectDBEn->getNama());	
							}
							if($tempObjectDBEn->getIdentified() == $tempObjectDB->getDosenD()){
								$dosenD = true;
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $tempObjectDBEn->getNama());	
							}
							if($tempObjectDBEn->getIdentified() == $tempObjectDB->getDosenT()){
								$dosenT = true;
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $tempObjectDBEn->getNama());	
							}
						}
					}
				}
				if(!$dosenS) $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, "Belum dipilihkan");
				if(!$dosenD) $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, "Belum dipilihkan");
				if(!$dosenT) $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, "Belum dipilihkan");
				if($tempObjectDB->getDataProsesD() == '1'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, "Menunggu");
				}else if($tempObjectDB->getDataProsesD() == '2'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, "Disetujui");
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, "Ditolak");
				}
				if($tempObjectDB->getNilai() == '0'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "Belum dinilai");
				}else if($tempObjectDB->getNilai() == '5'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "E (Sangat Kurang)");
				}else if($tempObjectDB->getNilai() == '4'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "D (Kurang)");
				}else if($tempObjectDB->getNilai() == '3'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "C (Bagus)");
				}else if($tempObjectDB->getNilai() == '2'){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "B (Sangat Bagus)");
				}else{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, "A (Paling Bagus)");
				}
				$i++;
				$row++;
			}	
			if(!$isExist){
				exit("0data tidak ditemukan");
			}
		}else{
			exit("0data tidak ditemukan");
		}
		$objPHPExcel->setActiveSheetIndex(0);
		//Set Title
		$objPHPExcel->getActiveSheet()->setTitle('Data Absen');
		//Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//Nama File
		header('Content-Disposition: attachment;filename="DataPeserta Registrasi.xlsx"');
		//Download
		$objWriter->save("php://output");
	}
	public function getTableSeminarTA2(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		$controlTime = new ControlTime($this->gateControlModel);
		if($semester == null || $tahun == null){ $tahunAk = $controlTime->getYearNow();
		}else{ $tahunAk = "".$tahun."".$semester.""; }
		$changeAvaila = "";
		if(intval($tahunAk) != intval($controlTime->getYearNow()))
			$changeAvaila = "disabled";
		//key
		$key = null;
		if($this->input->post('key') === NULL)
			$key = "*";
		else if($this->isNullPost('key') == "" || $this->isNullPost('key') == " "){
			$key = "*";
		}else{
			if(!$this->inputJaservFilter->nameLevelFiltering($this->isNullPost('key'))[0]){ echo "0Kata kunci harus berupa bagian nama dari seseorang"; return;
			}else $key = $this->isNullPost('key');
		}
		$this->loadLib("ControlSidang");
		$this->loadLib("ControlMahasiswa");
		$this->loadLib("ControlDetail");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlDosen");
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlDetail = new ControlDetail($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$tempObjectDBs = (new ControlSidang($this->gateControlModel))->getAllDataHaveATimeWithMahasiswa($tahunAk);
		
		$tempObjectDBEn = $controlDosen->getDataByStatus();
		$select2 = "<option value='0'>Belum dipilih</option>";
		$data="";
		if($tempObjectDBs){
			$i=1;
			$isExist = false;
			while($tempObjectDBs->getNextCursor()){
				$tempObjectDB = $tempObjectDBs->getTableStack(0);
				$tempObjectDBD = $tempObjectDBs->getTableStack(1);
				if($key == "*" || !is_bool(strpos(strtolower($tempObjectDBD->getNama()),strtolower($key)))){
					$isExist = true;
					$data .= "<tr>";
					$tempObjectDBT = $controlDetail->getDetail('minat',$tempObjectDBD->getMinat());
					$tempObjectDBT->getNextCursor();
					
					
					
					$tempObjectDBEs = $controlRegistrasi->getAllDataWithDosbing($tahunAk, $tempObjectDBD->getIdentified());
					$tempObjectDBEs->getNextCursor();
					$tempObjectDBL = $tempObjectDBEs->getTableStack(2);
					$tempObjectDBE = $tempObjectDBEs->getTableStack(1);
					
					$selectPS = $select2;
					$selectPD = $select2;
					$selectPT = $select2;
					//echo "<br>".var_dump($TEMP_DOSEN_PS->TEMP_RESULT_ARRAY)."<br>";
					if($tempObjectDBEn){
						$tempObjectDBEn->resetSendRequest();
						while($tempObjectDBEn->getNextCursor()){
							if($tempObjectDBEn->getNip() != $tempObjectDBL->getIdentified()){
								//echo $tempObjectDB->getDosenPS()." ".$tempObjectDB->getDosenPD()." ".$tempObjectDB->getDosenPT()." ".$this->sc_sd->getNip()."<br>";
								if($tempObjectDBEn->getIdentified() == $tempObjectDB->getDosenS())
									$selectPS .= "<option selected value='".$tempObjectDBEn->getNip()."'>".$tempObjectDBEn->getNama()."</option>";
								else
									$selectPS .= "<option value='".$tempObjectDBEn->getNip()."'>".$tempObjectDBEn->getNama()."</option>";	
								if($tempObjectDBEn->getIdentified() == $tempObjectDB->getDosenD())
									$selectPD .= "<option selected value='".$tempObjectDBEn->getNip()."'>".$tempObjectDBEn->getNama()."</option>";
								else
									$selectPD .= "<option value='".$tempObjectDBEn->getNip()."'>".$tempObjectDBEn->getNama()."</option>";
								if($tempObjectDBEn->getIdentified() == $tempObjectDB->getDosenT())
									$selectPT .= "<option selected value='".$tempObjectDBEn->getNip()."'>".$tempObjectDBEn->getNama()."</option>";
								else
									$selectPT .= "<option value='".$tempObjectDBEn->getNip()."'>".$tempObjectDBEn->getNama()."</option>";
							}
						}
					}
					
					$data.="<td>".$i."</td><td>".$tempObjectDBD->getNim()."</td><td>".$tempObjectDBD->getNama()."</td><td>";
					if($tempObjectDB->getDataProsesD() == '3'){
						$data.="<select disabled>";
					}else{
						$data.="<select ".$changeAvaila." onchange='changePenguji1(".'"'.$tempObjectDBD->getNim().'"'.",this)'>";	
					}
					$data.=$selectPS."</select></td><td>";
					if($tempObjectDB->getDataProsesD() == '3'){
						$data.="<select disabled>";
					}else{
						$data.="<select ".$changeAvaila." onchange='changePenguji2(".'"'.$tempObjectDBD->getNim().'"'.",this)'>";
					}
					$data.=$selectPD."</select></td><td>";
					if($tempObjectDB->getDataProsesD() == '3'){
						$data.="<select disabled>";
					}else{
						$data.="<select ".$changeAvaila." onchange='changePenguji3(".'"'.$tempObjectDBD->getNim().'"'.",this)'>";
					}
					
					$data.=$selectPT."</select>"."</td><td>";
					$data.=$tempObjectDBL->getNama()."</td>";
					$data.="<td><select ".$changeAvaila." onchange='approveThisPenguji(".'"'.$tempObjectDBD->getNim().'"'.",this.value)'>";
					if($tempObjectDB->getDataProsesS() == '1'){
						$data.="<option value='1' selected>menunggu</option>";
					}else{
						$data.="<option value='1'>menunggu</option>";
					}
					if($tempObjectDB->getDataProsesS() == '2'){
						$data.="<option value='2' selected>disetujui</option>";
					}else{
						$data.="<option value='2'>disetujui</option>";
					}
					$data.="</select></td><td><div class='row'>";
					if($tempObjectDB->getRekomendasi() == '1'){
					$data .= "<div class='col-md-3'>".
					"<span style='color : green;' title='rekomendasi'><i class='icon-map-marker'></i></span></div>";
					}else{
					$data .= "<div class='col-md-3'>".
					"<span style='color : red;' title='tidak direkomendasikan'><i class='icon-map-marker'></i></span></div>";
					}
					//FUJ21
					if($tempObjectDB->getFujDS() != "" && $tempObjectDB->getFujDS() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color : green;' class='pointer' title='sudah mengumpulkan surat pengantar'  onclick='showPdfTA1(".'"'.substr($tempObjectDB->getFujDS(),0,strlen($tempObjectDB->getFujDS())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan surat pengantar'><i class='icon-file-alt'></i></span>".
					"</div>";		
					}
					//FUJ20
					if($tempObjectDB->getFujDP() != "" && $tempObjectDB->getFujDP() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color : green;' class='pointer' title='sudah mengumpulkan FUJ 20'  onclick='showPdfTA1(".'"'.substr($tempObjectDB->getFujDP(),0,strlen($tempObjectDB->getFujDP())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan FUJ 20'><i class='icon-file-alt'></i></span>".
					"</div>";		
					}
					//FUJ25
					if($tempObjectDB->getFujDL() != "" && $tempObjectDB->getFujDL() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color : green;' class='pointer' title='sudah mengumpulkan FUJ 25'  onclick='showPdfTA1(".'"'.substr($tempObjectDB->getFujDL(),0,strlen($tempObjectDB->getFujDL())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan FUJ 25'><i class='icon-file-alt'></i></span>".
					"</div>";		
					}
					//kartu bimbingan
					if($tempObjectDB->getKarBim() != "" && $tempObjectDB->getKarBim() != " "){
					$data.="<div class='col-md-2'>".
					"<span style='color:green' class='pointer'  title='sudah mengumpulkan kartu bimbingan' onclick='showPdfTA1(".'"'.substr($tempObjectDB->getKarBim(),0,strlen($tempObjectDB->getKarBim())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data.="<div class='col-md-2'>".
					"<span style='color:red' title='belum mengumpulkan kartu bimbingan'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}
					//toefl
					if($tempObjectDB->getToefl() != "" && $tempObjectDB->getToefl() != " "){
					$data .= "<div class='col-md-2'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan hasil Toefl' onclick='showPdfTA1(".'"'.substr($tempObjectDB->getToefl(),0,strlen($tempObjectDB->getToefl())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}else{
					$data .= "<div class='col-md-2'>".
					"<span style='color : red;' title='belum mengumpulkan hasil Toefl'><i class='icon-file-alt'></i></span>".
					"</div>";	
					}
					//krs
					if($tempObjectDB->getNamaKRS() != "" && $tempObjectDB->getNamaKRS() != " "){
					$data.="<div class='col-md-3'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan KRS' onclick='showPdfTA1(".'"'.substr($tempObjectDB->getNamaKRS(),0,strlen($tempObjectDB->getNamaKRS())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";
					}else{
					$data.="<div class='col-md-3'>".
					"<span style='color : red;' title='belum mengumpulkan KRS'><i class='icon-file-alt'></i></span>".
					"</div>";
					}
					//transkrip
					if($tempObjectDB->getNamaTranskrip() != "" && $tempObjectDB->getNamaTranskrip() != " "){
					$data.="<div class='col-md-3'>".
					"<span style='color : green;' class='pointer'  title='sudah mengumpulkan transkrip' onclick='showPdfTA1(".'"'.substr($tempObjectDB->getNamaTranskrip(),0,strlen($tempObjectDB->getNamaTranskrip())-4).'"'.",".'"getPreviewPDFSeminarTA2"'.")'><i class='icon-file-alt'></i></span>".
					"</div>";
					}else{
					$data.="<div class='col-md-3'>".
					"<span style='color : red;' title='belum mengumpulkan transkrip'><i class='icon-file-alt'></i></span>".
					"</div>";
					}
					$data.="</div></td><td>";
					if($tempObjectDB->getDataProsesD() == '3'){
						$data.="<select disabled>";
					}else{
						$data.="<select ".$changeAvaila." onchange='seminarTA2Agreement(".'"'.$tempObjectDBD->getNim().'"'.",this)'>";	
					}
					if($tempObjectDB->getDataProsesD() == '1'){
						$data.="<option value='1' selected>menunggu</option>";
					}else{
						$data.="<option value='1'>menunggu</option>";
					}
					if($tempObjectDB->getDataProsesD() == '2'){
						$data.="<option value='2' selected>disetujui</option>";
					}else{
						$data.="<option value='2'>disetujui</option>";
					}
					if($tempObjectDB->getDataProsesD() == '3'){
						$data.="<option value='3' selected>ditolak</option>";
					}else{
						$data.="<option value='3'>ditolak</option>";
					}
					$data.="</select>";
					$data.="</td>";
					$data.="<td><select ".$changeAvaila." onchange='giviTA2Seminar(".'"'.$tempObjectDBD->getNim().'"'.",this.value)'>";
					if($tempObjectDB->getNilai() == '0'){
						$data.="<option value='0' selected>belum diberikan</option>";
					}else{
						$data.="<option value='0'>belum diberikan</option>";
					}
					if($tempObjectDB->getNilai() == '5'){
						$data.="<option value='5' selected>E (Sangat Kurang)</option>";
					}else{
						$data.="<option value='5'>E (Sangat Kurang)</option>";
					}
					if($tempObjectDB->getNilai() == '4'){
						$data.="<option value='4' selected>D (kurang)</option>";
					}else{
						$data.="<option value='4'>D (kurang)</option>";
					}
					if($tempObjectDB->getNilai() == '3'){
						$data.="<option value='3' selected>C (Bagus)</option>";
					}else{
						$data.="<option value='3'>C (Bagus)</option>";
					}
					if($tempObjectDB->getNilai() == '2'){
						$data.="<option value='2' selected>B (Sangat Bagus)</option>";
					}else{
						$data.="<option value='2'>B (Sangat Bagus)</option>";
					}
					if($tempObjectDB->getNilai() == '1'){
						$data.="<option value='1' selected>A (Paling Bagus)</option>";
					}else{
						$data.="<option value='1'>A (Paling Bagus)</option>";
					}
					$data.="</select></td>";
					$data.="</tr>";
					$i++;
				}
			}
			if(!$isExist){
				$data.="<tr>";
				$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
				$data.="</tr>";
			}
		}else{
			$data.="<tr>";
			$data.="<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
			$data.="</tr>";
		}
		echo "1".$data;
	}
	public function getJsonTableNow(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		if($semester == null || $tahun == null){
			$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		}else{
			$tahunAk = "".$tahun."".$semester."";
		}
		$this->loadLib("ControlDosen");
		$this->loadLib("ControlSidang");
		$this->loadLib("ControlRegistrasi");
		$this->loadLib("ControlMahasiswa");
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByStatus();
		$temp1 = "";
		$temp2 = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				//
				$temp1 .= '"'.$tempObjectDB->getNama().'",';
				$tempObjectDBD = $controlRegistrasi->getAllDataByDosen($tahunAk,$tempObjectDB->getIdentified());
				$countData = 0;
				if($tempObjectDBD){
					while($tempObjectDBD->getNextCursor()){
						$tempObjectDBT = $controlSidang->getDataByMahasiswa($tahunAk,$tempObjectDBD->getTableStack(1)->getMahasiswa());
						if($tempObjectDBT && $tempObjectDBT->getNextCursor()){
							$countData += 1;
						}
					}
				}
				$temp2 .= $countData.",";
			}
		}
		if($temp2 != ""){
			$temp1 = substr($temp1, 0,strlen($temp1)-1);
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		}
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
	public function getJsonTableTesterS(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		if($semester == null || $tahun == null){
			$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		}else{
			$tahunAk = "".$tahun."".$semester."";
		}
		$this->loadLib("ControlDosen");
		$this->loadLib("ControlSidang");
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByStatus();
		$temp1 = "";
		$temp2 = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$countData = 0;
				$temp1 .= '"'.$tempObjectDB->getNama().'",';
				$tempObjectDBD = $controlSidang->isTesterOfMahasiswa(1,$tahunAk,$tempObjectDB->getIdentified());
				if($tempObjectDBD){
					$countData += $tempObjectDBD->getCountData();
				}
				$temp2 .= $countData.",";
			}
		}
		if($temp2 != ""){
			$temp1 = substr($temp1, 0,strlen($temp1)-1);
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		}
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	
	public function getJsonTableTesterD(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		if($semester == null || $tahun == null){
			$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		}else{
			$tahunAk = "".$tahun."".$semester."";
		}
		$this->loadLib("ControlDosen");
		$this->loadLib("ControlSidang");
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByStatus();
		$temp1 = "";
		$temp2 = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$countData = 0;
				$temp1 .= '"'.$tempObjectDB->getNama().'",';
				$tempObjectDBD = $controlSidang->isTesterOfMahasiswa(2,$tahunAk,$tempObjectDB->getIdentified());
				if($tempObjectDBD){
					$countData += $tempObjectDBD->getCountData();
				}
				$temp2 .= $countData.",";
			}
		}
		if($temp2 != ""){
			$temp1 = substr($temp1, 0,strlen($temp1)-1);
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		}
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	public function getJsonTableTesterT(){
		$tahun = $this->input->post('tahun');
		if($this->input->post('tahun') === null){
			$tahun = null;
		}else {
			if(intval($tahun) < 2004 || intval($tahun) > intval(date("Y"))){
				echo "0Tahun ajaran tidak valid";
				return;
			}
			$tahun = intval($tahun)."";	
		}
		//semester
		$semester = $this->input->post('semester');
		if($this->input->post('semester') === null){
			$semester = null; 
		}else{		
			if(intval($semester) < 1 || intval($semester) > 2){
				echo "0Semester tidak di ketahui";
				return;
			}
			$semester = intval($semester)."";	
		}
		$this->loadLib('ControlTime');
		if($semester == null || $tahun == null){
			$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		}else{
			$tahunAk = "".$tahun."".$semester."";
		}
		$this->loadLib("ControlDosen");
		$this->loadLib("ControlSidang");
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDB = (new ControlDosen($this->gateControlModel))->getDataByStatus();
		$temp1 = "";
		$temp2 = "";
		if($tempObjectDB){
			while($tempObjectDB->getNextCursor()){
				$countData = 0;
				$temp1 .= '"'.$tempObjectDB->getNama().'",';
				$tempObjectDBD = $controlSidang->isTesterOfMahasiswa(3,$tahunAk,$tempObjectDB->getIdentified());
				if($tempObjectDBD){
					$countData += $tempObjectDBD->getCountData();
				}
				$temp2 .= $countData.",";
			}
		}
		if($temp2 != ""){
			$temp1 = substr($temp1, 0,strlen($temp1)-1);
			$temp2 = substr($temp2, 0,strlen($temp2)-1);
		}
		$json = '{"data": [[';
		$json .= $temp1;
		$json .= "],[";
		$json .= $temp2;
		$json .= "]]}";
		echo "1".$json;
	}
	public function setNewStatusSeminarTA(){
		$nim = $this->isNullPost('nim');
		$ta = intval($this->isNullPost('ta'));
		$status = intval($this->isNullPost('status'));
		$symbolize = $this->isNullPost('symbolize');
		if($symbolize != 'JASERVTECH-SET-NEW-STATUS-SEMINAR-TA'){
			exit('0anda melakukan debugging terhadap sistem');
		}
		$this->loadLib("Aktor/Mahasiswa");
		$this->loadLib("Inputjaservfilter");
		$mahasiswa = new Mahasiswa(new Inputjaservfilter());
		if(!$mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Nim tidak Valid');
		}
		$this->loadLib('ControlMahasiswa');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit('0nim tidak terdaftar');
		}
		if(intval($tempObjectDB->getStatus()) != 1){
			exit('0nim sudah tidak aktif');
		}
		if($status > 3 || $status < 1){
			exit('0anda melakukan debugging terhadap system');
		}
		if($ta > 2 || $ta < 1){
			exit('0anda melakukan debugging terhadap system');
		}
		$tempResult = false;
		$this->loadLib("ControlTime");
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		if($ta == 1){
			$this->loadLib('ControlSeminar');
			$controlSeminar = new ControlSeminar($this->gateControlModel);
			$tempObjectDBD = $controlSeminar->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified());
			if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
				exit('0nim ini tidak mendaftar seminar ta 1');
			}
			$tempObjectDBD->setDataProses($status);
			if($controlSeminar->tryUpdate($tempObjectDBD)) {exit('1Berhasil melakukan perubahan nilai');}
			exit('0Gagal melakukan perubahan nilai');
		}else{
			$this->loadLib('ControlSidang');
			$controlSidang = new ControlSidang($this->gateControlModel);
			$tempObjectDBD = $controlSidang->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified());
			if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
				exit('0nim ini tidak mendaftar seminar ta 2');
			}
			if(intval($tempObjectDBD->getDataProsesS()) != 2)
				exit('0nim ini belum disetujui dosen pengujinya');
			if(strlen($tempObjectDBD->getFujDL()) < 6)
				exit('0nim ini belum memilih ruangan');
			if(strlen($tempObjectDBD->getFujDP()) < 6)
				exit('0nim ini belum memilih ruangan');
			if(intval($tempObjectDBD->getNilai()) != 0)
				exit('0nim ini sudah diberikan nilai');
			$tempObjectDBD->setDataProsesD($status);
			if($controlSidang->tryUpdate($tempObjectDBD)) {exit('1Berhasil melakukan perubahan status');}
			exit('0Gagal melakukan perubahan status');
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function setValueSeminarTA2(){
		$nim = $this->isNullPost('nim');
		$symbolize = $this->isNullPost('symbolize');
		$value = intval($this->isNullPost('value'));
		if($value > 5 || $value < 0){
			exit('0anda melakukan debugging terhadap sistem');
		}
		if($symbolize != 'JASERVTECH-SET-VALUE-SEMINAR-TA2'){
			exit('0anda melakukan debuging terhadap system');
		}
		$this->loadLib("Aktor/Mahasiswa");
		$this->loadLib("Inputjaservfilter");
		$mahasiswa = new Mahasiswa(new Inputjaservfilter());
		if(!$mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Nim tidak Valid');
		}
		$this->loadLib('ControlMahasiswa');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit('0nim tidak terdaftar');
		}
		if(intval($tempObjectDB->getStatus()) != 1){
			exit('0nim sudah tidak aktif');
		}
		$this->loadLib("ControlTime");
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->loadLib('ControlSidang');
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDBD = $controlSidang->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit('0nim ini tidak mendaftar seminar ta 1');
		}
		if(intval($tempObjectDBD->getDataProsesS()) != 2 || intval($tempObjectDBD->getDataProsesD()) != 2 )
			exit('0Gagal melakukan perubahan nilai');
		$tempObjectDBD->setNilai($value);
		if($controlSidang->tryUpdate($tempObjectDBD)) {exit('1Berhasil melakukan perubahan nilai');}
		exit('0Gagal melakukan perubahan nilai');
	}
	public function setValueSeminarTA1(){
		$nim = $this->isNullPost('nim');
		$symbolize = $this->isNullPost('symbolize');
		$value = intval($this->isNullPost('value'));
		if($value > 5 || $value < 0){
			exit('0anda melakukan debugging terhadap sistem');
		}
		if($symbolize != 'JASERVTECH-SET-VALUE-SEMINAR-TA1'){
			exit('0anda melakukan debuging terhadap system');
		}
		$this->loadLib("Aktor/Mahasiswa");
		$this->loadLib("Inputjaservfilter");
		$mahasiswa = new Mahasiswa(new Inputjaservfilter());
		if(!$mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Nim tidak Valid');
		}
		$this->loadLib('ControlMahasiswa');
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit('0nim tidak terdaftar');
		}
		if(intval($tempObjectDB->getStatus()) != 1){
			exit('0nim sudah tidak aktif');
		}
		$this->loadLib("ControlTime");
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$this->loadLib('ControlSeminar');
		$controlSeminar = new ControlSeminar($this->gateControlModel);
		$tempObjectDBD = $controlSeminar->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
			exit('0nim ini tidak mendaftar seminar ta 1');
		}
		$tempObjectDBD->setNilai($value);
		if($controlSeminar->tryUpdate($tempObjectDBD)) {exit('1Berhasil melakukan perubahan nilai');}
		exit('0Gagal melakukan perubahan nilai');
	}
	
	public function setNewPenguji(){
		$nim = $this->isNullPost('nim');
		$this->loadLib('Inputjaservfilter');
		$this->loadLib('Aktor/Mahasiswa');
		$this->loadLib('Aktor/Dosen');
		$inputJaservFilter = new Inputjaservfilter();
		$mahasiswa = new Mahasiswa($inputJaservFilter);
		$dosen = new Dosen($inputJaservFilter);
		if(!$mahasiswa->getCheckNim($nim,1)[0]){
			exit("0Nim tidak valid");
		}
		$this->loadLib('ControlTime');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0Nim tidak terdaftar");
		}
		if(intval($tempObjectDB->getStatus()) != 1){
			exit('0nim sudah tidak aktif');
		}
		$tempObjectDBTs = $controlRegistrasi->getAllDataWithDosbing($tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBTs || !$tempObjectDBTs->getNextCursor()){
			exit('Nim belum melakukan registrasi tugas akhir');
		}
		$nip = $this->isNullPost('nip');
		if($nip != '0'){
			if(!$dosen->getCheckNip($nip,1)[0]){
				exit("0Nip tidak valid");
			}	
			$tempObjectDBD = $controlDosen->getDataByNip($nip);
			if(!$tempObjectDBD || !$tempObjectDBD->getNextCursor()){
				exit("0Nip tidak terdaftar");
			}
			if($tempObjectDBD->getIdentified() == $tempObjectDBTs->getTableStack(0)->getDosen()){
				exit("0Nip bimbingan, tidak boleh penguji dari yang di bimbing");
			}
		}
		$this->loadLib('ControlSidang');
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDBE = $controlSidang->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBE || !$tempObjectDBE->getNextCursor()){
			exit("0Nim tidak mendaftar seminar ta 2");
		}
		if($tempObjectDBE->getRekomendasi() != '1'){
			if(strlen($tempObjectDBE->getFujDS()) < 6){
				exit("0tidak dapat merubah penguji karena belum mengumpulkan dokumen");
			}
		}
		if(strlen($tempObjectDBE->getFujDP()) > 6 && strlen($tempObjectDBE->getFujDL()) > 6){
			exit("0tidak dapat merubah penguji karena sudah mengumpulkan dokumen");
		}
		$penguji = intval($this->isNullPost('penguji'));
		switch($penguji){
			case 1 : 
				if(strlen($nip) > 10){
					if($tempObjectDBD->getIdentified() == $tempObjectDBE->getDosenD()){
						$tempObjectDBE->setDosenS($tempObjectDBD->getIdentified());
						$tempObjectDBE->setDosenD(" ");
					}else if($tempObjectDBD->getIdentified() == $tempObjectDBE->getDosenT()){
						$tempObjectDBE->setDosenS($tempObjectDBD->getIdentified());
						$tempObjectDBE->setDosenT(" ");
					}else{
						$tempObjectDBE->setDosenS($tempObjectDBD->getIdentified());
					}	
				}else{
					$tempObjectDBE->setDosenS($tempObjectDBD->getIdentified());
				}
				break;
			case 2 :
				if(strlen($nip) > 10){
					if($tempObjectDBD->getIdentified() == $tempObjectDBE->getDosenS()){
						$tempObjectDBE->setDosenS(" ");
						$tempObjectDBE->setDosenD($tempObjectDBD->getIdentified());
					}else if($tempObjectDBD->getIdentified() == $tempObjectDBE->getDosenT()){
						$tempObjectDBE->setDosenD($tempObjectDBD->getIdentified());
						$tempObjectDBE->setDosenT(" ");
					}else{
						$tempObjectDBE->setDosenD($tempObjectDBD->getIdentified());
					}	
				}else{
					$tempObjectDBE->setDosenPD($tempObjectDBD->getIdentified());
				}
				break;
			case 3 :
				if(strlen($nip) > 10){
					if($tempObjectDBD->getIdentified() == $tempObjectDBE->getDosenS()){
						$tempObjectDBE->setDosenS(" ");
						$tempObjectDBE->setDosenT($tempObjectDBD->getIdentified());
					}else if($tempObjectDBD->getIdentified() == $tempObjectDBE->getDosenD()){
						$tempObjectDBE->setDosenT($tempObjectDBD->getIdentified());
						$tempObjectDBE->setDosenD(" ");
					}else{
						$tempObjectDBE->setDosenT($tempObjectDBD->getIdentified());
					}	
				}else{
					$tempObjectDBE->setDosenT($tempObjectDBD->getIdentified());
				}
			break;
			default :
			exit("0kode ta tidak valid");
			break;
		}
		$tempObjectDBE->setDataProsesS(1);
		if($controlSidang->tryUpdate($tempObjectDBE))
			exit("1Status berhasil dirubah");
		else{
			exit("0Status gagal dirubah");
		}
	}
	public function setStatusProsesTester(){
		$nim = $this->isNullPost('nim');
		$status = intval($this->isNullPost('status'));
		$symbolize = $this->isNullPost('symbolize');
		if($symbolize != 'JASERVTECH-SET-STATUS-PROSES-TESTER'){
			exit('0anda melakukan debugging terhadap sistem');
		}
		$this->loadLib('Inputjaservfilter');
		$this->loadLib('Aktor/Mahasiswa');
		
		$inputJaservFilter = new Inputjaservfilter();
		$mahasiswa = new Mahasiswa($inputJaservFilter);
		
		if(!$mahasiswa->getCheckNim($nim,1)[0]){
			exit('0Nim tidak Valid');
		}
		$this->loadLib('ControlTime');
		$this->loadLib('ControlMahasiswa');
		$this->loadLib('ControlDosen');
		$this->loadLib('ControlRegistrasi');
		$tahunAk = (new ControlTime($this->gateControlModel))->getYearNow();
		$controlRegistrasi = new ControlRegistrasi($this->gateControlModel);
		$controlDosen = new ControlDosen($this->gateControlModel);
		$controlMahasiswa = new ControlMahasiswa($this->gateControlModel);
		$tempObjectDB = $controlMahasiswa->getDataByNim($nim);
		if(!$tempObjectDB || !$tempObjectDB->getNextCursor()){
			exit("0Nim tidak terdaftar");
		}
		if(intval($tempObjectDB->getStatus()) != 1){
			exit('0nim sudah tidak aktif');
		}
		if($status > 2 || $status < 1){
			exit('0anda melakukan debugging terhadap system');
		}
		$this->loadLib('ControlSidang');
		$controlSidang = new ControlSidang($this->gateControlModel);
		$tempObjectDBE = $controlSidang->getDataByMahasiswa($tahunAk,$tempObjectDB->getIdentified());
		if(!$tempObjectDBE || !$tempObjectDBE->getNextCursor()){
			exit("0Nim tidak mendaftar seminar ta 2");
		}
		//optional security
		//opening
		if(strlen($tempObjectDBE->getDosenS()) != 40){
			exit('0nim ini belum dipilihkan dosen penguji 1');
		}
		if(strlen($tempObjectDBE->getDosenD()) != 40){
			exit('0nim ini belum dipilihkan dosen penguji 2');
		}
		if(strlen($tempObjectDBE->getFujDP()) > 10){
			exit('0nim ini sudah mengumpulkan FUJ 20');
		}
		if(strlen($tempObjectDBE->getFujDL()) > 10){
			exit('0nim ini sudah mengumpulkan FUJ 25');
		}
		//enclosing
		$tempObjectDBE->setDataProsesS($status);
		if($controlSidang->tryUpdate($tempObjectDBE))
			exit("1Status berhasil dirubah");
		else{
			exit("0Status gagal dirubah");
		}
	}
	
	
}