<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

$conf = array (
	'username' => 'username',
	'password' => 'password',
	'host'     => 'localhost',
	'db'       => 'db_name'
);

error_reporting (0);
$db = mysql_connect ($conf ['host'], $conf ['username'], $conf ['password']) or die (mysql_error ());
mysql_select_db ($conf ['db'], $db) or die (mysql_error ());
?>