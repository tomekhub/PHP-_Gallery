<?php
  header("Content-type: image/jpeg");
  $name = 'photos/'.$_GET['obraz'];
  $im = imagecreatefromjpeg($name);
  $dane = getimagesize($name);
  $sze = $dane[0];
  $wys = $dane[1];
  $odsteph = 110;
  $fsize = 90;
  $color1 = imagecolorallocate($im,255,255,255);
  imagettftext($im, $fsize, 0, 20, $odsteph, $color1, "Outwrite.ttf", "thomaspro.pl");  
  //imagestring($im,5,10,10,"thomaspro.pl",$color1);
  imagejpeg($im);
  imagedestroy($im);
?>