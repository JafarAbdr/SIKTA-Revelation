<?php
//script counter
//exit("hello");
header("location:http://siata.if.undip.ac.id");
exit();
$path = "images/";
$ext = ".png";
$file = "counter.txt";
$file_array = file($file);
$hitung = $file_array[0];
$hitung++;
$fp = fopen($file, "w");
fputs($fp, $hitung);
fclose($fp);
header("location:index2.php");
?>