<?php
	//Modifier un daily quote
	$btn_dailyquot_upd			= 	$_POST['btn_dailyquot_upd'];
	$dailyquot_selLangUpd		= 	$_POST['dailyquot_selLangUpd'];
	$hd_dailyquot_id			= 	$_POST['hd_dailyquot_id'];
	$hd_date_pub				=	$_POST['hd_date_pub'];
	$dailyquot_selCatUpd		= 	$_POST['dailyquot_selCatUpd'];
	$txt_dailyquot_title_upd 	= 	$_POST['txt_dailyquot_title_upd'];
	$ta_dailyquot_content_upd	= 	stripslashes($_POST['ta_dailyquot_content_upd']);
	$datePubUpd					= 	$_POST['cmbYearUpd']."-".$_POST['cmbMonthUpd']."-".$_POST['cmbDayUpd'];
	
	if(isset($btn_dailyquot_upd)){
		if(empty($txt_dailyquot_title_upd) || empty($ta_dailyquot_content_upd))
			$dailyquot_update_err_msg 	= 	$mod_lang_output['CALLOUT_UPDATE_ERROR_MANDATORY'];
		elseif(($datePubUpd != $hd_date_pub) AND ($dailyquot->chk_entry($dailyquot->tbl_dailyquot, "dq_date_display", $datePubUpd)))
			$dailyquot_update_err_msg 	= 	$mod_lang_output['CALLOUT_UPDATE_ERROR_EXIST'];
		elseif($dailyquot->update_dailyquot(
									$hd_dailyquot_id,
								  	$dailyquot_selCatUpd, 
								  	addslashes($txt_dailyquot_title_upd),
								  	addslashes($ta_dailyquot_content_upd),
								  	$datePubUpd,
								  	$dailyquot_selLangUpd,
								  	$_SESSION['uId']
								  	)){
			$dailyquot_update_cfrm_msg 	= 	$mod_lang_output['CALLOUT_UPDATE_SUCCESS'];
			//Log insert
			$dailyquot->set_log('QUOTE UPDATED :: '.stripslashes($txt_dailyquot_title_upd));
			
			//Creer le Data Set Correspondant
			//$dailyquot->create_xml_dailyquot("../modules/dailyquot/xml/dailyquot.xml");
			$myRss->makeRSS("../modules/dailyquot/rss/dailyquots.xml");
		}
	}
?>

<?php
	//Ajouter une cat&eacute;gorie
	$btn_cat_insert					= 	$_POST['btn_cat_insert'];
	$dailyquot_selLang				= 	$_POST['dailyquot_selLang'];
	$txt_cat_id 					= 	addslashes($_POST['txt_cat_id']);
	$txt_cat_lib 					= 	addslashes($_POST['txt_cat_lib']);
	
	if(isset($btn_cat_insert)){
		if(empty($txt_cat_lib))
			$rub_insert_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_ERROR_EMPTY'];
		elseif($dailyquot->chk_entry_twice($dailyquot->tbl_dailyquotCat, "dq_cat_id", "lang_id", $txt_cat_id, $dailyquot_selLang))
			$rub_insert_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_ERROR_EXIST'];
		elseif($dailyquot->chk_entry_twice($dailyquot->tbl_dailyquotCat, "dq_cat_lib", "lang_id", $txt_cat_lib, $dailyquot_selLang))
			$rub_insert_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_ERROR_EXIST'];
		elseif($dailyquot->dailyquot_cat_insert(strtoupper($txt_cat_id), $txt_cat_lib, $dailyquot_selLang)){
			$rub_insert_cfrm_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_SUCCESS'];
			
			//Log insert
			$dailyquot->set_log('NEW QUOTE CATEGORY INSERTED :: '.stripslashes($txt_cat_lib));
		}
			
	}
?>

<?php
	//Modifier une cat&eacute;gorie de dailyquot
	$hd_cat_id						= 	$_POST['hd_cat_id'];
	$btn_cat_upd					= 	$_POST['btn_cat_upd'];
	$dailyquot_selLangUpd			= 	$_POST['dailyquot_selLangUpd'];
	$txt_cat_lib_upd 				= 	addslashes($_POST['txt_cat_lib_upd']);
	
	if(isset($btn_cat_upd)){
		if(empty($txt_cat_lib_upd))
			$rub_update_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_UPDATE_EMPTY'];
		elseif($dailyquot->update_dailyquot_cat($hd_cat_id, $txt_cat_lib_upd, $dailyquot_selLangUpd))
			$rub_update_cfrm_msg 	= 	"Category successfully modified";
	}
?>

