<?php
	//Ajouter une cat&eacute;gorie
	$btn_cat_insert	= 	$_POST[btn_cat_insert];
	$txt_cat_id		= 	$_POST[txt_cat_id];
	$selLang		= 	$_POST[selLang];
	$txt_cat_lib 	= 	addslashes($_POST[txt_cat_lib]);
	
	if(isset($btn_cat_insert)){
		if(empty($txt_cat_lib))
			$rub_insert_err_msg 	= $mod_lang_output["EVENT_CAT_EMPTY_ERROR"];
		elseif($event->chk_entry_twice($event->tblEventType, "event_type_id", "lang_id", $txt_cat_id, $selLang))
			$rub_insert_err_msg 	= $mod_lang_output['EVENT_CODE_EXIST'];
		elseif($event->chk_entry_twice($event->tblEventType, "event_type_lib", "lang_id", $txt_cat_lib, $selLang))
			$rub_insert_err_msg 	= $mod_lang_output['EVENT_CAT_EXIST'];
		elseif($event->set_event_type(strtoupper($txt_cat_id), $txt_cat_lib, $selLang)){
			$rub_insert_cfrm_msg 	= $mod_lang_output['EVENT_CAT_SUCCESS'];
			$system->set_log('EVENT CATEGORY CREATED - ('.$txt_cat_lib.')');
			//Creer le Data Set Correspondant
			//$event->create_xml_event($modDir.'xml/mideno_event_cat.xml');
		}
	}
?>

<?php
	//Modifier une cat&eacute;gorie d'event
	$hd_cat_id				= 	$_POST[hd_cat_id];
	$btn_cat_upd			= 	$_POST[btn_cat_upd];
	$selLangUpd				= 	$_POST[selLangUpd];
	$txt_cat_lib_upd 		= 	addslashes($_POST[txt_cat_lib_upd]);
	
	if(isset($btn_cat_upd)){
		if(empty($txt_cat_lib_upd))
			$rub_update_err_msg 	= $mod_lang_output['EVENT_CAT_LABEL_EMPTY_REQUIRED'];
		elseif($event->update_event_cat($hd_cat_id, $txt_cat_lib_upd, $selLangUpd)){
			$rub_update_cfrm_msg 	= $mod_lang_output['EVENT_CAT_UPDATE_SUCCESS'];
			$system->set_log('EVENT CATEGORY UPDATED - ('.$txt_cat_lib.')');
			//Creer le Data Set Correspondant
			//$event->create_xml_event($modDir.'xml/mideno_event_cat.xml');
		}
	}
?>

