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
            <li> <a class="pointer grey-blur" id="home-layout"> <span class=icon-home></span> beranda </a> </li>
            <li class=dropdown> <a class='dropdown-toggle pointer' data-toggle=dropdown><span class=icon-pencil></span> registrasi ta <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a class="pointer" id="registrasi-baru-layout"> baru</a></li>
                <li><a class="pointer" id="registrasi-lama-layout"> lama</a></li>
              </ul>
            </li>
            <li class=dropdown> <a class="pointer dropdown-toggle" data-toggle=dropdown><span class=icon-pencil></span> seminar ta <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a class="pointer" id="seminar-ta1-layout"> pertama</a></li>
                <li><a class="pointer" id="seminar-ta2-layout"> kedua</a></li>
              </ul>
            </li>
            <li class=dropdown> <a class='dropdown-toggle pointer' data-toggle=dropdown><span class=icon-globe></span> lihat <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a class="pointer" id="lihat-dosen-layout"> dosen</a></li>
                <li><a class="pointer" id="lihat-bimbingan-layout"> bimbingan</a></li>
              </ul>
            </li>
            <li><a class="pointer" id="bantuan-layout"><span class=icon-cogs></span> bantuan</a></li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="row content-top-static">
  	<div class="col-md-12">
  	 <ol class="breadcrumb" id="content-breadcrumb">
  	  <li>beranda</li> 
  	  </ol> 
  	 </div>
  </div>
<div class='row'>