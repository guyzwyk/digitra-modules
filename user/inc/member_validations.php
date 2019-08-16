<?php 
	//Traitements ici
	/******************************** Chargement des membres ***********************************************/
	$btn_file_send_member		= 	$_POST[btn_file_send_member];
	
	//Les fichiers
	$memberFile_name 	= 	$_FILES[memberFile][name];
	$memberFile_size 	= 	$_FILES[memberFile][size];
	
	//$pageContent  = "Coco";
	//Extensions acceptees
	$tabExt = array("csv", "txt", "gzk", "cwd");
	$fileOrig	= "../member/files/imported/".$myMember->log_get_datetime()."_$memberFile_name";
	
	if(isset($btn_file_send_member)){
		if(!isset($memberFile_name)){
			$file_uploadMsg 	= "<div class=\"ADM_err_msg\">Erreur :<br />Vous devez choisir un fichier valide! $memberFile_name</div>";
		}
		else{
			//Procedure de renommage du fichier :
			$fileExt	= $myMember->get_file_ext($memberFile_name);
			if(!in_array($fileExt, $tabExt)){
				$file_uploadMsg 	= "<div class=\"ADM_err_msg\">Erreur!<br />Les fichiers de type $fileExt ne sont pas accept&eacute;s</div>";
			}
			//elseif(move_uploaded_file($_FILES[contactFile]['tmp_name'], $fileOrig)){
			elseif(move_uploaded_file($_FILES[memberFile]['tmp_name'], $fileOrig)){
				$_SESSION[file_orig]	=	$fileOrig;
				$file_uploadMsg = "<div class=\"ADM_cfrm_msg\"><p>Fichier membre envoy&eacute; avec succ&egrave;s!</p><p><a href=\"?what=memberLoad&action=memberDump&mFile=".$_SESSION[file_orig]."\">Charger le fichier dans la base des donn&eacute;es</a></p></div>";
				$system->set_log('MEMBER FILE UPLOADED - ('.$fileOrig.')');
			}
			else{
				$file_uploadMsg 	= "<div class=\"ADM_err_msg\">Impossible d'envoyer le fichier membre</div>";
			}
		}
	}
	
	/******************************** Chargement des ecolages ***********************************************/
	$btn_file_send_scholarship		= 	$_POST[btn_file_send_scholarship];
	
	//Les fichiers
	$scholarshipFile_name 			= 	$_FILES[scholarshipFile][name];
	$scholarshipFile_size 			= 	$_FILES[scholarshipFile][size];
	
	//$pageContent  = "Coco";
	//Extensions acceptees
	$tabExt = array("csv", "txt", "gzk", "cwd");
	$fileOrig	= "../member/files/imported/".$myMember->log_get_datetime()."_$scholarshipFile_name";
	
	if(isset($btn_file_send_scholarship)){
		if(!isset($scholarshipFile_name)){
			$file_uploadMsg_scholarship 	= "<div class=\"ADM_err_msg\">".$mod_lang_output['OTOURIX_FILE_NOT_ACCEPTED']." $scholarshipFile_name</div>";
		}
		else{
			//Procedure de renommage du fichier :
			$fileExt	= $myMember->get_file_ext($scholarshipFile_name);
			if(!in_array($fileExt, $tabExt)){
				$file_uploadMsg_scholarship 	= "<div class=\"ADM_err_msg\">".$mod_lang_output['OTOURIX_FILE_NOT_ACCEPTED']." $fileExt </div>";
			}
			//elseif(move_uploaded_file($_FILES[contactFile]['tmp_name'], $fileOrig)){
			elseif(move_uploaded_file($_FILES[scholarshipFile]['tmp_name'], $fileOrig)){
				$_SESSION[file_orig]	=	$fileOrig;
				$file_uploadMsg_scholarship = "<div class=\"ADM_cfrm_msg\"><p>".$mod_lang_output['OTOURIX_MEMBERS_DUMP_SUCCESS']."</p><p><a href=\"?what=fileLoad&action=scholarshipDump&scFile=".$_SESSION[file_orig]."\">".$mod_lang_output['OTOURIX_FILE_DUMP']."</a></p></div>";
				$system->set_log('TUITION FEE FILE UPLOADED - ('.$fileOrig.')');
			}
			else{
				$file_uploadMsg_scholarship	= "<div class=\"ADM_err_msg\">".$mod_lang_output['OTOURIX_FILE_CANNOT_GO']."</div>";
			}
		}
	}
	
	/******************************** Chargement des notes ***********************************************/
	$btn_file_send_note		= 	$_POST[btn_file_send_note];
	
	//Les fichiers
	$noteFile_name 			= 	$_FILES[noteFile][name];
	$noteFile_size 			= 	$_FILES[noteFile][size];
	
	//$pageContent  = "Coco";
	//Extensions acceptees
	$tabExt = array("csv", "txt", "gzk", "cwd");
	$fileOrig	= "../member/files/imported/".$myMember->log_get_datetime()."_$noteFile_name";
	
	if(isset($btn_file_send_note)){
		if(!isset($noteFile_name)){
			$file_uploadMsg_note 	= "<div class=\"ADM_err_msg\">Erreur :<br />Vous devez choisir un fichier de notes valide! $noteFile_name</div>";
		}
		else{
			//Procedure de renommage du fichier :
			$fileExt	= $myMember->get_file_ext($noteFile_name);
			if(!in_array($fileExt, $tabExt)){
				$file_uploadMsg_note 	= "<div class=\"ADM_err_msg\">Erreur!<br />Les fichiers de type $fileExt ne sont pas accept&eacute;s</div>";
			}
			//elseif(move_uploaded_file($_FILES[contactFile]['tmp_name'], $fileOrig)){
			elseif(move_uploaded_file($_FILES[noteFile]['tmp_name'], $fileOrig)){
				$_SESSION[file_orig]	=	$fileOrig;
				$file_uploadMsg_note = "<div class=\"ADM_cfrm_msg\"><p>Fichier envoy&eacute; avec succ&egrave;s!</p><p><a href=\"?what=fileLoad&action=noteDump&nFile=".$_SESSION[file_orig]."\">Charger le fichier dans la base des donn&eacute;es</a></p></div>";
				$system->set_log('NOTES FILE UPLOADED - ('.$fileOrig.')');
			}
			else{
				$file_uploadMsg_note	= "<div class=\"ADM_err_msg\">Impossible d'envoyer le fichier</div>";
			}
		}
	}
	
	/******************************** Ajouter un membre ***********************************************/
	$btn_memberInsert	= 	$_POST['btn_memberInsert'];
	$sel_memberType		=	$_POST['sel_memberType'];
	$sel_memberClass	=	$_POST['sel_memberClass'];
	$txt_memberName		=	$_POST['txt_memberName'];
	$txt_memberLogin	=	$_POST['txt_memberLogin'];
	$txt_memberPass1	=	$_POST['txt_memberPass1'];
	$txt_memberPass2	=	$_POST['txt_memberPass2'];
	$txt_memberTel		=	$_POST['txt_memberTel'];
	
	if(isset($btn_memberInsert)){
		if(empty($txt_memberName) || empty($txt_memberLogin) || empty($txt_memberPass1))
			$member_insert_err_msg	=	"Erreur!<br />Les champs avec ast&eacute;risques sont obligatoires";
		elseif($txt_memberPass1 != $txt_memberPass2)
			$member_insert_err_msg	=	"Erreur!<br />Les mots de passe doivent &ecirc;tre identiques";
		elseif($myMember->chk_entry($myMember->tbl_member, $myMember->fld_memberName, $txt_memberName) || $myMember->chk_entry($myMember->tbl_member, $myMember->fld_memberLogin, $txt_memberLogin))
			$member_insert_err_msg	=	"Erreur!<br />Le code membre ou le nom existe d&eacute;j&agrave; dans notre syst&egrave;me.";
		elseif(($sel_memberType != '3') && ($sel_memberClass != '0'))
			$member_insert_err_msg	=	"Erreur!<br />Vous ne pouvez renseigner les classes que pour les membres de type <em>'&Eacute;l&egrave;ve'</em>";
		elseif($myMember->set_member('', $txt_memberName, $sel_memberType, $txt_memberLogin, trim($txt_memberPass1), $sel_memberClass, $txt_memberTel, '0')){
			$member_insert_cfrm_msg	=	"Bravo!<br />Vous avez pu ins&eacute;rer un membre avec succ&egrave;s dans notre syst&egrave;me!<br /><a href=\"?what=memberDisplay\">Cliquez ici</a> pour afficher la liste des membres ou remplissez le formulaire pour en ajouter d'autres.";
			$system->set_log('OTOURIX MEMBER CREATED - ('.$txt_memberName.')');
		}
		
	}
	
	/******************************** Modifier un membre ***********************************************/
	$hd_memberId			=	$_POST['hd_memberId'];
	$btn_memberUpdate		= 	$_POST['btn_memberUpdate'];
	$sel_memberTypeUpd		=	$_POST['sel_memberTypeUpd'];
	$sel_memberClassUpd		=	$_POST['sel_memberClassUpd'];
	$txt_memberNameUpd		=	$_POST['txt_memberNameUpd'];
	$txt_memberLoginUpd		=	$_POST['txt_memberLoginUpd'];
	$txt_memberPassUpd		=	$_POST['txt_memberPassUpd'];
	$txt_memberTelUpd		=	$_POST['txt_memberTelUpd'];	
	
	if(isset($btn_memberUpdate)){
		if(empty($txt_memberNameUpd) || empty($txt_memberLoginUpd))
			$member_update_err_msg	=	"Erreur!<br />Les champs avec ast&eacute;risques sont obligatoires";
		/* elseif($myMember->chk_entry($myMember->tbl_member, $myMember->fld_memberName, $txt_memberNameUpd) || $myMember->chk_entry($myMember->tbl_member, $myMember->fld_memberLogin, $txt_memberLoginUpd))
			$member_update_err_msg	=	"Erreur!<br />Le code membre ou le nom existe d&eacute;j&agrave; dans notre syst&egrave;me."; */
		elseif(($sel_memberTypeUpd != '3') && ($sel_memberClassUpd != '0'))
			$member_update_err_msg	=	"Erreur!<br />Vous ne pouvez renseigner les classes que pour les membres de type <em>'&Eacute;l&egrave;ve'</em>";
		elseif($myMember->update_member($hd_memberId, $sel_memberTypeUpd, $sel_memberClassUpd, $txt_memberNameUpd, $txt_memberLoginUpd, $txt_memberTelUpd)){
			if(!empty($txt_memberPassUpd))
					$myMember->update_member_element($myMember->fld_memberPass, sha1(trim($txt_memberPassUpd)), $hd_memberId); //Update the password if necessary
			$member_update_cfrm_msg	=	"Bravo!<br />Vous avez pu mettre &agrave; jour les informations sur le membre avec succ&egrave;s dans notre syst&egrave;me!<br /><a href=\"?what=memberDisplay\">Cliquez ici</a> pour afficher la liste des membres.";
			$system->set_log('OTOURIX MEMBER UPDATED - ('.$txt_memberNameUpd.')');
		}
	}
	
	/******************************** Reinitialiser le mot de passe d'un membre ***********************************************/
	$hd_passwordIni		=	$_POST['hd_passwordIni'];
	$btn_passwordIni	=	$_POST['btn_passwordIni'];
	
	if (isset($btn_passwordIni)){
		$memberInfo	= $myMember->get_member($hd_passwordIni);
		if($myMember->password_ini($hd_passwordIni)){
			$action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Mot de passe de ".ucfirst($memberInfo[m_NAME])." r&eacute;initialis&eacute; avec succ&egrave;s</div>";
			$system->set_log('OTOURIX MEMBER PASSWORD REINITIALIZED - ('.ucfirst($memberInfo[m_NAME]).')');
		}
	}
