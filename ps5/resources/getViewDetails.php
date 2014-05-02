<?php

require 'resources/connectDB.php';

//saves the data by the resume name

try {

	$DBH = openConnection();
	$DBH->beginTransaction();
	
	//sanitize the input
	$resname = mysql_real_escape_string($resumename);
	$user = mysql_real_escape_string($user);
	
	debug_to_console("in get view details");
	debug_to_console($resname);
	debug_to_console($user);

	$stmt = $DBH->prepare("select * from ps5_Personal_Info where resumeName = ? and user = ?");
	$stmt->bindValue(1, $resname);
	$stmt->bindValue(2, $user);
	$stmt->execute();

	debug_to_console("got the personal info");
	
	while ($row = $stmt->fetch()) {
		$name = ($row['name'] !== NULL)? $row['name']:'';
		$address = ($row['address'] !== NULL)? $row['address']:'';
		$number = ($row['phoneNumber'] !== NULL)? $row['phoneNumber']:'';
		$position = ($row['positionSought'] !== NULL)? $row['positionSought']:'';
	}

	debug_to_console($name);
	debug_to_console($address);
	debug_to_console($number);
	debug_to_console($position);
	
	$stmt = $DBH->prepare("select * from ps5_Job_History where resume_name = ? and user_name = ?");
	$stmt->bindValue(1, $resname);
	$stmt->bindValue(2, $user);
	$stmt->execute();

	debug_to_console("Got the job details");
	
	$rowNum = 0;
	while ($row = $stmt->fetch()) {
		$rowNum++;
		$experience = true;
		array_push($startdate, ($row['startDate'] == NULL) ? '' : $row['startDate']);
		array_push($enddate, ($row['endDate'] == NULL) ? '' : $row['endDate']);
		array_push($text, ($row['descr'] == NULL) ? '' : $row['descr']);
	}
	$numOfJobs = $rowNum;
	
	debug_to_console($rowNum);
	debug_to_console($startdate);
	debug_to_console($enddate);
	debug_to_console($text);
}
catch (PDOException $e) {

	debug_to_console("error in database interaction");
	$errMsg = 'There was a problem while loading the resume. Please try again!';
}


?>