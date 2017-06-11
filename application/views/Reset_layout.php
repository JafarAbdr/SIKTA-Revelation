<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIATA Di bangun ulang | Masuk</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url();?>resources/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>resources/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/iCheck/square/blue.css">
	<script>
	<?php
		echo "var kodeValidity = '".$kodeValidity."';";
		echo "var base_url = '".base_url()."';";
	?>
	</script>
	<?php
		for($i=0;array_key_exists($i,$url_link);$i++)
			echo link_tag($url_link[$i]); 
	?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
  </head>
  <body class="">
    <div class="login-box">
      <div class="login-logo">
        <a class="white-blur"><b>SIATA</b> - INFORMATIKA</a>
      </div><!-- /.login-logo -->
      <div id="signInLayout"  class="login-box-body">
        <p class="login-box-msg">Reset Password</p>
        <form target='frame-layout' id="masuk-form-validation" action="<?php echo htmlspecialchars(base_url()."gateinout/getSignIn.aspx");?>" method="post" >
         <div class="form-group has-feedback">
          <div></div>
            <input type="password" class="form-control" id="set-password" name="set-password" placeholder="Password baru">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
          	<div></div>
            <input type="password" class="form-control" placeholder="Password konfirmasi" id="set-password-con" name="set-password-con">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
          <div class="col-xs-8">
          
          <!-- 
              <div class="checkbox icheck">
                <label >
                  <input type="checkbox"> Ingatkan saya
                </label>
              </div>
              -->
            </div><!-- /.col -->
           
            <div class="col-xs-4">
              <button type="button" onclick='resetPassword()' class="btn btn-primary btn-block btn-flat" id="login-exe">Ubah</button>
            </div><!-- /.col -->
          </div>
        </form>
        <a class="text-center pointer" href='<?php echo base_url();?>Gateinout.aspx' id="getBackto">Ingin masuk</a><br>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>resources/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url();?>resources/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>resources/plugins/iCheck/icheck.min.js"></script>
    
	<?php
		for($i=0;array_key_exists($i,$url_script);$i++)
			echo "<script type='text/javascript' src='".base_url().$url_script[$i]."'></script>";
	?>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
      <footer>
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0.1 Beta
        </div>
        <strong>Copyright &copy; 2014-<?php echo DATE('Y')?> <a>Jaserv Studio</a>.</strong> All rights reserved.
      </footer>
      <div class="background-page">
      	<div class="layer-background-page"></div>
      	<div class="image-background-page"></div>
      </div>
      <iframe class="hidden" id="frame-layout" name="frame-layout"></iframe>
  </body>
</html>
