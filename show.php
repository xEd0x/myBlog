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
	
	$query  = "SELECT * FROM `myblog` WHERE `id` = '{$id}'";
	$result = mysql_query ($query) or die (mysql_error ());
	
	$data = mysql_fetch_array ($result, MYSQL_ASSOC);
	$post = bbcode (htmlentities (stripslashes ($data ['post'])));
	print "<br><br>\n";
	print "{$post}<br><br>\n";
	print "Posted by <b>{$data ['author']}</b> on {$data ['date']} at {$data ['time']}";
	print "<br><br>\n";
	
	echo "<br><br><br><br><br><br>Posta un commento: <br><br>
		<form action = 'comments.php?id={$id}' method = 'POST'>\n
			Nome: <input type = 'text' name = 'name'><br>\n
			Testo: <textarea name = 'text' cols = '20' rows = '7'></textarea><br>\n
			<img src = 'captcha.php'><br>\n
			Captcha: <input type = 'text' name = 'captcha'><br>\n
			<input type = 'Submit' value = 'Post'><br>\n
		</form>\n<br><br><br>
		";
	
	$query = "SELECT * FROM `comments` WHERE `post_id` = {$id} ORDER BY `id` DESC";
	$res   = mysql_query ($query) or die (mysql_error ());
	
	while ($comment = mysql_fetch_array ($res, MYSQL_ASSOC)) {
		print "Author: <b>{$comment ['name']}</b>  [{$comment ['date']} ~ {$comment ['time']}]";
		
		if (checkCookie ()) {
			print " [<i>{$comment ['ip']}</i>] [<a href = 'comments.php?delete&ref={$comment ['post_id']}&del={$comment ['id']}'>x</a>]";
		}
		print "<br><br>\n";
		print $comment ['text'] . "<br><br>\n";
		print "<hr>";
	}
}

function bbcode ($code) {
	$cods = $code;
	
	$cods = str_replace ("[b]", "<b>", $cods);
	$cods = str_replace ("[/b]", "</b>", $cods);
	
	$cods = str_replace ("[i]", "<i>", $cods);
	$cods = str_replace ("[/i]", "</i>", $cods);
	
	$cods = str_replace ("[u]", "<u>", $cods);
	$cods = str_replace ("[/u]", "</u>", $cods);
	
	$cods = str_replace ("\n", "<br>", $cods);
	
	if (preg_match ("/\[spoiler\](.*?)\[\/spoiler\]/", $cods, $matches)) {
		$cods = str_replace ("[spoiler]{$matches [1]}[/spoiler]", "<b>SPOILER</b> (<a href = '#' onClick = 'spoil (\"spoiler\");'>Clicca per visualizzare</a>)<div id = 'spoiler'><br>{$matches [1]}<br><br></div>", $cods);
	}
	
	if (preg_match ("/\[code\](.*?)\[\/code\]/", $cods, $matches)) {
		$source = stripCode ($matches [1]);
		$cods   = str_replace ("[code]{$matches [1]}[/code]", "<table id = 'code'>\n<tr>\n<td>\n<b>CODE:</b><br><br><pre>{$source}</pre>\n</td>\n</tr>\n</table>", $cods);
	}
	
	if (preg_match ("/\[img\](.+)\[\/img\]/i", $cods, $matches)) {
		$cods = str_replace ("[img]{$matches [1]}[/img]", "<img src = '{$matches [1]}'>", $cods);
	}
	
	/**
	*
	* Gli url e i video di youtube, sono stati scritti da KinG InFeT
	*
	*/
	
	$search = array(
		"/\\[url\\](.*?)\\[\\/url\\]/is",
		"/\\[url\\=(.*?)\\](.*?)\\[\\/url\\]/is",
		"/\\[youtube\\]http\:\/\/www\.youtube\.com\/watch\?v\=(.*?)\\[\\/youtube\\]/is"
	);
 
	$replace = array(
		"<a target=\"_blank\" href=\"$1\">$1</a>",
		"<a target=\"_blank\" href=\"$1\">$2</a>",
		"<br /><iframe title=\"YouTube video player\" width=\"480\" height=\"390\" src=\"http://www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>"
	);
	
	$cods = preg_replace ($search, $replace, $cods);
	
	return $cods;
}

function stripCode ($code) {
	$source = str_replace ("<br>", "", $code);
	return $source;
}
?>
	</body>
</html>