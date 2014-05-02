<?php
$pageName = 'Registration';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];



require ("resources/dbMethods.php");

require 'resources/redirectPrev.php';

//error messages
$errMsg = '';
$nameErr = '';
$loginErr = '';
$passErr = '';

$resumename = '';//for the purpose of navigation bar
$realName = '';
$loginName = '';
$pass = '';
$pass2 = '';
$valid = true;
$page = 'index.php';//default redirect

//the user cancelled
if (isset($_POST['submission']) && $_POST['submission'] == 'cancel')
{	
	if(array_key_exists('previous', $resumeDetails))
		$page = $resumeDetails['previous'];//get the previous page
	
	goToPage($page);//redirect
}


//boolean to flaf if the submit button was clicked
$isSubmission = isset($_POST['submission']) && $_POST['submission'] == 'yes';


//now validate if submit was clicked
if ($isSubmission)
{
	if(isset($_POST['realName']))
		$realName = trim($_POST['realName']);
	
	if(isset($_POST['loginName']))
		$loginName = trim($_POST['loginName']);
	
	if(isset($_POST['pass']))
		$pass = trim($_POST['pass']);
	
	if(isset($_POST['re_pass']))
		$pass2 = trim($_POST['re_pass']);
	
	//check if the login name has been taken or not
	if(loginExists($loginName))
	{
		$loginErr = 'This login name has been taken';
		$valid = false;
	}
	
	//just in case (eventhough they are being validated on the client side)
	if ($realName == "")
	{
		$nameErr = 'You can not leave this field blank!';
		$valid = false;
	}
	if ($pass == "" || strlen($pass) < 8)
	{
		$passErr = 'The password must be atleast 8 characters long';
		$valid = false;
	}
	if (strcmp($pass, $pass) != 0)
	{
		$passErr = 'The passwords do not match';
		$valid = false;
	}
	if (!$valid)
		$errMsg = 'Please correct the following errors';
}

if ($valid && $isSubmission)
{	
	register($loginName, $pass, $realName);
	
	//set the user and role in to the session
	$resumeDetails['user'] = $loginName;
	setUserInfo($loginName, $resumeDetails);
	
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
	require ("RegistrationPage.php");
}


?>