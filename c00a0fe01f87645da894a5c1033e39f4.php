<?php
include "system/core/ce52be6c2416624adf15d1782ed729b1.php";
#nim trouble
$varce52be6c2416624adf15d1782ed729b1->addKode("NIM-CODE-1","Nim tidak ditemukan");
$varce52be6c2416624adf15d1782ed729b1->addKode("NIM-CODE-2","Nim tersedia");
#nip trouble
$varce52be6c2416624adf15d1782ed729b1->addKode("NIP-CODE-1","Nip tidak ditemukan");
$varce52be6c2416624adf15d1782ed729b1->addKode("NIP-CODE-2","Nip tersedia");
$varce52be6c2416624adf15d1782ed729b1->addKode("NIP-CODE-3","Nip tidak tersedia");
#Registrasi
$varce52be6c2416624adf15d1782ed729b1->addKode("REGISTRASI-CODE-1","Belum Mendaftar Tugas Akhir");
$varce52be6c2416624adf15d1782ed729b1->addKode("REGISTRASI-CODE-2","Belum dipilihkan dosen pembimbing Tugas Akhir");
#sidang 
$varce52be6c2416624adf15d1782ed729b1->addKode("SIDANG-CODE-1","Belum Mendaftar Sidang");
$varce52be6c2416624adf15d1782ed729b1->addKode("SIDANG-CODE-2","belum memilih waktu sidang");
#seminar
$varce52be6c2416624adf15d1782ed729b1->addKode("SEMINAR-CODE-1","Belum Mendaftar Seminar");
if(isset($_GET['key']))
	$varce52be6c2416624adf15d1782ed729b1->show($_GET['key']);
else
	$varce52be6c2416624adf15d1782ed729b1->show();