<?php
	//Ajouter un événement
	$btn_event_insert		= 	$_POST[btn_event_insert];
	$event_selCat			= 	$_POST[event_selCat];
	$sel_eventLang			= 	$_POST['hdLang'];
	$txt_event_title 		= 	addslashes($_POST[txt_event_title]);
	$txt_event_location		= 	addslashes($_POST[txt_event_location]);
	$ta_event_content		= 	addslashes($_POST[ta_event_content]);
	$dateStart				= 	$_POST[cmbYear1]."-".$_POST[cmbMonth1]."-".$_POST[cmbDay1];
	$timeStart				= 	$_POST[cmbHour1].":".$_POST[cmbMinute1].":".$_POST[cmbSecond1];
	$datetimeStart			= 	"$dateStart $timeStart";
	$dateEnd				= 	$_POST[cmbYear2]."-".$_POST[cmbMonth2]."-".$_POST[cmbDay2];
	$timeEnd				= 	$_POST[cmbHour2].":".$_POST[cmbMinute2].":".$_POST[cmbSecond2];
	$datetimeEnd			= 	"$dateEnd $timeEnd";
	$dateInsert				= 	$event->get_datetime();
	$txt_event_url			= 	$_POST[txt_event_url];
	//$sel_eventLang			= $_POST[hdLang];
	
	
	//Validations *****************************************************************************
	if(isset($btn_event_insert)){
	    if($sel_eventLang == 'NULL' OR $sel_eventLang == '')
	        $event_insert_err_msg = $mod_lang_output['FORM_ERROR_LANG'];
		elseif(empty($txt_event_title) || empty($ta_event_content))
			$event_insert_err_msg 	= $mod_lang_output['EVENT_MANDATORY_FIELDS_ERROR'];
		elseif($event->chk_entry($event->tbl_event, "event_name", $txt_event_title))
			$event_insert_err_msg 	= $mod_lang_output['EVENT_TITLE_EXISTS_ERROR'];
		elseif($event->chk_entry($event->tbl_event, "event_descr", $ta_event_content))
			$event_insert_err_msg 	= $mod_lang_output['EVENT_EXISTS_ERROR'];
		elseif(!checkdate($_POST[cmbMonth1], $_POST[cmbDay1], $_POST[cmbYear1]))
			$event_insert_err_msg 	= $mod_lang_output['EVENT_DATE_START_ERROR'];
		elseif(!checkdate($_POST[cmbMonth2], $_POST[cmbDay2], $_POST[cmbYear2]))
			$event_insert_err_msg 	= $mod_lang_output['EVENT_DATE_END_ERROR'];
		elseif($dateEnd < $dateStart)
			$event_insert_err_msg 	= $mod_lang_output['EVENT_DATES_ERROR'];	
		elseif($event->set_event($event_selCat, (int)$userId, $txt_event_title, $ta_event_content, $txt_event_location, $datetimeStart, $datetimeEnd, $txt_event_url, $sel_eventLang)){
			$event_insert_cfrm_msg 	= $mod_lang_output['EVENT_CREATE_SUCCESS'];
			$system->set_log('EVENT CREATED - ('.$txt_event_title.')');
			//Creer le Data Set Correspondant
			//$event->create_xml_event($modDir.'xml/mideno_event.xml');
		}
	}
?>

<?php
	//Modifier un evenement
	$btn_event_upd			= $_POST[btn_event_upd];
	$hd_event_id			= $_POST[hd_event_id];
	$event_selCatUpd		= $_POST[event_selCatUpd];
	$txt_event_title_upd	= addslashes($_POST[txt_event_title_upd]);
	$txt_event_location_upd	= addslashes($_POST[txt_event_location_upd]);
	$ta_event_content_upd	= addslashes($_POST[ta_event_content_upd]);
	
	$dateStartUpd			= $_POST[cmbYear1]."-".$_POST[cmbMonth1]."-".$_POST[cmbDay1];
	$timeStartUpd			= $_POST[cmbHour1].":".$_POST[cmbMinute1].":".$_POST[cmbSecond1];
	$datetimeStartUpd		= "$dateStartUpd $timeStartUpd";
	
	$dateEndUpd				= $_POST[cmbYear2]."-".$_POST[cmbMonth2]."-".$_POST[cmbDay2];
	$timeEndUpd				= $_POST[cmbHour2].":".$_POST[cmbMin2].":".$_POST[cmbSecond2];
	
	$datetimeEndUpd			= "$dateEndUpd $timeEndUpd";
	$dateInsertUpd			= $event->get_datetime();
	
	$txt_event_url_upd		= $_POST[txt_event_url_upd];
	$sel_eventLangUpdate	= $_POST[sel_eventLangUpdate];
	
	if(isset($btn_event_upd)){
		if(empty($txt_event_title_upd) || empty($ta_event_content_upd))
			$event_update_err_msg 	= $mod_lang_output['EVENT_MANDATORY_FIELDS_ERROR'];
		elseif(!checkdate($_POST[cmbMonth1], $_POST[cmbDay1], $_POST[cmbYear1]))
			$event_update_err_msg 	= $mod_lang_output['EVENT_DATE_START_ERROR'];
		elseif(!checkdate($_POST[cmbMonth2], $_POST[cmbDay2], $_POST[cmbYear2]))
			$event_update_err_msg 	= $mod_lang_output['EVENT_DATE_END_ERROR'];
		elseif($dateEndUpd < $dateStartUpd)
			$event_update_err_msg 	= $mod_lang_output['EVENT_DATES_ERROR'];
		elseif($event->update_event($hd_event_id,
								  $event_selCatUpd,
								  $_SESSION[uId],
								  $txt_event_title_upd,
								  $ta_event_content_upd,
								  $txt_event_location_upd,
								  $datetimeStartUpd,
								  $datetimeEndUpd,
								  $txt_event_url_upd,
								  $sel_eventLangUpdate)){
			$event_update_cfrm_msg 	= $mod_lang_output['EVENT_UPDATE_SUCCESS'];
			$system->set_log('EVENT UPDATED - ('.$txt_event_title_upd.')');
			//Creer le Data Set Correspondant
			//$event->create_xml_event($modDir.'xml/mideno_event.xml');
		}
	}
