<?php

require 'resources/connectDB.php';

//saves the data by the resume name
function save($name) 
{
	if (nameExists($name))
	{
		debug_to_console("in save nameExists true");
		return updateRows($name);
	}
	else 
	{
		debug_to_console("in save nameExists fasle");
		return insertRow($name);
	}
}


/****************** New code begins **************************/

//update the required tables
function updateRows($name)
{
	$resumeDetails = $GLOBALS["resumeDetails"];
	//indicates information from which pages need to be inserted
	$infoPage = false;//indicates if contact info page has been filled
	$hasPosition = false;//indicates if position sought page has been filled
	$experience = false;//indicates if experience page has been filled
	
	//all the fields required for the updates
	$person = '';
	$phone = '';
	$address = '';
	$position = '';
	$startdate = Array();
	$enddate = Array();
	$text = Array();
	$numOfJobs = '';
	$user = $resumeDetails['user'];
	
	if (array_key_exists('experience', $resumeDetails) )
		$experience = $resumeDetails['experience'];
	
	debug_to_console("in update rows ");
	
	//now insert them as appropriate
	try
	{
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$query = "";
		$stmt = "";
		
		//set up the data required for the updating the info page
		if (array_key_exists('contactInfo', $resumeDetails) && (strcmp($resumeDetails['contactInfo'], 'modified') == 0))
		{
			//these three fields would never be blank if the contact information page was modified
			$person = $resumeDetails['name'];
			$address = $resumeDetails['address'];
			$phone = $resumeDetails['number'];
			
			$query = "update ps5_Personal_Info set name = ?, phoneNumber = ?, address = ? where resumeName = ? and user = ?";
			$stmt = $DBH->prepare($query);
			
			$stmt->bindValue(1, mysql_real_escape_string($person));
			$stmt->bindValue(2, mysql_real_escape_string($phone));
			$stmt->bindValue(3, mysql_real_escape_string($address));
			$stmt->bindValue(4, mysql_real_escape_string($name));
			$stmt->bindValue(5, mysql_real_escape_string($user));
			
			$stmt->execute();
		}
		if (array_key_exists('position', $resumeDetails))
		{
			$position = $resumeDetails['position'];
			
			$query = "update ps5_Personal_Info set positionSought = ? where resumeName = ? and user = ?";
			$stmt = $DBH->prepare($query);
				
			$stmt->bindValue(1, mysql_real_escape_string($position));
			$stmt->bindValue(2, mysql_real_escape_string($name));
			$stmt->bindValue(3, mysql_real_escape_string($user));
			
			$stmt->execute();
		}
		if ($experience)
		{
			$stmt = $DBH->prepare("select count(jobNumber) as count from ps5_Job_History where resume_name like ? and user_name like ?");
			$stmt->bindValue(1, mysql_real_escape_string($name));
			$stmt->bindValue(2, mysql_real_escape_string($user));
			$stmt->execute();
			
			debug_to_console("in experience");
			
			$count = '';
			while ($row = $stmt->fetch())
				$count = $row['count'];
			
			//delete any rows that exist by the resume name provided
			if ($count > 0)
			{
				$stmt = $DBH->prepare("delete from ps5_Job_History where resume_name like ? and user_name like ?");
				$stmt->bindValue(1, mysql_real_escape_string($name));
				$stmt->bindValue(2, mysql_real_escape_string($user));
				$stmt->execute();
			}
			debug_to_console($count);
			
			//insert the new rows
			//get all the stored data from session for the experience page
			$numOfJobs = $resumeDetails['numberofjobs'];
			$enddate = $resumeDetails['enddate'];
			$startdate = $resumeDetails['startdate'];
			$text = $resumeDetails['text'];
			
			debug_to_console($numOfJobs);
			debug_to_console($enddate);
			debug_to_console($startdate);
			debug_to_console($text);
			
			$query = "insert into ps5_Job_History (user_name, resume_name, startDate, endDate, descr) values";
				
			//execute the above query as many times as jobs were entered
			for ($i = 0; $i < $numOfJobs; $i++)
			{
				$comma = '';
				
			if ($i >= 1)
				$comma = ',';
					
				$query .= "$comma (?,?,?,?,?)";
			}
				
			$stmt = $DBH->prepare($query);
			
			$k = 1;
			for ($j = 0; $j < $numOfJobs; $j++)
			{
				$stmt->bindValue($k++, mysql_real_escape_string($user));
				$stmt->bindValue($k++, mysql_real_escape_string($name));
				$stmt->bindValue($k++, mysql_real_escape_string($startdate[$j]));
				$stmt->bindValue($k++, mysql_real_escape_string($enddate[$j]));
				$stmt->bindValue($k++, mysql_real_escape_string($text[$j]));
			}
			
			
			$stmt->execute();
			debug_to_console("executed experience");
		}
		$DBH->commit();
		return true;
	}
	catch (PDOException $e) 
	{
		return false;
	}
}
/******************End of new code***************************/


