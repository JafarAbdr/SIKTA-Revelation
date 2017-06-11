<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<!DOCTYPE html>
<html lang=en>
<head>
<title><?php echo $title;?></title>
<meta http-equiv=Content-Type content="text/html; charset=utf-8" />
<link rel=icon type=image/ico href="favicon.html"/>
<script type="text/javascript">
	var base_url = "<?php echo base_url();?>";
	var nama_user = '<?php echo $nama;?>';
	var nim_user = '<?php echo $nim;?>';
	var breadCrumb = '<li>Beranda</li>';
</script>
<?php
	for($i=0;array_key_exists($i,$url_link);$i++)
		echo link_tag($url_link[$i]); 
?>
<?php
	for($i=0;array_key_exists($i,$url_script);$i++)
		echo "<script type='text/javascript' src='".base_url().$url_script[$i]."'></script>";
?>
</head>