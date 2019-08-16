<?php
	//Modifier une interview
	$btn_interview_upd	= 	$_POST[btn_interview_upd];
	$txt_nameUpd		= 	$_POST[txt_nameUpd];
	$hd_interview_id	= 	$_POST[hd_interview_id];
	$txt_rankUpd		= 	$_POST[txt_rankUpd];
	$ta_subjectUpd 		= 	stripslashes($_POST[ta_subjectUpd]);
	$txt_emailUpd		= 	$_POST[txt_emailUpd];
	$txt_telUpd			= 	$_POST[txt_telUpd];
	$txt_cniUpd			= 	$_POST[txt_cniUpd];
	$dateUpd			= 	$_POST[cmbYearUpd]."-".$_POST[cmbMonthUpd]."-".$_POST[cmbDayUpd];
	
	if(isset($btn_interview_upd)){
		if(empty($txt_interview_title_upd) || empty($ta_interview_content_upd))
			$interview_update_err_msg 	= "Veuillez remplir <strong>tous</strong> les champs obligatoires svp...";
		elseif($myInterview->interview_update(
					$hd_interview_id,
					$interview_selCatUpd, 
					$_SESSION['uId'], 
					$txt_interview_title_upd,
					$ta_interview_content_upd,
					$txt_interview_signature_upd,
					$datePubUpd,
					$interview_selLangUpd
				)){
			$interview_update_cfrm_msg 	= "interview modifi&eacute;e avec succ&egrave;s";
			//Creer le Data Set Correspondant
			//$myInterview->create_xml_interview("../modules/interview/xml/interview.xml");
			$myRss->makeRSS("../rss/interviews.xml");
		}
	}
?>

<?php
	//Ajouter une cat&eacute;gorie
	$btn_cat_insert	= $_POST[btn_cat_insert];
	$selLang		= $_POST[selLang];
	$txt_cat_lib 	= addslashes($_POST[txt_cat_lib]);
	
	if(isset($btn_cat_insert)){
		if(empty($txt_cat_lib))
			$rub_insert_err_msg 	= "You must specify a category...";
		elseif($myInterview->chk_entry_twice($myInterview->tbl_interviewCat, "interview_cat_lib", "lang", $txt_cat_lib, $selLang))
			$rub_insert_err_msg 	= "Sorry!<br />That category still exists.<br />Please try again...!";
		elseif($myInterview->interview_cat_insert($txt_cat_lib, $selLang))
			$rub_insert_cfrm_msg 	= "Category successfully inserted";
	}
?>

<?php
	//Modifier une cat&eacute;gorie d'interview
	$hd_cat_id			= $_POST[hd_cat_id];
	$btn_cat_upd		= $_POST[btn_cat_upd];
	$interview_selLangUpd	= $_POST[interview_selLangUpd];
	$txt_cat_lib_upd 	= addslashes($_POST[txt_cat_lib_upd]);
	
	if(isset($btn_cat_upd)){
		if(empty($txt_cat_lib_upd))
			$rub_update_err_msg 	= "Please you must specify a category...";
		elseif($myInterview->update_interview_cat($hd_cat_id, $txt_cat_lib_upd, $interview_selLangUpd))
			$rub_update_cfrm_msg 	= "Category successfully modified";
	}
?>