?>

<?php
	//Actions sur les events et leurs rubriques
	$what 		= $_REQUEST[what];
	$action		= $_REQUEST[action];
	$eId		= $_REQUEST[pmId];
	$ecId		= $_REQUEST[catId];
	
	switch($action){
		case "delete" : $system->set_log('EVENT DELETED - ('.$event->get_event_by_id($event->fld_eventLib, $eId).')');
							$toDo 						= 	$event->delete_event($eId);
							$event_display_cfrm_msg		= 	$mod_lang_output['EVENT_DELETE_SUCCESS'];
							
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_event($modDir.'xml/mideno_event.xml');
		break;
		case "hide": $toDo						= 	$event->switch_event_status($eId, "0");
							$event_display_cfrm_msg	= $mod_lang_output['EVENT_SET_HIDDEN_SUCCESS'];
							$system->set_log('EVENT SET INVISIBLE - ('.$event->get_event_by_id($event->fld_eventLib, $eId).')');
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_event($modDir.'xml/mideno_event.xml');
		break;
		case "show":	$toDo					= 	$event->switch_event_status($eId, "1");
							$event_display_cfrm_msg	= $mod_lang_output['EVENT_SET_VISIBLE_SUCCESS'];
							$system->set_log('EVENT SET VISIBLE - ('.$event->get_event_by_id($event->fld_eventLib, $eId).')');
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_event($modDir.'xml/mideno_event.xml');
		break;
		case "update" : $tabUpd					= 	$event->get_event($eId); //Ce tableau sera utilis pour remplir les champs du formulaire de modification
							$event_displayUpd = true;
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_event($modDir.'xml/mideno_news.xml');
		break;
		case "catDelete" : $system->set_log('EVENT CATEGORY DELETED - ('.$event->get_event_cat_by_id($event->fld_eventTypeLib, $ecId).')');
								$toDo					= 	$event->delete_event_cat($ecId);
							   $rub_display_cfrm_msg	= 	$mod_lang_output['EVENT_CAT_DELETE_SUCCESS'];
							   
							   //Cr&eacute;er le Data Set Correspondant
							   //$news->create_xml_event("$modDir.'xml/mideno_event.xml');
							  
		break;
		case "catUpdate" : $tabCatUpd 				= 	$event->get_event_cat($ecId);
							   $rub_displayUpd			= 	true;
		break;
		case "catShow" : $toDo 					= 	$event->set_eventcat_state($ecId, 1);
								$rub_display_cfrm_msg	= 	$mod_lang_output['EVENT_CAT_VISIBLE_SUCCESS'];
								$system->set_log('EVENT CATEGORY SET VISIBLE - ('.$event->get_event_cat_by_id($event->fld_eventTypeLib, $ecId).')');
								//Cr&eacute;er le Data Set Correspondant
								//$news->create_xml_event("$modDir.'xml/mideno_event.xml');
		case "catHide" : $toDo					= 	$news->set_eventcat_state($ecId, 0);
								$rub_display_cfrm_msg	= 	$mod_lang_output['EVENT_CAT_HIDDEN_SUCCESS'];
								$system->set_log('EVENT CATEGORY SET INVISIBLE - ('.$event->get_event_cat_by_id($event->fld_eventTypeLib, $ecId).')');
								//Cr&eacute;er le Data Set Correspondant
								//$news->create_xml_event("$modDir.'xml/mideno_event.xml');
		break;
	}
?>