<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>

  </div>
  <div class='row footer-static'>
    <div class='page-footer'>
      <div class='page-footer-wrap' >
        <div class="side pull-left"> Copyirght &copy; 2014-<?php echo DATE('Y');?> Jaserv Studio. All rights reserved. </div>
      </div>
    </div>
  </div>
  <div class="background-page">
      <div class="layer-background-page"></div>
      <div class="image-background-page"></div>
  </div>
</div>
<div style="display: none; bottom: 45px;" class="statusbar" id="statusbar-loading"> 
	<div class="statusbar-icon"><img src="resources/taurus/img/loader.gif"></div> 
	<div class="statusbar-text" id="loading-pesan">Sedang melakukan proses ...</div>
</div>
<?php
	for($i=0;array_key_exists($i,$url_link);$i++)
		echo link_tag($url_link[$i]); 
?>
<?php
	for($i=0;array_key_exists($i,$url_script);$i++)
		echo "<script type='text/javascript' src='".base_url().$url_script[$i]."'></script>";
?>
<!--<div style="display : block; position : fixed; bottom:100px; left : 14px;">-->
<div style="display : block; position : fixed; bottom:46px; right : -5px;">
	<div style="width : 100px; /* background-color : black; */ border-radius : 0px 50px 50px 0px; padding-top : 0.07px; ">
		<div style="margin-top : -10px;" class="cortana">
			<span></span>
		</div>
		<!--
		<br style="line-height:0px;">
		<h1 class="caption">Assistance</h1>
		<div style="margin-left:auto; margin-right : auto;">
		<label style="margin-left : 29px;" class="switch">
		  <input type="checkbox" checked onchange="
		  if(this.checked){
				$('#slider-cortana').css({'background-color':'#2196F3'});
				$('#bullet').css({'transform':'translateX(20px)'});
				jaservtechCortana = true;
		  }else{
				$('#slider-cortana').css({'background-color':'#ccc'});
				$('#bullet').css({'transform':'translateX(0px)'});
				 jaservtechCortana = false;
		  }
		  ">
		  <div class="slider round" id="slider-cortana">
			<div class="gg" id="bullet"></div>
			</div>
		</label>
		-->
	</div>
	</div>
<div>
</body>
</html>