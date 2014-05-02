<?php
$pageName = 'Archive';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];



require ("resources/dbMethods.php");

//error messages
$errMsg = '';
$nameErr = '';
$savedMsg = '';

$resumename = '';
$action = '';//determine what action the user wants to take
$allValid = false;
$user = $resumeDetails['userName'];
$login = $resumeDetails['user'];

$openView = false;

if (array_key_exists('resumename', $resumeDetails))
	$resumename = $resumeDetails['resumename'];

//boolean to flaf if the submit button was clicked
$isSubmission = isset($_POST['submission']) && $_POST['submission'] == 'yes';

//now validate if submit was clicked
if ($isSubmission)
{
	if(isset($_POST['subType']))
		$action = trim($_POST['subType']);
	if(isset($_POST['resumeName']))
		$resumename = trim($_POST['resumeName']);
	
	//validate the name if subtype matches
	if((strcmp($action, 'delete') == 0) || (strcmp($action, 'save') == 0) || (strcmp($action, 'load') == 0) || (strcmp($action, 'view') == 0))
	{
		if (!(preg_match("/^[a-zA-Z]{5,20}$/", $resumename)))
		{
			$errMsg = 'Invalid input detected. Please correct the field below!';
			$nameErr = 'You have entered an invalid name';
		}		
		//at this point it doesnt matter if the name exists during the save action
		//so in any other case check if the name exists in the db
		else if ((strcmp($action, 'save') != 0) && !nameExists($resumename))
		{
			$errMsg = 'Invalid input detected. Please correct the field below!';
			$nameErr = 'The name you entered does not exist. Please select a valid name!';
		}
		else //passed validation
		{
			$allValid = true;
		}
	}
	else
	{
		$errMsg = "Please don't do that!";//the user must have done something funky
	}
}

if ($allValid)
{
	$resumeDetails['resumename'] = $resumename;
	//save
	if (strcmp($action, "save") == 0)
	{
		if (save($resumename))
			$savedMsg = "Your resume has been saved!";
		else
			$errMsg = "Encountered a problem while saving the resume. Be sure to check all the inputs!";
	}
	//delete
	else if (strcmp($action, "delete") == 0)
	{
		if (delete($resumename))
			$savedMsg = "Your resume has been deleted successfully!";
		else
			$errMsg = "Encountered a problem while deleting the resume. Please try again!";
	}
	//load
	else if (strcmp($action, "load") == 0)
	{
		if (load($resumename))
			$savedMsg = "Your resume has been loaded. You may go to each of the sections to review them!";
		else
			$errMsg = "Encountered a problem while loading the resume. Please try again!";
	}
	//view
	else if (strcmp($action, "view") == 0)
	{
		//open the view page in a new window if view button was clicked, after
		//validating the name.
		$openView = true;
	}
}


require ("resources/header.php");
require ("resources/navigation.php");
require ("ArchivePage.php");


?>