?>
<?php 
	switch($_REQUEST[action]){
		case	'memberDump'		: 	if($totalMember = $myMember->csv_dump_members($_REQUEST[mFile])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">$totalMember membres effectivement import&eacute;s dans le syst&egrave;me.<br /><a href=\"?what=memberDisplay\">Afficher les membres</a></div>"; $system->set_log('OTOURIX MEMBER FILE DUMPED SUCCESSFULLY - ('.$_REQUEST[mFile].')');} else{$file_dumpMsg="<div class=\"ADM_err_msg\">Erreur lors de l'importation des donn&eacute;es dans le syst&egrave;me</div>"; $system->set_log('OTOURIX MEMBER FILE DUMP ERROR - ('.$_REQUEST[mFile].')');}
		break;
		case	'scholarshipDump'	: 	if($totalScholarship = $myMember->csv_dump_scholarships($_REQUEST[scFile])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">$totalScholarship enregistrements effectivement import&eacute;s dans le syst&egrave;me.<br /><a href=\"?what=scDisplay\">Afficher le donn&eacute;es d'ecolages</a></div>"; $system->set_log('OTOURIX TUITION FEES FILE DUMPED SUCCESSFULLY - ('.$_REQUEST[mFile].')');} else{$file_dumpMsg_scholarship="<div class=\"ADM_err_msg\">Erreur lors de l'importation des donn&eacute;es d'&eacute;colage dans le syst&egrave;me</div>"; $system->set_log('OTOURIX TUITION FEE DUMP ERROR - ('.$_REQUEST[mFile].')');}
		break;
		case	'noteDump'			: 	if($totalNote = $myMember->csv_dump_notes($_REQUEST[nFile])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">$totalNote notes effectivement import&eacute;s dans le syst&egrave;me.<br /><a href=\"?what=noteDisplay\">Afficher les notes</a></div>"; $system->set_log('OTOURIX SCHOOL NOTES DUMPED SUCCESSFULLY - ('.$_REQUEST[mFile].')');} else{$file_dumpMsg_note="<div class=\"ADM_err_msg\">Erreur lors de l'importation des donn&eacute;es de notes dans le syst&egrave;me</div>"; $system->set_log('OTOURIX SCHOOL NOTES DUMP ERROR - ('.$_REQUEST[mFile].')');}
		break;
		case 	'memberDelete'		: 	if($myMember->del_member($_REQUEST['memberId'])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />Le membre a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s!</div>"; }
		break;
		case 	'requestDelete'		: 	if($myMember->del_request($_REQUEST['rId'])) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />La requ&ecirc;te a &eacute;t&eacute; supprim&eacute;e avec succ&egrave;s!</div>"; }
		break;
		case 	'memberActivate'	: 	if($myMember->set_member_state($_REQUEST['memberId'], '1')) { $memberInfo = $myMember->get_member($_REQUEST[memberId]); $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />Le vous venez d'activer le compte membre de ".$memberInfo['m_NAME']." avec succ&egrave;s!</div>"; }
		break;
		case 	'memberDeactivate'	: 	if($myMember->set_member_state($_REQUEST['memberId'], '0')) { $memberInfo = $myMember->get_member($_REQUEST[memberId]); $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />Le vous venez de d&eacute;sactiver le compte membre de ".$memberInfo['m_NAME']." avec succ&egrave;s!</div>"; }
		break;
		case 	'requestActivate'	: 	if($myMember->set_request_state($_REQUEST['rId'], '1')) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />La requ&ecirc;te est d&eacute;sormais marqu&eacute;e comme &laquo; En traitement... &raquo;</div>"; }
		break;
		case 	'requestDeactivate'	: 	if($myMember->set_request_state($_REQUEST['rId'], '3')) { $action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Bravo<br />La requ&ecirc;te est d&eacute;sormais marqu&eacute;e comme &laquo; Trait&eacute;e... &raquo;</div>"; }
		break;
		case 	"memberUpdate" 		: 	$memberInfo	=	$myMember->get_member($_REQUEST[memberId]);	
		break;
		case 	'memberDisconnect'	:	if($myMember->set_connected_member($_REQUEST[mcId], '0'))	$action_msgOk	=	"<div class=\"ADM_cfrm_msg\">Utilisateur d&eacute;connect&eacute; avec succ&egrave;s...</div>";
		break;
		case 	'emptyMarks'			:	if($myMember->empty_otourix_marks()) { $empty_data_msg = "<div class=\"ADM_cfrm_msg\">La table des notes a &eacute;t&eacute; vid&eacute;e avec succ&egrave;s</div>"; $system->set_log('OTOURIX SCHOOL NOTES EMPTY OK');} else { $empty_data_msg = "<div class=\"ADM_err_msg\">La table des notes n' a pas pu &ecirc;tre vid&eacute;e</div>"; $system->set_log('OTOURIX SCHOOL NOTES EMPTY ERROR');}
		break;
		case 	'emptyScholarships'		:	if($myMember->empty_otourix_scholarships()) { $empty_data_msg = "<div class=\"ADM_cfrm_msg\">La table des &eacute;colages a &eacute;t&eacute; vid&eacute;e avec succ&egrave;s</div>"; $system->set_log('OTOURIX TUITION FEES EMPTY OK');} else { $empty_data_msg = "<div class=\"ADM_err_msg\">La table des &eacute;colages n' a pas pu &ecirc;tre vid&eacute;e</div>"; $system->set_log('OTOURIX TUITION FEES EMPTY ERROR');}
		break;
		case 	'emptyMembers'			:	if($myMember->empty_otourix_members()) { $empty_data_msg = "<div class=\"ADM_cfrm_msg\">La table des membres a &eacute;t&eacute; vid&eacute;e avec succ&egrave;s</div>"; $system->set_log('OTOURIX MEMBER EMPTY OK'); } else { $empty_data_msg = "<div class=\"ADM_err_msg\">La table des membres n' a pas pu &ecirc;tre vid&eacute;e</div>"; $system->set_log('OTOURIX MEMBER EMPTY ERROR');}
		break;
	}
?>