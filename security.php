<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

function clearRequest ($req) {
	if (isset ($_REQUEST [$req])) {
		$var = mysql_real_escape_string (htmlentities ($_REQUEST [$req]));
		return (get_magic_quotes_gpc () ? stripslashes ($var) : $var);
	}
}

function checkCookie () {
	if (isset ($_COOKIE ['myblog_username']) && isset ($_COOKIE ['myblog_password'])) {
		$username = clearRequest ('myblog_username');
		$password = clearRequest ('myblog_password');
		
		$check = "SELECT * FROM `admin`";	
		$log   = mysql_query ($check) or die (mysql_error ());
		$fetch = mysql_fetch_array ($log, MYSQL_ASSOC);
		
		if ($fetch ['username'] == $username && $fetch ['password'] == $password) {
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

function displayError ($errstr) {
	$query = "SELECT `theme` FROM `admin`";
	$ris   = mysql_query ($query);

	$theme = mysql_fetch_array ($ris, MYSQL_ASSOC);
	
	return <<<ERROR
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv = "Content-Type" content = "text/html; charset=iso-8859-1">
		<link rel = "stylesheet" href = "../style/themes/{$theme ['theme']}" type = "text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
		<title>myBlog</title>
	</head>
	<body style = "display: none" onLoad = "$('body').fadeIn(1500);">
	<br>
	&nbsp; &nbsp; myBlog
	<br><br>
	<hr>
	<a href = '../index.php'>Home</a> &nbsp; &nbsp; <a href = '../login.php'>Login</a> &nbsp; &nbsp; <br><br>
	<br><br>{$errstr}
	</body>
</html>
ERROR;
}
?>