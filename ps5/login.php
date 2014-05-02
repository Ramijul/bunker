<?php
$pageName = 'Login';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];



require ("resources/dbMethods.php");

require 'resources/redirectPrev.php';

//error messages
$errMsg = '';
$loginName = '';
$pass = '';
$valid = true;

$resumename = '';//for the purpose of navigation bar

$page = 'index.php';//default redirect


//boolean to flaf if the submit button was clicked
$isSubmission = isset($_POST['submission']) && (strcmp($_POST['submission'], 'login') == 0);
debug_to_console($isSubmission? 'true' :'false');

//now validate if submit was clicked
if ($isSubmission)
{	
	if(isset($_POST['loginName']))
		$loginName = trim($_POST['loginName']);
	
	if(isset($_POST['pass']))
		$pass = trim($_POST['pass']);
	
	//check if the login name has been taken or not
	if($loginName == '' ||!loginExists($loginName))
		$valid = false;
	//check if the password matches at this point the login name must have matched
	else if ($pass == '' || !passMatched($pass, $loginName))
		$valid = false;
	
	if (!$valid)
		$errMsg = 'The login name and/or password was incorrect. Please try again';
}

if ($valid && $isSubmission)
{
	//set the user and role in to the session
	setUserInfo($loginName, $resumeDetails);
		
	if(array_key_exists('previous', $resumeDetails))
		$page = $resumeDetails['previous'];//get the previous page
	
	goToPage($page);//redirect
}
//the user calcelled
else if (isset($_POST['submission']) && strcmp($_POST['submission'], 'cancel') == 0)
{	
	if(array_key_exists('previous', $resumeDetails))
		$page = $resumeDetails['previous'];//get the previous page
	
	goToPage($page);//redirect
}
else
{
	require ("resources/secure.php");
	
	redirectToHTTPS();//get secure connection
	require ("resources/header.php");
	require ("resources/navigation.php");
	require ("LoginPage.php");
}


?>