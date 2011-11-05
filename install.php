<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel = "stylesheet" href = "style/style.css" type = "text/css">
		<title>Install myBlog.</title>
	</head>
	<body>
	Configure config.php if you haven't done it yet.<br><br>
	<form action = 'install.php' method = 'POST'>
		Admin name: <input type = 'text' name = 'admin_name'><br>
		Password: <input type = 'password' name = 'password1'><br>
		Retype password: <input type = 'password' name = 'password2'><br>
		E-mail: <input type = 'text' name = 'email'><br>
		<input type = 'submit' value = 'Go'><br>
	</form>
	<?php
	include ('config.php');
	
	if (!empty ($_REQUEST ['admin_name']) && !empty ($_REQUEST ['password1']) && !empty ($_REQUEST ['password2']) && !empty ($_REQUEST ['email'])) {
		if ($_REQUEST ['password1'] == $_REQUEST ['password2']) {
			$admin = $_REQUEST ['admin_name'];
			$pass1 = $_REQUEST ['password1'];
			$email = $_REQUEST ['email'];
			
			$admins = mysql_query ("CREATE TABLE `{$conf ['db']}`.`admin` (
	`username` TEXT NOT NULL ,
	`password` TEXT NOT NULL ,
	`email` TEXT NOT NULL ,
	`theme` TEXT NOT NULL
	) ENGINE = MYISAM ;") or die (mysql_error ());
	
			$posts = mysql_query ("CREATE TABLE `{$conf ['db']}`.`myblog` (
	`author` TEXT NOT NULL ,
	`title` TEXT NOT NULL ,
	`post` TEXT NOT NULL ,
	`date` TEXT NOT NULL ,
	`time` TEXT NOT NULL ,
	`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY
	) ENGINE = MYISAM ;") or die (mysql_error ());
	
			
			$comments = mysql_query ("CREATE TABLE `{$conf ['db']}`.`comments` (
	`name` TEXT NOT NULL ,
	`text` TEXT NOT NULL ,
	`date` TEXT NOT NULL ,
	`time` TEXT NOT NULL ,
	`post_id` TEXT NOT NULL ,
	`ip` TEXT NOT NULL ,
	`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY
	) ENGINE = MYISAM ;") or die (mysql_error ());
	
			$visite = mysql_query ("CREATE TABLE `{$conf ['db']}`.`visite` (
	`ip` TEXT NOT NULL
	) ENGINE = MYISAM ;") or die (mysql_error ());
	
	
			$pass = sha1 (md5 ($pass1));
			$reg = mysql_query ("INSERT INTO `admin` (`username`, `password`, `email`, `theme`) VALUES ('{$admin}', '{$pass}', '{$email}', 'White.css')") or die (mysql_error ());
			print "Done<br>\nYour name: {$admin}<br>\nYour password: {$pass1}<br>\nNow you can delete this file.";
		}
		else {
			die ('Wrong passowrds');
		}
	}
	?>
	</body>
</html>