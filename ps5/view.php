<?php

$resumename = '';
$user = '';

//for debuging purposes
function debug_to_console( $data ) {

	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

	echo $output;
}

if (isset($_REQUEST['resName']))
	$resumename = $_REQUEST['resName'];
if (isset($_REQUEST['login']))
	$user = $_REQUEST['login'];


$name = '';
$address = '';
$number = '';
$position = '';
$startdate = Array();
$enddate = Array();
$text = Array();
$errMsg = '';
$numOfJobs = 0;
$experience = false;

require 'resources/getViewDetails.php';

require ("resources/viewHeader.php");
require ("viewBody.php");
?>
