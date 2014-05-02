
<!-- decided to seperate out this portion form the html files beacuse these lines are same in all the 
other files. -->
<!DOCTYPE html>
<!--
Author: Ramijul Islam

-->

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/> <!-- css -->
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<title>Resume Builder <?php echo $resumename;?></title>
</head>
<body>
	<div id="page">
		<div id="navigation">
			<h1>Resume Builder</h1>
			
			<span id="userName"></span> <span  id="logout" class="link"> <a href="logout.php"> Logout </a> </span> <!-- will display a welcome message if signed in -->
			
			
			<span  id="register" class="link"> <a href="registration.php"> Register </a> </span>
			<span id="login" class="link"> <a href="login.php"> Login </a> </span>
			</br></br></br>
			
			<script>
				$(document).ready(function(){
					var user = "";
					<?php if (array_key_exists('userName', $resumeDetails)) { ?>
		
					user = <?php echo '"'.$resumeDetails['userName'].'";'; } ?>
		
					if (user == "")
					{
						$("#userName").hide();
						$("#logout").hide();
					}
					else
					{
						$("#userName").html(user);
						$("#register").hide();
						$("#login").hide();
					}
				});
			</script>
			
			<ul id="navBar">
			