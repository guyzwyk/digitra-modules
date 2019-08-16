<?php
	//Modifier une annonce
	$btn_annonce_upd			= 	$_POST['btn_annonce_upd'];
	$annonce_selLangUpd			= 	$_POST['annonce_selLangUpd'];
	$hd_annonce_id				= 	$_POST['hd_annonce_id'];
	$annonce_selCatUpd			= 	$_POST['annonce_selCatUpd'];
	$txt_annonce_title_upd 		= 	$_POST['txt_annonce_title_upd'];
	$txt_annonce_author_upd		= 	$_POST['txt_annonce_author_upd'];
	$ta_annonce_content_upd		= 	stripslashes($_POST['ta_annonce_content_upd']);
	$txt_annonce_signature_upd	= 	$_POST['txt_annonce_signature_upd'];
	$datePubUpd					= 	$_POST['cmbYearUpd']."-".$_POST['cmbMonthUpd']."-".$_POST['cmbDayUpd'];
	
	if(isset($btn_annonce_upd)){
		if(empty($txt_annonce_title_upd) || empty($ta_annonce_content_upd))
			$annonce_update_err_msg 	= 	$mod_lang_output['CALLOUT_UPDATE_MANDATORY'];
		elseif($annonce->annonce_update(
									$hd_annonce_id, 
								  	$_SESSION['uId'],
								  	$annonce_selCatUpd, 
								  	addslashes($txt_annonce_title_upd),
								  	addslashes($ta_annonce_content_upd),
								  	addslashes($txt_annonce_signature_upd),
								  	$datePubUpd,
								  	$annonce_selLangUpd
								  	)){
			$annonce_update_cfrm_msg 	= 	$mod_lang_output['CALLOUT_UPDATE_SUCCESS'];
			//Creer le Data Set Correspondant
			$annonce->create_xml_annonce("../modules/annonce/xml/annonce.xml");
			$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
			$annonce->set_log('ANNOUNCEMENT UPDATE SUCCESS :: '.stripslashes($txt_annonce_title_upd));
		}
	}
?>

<?php
	//Ajouter une cat&eacute;gorie
	$btn_cat_insert					= 	$_POST['btn_cat_insert'];
	$annonce_catSelLang				= 	$_POST['annonce_catSelLang'];
	$txt_cat_lib 					= 	addslashes($_POST['txt_cat_lib']);
	
	if(isset($btn_cat_insert)){
		if(empty($txt_cat_lib))
			$rub_insert_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_ERROR_EMPTY'];
		elseif($annonce->chk_entry_twice($annonce->tbl_annonceCat, "annonce_cat_lib", "lang_id", $txt_cat_lib, $annonce_catSelLang))
			$rub_insert_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_ERROR_EXIST'];
		elseif($annonce->annonce_cat_insert($txt_cat_lib, $annonce_catSelLang)){
			$rub_insert_cfrm_msg 	= 	$mod_lang_output['CALLOUT_CAT_INSERT_SUCCESS'];
			$annonce->set_log('ANNOUNCEMENT CATEGORY UPDATE :: '.stripslashes($txt_cat_lib_upd));
		}
			
	}
?>

<?php
	//Modifier une cat&eacute;gorie d'annonce
	$hd_cat_id						= 	$_POST['hd_cat_id'];
	$btn_cat_upd					= 	$_POST['btn_cat_upd'];
	$annonce_selLangUpd				= 	$_POST['annonce_selLangUpd'];
	$txt_cat_lib_upd 				= 	addslashes($_POST['txt_cat_lib_upd']);
	
	if(isset($btn_cat_upd)){
		if(empty($txt_cat_lib_upd))
			$rub_update_err_msg 	= 	$mod_lang_output['CALLOUT_CAT_UPDATE_ERROR_EMPTY'];
		elseif($annonce->update_annonce_cat($hd_cat_id, $txt_cat_lib_upd, $annonce_selLangUpd)){
			$rub_update_cfrm_msg 	= 	$mod_lang_output['CALLOUT_CAT_UPDATE_SUCCESS'];
			$annonce->set_log('ANNOUNCEMENT CATEGORY UPDATE :: '.stripslashes($txt_cat_lib_upd));
		}
	}
?>

