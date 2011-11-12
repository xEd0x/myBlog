<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

include ('../config.php');
include ('../security.php');

if ($_GET ['mode'] == 'logout') {
	if (checkCookie ()) {
		setcookie ('myblog_username', '', time () - 1, '/');
		setcookie ('myblog_password', '', time () - 1, '/');
		
		header ("Location: ../index.php");
	}
	else {
		die (displayError ('Not logged in.'));
	}
}

if (isset ($_REQUEST ['username'])) {
	if (checkCookie ()) {
		header ("Location: ../index.php");
	}
	
	$username = clearRequest ('username');
	$password = clearRequest ('password');
	$query = "SELECT `password` FROM `admin` WHERE `username` = '{$username}'";
	if (!mysql_query ($query, $db)) {
		die (displayError (mysql_error ()));
	}
	else {
		$fetch = mysql_fetch_array (mysql_query ($query, $db), MYSQL_ASSOC);
		if ($fetch ['password'] == sha1 (md5 ($password))) {
			setcookie ('myblog_username', $username, time () + 3600 * 24 * 30, '/');
			setcookie ('myblog_password', sha1 (md5 ($password)), time () + 3600 * 24 * 30, '/');
			
			header ("Location: ../index.php");
		}
		else {
			header ("Location: ../index.php");
		}
	}
}

if (isset ($_REQUEST ['change'])) {
	if (!checkCookie ()) {
		die (displayError ('Fail.'));
	}
	
	$pass1 = clearRequest ('pass1');
	$pass2 = clearRequest ('pass2');
	
	if ($pass1 == $pass2) {
		$pass = sha1 (md5 ($pass1));
		$query = "UPDATE `admin` SET `password` = '{$pass}'";
		if (!mysql_query ($query, $db)) {
			die (displayError (mysql_error ()));
		}
		else {
			setcookie ('myblog_username', '', time () - 1, '/');
			setcookie ('myblog_password', '', time () - 1, '/');
			header ("Location: ../index.php");
		}
	}
}

if (isset ($_REQUEST ['theme'])) {
	if (!checkCookie ()) {
		die (displayError ('Fail.'));
	}
	
	$theme = clearRequest ('theme');
	
	$styles = glob ('../style/themes/*.css');
	$types  = array ();
	
	foreach ($styles as $style) {
		$name = explode ('/', $style);
		$s    = $name [count ($name) - 1];
		
		array_push ($types, $s);
	}
	
	
	if (!in_array ($theme, $types)) {
		die (displayError ('Invalid theme.'));
	}
	
	$query = "UPDATE `admin` SET `theme` = '{$theme}'";
	if (!mysql_query ($query, $db)) {
		die (displayError (mysql_error ()));
	}
	else {
		header ("Location: /index.php");
	}
}
?>