//inserts rows into both tables according to user inputs
//the tables are Personal_Info (holds everything but the employment history inputs);
//and, Job_History (one row for each job).
function insertRow($name)
{
	debug_to_console("in insert rows");
	
	$resumeDetails = $GLOBALS["resumeDetails"];
	//indicates information from which pages need to be inserted
	$resumeDetailsPage = false;//indicates if contact info page has been filled
	$hasPosition = false;//indicates if position sought page has been filled
	$experience = false;//indicates if experience page has been filled
	
	$user = $resumeDetails['user'];
	//all the fields required for the insert statements
	$person = '';
	$phone = '';
	$address = '';
	$position = '';
	$startdate = Array();
	$enddate = Array();
	$text = Array();
	$numOfJobs = '';
	
	//set up the data required for the inserts
	if (array_key_exists('contactInfo', $resumeDetails) && (strcmp($resumeDetails['contactInfo'], 'modified') == 0))
	{
		debug_to_console("adding personal info");
		//these three fields would never be blank if the contact information page was modified
		$person = $resumeDetails['name'];
		$address = $resumeDetails['address'];
		$phone = $resumeDetails['number'];
		
		$resumeDetailsPage = true;
	}

	if (array_key_exists('position', $resumeDetails))
	{
		debug_to_console("adding position");
		$position = $resumeDetails['position'];
		$hasPosition = true;
	}
	
	if (array_key_exists('experience', $resumeDetails))
		$experience = $resumeDetails['experience'];
	
	if ($experience)
	{
		//get all the stored data from session for the experience page
		$numOfJobs = $resumeDetails['numberofjobs'];
		$enddate = $resumeDetails['enddate'];
		$startdate = $resumeDetails['startdate'];
		$text = $resumeDetails['text'];
		
		debug_to_console("adding experience");
		debug_to_console($numOfJobs);
		debug_to_console($enddate);
		debug_to_console($startdate);
		debug_to_console($text);
	}
	
	//now insert them as appropriate
	try{
		$DBH = openConnection();
		$DBH->beginTransaction();
		
		$query = "";
		$stmt = "";
		
		//info page or the position page has been completed
		if ($resumeDetailsPage || $hasPosition)
		{
			debug_to_console("inserting personal info");
			//only insert the values that have been filled out
			//assuming that the none of the two pages can be partially filled.
			if ($resumeDetailsPage && $hasPosition)
			{
				$query = "insert into ps5_Personal_Info (user, resumeName, name, address, phoneNumber, positionSought) values (?,?,?,?,?,?)";
				$stmt = $DBH->prepare($query);
				$stmt->bindValue(1, mysql_real_escape_string($user));
				$stmt->bindValue(2, mysql_real_escape_string($name));
				$stmt->bindValue(3, mysql_real_escape_string($person));
				$stmt->bindValue(4, mysql_real_escape_string($address));
				$stmt->bindValue(5, mysql_real_escape_string($phone));
				$stmt->bindValue(6, mysql_real_escape_string($position));
				debug_to_console($stmt->queryString);
				debug_to_console("inserting two pages");
			}
			else if ($resumeDetailsPage && !$hasPosition)
			{
				$query = "insert into ps5_Personal_Info (user, resumeName, name, address, phoneNumber) values (?,?,?,?,?)";
				$stmt = $DBH->prepare($query);
				$stmt->bindValue(1, mysql_real_escape_string($user));
				$stmt->bindValue(2, mysql_real_escape_string($name));
				$stmt->bindValue(3, mysql_real_escape_string($person));
				$stmt->bindValue(4, mysql_real_escape_string($address));
				$stmt->bindValue(5, mysql_real_escape_string($phone));

				debug_to_console("inserting contact page");
			}
			else if (!$resumeDetailsPage && $hasPosition)
			{
				$query = "insert into ps5_Personal_Info (user, resumeName, position) values (?,?,?)";
				$stmt = $DBH->prepare($query);
				$stmt->bindValue(1, mysql_real_escape_string($user));
				$stmt->bindValue(2, mysql_real_escape_string($name));
				$stmt->bindValue(3, mysql_real_escape_string($position));
				
				debug_to_console("inserting position page");
			}
			$stmt->execute();
		}		
		if ($experience)//if experience page has been filled out
		{
			debug_to_console("inserting in experience");
			
			$query = "insert into ps5_Job_History (user_name, resume_name, startDate, endDate, descr) values";
			
			//execute the above query as many times as jobs were entered 
			for ($i = 0; $i < $numOfJobs; $i++)
			{	
				$comma = '';
				if ($i >= 1)
					$comma = ',';
				$query .= "$comma (?,?,?,?,?)";
			}

			$stmt = $DBH->prepare($query);
			$name = mysql_real_escape_string($name);
			$user = mysql_real_escape_string($user);
			
			$k = 1;
			for ($j = 0; $j < $numOfJobs; $j++)
			{
				$stmt->bindValue($k++, $user);
				$stmt->bindValue($k++, $name);
				$stmt->bindValue($k++, mysql_real_escape_string($startdate[$j]));
				$stmt->bindValue($k++, mysql_real_escape_string($enddate[$j]));
				$stmt->bindValue($k++, mysql_real_escape_string($text[$j]));
			}
			$stmt->execute();
		}
		$DBH->commit();
		return true;
	}
	catch (PDOException $e) {
		return false;
	}
}

