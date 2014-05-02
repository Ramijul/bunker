<?php
$list = array($resumename => "Active Resume",
			  "Contact Information" => "index.php",
			  "Position Sought" => "position.php",
			  "Employment History" => "employment.php",
			  "Resume" => "resume.php",
			  "Archive" => "archive.php",
		      "Admin Page" => "admin.php",
			  "Help" => "Help.html");

//creates the navigation list
//sets the class to be selected if the curret page matches the key in the array
if (strcmp($pageName, 'Registration') != 0 && strcmp($pageName, 'Login') != 0)
{
	$client = false;
	$admin = false;
	if (array_key_exists('client', $resumeDetails))
		$client = $resumeDetails['client'];
	
	if (array_key_exists('admin', $resumeDetails))
		$admin = $resumeDetails['admin'];
	
	foreach ($list as $key => $val)
	{
		$hide = false;
		if ((strcmp($key, 'Admin Page') == 0) && ($client || !$admin))
			$hide = true;
		else if ((strcmp($key, 'Archive') == 0) && !$client && !$admin)
			$hide = true;
		
		//display the resume name if exists
		if ( (strcmp($val, "Active Resume") == 0)  && (strlen($key) >= 5) )
			echo '<li class="resname">'.$val.': '.$key.'</li>';
		else if (strcmp($key, $pageName) == 0)
			echo '<li class="selected"><a href="'.$val.'">'.$key.'</a></li>';
		else if (!$hide)
			echo '<li><a href="'.$val.'">'.$key.'</a></li>';
	}
}

//records the previous page
if (array_key_exists('current', $resumeDetails))
	$resumeDetails['previous'] = $resumeDetails['current'];

$resumeDetails['current'] = $pageName;
?>
