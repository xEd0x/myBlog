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

if (!checkCookie ()) {
	die ("Fail.");
}
else {
	if (isset ($_GET ['post'])) {
		$author = clearRequest ('myblog_username');
		$title  = clearRequest ('title');
		$post   = mysql_real_escape_string ($_REQUEST ['post']);
		$date   = date ("d-m-y");
		$time   = date ("G:i");
		$query  = "INSERT INTO `myblog` (`author`, `title`, `post`, `date`, `time`) VALUES ('{$author}', '{$title}', '{$post}', '{$date}', '{$time}')";
		if (!@mysql_query ($query, $db)) {
			die (mysql_error ());
		}
		else {
			header ("Location: ../index.php");
		}
	}
	else if (isset ($_GET ['edit'])) {
		$title  = clearRequest ('title');
		$post   = mysql_real_escape_string ($_REQUEST ['post']);
		$id     = intval ($_GET ['id']);
		$query  = "UPDATE `myblog` SET `title` = '{$title}', `post` = '{$post}' WHERE `id` = '{$id}'";
		if (!@mysql_query ($query, $db)) {
			die (mysql_error ());
		}
		else {
			header ("Location: ../index.php");
		}
	}
	else if (isset ($_GET ['delete'])) {
		$id    = intval ($_GET ['id']);
		$query = "DELETE FROM `myblog` WHERE `id` = '{$id}'";
		if (!@mysql_query ($query, $db)) {
			die (mysql_error ());
		}
		else {
			header ("Location: ../index.php");
		}
	}
}
?>