//deletes the resume by its name
function delete($name)
{
	try {
		$resumeDetails = $GLOBALS["resumeDetails"];
		$user = $resumeDetails['user'];
		//sanitize the input
		$name = mysql_real_escape_string($name);
		$user = mysql_real_escape_string($user);
	
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$stmt = $DBH->prepare("delete from ps5_Personal_Info where resumeName = ? and user = ?");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $user);
		$stmt->execute();
		$DBH->commit();
		return true;
	}
	catch (PDOException $e) {
		return false;
	}	
}

//loads the resume
function load($name)
{
	try {
	
		$resumeDetails =& $GLOBALS["resumeDetails"];
		$user = $resumeDetails['user'];
		//sanitize the input
		$name = mysql_real_escape_string($name);
		$user = mysql_real_escape_string($user);
	
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$stmt = $DBH->prepare("select * from ps5_Personal_Info where resumeName = ? and user = ?");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $user);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$resumeDetails['resumename'] = $row['resumeName'];
			$resumeDetails['name'] = ($row['name'] !== NULL)? $row['name']:'';
			$resumeDetails['address'] = ($row['address'] !== NULL)? $row['address']:'';
			$resumeDetails['number'] = ($row['phoneNumber'] !== NULL)? $row['phoneNumber']:'';
			$resumeDetails['position'] = ($row['positionSought'] !== NULL)? $row['positionSought']:'';
		}
		
		$stmt = $DBH->prepare("select * from ps5_Job_History where resume_name = ? and user_name = ?");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $user);
		$stmt->execute();
		
		$sDate = Array();//start date
		$eDate = Array();//end date
		$jobDescr = Array();//text
		$rowNum = 0;
		while ($row = $stmt->fetch()) {
			$rowNum++;
			$resumeDetails['experience'] = true;
			array_push($sDate, $row['startDate']);
			array_push($eDate, $row['endDate']);
			array_push($jobDescr, $row['descr']);
		}
		$resumeDetails['resumename'] = $name;
		$resumeDetails['numberofjobs'] = $rowNum;
		$resumeDetails['startdate'] = $sDate;
		$resumeDetails['enddate'] = $eDate;
		$resumeDetails['text'] = $jobDescr;
		
		setUserInfo($user, $resumeDetails);
		
		return true;
	}
	catch (PDOException $e) {
		return false;
	}
}

//checks if a Resume Name exists in the db
//returns true if found
function nameExists($name) {
	try {
		$resumeDetails =& $GLOBALS["resumeDetails"];
		$login = $resumeDetails['user'];
		//sanitize the input
		$name = mysql_real_escape_string($name);
		$login = mysql_real_escape_string($login);
		
		$DBH = openConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("select count(resumeName) as count from ps5_Personal_Info where resumeName = ? and user = ?");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $login);
		$stmt->execute();
		
		$count = '';
		while ($row = $stmt->fetch())
			$count = $row['count'];
		
		debug_to_console("name exist count " .$count);
		if ($count == 1)
			return true;
		else
			return false;
		
	}
	catch (PDOException $e) {
		return false;
	}
}

//sets the user name, and whether or not this person is a 
//client or admin. stores them to te provided array. which could be the
//the array in the session.
function setUserInfo($user, &$array)
{
	try {
		//sanitize the input
		$user = mysql_real_escape_string($user);
		
		$DBH = openConnection();
		$DBH->beginTransaction();
		
		$stmt = $DBH->prepare("select * from Roles where user_name = ?");
		$stmt->bindValue(1, $user);
		$stmt->execute();
		
		$row = $stmt->fetch();
		$client = $row['client'];
		$admin = $row['admin'];
		$userName = $row['realName'];		
		
		debug_to_console("admin " .$admin);
		$array['client'] = $client;
		$array['admin'] = $admin;
		$array['userName'] = $userName;
		$array['user'] = $user;
		return true;
	}
	catch (PDOException $e) {
		return false;
	}
}

