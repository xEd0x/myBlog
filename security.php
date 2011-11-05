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
?>