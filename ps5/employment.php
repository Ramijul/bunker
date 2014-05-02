<?php
$pageName = 'Employment History';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];

$numberOfJobs = "1";
//error messages
$errMsg = '';
$startDateErr = Array();
$endDateErr = Array();
$textErr = Array();

//field values
$startdate = Array();
$enddate = Array();
$text = Array();
$savedMsg = '';

$startdate[0] = '';
$enddate[0] ='';
$text[0] = ''; 

$resumename = '';

if (array_key_exists('resumename', $resumeDetails))
	$resumename = $resumeDetails['resumename'];

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

if (array_key_exists('numberofjobs', $resumeDetails))
{
	$numberOfJobs = $resumeDetails['numberofjobs'];
}

for ($j = 0; $j< $numberOfJobs; $j++)
{
	$startDateErr[$j] = '';
	$endDateErr[$j] = '';
	$textErr[$j] ='';
}

//boolean to flaf if the submit button was clicked
$isSubmission = isset($_POST['submission']) && $_POST['submission'] == 'yes';

//now validmate if submit was clicked
if ($isSubmission)
{
	//get the inputs
	if(isset($_POST['startDate']))
		$startdate = $_POST['startDate'];	
	
	if (isset($_POST['endDate']))
		$enddate = $_POST['endDate'];
	
	if (isset($_POST['text']))
		$text = $_POST['text'];
	
	if (isset($_POST['num']))
		$numberOfJobs = $_POST['num'];
	
	//check if this optional section has been left blank or not
	//we continue validating if atleast one of the fields has been 
	//filled out. 
	$hasStart = (count($startdate) > 0) ? true : false;
	$hasEnd = (count($enddate) > 0) ? true : false;
	$hasText = (count($text) > 0) ? true : false;
	
	$experience = true;//true if the user has entered anythign at all in the job fields
	if (!$hasStart && !$hasEnd && !$hasText)
		$experience = false;	

	//no matter what the experience needs to be in the session, it will be helpful in the resume page
	$resumeDetails['experience'] = $experience;
	
	$invalid = false;
	for ($i = 0; $i < $numberOfJobs; $i++)
	{
		$start = '';
		$end = '';
		$descr = '';
		
		if ($hasStart)
		{
			$start = trim($startdate[$i]);
		}
		
		if ($hasEnd)
		{
			$end = trim($enddate[$i]);
		}
		
		if ($hasText)
		{
			$descr = trim($text[$i]);
		}
		
		$startDateErr[$i] = '';
		$endDateErr[$i] = '';
		$textErr[$i] = '';
		
		//validate only if atleast one of the fields has been filled
		if($start != '' || $end != '' || $descr != '')
		{
			$needsErrMsg = false;	
			//validate name
			if (!validateDate($start))
			{
				$invalid = true;
				if ($start == '')
					$startDateErr[$i] = 'This field cannot be blank';
				else 
					$startDateErr[$i] = 'Invalid Date';
			}
			
			//validate address
			if (!validateDate($end))
			{
				$invalid = true;
				if ($end == '')
					$endDateErr[$i] = 'This field cannot be blank';
				else 
					$endDateErr[$i] = 'Invalid Date';
			}
			if ($descr == "")
			{
				$invalid = true;
				$textErr[$i] = 'You cannot leave this field empty!';
			}
		}
	}
	
	if (!$invalid)
	{
		$resumeDetails['startdate'] = $startdate;
		$resumeDetails['enddate'] = $enddate;
		$resumeDetails['text'] = $text;
		$resumeDetails['numberofjobs'] = $numberOfJobs;
		$savedMsg = "Your Resume has been updated!";
	}
	else 
		$errMsg = "Invalid input(s) detected. Please correct the field(s) below! Eventhough its optional, you have to fill out all the fields or nothing at all.";
}
else
{
	//executes when a resume is being loaded
	for ($i = 0; $i < $numberOfJobs; $i++)
	{
		$startDateErr[$i] = '';
		$endDateErr[$i] = '';
		$textErr[$i] = '';
	}
}


function validateDate($date)
{
	$valid = false;
	$regex = '/[0-9]{2}\/[0-9]{2}\/(20|19)[0-9]{2}/';
	if (preg_match($regex, $date))
	{
		$valid = true;
	}
	return $valid;
}

require ("resources/header.php");
require ("resources/navigation.php");
require ("EmpHistory.php");


?>