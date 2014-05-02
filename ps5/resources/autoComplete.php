
<?php
session_start();//resume session

if (!isset($_SESSION['resume'])) {
	$_SESSION['resume'] = Array();//create new session if the session doesnt exist
}



function openConnection()
{
	$pw = '915198305';
	$DBH = new PDO ( "mysql:host=atr.eng.utah.edu;dbname=cs4540_ramijuli", 'cs4540_ramijuli', $pw);
	$DBH->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	return $DBH;
}

if (!isset($_GET['term']))
	exit();

/**
 * Send debug code to the Javascript console
 */
function debug_to_console($data) {
	if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
}

$resumeDetails =& $_SESSION['resume'];
$user = $resumeDetails['user'];

$name = trim($_GET['term']);
$data = Array();
try
{
	$name = mysql_real_escape_string($name);
	$user = mysql_real_escape_string($user);
	
	$DBH = openConnection();
	$DBH->beginTransaction();
	
	$stmt = $DBH->prepare("select resumeName from ps5_Personal_Info where resumeName like ? and user = ?");
	$stmt->bindValue(1, $name."%");
	$stmt->bindValue(2, $user);
	
	$stmt->execute();
	
	while ($row = $stmt->fetch()) {
		$retVal = $row['resumeName'];
		$data[] = Array('label' => $retVal , 'value' => $retVal);
	}
}
catch (PDOException $e)
{
	
}

echo json_encode($data);

