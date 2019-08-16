<?php	
	//Libraries Import
	require_once("../modules/gallery/library/gallery.inc.php");
	require_once("../modules/banner/library/banner.inc.php");
?>

<?php
//Call the language file pack
require("../modules/banner/langfiles/".$langFile.".php"); //Module language pack

//Page name
$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php
	//Module lib initializations
	$myBanner		= new cwd_banner();
	$myBannerImg	= new cwd_gallery("../modules/banner/bans/", "../modules/banner/bans/");
?>