<?php

$pageName = 'Admin';

session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}

$resumeDetails =& $_SESSION['resume'];



require ("resources/dbMethods.php");

//error messages
$errMsg = '';
$savedMsg = '';
$resumename = '';
$invalid = false;
$user = $resumeDetails['userName'];

$numOfUsers = '';
$userid = Array();
$user_name = Array();
$user_client = Array();
$user_admin = Array();

$toDel = Array();
$roles = Array();

//these will hold the data that needs to be updated
$temp_userid = Array();
$temp_client = Array();
$temp_admin = Array();

//get all the data that was queried the last time
if (array_key_exists('userid', $resumeDetails))
	$userid = $resumeDetails['userid'];
if (array_key_exists('user_client', $resumeDetails))
	$user_client = $resumeDetails['user_client'];
if (array_key_exists('user_admin', $resumeDetails))
	$user_admin = $resumeDetails['user_admin'];

//boolean to flag if the submit button was clicked
$isSubmission = isset($_POST['submission']) && $_POST['submission'] == 'yes';

//now validate if submit was clicked
if ($isSubmission)
{
	if(isset($_POST['todel']))
		$toDel = $_POST['todel'];
	
	if (isset($_POST['roles']))
		$roles = $_POST['roles'];
	
	$count_roles = count($roles);
	debug_to_console($count_roles);
	
	if ($count_roles == count($userid))
	{
		$count_del = count($toDel);
		for ($i = 0; $i < $count_del; $i++)
		{
			$del_user = $toDel[$i];
			if (!in_array($del_user, $userid))
			{
				$errMsg = 'Please do not manipulate the page content this time!';
				$invalid = true;
				break;
			}
		}
		
		//if the del array holds valid data
		if (!$invalid)
		{
			$j = 0;
			for ($i = 0; $i < $count_roles; $i++)
			{
				//find if the to del user id matches 
				//get the index and remove it
				// also for client and admin array 
				debug_to_console($user_client);
				debug_to_console($user_admin);
				
				$role = $roles[$i];
				debug_to_console($role);
				
				if (strcmp($role, 'Client') == 0 && !$user_client[$i])
				{
					$temp_userid[$j] = $userid[$i]; 
					$temp_client[$j] = true;
					$temp_admin[$j] = false;
					$j++;
					debug_to_console('in client');
				}
				else if (strcmp($role, 'Admin') == 0 && !$user_admin[$i])
				{
					$temp_userid[$j] = $userid[$i];
					$temp_client[$j] = false;
					$temp_admin[$j] = true;
					$j++;
					debug_to_console('in admin');
				}
				else if (strcmp($role, 'Client') != 0 && strcmp($role, 'Admin') != 0)
				{
					$errMsg = 'Please do not manipulate the page content this time!';
					$invalid = true;
					break;
				}
			}			
		}
		
		debug_to_console($temp_userid);
		debug_to_console($temp_client);
		debug_to_console($temp_admin);
	}
	else 
	{
		$errMsg = 'Please do not manipulate the page content this time!';
		$invalid = true;
	}
}

//update the data
if (!$invalid && $isSubmission)
{
	if (!updateRoles($temp_userid, $temp_admin, $temp_client))
		$errMsg = 'Error occured while updating the roles. Please try again!';
	if (!deleteUsers($toDel))
		$errMsg = 'Error while deleting users. Please try again!';
}

//reset the arrays
$userid = Array();
$user_name = Array();
$user_client = Array();
$user_admin = Array();

//get all the info to display
if (!getAdminPageData($numOfUsers, $userid, $user_admin, $user_client, $user_name))
	$errMsg = 'Error occured while loading. Please try again!';
else
{
	$resumeDetails['userid'] = $userid;
	$resumeDetails['user_client'] = $user_client;
	$resumeDetails['user_admin'] = $user_admin;
	if ($isSubmission && !$invalid)
		$savedMsg = 'Your changes have been made successfully!';
}

require ("resources/header.php");
require ("resources/navigation.php");
require ("AdminPage.php");


?>