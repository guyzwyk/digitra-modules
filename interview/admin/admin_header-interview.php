<?php	
	//Libraries Import
	require_once("../modules/interview/library/interview.inc.php");
	$myInterview	= new cwd_interview();

	
	//Call the language file pack
    require("../modules/interview/langfiles/".$langFile.".php"); //Module language pack
?>