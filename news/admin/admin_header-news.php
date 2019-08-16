<?php	
	//Libraries Import
	/*require_once("../scripts/incfiles/config.inc.php");
	require_once ("../scripts/incfiles/page.inc.php");
	require_once("../modules/news/library/news.inc.php");
	require_once("../modules/gallery/library/gallery.inc.php"); */
	//require_once("fckeditor/fckeditor.php");
	$news		= 	new cwd_news();
	$myPage		= 	new cwd_page();

//Call the language file pack
require("../modules/news/langfiles/".$langFile.".php"); //Module language pack

//Page name
$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php
	
	//Rss settings NB : Prevoir une page speciale pour la generation du flux RSS qui prendra en compte la specificite linguistique
	//$pageNews	= 	$myPage->get_pages_modules_links("news", $_POST[sel_newsLang]);
	$pageNews	= 	$myPage->get_pages_modules_links("news", 'EN');
	$myRss		= 	new cwd_rss091($pageNews);
	
	$myRss->set_rss_tblInfos($news->tbl_news, $news->fld_newsId, $news->fld_newsDescr, $news->fld_newsTitle, $news->fld_newsAuthId, $news->fld_newsDatePub, $news->tbl_newsAuth, $news->fld_newsAuthFirstName, $news->fld_newsAuthLastName);	
	$myRss->set_rss_link_param("", $pageNews.'-detail-', $pageNews.'-detail-'); //Varie selon chaque module	
	$myRss->set_rss_header("CABB News - Actualit� de la R�gion du Nord-Ouest", $myRss->get_datetime(), "NWR News - Actualit� RNO", $thewu32_site_url.'rss/rss.xml', "theWu32 Feeder", $thewu32_site_url.'modules/new/img/rss_news.gif', "NWR News", $thewu32_site_url.'modules/news/img/rss_news.gif', "Actualit&eacute; RNO");
	//$myRss->rss_customize_layout("Actualit� de l'Emploi au Cameroun", "Toutes l'actualit� de l'Emploi au Cameroun", $thewu32_site_url.'modules/job/img/rss_news.gif', "Actualit� Emploi Cameroun", "Actualit� Emploi Cameroun", "");
	$admin_pageTitle	=	"Gestionnaire des News";
	
	//Preparing the news spry dataset
	//$news->news_dsPath	=	'../modules/news/spry/data/spry-news.xml';
	//$news->create_ds_news($pageNews);
	//print "Page News :".$pageNews;
	$news->spry_ds_create();
?>
