<?php
require 'resources/word.php';
function openConnection()
{
	global $pw;
	$DBH = new PDO ( "mysql:host=atr.eng.utah.edu;dbname=cs4540_ramijuli", 'cs4540_ramijuli', $pw);
	$DBH->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	return $DBH;
}
?>