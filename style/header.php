<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

include_once ('config.php');

$query = "SELECT `theme` FROM `admin`";
$ris   = mysql_query ($query);

$theme = mysql_fetch_array ($ris, MYSQL_ASSOC);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv = "Content-Type" content = "text/html; charset=iso-8859-1">
		<link rel = "stylesheet" href = "<?php print 'style/themes/' . $theme ['theme']; ?>" type = "text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
		<title>myBlog</title>
		<script>
var myRequest = null;

function CreateXmlHttpReq (handler) {
	var xmlhttp = null;
	xmlhttp     = new XMLHttpRequest();
  
	xmlhttp.onreadystatechange = handler;
	return xmlhttp;
}

function myHandler () {
	if (myRequest.readyState == 4 && myRequest.status == 200) {
		div = document.getElementById ('post');
		div.style.display = 'none';

		div.innerHTML = myRequest.responseText;
		$("div").show ("slow");

	}
}

function showPost (id) {
	myRequest = CreateXmlHttpReq (myHandler);

	myRequest.open ("GET", "show.php?id=" + id);
	myRequest.send (null);
}
</script>
	</head>
	<body style = "display: none" onLoad = "$('body').fadeIn(1500);">
	<br>
	&nbsp; &nbsp; myBlog
	<br><br>
	<hr>
	<a href = 'index.php'>Home</a> &nbsp; &nbsp; <a href = 'login.php'>Login</a> &nbsp; &nbsp; <br><br>