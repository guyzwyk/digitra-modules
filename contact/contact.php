<?php
	//:::::::::::::::::::::::::::::::Contact Module:::::::::::::::::::::::::::::::
	//Contact default page
	$contactPage = "Contact form below!";
	//Form validation
	$txtFirstName 	= ucwords($_POST['txtFirstName']);
	$txtLastName	= strtoupper($_POST['txtLastName']);
	$txtEmail		= $_POST['txtEmail'];
	$txtPhone1		= $_POST['txtPhone1'];
	$txtPhone2		= $_POST['txtPhone2'];
	$txtComName		= $_POST['txtComName'];
	$txtWebSite		= $_POST['txtWebSite'];
	$selCountry		= $_POST['selCountry'];
	$taOther		= utf8_decode(stripslashes(nl2br($_POST['taOther'])));
	
	if($_REQUEST['level'] == 'front'){
	    //$news_homeTitle		= 	"<h1 style=\"border-bottom:#E9601F 1px solid; margin-bottom:5px; margin-right:10px;\">".$lang_output["NEWS_HOME_TITLE"]."</h1>";
	    //$news_headLine		= 	$myNews->dt_pageBox($lang_output["NEWS_HOME_TITLE"], $myNews->_sprySliding_load_news_home($pageNews, $nombre='6', $pageLang, $limit='0'), "", 'fa fa-newspaper-o');
	    //$news_home		=	$myNews->cwdBoxed($lang_output["NEWS_HOME_TITLE_ALSO"], $myNews->load_news_home($pageNews, 0, 4, $pageLang, $lang_output["NEWS_MORE"], "nwr_newsHome"), $link_to_pageMaster, 'fa fa-newspaper-o'); //Rendu sur YA-FE 2011
	    //$news_home          =   $myNews->dt_pageBox($mod_lang_output["NEWS_HOME_TITLE"], $myNews->dgt_load_news_home($pageNews, 0, 6, $pageLang, $mod_lang_output["NEWS_MORE"], "newsHome"), "", 'fa fa-newspaper-o', 'homeBox');
	}
	elseif($_REQUEST['mod'] 	== 'contact'){
	    /*$modSecondaryMenu	= 	$myNews->dt_pageBox($mod_lang_output['NEWS_CAT_SIDE_BOX_TITLE'], $myNews->load_news_cat($pageNews, $mod_lang_output["NEWS_CAT_ERR"], '', $_SESSION['LANG']), '');
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
	            /*$newsTitle			= 	$mod_lang_output["NEWS_PAGE_TITLE"]." : ".$myNews->get_news_cat_by_id($myNews->fld_newsCatLib, $_REQUEST['catId']);
	            
	            $pageHeader			= 	$mod_lang_output["NEWS_PAGE_HEADER"].' - '.strip_tags(stripslashes($newsTitle));
	            $pageTitle			=	$newsTitle;
	            $pageContent		=	$myNews->load_news_by_cat($pageNews, $_REQUEST[$myNews->URI_newsCat], 50, $lang_output["NEWS_MORE"], $_SESSION['LANG']);
	            $pagePathWay		= 	$myPage->build_path_way($_REQUEST[$myPage->URI_pageVar], $newsTitle, "", "&raquo;", $_SESSION["LANG"]);
	        }
	    }*/
	}

	if(isset($_POST['btnSend'])){
		if((empty($txtFirstName)) || (empty($txtLastName)) || (empty($txtEmail)) || (empty($taOther))){
			$err_msg 			= $lang_output['C_REQUIRED'];
			$validateFirstName	= $myPage->show_content($err_msg, $_POST['txtFirstName']);
		    $validateLastName	= $myPage->show_content($err_msg, $_POST['txtLastName']);
		    $validateEmail		= $myPage->show_content($err_msg, $_POST['txtEmail']);
		    $validatePhone1		= $myPage->show_content($err_msg, $_POST['txtPhone1']);
		    $validatePhone2		= $myPage->show_content($err_msg, $_POST['txtPhone2']);
		    $validateWebSite	= $myPage->show_content($err_msg, $_POST['txtWebSite']);
		    $validateCountry	= $myPage->show_content($err_msg, $_POST['selCountry']);
			$validateOther		= $myPage->show_content($err_msg, $_POST['taOther']);
			$frm_msgDisplay		= "<p>&nbsp</p><div class=\"boxErr\">$err_msg</div>";
		}
		else{
			$cfrm_msg			= $lang_output['C_OK'];
			$msg = "";
			//$country = $myCountry->get_country($selCountry);
			$msg .= "<p><strong>Last Name :</strong> $txtLastName<br/>
				 <strong>First Name :</strong> $txtFirstName<br />
				 <strong>Email :</strong> $txtEmail<br />
				 <strong>Telephone(DID) :</strong> $txtPhone1<br />
				 <strong>Mobile phone :</strong> $txtPhone2<br />
				 <strong>Web site :</strong> $txtWebSite<br />
				 <strong>Country :</strong> $country</p>
				 <p><strong>Visitor's suggestions  :</strong><br />$taOther</p>";
			
			$to 			= 	$pageEmail;
			$subject 		= 	"[$pageName] - ".$mod_lang_output['CONTACT_MAIL_SUBJECT']." $txtFirstName $txtLastName";
			//$from 		= 	"FROM : $txtEmail";
			$mailHeaders	= 	"From:"."$txtEmail"."\r\n" ."MIME-Version: 1.0\r\n"."Content-Type: text/html; charset=iso-8859-1\r\nReply-to : ".$txtEmail;
			@mail($to, $subject, $msg, $mailHeaders);
			@mail($thewu32_authorEmail, $subject, $msg, $mailHeaders); //Test
			$txtName		= 	"$txtFirstName $txtLastName";
			$frm_msgDisplay	= 	"<p>&nbsp</p><div class=\"boxCfrm\">$cfrm_msg</div><p>&nbsp</p>";
		}		
	}
	
	//Contact form here...
	//goto contact.tpl
	
	//**Contact smarty assignations
	/*frmLabels*/
	$oSmarty->assign('s_frmMsgFrame', $mod_lang_output['FRM_DETAILS']);
	$oSmarty->assign('s_lbl_contact_firstName', $mod_lang_output['C_FIRST_NAME']);
	$oSmarty->assign('s_lbl_contact_lastName', $mod_lang_output['C_LAST_NAME']);
	$oSmarty->assign('s_lbl_contact_email', $mod_lang_output['C_EMAIL']);
	$oSmarty->assign('s_lbl_contact_phone1', $mod_lang_output['C_PHONE1']);
	$oSmarty->assign('s_lbl_contact_phone2', $mod_lang_output['C_PHONE2']);
	$oSmarty->assign('s_lbl_contact_comName', $mod_lang_output['C_COM_NAME']);
	$oSmarty->assign('s_lbl_contact_webSite', $mod_lang_output['C_WEBSITE']);
	$oSmarty->assign('s_lbl_contact_country', $mod_lang_output['C_COUNTRY']);
	$oSmarty->assign('s_lbl_contact_other', $mod_lang_output['C_COMMENT']);
	$oSmarty->assign('s_lbl_contact_confirm', $mod_lang_output['C_CONFIRM']);
	$oSmarty->assign('s_lbl_contact_send', $mod_lang_output['FRM_BTN_SEND']);
	$oSmarty->assign('s_lbl_contact_choose', $mod_lang_output['FRM_COMBO_CHOOSE']);
	$oSmarty->assign('s_lbl_captcha', $mod_lang_output['FRM_CAPTCHA_LABEL']);

	/*frmVars*/
	$oSmarty->assign('s_frmMsgDisplay', $frm_msgDisplay);
	$oSmarty->assign('s_validateFirstName', $validateFirstName);
	$oSmarty->assign('s_validateLastName', $validateLastName);
	$oSmarty->assign('s_validateEmail', $validateEmail);
	$oSmarty->assign('s_validatePhone1', $validatePhone1);
	$oSmarty->assign('s_validatePhone2', $validatePhone2);
	$oSmarty->assign('s_validateWebSite', $validateWebSite);
	$oSmarty->assign('s_validateCountry', $validateCountry);
	$oSmarty->assign('s_loadCountry', $myCountry->load_cmbCountry());
	$oSmarty->assign('s_validateDescr', $validateDescr);
	$oSmarty->assign('s_validateOther', $validateOther);