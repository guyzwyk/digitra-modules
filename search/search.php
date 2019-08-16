<?php
	require_once ('library/search.inc.php');
	$mySearch		= new cwd_search();
	$searchPage		= $myPage->get_pages_modules_links("search", $_SESSION["LANG"]);
	$searchesPage	= "&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['SEARCH_BOX_LINK_ALL']."\" href=\"".$searchPage.".html\">".$lang_output['SEARCH_BOX_LINK_ALL']."</a>";
	//$searchLast	= $myAnnonce->cwdBoxed($lang_output["ANNONCE_RBOX_TITLE"], $myAnnonce->load_recent_annonce(5, $annoncePage), $annoncesPage);
	
	if($_REQUEST[mod] == "search"){
		$pageContent 	.= 	$mySearch->search_page($_POST['txtSearch'], $_SESSION[LANG], $mod_lang_output['SRC_NOT_FOUND']);
	}