//checks if a login name exists in the db
//returns true if found
function loginExists($loginName) {
	try {

		//sanitize the input
		$loginName = mysql_real_escape_string($loginName);

		$DBH = openConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("select user_name from Roles where user_name = ?");
		$stmt->bindValue(1, $loginName);
		$stmt->execute();

		if((strcmp($stmt->fetch()['user_name'], $loginName) == 0))
			return true;
		else
			return false;
	}
	catch (PDOException $e) {
		return false;
	}
}

//Assuming a user only register once, the password is hashed
//and the data is entered into the table setting the user as a client
function register($login, $pass, $realName)
{
	//generates pseudo random bytes worth 10 characters long
	//and sets $strong to true if the salt is strong enough
	//the is diferent(ish) for each user. the hash of password along with the salt is stored
	//in the roles table. This helps securing the data better.
		
// 	$bytes = openssl_random_pseudo_bytes(10, $strong);
// 	$salt   = bin2hex($bytes); // convert to hex

	//unfortunately openssl is not supported (i have to install it)
	//so I will be generating random numbers and converting them to hex
	
	$r = mt_rand()  * mt_rand();//long int
	$salt   = dechex($r) ; // convert to hex
	
	$hash = getHash($pass, $salt);//get the hash of password and salt appended
	
	try{
		$login = mysql_real_escape_string($login);
		
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$query = "insert into Roles (user_name, client, admin, realName) values (?,?,?,?)";
		$stmt = $DBH->prepare($query);
		$stmt->bindValue(1, $login);
		$stmt->bindValue(2, true);//client
		$stmt->bindValue(3, false);
		$stmt->bindValue(4, mysql_real_escape_string($realName));
	
		$stmt->execute();
		
		
		$query = "insert into Users (user_name, password, salt) values (?,?,?)";
		$stmt = $stmt = $DBH->prepare($query);
		$stmt->bindValue(1, $login);
		$stmt->bindValue(2, $hash);
		$stmt->bindValue(3, $salt);		
		$stmt->execute();
		
		$DBH->commit();
		return true;
	}
		catch (PDOException $e) {
		return false;
	}
}

//checks if the password matches with the password provided in the 
//registration process. The salt is diferent for each user (some what)
//and is stored in the database along with the hashed password.
//I will be adding the salt to this password and rehash it to check if
//they match
function passMatched($pass, $user)
{
	
	try {	
		//sanitize the input
		$user = mysql_real_escape_string($user);
	
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$stmt = $DBH->prepare("select * from Users where user_name = ?");
		$stmt->bindValue(1, $user);
		$stmt->execute();
		$row = $stmt->fetch();
		$dbPass = $row['password'];
		$salt = $row['salt'];
		debug_to_console($salt);
		$hash = getHash($pass, $salt);
		
		if (strcmp($hash,$dbPass) == 0)//comparing the two hash values
			return true;
		else
			return false;
	}
	catch (PDOException $e) {
		return false;
	}
}

//prepends the salt to the password
//then return the hash value of it which is 40 characters long
function getHash($pass, $salt)
{
	$toHash = $salt.$pass;
	return sha1($toHash);
}

//delete all the users
function deleteUsers($userid)
{
	try {	
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$stmt = $DBH->prepare("delete from Roles where user_name = ?");
		
		$count = count($userid);
		
		for ($i = 0; $i < $count; $i++)
		{
			$stmt->bindValue(1, $userid[$i]);
			$stmt->execute();
		}
		$DBH->commit();
		return true;
	}
	catch (PDOException $e) {
		return false;
	}
}

//update all the user data
function updateRoles($userid, $user_admin, $user_client)
{
	try {
		//sanitize the input
		$DBH = openConnection();
		$DBH->beginTransaction();

		$stmt = $DBH->prepare("update Roles set admin = ?, client = ? where user_name = ?");

		$count = count($userid);
		
		for ($i = 0; $i < $count; $i++)
		{			
			$stmt->bindValue(1, $user_admin[$i]);
			$stmt->bindValue(2, $user_client[$i]);
			$stmt->bindValue(3, $userid[$i]);			

			$stmt->execute();
		}
		$DBH->commit();
		return true;
	}
	catch (PDOException $e) {
		return false;
	}
}

//gets all the user data
function getAdminPageData(&$num_users, &$userid, &$user_admin, &$user_client, &$user_name)
{
	try {
		//sanitize the input
		$DBH = openConnection();
		$DBH->beginTransaction();
	
		$stmt = $DBH->prepare("select * from Roles");
		$stmt->execute();
		
		while ($row = $stmt->fetch())
		{
			array_push($userid, $row["user_name"]);
			array_push($user_admin, $row["admin"]);
			array_push($user_client, $row["client"]);
			array_push($user_name, $row["user_name"]);
			$num_users++;
		}
		
		return true;
	}
	catch (PDOException $e) {
		return false;
	}
}

//for debuging purposes
function debug_to_console( $data ) {

	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

	echo $output;
}
?>