<?php
	//Ajouter une citation ou un verset
	$btn_dailyquot_insert			= 	$_POST['btn_dailyquot_insert'];
	$dailyquot_selCat				= 	$_POST['dailyquot_selCat'];
	$dailyquot_selLang				= 	$_POST['dailyquot_hdLang'];
	$txt_dailyquot_title 			= 	addslashes($_POST['txt_dailyquot_title']);
	$ta_dailyquot_content			= 	addslashes($_POST['ta_dailyquot_content']);
	$datePub						= 	$_POST['cmbYear']."-".$_POST['cmbMonth']."-".$_POST['cmbDay'];
	$dateInsert						= 	$dailyquot->get_datetime();
	
	
	
	//Validations *****************************************************************************
	if(isset($btn_dailyquot_insert)){
		$dailyquot_img						=	'no_dailyquot_img';
		if($dailyquot_selLang 				== 	'NULL' OR $dailyquot_selLang == '')
		    $dailyquot_insert_err_msg    	= 	$mod_lang_output['FORM_ERROR_LANG'];
		elseif(empty($dailyquot_selCat) 	|| 	($dailyquot_selCat == 'NULL'))
		    $dailyquot_insert_err_msg 		= 	$mod_lang_output['FORM_ERROR_NO_CAT'];
		elseif(empty($txt_dailyquot_title) 	|| 	empty($ta_dailyquot_content))
			$dailyquot_insert_err_msg 		= 	$mod_lang_output['CALLOUT_INSERT_ERROR_MANDATORY'];
		elseif($dailyquot->chk_entry($dailyquot->tbl_dailyquot, "dq_reference", $txt_dailyquot_title))
			$dailyquot_insert_err_msg 		= 	$mod_lang_output['CALLOUT_INSERT_ERROR_EXIST_SAME_TITLE'];
		elseif($dailyquot->chk_entry($dailyquot->tbl_dailyquot, "dq_text", $ta_dailyquot_content))
			$dailyquot_insert_err_msg 		= 	$mod_lang_output['CALLOUT_INSERT_ERROR_EXIST'];
		elseif($dailyquot->chk_entry($dailyquot->tbl_dailyquot, "dq_date_display", $datePub))
		$dailyquot_insert_err_msg 			= 	$mod_lang_output['CALLOUT_INSERT_ERROR_EXIST_SAME_DAY'];
		elseif($insertId = $dailyquot->dailyquot_insert($dailyquot_selCat, $txt_dailyquot_title,  $ta_dailyquot_content, $datePub, $dateInsert, $dailyquot_selLang, $_SESSION['uId'])){
			$dailyquot_insert_cfrm_msg 		= 	$mod_lang_output['CALLOUT_INSERT_SUCCESS'];
			
			//Log insert
			$dailyquot->set_log('NEW QUOTE INSERTED :: '.stripslashes($txt_dailyquot_title));
		}
	}
?>

<?php
	//Actions sur les dailyquots et leurs rubriques
	$what 			= 	$_REQUEST['what'];
	$action			= 	$_REQUEST['action'];
	$dailyquotId	= 	$_REQUEST['dailyquotId'];
	$catId			= 	$_REQUEST['catId'];
	
	switch($action){
		case 	"delete" 	: 	$toDo 						= 	$dailyquot->del_dailyquot($dailyquotId);
								$dailyquot_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_DELETE_SUCCESS'];
								//Cr&eacute;er le Data Set Correspondant
								//$dailyquot->create_xml_dailyquot("../modules/dailyquot/xml/dailyquot.xml");
								//Log insert
								$dailyquot->set_log('QUOTE DELETED :: ID was '.$dailyquotId);
								$myRss->makeRSS("../modules/dailyquot/rss/dailyquots.xml");
		break;
		case 	"hide"		: 	$toDo						= 	$dailyquot->set_dailyquot_state($dailyquotId, "0");
								$dailyquot_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_HIDE'];
								//Cr&eacute;er le Data Set Correspondant
								//$dailyquot->create_xml_dailyquot("../modules/dailyquot/xml/dailyquot.xml");
								$dailyquot->set_log('QUOTE TURNED PRIVATE :: ID is '.$dailyquotId);
								$myRss->makeRSS("../modules/dailyquot/rss/dailyquots.xml");
		break;
		case 	"show"		:	$toDo						= 	$dailyquot->set_dailyquot_state($dailyquotId, "1");
								$dailyquot_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_SHOW'];
								//Cr&eacute;er le Data Set Correspondant
								//$dailyquot->create_xml_dailyquot("../modules/dailyquot/xml/dailyquot.xml");
								$dailyquot->set_log('QUOTE TURNED PUBLIC :: ID is '.$dailyquotId);
								$myRss->makeRSS("../modules/dailyquot/rss/dailyquots.xml");
		break;
		case 	"update" 	: 	$tabUpd						= 	$dailyquot->get_dailyquot($dailyquotId); //Ce tableau sera utilis pour remplir les champs du formulaire de modification
								$dailyquot_displayUpd 		= 	true;
		break;
		case 	"catDelete" : 	$toDo						= 	$dailyquot->del_dailyquot_cat($catId);
								$rub_display_cfrm_msg		= 	$mod_lang_output['CALLOUT_CAT_DELETE_SUCCESS'];
								$dailyquot->set_log('QUOTE CATEGORY DELETED :: ID was '.$catId);
							  
		break;
		case 	"catUpdate" : 	$tabCatUpd 					= 	$dailyquot->get_dailyquot_cat($catId);
							   $rub_displayUpd				= 	true;
		break;
		case 	"catShow" 	: 	$toDo 						= 	$dailyquot->set_dailyquotcat_state($catId, 1);
								$rub_display_cfrm_msg		= 	$mod_lang_output['CALLOUT_CAT_SHOW'];
								$dailyquot->set_log('QUOTE TURNED PUBLIC :: ID is '.$catId);
		break;
		case 	"catHide" 	: 	$toDo						= 	$dailyquot->set_dailyquotcat_state($catId, 0);
								$rub_display_cfrm_msg		= 	$mod_lang_output['CALLOUT_CAT_HIDE'];
								$dailyquot->set_log('QUOTE TURNED PUBLIC :: ID is '.$catId);
		break;
	}
?>