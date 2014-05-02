<?php

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];

$resumeDetails["userName"] = '';
$resumeDetails["name"] = '';
$resumeDetails["position"] = '';
$resumeDetails["address"] = '';
$resumeDetails["number"] = '';
$resumeDetails["startdate"] = '';
$resumeDetails["enddate"] = '';
$resumeDetails["text"] = '';
$resumeDetails["experience"] = '';
$resumeDetails["numberofjobs"] = '';
$resumeDetails["resumename"] = '';
$resumeDetails["client"] = '';
$resumeDetails["admin"] = '';



$redirect = "http://" . $_SERVER['HTTP_HOST'] . "/ps5/index.php";
header("Location:$redirect");
exit();

?>