<?php
	//Ajouter une interview
	$btn_interview_insert		= $_POST[btn_interview_insert];
	$interview_selCat			= $_POST[interview_selCat];
	$interview_selLang		= $_POST[interview_selLang];
	$txt_interview_title 		= addslashes($_POST[txt_interview_title]);
	$txt_interview_signature	= addslashes($_POST[txt_interview_signature]);
	$ta_interview_content		= addslashes($_POST[ta_interview_content]);
	$datePub				= $_POST[cmbYear]."-".$_POST[cmbMonth]."-".$_POST[cmbDay];
	$dateInsert				= $myInterview->get_date();
	
	
	//Les pieces-jointes
	$interviewPJ_name = $_FILES[interviewPJ][name];
	$interviewPJ_size = $_FILES[interviewPJ][size];
	
	
	//Extensions acceptes
	$tabExt = array("gif", "jpg", "png", "pdf", "docx", "rtf", "doc", "odt");
	
	//Rpertoire de destination des CV
	$uploaddir = "../dox/";
	
	
	//Validations *****************************************************************************
	if(isset($btn_interview_insert)){
		$interview_img='no_interview_img';
		if(empty($txt_interview_title) || empty($ta_interview_content))
			$interview_insert_err_msg 	= "Veuillez remplir <strong>tous</strong> les champs obligatoires svp...";
		elseif($myInterview->chk_entry($myInterview->tbl_interview, "interview_title", $txt_interview_title))
			$interview_insert_err_msg 	= "D&eacute;sol&eacute;!<br />Ce titre existe d&eacute;j&agrave;.<br />Veuillez reessayer ult&eacute;rieurement svp...!";
		elseif($myInterview->chk_entry($myInterview->tbl_interview, "interview_lib", $ta_interview_content))
			$interview_insert_err_msg 	= "D&eacute;sol&eacute;!<br />Cette interview a d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute;!<br />";
		elseif($insertId = $myInterview->interview_insert($interview_selCat, $_SESSION['uId'], $txt_interview_title,  $ta_interview_content, $txt_interview_signature, $interview_img, $datePub, $dateInsert, $interviewPJ, $interview_selLang)){
			$interview_insert_cfrm_msg 	= "interview ajout&eacute; avec succ&egrave;s";
			if($interviewPJ_name != ""){
				//Envoyer le fichier et Mettre la table a jour
				if(move_uploaded_file($_FILES[interviewPJ]['tmp_name'], $uploaddir . $interviewPJ_name) && ($myInterview->interview_element_update("interview_pj", $interviewPJ_name, $insertId)))
					$interview_insert_cfrm_msg .= "<br />Une pi&egrave;ce-jointe est ajout&eacute;e &agrave; l'interview.";
			}
		}
	}
?>

<?php
	//Actions sur les interviews et leurs rubriques
	$what 			    =   $_REQUEST[what];
	$action			    =   $_REQUEST[action];
	$interviewId	    =   $_REQUEST[interviewId];
	$icId			    =   $_REQUEST[icId];
	
	switch($action){
		case "interviewDelete" : $toDo 					= $myInterview->del_interview($interviewId);
							$interview_display_cfrm_msg	= "News supprim&eacute; avec succ&egrave;s";
							//Cr&eacute;er le Data Set Correspondant
							//$myInterview->create_xml_interview("../modules/interview/xml/interview.xml");
							$myRss->makeRSS("../rss/interviews.xml");
		break;
		case "interviewPrivate": $toDo					= $myInterview->set_interview_state($interviewId, "0");
							$interview_display_cfrm_msg	= "Vous avez rendu la news inaccessibe aux visiteurs du site.";
							//Cr&eacute;er le Data Set Correspondant
							//$myInterview->create_xml_interview("../modules/interview/xml/interview.xml");
							$myRss->makeRSS("../rss/interviews.xml");
		break;
		case "interviewPublish":	$toDo					= $myInterview->set_interview_state($interviewId, "1");
							$interview_display_cfrm_msg	= "Vous avez publi&eacute; la news aux visiteurs du site.";
							//Cr&eacute;er le Data Set Correspondant
							//$myInterview->create_xml_interview("../modules/interview/xml/interview.xml");
							$myRss->makeRSS("../rss/interviews.xml");
		break;
		case "interviewUpdate" : $tabUpd			= $myInterview->get_interview($interviewId); //Ce tableau sera utilis pour remplir les champs du formulaire de modification
							$interview_displayUpd = true;
		break;
		case "interviewCatDelete" : $toDo					= $myInterview->del_interview_cat($acId);
							   $rub_display_cfrm_msg	= "Cat&eacute;gorie supprim&eacute;e avec succ&egrave;s";
							  
		break;
		case "interviewCatUpdate" : $tabCatUpd 				= $myInterview->get_interview_cat($acId);
							   $rub_displayUpd				= true;
		break;
		case "interviewCatPublish" : $toDo 					= $myInterview->set_interviewcat_state($acId, 1);
								$rub_display_cfrm_msg	= "Cat&eacute;gorie rendue publique.<br />Toutes les interviews appartenant &agrave; cette cat&eacute;gorie seront dor&eacute;navant accessibles au visiteur!";
		case "interviewCatPrivate" : $toDo					= $myInterview->set_interviewcat_state($acId, 0);
								$rub_display_cfrm_msg	= "Cat&eacute;gorie rendue priv&eacute;.<br />Toutes les interviews appartenant &agrave; cette cat&eacute;gorie seront inaccessibles au visiteur!";
		break;
	}
?>