<?php
	//Ajouter une annonce
	$btn_annonce_insert		= $_POST['btn_annonce_insert'];
	$annonce_selCat			= $_POST['annonce_selCat'];

	$annonce_selLang		= ($_POST['hdLang'] == '')	?	($_SESSION['LANG'])	: ($_POST['hdLang']);

	$txt_annonce_title 		= addslashes($_POST['txt_annonce_title']);
	$txt_annonce_signature	= addslashes($_POST['txt_annonce_signature']);
	$ta_annonce_content		= addslashes($_POST['ta_annonce_content']);
	$datePub				= $_POST['cmbYear']."-".$_POST['cmbMonth']."-".$_POST['cmbDay'];
	$dateInsert				= $annonce->get_date();
	
	
	//Les pieces-jointes
	$annoncePJ_name = $_FILES['annoncePJ']['name'];
	$annoncePJ_size = $_FILES['annoncePJ']['size'];
	
	
	//Extensions acceptes
	$tabExt = array("gif", "jpg", "png", "pdf", "docx", "rtf", "doc", "odt");
	
	//Rpertoire de destination des CV
	$uploaddir = "../dox/";
	
	
	//Validations *****************************************************************************
	if(isset($btn_annonce_insert)){
		$annonce_img='no_annonce_img';

		if($annonce_selLang   ==   'NULL')
		    $annonce_insert_err_msg = $mod_lang_output['FORM_ERROR_LANG'];
		elseif(empty($txt_annonce_title) || empty($ta_annonce_content))
			$annonce_insert_err_msg 	= 	$mod_lang_output['CALLOUT_INSERT_ERROR_EMPTY'];
		elseif($annonce->chk_entry($annonce->tbl_annonce, "annonce_title", $txt_annonce_title))
			$annonce_insert_err_msg 	= 	$mod_lang_output['CALLOUT_INSERT_ERROR_EXIST_SAME_TITLE'];
		elseif($annonce->chk_entry($annonce->tbl_annonce, "annonce_lib", $ta_annonce_content))
			$annonce_insert_err_msg 	= 	$mod_lang_output['CALLOUT_INSERT_ERROR_EXIST'];
		elseif($insertId = $annonce->annonce_insert($annonce_selCat, $_SESSION['uId'], $txt_annonce_title,  $ta_annonce_content, $txt_annonce_signature, $annonce_img, $datePub, $dateInsert, $annoncePJ, $annonce_selLang)){
			$annonce_insert_cfrm_msg 	= 	$mod_lang_output['CALLOUT_INSERT_SUCCESS'];
			//$annonce->create_xml_annonce("../modules/annonce/xml/annonce.xml");
			$annonce->set_log('ANNOUNCEMENT CREATED :: '.$txt_annonce_title);
			if($annoncePJ_name != ""){
				//Envoyer le fichier et Mettre la table a jour
				if(move_uploaded_file($_FILES['annoncePJ']['tmp_name'], $uploaddir . $annoncePJ_name) && ($annonce->annonce_element_update("annonce_pj", $annoncePJ_name, $insertId))){
					$annonce_insert_cfrm_msg .= "<br />".$mod_lang_output['CALLOUT_INSERT_SUCCESS_PJ'];
					$annonce->set_log('ANNOUNCEMENT INSERTED WITH ATTACHMENT');
				}	
			}
		}
	}
?>

<?php
	//Actions sur les annonces et leurs rubriques
	$what 			= 	$_REQUEST['what'];
	$action			= 	$_REQUEST['action'];
	$annonceId		= 	$_REQUEST['pmId'];
	$acId			= 	$_REQUEST['acId'];
	
	switch($action){
		case	"delete" 	:	$toDo						= 	$annonce->del_annonce($annonceId);
								$annonce_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_DELETE_SUCCESS'];;
								//Cr&eacute;er le Data Set Correspondant
								//$annonce->create_xml_annonce("../modules/annonce/xml/annonce.xml");
								$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
								$annonce->set_log('ANNOUNCEMENT DELETED :: ID was '.$annonceId);
		break;

		case 	"hide"		: 	$toDo						= 	$annonce->set_annonce_state($annonceId, "0");
								$annonce_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_HIDE'];;
								//Cr&eacute;er le Data Set Correspondant
								//$annonce->create_xml("../modules/annonce/xml/annonce.xml");
								$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
								$annonce->set_log('ANNOUNCEMENT TURNED PRIVATE :: ID is '.$annonceId);
		break;

		case 	"show"		:	$toDo						= 	$annonce->set_annonce_state($annonceId, "1");
								$annonce_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_SHOW'];
								//Cr&eacute;er le Data Set Correspondant
								//$annonce->create_xml("../modules/annonce/xml/annonce.xml");
								$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
								$annonce->set_log('ANNOUNCEMENT TURNED PUBLIC :: ID is '.$annonceId);
		break;

		case 	"update" 	:	$tabUpd						= 	$annonce->get_annonce($pmId); //Ce tableau sera utilis pour remplir les champs du formulaire de modification
								$annonce_displayUpd 		= 	true;
		break;

		case	 "catDelete": 	$toDo						= 	$annonce->del_annonce_cat($acId);
								$rub_display_cfrm_msg		= 	$mod_lang_output['CALLOUT_CAT_DELETE_SUCCESS'];
								$annonce->set_log('ANNOUNCEMENT CATEGORY DELETED :: ID wass '.$acId);
							  
		break;

		case 	"catUpdate" : 	$tabCatUpd 					= 	$annonce->get_annonce_cat($acId);
								$rub_displayUpd				= 	true;
		break;

		case 	"catShow" 	: 	$toDo 						= 	$annonce->set_annoncecat_state($acId, 1);
								$rub_display_cfrm_msg		= 	$mod_lang_output['CALLOUT_CAT_SHOW'];
								$annonce->set_log('ANNOUNCEMENT CATEGORY TURNED PUBLIC :: ID is '.$acId);
		break;

		case 	"catHide" 	: 	$toDo						= 	$annonce->set_annoncecat_state($acId, 0);
								$rub_display_cfrm_msg		= 	$mod_lang_output['CALLOUT_CAT_HIDE'];
								$annonce->set_log('ANNOUNCEMENT CATEGORY TURNED PUBLIC :: ID is '.$acId);
		break;
	}
?>