<?php
session_start();
$image=imagecreatetruecolor(100,30);
$bgcolor=imagecolorallocate($image,255,255,255);
imagefill($image,0,0,$bgcolor);
$code='';
for($i=0;$i<4;$i++)
{
	$data='abcdefghijk123456789';
	$fontsize=6;
	$color=imagecolorallocate($image,rand(0,120),rand(0,120),rand(0,120));
	$fontcontent=substr($data,rand(0,strlen($data)-1),1);

	$x=($i*100/4)+rand(5,10);
	$y=rand(5,10);
	imagestring($image,$fontsize,$x,$y,$fontcontent,$color);
		$code=$code.$fontcontent;
}
$_SESSION['ycode']=$code;
for($i=0;$i<200;$i++)
{
	$pointcolor=imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
	imagesetpixel($image,rand(1,99),rand(1,29),$pointcolor);
}
for($i=0;$i<4;$i++)
{
	$linecolor=imagecolorallocate($image,rand(80,255),rand(80,255),rand(80,255));
	imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
}


header('content-type:image/png');
imagepng($image);
imagedestroy($image);

?>