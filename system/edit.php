<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

include_once ('../config.php');

$query = "SELECT `theme` FROM `admin`";
$ris   = mysql_query ($query);

$theme = mysql_fetch_array ($ris, MYSQL_ASSOC);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv = "Content-Type" content = "text/html; charset=iso-8859-1">
		<link rel = "stylesheet" href = "<?php print '../style/themes/' . $theme ['theme']; ?>" type = "text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
		<title>myBlog</title>
	</head>
	<body style = "display: none" onLoad = "$('body').fadeIn(1500);">
	<br>
	&nbsp; &nbsp; myBlog
	<br><br>
	<hr>
	<a href = '../index.php'>Home</a> &nbsp; &nbsp; <a href = '../login.php'>Login</a> &nbsp; &nbsp; <br><br>
	
<?php
include ('../config.php');

$id    = intval ($_GET ['id']);
$query = "SELECT * FROM `myblog` WHERE `id` = '{$id}'";
$ris   = mysql_query ($query) or die (mysql_error ());

$data = mysql_fetch_array ($ris, MYSQL_ASSOC);
?>
	<form action = "blog.php?edit&id=<? print $id; ?>" method = "POST">
		New title: <input type = "text" name = "title" value = "<? print stripcslashes ($data ['title']); ?>"><br>
		New text: <textarea name = "post" cols = "40" rows = "14"><? print stripcslashes ($data ['post']); ?></textarea><br>
		<input type = "submit" value = "Edit">
	</form>
	</body>
</html>