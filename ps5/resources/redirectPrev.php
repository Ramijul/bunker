<?php
function goToPage($page)
{
	$redirect = 'index.php';
	if (strcmp($page, 'Position Sought') == 0)
		$redirect = 'postion.php';
	else if (strcmp($page, 'Employment History') == 0)
		$redirect = 'employment.php';
	else if (strcmp($page, 'Resume') == 0)
		$redirect = 'resume.php';
	header('Location: '.$redirect);	
}