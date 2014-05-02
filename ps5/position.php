<?php
$pageName = 'Position Sought';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//new session if session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];

//error messages
$errMsg = '';
$positionErr = '';
$savedMsg = '';

//input fields
$position = 'Enter Text Here...';//gets displayed if nothing was entered

$resumename = '';

if (array_key_exists('resumename', $resumeDetails))
	$resumename = $resumeDetails['resumename'];

if (array_key_exists('position', $resumeDetails))
{
	$position = $resumeDetails['position'];
}

//boolean to flag if the submit button was clicked
$isSubmission = isset($_POST['submission']) && $_POST['submission'] == 'yes';

//now evaluate on submit
if ($isSubmission)
{
	//get the input
	if(isset($_POST['position']))
		$position = trim($_POST['position']);
	
	//validate the input
	if ($position == '' || $position == 'Enter Text Here...')
	{
		$positionErr = 'You cant leave this field blank!';
		$errMsg = 'Invalid input detected. Please correct the field below!';
	}
	else//inputs valid
	{
		//store it in the session
		$resumeDetails['position'] = $position;
		$savedMsg = "Your Resume has been updated!";
	}
}

require ("resources/header.php");
require ("resources/navigation.php");
require ("PositionSought.php");


?>