<?php
	require('library/preregistration.inc.php');
	$myPreg	= new cwd_preregistration();
	$myFile	= new cwd_preregistration();
	//:::::::::::::::::::::::::::::::preg Module:::::::::::::::::::::::::::::::
	//Form validation
	$txtFirstName 	= ucwords($_POST[txtFirstName]);
	$txtLastName	= strtoupper($_POST[txtLastName]);
	$txtEmail		= $_POST[txtEmail];
	$txtPhone1		= $_POST[txtPhone1];
	$txtPhone2		= $_POST[txtPhone2];
	$txtAdress		= $_POST[txtAdress];
	$txt_lastDiploma= $_POST[txt_lastDiploma];
	$txtCity		= $_POST[txtCity];
	$selCountry		= $_POST[selCountry];
	$selCenter		= $_POST[selCenter];
	$selContest		= $_POST[selContest];
	$dateTime		= $mySystem->get_datetime();
	$btnOk			= $_POST[btnOk];
	
	//File
	$preg_file_name	= $_FILES[selPhoto][name];
	$preg_file_temp	= $_FILES[selPhoto][tmp_name];
	$preg_file_size	= $_FILES[selPhoto][size];
	
	$currentId = ($myPreg->get_tbl_last_id($myPreg->tbl_preg, $myPreg->fld_pregId) + 1);
		
	//Definir la taille max du fichier
	$myFile->set_fileMaxSize(153600);
		
	//Renommage du fichier :
	$pixExt 		= $myPreg->get_file_ext($preg_file_name);
	$preg_file_name = $currentId.".".$pixExt;
	$pixType		= $myFile->fileImgType;
	
	//Creation du fichier temporaire
	$myFile->set_fileTempName($preg_file_temp);
	//Definition du repertoire d'envoi des images et des imagettes
	$myFile->set_fileDirectory($myPreg->dir_preg_img);
	
	
	
	if(isset($btnOk)){
		if((empty($txtFirstName)) || (empty($txtLastName)) || (empty($txtEmail)) || (empty($txtCity)) || (empty($txt_lastDiploma)) || (empty($txtAdress)) || (empty($txtPhone2)) || (empty($selCountry)) || (empty($selCenter)) || (empty($selContest))){
			$err_msg 			= $lang_output[PREG_REQUIRED];
			$frm_msgDisplay		= "<div class=\"boxErr\">$err_msg</div>";
		}
		elseif(!$myPreg->chk_mail($txtEmail)){
			$err_msg		= $lang_output[PREG_ERROR_EMAIL];
			$frm_msgDisplay	= "<div class=\"boxErr\">$err_msg</div><p>&nbsp</p>";
		}
		elseif($myPreg->chk_entry_trice($myPreg->tbl_preg, $myPreg->fld_pregFirstName, $myPreg->fld_pregLastName, $myPreg->fld_pregEmail, $txtFirstName, $txtLastName, $txtEmail)){
			$err_msg		= $lang_output[PREG_ERROR_DUPLICATE];
			$frm_msgDisplay	= "<div class=\"boxErr\">$err_msg</div><p>&nbsp</p>";
		}
		elseif($preg_file_size > $myFile->fileMaxSize){
			$err_msg		= $lang_output[PREG_ERROR_PHOTO];
			$frm_msgDisplay	= "<div class=\"boxErr\">$err_msg</div><p>&nbsp</p>";
		}
		elseif(!in_array($pixExt, $pixType)){
			$err_msg		= $lang_output[PREG_ERROR_PHOTO];
			$frm_msgDisplay	= "<div class=\"boxErr\">$err_msg</div><p>&nbsp</p>";
		}
		elseif($myPreg->set_preregistration($txtFirstName, $txtLastName, $txtCity, $selCenter, $txtPhone1, $txtPhone2, $txtEmail, $txtAdress, $selCountry, $txt_lastDiploma, $selContest, $preg_file_name, $dateTime)){
			//Envoi du fichier après insertion des données dans la base
			$myFile->fileSend($preg_file_name);
			
			//Preparation du mail à envoyer
			$pregMsg		= "<p>Ses coordonn&eacute;es essenteilles sont les suivantes : </p><p><img src=\"".$thewu32_site_url."modules/preregistration/4x4/$preg_file_name\" align=\"left\" style=\"width:200px; margin-right:10px;\" /><strong>Nom : </strong>$txtFirstName $txtLastName<br /><strong>E-mail : </strong>$txtEmail<br /><strong>Concours choisi : </strong>".$myPreg->get_contest_by_id($selContest)."<br /><strong>Centre choisi : </strong>".$myPreg->get_center_by_id($selCenter)."</p><div style=\"clear:both;\"></div>";
			$pregSubject	= "[$pageName] - Pré-enregistrement en ligne de $txtFirstName $txtLastName";
			$pregTo			= $pageEmail;
			
			//Envoi du mail...
			$mailHeaders	= "From:"."$txtEmail"."\r\n" ."MIME-Version: 1.0\r\n"."Content-Type: text/html; charset=iso-8859-1\r\nReply-to : ".$txtEmail;
			@mail($pregTo, $pregSubject, $pregMsg, $mailHeaders);
			@mail($thewu32_authorEmail, $pregSubject, $pregMsg, $mailHeaders);
			
			//Message de confirmation
			$cfrm_msg		= $lang_output[PREG_OK];
			$frm_msgDisplay	= "<div class=\"boxCfrm\">$cfrm_msg</div><p>&nbsp</p>";
		}
		else{
			$err_msg		= $lang_output[PREG_ERROR];
			$frm_msgDisplay	= "<div class=\"boxErr\">$err_msg</div><p>&nbsp</p>";
		}
		$validateFirstName		= $myPage->show_content($err_msg, $_POST[txtFirstName]);
		$validateLastName		= $myPage->show_content($err_msg, $_POST[txtLastName]);
		$validateEmail			= $myPage->show_content($err_msg, $_POST[txtEmail]);
		$validatePhone1			= $myPage->show_content($err_msg, $_POST[txtPhone1]);
		$validatePhone2			= $myPage->show_content($err_msg, $_POST[txtPhone2]);
		$validateAdress			= $myPage->show_content($err_msg, $_POST[txtAdress]);
		$validateCity			= $myPage->show_content($err_msg, $_POST[txtCity]);
		$validateLastDiploma	= $myPage->show_content($err_msg, $_POST[txt_lastDiploma]);
	}
	
	//**preg smarty assignations
	/*frmLabels*/
	$oSmarty->assign('s_lbl_preg_firstName', $lang_output[PREG_FIRST_NAME]);
	$oSmarty->assign('s_lbl_preg_lastName', $lang_output[PREG_LAST_NAME]);
	$oSmarty->assign('s_lbl_preg_email', $lang_output[PREG_EMAIL]);
	$oSmarty->assign('s_lbl_preg_fPhone', $lang_output[PREG_FIXED_PHONE]);
	$oSmarty->assign('s_lbl_preg_mPhone', $lang_output[PREG_MOBILE_PHONE]);
	$oSmarty->assign('s_lbl_preg_iaiCenter', $lang_output[PREG_IAI_CENTER]);
	$oSmarty->assign('s_lbl_preg_lastDiploma', $lang_output[PREG_LAST_DIPLOMA]);	
	$oSmarty->assign('s_lbl_preg_iaiContest', $lang_output[PREG_IAI_CONTEST]);
	$oSmarty->assign('s_lbl_preg_photo', $lang_output[PREG_PHOTO]);
	$oSmarty->assign('s_lbl_preg_country', $lang_output[PREG_COUNTRY]);
	$oSmarty->assign('s_lbl_preg_city', $lang_output[PREG_CITY]);
	$oSmarty->assign('s_lbl_preg_pobox', $lang_output[PREG_POBOX]);
	$oSmarty->assign('s_lbl_preg_okBtn', $lang_output[PREG_OK_BTN]);
	$oSmarty->assign('s_lbl_preg_chooseCountry', $lang_output[PREG_COMBO_CHOOSE_COUNTRY]);
	$oSmarty->assign('s_lbl_preg_chooseCenter', $lang_output[PREG_COMBO_CHOOSE_CENTER]);
	$oSmarty->assign('s_lbl_preg_chooseContest', $lang_output[PREG_COMBO_CHOOSE_CONTEST]);
	$oSmarty->assign('s_lbl_preg_confirm', $lang_output[PREG_CONFIRM]);

	
	/*frmVars*/
	$oSmarty->assign('s_frmMsgDisplay', $frm_msgDisplay);
	$oSmarty->assign('s_validateFirstName', $validateFirstName);
	$oSmarty->assign('s_validateLastName', $validateLastName);
	$oSmarty->assign('s_validateEmail', $validateEmail);
	$oSmarty->assign('s_validatePhone1', $validatePhone1);
	$oSmarty->assign('s_validatePhone2', $validatePhone2);
	$oSmarty->assign('s_validateAdress', $validateAdress);
	$oSmarty->assign('s_validateLastDiploma', $validateLastDiploma);
	$oSmarty->assign('s_validateCity', $validateCity);
	$oSmarty->assign('s_validateCountry', $validateCountry);
	$oSmarty->assign('s_validateCenter', $validateCenter);
	$oSmarty->assign('s_validateContest', $validateContest);
	$oSmarty->assign('s_loadCountry', $myCountry->cmb_load_country($_POST[selCountry]));
	$oSmarty->assign('s_loadCenters', $myPreg->cmb_load_centers($_POST[selCenter]));
	$oSmarty->assign('s_loadContests', $myPreg->cmb_load_contests($_POST[selContest]));
	$oSmarty->assign('s_validateDescr', $validateDescr);
	$oSmarty->assign('s_validateOther', $validateOther);