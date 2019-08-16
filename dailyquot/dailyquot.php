<?php
	require_once ('library/dailyquot.inc.php');
	$mydailyquot			= 	new cwd_dailyquot();
	$dailyquotPage			= 	$myPage->get_pages_modules_links("dailyquot", $_SESSION["LANG"]); //$thewu32_modLink[dailyquot]; 
	$dailyquotPages			= 	"&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['DQ_BOX_LINK_ALL']."\" href=\"".$dailyquotPage.".html\">".$lang_output['DQ_BOX_LINK_ALL']."</a>";
	//$dailyquotLast		= 	$mydailyquot->cwdBoxed($lang_output["DQ_RBOX_TITLE"], $mydailyquot->load_recent_dailyquot(5, $dailyquotPage, $_SESSION["LANG"]), $dailyquotPages);
	//$dailyquotLast		= 	$mydailyquot->cwdBoxed($lang_output["DQ_RBOX_TITLE"], $mydailyquot->load_previous_dailyquots(5, $dailyquotPage, $_SESSION["LANG"]), '');
	$tab_dailyquotActual	=	$mydailyquot->get_actual_dailyquot($_SESSION["LANG"]);
	$dailyquotActual		= 	$mydailyquot->load_actual_dailyquot($dailyquotPage, "Plus de detail", $_SESSION["LANG"]);
	
	//:::::::::::::::::::::::::::::::dailyquot Module:::::::::::::::::::::::::::::::
	
	if($_REQUEST['level'] 	== 'front'){
		$dailyquotPages		= 	"&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['DQ_BOX_LINK_ALL']."\" href=\"".$dailyquotPage.".html\">".$lang_output['DQ_BOX_LINK_ALL']."</a>";
		//$dailyquotLast	= 	$mydailyquot->cwdBoxed($lang_output["DQ_RBOX_TITLE"], $mydailyquot->load_recent_dailyquot(5, $dailyquotPage, $_SESSION["LANG"]), $dailyquotPages);
		$dailyquotActual	= 	$mydailyquot->load_actual_dailyquot($dailyquotPage, "Plus de detail", $_SESSION["LANG"]);
	}
	elseif($_REQUEST['mod'] 	== 'dailyquot'){
		$modSecondaryMenu	= $mydailyquot->cwdBoxed($lang_output["DQ_RBOX_CAT_TITLE"], $mydailyquot->load_dailyquot_cat($dailyquotPage, $lang_output["DQ_CAT_ERR"], $_SESSION["LANG"]), '');
		if($_REQUEST['level'] == "inner"){
			//Current quote
			$dailyquotActual		= 	$mydailyquot->load_actual_dailyquot($dailyquotPage, "Plus de detail", $_SESSION["LANG"]);
			
			$dailyquotPages			= 	"&raquo; <a class=\"lnk_gray\" title=\"".$lang_output['DQ_BOX_LINK_ALL']."\" href=\"".$dailyquotPage.".html\">".$lang_output['DQ_BOX_LINK_ALL']."</a>";
			//print_r (pathinfo($dailyquotPage));
			$mydailyquot->limit		= 	$_REQUEST['limite'];
			$pageTitle				= 	$lang_output["DQ_PAGE_TITLE"];			  // $number=5, $page_dailyquotDetail='dailyquot_read.php', $lang='FR', $pageDailyquot='dailyquots.php'
			$pageContent			.= 	stripslashes($mydailyquot->load_previous_dailyquots(100, $dailyquotPage, $_SESSION["LANG"], '&raquo;&nbsp;'.$lang_output["READ_MORE"]));
			$pageHeader				= 	$lang_output["DQ_PAGE_HEADER"]; //strip_tags(stripslashes($dailyquotTitle));
			//$pageSecondaryMenu	= 	$mydailyquot->boxed($lang_output["DQ_RBOX_CAT_TITLE"], $mydailyquot->load_dailyquot_cat($dailyquotPage, $lang_output["DQ_CAT_ERR"]), '', "box_right");
			//$dailyquotLast		= 	$mydailyquot->cwdBoxed($lang_output["DQ_RBOX_TITLE"], $mydailyquot->load_recent_dailyquot(5, $dailyquotPage), '')
				
			//if(isset($_REQUEST[$mydailyquot->URI_dailyquot]) && ($_REQUEST[view] == 'detail')){
			if(isset($_REQUEST['dailyquotId']) && ($_REQUEST['view'] == 'detail')){
				$tab_dailyquots 	= 	$mydailyquot->get_dailyquot($_REQUEST[$mydailyquot->URI_dailyquot]);
				
				$cat				= 	$mydailyquot->get_dailyquot_cat_by_id($tab_dailyquots['dailyquotCATID']);
				$dailyquotTitle		= 	strip_tags(stripslashes($tab_dailyquots['dailyquotTITLE']));
				$dailyquotLib 		= 	$tab_dailyquots['dailyquotLIB'];
				$dailyquotDate		=	"<p style=\"font-style:italic\">Publi&eacute; le ".$mydailyquot->date_fr2($tab_dailyquots['dailyquotDATEPUB'])."</p>";
				
				
				$dailyquotPageBck	= 	"<p><a href=\"$dailyquotPage".".html"."\">".$lang_output["DQ_PAGE_BACK"]."</a></p>";
				$pageHeader			= 	$lang_output["DQ_PAGE_HEADER"].' - '.strip_tags(stripslashes($dailyquotTitle));
				$pageTitle			= 	$lang_output["DQ_PAGE_TITLE"];
				//Build the content
				$dailyquotContent	= 	$dailyquotPageBck.$dailyquotDate."<h2>$dailyquotTitle</h2>".$dailyquotLib.$dailyquotPageBck;
				$pageContent		= 	$dailyquotContent;
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $dailyquotTitle, "", "&raquo;", $_SESSION["LANG"]);
				//$dailyquotLast		= 	$mydailyquot->cwdBoxed($lang_output["DQ_RBOX_TITLE"], $mydailyquot->load_recent_dailyquot(5, $dailyquotPage, $_SESSION["LANG"]), '');
			}
			
			elseif(isset($_REQUEST[$mydailyquot->URI_dailyquotCat])){
				$mydailyquot->limit	= 	$_REQUEST['limite'];
				$dailyquotTitle		= 	$lang_output["DQ_PAGE_TITLE"]." : ".$mydailyquot->get_dailyquot_cat_by_id($_REQUEST[$mydailyquot->URI_dailyquotCat]);
				$dailyquotContent	= 	$mydailyquot->load_dailyquot_by_cat($dailyquotPage, $_REQUEST[$mydailyquot->URI_dailyquotCat], 20, $lang_output["READ_MORE"]);
				$pageHeader			= 	$lang_output["DQ_PAGE_HEADER"].' - '.strip_tags(stripslashes($dailyquotTitle));
				$pageTitle			=	$dailyquotTitle;
				$pageContent		= 	stripslashes($dailyquotContent);
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $dailyquotTitle, "", "&raquo;", $_SESSION["LANG"]);
			}
		}
	}
	
	/*dailyquot assignations*/
	//$oSmarty = new Smarty();
	$oSmarty->assign('s_dailyquotLast', utf8_decode(stripslashes($dailyquotLast)));
	$oSmarty->assign('s_dailyquotActual', utf8_decode(stripslashes($dailyquotActual)));