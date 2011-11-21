/* * * * * * * * * * * *
*                      *
* @Project: myBlog     *
* @Author: xEdox       *
* @Licence: GNU GPL    *
*                      *
* * * * * * * * * * * */

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

function removePost (id) {
	if (confirm ('Sei sicuro di voler eliminare il post numero ' + id + '?')) {
		window.location = 'system/blog.php?delete&id=' + id;
	}
}

function spoil (spoiler) {
	var el = document.getElementById (spoiler);
	
	if (el.style.visibility == 'visible') {
		el.style.visibility = 'hidden';
	}
	else {
		el.style.visibility = 'visible';
	}
}