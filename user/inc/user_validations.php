<?php
	//Initializations
    $user	        =   new cwd_user();
    $my_users       =   new cwd_user();
    $my_userStats	=	new cwd_user();
?>
<?php
	//Modifier un utilisateur
	$btn_user_update		= $_POST[btn_user_update];
	$hd_user_id				= $_POST[hd_user_id];
	$hd_user_date_enreg		= $_POST[hd_user_date_enreg];
	$hd_user_is_connected	= $_POST[hd_user_is_connected];
	$hd_user_display		= $_POST[hd_user_display];
	$hd_user_img_id			= $_POST[hd_user_img_id];
	
	$sel_user_cat_upd		= $_POST[user_selCat_upd];
	$txt_user_login_upd		= addslashes($_POST[txt_user_login_upd]);
	$txt_user_pass_upd		= addslashes($_POST[txt_user_pass_upd]);
	$txt_user_email_upd		= addslashes($_POST[txt_user_email_upd]);
	$txt_user_telephone_upd	= addslashes($_POST[txt_user_telephone_upd]);
	$txt_user_last_upd		= $_POST[txt_user_last_upd];
	$txt_user_first_upd		= $_POST[txt_user_first_upd];
	
	if(isset($btn_user_update)){
		
		//Gestion du mot de passe
		$userPass = ((isset($txt_user_pass_upd) && ($txt_user_pass_upd != '')) ? (sha1($txt_user_pass_upd)) : ($my_users->get_user_by_id("usr_pass", $hd_user_id)));
		
		if(empty($txt_user_login_upd) || empty($txt_user_email_upd))
			$user_update_err_msg 	= "Sorry!<br />Fill <strong>all</strong> the mandatory fields...";
		elseif(!$my_users->chk_mail($txt_user_email_upd))
			$user_update_err_msg 	= "Sorry!<br />E-mail is not correct. Please insert a valid one";
		elseif($my_users->update_user($hd_user_id, $txt_user_login_upd, $userPass, $sel_user_cat_upd, $hd_user_date_enreg, $hd_user_is_connected, $hd_user_display)
				&& 
			   $my_users->update_user_detail($hd_user_id, $txt_user_first_upd, $txt_user_last_upd, $txt_user_email_upd, $txt_user_telephone_upd, $hd_user_img_id)){
			$user_update_cfrm_msg = "Congratulations!<br />Account successfully updated";
			$system->set_log('USER ACCOUNT UPDATED - ('.$txt_user_login_upd.')');
			//Creer le Data Set Correspondant
			//$news->create_xml_directory("../xml/province_users.xml");
		}
	}
?>

<?php
	//Ajouter une cat&eacute;gorie
	$btn_cat_insert	= $_POST[btn_cat_insert];
	$txt_cat_lib	= addslashes($_POST[txt_cat_lib]);
	
	if(isset($btn_cat_insert)){
		if(empty($txt_cat_lib))
			$rub_insert_err_msg 	= "Sorry!<br />You must define a category please...";
		elseif($my_users->chk_entry($my_users->tbl_userType, $my_users->fld_userTypeLib, $txt_cat_lib))
			$rub_insert_err_msg 	= "Sorry!<br />this category already exists.<br />Please, fill another label value!";
		elseif($my_users->create_user_cat($txt_cat_lib)){
			$rub_insert_cfrm_msg 	= "Congratulations!<br />Category successfully created";
			$system->set_log('USER CATEGORY CREATTED - ('.$txt_cat_lib.')');
		}
	}
?>

<?php
	//Modifier une cat&eacute;gorie d'utilisateur
	$hd_cat_id			= $_POST[hd_cat_id];
	$btn_cat_upd		= $_POST[btn_cat_upd];
	$txt_cat_lib_upd 	= addslashes($_POST[txt_cat_lib_upd]);
	
	if(isset($btn_cat_upd)){
		if(empty($txt_cat_lib_upd))
			$rub_update_err_msg 	= "Error!<br />The label field should not be empty";
		elseif($my_users->update_user_cat($hd_cat_id, $txt_cat_lib_upd)){
			$rub_update_cfrm_msg 	= "Congratulations!<br />Category successfully updated";
			$system->set_log('USER CATEGORY UPDATED - ('.$txt_cat_lib_upd.')');
		}
	}
?>

