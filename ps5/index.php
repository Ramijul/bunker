<?php
$pageName = 'Contact Information';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];

//error messages
$errMsg = '';
$nameErr = '';
$addressErr = '';
$numberErr = '';

//field values
$name = '';
$address = '';
$number = '';
$savedMsg = '';
$resumename = '';

if (array_key_exists('resumename', $resumeDetails))
	$resumename = $resumeDetails['resumename'];

if (array_key_exists('name', $resumeDetails))
	$name = $resumeDetails['name'];

if (array_key_exists('address', $resumeDetails))
	$address = $resumeDetails['address'];

if (array_key_exists('number', $resumeDetails))
	$number = $resumeDetails['number'];

//indicates that this page has been filled (for the purpose of saving)
if ($name != ''  && $address != '' && $number != '' && !array_key_exists('contactInfo', $resumeDetails))
	$resumeDetails['contactInfo'] = 'modified';

//boolean to flaf if the submit button was clicked
$isSubmission = isset($_POST['submission']) && $_POST['submission'] == 'yes';

//now validate if submit was clicked
if ($isSubmission)
{
	$allValid = true;
	//get the inputs
	if(isset($_POST['person']))
		$name = trim($_POST['person']);
	
	if (isset($_POST['address']))
		$address = trim($_POST['address']);
	
	if (isset($_POST['number']))
		$number = $_POST['number'];
	
	//validate name
	if ($name == '')
	{
		$nameErr = 'Name cannot be empty!';
		$allValid = false;
	}
	
	//validate address
	if ($address == '')
	{
		$addressErr = 'Address cannot be empty!';
		$allValid = false;
	}
	
	//validate number
	if ($number == '' || !(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $number)))
	{
		$numberErr = 'Invalid phone number!';
		$allValid = false;
	}
	if ($allValid)
	{
		//store the inputs in the session
		$resumeDetails['name'] = $name;
		$resumeDetails['address'] = $address;
		$resumeDetails['number'] = $number;
		$resumeDetails['contactInfo'] = 'modified';
		$savedMsg = "Your Resume has been updated!";
	}
	else if(!$allValid)
		$errMsg = 'Invalid input(s) detected. Please correct the field(s) below!';
}

require ("resources/header.php");
require ("resources/navigation.php");
require ("ContactInfo.php");


?>