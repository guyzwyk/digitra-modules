<?php
    //Library call
    require('../modules/event/langfiles/'.$langFile.'.php');
	$event		= 	new cwd_event();
	$myCal		=	new CALENDAR($_POST['cmbYear'], $_POST['cmbMonth']);
?>

<?php	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>