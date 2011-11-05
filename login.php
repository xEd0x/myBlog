<?php
/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

include ('style/header.php');
?>

<form action = "system/admin.php" method = "POST">
Username: <input type = "text" name = "username"><br>
Password: <input type = "password" name = "password"><br>
<input type = "submit" value = "Login">
</form>
</body>
</html>