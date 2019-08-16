<?php
	require('library/news.inc.php');
	$myNews			       =   new cwd_news();
	$myNews->limit         =   $_REQUEST['limite']; // For pagination
	
	$pageNews		           =   $myPage->get_pages_modules_links("news", $_SESSION["LANG"]); //$thewu32_modLink[annonce];
	$pageMaster                =   $myPage->set_mod_page_master($pageNews); //Vers la page du module annonce dans la langue choisie mais sans la balise <a></a>
	$link_to_pageMaster        =   $myPage->get_mod_link($myPage->set_mod_pages($pageNews), $mod_lang_output['NEWS_BOX_LINK_ALL']); // Lien vers la page master
	
	$pageNewsBck		       =   "<p><a href=\"".$pageMaster."\">".$mod_lang_output["NEWS_PAGE_BACK"]."</a></p>";
	$link_back_to_pageMaster   =   "<a href=\"".$pageMaster."\">".$mod_lang_output["NEWS_PAGE_BACK"]."</a>";
	
	//:::::::::::::::::::::::::::::::News Module:::::::::::::::::::::::::::::::
	$newsLast		    = 	$myNews->dt_pageBox($mod_lang_output["NEWS_BOX_TITLE"], $myNews->load_last_news(5, $pageNews, $_SESSION["LANG"]), $link_to_pageMaster, 'fa fa-newspaper-o');
	//Link to the news module
	$newsBoxLink		= 	"<a class=\"lnk_gray\" href=\"".$myNews->mod_pageMaster."\">".$mod_lang_output["NEWS_BOX_LINK"]."</a>"; //Add a tool tip later	
	//News Carousel
	$newsCarousel		=	$myNews->_jollySliding_load_news_home($pageNews, 4, $pageLang);	
	//News Footer
	$footerPosts		=	$myNews->load_footer_posts($pageNews);	
	//Spry sliding news
	$newsSlider			=	$myNews->_sprySliding_load_news_home($pageNews);	
	//Flex slider news
	$newsFlexSlider		=	$myNews->_flexSliding_load_news_home($pageNews, 5, $pageLang);

	
	//Initialisation du formulaire de reaction
	//Obtenir les informations de l'utilisateur connect�...
	$txt_commentEmail 	= 	$_POST["txt_commentEmail"];
	$txt_commentName  	= 	addslashes($_POST["txt_commentName"]);
	
	//$txtContent 		= 	$my_article->protect_box(addslashes($_POST["txtContent"]));
	$btn_commentInsert	= 	$_POST['btn_commentInsert'];
	$ta_commentContent 	= 	addslashes($_POST['ta_commentContent']);
	$btn_commentInsert 	= 	$_POST['btn_commentInsert'];
	$hd_newsId 			= 	$_POST['hd_newsId'];
	$security_code 		= 	$_POST['security_code'];
	
	//When connected : 
	if(isset($_SESSION['CONNECTED'])){
		//Connected as candidat
		$txt_commentName	= strtoupper($_SESSION['c_lastName']).' '.ucwords($_SESSION['c_firstName']);
		$txt_commentEmail	= $_SESSION['cEmail'];
	}
		
	if($_REQUEST['level'] == 'front'){
		$news_homeTitle		= 	"<h1 style=\"border-bottom:#E9601F 1px solid; margin-bottom:5px; margin-right:10px;\">".$lang_output["NEWS_HOME_TITLE"]."</h1>";
		$news_headLine		= 	$myNews->dt_pageBox($lang_output["NEWS_HOME_TITLE"], $myNews->_sprySliding_load_news_home($pageNews, $nombre='6', $pageLang, $limit='0'), "", 'fa fa-newspaper-o');
		//$news_home		=	$myNews->cwdBoxed($lang_output["NEWS_HOME_TITLE_ALSO"], $myNews->load_news_home($pageNews, 0, 4, $pageLang, $lang_output["NEWS_MORE"], "nwr_newsHome"), $link_to_pageMaster, 'fa fa-newspaper-o'); //Rendu sur YA-FE 2011
		$news_home          =   $myNews->dt_pageBox($mod_lang_output["NEWS_HOME_TITLE"], $myNews->dgt_load_news_home($pageNews, 0, 6, $pageLang, $mod_lang_output["NEWS_MORE"], "newsHome"), "", 'fa fa-newspaper-o', 'homeBox');
	}
	elseif($_REQUEST['mod'] 	== 'news'){
	    $modSecondaryMenu	= 	$myNews->dt_pageBox($mod_lang_output['NEWS_CAT_SIDE_BOX_TITLE'], $myNews->load_news_cat($pageNews, $mod_lang_output["NEWS_CAT_ERR"], '', $_SESSION['LANG']), '');
	    $pageSecondaryMenu	= 	$myNews->dt_pageBox($mod_lang_output['NEWS_CAT_SIDE_BOX_TITLE'], $myNews->load_news_cat($pageNews, $mod_lang_output["NEWS_CAT_ERR"], '', $_SESSION['LANG']), '');
	    $newsLast		    = 	$myNews->dt_pageBox($mod_lang_output["NEWS_BOX_TITLE"], $myNews->load_last_news(5, $pageNews, $_SESSION["LANG"]), '', 'fa fa-newspaper-o');
	    if($_REQUEST['level'] == "inner"){
	        $pageHeader			= 	$mod_lang_output["NEWS_PAGE_HEADER"]; //strip_tags(stripslashes($annonceTitle));
		    $pageTitle			= 	$mod_lang_output["NEWS_PAGE_TITLE"];
			$pageContent		.=	stripslashes($myNews->load_news($pageNews, 50, $lang_output["NEWS_MORE"], $_SESSION['LANG']));
			if(isset($_REQUEST[$myNews->URI_news]) && ($_REQUEST['view'] == 'detail')){
				$tabNews 		= 	$myNews->get_news($_REQUEST[$myNews->URI_news]);
				$id				=	$tabNews['ID'];
				$cat			=	$myNews->get_news_cat_by_id($myNews->fld_newsCatLib, $tabNews['CATID']);
				$date			=	$tabNews['DATE'];
				$title			=	$tabNews['TITLE'];
				$descr			=	$tabNews['DESCR'];
				$content		=	$myNews->img_pathRestaure($tabNews['CONTENT']);
				$img			=	$tabNews['HEADIMG'];
				$thumb			=	$tabNews['THUMB'];
				$authorId		=	$tabNews['AUTHOR'];
				$langId			=	$tabNews['LANG'];
				$tags			=	$tabNews['TAGS'];
				$display		=	$tabNews['DISPLAY'];
				
				$author_lastName	=	strtoupper($myNews->get_news_author_by_id($myNews->fld_newsAuthLastName, $authorId));
				$author_firstName	=	ucfirst($myNews->get_news_author_by_id($myNews->fld_newsAuthFirstName, $authorId));
				$news_detail_author =   ucfirst($author_firstName).' '.strtoupper($author_lastName);
				$news_detail_author_group   =   $myNews->get_news_author_cat_by_author_id($authorId);
				
				
				
				$newsPageBck			= 	"<p><a href=\"$newsPage".".html"."\">".$mod_lang_output["NEWS_PAGE_BACK"]."</a></p>";
				$news_detail_link_back	=	"<a href=\"$pageNews"."-all.html"."\">".$mod_lang_output["NEWS_LINK_BACK"]."</a>";
				$news_detail_nav_bar	= 	$myNews->load_news_nav($_REQUEST[$myNews->URI_news], $pageNews, "news_nav", $mod_lang_output["NAV_NEXT"], $mod_lang_output["NAV_PREV"], $mod_lang_output["NAV_FIRST"], $mod_lang_output["NAV_LAST"]);
				
				$newsDate 				= 	$myNews->extract_date_from_datetime($date);
				$news_detail_date		= 	$myNews->build_dayCalByLang($newsDate, $_SESSION['LANG']);
				$news_detail_head_img   =   "<img src=\"".$myNews->mod_imgDir['heads'].$img."\" />";
				$news_detail_content	=	$content;
				
				$pageHeader			= 	$mod_lang_output["NEWS_PAGE_HEADER"].' - '.stripslashes($newsTitle);
				$pageTitle			= 	$mod_lang_output["NEWS_PAGE_TITLE"];
				
				$news_catUrl		=	$myNews->set_mod_detail_uri_cat($pageNews, $tabNews['CATID']); //$newsPage.'-cat@'.$tabNews['CATID'].'.html';
	
				
				$pageContent		=	"<div class=\"newsDetail\">
                                            <div class=\"ndHead\">
    												$news_detail_date <span class=\"news_detail_title\" style=\"line-height:23px;\">$title</span>
    												<div class=\"news_detail_descr\">$descr</div>
    										    <div class=\"clrBoth\"></div>
									        </div>
                                            <div class=\"ndBody\">
        									    $news_detail_nav_bar
        									    <div class=\"news_detail_content\">$news_detail_content<div class=\"clrBoth\"></div></div>
        									    <p class=\"news_author\">".$lang_output["BY"].' '.$news_detail_author.", <em>".$news_detail_author_group."</em></p>
        									    <p>$news_detail_link_back</p>
        									    $news_detail_nav_bar
				                            </div>
                                        </div>";
				
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $myNews->chapo($arr_newsDetail['NEWS_DETAIL_TITLE'], 50), "", "&raquo;", $_SESSION["LANG"]);
			}
			elseif($_REQUEST['view'] == 'cat'){
				$newsTitle			= 	$mod_lang_output["NEWS_PAGE_TITLE"]." : ".$myNews->get_news_cat_by_id($myNews->fld_newsCatLib, $_REQUEST['catId']);
				
				$pageHeader			= 	$mod_lang_output["NEWS_PAGE_HEADER"].' - '.strip_tags(stripslashes($newsTitle));
				$pageTitle			=	$newsTitle;
				$pageContent		=	$myNews->load_news_by_cat($pageNews, $_REQUEST[$myNews->URI_newsCat], 50, $lang_output["NEWS_MORE"], $_SESSION['LANG']);
				$pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $newsTitle, "", "&raquo;", $_SESSION["LANG"]);
			}
		}
	}
	
	
	
	//RSS Feed
	//Display the RSS Button
	$homeRSS	=	$myNews->boxed($mod_lang_output["NRSS_BOX_TITLE"], "<strong>".$mod_lang_output["NRSS_BOX_DESCR"]."</strong>", "<a href=\"xml/rss.xml\">&raquo;".$mod_lang_output["CLICK_HERE"]."</a>", "box_right");
		
	
	//Boxes
	$oSmarty->assign('s_newsSideBoxTitle', $mod_lang_output['NEWS_SIDE_BOX_TITLE']);
	$oSmarty->assign('s_newsCatSideBoxTitle', $mod_lang_output['NEWS_CAT_SIDE_BOX_TITLE']);
	
	//News module assignations
	$oSmarty->assign('s_header_imgDir', $myNews->mod_imgDir['heads']);
	$oSmarty->assign('s_thumb_imgDir', $myNews->mod_imgDir['thumbs']);
	$oSmarty->assign('s_main_imgDir', $myNews->mod_imgDir['main']);
	$oSmarty->assign('s_mod_imgDir', $myNews->mod_imgDir);
	
	
	$oSmarty->assign('s_news_home', stripslashes($news_home));
	$oSmarty->assign('s_news_homeTitle', stripslashes($news_homeTitle));
	$oSmarty->assign('s_news_headLine', stripslashes($news_headLine));
	$oSmarty->assign('s_newsLast', stripslashes($newsLast));
	$oSmarty->assign('s_txtHeadLine', stripslashes($txtHeadLine));
	$oSmarty->assign('s_headLine', stripslashes($headLine));
	$oSmarty->assign('s_homeNews', stripslashes($homeNews));
	$oSmarty->assign('s_homeRSS', stripslashes($homeRSS));
	
	//$oSmarty->assign('s_newsLast', stripslashes($newsLast));
	$oSmarty->assign('s_newsRelated', stripslashes($newsRelated));
	$oSmarty->assign('s_newsCat', stripslashes($newsCat));
	$oSmarty->assign('s_newsSlider', stripslashes($newsSlider));
	$oSmarty->assign('s_newsCarousel', stripslashes($newsCarousel));
	$oSmarty->assign('s_newsFlexSlider', stripslashes($newsFlexSlider));
	$oSmarty->assign('s_newsFooterPosts', stripslashes($footerPosts));
	
	//$oSmarty->assign('s_news_detail_date', $news_detail_date);
	$oSmarty->assign('s_news_detail_title', stripslashes($news_detail_title));
	$oSmarty->assign('s_news_detail_descr', $news_detail_descr);
	$oSmarty->assign('s_news_detail_content', $news_detail_content);
	$oSmarty->assign('s_news_detail_author', $news_detail_author);
	$oSmarty->assign('s_news_detail_link_back', $news_detail_link_back);
	$oSmarty->assign('s_news_detail_nav_bar', $news_detail_nav_bar);
	$oSmarty->assign('s_news_detail_related', $news_detail_related);
	$oSmarty->assign('s_newsPageBck', $newsPageBck);
	
	//News comment assignations
		//Comment form...
	$oSmarty->assign('s_frm_txtCommentName', $frm_txtCommentName);
	$oSmarty->assign('s_frm_txtCommentEmail', $frm_txtCommentEmail);
	$oSmarty->assign('s_frm_taCommentContent', $frm_taCommentContent);
	$oSmarty->assign('s_frm_hdCommentId', $frm_hdCommentId);
	$oSmarty->assign('s_cfrm_commentInsert', $cfrm_commentInsert);
	$oSmarty->assign('s_err_commentInsert', $err_commentInsert);
		//Comment details
	$oSmarty->assign('s_newsComment', $newsComment);
	$oSmarty->assign('s_newsCommentFrm', $commentFrmTitle.$commentFrmMain);
	$oSmarty->assign('s_newsComment', $newsComment);
	
	//RSS
	$oSmarty->assign('s_news_rss_title', $mod_lang_output["NEWS_RSS_TITLE"]);
	$oSmarty->assign('s_news_rss_href', $mod_lang_output["NEWS_RSS_HREF"])
?>