<?php
	//Ajouter compte
	$btn_user_insert	= $_POST['btn_user_insert'];
	$user_selCat		= $_POST['user_selCat'];
	$txt_user_login 	= addslashes($_POST['txt_user_login']);
	$txt_user_password1	= addslashes($_POST['txt_user_password1']);
	$txt_user_password2	= addslashes($_POST['txt_user_password2']);
	$txt_user_email		= addslashes($_POST['txt_user_email']);
	$txt_user_first		= addslashes($_POST['txt_user_first']);
	$txt_user_last		= addslashes($_POST['txt_user_last']);
	$datetimeInsert		= $system->get_datetime();
	$txt_user_telephone	= $_POST['txt_user_telephone'];
	$chk_user_display	= $_POST['chk_user_display'];
	
	/*********************** Mailing configuration ***************************/
	$mailFrom		=	$thewu32_adminEmail;
	$mailFromPass	=	$thewu32_adminEmailPass;
	$mailTo			=	$txt_user_email;
	$mailSubject	=	$mod_lang_output['ADMIN_EMAIL_NAME']. ' :: '.$mod_lang_output['ADMIN_EMAIL_OBJECT'];
	$userName		=	ucfirst($txt_user_first).' '.strtoupper($txt_user_last);
	//$mailContent	=	"<p style=\"font-weight:bold;\">Hello $userName,</p><p>Your user account has been successfully created on <a href=\"http://www.cabb.info/\" target=\"_blank\">CABB's Website</a>. Below are your credentials : <br /><br /><strong>Login :</strong> $txt_user_login<br /><strong>Password :</strong> $txt_user_password1</p><p>We recommand you to keep this information in a safer place.</p><p>Please contact the Principal or the Webmaster for more informations on how to access the Extranet</p><p>Cordially.</p>";
	$mailContent	=	"<p style=\"font-weight:bold;\">".$system->greet_by_lang($_SESSION['LANG'])." $userName,</p>
						<p>Un compte pour l'acc&egrave;s &agrave; l'espace d'administration <a href=\"http://www.cabb.info/\" target=\"_blank\">du site web du CABB</a> vient d'&ecirc;tre cr&eacute;&eacute; &agrave; votre intention.</p>
						<p>Ci-dessous, figurent les codes d'acc&egrave;s qui vous permettront de vous connecter et apporter des modifications et mises &agrave; jour dans le contenu du site web.</p>
						<h3><u>Codes d'acc&egrave;s</u></h3><strong>Identifiant :</strong> $txt_user_login<br /><strong>Mot de passe :</strong> $txt_user_password1</p>
						<p>Nous vous recommandons vivement de supprimer cet e-mail et de sauvegarder ces information dans une endroit plus appropri&eacute; pour des raisons &eacute;videntes de s&eacute;curit&eacute;.</p><p>Bien vouloir contacter le Principal ou le Webmaster pour plus d'information ou en cas de besoin.</p><p>Cordialement.</p>";
	$mailHeaders	=	"MIME-Version: 1.0"."\r\n";
	$mailHeaders 	.= 	"Content-type:text/html; charset=UTF-8"."\r\nReply-to : ".$mailFrom;
	$mailHeaders 	.= 	"From: ".$mailFrom."\r\n";
	
	//Validations *****************************************************************************
	//Ajouter un utilisateur*******************************************************************
	if(isset($btn_user_insert)){
		if(empty($txt_user_login) || empty($txt_user_password1) || empty($txt_user_email))
			$user_insert_err_msg 	= $mod_lang_output['USER_ERROR_MANDATORY_FIELDS'];
		elseif($my_users->chk_entry($my_users->tbl_user, "usr_login", $txt_user_login))
			$user_insert_err_msg 	= $mod_lang_output['USER_ERROR_USER_ALREADY'];
		elseif($txt_user_password1 != $txt_user_password2)
			$user_insert_err_msg	= $mod_lang_output['USER_ERROR_PASSWORD_NOT_MATCH'];
		elseif(!$my_users->chk_mail($txt_user_email))
			$user_insert_err_msg 	= $mod_lang_output['USER_ERROR_INVALID_EMAIL'];
		elseif(($new_userId = $my_users->create_user($txt_user_login, sha1($txt_user_password1), $user_selCat, $datetimeInsert, '0', $chk_user_display)) 
			&& 
			($my_users->create_user_detail($txt_user_first, $txt_user_last, $txt_user_email, $txt_user_telephone, $user_img_id, $new_userId))){

			$user_insert_cfrm_msg 	= $mod_lang_output['CALLOUT_INSERT_SUCCESS'];
			$system->set_log('USER ACCOUNT CREATED - ('.$txt_user_login.')');

			if(mail($mailTo, $mailSubject, $mailContent, $mailHeaders)){
				$user_insert_cfrm_msg	.=	"<br />AN E-MAIL HAS BEEN SENT TO $mailTo ($txt_user_email)";
			}		
		}
	}
