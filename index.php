<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

define ('AUTHOR', 'xEdox');
define ('VERSION', '1.2');

include ('config.php');
include ('style/header.php');
include ('security.php');

if (checkCookie ()) {
	print "Welcome {$_COOKIE ['myblog_username']}<br>\n";
	print "<a href = 'system/post.php'>Post</a> &nbsp; &nbsp;";
	print "<a href = 'system/change.php'>Change password</a> &nbsp; &nbsp;";
	print "<a href = 'system/theme.php'>Change Theme</a> &nbsp; &nbsp;";
	print "<a href = 'system/admin.php?mode=logout'>Logout</a><br>\n";
}
	
print "<br><br><br>\n<div id = 'post'>";

$take   = "SELECT * FROM `myblog`";
$result = mysql_query ($take);
$num    = mysql_num_rows ($result);
	
if ($num % 10 > 0) {
	$pages = (int) ($num / 10) + 1;
}
else {
	$pages = (int) ($num / 10);
}
	
if (isset ($_GET ['id'])) {
	$id   = intval ($_GET ['id']);
	$from = abs ($id - 1) * 10;
	$to = 10;
}
else {
	$from = 0;
	$to   = 10;
}

$query = "SELECT * FROM `myblog` ORDER BY `id` DESC LIMIT {$from},{$to}";
$ris   = mysql_query ($query) or die (mysql_error ());

while ($_TEXT = mysql_fetch_array ($ris, MYSQL_ASSOC)) {
	print "[{$_TEXT ['date']} · {$_TEXT ['time']}] ~ <a onClick = 'showPost ({$_TEXT ['id']});' href = '#'>{$_TEXT ['title']}</a>";
	
	if (checkCookie ()) {
		print " [<a  onClick = 'removePost ({$_TEXT ['id']});' href = '#'>x</a>] [<a href = 'system/edit.php?id={$_TEXT ['id']}'>edit</a>]\n";
	}
	
	print "<br>\n";
}

print "<br><br><center>\n";

for ($c = 1; $c <= $pages; $c++) {
	if ($c == 1) {
		print "<span id = 'num' style = 'border: 0px'><a href = 'index.php'>{$c}</a></span> ";
	}
	else {
		print "<span id = 'num' style = 'border: 0px'> <a href = 'index.php?id={$c}'>{$c}</a> </span> ";
	}
}

print "</div></center><br><br>\n";

print "<p align = 'right'>" . AUTHOR . "<br>\nVersion: " . VERSION . "<br>\nVisite: " . seen () . "<br>\n";

print "</div>";
print "</body>";
print "</html>";

function seen () {
	$ip = $_SERVER ['REMOTE_ADDR'];
	
	$select = "SELECT `ip` FROM `visite` WHERE `ip` = '{$ip}'";
	$res    = mysql_query ($select) or die (mysql_error ());
	
	$num = "SELECT * FROM `visite`";
	$ret = mysql_query ($num) or die (mysql_error ());

	if (mysql_num_rows ($res) == 1) {		
		return mysql_num_rows ($ret);
	}
	else {
		$ins = "INSERT INTO `visite` (`ip`) VALUES ('{$ip}')";
		mysql_query ($ins) or die (mysql_error ());
		
		return mysql_num_rows ($ret) + 1;
	}
}
?>