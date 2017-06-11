<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<body>
<div class=container>
  <div class='row header-static'>
    <div class=col-md-12>
      <nav class="navbar" role=navigation>
      	<div class=navbar-header>
          <button type=button class=navbar-toggle data-toggle=collapse data-target=.navbar-ex1-collapse> <span class=sr-only>Toggle navigation</span> <span class=icon-reorder></span> </button>
          <a class=navbar-brand href="http://undip.ac.id/"><img src="resources/mystyle/image/undip.png"/></a> 
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse back-black-blur grey-blur">
          <ul class="nav navbar-nav">
            <li><a class="pointer grey-blur" id="acara-layout"> <span class=icon-home></span> Acara </a> </li>
            <li><a id="registrasi-layout" class=' grey-blur pointer' data-toggle=dropdown><span class=icon-pencil></span> registrasi ta </a></li>
            <li><a id="seminar-layout" class="pointer  grey-blur" data-toggle=dropdown><span class=icon-pencil></span> seminar ta </a></li>
			 <li class=dropdown> <a class='dropdown-toggle pointer' data-toggle=dropdown><span class=icon-pencil></span> Dosen <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
				<li><a id="dosen-layout" class=' grey-blur pointer' data-toggle=dropdown><span class=icon-globe></span> List terdaftar </a></li>
				<li><a id="rekap-layout" class=' grey-blur pointer' data-toggle=dropdown><span class=icon-globe></span> Rekapitulasi </a></li>
              </ul>
            </li>
			<li><a class="pointer grey-blur" id="mahasiswa-layout"> <span class=icon-globe></span> Mahasiswa </a> </li>
            <li><a class="pointer  grey-blur" id="bantuan-layout"><span class=icon-cogs></span> bantuan</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="row content-top-static">
  	<div class="col-md-12">
  	 <ol class="breadcrumb" id="content-breadcrumb">
  	  <li>Acara</li> 
  	  </ol> 
  	 </div>
  </div>
<div class='row'>