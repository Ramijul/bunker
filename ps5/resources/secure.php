<?php


// Reports if https is in use
function usingHTTPS () {
	return isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != "off");
}

// Redirects to HTTPS
function redirectToHTTPS()
{
	if(!usingHTTPS())
	{
		$redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];		
		//header("Location:$redirect");
		//exit();
	}
}

?>