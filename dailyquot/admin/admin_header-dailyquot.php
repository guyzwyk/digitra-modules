<?php	
	//Libraries Import
	/* require_once("../scripts/incfiles/config.inc.php");
	require_once("../modules/user/library/user.inc.php"); */
	require_once("../modules/dailyquot/library/dailyquot.inc.php");
	$system		= new cwd_system();
	$dailyquot	= new cwd_dailyquot();
	$myRss		= new cwd_rss091();

	require_once("../modules/dailyquot/langfiles/".$langFile.".php"); //Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
	
	//Spry
	$dailyquot->spry_ds_create();
?>

<?php
	$myRss->set_rss_tblInfos($dailyquot->tbl_dailyquot, $dailyquot->fld_dailyquotId, $dailyquot->fld_dailyquotTitle, $dailyquot->fld_dailyquotLib, $dailyquot->fld_dailyquotAuthor, $dailyquot->fld_dailyquotDatePub, $dailyquot->tbl_dailyquotAuthor, $dailyquot->fld_dailyquotAuthorF, $dailyquot->fld_dailyquotAuthorL);
	$myRss->set_rss_link_param($dailyquot->URI_dailyquot, $thewu32_modLink['dailyquot'], $thewu32_modLink['dailyquot']);
	$myRss->rss_customize_layout("CABB :: Verset biblique du jour", "Tous les versets bibliques du jour selon le CABB", $thewu32_site_url.'modules/dailyquot/img/rss_dailyquots.gif', "Versets du jour", "CABB :: Versets du Jour", "");
	//$myRss->se
	$myRss->makeRSS("../modules/dailyquot/rss/dailyquots.xml");
	$admin_pageTitle	=	"Gestionnaire des Citations";
?>