<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

$image = imageCreate (60, 30);

$white = imageColorAllocate ($image, 255, 255, 255);
$black = imageColorAllocate ($image, 0, 0, 0);

$str = substr (md5 (rand ()), 0, 5);
imageLine ($image, rand (1, 10), rand (10, 20), rand (20, 30), rand (30, 40), $black);
imageLine ($image, rand (30, 40), rand (20, 30), rand (10, 20), rand (1, 10), $black);
imageLine ($image, rand (1, 15), rand (15, 30), rand (20, 25), rand (30, 35), $black);
imageString ($image, 5, 2, 10, $str, $black);

header ("Content-type: image/png");
imagePng ($image);
imageDestroy ($image);
session_start ();
$_SESSION ['captcha'] = md5 ($str);
?>