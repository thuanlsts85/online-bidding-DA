<?php 
session_start(); 
$text = rand(10000,99999); 
$_SESSION["vercode"] = $text;  
$image_p = imagecreatetruecolor(50, 24); 
$black = imagecolorallocate($image_p, 0, 0, 0); 
$white = imagecolorallocate($image_p, 255, 255, 255); 
$font_size = 14; 
imagestring($image_p,rand(1, 7), rand(1, 7),
rand(1, 7), $text, $white);
// VERY IMPORTANT: Prevent any Browser Cache!!
header("Cache-Control: no-store,
        no-cache, must-revalidate"); 
// The PHP-file will be rendered as image
header('Content-type: image/png'); 
// Finally output the captcha as jpeg img
imagepng($image_p); 
// Free memory
imagedestroy($image_p);
?>