<?php
	require_once ('library/interview.inc.php');
	$myInterview		= new cwd_interview();
	$interviewPage		= $myPage->get_pages_modules_links("interview", $_SESSION["LANG"]); //$thewu32_modLink[interview];
	
	$txtName			= 	htmlspecialchars(addslashes($myInterview->counterXss($_POST[txtName], $_SESSION["LANG"])));
	$txtRank			= 	htmlspecialchars(addslashes($myInterview->counterXss($_POST[txtRank], $_SESSION["LANG"])));
	$taSubject			= 	htmlspecialchars(addslashes($myInterview->counterXss($_POST[taSubject], $_SESSION["LANG"])));
	$txtEmail			= 	htmlspecialchars(addslashes($myInterview->counterXss($_POST[txtEmail], $_SESSION["LANG"])));
	$txtPhone			= 	htmlspecialchars(addslashes($myInterview->counterXss($_POST[txtPhone], $_SESSION["LANG"])));
	$txtCni				= 	htmlspecialchars(addslashes($myInterview->counterXss($_POST[txtCni], $_SESSION["LANG"])));
	$cmbDayUpd			= 	$_POST[cmbDayUpd];
	$cmbMonthUpd		= 	$_POST[cmbMonthUpd];
	$cmbYearUpd			= 	$_POST[cmbYearUpd];
	$cmbHourUpd			= 	$_POST[cmbHourUpd];
	$cmbMinUpd			= 	$_POST[cmbMinUpd];
	$datetimeInterview	=	$_POST[cmbYearUpd].'-'.$_POST[cmbMonthUpd].'-'.$_POST[cmbDayUpd].' '.$_POST[cmbHourUpd].':'.$_POST[cmbMinUpd].':00';
	$sms_msg			=	"Interview request from $txtName ($txtPhone)";
	
	$myRss		= 	new cwd_rss091($interviewPage);
	
	/*
	 * $myRss->set_rss_tblInfos($myInterview->tblInterview, $myInterview->fld_intId, $myInterview->fld_intName, $myInterview->fld_intSubject, $news->fld_newsAuthId, $myInterview->fld_intDate, $news->tbl_newsAuth, $news->fld_newsAuthFirstName, $news->fld_newsAuthLastName);
	$myRss->set_rss_link_param("", $pageNews.'-detail-', $pageNews.'-detail-'); //Varie selon chaque module
	$myRss->set_rss_header("North West Region News - Actualité de la Région du Nord-Ouest", $myRss->get_datetime(), "NWR News - Actualité RNO", $thewu32_site_url.'rss/rss.xml', "theWu32 Feeder", $thewu32_site_url.'modules/new/img/rss_news.gif', "NWR News", $thewu32_site_url.'modules/news/img/rss_news.gif', "Actualit&eacute; RNO");
	*/
	//Captcha
	$security_code 		= 	$_POST[security_code];
	
	if(isset($_POST[btn_itwBook])){		
		if(empty($txtName) || empty($taSubject) || empty($txtEmail) || empty($txtRank)){
			$errMsg				=	$mod_lang_output["ITW_ERROR_REQUIRED"];
			$frmBookMsgDisplay	= 	"<div class=\"boxErr\">$errMsg</div>";
		}
		elseif(!checkdate($cmbMonthUpd, $cmbDayUpd, $cmbYearUpd)){
			$errMsg				=	$mod_lang_output["ITW_ERROR_DATE"];
			$frmBookMsgDisplay	= 	"<div class=\"boxErr\">$errMsg</div>";
		}
		elseif($myInterview->chk_entry_trice($myInterview->tblInterview, $myInterview->fld_intName, $myInterview->fld_intSubject, $myInterview->fld_intTel, $txtName, $taSubject, $txtPhone)){
			$errMsg				=	$mod_lang_output["ITW_ERROR_EXIST"];
			$frmBookMsgDisplay	= 	"<div class=\"boxErr\">$errMsg</div>";
		}
		elseif(($_POST[security_code] != $_SESSION[security_code]) || (empty($_SESSION[security_code])) ){
			unset($_SESSION[security_code]);
			$errMsg 			= 	$mod_lang_output["CAPTCHA_ERROR"];
			$frmBookMsgDisplay	= 	"<div class=\"boxErr\">$errMsg</div>";
		}
		elseif($myInterview->insert_interview($txtName, $txtRank, $taSubject, $txtEmail, $txtPhone, $txtCni, $datetimeInterview)){
			$cfrmMsg 			= 	$mod_lang_output["ITW_INSERT_CFRM"];
			$frmBookMsgDisplay	= 	"<div class=\"boxCfrm\">$cfrmMsg</div>";
			//Create XML
			//$myInterview->create_xml($xml_file, $xml_header, $xml_content, $xml_footer)
			unset($_SESSION[security_code]);
			$myMail				=	new cwd_mailer($mod_lang_output["ITW_MAIL_FROM"], $txtEmail, $mod_lang_output["ITW_MAIL_SUBJECT"], $mod_lang_output["ITW_MAIL_CONTENT"]);
			@$myMail->send_mail();
			
			//Send SMS
			//header("http://iyam.mobi/apiv1/?action=sendsms&userid=9a6ef622-e011-4af9-b47d-6fcdb9128d29&password=hanibal128&sender=NorthWestRegion&to=$txtPhone&msg=$sms_msg");
		}
		$validateName			= 	$myPage->show_content($errMsg, $_POST[txtName]);
		$validateRank			= 	$myPage->show_content($errMsg, $_POST[txtRank]);
		$validateEmail			= 	$myPage->show_content($errMsg, $_POST[txtEmail]);
		$validatePhone			= 	$myPage->show_content($errMsg, $_POST[txtPhone]);
		$validateSubject		= 	$myPage->show_content($errMsg, $_POST[taSubject]);
		$validateCni			= 	$myPage->show_content($errMsg, $_POST[txtCni]);
	}
	

