<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

include ('config.php');
include ('security.php');

if (isset ($_GET ['id'])) {
	$id = intval ($_GET ['id']);

	$name = clearRequest ('name');
	$text = clearRequest ('text');
	
	if (empty ($name)) {
		$name = "Anonimo";
	}
	
	if (empty ($text)) {
		header ("Location: index.php");
	}
	
	$captcha = md5 ($_REQUEST ['captcha']);
	
	session_start ();
	if ($captcha == $_SESSION ['captcha']) {
		$date = date ("d-m-y");
		$time = date ("G:i");
		$ip   = $_SERVER ['REMOTE_ADDR'];
		
		$query = "INSERT INTO `comments` (`name`, `text`, `date`, `time`, `post_id`, `ip`) VALUES ('{$name}', '{$text}', '{$date}', '{$time}', '{$id}', '{$ip}')";
		mysql_query ($query) or die (mysql_error ());
		header ("Location: index.php");
	}
	else {
		die ("<script> alert ('Wrong captcha.'); </script>");
	}
}

else if (isset ($_GET ['delete'])) {
	if (isset ($_GET ['del']) && isset ($_GET ['ref'])) {
		if (checkCookie ()) {
			include ('config.php');
			
			$id  = intval ($_GET ['del']);
			$ref = intval ($_GET ['ref']);
			$query = "DELETE FROM `comments` WHERE `post_id` = '{$ref}' AND `id` = '{$id}'";
			mysql_query ($query) or die (mysql_error ());
			header ("Location: index.php");
		}
		else {
			header ("Location: index.php");
		}
	}
}
?>