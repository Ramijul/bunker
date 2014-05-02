<?php
$pageName = 'Resume';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//new session if session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];


$name = '';
$address = '';
$number = '';
$position = '';
$startdate= '';
$enddate = '';
$text = '';
$experience = false;
$resumename = '';

if (array_key_exists('resumename', $resumeDetails))
	$resumename = $resumeDetails['resumename'];

if (array_key_exists('name', $resumeDetails))
{
	$name = $resumeDetails['name'];
}

if (array_key_exists('position', $resumeDetails))
{
	$position = $resumeDetails['position'];
}

if (array_key_exists('address', $resumeDetails))
{
	$address = $resumeDetails['address'];
}

if (array_key_exists('number', $resumeDetails))
{
	$number = $resumeDetails['number'];
}

if (array_key_exists('startdate', $resumeDetails))
{
	$startdate = $resumeDetails['startdate'];
}

if (array_key_exists('enddate', $resumeDetails))
{
	$enddate = $resumeDetails['enddate'];
}

if (array_key_exists('text', $resumeDetails))
{
	$text = $resumeDetails['text'];
}

if (array_key_exists('experience', $resumeDetails))
{
	$experience = $resumeDetails['experience'];
}

if (array_key_exists('numberofjobs', $resumeDetails))
{
	$numberofjobs = $resumeDetails['numberofjobs'];
}

require ("resources/header.php");
require ("resources/navigation.php");
require ("ResumePage.php");


?>