//Smarty Assignations
	//Label displaying
	$oSmarty->assign('s_lbl_itw_name', $mod_lang_output["ITW_NAME"]);
	$oSmarty->assign('s_lbl_itw_rank', $mod_lang_output["ITW_RANK"]);
	$oSmarty->assign('s_lbl_itw_subject', $mod_lang_output["ITW_SUBJECT"]);
	$oSmarty->assign('s_lbl_itw_email', $mod_lang_output["ITW_EMAIL"]);
	$oSmarty->assign('s_lbl_itw_phone', $mod_lang_output["ITW_PHONE"]);
	$oSmarty->assign('s_lbl_itw_cni', $mod_lang_output["ITW_CNI"]);
	$oSmarty->assign('s_lbl_itw_date', $mod_lang_output["ITW_DATE"]);
	$oSmarty->assign('s_load_datetimeFR', $myInterview->combo_datetimeFrUpd($myInterview->get_datetime(), date("Y")));
	$oSmarty->assign('s_load_datetimeEN', $myInterview->combo_datetimeEnUpd($myInterview->get_datetime(), date("Y")));
	$oSmarty->assign('s_lbl_itw_book_confirm', $mod_lang_output["ITW_BTN_BOOK_CFRM"]);
	$oSmarty->assign('s_lbl_itw_captcha', $mod_lang_output["ITW_CAPTCHA_LABEL"]);
	$oSmarty->assign('s_lbl_itw_btn_ok', $mod_lang_output["ITW_BTN_OK"]);
	
	//Validations
	$oSmarty->assign('s_frmBookMsgDisplay', $frmBookMsgDisplay);
	$oSmarty->assign('s_validateName', $validateName);
	$oSmarty->assign('s_validateRank', $validateRank);
	$oSmarty->assign('s_validateEmail', $validateEmail);
	$oSmarty->assign('s_validatePhone', $validatePhone);
	$oSmarty->assign('s_validateSubject', $validateSubject);
	$oSmarty->assign('s_validateCni', $validateCni);
	
	//Mail sending
	