?>

<?php
	//Actions sur les utilisateurs et leurs categories
	$what 		= $_REQUEST['what'];
	$action		= $_REQUEST['action'];
	$uId		= $_REQUEST['uId'];
	$ucId		= $_REQUEST['ucId'];
	$userId		= $_REQUEST['userId'];
	
	
	switch($action){
		case "delete" 			: 	$toDo 					= 	$my_users->delete_user($_REQUEST[$my_users->URI_userVar]);
									$user_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_DELETE_SUCCESS'];
									//Cr&eacute;er le Data Set Correspondant
									//$news->create_xml_news("../xml/province_news.xml");
									$my_users->set_log('USER ACCOUNT CANCELED :: ID was '.$_REQUEST[$my_users->URI_userVar]);
		break;
		case 	"hide"			: 	$toDo					= 	$my_users->set_user_state($_REQUEST[$my_users->URI_userVar], "0");
									$user_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_HIDE'];;
									//Cr&eacute;er le Data Set Correspondant
									//$annonce->create_xml("../modules/annonce/xml/annonce.xml");
									//$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
									$my_users->set_log('USER DEACTIVATED :: ID is '.$_REQUEST[$my_users->URI_userVar]);
		break;
		case 	"show"			: 	$toDo					= 	$my_users->set_user_state($_REQUEST[$my_users->URI_userVar], "1");
									$user_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_SHOW'];;
									//Cr&eacute;er le Data Set Correspondant
									//$annonce->create_xml("../modules/annonce/xml/annonce.xml");
									//$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
									$my_users->set_log('USER ACTIVATED :: ID is '.$_REQUEST[$my_users->URI_userVar]);
		break;
		case "userDisconnect"	: 	$toDo					= 	$my_users->switch_user_status($uId, "0");
									$user_display_cfrm_msg	= 	"Congratulations!<br />You have successfully disconnected the user account.";
									//Cr&eacute;er le Data Set Correspondant
									//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "userConnect"		:	$toDo					= 	$my_users->switch_user_status($uId, "1");
									$user_display_cfrm_msg	= 	"Congratulations<br />You have successfully connected the user account.";
									//Cr&eacute;er le Data Set Correspondant
									//$annuaire->create_xml_directorys("../xml/province_directory.xml");
		break;
		case "userDeactivate"	: 	$toDo					= 	$my_users->switch_user_activate($uId, "0");
									$user_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_HIDE'];
									//Cr&eacute;er le Data Set Correspondant
									//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "userActivate"		:	$toDo					= 	$my_users->switch_user_activate($uId, "1");
									$user_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_SHOW'];
									//Cr&eacute;er le Data Set Correspondant
									//$annuaire->create_xml_directorys("../xml/province_directory.xml");
		break;
		case "update" 			: 	$tab_userUpd 			= 	$my_users->get_user($_REQUEST[$my_users->URI_userVar]); 
									$tab_userDetailUpd 		= 	$my_users->get_user_detail($_REQUEST[$my_users->URI_userVar]);
									//Ces tableaux seront utilises pour remplir les champs du formulaire de modification
									$user_displayUpd 		= 	true;
									//Cr&eacute;er le Data Set Correspondant
									//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "catDelete" 		: 	$toDo					= 	$my_users->delete_user_cat($_REQUEST[$my_users->URI_userTypeVar]);
							   		$rub_display_cfrm_msg	= 	$mod_lang_output['CALLOUT_CAT_DELETE_SUCCESS'];
							  
		break;
		case "catUpdate" 		: 	$tab_userCatUpd 		= 	$my_users->get_user_cat($_REQUEST[$my_users->URI_userTypeVar]);
							   		$rub_displayUpd			= 	true;
		break;
		case "catPublish" 		: 	$toDo 					= $my_users->set_usercat_state($ucId, 1);
									$rub_display_cfrm_msg	= "Cat&eacute;gorie rendue publique.<br />Tous les utilisateurs appartenant &agrave; cette cat&eacute;gorie veront dor&eacute;navant leurs comptes activ&eacute;s!";
		break;
		case "catPrivate" 		: 	$toDo					= $news->set_usercat_state($ecId, 0);
									$rub_display_cfrm_msg	= "Cat&eacute;gorie rendue priv&eacute;.<br />Tous les utilisateurs appartenant &agrave; cette cat&eacute;gorie veront d&eacute;sormais leurs comptes d&eacute;sactiv&eacute;s!";
		break;
	}
?>